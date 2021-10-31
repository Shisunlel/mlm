@extends('admin.layouts.app')

@section('panel')

    <div class="row mb-none-30">
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--deep-purple b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-user-alt"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$widget['total_users']}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Users')</span>
                    </div>

                    @if (auth()->guard('admin')->user()->can('view.users'))
                    <a href="{{route('admin.backend-users.all')}}"
                       class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--primary b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$widget['total_members']}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Members')</span>
                    </div>

                    @if (auth()->guard('admin')->user()->can('view.members'))
                    <a href="{{route('admin.users.all')}}"
                       class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--teal b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-user-check"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$widget['verified_members']}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Verified Members')</span>
                    </div>
                    @if (auth()->guard('admin')->user()->can('view.pages'))
                    <a href="{{route('admin.users.active')}}"
                       class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--red b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-user-plus"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$widget['banned_members']}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Registered Members')</span>
                    </div>
                    @if (auth()->guard('admin')->user()->can('view.pages'))
                    <a href="{{route('admin.users.banned')}}"
                       class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                    @endif
                </div>
            </div>
        </div>

@endsection