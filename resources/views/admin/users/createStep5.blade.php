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
                <li>Fourth Step</li>
                <li class="bc-active">Fifth Step</li>
            </ol>
        </div>
    </div>

    <div class="my-5">
        <h4>{{__('message.congratulation')}}</h4>
        <h4>{{__('message.registered')}}</h4>
    </div>
    <div>
        <h4>{{__('form.name')}}: {{ $member_info->first_name . " " . $member_info->last_name }}</h4>
        <span>{{__('form.id')}}: 1234</span>
        <span>{{__('form.password')}}: pass1234</span>
    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline--secondary">{{__('form.home')}}</a>
        </div>
    </div>
@endsection
