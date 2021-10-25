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
                <li>Third Step</li>
                <li class="bc-active">Fourth Step</li>
                <li>Fifth Step</li>
            </ol>
        </div>
    </div>

    <div class="row my-5">
        <h5 class="my-2">{{__('form.member_info')}}</h5>
        <div class="table-responsive">
            <table class="table">
                <form action="">
                    <tr>
                        <th>{{__('form.name')}}*</th>
                        <td>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between">
                                    <span>{{__('form.en')}}</span>
                                    <div>
                                        {{ $member_info->first_name }}
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-between">
                                    <span>{{__('form.kh')}}</span>
                                    <div>
                                        {{ $member_info->first_name_kh }}
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <div>
                            <th>{{__('form.dob')}}*</th>
                            <td class="d-flex">
                                {{ $member_info->dob }}
                            </td>
                        </div>
                        <div>
                            <th>{{__('form.gender')}}*</th>
                            <td class="d-flex">
                                {{ $member_info->gender }}
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div>
                            <th>{{__('form.id_card')}}*</th>
                            <td class="d-flex">
                                {{ $member_info->id_card }}
                            </td>
                        </div>
                        <div>
                            <th>{{__('form.phone')}}*</th>
                            <td class="d-flex">
                                {{ $member_info->phone }}
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <th>{{__('form.address')}}*</th>
                        <td class="d-flex">
                            {{ $member_info->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>{{__('form.email')}}*</th>
                        <td class="d-flex">
                            {{ $member_info->email }}
                        </td>
                    </tr>
                </form>

            </table>
        </div>
    </div>

    <div class="row my-5">
        <h5 class="my-2">{{__('form.upline_info')}}</h5>
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th>{{__('form.name')}}*</th>
                    <td>ជន</td>
                </tr>
                <tr>
                    <th>{{__('form.id')}}*</th>
                    <td>12131</td>
                </tr>
                <tr>
                    <th>{{__('form.address')}}</th>
                    <td>Phnom Pneh</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row d-flex justify-content-end">
        <div class="col-3 col-lg-2">
            <a href="{{ route('admin.members.createStep3') }}" class="btn btn-outline--secondary form-control">{{__('form.back')}}</a>
        </div>
        <div class="col-3 col-lg-2">
            <a href="{{ route('admin.members.createStep5') }}" class="btn btn-primary form-control">{{__('form.proceed')}}</a>
        </div>
    </div>
@endsection
