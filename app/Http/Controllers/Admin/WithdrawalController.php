<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BvLog;
use App\Models\GeneralSetting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use App\Models\WithdrawMethod;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function pending()
    {
        $page_title = 'Pending Withdrawals';
        $withdrawals = Withdrawal::where('status', 2)->with(['user', 'method'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal is pending';
        $type = 'pending';
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message', 'type'));
    }
    public function approved()
    {
        $page_title = 'Approved Withdrawals';
        $withdrawals = Withdrawal::where('status', 1)->with(['user', 'method'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal is approved';
        $type = 'approved';
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message', 'type'));
    }

    public function rejected()
    {
        $page_title = 'Rejected Withdrawals';
        $withdrawals = Withdrawal::where('status', 3)->with(['user', 'method'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal is rejected';
        $type = 'rejected';
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message', 'type'));
    }

    public function log()
    {
        $page_title = 'Withdrawals Log';
        $withdrawals = Withdrawal::where('status', '!=', 0)->with(['user'])->latest()->paginate(getPaginate());
        $empty_message = 'No withdrawal history';
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message'));
    }

    public function logViaMethod($method_id, $type = null)
    {
        $method = WithdrawMethod::findOrFail($method_id);
        if ($type == 'approved') {
            $page_title = 'Approved Withdrawal Via ' . $method->name;
            $withdrawals = Withdrawal::where('status', 1)->with(['user', 'method'])->latest()->paginate(getPaginate());
        } elseif ($type == 'rejected') {
            $page_title = 'Rejected Withdrawals Via ' . $method->name;
            $withdrawals = Withdrawal::where('status', 3)->with(['user', 'method'])->latest()->paginate(getPaginate());

        } elseif ($type == 'pending') {
            $page_title = 'Pending Withdrawals Via ' . $method->name;
            $withdrawals = Withdrawal::where('status', 2)->with(['user', 'method'])->latest()->paginate(getPaginate());
        } else {
            $page_title = 'Withdrawals Via ' . $method->name;
            $withdrawals = Withdrawal::where('status', '!=', 0)->with(['user', 'method'])->latest()->paginate(getPaginate());
        }
        $empty_message = 'Withdraw Log Not Found';
        return view('admin.withdraw.withdrawals', compact('page_title', 'withdrawals', 'empty_message', 'method'));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $page_title = '';
        $empty_message = 'No search result found.';

        $withdrawals = Withdrawal::with(['user'])->where('status', '!=', 0)->where(function ($q) use ($search) {
            $q->where('trx', 'like', "%$search%")
                ->orWhereHas('user', function ($user) use ($search) {
                    $user->where('id', 'like', "%$search%");
                });
        });

        $page_title .= 'Withdrawals Log Search';
        $withdrawals = $withdrawals->paginate(getPaginate());
        $page_title .= ' - ' . $search;

        return view('admin.withdraw.withdrawals', compact('page_title', 'empty_message', 'search', 'withdrawals'));
    }

    public function dateSearch(Request $request)
    {
        $search = $request->date;
        if (!$search) {
            return back();
        }
        $date = explode('-', $search);

        if (!(@strtotime($date[0]) || @strtotime($date[1]))) {
            $notify[] = ['error', 'Please provide valid date'];
            return back()->withNotify($notify);
        }

        $start = @$date[0];
        $end = @$date[1];
        if ($start && !$end) {
            $withdrawals = Withdrawal::where('status', '!=', 0)->where(DB::raw('date(created_at)'), Carbon::parse($start));
        }
        if ($end && $start) {
            $withdrawals = Withdrawal::where('status', '!=', 0)->where(DB::raw('date(created_at)'), '>=', Carbon::parse($start))->where(DB::raw('date(created_at)'), '<=', Carbon::parse($end));
        }

        $withdrawals = $withdrawals->with('user')->paginate(getPaginate());
        $page_title = 'Withdraw Log';
        $empty_message = 'No Withdrawals Found';
        $dateSearch = $search;
        return view('admin.withdraw.withdrawals', compact('page_title', 'empty_message', 'dateSearch', 'withdrawals'));

    }

    public function details($id)
    {
        $general = GeneralSetting::first();
        $withdrawal = Withdrawal::where('id', $id)->where('status', '!=', 0)->with(['user', 'method'])->firstOrFail();
        $page_title = $withdrawal->user->username . ' Withdraw Requested ' . getAmount($withdrawal->amount) . ' ' . $general->cur_text;
        $details = ($withdrawal->withdraw_information != null) ? json_encode($withdrawal->withdraw_information) : null;

        $methodImage = getImage(imagePath()['withdraw']['method']['path'] . '/' . $withdrawal->method->image, '800x800');

        return view('admin.withdraw.detail', compact('page_title', 'withdrawal', 'details', 'methodImage'));
    }

    public function withdrawProcess()
    {
        $page_title = 'Member Withdrawals';
        $empty_message = __('frontend.data_not_found');
        $withdrawals = Withdrawal::where('status', 1)->with('user')->latest()->paginate(getPaginate());
        $users = User::where('status', '!=', 0)->get();
        return view('admin.withdraw.index', compact('page_title', 'empty_message', 'withdrawals', 'users'));
    }

    public function storeWithdrawProcess(Request $request)
    {
        $request->validate([
            'user_id' => 'required|numeric',
            'amount' => 'required|gt:0',
            'percent_charge' => 'required|between:0,100',
            'admin_feedback' => 'nullable|max:64000',
        ]);

        $user = User::findOrFail($request->user_id);

        if ($user->total_ref_com < $request->amount) {
            $notify[] = ['error', 'Your do not have Sufficient Balance For Withdraw.'];
            return back()->withNotify($notify);
        }

        $charge = $request->amount * $request->percent_charge / 100;
        $afterCharge = $request->amount - $charge;

        $withdraw = new Withdrawal();
        $withdraw->user_id = $user->id;
        $withdraw->amount = getAmount($request->amount);
        $withdraw->charge = $charge;
        $withdraw->after_charge = $afterCharge;
        $withdraw->trx = getTrx();
        $withdraw->admin_feedback = $request->admin_feedback;
        $withdraw->status = 1;
        $withdraw->save();

        $bvLog = new BvLog();
        $bvLog->user_id = $user->id;
        $bvLog->amount = getAmount($request->amount);
        $bvLog->charge = $charge;
        $bvLog->post_balance = getAmount($user->total_ref_com - $request->amount);
        $bvLog->trx_type = '-';
        $bvLog->trx = $withdraw->trx;
        $bvLog->details = 'Commission withdrawal';
        $bvLog->remark = 'referral_commission';
        $bvLog->save();

        $user->total_ref_com -= $request->amount;
        $user->save();

        $notify[] = ['success', 'Withdraw Request Successfully Send'];
        return redirect()->route('admin.withdraw.process.index')->withNotify($notify);
    }

    public function approve(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $withdraw = Withdrawal::where('id', $request->id)->where('status', 2)->with('user')->firstOrFail();
        $withdraw->status = 1;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();

        $general = GeneralSetting::first();
        notify($withdraw->user, 'WITHDRAW_APPROVE', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => getAmount($withdraw->final_amount),
            'amount' => getAmount($withdraw->amount),
            'charge' => getAmount($withdraw->charge),
            'currency' => $general->cur_text,
            'rate' => getAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'admin_details' => $request->details,
        ]);

        $notify[] = ['success', 'Withdrawal Marked  as Approved.'];
        return redirect()->route('admin.withdraw.pending')->withNotify($notify);
    }

    public function reject(Request $request)
    {
        $general = GeneralSetting::first();
        $request->validate(['id' => 'required|integer']);
        $withdraw = Withdrawal::where('id', $request->id)->where('status', 2)->firstOrFail();

        $withdraw->status = 3;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();

        $user = User::find($withdraw->user_id);
        $user->balance += getAmount($withdraw->amount);
        $user->save();

        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = $withdraw->amount;
        $transaction->post_balance = getAmount($user->balance);
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->details = getAmount($withdraw->amount) . ' ' . $general->cur_text . ' Refunded from Withdrawal Rejection';
        $transaction->trx = $withdraw->trx;
        $transaction->save();

        notify($user, 'WITHDRAW_REJECT', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => getAmount($withdraw->final_amount),
            'amount' => getAmount($withdraw->amount),
            'charge' => getAmount($withdraw->charge),
            'currency' => $general->cur_text,
            'rate' => getAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'post_balance' => getAmount($user->balance),
            'admin_details' => $request->details,
        ]);

        $notify[] = ['success', 'Withdrawal has been rejected.'];
        return redirect()->route('admin.withdraw.pending')->withNotify($notify);
    }

}
