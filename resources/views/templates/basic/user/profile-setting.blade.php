@extends($activeTemplate.'layouts.master')

@section('content')

    @include($activeTemplate.'layouts.breadcrumb')
    <section class="account-section padding-bottom padding-top">
        <div class="container-fluid mb-3 d-flex justify-content-end">
            <a href="{{ route('user.change-password') }}" class="btn btn--success btn--shadow"><i
                    class="fa fa-key"></i>@lang('Change Password')</a>
        </div>
        <div class="container">
            <div class="row mb-none-30">
                <div class="col-xl-3 col-lg-5 col-md-5">
                    <div class="card b-radius--10 overflow-hidden box--shadow1">
                        <div class="card-body p-0">
                            <div class="p-3 bg--white">
                                <img id="output"
                                    src="{{ getImage('assets/images/user/profile/' . auth()->user()->image, '350x300') }}"
                                    alt="@lang('profile-image')" class="b-radius--10 w-100">


                                <ul class="list-group mt-3">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>@lang('Name')</span> {{ auth()->user()->fullname }}
                                    </li>
                                    <li class="list-group-item rounded-0 d-flex justify-content-between">
                                        <span>@lang('ID')</span> {{ auth()->user()->id }}
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

                <div class="col-xl-9 col-lg-7 col-md-7 mb-30">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-50 border-bottom pb-2">{{ auth()->user()->fullname }}
                                @lang('Information')</h5>

                            <form action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label class="form-control-label font-weight-bold">@lang('form.first_name')</label>
                                            <input class="form-control form-control-lg info-input" type="text"
                                                value="{{ auth()->user()->firstname }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label  font-weight-bold">@lang('form.last_name')</label>
                                            <input class="form-control form-control-lg info-input" type="text"
                                                value="{{ auth()->user()->lastname }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label class="form-control-label font-weight-bold">@lang('form.first_name')
                                                @lang('form.kh')</label>
                                            <input class="form-control form-control-lg info-input" type="text"
                                                value="{{ auth()->user()->firstname_kh }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label  font-weight-bold">@lang('form.last_name')
                                                @lang('form.kh')</label>
                                            <input class="form-control form-control-lg info-input" type="text"
                                                value="{{ auth()->user()->lastname_kh }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label class="form-control-label font-weight-bold">@lang('form.dob')</label>
                                            <input class="form-control form-control-lg" type="date" name="dob"
                                                value="{{ auth()->user()->dob }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gender">{{ __('form.gender') }}</label>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="gender_m"
                                                            name="gender" required value="M" @php
                                                                if (!empty(auth()->user()->gender)) {
                                                                    if (auth()->user()->gender == 'M') {
                                                                        echo 'checked';
                                                                    }
                                                                }
                                                            @endphp>
                                                        <label for="gender_m"
                                                            class="form-check-label">{{ __('form.male') }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="gender_f"
                                                            name="gender" value="F" @php
                                                                if (!empty(auth()->user()->gender)) {
                                                                    if (auth()->user()->gender == 'F') {
                                                                        echo 'checked';
                                                                    }
                                                                }
                                                            @endphp>
                                                        <label for="gender_f"
                                                            class="form-check-label">{{ __('form.female') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label  font-weight-bold">@lang('Avatar')</label>
                                            <input class="form-control form-control-lg" type="file" accept="image/*"
                                                onchange="loadFile(event)" name="image">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block btn-lg">@lang('Save
                                                Changes')</button>
                                        </div>
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


@push('script')
    <script>
        'use strict';

        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src)
            }
        };
    </script>
@endpush

@push('css')
    <style>
        .info-input{
            border: none;
            pointer-events: none;
        }
    </style>
@endpush
