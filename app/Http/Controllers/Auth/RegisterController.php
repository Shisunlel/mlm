<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserExtra;
use App\Models\UserLogin;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('regStatus')->except('registrationNotAllowed');

        $this->activeTemplate = activeTemplate();
    }

    public function showRegistrationForm()
    {
        $page_title = 'Sign Up';
        return view($this->activeTemplate . 'user.auth.register', compact('page_title'));
    }

    public function registerStep2()
    {
        session()->put('lang', request()->lang);
        $page_title = 'Sign Up';
        $member_agreement = Frontend::where('data_keys', 'member_agreement.content')->latest()->first();
        $tos = Frontend::where('data_keys', 'terms_conditions.content')->latest()->first();
        $privacy = Frontend::where('data_keys', 'privacy_and_security.content')->latest()->first();
        return view($this->activeTemplate . 'user.auth.registerStep2', compact('page_title', 'member_agreement', 'tos', 'privacy'));
    }

    public function registerStep3(Request $request)
    {
        $plans = Plan::select('id', 'name')->get();
        if ($request->ref && $request->position) {
            $ref_user = User::where('username', $request->ref)->first();
            if ($ref_user == null) {
                $notify[] = ['error', 'Invalid Referral link.'];
                return redirect()->route('home')->withNotify($notify);
            }

            if ($request->position == 'left') {
                $position = 1;
            } elseif ($request->position == 'right') {
                $position = 2;
            } else {
                $notify[] = ['error', 'Invalid referral position'];
                return redirect()->route('home')->withNotify($notify);
            }

            $pos = getPosition($ref_user->id, $position);

            $join_under = User::find($pos['pos_id']);

            if ($pos['position'] == 1) {
                $get_position = 'Left';
            } else {
                $get_position = 'Right';
            }

            $joining = "<span class='help-block2'><strong class='custom-green' >Your are joining under $join_under->username at $get_position  </strong></span>";

            $page_title = "Sign Up";
            return view($this->activeTemplate . 'user.auth.registerStep3', compact('page_title', 'ref_user', 'joining', 'position', 'plans'));

        }

        $ref_user = null;
        $joining = null;
        $page_title = "Sign Up";
        return view($this->activeTemplate . 'user.auth.registerStep3', compact('page_title', 'ref_user', 'plans'));

    }

    public function registerStep4(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = User::where('id', $request->ref_name)->first();
        $request->session()->put('register_info', $request->except('idcard_image'));
        if ($request->hasFile('idcard_image')) {
            try {
                $imageName = uploadImage($request->idcard_image, "assets/images/user/" . auth()->user()->id . "/idcard/temp/", '600x600');
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
            $request->session()->put('register_info.idcard_image', $imageName);
        }
        $register_info = (object) request()->session()->get('register_info');
        $page_title = 'Sign Up';
        return view($this->activeTemplate . 'user.auth.registerStep4', compact('page_title', 'register_info', 'user'));
    }

    public function registerStep5(Request $request)
    {
        $page_title = 'Sign Up';
        $register_info = (object) $request->session()->get('register_info');
        // check createuser --- array to string conversion
        event(new Registered($user = $this->create($register_info)));
        $login_info = [
            'id' => $user->id,
            'password' => $register_info->member_password,
            'fullname' => $user->fullname,
        ];
        $request->session()->forget('register_info');
        return view($this->activeTemplate . 'user.auth.registerStep5', compact('page_title', 'login_info'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        $validate = Validator::make($data, [
            'left_pos' => 'sometimes|integer|nullable|required_without:right_pos',
            'right_pos' => 'sometimes|integer|nullable|required_without:left_pos',
            'ref_name' => 'required|string|max:160',
            'member_plan' => 'required|integer',
            'firstname' => 'sometimes|required|string|max:60',
            'lastname' => 'sometimes|required|string|max:60',
            'firstname_kh' => 'sometimes|required|string|max:60',
            'lastname_kh' => 'sometimes|required|string|max:60',
            'gender' => 'required',
            'idcard' => 'required|integer',
            'idcard_image' => 'sometimes|required|mimes:png,jpg,jpeg|max:1000',
            'dob' => 'required|date',
            'password' => 'required|string|min:6|confirmed|current_password',
            'member_password' => 'required|string|min:6',
        ]);

        return $validate;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $general = GeneralSetting::first();

        if ($general->secure_password) {
            $notify = $this->strongPassCheck($request->member_password);
            if ($notify) {
                return back()->withNotify($notify)->withInput($request->all());
            }
        }

        // $exist = User::where('mobile', $request->country_code . $request->mobile)->first();
        // if ($exist) {
        //     $notify[] = ['error', 'Mobile number already exist'];
        //     return back()->withNotify($notify)->withInput();
        // }

        $userCheck = User::where('id', $request->ref_name)->first();

        if (!$userCheck) {
            $notify[] = ['error', 'Referral not found.'];
            return back()->withNotify($notify);
        }

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
        ?: redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(object $data)
    {
        if (!empty($data->idcard_image)) {
            try {
                rename("assets/images/user/" . auth()->user()->id . "/idcard/temp/{$data->idcard_image}", "assets/images/user/idcard/{$data->idcard_image}");
                rrmdir("assets/images/user/" . auth()->user()->id);
            } catch (\Exception $ex) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }
        //User Create
        $user = new User();
        $user->plan_id = $data->member_plan;
        $user->ref_id = $data->ref_name;
        if (!empty($data->left_pos)) {
            $user->pos_id = $data->left_pos;
            $user->position = 1;
        } else if (!empty($data->right_pos)) {
            $user->pos_id = $data->right_pos;
            $user->position = 2;
        }
        $user->firstname = $data->firstname ?? null;
        $user->lastname = $data->lastname ?? null;
        $user->firstname_kh = $data->firstname_kh ?? null;
        $user->lastname_kh = $data->lastname_kh ?? null;
        $user->password = Hash::make($data->member_password);
        $user->username = strtolower($data->lastname) . strtolower($data->firstname) . time();
        $user->idcard = $data->idcard;
        $user->dob = $data->dob;
        $user->gender = $data->gender;
        $user->mobile = $data->address_phone;
        $user->idcard_image = $data->idcard_image ?? null;
        $user->address = [
            'no' => $data->address_no,
            'street' => $data->address_str,
            'village' => $data->address_vil,
            'commune' => $data->address_com,
            'district' => $data->address_dis,
            'province' => $data->address_pro,
            'zip' => $data->address_zip,
        ];
        $user->inheritors = [
            'name' => $data->inheritors_name,
            'phone' => $data->inheritors_phone,
            'gender' => $data->inheritors_gender,
            'role' => $data->inheritors_role,
        ];
        $user->status = 0;
        $user->created_by = auth()->id;
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

    protected function strongPassCheck($password)
    {
        $password = $password;
        $capital = '/[ABCDEFGHIJKLMNOPQRSTUVWXYZ]/';
        $capital = preg_match($capital, $password);
        $notify = null;
        if (!$capital) {
            $notify[] = ['error', 'Minimum 1 capital word is required'];
        }
        $number = '/[123456790]/';
        $number = preg_match($number, $password);
        if (!$number) {
            $notify[] = ['error', 'Minimum 1 number is required'];
        }
        $special = '/[`!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?~\']/';
        $special = preg_match($special, $password);
        if (!$special) {
            $notify[] = ['error', 'Minimum 1 special character is required'];
        }
        return $notify;
    }

    public function registered(Request $request, $user)
    {
        $user_extras = new UserExtra();
        $user_extras->user_id = $user->id;
        $user_extras->save();
        updateFreeCount($user->id);
        return redirect()->route('user.home');
    }

}
