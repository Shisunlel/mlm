@extends($activeTemplate.'layouts.master')

@section('content')

    @include($activeTemplate.'layouts.breadcrumb')


    <section class="account-section padding-bottom padding-top">
        <div class="container">
            @include($activeTemplate.'user.partials.register_step')
            <div class="row my-5">
                <form id="member_form" class="w-100" action="{{ route('user.register.step4') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-50 border-bottom pb-2">{{ __('form.member_info') }}</h5>
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-4 form-group">
                                    <label for="left_pos">@lang('form.upline_id') @lang('form.left')</label>
                                    <x-forms.input name="left_pos" id="left_pos" class="num_input" tabindex="-1"
                                        value="{{ old('left_pos') ?? ($register_info->left_pos ?? '') }}"></x-forms.input>
                                    <div id="left_msg"></div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 form-group">
                                    <label for="right_pos">@lang('form.upline_id') @lang('form.right')</label>
                                    <x-forms.input name="right_pos" id="right_pos" class="num_input" tabindex="-1"
                                        value="{{ old('right_pos') ?? ($register_info->right_pos ?? '') }}">
                                    </x-forms.input>
                                    <div id="right_msg"></div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 form-group">
                                    <label for="direct_sponsor">@lang('form.direct_sponsor')<span
                                        class="text-danger">*</span></label>
                                    <x-forms.input name="ref_name" id="ref_name" class="num_input"
                                        value="{{ old('ref_name') ?? ($register_info->ref_name ?? '') }}" required>
                                    </x-forms.input>
                                    <div id="ref"></div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 form-group">
                                    <label for="last_name">{{ __('form.last_name') }}<span
                                            class="text-danger">*</span></label>
                                    <x-forms.input name="lastname" class="name"
                                        value="{{ old('lastname') ?? ($register_info->lastname ?? '') }}" required>
                                    </x-forms.input>
                                    <p class="name_check text-danger my-1 d-none">@lang('message.english_text')</p>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 form-group">
                                    <label for="first_name">{{ __('form.first_name') }}<span
                                            class="text-danger">*</span></label>
                                    <x-forms.input name="firstname" class="name"
                                        value="{{ old('firstname') ?? ($register_info->firstname ?? '') }}" required>
                                    </x-forms.input>
                                    <p class="name_check text-danger my-1 d-none">@lang('message.english_text')</p>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 form-group">
                                    <label for="first_name">{{ __('form.position') }}</label>
                                    <select name="member_plan" class="w-100 nice-select">
                                        @foreach ($plans as $plan)
                                            <option value="{{ $plan->id }}" @php
                                                if (!empty($register_info->member_plan)) {
                                                    if ($register_info->member_plan == $plan->id) {
                                                        echo 'checked';
                                                    }
                                                }
                                            @endphp>{{ $plan->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-4 form-group">
                                    <label for="last_name">{{ __('form.last_name') . ' (' . __('form.kh') . ')' }}<span
                                            class="text-danger">*</span>
                                    </label>
                                    <x-forms.input name="lastname_kh" class="name_kh"
                                        value="{{ old('lastname_kh') ?? ($register_info->lastname_kh ?? '') }}" required>
                                    </x-forms.input>
                                    <p class="namekh_check text-danger my-1 d-none">@lang('message.khmer_text')</p>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 form-group">
                                    <label for="first_name">{{ __('form.first_name') . ' (' . __('form.kh') . ')' }}<span
                                            class="text-danger">*</span></label>
                                    <x-forms.input name="firstname_kh" class="name_kh"
                                        value="{{ old('firstname_kh') ?? ($register_info->firstname_kh ?? '') }}"
                                        required>
                                    </x-forms.input>
                                    <p class="namekh_check text-danger my-1 d-none">@lang('message.khmer_text')</p>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 form-group">
                                    <label for="gender">{{ __('form.gender') }}</label>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="gender_m" name="gender"
                                                    required value="M" @php
                                                        if (!empty($register_info->gender)) {
                                                            if ($register_info->gender == 'M') {
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
                                                <input type="radio" class="form-check-input" id="gender_f" name="gender"
                                                    value="F" @php
                                                        if (!empty($register_info->gender)) {
                                                            if ($register_info->gender == 'F') {
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
                                
                                <div class="col-12 col-md-6 form-group">
                                    <label for="dob">{{ __('form.dob') }}</label>
                                    <x-forms.input type="date" name="dob"
                                        value="{{ old('dob') ?? ($register_info->dob ?? '') }}">
                                    </x-forms.input>
                                </div>
                                <div class="col-12 col-lg-6 form-group">
                                    <label for="id_card">{{ __('form.id_card') }}<span
                                            class="text-danger">*</span></label>
                                    <x-forms.input name="idcard" type="text" class="num_input"
                                        value="{{ old('idcard') ?? ($register_info->idcard ?? '') }}" required>
                                    </x-forms.input>
                                </div>
                                <div class="col-12 col-md-6 form-group">
                                    <label for="idcard_image">{{ __('form.id_card_front') }}<span
                                        class="text-danger">*</span></label>
                                    <div class="file-upload-wrapper">
                                        <x-forms.input type="file" name="idcard_image" accept=".png, .jpg, .jpeg">
                                        </x-forms.input>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 form-group">
                                    <label for="idcard_image_back">{{ __('form.id_card_back') }}<span
                                        class="text-danger">*</span></label>
                                    <div class="file-upload-wrapper">
                                        <x-forms.input type="file" name="idcard_image_back" accept=".png, .jpg, .jpeg">
                                        </x-forms.input>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-4 form-group">
                                    <label for="password" class="form-label">{{ __('form.password') }} <span
                                            class="text-danger">*</span></label>
                                    <x-forms.input type="password" name="password" id="user_password" required>
                                    </x-forms.input>
                                </div>
                                <div class="col-12 col-md-4 form-group">
                                    <label for="password_confirmation"
                                        class="form-label">{{ __('form.confirm_password') }}<span
                                            class="text-danger">*</span></label>
                                    <x-forms.input type="password" name="password_confirmation" required></x-forms.input>
                                </div>
                                <div class="col-12 col-md-4 form-group">
                                    <label for="password_member"
                                        class="form-label">{{ __('form.member_password') }}<span
                                            class="text-danger">*</span></label>
                                    <x-forms.input type="password" name="member_password" required></x-forms.input>
                                    @if ($general->secure_password)
                                        <p class="text-danger my-1 length">@lang('passwords.min')</p>
                                        <p class="text-danger my-1 capital">@lang('passwords.capital')
                                        </p>
                                        <p class="text-danger my-1 number">@lang('passwords.number')</p>
                                        <p class="text-danger my-1 special">@lang('passwords.special')</p>
                                    @endif
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
                                    <x-forms.input name="address_no"
                                        value="{{ old('address_no') ?? ($register_info->address_no ?? '') }}">
                                    </x-forms.input>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 form-group">
                                    <label for="address_str" class="form-label">{{ __('form.street') }}</label>
                                    <x-forms.input name="address_str"
                                        value="{{ old('address_str') ?? ($register_info->address_str ?? '') }}">
                                    </x-forms.input>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 form-group">
                                    <label for="address_vil" class="form-label">{{ __('form.village') }}</label>
                                    <x-forms.input name="address_vil"
                                        value="{{ old('address_vil') ?? ($register_info->address_vil ?? '') }}">
                                    </x-forms.input>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 form-group">
                                    <label for="address_com" class="form-label">{{ __('form.commune') }}</label>
                                    <x-forms.input name="address_com"
                                        value="{{ old('address_com') ?? ($register_info->address_com ?? '') }}">
                                    </x-forms.input>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 form-group">
                                    <label for="address_dis" class="form-label">{{ __('form.district') }}</label>
                                    <x-forms.input name="address_dis"
                                        value="{{ old('address_dis') ?? ($register_info->address_dis ?? '') }}">
                                    </x-forms.input>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 form-group">
                                    <label for="address_pro" class="form-label">{{ __('form.province') }}</label>
                                    <x-forms.input name="address_pro"
                                        value="{{ old('address_pro') ?? ($register_info->address_pro ?? '') }}">
                                    </x-forms.input>
                                </div>
                                <div class="col-12 col-md-6 form-group">
                                    <label for="address_zip" class="form-label">{{ __('form.zip') }}</label>
                                    <x-forms.input name="address_zip"
                                        value="{{ old('address_zip') ?? ($register_info->address_zip ?? '') }}">
                                    </x-forms.input>
                                </div>
                                <div class="col-12 col-md-6 form-group">
                                    <label for="address_phone" class="form-label">{{ __('form.phone') }}</label>
                                    <x-forms.input name="address_phone" class="phone num_input"
                                        value="{{ old('address_phone') ?? ($register_info->address_phone ?? '') }}">
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
                                    <x-forms.input name="inheritors_name"
                                        value="{{ old('inheritors_name') ?? ($register_info->inheritors_name ?? '') }}">
                                    </x-forms.input>
                                </div>
                                <div class="col-12 col-md-6 form-group">
                                    <label for="inheritors_phone" class="form-label">{{ __('form.phone') }}</label>
                                    <x-forms.input name="inheritors_phone" class="phone num_input"
                                        value="{{ old('inheritors_phone') ?? ($register_info->inheritors_phone ?? '') }}">
                                    </x-forms.input>
                                </div>
                                <div class="col-7 col-lg-4 form-group">
                                    <label for="inheritors_gender" class="form-label">{{ __('form.gender') }}</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="inh_gender_m"
                                                    name="inheritors_gender" value="M" @php
                                                        if (!empty($register_info->inheritors_gender)) {
                                                            if ($register_info->inheritors_gender == 'M') {
                                                                echo 'checked';
                                                            }
                                                        }
                                                    @endphp>
                                                <label for="inh_gender_m"
                                                    class="form-check-label">{{ __('form.male') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="inh_gender_f"
                                                    name="inheritors_gender" value="F" @php
                                                        if (!empty($register_info->inheritors_gender)) {
                                                            if ($register_info->inheritors_gender == 'F') {
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
                                    <x-forms.input name="inheritors_role"
                                        value="{{ old('inheritors_role') ?? ($register_info->inheritors_role ?? '') }}">
                                    </x-forms.input>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row d-flex justify-content-end">
                <div class="col-5 col-md-3">
                    <a href="{{ route('user.register.step2') }}" class="btn form-control">{{ __('form.back') }}</a>
                </div>
                <div class="col-5 col-md-3">
                    <a href="javascript:void(0)" class="btn btn-primary form-control" onclick="$('#member_form').submit()">
                        {{ __('form.proceed') }}</a>
                </div>
            </div>
        </div>
    </section>


@endsection
@push('script')
    <script>
        (function($) {
            "use strict";
            $('#member_form').on('keyup', '#left_pos, #right_pos', function() {
                if ($('#left_pos').val() == '' && $('#right_pos').val() == '') {
                    $('#left_pos').prop('readonly', false)
                    $('#right_pos').prop('readonly', false)
                    $('#left_msg').html('')
                    $('#right_msg').html('')
                    return
                }
                const pos = $(this)
                if (pos.prop('id') === 'left_pos') {
                    $('#right_pos').prop('readonly', true)
                    $('#right_pos').val('')
                    if (pos.val() !== '') {
                        updateHand($(this).val(), 1)
                    }
                } else {
                    $('#left_pos').prop('readonly', true)
                    $('#left_pos').val('')
                    if (pos.val() !== '') {
                        updateHand($(this).val(), 2)
                    }
                }
            })

            $('#member_form').on('keyup', '#ref_name', function() {
                var ref_id = $('#ref_name').val();
                var token = "{{ csrf_token() }}";
                $.ajax({
                    type: "POST",
                    url: "{{ route('check.referral') }}",
                    data: {
                        'ref_id': ref_id,
                        '_token': token
                    },
                    success: function(data) {
                        $("#ref").html(data.msg);
                    }
                });
            });

            $(document).on('submit', '#member_form', function(e) {
                return submitUserForm(e)
            })
            $('#member_form').on('change', 'input[type=file]', function(e) {
                if (this.files[0]?.name?.length > 0) {
                    $(this).parents('.form-group').find('.file-upload-wrapper').attr('data-text', this.files[0].name)
                }
            })

            function updateHand(refer, position) {
                var token = "{{ csrf_token() }}";
                $.ajax({
                    type: "POST",
                    url: "{{ route('get.user.position') }}",
                    data: {
                        'referrer': refer,
                        'position': position,
                        '_token': token
                    },
                    success: function(data) {
                        if (position == 1) {
                            $('#right_msg').html('')
                            $("#left_msg").html(data.msg);
                        } else {
                            $('#left_msg').html('')
                            $('#right_msg').html(data.msg);
                        }
                    }
                });
            }

            function submitUserForm(e) {
                let valid = true
                let userDate = ''
                // upline validation
                if ($('#left_pos').val().length > 0 || $('#right_pos').val().length > 0) {
                    if ($('#left_msg .help-block .text-danger').length == 1 || $('#right_msg .help-block .text-danger')
                        .length == 1) {
                        valid = false
                    }
                } else {
                    valid = false
                }

                // direct sponsor validation
                if ($('#ref_name').val().length > 0) {
                    if ($('#ref .help-block .text-danger').length == 1) {
                        $('#ref_name').focus()
                        valid = false
                    }
                } else {
                    $('#ref_name').focus()
                    valid = false
                }

                // valid name
                if ($('.name_check.d-none').length !== 2 || $('.namekh_check.d-none').length !== 2) {
                    valid = false
                }

                // valid idcard
                if ($('input[name=idcard]').val().length < 9) {
                    $('input[name=idcard]').focus()
                    valid = false
                }

                // valid date
                if ($('input[name=dob]').val().length === 0) {
                    $('input[name=dob]').focus()
                    valid = false
                } else {
                    userDate = $('input[name=dob]').val()
                    userDate = userDate.split('-')
                    let date = new Date()
                    if ((date.getFullYear() - userDate[0]) < 18) {
                        $('input[name=dob]').focus()
                        valid = false
                    }
                }

                // valid password
                let pw = $('input[name=member_password]')
                const length = 8

                if(pw.val().length < length){
                    pw.focus()
                    valid = false
                }

                let capital = /[A-Z]/;
                capital = capital.test(pw.val());
                if (!capital) {
                    pw.focus()
                    valid = false
                }

                let number = /[0-9]/
                number = number.test(pw.val())
                if (!number) {
                    pw.focus()
                    valid = false
                }
                
                let special=/[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
                special = special.test(pw.val())
                if(!special){
                    pw.focus()
                    valid = false
                }

                if (!(valid)) {
                    e.preventDefault()
                    return false
                }
                return true
            }

            $('.name').on('input', function() {
                const name = $(this).val()
                const checkName = /^[A-Za-z]+$/
                if (!(checkName.test(name))) {
                    $(this).next().removeClass('d-none')
                    $(this).focus()
                    return
                } else {
                    $(this).next().addClass('d-none')
                }
            })

            $('.name_kh').on('input', function() {
                const name = $(this).val()
                const checkName = /^[\u1780-\u17FF]*$/
                if (!(checkName.test(name))) {
                    $(this).next().removeClass('d-none')
                    $(this).focus()
                    return
                } else {
                    $(this).next().addClass('d-none')
                }
            })

            $('input[name=idcard]').on('input', function() {
                if ($(this).val().length > 9) {
                    $(this).val($(this).val().substring(0, 9))
                }
                numInput($(this))
            })

            $('.phone').on('input', function() {
                if ($(this).val().length > 10) {
                    $(this).val($(this).val().substring(0, 10))
                }
                numInput($(this))
            })

            $('.num_input').on('input', function() {
                numInput($(this))
            })

            function numInput(input) {
                if (isNaN($(input).val())) {
                    $(input).val($(input).val().substring(0, 0))
                }
            }

            @if ($general->secure_password)
                $('input[name=member_password]').on('input', function () {
                var password = $(this).val();
                var capital = /[ABCDEFGHIJKLMNOPQRSTUVWXYZ]/;
                var capital = capital.test(password);
                if (!capital) {
                $('.capital').removeClass('d-none');
                } else {
                $('.capital').addClass('d-none');
                }
                var number = /[123456790]/;
                var number = number.test(password);
                if (!number) {
                $('.number').removeClass('d-none');
                } else {
                $('.number').addClass('d-none');
                }
                const length = 8;
                if($(this).val().length < length){ $('.length').removeClass('d-none') }else{ $('.length').addClass('d-none') } var
                    special=/[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
                    var special = special.test(password);
                    if (!special) {
                    $('.special').removeClass('d-none');
                    } else {
                    $('.special').addClass('d-none');
                    }
            
            
                    });
            @endif

        })(jQuery);
    </script>



@endpush
