@extends($activeTemplate.'layouts.master')

@section('content')

    @include($activeTemplate.'layouts.breadcrumb')
    <section class="account-section padding-bottom padding-top">
        <div class="container-fluid mb-3 d-flex justify-content-end">
            <a href="{{ route('user.profile-setting') }}" class="btn btn--success btn--shadow"><i
                    class="fa fa-user"></i>@lang('Profile Setting')</a>
        </div>
        <div class="container">
            <div class="row mb-none-30">
                <div class="col-xl-4 col-lg-5 col-md-5">
                    <div class="card b-radius--10 overflow-hidden box--shadow1">
                        <div class="card-body p-0">
                            <div class="p-3 bg--white">
                                <img id="output"
                                    src="{{ getImage('assets/images/user/profile/' . auth()->user()->image, '350x300') }}"
                                    alt="@lang('profile-image')" class="b-radius--10 w-100">
                                <ul class="list-group mt-3">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>@lang('form.name')</span> {{ auth()->user()->fullnamecap }}
                                    </li>
                                    <li class="list-group-item rounded-0 d-flex justify-content-between">
                                        <span>@lang('form.id')</span> {{ auth()->user()->id }}
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>@lang('form.position')</span>
                                        {{ auth()->user()->plan->name }}
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>@lang('Joined at')</span>
                                        {{ date('d M, Y h:i A', strtotime(auth()->user()->created_at)) }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7 mb-30">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-50 border-bottom pb-2">@lang('Change Password')</h5>
                            <form action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">@lang('Password')</label>
                                    <div class="col-lg-9">
                                        <input class="form-control form-control-lg" type="password" name="current_password"
                                            required minlength="5">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">@lang('New password')</label>
                                    <div class="col-lg-9">
                                        <input class="form-control form-control-lg" type="password" name="password" required
                                            minlength="5">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">@lang('Confirm
                                        password')</label>
                                    <div class="col-lg-9">
                                        <input class="form-control form-control-lg" type="password" required minlength="5"
                                            name="password_confirmation">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label"></label>
                                    <div class="col-lg-9">
                                        <button type="submit" class="btn btn-primary btn-block btn-lg">@lang('Save
                                            Changes')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
