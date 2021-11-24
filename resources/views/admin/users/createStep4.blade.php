@extends('admin.layouts.app')
@section('panel')
    @include('admin.partials.register_step')
    <div class="row my-5">
        <h5 class="my-2">{{ __('form.member_info') }}</h5>
    </div>

    <div class="row py-4 border-bottom">
        <header class="col-12">{{ __('form.name') }}</header>
        <div class="col-12 col-md-6">
            <span class="mr-2">{{ __('form.en') }}:</span>
            <strong>
                {{ $member_info->lastname . ' ' . $member_info->firstname }}
            </strong>
        </div>
        <div class="col-12 col-md-6">
            <span class="mr-2">{{ __('form.kh') }}:</span>
            <strong>
                {{ $member_info->lastname_kh . ' ' . $member_info->firstname_kh }}
            </strong>
        </div>
    </div>
    <div class="row py-4 border-bottom">
        <div class="col-12 col-md-6">
            <span class="mr-2">{{ __('form.dob') }}:</span>
            <strong>
                {{ $member_info->dob }}
            </strong>
        </div>
        <div class="col-12 col-md-6">
            <span class="mr-2">{{ __('form.gender') }}:</span>
            <strong>
                {{ $member_info->gender }}
            </strong>
        </div>
    </div>
    <div class="row py-4 border-bottom">
        <div class="col-12 col-md-6">
            <span class="mr-2">{{ __('form.id_card') }}:</span>
            <strong>
                {{ $member_info->idcard }}
            </strong>
        </div>
    </div>
    <div class="row py-4 border-bottom">
        <div class="col-12 col-md-6">
            <span class="mr-2">{{ __('form.address') }}:</span>
            <strong>
                {{ $member_info->address_no . ', ' . $member_info->address_str . ' ' . $member_info->address_dis . ',' . $member_info->address_pro }}
            </strong>
        </div>
    </div>
    <div class="row d-flex justify-content-end">
        <div class="col-5 col-md-3">
            <a href="{{ route('admin.members.createStep3') }}"
                class="btn form-control">{{ __('form.back') }}</a>
        </div>
        <div class="col-5 col-md-3">
            <a href="{{ route('admin.members.createStep5') }}"
                class="btn btn--primary form-control">{{ __('form.proceed') }}</a>
        </div>
    </div>
@endsection
