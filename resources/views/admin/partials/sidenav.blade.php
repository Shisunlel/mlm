<div class="sidebar {{ sidebarVariation()['selector'] }} {{ sidebarVariation()['sidebar'] }} {{ @sidebarVariation()['overlay'] }} {{ @sidebarVariation()['opacity'] }}"
     data-background="{{getImage('assets/admin/images/sidebar/2.jpg','400x800')}}">


    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="{{route('admin.dashboard')}}" class="sidebar__main-logo"><img
                    src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('image')"></a>
            <a href="{{route('admin.dashboard')}}" class="sidebar__logo-shape"><img
                    src="{{getImage(imagePath()['logoIcon']['path'] .'/favicon.png')}}" alt="@lang('image')"></a>
            <button type="button" class="navbar__expand"></button>
        </div>

        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">
                <li class="sidebar-menu-item {{menuActive('admin.dashboard')}}">
                    <a href="{{route('admin.dashboard')}}" class="nav-link ">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title">@lang('menu.dashboard')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{menuActive('ecommerce.admin.dashboard')}}">
                    <a href="{{route('ecommerce.admin.dashboard')}}" class="nav-link ">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title">@lang('menu.ecom.dashboard')</span>
                    </a>
                </li>

                @if (auth()->guard('admin')->user()->can('view.plans') || auth()->guard('admin')->user()->can('edit.plans') || auth()->guard('admin')->user()->can('destroy.plans'))
                <li class="sidebar-menu-item {{menuActive('admin.plan*')}}">
                    <a href="{{route('admin.plan')}}" class="nav-link ">
                        <i class="menu-icon las la-paper-plane"></i>
                        <span class="menu-title">@lang('menu.plans')</span>
                    </a>
                </li>
                @endif


                @if (auth()->guard('admin')->user()->can('view.members') || auth()->guard('admin')->user()->can('edit.members') || auth()->guard('admin')->user()->can('destroy.members'))
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.users*',3)}}">
                        <i class="menu-icon las la-users"></i>
                        <span class="menu-title">@lang('menu.member')</span>

                        @if($banned_users_count > 0)
                            <span class="menu-badge pill bg--primary ml-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.users*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.users.all')}} ">
                                <a href="{{route('admin.users.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('menu.all_member')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('admin.users.active')}} ">
                                <a href="{{route('admin.users.active')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('menu.active_member')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.users.banned')}} ">
                                <a href="{{route('admin.users.banned')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('menu.new_member')</span>
                                    @if($banned_users_count)
                                        <span class="menu-badge pill bg--primary ml-auto">{{$banned_users_count}}</span>
                                    @endif
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                @endif

                @if (auth()->guard('admin')->user()->can('view.users') || auth()->guard('admin')->user()->can('edit.users') || auth()->guard('admin')->user()->can('destroy.users'))
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.backend-users*',3)}}">
                        <i class="menu-icon las la-users"></i>
                        <span class="menu-title">@lang('menu.user')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.backend-users*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.backend-users.all')}} ">
                                <a href="{{route('admin.backend-users.all')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('menu.all_user')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.backend-users.roles')}} ">
                                <a href="{{route('admin.backend-users.roles')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('menu.roles')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.withdraw*',3)}}">
                        <i class="menu-icon la la-bank"></i>
                        <span class="menu-title">@lang('Withdrawals') </span>
                        @if(0 < $pending_withdraw_count)
                            <span class="menu-badge pill bg--primary ml-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.withdraw*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive('admin.withdraw.process.index')}}">
                                <a href="{{route('admin.withdraw.process.index')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Process Withdraw')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.withdraw.pending')}} ">
                                <a href="{{route('admin.withdraw.pending')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Pending Log')</span>
                                    @if($pending_withdraw_count)
                                        <span class="menu-badge pill bg--primary ml-auto">{{$pending_withdraw_count}}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.withdraw.approved')}} ">
                                <a href="{{route('admin.withdraw.approved')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Approved Log')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.withdraw.rejected')}} ">
                                <a href="{{route('admin.withdraw.rejected')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Rejected Log')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('admin.withdraw.log')}} ">
                                <a href="{{route('admin.withdraw.log')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Withdrawals Log')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar__menu-header">@lang('Ecommerce')</li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive(['ecommerce.admin.product*', 'ecommerce.admin.category.*', 'ecommerce.admin.subcategory.*', 'ecommerce.admin.attributes*', 'ecommerce.admin.brand.*'], 3) }}">
                        <i class="la la-product-hunt menu-icon"></i>
                        <span class="menu-title">@lang('Product')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive(['ecommerce.admin.product*', 'ecommerce.admin.category.*', 'ecommerce.admin.subcategory.*', 'ecommerce.admin.attributes*', 'ecommerce.admin.brand.*'], 2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{ menuActive('ecommerce.admin.category.*') }}">
                                <a class="nav-link" href="{{ route('ecommerce.admin.category.all') }}">
                                    <i class="las la-align-left menu-icon"></i>
                                    <span class="menu-title">@lang('Categories')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('ecommerce.admin.brand.*') }}">
                                <a class="nav-link" href="{{ route('ecommerce.admin.brand.all') }}">
                                    <i class="la la-tags menu-icon"></i>
                                    <span class="menu-title">@lang('Brands')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ menuActive('ecommerce.admin.attributes*') }}">
                                <a class="nav-link" href="{{ route('ecommerce.admin.attributes') }}">
                                    <i class="la la-palette menu-icon"></i>
                                    <span class="menu-title">@lang('Attribute Types')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('ecommerce.admin.products.*') }}">
                                <a class="nav-link" href="{{ route('ecommerce.admin.products.all') }}">
                                    <i class="menu-icon las la-tshirt"></i>
                                    <span class="menu-title">@lang('Products')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('ecommerce.admin.product.review*') }}">
                                <a class="nav-link" href="{{ route('ecommerce.admin.product.reviews') }}">
                                    <i class="menu-icon las la-star"></i>
                                    <span class="menu-title">@lang('Product Reviews')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive(['ecommerce.admin.coupon*', 'ecommerce.admin.offer.*'], 3) }}">
                        <i class="la la-bullhorn menu-icon"></i>
                        <span class="menu-title">@lang('Promotion')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive(['ecommerce.admin.coupon*', 'ecommerce.admin.offer.*'], 2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{ menuActive('ecommerce.admin.coupon*') }}">
                                <a class="nav-link" href="{{ route('ecommerce.admin.coupon.index') }}">
                                    <i class="menu-icon lab la-contao"></i>
                                    <span class="menu-title">@lang('Coupons')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('ecommerce.admin.offer*') }}">
                                <a class="nav-link" href="{{ route('ecommerce.admin.offer.index') }}">
                                    <i class="menu-icon la la-fire-alt"></i>
                                    <span class="menu-title">@lang('Offers')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('ecommerce.admin.order*',3)}}">
                        <i class="las la-money-bill menu-icon"></i>
                        <span class="menu-title">@lang('Orders')</span>
                        @if($pending_orders_count > 0 || $processing_orders_count || $dispatched_orders_count > 0)
                        <span class="menu-badge pill bg--primary ml-auto">
                            <i class="las la-bell"></i>
                        </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('ecommerce.admin.order*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{ menuActive('ecommerce.admin.order.index') }}">
                                <a class="nav-link" href="{{ route('ecommerce.admin.order.index') }}">
                                    <i class="menu-icon las la-list-ol"></i>
                                    <span class="menu-title">@lang('All Orders')</span>

                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('ecommerce.admin.order.to_deliver')}}">
                                <a class="nav-link" href="{{ route('ecommerce.admin.order.to_deliver') }}">
                                    <i class="menu-icon las la-pause-circle"></i>
                                    <span class="menu-title">@lang('Pending Orders')</span>
                                    @if($pending_orders_count > 0)
                                    <span class="badge bg--primary badge-pill ml-2"><i class="fas fa-exclamation"></i></span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('ecommerce.admin.order.on_processing') }}">
                                <a class="nav-link" href="{{ route('ecommerce.admin.order.on_processing') }}">
                                    <i class="menu-icon las la-spinner"></i>
                                    <span class="menu-title">@lang('Processing Orders')</span>
                                    @if($processing_orders_count > 0)
                                    <span class="badge bg--primary badge-pill ml-2"><i class="fas fa-exclamation"></i></span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('ecommerce.admin.order.dispatched') }}">
                                <a class="nav-link" href="{{ route('ecommerce.admin.order.dispatched') }}">
                                    <i class="menu-icon las la-shopping-basket"></i>

                                    <span class="menu-title">@lang('Dispatched Orders')</span>

                                    @if($dispatched_orders_count > 0)
                                    <span class="badge bg--primary badge-pill ml-2"><i class="fas fa-exclamation"></i></span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('ecommerce.admin.order.delivered') }}">
                                <a class="nav-link" href="{{ route('ecommerce.admin.order.delivered') }}">
                                    <i class="menu-icon las la-check-circle"></i>
                                    <span class="menu-title">@lang('Delivered Orders') </span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('ecommerce.admin.order.canceled') }}">
                                <a class="nav-link" href="{{ route('ecommerce.admin.order.canceled') }}">
                                    <i class="menu-icon las la-times-circle"></i>
                                    <span class="menu-title">@lang('Canceled Orders')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('ecommerce.admin.order.cod') }}">
                                <a class="nav-link" href="{{ route('ecommerce.admin.order.cod') }}">
                                    <i class="menu-icon las la-hand-holding-usd"></i>
                                    <span class="menu-title"><abbr data-toggle="tooltip" title="@lang('Cash On Delivery')">{{ @$deposit->gateway->name??trans('COD') }}</abbr> @lang('Orders')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('ecommerce.admin.report*',3)}}">
                        <i class="menu-icon la la-list"></i>
                        <span class="menu-title">@lang('Report') </span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.report*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive(['ecommerce.admin.report.transaction*'])}}">
                                <a href="{{route('ecommerce.admin.report.transaction')}}" class="nav-link">
                                    <i class="menu-icon las la-money-check"></i>
                                    <span class="menu-title">@lang('Transaction Log')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('ecommerce.admin.report.order*') }}">
                                <a class="nav-link" href="{{ route('ecommerce.admin.report.order') }}">
                                    <i class="menu-icon las la-cart-arrow-down"></i>
                                    <span class="menu-title">@lang('Order Log')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                @if (auth()->guard('admin')->user()->can('view.settings') || auth()->guard('admin')->user()->can('view.logo_settings') || auth()->guard('admin')->user()->can('view.language'))
                <li class="sidebar__menu-header">@lang('menu.settings')</li>

                @if (auth()->guard('admin')->user()->can('view.settings') || auth()->guard('admin')->user()->can('edit.settings') || auth()->guard('admin')->user()->can('destroy.settings'))
                <li class="sidebar-menu-item {{menuActive('admin.setting.index')}}">
                    <a href="{{route('admin.setting.index')}}" class="nav-link">
                        <i class="menu-icon las la-life-ring"></i>
                        <span class="menu-title">@lang('menu.general_setting')</span>
                    </a>
                </li>
                @endif

                @if (auth()->guard('admin')->user()->can('view.logo_settings') || auth()->guard('admin')->user()->can('edit.logo_settings') || auth()->guard('admin')->user()->can('destroy.logo_settings'))
                <li class="sidebar-menu-item {{menuActive('admin.setting.logo_icon')}}">
                    <a href="{{route('admin.setting.logo_icon')}}" class="nav-link">
                        <i class="menu-icon las la-images"></i>
                        <span class="menu-title">@lang('menu.logo_setting')</span>
                    </a>
                </li>
                @endif

                <li class="sidebar-menu-item {{menuActive('admin.extensions.index')}}">
                    <a href="{{route('admin.extensions.index')}}" class="nav-link">
                        <i class="menu-icon las la-cogs"></i>
                        <span class="menu-title">@lang('Extensions')</span>
                    </a>
                </li>

                @if (auth()->guard('admin')->user()->can('view.languages') || auth()->guard('admin')->user()->can('edit.languages') || auth()->guard('admin')->user()->can('destroy.languages'))
                <li class="sidebar-menu-item  {{menuActive(['admin.language.manage','admin.language.key'])}}">
                    <a href="{{route('admin.language.manage')}}" class="nav-link"
                       data-default-url="{{ route('admin.language.manage') }}">
                        <i class="menu-icon las la-language"></i>
                        <span class="menu-title">@lang('Language') </span>
                    </a>
                </li>
                @endif

                @endif

                {{-- open later --}}

                @if (auth()->guard('admin')->user()->can('view.pages') || auth()->guard('admin')->user()->can('view.sections'))
                <li class="sidebar__menu-header">@lang('menu.frontend_manager')</li>

                @if (auth()->guard('admin')->user()->can('view.pages') || auth()->guard('admin')->user()->can('edit.pages') || auth()->guard('admin')->user()->can('destroy.pages'))                    
                <li class="sidebar-menu-item {{menuActive('admin.frontend.manage.pages')}}">
                    <a href="{{route('admin.frontend.manage.pages')}}" class="nav-link ">
                        <i class="menu-icon la la-list"></i>
                        <span class="menu-title">@lang('menu.manage_pages')</span>
                    </a>
                </li>
                @endif

                @if (auth()->guard('admin')->user()->can('view.sections') || auth()->guard('admin')->user()->can('edit.sections') || auth()->guard('admin')->user()->can('destroy.sections'))                    
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('admin.frontend.sections*',3)}}">
                        <i class="menu-icon la la-html5"></i>
                        <span class="menu-title">@lang('menu.manage_section')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('admin.frontend.sections*',2)}} ">
                        <ul>
                            @php
                               $lastSegment =  collect(request()->segments())->last();
                            @endphp
                            @foreach(getPageSections(true) as $k => $secs)
                                @if($secs['builder'])
                                    <li class="sidebar-menu-item  @if($lastSegment == $k) active @endif ">
                                        <a href="{{ route('admin.frontend.sections',$k) }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">{{__('menu.'.$secs['name'])}}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </li>
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('ecommerce.admin.frontend.sections*',3)}}">
                        <i class="menu-icon la la-html5"></i>
                        <span class="menu-title">@lang('menu.manage_ecom_section')</span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('ecommerce.admin.frontend.sections*',2)}} ">
                        <ul>
                            @php
                               $lastSegment =  collect(request()->segments())->last();
                            @endphp
                            @foreach(getEcomPageSections(true) as $k => $secs)
                                @if($secs['builder'])
                                    <li class="sidebar-menu-item  @if($lastSegment == $k) active @endif ">
                                        <a href="{{ route('ecommerce.admin.frontend.sections',$k) }}" class="nav-link">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title">{{__('menu.'.$secs['name'])}}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </li>
                @endif
                @endif
            </ul>
            <div class="text-center mb-3 text-uppercase">
                <span class="text--primary">{{systemDetails()['name']}}</span>
                <span class="text--success">@lang('V'){{systemDetails()['version']}} </span>
            </div>
        </div>
    </div>
</div>
<!-- sidebar end -->
