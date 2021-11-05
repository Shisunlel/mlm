@extends('admin.layouts.app')
@push('style')
    <style>
        .agree_content {
            max-height: 20rem;
            overflow-y: scroll;
            padding: 1rem;
            border: 1px solid grey;
        }

    </style>
@endpush
@section('panel')
@include('admin.partials.register_step')
    <div class="check_group">
        <div class="mt-5 d-flex justify-content-end">
            <label for="select_all">{{__('form.agree_all')}}<input type="checkbox" class="input-icheck check_all"></label>
        </div>
        <div class="row my-2">
            <div class="col-12 my-2">
                <h6>{{ $member_agreement->data_values->title }}</h6>
                <div class="agree_content mt-3">
                    @php
                        echo $member_agreement->data_values->description;
                    @endphp
                </div>
                <div class="d-flex justify-content-end mt-2">
                    <label for="agreement">{{__('form.agree')}}<input type="checkbox"
                            class="input-icheck agree" form="agree_form"></label>
                </div>
            </div>
            <div class="col-12 my-2">
                <h6>{{ $tos->data_values->title }}</h6>
                <div class="agree_content mt-3">
                    @php
                        echo $tos->data_values->description;
                    @endphp
                </div>
                <div class="d-flex justify-content-end mt-2">
                    <label for="tos">{{__('form.agree')}}<input type="checkbox"
                            class="input-icheck agree" form="agree_form"></label>
                </div>
            </div>
            <div class="col-12 my-2">
                <h6>{{ $privacy->data_values->title }}</h6>
                <div class="agree_content mt-3">
                    @php
                        echo $privacy->data_values->description;
                    @endphp
                </div>
                <div class="d-flex justify-content-end mt-2">
                    <label for="privacy">{{__('form.agree')}}<input type="checkbox"
                            class="input-icheck agree" form="agree_form"></label>
                </div>
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-end">
        <div class="col-5 col-md-3">
            <a href="{{ route('admin.members.create') }}" class="btn form-control">{{__('form.back')}}</a>
        </div>
        <div class="col-5 col-md-3">
            <form action="{{ route('admin.members.createStep3') }}" id="agree_form">
                <button type="submit" class="btn btn--primary form-control">{{__('form.proceed')}}</button>
            </form>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $('input[type="checkbox"].input-icheck, input[type="radio"].input-icheck').iCheck({
            checkboxClass: 'icheckbox_polaris',
            radioClass: 'iradio_polaris',
        });
        $(document).on('ifChecked', '.check_all', function() {
            $(this)
                .closest('.check_group')
                .find('.input-icheck')
                .each(function() {
                    $(this).iCheck('check');
                });
        });
        $(document).on('ifUnchecked', '.check_all', function() {
            $(this)
                .closest('.check_group')
                .find('.input-icheck')
                .each(function() {
                    $(this).iCheck('uncheck');
                });
        });
        $('.check_all').each(function() {
            var length = 0;
            var checked_length = 0;
            $(this)
                .closest('.check_group')
                .find('.input-icheck')
                .each(function() {
                    length += 1;
                    if ($(this).iCheck('update')[0].checked) {
                        checked_length += 1;
                    }
                });
            length = length - 1;
            if (checked_length != 0 && length == checked_length) {
                $(this).iCheck('check');
            }
        });
        $('form#agree_form').on('submit', function() {
            let count = 0
            $('.agree').each(function() {
                if (!($(this).is(':checked'))) {
                    iziToast.warning({
                        message: 'Please agree to our condition before proceeding',
                        position: 'topRight',
                    })
                    return false
                }
                count+=1
            })
            return count == 3 ? true : false
        })
    </script>
@endpush
