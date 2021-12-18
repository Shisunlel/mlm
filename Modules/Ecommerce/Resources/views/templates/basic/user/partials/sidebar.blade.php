<li>
    <a href="{{ route('ecommerce.user.deposit.history') }}" class="{{ menuActive('ecommerce.user.deposit.history') }}"><i class="las la-money-bill-wave"></i>@lang('Payment Log')</a>
</li>

<li>
    <a href="{{route('ecommerce.user.orders', 'all')}}" class="{{ menuActive('ecommerce.user.orders') }}"><i class="las la-list"></i>@lang('Order Log')</a>
</li>

<li>
    <a href="{{route('ecommerce.user.product.to_review')}}" class="{{ menuActive('ecommerce.user.product.to_review') }}"><i class="la la-star"></i> @lang('Review Products')</a>
</li>

<li>
    <a href="{{ route('user.logout') }}"><i class="la la-sign-out"></i>@lang('Sign Out')</a>
</li>
