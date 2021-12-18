<?php

namespace Modules\Ecommerce\Http\Controllers\Admin;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Ecommerce\Entities\Order;
use Modules\Ecommerce\Entities\Product;
use Modules\Ecommerce\Entities\User;

class AdminController extends Controller
{

    public function dashboard()
    {
        $page_title = 'Dashboard';

        // User Info
        $widget['total_users'] = User::count();
        $widget['verified_users'] = User::where('status', 1)->count();

        // Monthly Deposit Report Graph
        $report['months'] = collect([]);
        $report['deposit_month_amount'] = collect([]);
        $widget['all_orders'] = Order::where('payment_status', '!=', 0)->count();
        $recent_orders = Order::latest()->take(6)->get();

        $depositsMonth = Transaction::whereYear('created_at', '>=', Carbon::now()->subYear())
            ->selectRaw("SUM( CASE WHEN trx_type = '-' THEN amount END) as depositAmount")
            ->selectRaw("DATE_FORMAT(created_at,'%M') as months")
            ->orderBy('created_at')
            ->groupBy(DB::Raw("MONTH(created_at)"))->get();

        $depositsMonth->map(function ($aaa) use ($report) {
            $report['months']->push($aaa->months);
            $report['deposit_month_amount']->push(getAmount($aaa->depositAmount));
        });

        $widget['total_product'] = Product::whereHas('brand')->whereHas('categories')->count();

        $payment['total_deposit_amount'] = Transaction::where('trx_type', '-')->sum('amount');

        $widget['last_seven_days'] = Transaction::where('trx_type', '-')->where('created_at', '>=', Carbon::today()->subDays(7))->sum('amount');

        $widget['last_fifteen_days'] = Transaction::where('trx_type', '-')->where('created_at', '>=', Carbon::today()->subDays(15))->sum('amount');

        $widget['last_thirty_days'] = Transaction::where('trx_type', '-')->where('created_at', '>=', Carbon::today()->subDays(30))->sum('amount');

        $widget['top_selling_products'] = Product::topSales(3);

        $latestUser = User::latest()->take(6)->get();

        return view('ecommerce::admin.dashboard', compact('page_title', 'widget', 'report', 'payment', 'latestUser', 'recent_orders'));
    }

    public function profile()
    {
        $page_title = 'Profile';
        $admin = Auth::guard('admin')->user();
        return view('ecommerce::admin.profile', compact('page_title', 'admin'));
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'email' => 'required|email|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $user = Auth::guard('admin')->user();

        if ($request->hasFile('image')) {
            try {
                $old = $user->image ?: null;
                $user->image = uploadImage($request->image, 'assets/admin/images/profile/', '400X400', $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $notify[] = ['success', 'Your profile has been updated.'];
        return redirect()->route('admin.profile')->withNotify($notify);
    }

    public function password()
    {
        $page_title = 'Password Setting';
        $admin = Auth::guard('admin')->user();
        return view('ecommerce::admin.password', compact('page_title', 'admin'));
    }

    public function passwordUpdate(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        $user = Auth::guard('admin')->user();
        if (!Hash::check($request->old_password, $user->password)) {
            $notify[] = ['error', 'Password Do not match !!'];
            return back()->withErrors(['Invalid old password.']);
        }
        $user->update([
            'password' => bcrypt($request->password),
        ]);
        $notify[] = ['success', 'Password Changed Successfully.'];
        return redirect()->route('ecommerce.admin.password')->withNotify($notify);
    }

}
