@extends($activeTemplate.'layouts.master')

@section('content')

    @include($activeTemplate.'layouts.breadcrumb')


    <section class="account-section padding-bottom padding-top">
        <div class="container">
            @include($activeTemplate.'user.partials.register_step')
            <div class="row my-5">
                <div class="card vw-100">
                    <div class="card-body">
                        <h5 class="card-title border-bottom pb-2">{{ __('form.member_info') }}</h5>
                        <div class="row py-4 border-bottom">
                            <header class="col-12">{{ __('form.name') }}</header>
                            <div class="col-12 col-md-6">
                                <span class="mr-2">{{ __('form.en') }}:</span>
                                <strong>
                                    {{ $register_info->lastname . ' ' . $register_info->firstname }}
                                </strong>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="mr-2">{{ __('form.kh') }}:</span>
                                <strong>
                                    {{ $register_info->lastname_kh . ' ' . $register_info->firstname_kh }}
                                </strong>
                            </div>
                        </div>
                        <div class="row py-4 border-bottom">
                            <div class="col-12 col-md-6">
                                <span class="mr-2">{{ __('form.dob') }}:</span>
                                <strong>
                                    {{ $register_info->dob }}
                                </strong>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="mr-2">{{ __('form.gender') }}:</span>
                                <strong>
                                    {{ $register_info->gender }}
                                </strong>
                            </div>
                        </div>
                        <div class="row py-4 border-bottom">
                            <div class="col-12 col-md-6">
                                <span class="mr-2">{{ __('form.id_card') }}:</span>
                                <strong>
                                    {{ $register_info->idcard }}
                                </strong>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="mr-2">{{ __('form.document') }}:</span>
                                <div class="file-upload-wrapper">
                                    <form id="member_form" class="w-100" action="{{ route('user.register.step5') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <x-forms.input type="file" name="document" accept=".png, .jpg, .jpeg" required></x-forms.input>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row py-4">
                            <div class="col-12 col-md-6">
                                <span class="mr-2">{{ __('form.address') }}:</span>
                                <strong>
                                    {{ $register_info->address_no . ', ' . $register_info->address_str . ' ' . $register_info->address_dis . ',' . $register_info->address_pro }}
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-50 vw-100">
                    <div class="card-body">
                        <h5 class="card-title border-bottom pb-2">{{ __('form.referrer_info') }}</h5>
                        <div class="row py-4">
                            <div class="col-12 col-md-6">
                                <span class="mr-2">{{ __('form.name') }}:</span>
                                <strong>
                                    {{ $user->fullnamecap }}
                                </strong>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="mr-2">{{ __('form.id') }}:</span>
                                <strong>
                                    {{ $user->id }}
                                </strong>
                            </div>
                        </div>
                        <h5 class="card-title border-bottom pb-2 mt-2">{{ __('form.upline_info') }}</h5>
                        <div class="row py-4">
                            <div class="col-12 col-md-6">
                                <span class="mr-2">{{ __('form.name') }}:</span>
                                <strong>
                                    {{ $upline->fullnamecap }}
                                </strong>
                            </div>
                            <div class="col-12 col-md-6">
                                <span class="mr-2">{{ __('form.id') }}:</span>
                                <strong>
                                    {{ $upline->id }}
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-end">
                <div class="col-5 col-md-3">
                    <a href="{{ route('user.register.step3') }}" class="btn form-control">{{ __('form.back') }}</a>
                </div>
                <div class="col-5 col-md-3">
                    <button type="submit" form="member_form" class="btn btn-primary form-control">{{ __('form.proceed') }}</button>
                </div>
            </div>
        </div>
    </section>


@endsection
