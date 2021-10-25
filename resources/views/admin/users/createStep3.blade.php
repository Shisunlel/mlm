@extends('admin.layouts.app')
@push('style')
    <style>
        ol>li {
            margin: 0 0 0 1em;
        }

        .bc-active {
            background: teal;
            color: whitesmoke;
        }

        td>input {
            margin: 0 1rem;
        }

    </style>
@endpush
@section('panel')
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-center">
            <ol class="d-flex w-75 justify-content-between">
                <li>First Step</li>
                <li>Second Step</li>
                <li class="bc-active">Third Step</li>
                <li>Fourth Step</li>
                <li>Fifth Step</li>
            </ol>
        </div>
    </div>

    <div class="row my-5">
        <form id="member_form" class="w-100" action="{{ route('admin.members.createStep4') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <div class="col-12">
                    <strong>{{__('form.upline_id')}}*</strong>
                </div>
                <div class="d-flex">
                    <section class="col-5">
                        <x-forms.input name="left" value="{{ $member_info->left ?? '' }}"></x-forms.input>
                    </section>
                    <section class="col-5">
                        <x-forms.input name="right" value="{{ $member_info->right ?? '' }}"></x-forms.input>
                    </section>
                    <section class="col-2">
                        <button type="button">បញ្ជាក់</button>
                    </section>
                </div>
                <div>
                    <select name="member_plan" class="form-select">
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
            <div class="row mb-3">
                <div class="col-12"><strong>{{__('form.en_name')}}*</strong></div>
                <div class="col-6">
                    <label for="last_name">{{__('form.last_name')}}</label>
                    <x-forms.input name="last_name" value="{{ $member_info->last_name ?? '' }}">
                    </x-forms.input>

                </div>
                <div class="col-6">
                    <label for="first_name">{{__('form.first_name')}}</label>
                    <x-forms.input name="first_name" value="{{ $member_info->first_name ?? '' }}">
                    </x-forms.input>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12"><strong>{{__('form.kh_name')}}*</strong></div>
                <div class="col-6">
                    <label for="last_name">{{__('form.last_name')}}</label>
                    <x-forms.input name="last_name_kh" value="{{ $member_info->last_name_kh ?? '' }}">
                    </x-forms.input>

                </div>
                <div class="col-6">
                    <label for="first_name">{{__('form.first_name')}}</label>
                    <x-forms.input name="first_name_kh" value="{{ $member_info->first_name_kh ?? '' }}">
                    </x-forms.input>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <div class="row">
                        <div class="col-12"><strong>{{__('form.gender')}}*</strong></div>
                        <div class="col-6">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="gender" value="M" @php
                                    if (!empty($member_info->gender)) {
                                        if ($member_info->gender == 'M') {
                                            echo 'checked';
                                        }
                                    }
                                @endphp>
                                <label for="gender" class="form-check-label">{{__('form.male')}}</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="gender" value="F" @php
                                    if (!empty($member_info->gender)) {
                                        if ($member_info->gender == 'F') {
                                            echo 'checked';
                                        }
                                    }
                                @endphp>
                                <label for="gender" class="form-check-label">{{__('form.female')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-12">
                            <strong>{{__('form.dob')}}*</strong>
                        </div>
                        <div class="col-12">
                            <x-forms.input type="date" name="dob" value="{{ $member_info->dob ?? '' }}"></x-forms.input>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <div class="row">
                        <div class="col-12">
                            <strong>{{__('form.id_card')}}*</strong>
                        </div>
                        <div class="col-12">
                            <x-forms.input name="id_card" value="{{ $member_info->id_card ?? '' }}"></x-forms.input>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-12">
                            <strong>{{__('form.id_card')}}*</strong>
                        </div>
                        <div class="col-12">
                            <x-forms.input type="file" name="id_card_file"></x-forms.input>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label for="password" class="form-label">{{__('form.password')}}*</label>
                    <x-forms.input type="password" name="password"></x-forms.input>
                </div>
                <div class="col-6">
                    <label for="password_confirmation" class="form-label">{{__('form.confirm_password')}}*</label>
                    <x-forms.input type="password" name="password_confirmation"></x-forms.input>
                </div>
            </div>
            <tr>
                <th>{{__('form.member_password')}}*</th>
                <td class="d-flex">
                    <x-forms.input type="password" name="password_member"></x-forms.input>
                </td>
            </tr>
            <tr>
                <th>{{__('form.phone')}}*</th>
                <td class="d-flex">
                    <x-forms.input type="number" name="phone" value="{{ $member_info->phone ?? '' }}">
                    </x-forms.input>
                </td>
            </tr>
            <tr>
                <th>{{__('form.address')}}*</th>
                <td class="d-flex">
                    <textarea name="address" class="form-control" cols="30"
                        rows="3">{{ $member_info->address ?? '' }}</textarea>
                </td>
            </tr>
            <tr>
                <th>{{__('form.email')}}*</th>
                <td class="d-flex">
                    <x-forms.input type="email" name="email" value="{{ $member_info->email ?? '' }}">
                    </x-forms.input>
                </td>
            </tr>
        </form>
    </div>
    <div class="row d-flex justify-content-end">
        <div class="col-5 col-md-3">
            <a href="{{ route('admin.members.createStep2') }}"
                class="btn btn-outline--secondary form-control">{{__('form.back')}}</a>
        </div>
        <div class="col-5 col-md-3">
            <a href="#" class="btn btn-primary form-control" onclick="$('#member_form').submit()">{{__('form.proceed')}}</a>
        </div>
    </div>
@endsection
@push('script')
    <script>
        function formValidation(e) {
            const last_name = $('input[name="last_name"]').val()
            console.log(e);
            e.preventDefault()
            e.stopPropagation()
            if(last_name.length <= 0){
                return false;
            }
            e.currentTarget.submit()
        }
        $('#member_form').on('submit', formValidation)
    </script>
@endpush
