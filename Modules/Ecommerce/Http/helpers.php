<?php

use PHPMailer\PHPMailer\PHPMailer;

function currency()
{
    $data['crypto'] = 8;
    $data['fiat'] = 2;
    return $data;
}

function getAvatar($image, $clean = '')
{
    return file_exists($image) && is_file($image) ? asset($image) . $clean : asset(imagePath()['avatar']['image']);
}

function getEcomPageSections($arr = false)
{
    $jsonUrl = module_path('Ecommerce') . '/Resources/views/' . str_replace('.', '/', activeTemplate()) . 'sections.json';
    $sections = json_decode(file_get_contents($jsonUrl));
    if ($arr) {
        $sections = json_decode(file_get_contents($jsonUrl), true);
        ksort($sections);
    }
    return $sections;
}

function getModuleContent($data_keys, $singleQuery = false, $limit = null)
{
    if ($singleQuery) {
        $content = \Modules\Ecommerce\Entities\Frontend::where('data_keys', $data_keys)->latest()->first();
    } else {
        $article = \Modules\Ecommerce\Entities\Frontend::query();
        $article->when($limit != null, function ($q) use ($limit) {
            return $q->limit($limit);
        });
        $content = $article->where('data_keys', $data_keys)->latest()->get();
    }
    return $content;
}

function combinations($arrays, $i = 0)
{
    if (sizeof($arrays) == 1) {
        foreach ($arrays[0] as $arr) {
            $temp_array[] = $arr;
            $final_array[] = $temp_array;
            unset($temp_array);
        }
        return $final_array;
    }
    if (!isset($arrays[$i])) {
        return array();
    }
    if ($i == count($arrays) - 1) {
        return $arrays[$i];
    }
    // get combinations from subsequent arrays
    $tmp = combinations($arrays, $i + 1);
    $result = array();
    // concat each array from tmp with each element from $arrays[$i]
    foreach ($arrays[$i] as $v) {
        foreach ($tmp as $t) {
            $result[] = is_array($t) ?
            array_merge(array($v), $t) :
            array($v, $t);
        }
    }
    return $result;
}

function getStockData($pid, $attr)
{
    $a = \Modules\Ecommerce\Entities\ProductStock::where('product_id', $pid)->where('attributes', $attr)->first();
    if ($a) {
        return $a;
    }

    return false;
}

function calculateDiscount($amount, $type, $base_price)
{
    if ($type == 1) {
        $discount = $amount;
    } else {
        $discount = ($amount * $base_price) / 100;
    }
    return $discount;
}

function display_avg_rating($rvw)
{
    $total_rvw = $rvw->count();
    $total_rvw = ($total_rvw == 0) ? 1 : $total_rvw;
    $total_rating = $rvw->sum('rating');
    $rvw_avg = $total_rating / $total_rvw;

    $prec = round($rvw_avg, 2) - intval($rvw_avg);
    $result = '';
    if ($prec > 0.25) {
        $rvw_avg = intval($rvw_avg) + 0.5;
    }

    if ($prec > 0.75) {
        $rvw_avg = intval($rvw_avg) + 1;
    }

    for ($i = 0; $i < intval($rvw_avg); $i++) {
        $result .= '<i class="la la-star"></i>';
    }

    if ($rvw_avg - intval($rvw_avg) == 0.5) {
        $i++;
        $result .= '<i class="las la-star-half-alt"></i>';
    }

    for ($k = 0; $k < 5 - $i; $k++) {
        $result .= '<i class="lar la-star"></i>';
    }
    return $result;
}

function checkWishList($product_id)
{
    $user_id = auth()->user()->id ?? null;
    $wishlist = session()->get('wishlist') ?? [];

    $wishlist = array_keys($wishlist);

    if (in_array($product_id, $wishlist)) {
        return true;
    } else {
        return false;
    }
}

function checkCompareList($product_id)
{
    $compare = session()->get('compare') ?? [];

    $compare = array_keys($compare);

    if (in_array($product_id, $compare)) {
        return true;
    } else {
        return false;
    }
}

