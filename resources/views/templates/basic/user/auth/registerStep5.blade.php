@extends($activeTemplate.'layouts.master')

@section('content')

    @include($activeTemplate.'layouts.breadcrumb')


    <section class="account-section padding-bottom padding-top">
        <div class="container">
            @include($activeTemplate.'user.partials.register_step')
            <div class="row my-5">
                <div class="col-12 text-center my-5">
                    <h3 class="my-3">&#10003; {{ __('message.congratulation') }}</h3>
                    <h4>{{ __('message.registered') }}</h4>
                </div>
                <div class="row">
                    <div class="col-12 mb-2">
                        <span class="mr-5">{{ __('form.name') }}</span>
                        <strong>{{ $login_info['fullname'] }}</strong>
                    </div>
                    <div class="col-12 mb-2">
                        <span class="mr-5">{{ __('form.id') }}:</span>
                        <strong>{{ $login_info['id'] }}</strong>
                    </div>
                    <div class="col-12 mb-2">
                        <span class="mr-5">{{ __('form.password') }}:</span>
                        <strong>{{ $login_info['password'] }}</strong>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <a href="{{ route('home') }}" class="btn btn-primary">{{ __('form.home') }}</a>
                </div>
            </div>
        </div>
    </section>
@endsection
