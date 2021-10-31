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
@include('admin.partials.register_step')


    <div class="my-5 col-12 text-center">
        <h3>&#10003;  {{__('message.congratulation')}}</h3>
        <h4>{{__('message.registered')}}</h4>
    </div>
    <div class="row">
    <div class="col-12 mb-2">
        <span class="mr-5">{{__('form.name')}}</span>
        <strong>{{ $login_info['fullname'] }}</strong>
    </div>
    <div class="col-12 mb-2">
        <span class="mr-5">{{__('form.id')}}:</span>
        <strong>{{ $login_info['id'] }}</strong>
    </div>
    <div class="col-12 mb-2">
        <span class="mr-5">{{__('form.password')}}:</span>
        <strong>{{ $login_info['password'] }}</strong>
    </div>
</div>
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            <a href="{{ route('admin.dashboard') }}" class="btn btn--primary">{{__('form.home')}}</a>
        </div>
    </div>
@endsection
