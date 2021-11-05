<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\BvLog;
use App\Models\Deposit;
use App\Models\Frontend;
use App\Models\Gateway;
use App\Models\GeneralSetting;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserExtra;
use App\Models\UserLogin;
use App\Models\Withdrawal;
use App\Models\WithdrawMethod;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ManageUsersController extends Controller
{
    public function allUsers()
    {
        $page_title = 'Manage Members';
        $empty_message = 'No user found';
        $users = User::latest()->paginate(getPaginate());
        return view('admin.users.list', compact('page_title', 'empty_message', 'users'));
    }

    public function activeUsers()
    {
        $page_title = 'Manage Active Members';
        $empty_message = 'No active user found';
        $users = User::active()->latest()->paginate(getPaginate());
        return view('admin.users.list', compact('page_title', 'empty_message', 'users'));
    }

    public function bannedUsers()
    {
        $page_title = 'Newly Registered Members';
        $empty_message = 'No new member found';
        $users = User::banned()->latest()->paginate(getPaginate());
        return view('admin.users.list', compact('page_title', 'empty_message', 'users'));
    }

    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $users = User::where(function ($user) use ($search) {
            $user->where('username', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('mobile', 'like', "%$search%")
                ->orWhere('firstname', 'like', "%$search%")
                ->orWhere('lastname', 'like', "%$search%");
        });
        $page_title = '';
        switch ($scope) {
            case 'active':
                $page_title .= 'Active ';
                $users = $users->where('status', 1);
                break;
            case 'banned':
                $page_title .= 'Banned';
                $users = $users->where('status', 0);
                break;
        }
        $users = $users->paginate(getPaginate());
        $page_title .= 'User Search - ' . $search;
        $empty_message = 'No search result found';
        return view('admin.users.list', compact('page_title', 'search', 'scope', 'empty_message', 'users'));
    }

    public function detail($id)
    {
        $page_title = 'User Detail';
        $user = User::where('id', $id)->with('userExtra')->first();
        $ref_id = User::find($user->ref_id);
        $plans = Plan::select('id', 'name')->get();

        $totalBvCut = BvLog::where('user_id', $user->id)->where('trx_type', '-')->sum('amount');
        return view('admin.users.detail', compact('page_title', 'ref_id', 'user', 'totalBvCut', 'plans'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'firstname' => 'required|max:60',
            'lastname' => 'required|max:60',
        ]);
        if ($request->mobile != $user->mobile && User::where('mobile', $request->mobile)->whereId('!=', $user->id)->count() > 0) {
            $notify[] = ['error', 'Phone number already exists.'];
            return back()->withNotify($notify);
        }

        $user->mobile = $request->mobile;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->firstname_kh = $request->firstname_kh;
        $user->lastname_kh = $request->lastname_kh;
        $user->idcard = $request->idcard;
        $user->address = [
            'no' => $request->house,
            'street' => $request->street,
            'village' => $request->village,
            'commune' => $request->commune,
            'district' => $request->district,
            'province' => $request->province,
        ];
        $user->status = $request->status ? 1 : 0;
        $user->save();

        $notify[] = ['success', 'User detail has been updated'];
        return redirect()->back()->withNotify($notify);
    }

    public function addSubBalance(Request $request, $id)
    {
        $request->validate(['amount' => 'required|numeric|gt:0']);

        $user = User::findOrFail($id);
        $amount = getAmount($request->amount);
        $general = GeneralSetting::first(['cur_text', 'cur_sym']);
        $trx = getTrx();

        if ($request->act) {
            $user->balance += $amount;
            $user->save();
            $notify[] = ['success', $general->cur_sym . $amount . ' has been added to ' . $user->username . ' balance'];

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $amount;
            $transaction->post_balance = getAmount($user->balance);
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = 'Added Balance Via Admin';
            $transaction->trx = $trx;
            $transaction->save();

            notify($user, 'BAL_ADD', [
                'trx' => $trx,
                'amount' => $amount,
                'currency' => $general->cur_text,
                'post_balance' => getAmount($user->balance),
            ]);

        } else {
            if ($amount > $user->balance) {
                $notify[] = ['error', $user->username . ' has insufficient balance.'];
                return back()->withNotify($notify);
            }
            $user->balance -= $amount;
            $user->save();

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $amount;
            $transaction->post_balance = getAmount($user->balance);
            $transaction->charge = 0;
            $transaction->trx_type = '-';
            $transaction->details = 'Subtract Balance Via Admin';
            $transaction->trx = $trx;
            $transaction->save();

            notify($user, 'BAL_SUB', [
                'trx' => $trx,
                'amount' => $amount,
                'currency' => $general->cur_text,
                'post_balance' => getAmount($user->balance),
            ]);
            $notify[] = ['success', $general->cur_sym . $amount . ' has been subtracted from ' . $user->username . ' balance'];
        }
        return back()->withNotify($notify);
    }

    public function userLoginHistory($id)
    {
        $user = User::findOrFail($id);
        $page_title = 'User Login History - ' . $user->username;
        $empty_message = 'No users login found.';
        $login_logs = $user->login_logs()->latest()->paginate(getPaginate());
        return view('admin.users.logins', compact('page_title', 'empty_message', 'login_logs'));
    }

    public function userRef($id)
    {

        $empty_message = 'No user found';
        $user = User::findOrFail($id);
        $page_title = 'Referred By ' . $user->username;
        $users = User::where('ref_id', $id)->latest()->paginate(getPaginate());
        return view('admin.users.list', compact('page_title', 'empty_message', 'users'));
    }

    public function showEmailSingleForm($id)
    {
        $user = User::findOrFail($id);
        $page_title = 'Send Email To: ' . $user->username;
        return view('admin.users.email_single', compact('page_title', 'user'));
    }

    public function sendEmailSingle(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:65000',
            'subject' => 'required|string|max:190',
        ]);

        $user = User::findOrFail($id);
        sendGeneralEmail($user->email, $request->subject, $request->message, $user->username);
        $notify[] = ['success', $user->username . ' will receive an email shortly.'];
        return back()->withNotify($notify);
    }

    public function transactions(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($request->search) {
            $search = $request->search;
            $page_title = 'Search User Transactions : ' . $user->username;
            $transactions = $user->transactions()->where('trx', $search)->with('user')->latest()->paginate(getPaginate());
            $empty_message = 'No transactions';
            return view('admin.reports.transactions', compact('page_title', 'search', 'user', 'transactions', 'empty_message'));
        }
        $page_title = 'User Transactions : ' . $user->username;
        $transactions = $user->transactions()->with('user')->latest()->paginate(getPaginate());
        $empty_message = 'No transactions';
        return view('admin.reports.transactions', compact('page_title', 'user', 'transactions', 'empty_message'));
    }

    public function deposits(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $userId = $user->id;
        if ($request->search) {
            $search = $request->search;
            $page_title = 'Search User Deposits : ' . $user->username;
            $deposits = $user->deposits()->where('trx', $search)->latest()->paginate(getPaginate());
            $empty_message = 'No deposits';
            return view('admin.deposit.log', compact('page_title', 'search', 'user', 'deposits', 'empty_message', 'userId'));
        }

        $page_title = 'User Deposit : ' . $user->username;
        $deposits = $user->deposits()->latest()->paginate(getPaginate());
        $empty_message = 'No deposits';
        $scope = 'all';
        return view('admin.deposit.log', compact('page_title', 'user', 'deposits', 'empty_message', 'userId', 'scope'));
    }

    public function depViaMethod($method, $type = null, $userId)
    {
        $method = Gateway::where('alias', $method)->firstOrFail();
        $user = User::findOrFail($userId);
        if ($type == 'approved') {
            $page_title = 'Approved Payment Via ' . $method->name;
            $deposits = Deposit::where('method_code', '>=', 1000)->where('user_id', $user->id)->where('method_code', $method->code)->where('status', 1)->latest()->with(['user', 'gateway'])->paginate(getPaginate());
        } elseif ($type == 'rejected') {
            $page_title = 'Rejected Payment Via ' . $method->name;
            $deposits = Deposit::where('method_code', '>=', 1000)->where('user_id', $user->id)->where('method_code', $method->code)->where('status', 3)->latest()->with(['user', 'gateway'])->paginate(getPaginate());
        } elseif ($type == 'successful') {
            $page_title = 'Successful Payment Via ' . $method->name;
            $deposits = Deposit::where('status', 1)->where('user_id', $user->id)->where('method_code', $method->code)->latest()->with(['user', 'gateway'])->paginate(getPaginate());
        } elseif ($type == 'pending') {
            $page_title = 'Pending Payment Via ' . $method->name;
            $deposits = Deposit::where('method_code', '>=', 1000)->where('user_id', $user->id)->where('method_code', $method->code)->where('status', 2)->latest()->with(['user', 'gateway'])->paginate(getPaginate());
        } else {
            $page_title = 'Payment Via ' . $method->name;
            $deposits = Deposit::where('status', '!=', 0)->where('user_id', $user->id)->where('method_code', $method->code)->latest()->with(['user', 'gateway'])->paginate(getPaginate());
        }
        $page_title = 'Deposit History: ' . $user->username . ' Via ' . $method->name;
        $methodAlias = $method->alias;
        $empty_message = 'Deposit Log';
        return view('admin.deposit.log', compact('page_title', 'empty_message', 'deposits', 'methodAlias', 'userId'));
    }

    public function withdrawals(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($request->search) {
            $search = $request->search;
            $page_title = 'Search User Withdrawals : ' . $user->username;
            $withdrawals = $user->withdrawals()->where('trx', 'like', "%$search%")->latest()->paginate(getPaginate());
            $empty_message = 'No withdrawals';
            return view('admin.withdraw.withdrawals', compact('page_title', 'user', 'search', 'withdrawals', 'empty_message'));
        }
        $page_title = 'User Withdrawals : ' . $user->username;
        $withdrawals = $user->withdrawals()->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawals';
        $userId = $user->id;
        return view('admin.withdraw.withdrawals', compact('page_title', 'user', 'withdrawals', 'empty_message', 'userId'));
    }

    public function withdrawalsViaMethod($method, $type, $userId)
    {
        $method = WithdrawMethod::findOrFail($method);
        $user = User::findOrFail($userId);
        if ($type == 'approved') {
            $page_title = 'Approved Withdrawal of ' . $user->username . ' Via ' . $method->name;
            $withdrawals = Withdrawal::where('status', 1)->where('user_id', $user->id)->with(['user', 'method'])->latest()->paginate(getPaginate());
        } elseif ($type == 'rejected') {
            $page_title = 'Rejected Withdrawals of ' . $user->username . ' Via ' . $method->name;
            $withdrawals = Withdrawal::where('status', 3)->where('user_id', $user->id)->with(['user', 'method'])->latest()->paginate(getPaginate());

        } elseif ($type == 'pending') {
            $page_title = 'Pending Withdrawals of ' . $user->username . ' Via ' . $method->name;
            $withdrawals = Withdrawal::where('status', 2)->where('user_id', $user->id)->with(['user', 'method'])->latest()->paginate(getPaginate());
        } else {
            $page_title = 'Withdrawals of ' . $user->username . ' Via ' . $method->name;
            $withdrawals = Withdrawal::where('status', '!=', 0)->where('user_id', $user->id)->with(['user', 'method'])->latest()->paginate(getPaginate());
        }
        $empty_message = 'Withdraw Log Not Found';
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message', 'method'));
    }

    public function showEmailAllForm()
    {
        $page_title = 'Send Email To All Users';
        return view('admin.users.email_all', compact('page_title'));
    }

    public function sendEmailAll(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:65000',
            'subject' => 'required|string|max:190',
        ]);

        foreach (User::where('status', 1)->cursor() as $user) {
            sendGeneralEmail($user->email, $request->subject, $request->message, $user->username);
        }

        $notify[] = ['success', 'All users will receive an email shortly.'];
        return back()->withNotify($notify);
    }

    public function tree($username)
    {

        $user = User::where('username', $username)->first();

        if ($user) {
            $data['tree'] = showTreePage($user->id);
            $data['page_title'] = "Tree of " . $user->fullname;
            return view('admin.users.tree', $data);
        }

        $notify[] = ['error', 'Tree Not Found!!'];
        return redirect()->route('admin.dashboard')->withNotify($notify);

    }

    public function otherTree(Request $request, $username = null)
    {
        if ($request->username) {
            $user = User::where('username', $request->username)->first();
        } else {
            $user = User::where('username', $username)->first();
        }
        if ($user) {
            $data['tree'] = showTreePage($user->id);
            $data['page_title'] = "Tree of " . $user->fullname;
            return view('admin.users.tree', $data);
        }

        $notify[] = ['error', 'Tree Not Found!!'];
        return redirect()->route('admin.dashboard')->withNotify($notify);

    }

    public function create()
    {
        $page_title = 'Register Member';
        return view('admin.users.create', compact('page_title'));
    }

    public function createStep2()
    {
        session()->put('lang', request()->lang);
        $page_title = 'Register Member Step 2';
        $member_agreement = Frontend::where('data_keys', 'member_agreement.content')->latest()->first();
        $tos = Frontend::where('data_keys', 'terms_conditions.content')->latest()->first();
        $privacy = Frontend::where('data_keys', 'privacy_and_security.content')->latest()->first();
        return view('admin.users.createStep2', compact('page_title', 'member_agreement', 'tos', 'privacy'));
    }

    public function createStep3()
    {
        $member_info = (object) request()->session()->get('member_info');
        $plans = Plan::select('id', 'name')->get();
        $page_title = 'Register Member Step 3';
        return view('admin.users.createStep3', compact('page_title', 'member_info', 'plans'));
    }

    public function createStep4(Request $request)
    {
        $this->validator($request->all())->validate();
        $request->session()->put('member_info', $request->except('idcard_image'));
        if ($request->hasFile('idcard_image')) {
            try {
                $imageName = uploadImage($request->idcard_image, "assets/images/user/" . auth('admin')->user()->id . "/idcard/temp/", '400X400');
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
            $request->session()->put('member_info.idcard_image', $imageName);
        }
        $member_info = (object) request()->session()->get('member_info');
        $page_title = 'Register Member Step 4';
        return view('admin.users.createStep4', compact('page_title', 'member_info'));
    }

    public function createStep5(Request $request)
    {
        $page_title = 'Register Member Step 5';
        $member_info = (object) $request->session()->get('member_info');
        // check createuser --- array to string conversion
        event(new Registered($user = $this->createUser($member_info)));
        $login_info = [
            'id' => $user->id,
            'password' => $member_info->password_member,
            'fullname' => $user->fullname,
        ];
        $request->session()->forget('member_info');
        return view('admin.users.createStep5', compact('page_title', 'login_info'));
    }

    protected function validator(array $data)
    {
        $validate = Validator::make($data, [
            'member_plan' => 'required|integer',
            'firstname' => 'sometimes|required|string|max:60',
            'lastname' => 'sometimes|required|string|max:60',
            'firstname_kh' => 'sometimes|required|string|max:60',
            'lastname_kh' => 'sometimes|required|string|max:60',
            'password_member' => 'required|string|min:4',
            'idcard_image' => 'sometimes|required|file',
        ]);

        return $validate;
    }

    protected function createUser(object $data)
    {
        // move image to original
        if (!empty($data->idcard_image)) {
            try {
                rename("assets/images/user/" . auth('admin')->user()->id . "/idcard/temp/{$data->idcard_image}", "assets/images/user/idcard/{$data->idcard_image}");
                rrmdir("assets/images/user/" . auth('admin')->user()->id);
            } catch (\Exception $ex) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }
        //User Create
        $user = new User();
        $user->plan_id = $data->member_plan;
        $user->firstname = $data->firstname;
        $user->lastname = $data->lastname;
        $user->firstname_kh = $data->firstname_kh;
        $user->lastname_kh = $data->lastname_kh;
        $user->gender = $data->gender;
        $user->dob = $data->dob;
        $user->username = strtolower($data->lastname) . strtolower($data->firstname) . time();
        $user->idcard = $data->idcard;
        $user->password = Hash::make($data->password_member);
        $user->idcard_image = $data->idcard_image ?? null;
        $user->address = [
            'no' => $data->address_no,
            'street' => $data->address_str,
            'village' => $data->address_vil,
            'commune' => $data->address_com,
            'district' => $data->address_dis,
            'province' => $data->address_pro,
            'zip' => $data->address_zip,
            'phone' => $data->address_phone,
        ];
        $user->inheritors = [
            'name' => $data->inheritors_name,
            'phone' => $data->inheritors_phone,
            'gender' => $data->inheritors_gender,
            'role' => $data->inheritors_role,
        ];
        $user->status = 0;
        $user->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New member registered';
        $adminNotification->click_url = route('admin.users.detail', $user->id);
        $adminNotification->save();

        //Login Log Create
        $ip = $_SERVER["REMOTE_ADDR"];
        $exist = UserLogin::where('user_ip', $ip)->first();
        $userLogin = new UserLogin();

        //Check exist or not
        if ($exist) {
            $userLogin->longitude = $exist->longitude;
            $userLogin->latitude = $exist->latitude;
            $userLogin->location = $exist->location;
            $userLogin->country_code = $exist->country_code;
            $userLogin->country = $exist->country;
        } else {
            $info = json_decode(json_encode(getIpInfo()), true);
            $userLogin->longitude = @implode(',', $info['long']);
            $userLogin->latitude = @implode(',', $info['lat']);
            $userLogin->location = @implode(',', $info['city']) . (" - " . @implode(',', $info['area']) . "- ") . @implode(',', $info['country']) . (" - " . @implode(',', $info['code']) . " ");
            $userLogin->country_code = @implode(',', $info['code']);
            $userLogin->country = @implode(',', $info['country']);
        }

        $userAgent = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip = $ip;

        $userLogin->browser = @$userAgent['browser'];
        $userLogin->os = @$userAgent['os_platform'];
        $userLogin->save();

        $user_extras = new UserExtra();
        $user_extras->user_id = $user->id;
        $user_extras->save();
        updateFreeCount($user->id);

        return $user;
    }
}
