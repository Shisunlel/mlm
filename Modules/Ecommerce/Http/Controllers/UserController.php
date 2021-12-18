<?php

namespace Modules\Ecommerce\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;
use Modules\Ecommerce\Entities\Product;
use Modules\Ecommerce\Entities\ProductReview;

class UserController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }
    public function home()
    {
        $page_title = 'Dashboard';
        $user = Auth::user();
        $orders = $user->orders()->whereIn('payment_status', [1, 2])->get();
        return view('ecommerce::' . $this->activeTemplate . 'user.dashboard', compact('page_title', 'orders'));
    }

    public function profile()
    {
        $data['page_title'] = "Profile Setting";
        $data['user'] = Auth::user();
        return view('ecommerce::' . $this->activeTemplate . 'user.profile-setting', $data);
    }

    public function submitProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'address' => "sometimes|required|max:80",
            'state' => 'sometimes|required|max:80',
            'zip' => 'sometimes|required|max:40',
            'city' => 'sometimes|required|max:50',
            'image' => 'mimes:png,jpg,jpeg',
        ], [
            'firstname.required' => 'First Name Field is required',
            'lastname.required' => 'Last Name Field is required',
        ]);

        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;

        $in['address'] = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $request->country,
            'city' => $request->city,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $user->username . '.jpg';
            $location = 'assets/images/user/profile/' . $filename;
            $in['image'] = $filename;

            $path = './assets/images/user/profile/';
            $link = $path . $user->image;
            if (file_exists($link)) {
                @unlink($link);
            }
            $size = '500x500';
            $image = Image::make($image);
            $size = explode('x', strtolower($size));
            $image->resize($size[0], $size[1]);
            $image->save($location);
        }

        $user->fill($in)->save();
        $notify[] = ['success', 'Profile Updated successfully.'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $data['page_title'] = "CHANGE PASSWORD";
        return view('ecommerce::' . $this->activeTemplate . 'user.password', $data);
    }

    public function submitPassword(Request $request)
    {

        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);
        try {
            $user = auth()->user();
            if (Hash::check($request->current_password, $user->password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                $notify[] = ['success', 'Password Changes successfully.'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'Current password not match.'];
                return back()->withNotify($notify);
            }
        } catch (\PDOException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }

    /*
     * Payment History
     */
    public function depositHistory()
    {
        $page_title = 'Payment Log';
        $empty_message = 'No data found.';
        $logs = auth()->user()->deposits()->with(['gateway'])->latest()->paginate(getPaginate());
        return view('ecommerce::' . $this->activeTemplate . 'user.deposit_history', compact('page_title', 'empty_message', 'logs'));
    }

    public function productsReview()
    {
        $perpage = 16;

        $data = auth()->user()->orders()
            ->where('status', 3)
            ->join('order_details', function ($join) {
                $join->on('orders.id', '=', 'order_details.order_id');
            })
            ->distinct('product_id')
            ->get(['order_number', 'product_id'])
            ->pluck('product_id');

        $products = Product::whereIn('id', $data)->with('userReview')->get();

        $page_title = 'Review Products';
        $empty_message = 'You didn\'t receive any of our product yet';

        return view('ecommerce::' . activeTemplate() . 'user.orders.products_for_review', compact('page_title', 'empty_message', 'products'));
    }

    public function addReview(Request $request)
    {
        $this->validate($request, [
            'pid' => 'required|string',
            'review' => 'required|string',
            'rating' => 'required|numeric',
        ]);

        $product_id = $request->pid;
        $check_user = ProductReview::where('user_id', auth()->user()->id)->where('product_id', $product_id);
        if ($check_user->count() == 0) {
            $add_review = ProductReview::create([
                'user_id' => auth()->user()->id,
                'product_id' => $product_id,
                'review' => $request->review,
                'rating' => $request->rating,
            ]);
            if ($add_review) {
                $notify[] = ['success', 'Review Added'];
            } else {
                $notify[] = ['error', 'ERROR: Something went wrong!!'];
            }
        } else {
            $notify[] = ['error', 'You have already reviewd for this product'];
        }
        return redirect()->back()->withNotify($notify);
    }

}
