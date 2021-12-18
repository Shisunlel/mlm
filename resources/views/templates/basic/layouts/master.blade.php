<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ $general->sitename }} - {{ __(@$page_title) }} </title>
    <link rel="shortcut icon" href="{{ getImage(imagePath()['logoIcon']['path'] . '/favicon.png') }}"
        type="image/x-icon">
    @include('partials.seo')
    
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'frontend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'frontend/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'frontend/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'frontend/css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'frontend/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'frontend/css/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'frontend/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'frontend/css/line-awesome.min.css') }}">

    @stack('style-lib')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'frontend/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'frontend/css/custom.css') }}">
    @stack('css')
    <link rel="stylesheet"href='{{ asset($activeTemplateTrue . "frontend/css/color.php?color=$general->base_color") }}'>
    <link rel="stylesheet" href="{{ asset('assets/flags.css') }}">
    <!-- datepicker css -->
    <link rel="stylesheet" href="{{asset('assets/admin/css/vendor/datepicker.min.css')}}">
    @stack('style')
</head>

<body>

    @stack('facebook')

    <div class="overlay"></div>
    <a href="#0" class="scrollToTop"><i class="flaticon-arrow"></i></a>
    <div class="overlayer" id="overlayer">
        <div class="loader">
            <div class="loader-inner"></div>
        </div>
    </div>

    <header>


        <div class="header-top">
            <div class="container">
                <div class="header-top-area">


                    <div class="header-top-item">
                        <a href="Mailto:{{ @$contact->data_values->email_address }}"><i
                                class="fa fa-envelope"></i>{{ @$contact->data_values->email_address }}</a>
                    </div>
                    <div class="header-top-item">
                        <a href="tel:{{ @$contact->data_values->contact_number }}"><i
                                class="fa fa-mobile-alt"></i>{{ @$contact->data_values->contact_number }}</a>
                    </div>

                    <div class="ml-auto d-none d-sm-block">
                        <div class="dropdown">
                            <a class="btn btn-light p-2 dropdown-toggle" id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="flag flag-{{session('lang')}}"> </span> {{session('lang') == 'kh' ? 'Khmer' : 'English'}}</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown09">
                                <a class="dropdown-item" href="{{url('/change/en')}}"><span class="flag flag-en"> </span> English</a>
                                <a class="dropdown-item" href="{{url('/change/kh')}}"><span class="flag flag-kh"> </span>  Khmer</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="header-bottom">
            <div class="container">
                <div class="header-area">
                    <div class="logo">
                        <a href="{{ url('/') }}"><img
                                src="{{ getImage(imagePath()['logoIcon']['path'] . '/logo.png') }}" alt="logo"></a>
                    </div>
                    <ul class="menu">
                        <li><a href="{{ url('/') }}">@lang('Home')</a></li>
                        <li><a href="{{ route('user.office') }}">@lang('My Office')</a></li>
                        <li><a href="{{ route('ecommerce.home') }}">@lang('My Mall')</a></li>
                        @foreach ($pages as $k => $data)
                            <li><a href="{{ route('pages', [$data->slug]) }}">{{ trans($data->name) }}</a></li>
                        @endforeach
                        @auth
                            <li><a
                                    href="javascript:void(0)">{{ auth()->user()->Fullname . ' (' . auth()->user()->id . ')' }}</a>
                                <ul class="submenu">
                                    <li><a href="{{ route('user.profile-setting') }}">@lang('frontend.profile')</a></li>
                                    <li><a href="{{ route('user.register') }}">@lang('Sign Up')</a></li>
                                    <li><a href="{{ route('user.logout') }}">@lang('Logout')</a></li>
                                </ul>
                            </li>
                        @else
                            <li>
                                <a href="javascript:void(0)">@lang('Account')</a>
                                <ul class="submenu">
                                    <li><a href="{{ route('user.login') }}">@lang('Sign In')</a>
                                    </li>
                                    <li><a href="{{ route('user.register') }}">@lang('Sign Up')</a></li>
                                </ul>
                            </li>
                        @endauth
                    </ul>

                    <div class="d-sm-none ml-auto mr-3">
                        <div class="dropdown">
                            <a class="btn btn-light p-2 dropdown-toggle" id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="flag flag-{{session('lang')}}"> </span> {{session('lang') == 'kh' ? 'Khmer' : 'English'}}</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown09">
                                <a class="dropdown-item" href="{{url('/change/en')}}"><span class="flag flag-en"> </span>  English</a>
                                <a class="dropdown-item" href="{{url('/change/kh')}}"><span class="flag flag-kh"> </span>  Khmer</a>
                            </div>
                        </div>
                    </div>

                    <div class="header-bar d-lg-none">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ============Header Section Ends Here============ -->
    @yield('content')
    <!-- ============Footer Section Starts Here============ -->

    <footer>
        <div class="footer-top">
            <div class="container">
                <div class="logo">
                    <a href="{{ url('/') }}"><img
                            src="{{ getImage(imagePath()['logoIcon']['path'] . '/logo.png') }}" alt="logo"></a>
                </div>
                <p>{{ __(@$footer->data_values->website_footer) }}</p>
                <ul class="social-icons">
                    @foreach ($socials as $social)
                        <li><a href="{{ @$social->data_values->url }}" target="_blank"
                                title="{{ @$social->data_values->title }}">@php echo @$social->data_values->social_icon; @endphp</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>{{ __(@$footer->data_values->copyright) }}</p>
        </div>
    </footer>
    <!-- ============Footer Section Ends Here============ -->
    <script src="{{ asset($activeTemplateTrue . 'frontend/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'frontend/js/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'frontend/js/plugins.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="{{ asset($activeTemplateTrue . 'frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'frontend/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'frontend/js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'frontend/js/swiper.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'frontend/js/wow.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'frontend/js/odometer.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'frontend/js/viewport.jquery.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'frontend/js/nice-select.js') }}"></script>
    <!-- ionicicon -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    @stack('script-lib')

    <script src="{{ asset($activeTemplateTrue . 'frontend/js/main.js') }}"></script>

    @stack('js')
    @include('partials.notify')

    <script>
        $(document).on("change", ".langSel", function() {
            window.location.href = "{{ url('/') }}/change/" + $(this).val();
        });
    </script>
    @stack('script')

</body>

</html>
