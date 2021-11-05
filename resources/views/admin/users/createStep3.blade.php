@extends('admin.layouts.app')
@section('panel')
    @include('admin.partials.register_step')
    <div class="row my-5">
        <form id="member_form" class="w-100" action="{{ route('admin.members.createStep4') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-50 border-bottom pb-2">{{ __('form.member_info') }}</h5>

                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4 form-group">
                            <label for="last_name">{{ __('form.last_name') }}</label>
                            <x-forms.input name="lastname" value="{{ $member_info->lastname ?? '' }}">
                            </x-forms.input>

                        </div>
                        <div class="col-12 col-md-6 col-lg-4 form-group">
                            <label for="first_name">{{ __('form.first_name') }}</label>
                            <x-forms.input name="firstname" value="{{ $member_info->firstname ?? '' }}">
                            </x-forms.input>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 form-group">
                            <label for="first_name">{{ __('form.position') }}</label>
                            <select name="member_plan" class="form-control">
                                @foreach ($plans as $plan)
                                    <option value="{{ $plan->id }}" @php
                                        if (!empty($member_info->member_plan)) {
                                            if ($member_info->member_plan == $plan->id) {
                                                echo 'checked';
                                            }
                                        }
                                    @endphp>{{ $plan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4 form-group">
                            <label for="last_name">{{ __('form.last_name') . ' (' . __('form.kh') . ')' }} </label>
                            <x-forms.input name="lastname_kh" value="{{ $member_info->lastname_kh ?? '' }}">
                            </x-forms.input>

                        </div>
                        <div class="col-12 col-md-6 col-lg-4 form-group">
                            <label for="first_name">{{ __('form.first_name') . ' (' . __('form.kh') . ')' }}</label>
                            <x-forms.input name="firstname_kh" value="{{ $member_info->firstname_kh ?? '' }}">
                            </x-forms.input>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 form-group">
                            <label for="gender">{{ __('form.gender') }}*</label>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="gender_m" name="gender" value="M"
                                            @php
                                                if (!empty($member_info->gender)) {
                                                    if ($member_info->gender == 'M') {
                                                        echo 'checked';
                                                    }
                                                }
                                            @endphp>
                                        <label for="gender_m" class="form-check-label">{{ __('form.male') }}</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="gender_f" name="gender" value="F"
                                            @php
                                                if (!empty($member_info->gender)) {
                                                    if ($member_info->gender == 'F') {
                                                        echo 'checked';
                                                    }
                                                }
                                            @endphp>
                                        <label for="gender_f" class="form-check-label">{{ __('form.female') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                            <label for="id_card">{{ __('form.id_card') }}</label>
                            <x-forms.input name="idcard" value="{{ $member_info->id_card ?? '' }}"></x-forms.input>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="idcard_image">{{ __('form.id_card') }}</label>
                            <div class="file-upload-wrapper">
                                <x-forms.input type="file" name="idcard_image" accept=".png, .jpg, .jpeg"></x-forms.input>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                            <label for="dob">{{ __('form.dob') }}</label>
                            <x-forms.input type="date" name="dob" value="{{ $member_info->dob ?? '' }}"></x-forms.input>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="password_member" class="form-label">{{ __('form.member_password') }}*</label>
                            <x-forms.input type="password" name="password_member"></x-forms.input>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-50">
                <div class="card-body">
                    <h5 class="card-title mb-50 border-bottom pb-2">{{ __('form.address') }}</h5>

                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4 form-group">
                            <label for="address_no" class="form-label">{{ __('form.house') }}</label>
                            <x-forms.input name="address_no" value="{{ $member_info->address_no ?? '' }}">
                            </x-forms.input>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 form-group">
                            <label for="address_str" class="form-label">{{ __('form.street') }}</label>
                            <x-forms.input name="address_str" value="{{ $member_info->address_str ?? '' }}">
                            </x-forms.input>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 form-group">
                            <label for="address_vil" class="form-label">{{ __('form.village') }}</label>
                            <x-forms.input name="address_vil" value="{{ $member_info->address_vil ?? '' }}">
                            </x-forms.input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4 form-group">
                            <label for="address_com" class="form-label">{{ __('form.commune') }}</label>
                            <x-forms.input name="address_com" value="{{ $member_info->address_com ?? '' }}">
                            </x-forms.input>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 form-group">
                            <label for="address_dis" class="form-label">{{ __('form.district') }}</label>
                            <x-forms.input name="address_dis" value="{{ $member_info->address_dis ?? '' }}">
                            </x-forms.input>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 form-group">
                            <label for="address_pro" class="form-label">{{ __('form.province') }}</label>
                            <x-forms.input name="address_pro" value="{{ $member_info->address_pro ?? '' }}">
                            </x-forms.input>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-lg-6 form-group">
                            <label for="address_zip" class="form-label">{{ __('form.zip') }}</label>
                            <x-forms.input name="address_zip" value="{{ $member_info->address_zip ?? '' }}">
                            </x-forms.input>
                        </div>
                        <div class="col-12 col-lg-6 form-group">
                            <label for="address_phone" class="form-label">{{ __('form.phone') }}</label>
                            <x-forms.input name="address_phone" value="{{ $member_info->address_phone ?? '' }}">
                            </x-forms.input>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-50">
                <div class="card-body">
                    <h5 class="card-title mb-50 border-bottom pb-2">{{ __('form.inheritors') }}</h5>
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                            <label for="inheritors_name" class="form-label">{{ __('form.name') }}</label>
                            <x-forms.input name="inheritors_name" value="{{ $member_info->inheritors_name ?? '' }}">
                            </x-forms.input>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="inheritors_phone" class="form-label">{{ __('form.phone') }}</label>
                            <x-forms.input name="inheritors_phone" value="{{ $member_info->inheritors_phone ?? '' }}">
                            </x-forms.input>
                        </div>
                        <div class="col-7 col-lg-4 form-group">
                            <label for="inheritors_gender" class="form-label">{{ __('form.gender') }}</label>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="inh_gender_m"
                                            name="inheritors_gender" value="M" @php
                                                if (!empty($member_info->inheritors_gender)) {
                                                    if ($member_info->inheritors_gender == 'M') {
                                                        echo 'checked';
                                                    }
                                                }
                                            @endphp>
                                        <label for="inh_gender_m" class="form-check-label">{{ __('form.male') }}</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="inh_gender_f"
                                            name="inheritors_gender" value="F" @php
                                                if (!empty($member_info->inheritors_gender)) {
                                                    if ($member_info->inheritors_gender == 'F') {
                                                        echo 'checked';
                                                    }
                                                }
                                            @endphp>
                                        <label for="inh_gender_f"
                                            class="form-check-label">{{ __('form.female') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-none d-lg-block col-lg-2"></div>
                        <div class="col-5 col-lg-6 form-group">
                            <label for="inheritors_role" class="form-label">{{ __('form.role') }}</label>
                            <x-forms.input name="inheritors_role" value="{{ $member_info->inheritors_role ?? '' }}">
                            </x-forms.input>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row d-flex justify-content-end">
        <div class="col-5 col-md-3">
            <a href="{{ route('admin.members.createStep2') }}"
                class="btn form-control">{{ __('form.back') }}</a>
        </div>
        <div class="col-5 col-md-3">
            <a href="#" class="btn btn--primary form-control"
                onclick="$('#member_form').submit()">{{ __('form.proceed') }}</a>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(function() {
            function formValidation(e) {
                const last_name = $('input[name="lastname"]').val()
                console.log(e);
                e.preventDefault()
                e.stopPropagation()
                if (last_name.length <= 0) {
                    return false;
                }
                e.currentTarget.submit()
            }

            $('#member_form').on('submit', formValidation)
        });
    </script>
@endpush