function showAvailableStock($pid, $attr)
{
    $a = \Modules\Ecommerce\Entities\ProductStock::where('product_id', $pid)->where('attributes', $attr)->first();
    if ($a) {
        return $a->quantity;
    }
    return 0;
}

function getProductAttributes($pid, $aid)
{
    $data = \Modules\Ecommerce\Entities\AssignProductAttribute::where('status', 1)->where('product_id', $pid)->where('product_attribute_id', $aid)->with(['product', 'productAttribute'])->get();

    return $data;
}

function cartAttributesShow($attributes)
{
    $varients = '';
    $attr_data = \Modules\Ecommerce\Entities\AssignProductAttribute::with('productAttribute')->get();

    foreach ($attributes as $aid) {
        $varients .= $attr_data->where('id', $aid)->first()->productAttribute->name_for_user . ' : ';
        $varients .= $attr_data->where('id', $aid)->first()->name . '<br>';
    }
    return $varients;
}

function priceAfterAttribute($product, $attributes)
{

    $base_price = $product->base_price;
    if ($product->offer && $product->offer->activeOffer) {
        $discount = calculateDiscount($product->offer->activeOffer->amount, $product->offer->activeOffer->discount_type, $product->base_price);
    } else {
        $discount = 0;
    }

    $attr_data = \Modules\Ecommerce\Entities\AssignProductAttribute::with('productAttribute')->get();
    $varient_Price = 0;
    foreach ($attributes as $aid) {
        $varient_Price = $varient_Price + $attr_data->where('id', $aid)->first()->extra_price;
    }
    $final_price = $base_price - $discount + $varient_Price;

    return $final_price;
}

function insertUserToCart($user_id, $session_id)
{
    $cart = \Modules\Ecommerce\Entities\Cart::where('session_id', $session_id)->get();
    if ($cart) {
        foreach ($cart as $crt) {
            $crt->user_id = $user_id;
            $crt->save();
        }
    }
}

function number_format_short($n)
{
    $n_format = 0;
    $suffix = '';
    if ($n > 0 && $n < 1000) {
        // 1 - 999
        $n_format = floor($n);
    } else if ($n >= 1000 && $n < 1000000) {
        // 1k-999k
        $n_format = floor($n / 1000);
        $suffix = 'K+';
    } else if ($n >= 1000000 && $n < 1000000000) {
        // 1m-999m
        $n_format = floor($n / 1000000);
        $suffix = 'M+';
    } else if ($n >= 1000000000 && $n < 1000000000000) {
        // 1b-999b
        $n_format = floor($n / 1000000000);
        $suffix = 'B+';
    } else if ($n >= 1000000000000) {
        // 1t+
        $n_format = floor($n / 1000000000000);
        $suffix = 'T+';
    }

    return [$n_format, $suffix];
}

function paginate($items, $perPage = 5, $page = null, $options = [])
{
    $page = $page ?: (Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);

    $items = $items instanceof Illuminate\Database\Eloquent\Collection ? $items : Illuminate\Database\Eloquent\CollectionCollection::make($items);
    return new Illuminate\Pagination\LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [

        'path' => Illuminate\Pagination\Paginator::resolveCurrentPath(),
        'pageName' => 'page',

    ]);
}

function productAttributesDetails($attributes)
{
    $variants = '';
    $attr_data = \Modules\Ecommerce\Entities\AssignProductAttribute::with('productAttribute')->get();
    $variants = [];
    $extra_price = 0;
    foreach ($attributes as $key => $aid) {
        $price = $attr_data->where('id', $aid)->first()->extra_price;
        $variants[$key]['name'] = $attr_data->where('id', $aid)->first()->productAttribute->name_for_user;
        $variants[$key]['value'] = $attr_data->where('id', $aid)->first()->name;
        $variants[$key]['price'] = $price;

        $extra_price += $price;
    }
    $details['variants'] = $variants;
    $details['extra_price'] = $extra_price;

    return $details;
}

function array_flatten($array)
{
    if (!is_array($array)) {
        return false;
    }
    $result = array();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $result = array_merge($result, array_flatten($value));
        } else {
            $result[$key] = $value;
        }
    }
    return $result;
}
