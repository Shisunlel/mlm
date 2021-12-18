@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('Date')</th>
                                    <th scope="col">@lang('Trx Number')</th>
                                    <th scope="col">@lang('ID')</th>
                                    <th scope="col">@lang('Amount')</th>
                                    <th scope="col">@lang('Charge')</th>
                                    <th scope="col">@lang('After Charge')</th>
                                    {{-- <th scope="col">@lang('Status')</th> --}}
                                    <th scope="col">@lang('Admin Response')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($withdrawals as $withdraw)
                                    <tr>
                                        <td data-label="@lang('Date')">{{ showDateTime($withdraw->created_at) }}</td>
                                        <td data-label="@lang('Trx Number')" class="font-weight-bold">
                                            {{ strtoupper($withdraw->trx) }}</td>
                                        <td data-label="@lang('ID')"> {{ @$withdraw->user_id }} </td>
                                        <td data-label="@lang('Amount')" class="budget font-weight-bold">
                                            {{ getAmount($withdraw->amount) }} {{ __($general->cur_text) }}</td>
                                        <td data-label="@lang('Charge')" class="budget text-danger">
                                            {{ getAmount($withdraw->charge) }} {{ __($general->cur_text) }}</td>
                                        <td data-label="@lang('After Charge')" class="budget">
                                            {{ getAmount($withdraw->after_charge) }} {{ __($general->cur_text) }}</td>
                                        <td data-label="@lang('Admin Response')">{{ $withdraw->admin_feedback }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($withdrawals) }}
                </div>
            </div><!-- card end -->
        </div>
    </div>


    {{-- ACTIVATE METHOD MODAL --}}
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add Withdrawal')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.withdraw.process.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Select Member')</label>
                            <select name="user_id" id="user" class="w-100 nice-select">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->id }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Amount') <span class="text-danger">*</span></label>
                            <div class="input-group has_append mb-3">
                                <input type="text" class="form-control" name="amount" placeholder="0"
                                    value="{{ old('amount') }}" />
                                <div class="input-group-append">
                                    <div class="input-group-text"> {{ __($general->cur_text) }} </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group my-2">
                            <span class="font-weight-bold" id="current_amount"></span>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Percent Charge') <span
                                    class="text-danger">*</span></label>
                            <div class="input-group-append">
                                <input type="text" class="form-control" placeholder="0" name="percent_charge"
                                value="{{ old('percent_charge') }}">
                                <div class="input-group-text">%</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Remark')</label>
                            <input type="text" class="form-control" name="admin_feedback"
                                value="{{ old('admin_feedback') }}" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary">@lang('Save')</button>
                    </div>
            </div>

            </form>
        </div>
    </div>
    </div>
@endsection



@push('breadcrumb-plugins')
    <a class="btn btn-sm btn--primary box--shadow1 text--small" data-toggle="modal" data-target="#addModal"><i
            class="fa fa-fw fa-plus"></i>@lang('Add
        New')</a>
@endpush


@push('script')
    <script>
        'use strict';
        (function($) {
            $('#user').on('change', function() {
                const user_id = $(this).val()
                $.ajax({
                    url: "{{ route('user.commission') }}",
                    data: {
                        'user_id': user_id,
                    },
                    success: function(data) {
                        $("#current_amount").html("Total Commission: " + data.msg + " {{$general->cur_text}}");
                    }
                });
            })
        })(jQuery)
    </script>
@endpush
