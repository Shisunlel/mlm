@extends($activeTemplate.'layouts.master')
@push('style')
    <style>
        button{
            height: auto;
        }
    </style>
@endpush
@section('content')
    <div class="padding-top padding-bottom">
        <div class="container">
            <div class="row mb-2">

                <div class="col-md-12">
                        <form action="{{ route('user.general_commission.dateSearch')}}"
                            method="GET" class="form-inline float-sm-right bg--white mr-0 mr-xl-2 mr-lg-0">
                            <div class="input-group has_append">
                                <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - "
                                    data-language="en" class="datepicker-here form-control bg-white text-black"
                                    data-position='bottom right' placeholder="@lang('Min Date - Max date')"
                                    autocomplete="off" readonly value="{{ @$dateSearch }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card b-radius--10 ">
                        <div class="card-body p-0">
                            <div class="table-responsive--sm table-responsive">
                                <table class="table table--light style--two">
                                    <thead>
                                        <tr>
                                            <th scope="col">@lang('frontend.date')</th>
                                            <th scope="col">@lang('frontend.left_pv')</th>
                                            <th scope="col">@lang('frontend.right_pv')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($transactions as $trx)
                                            <tr>
                                                <td data-label="@lang('date')">{{ showDateTime($trx->created_at) }}</td>
                                                <td data-label="@lang('left PV')" class="budget">
                                                    {{ getAmount($trx->leftpv) }} </td>
                                                <td data-label="@lang('right PV')" class="budget py-sm-3">{{ getAmount($trx->rightpv) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-muted text-center" colspan="100%">
                                                    {{ __($empty_message) }}</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table><!-- table end -->
                            </div>
                        </div>
                        <div class="card-footer py-4">
                            {{ $transactions->links($activeTemplate . 'user.partials.paginate') }}
                        </div>
                    </div><!-- card end -->
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
@endpush
@push('script')
    <script>
        'use strict';
        (function($) {
            if (!$('.datepicker-here').val()) {
                $('.datepicker-here').datepicker();
            }
        })(jQuery)
    </script>
@endpush
