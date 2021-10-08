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

        .agree_content {
            max-height: 20rem;
            overflow-y: scroll;
            padding: 1rem;
            border: 1px solid grey;
        }

    </style>
@endpush
@section('panel')
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-center">
            <ol class="d-flex w-75 justify-content-between">
                <li>First Step</li>
                <li class="bc-active">Second Step</li>
                <li>Third Step</li>
                <li>Fourth Step</li>
                <li>Fifth Step</li>
            </ol>
        </div>
    </div>
    <div class="check_group">
        <div class="mt-5 d-flex justify-content-end">
            <label for="select_all">យល់ព្រមទាំងអស់<input type="checkbox" class="input-icheck check_all"></label>
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
                    <label for="agreement">សូមចុចជ្រើសរើសប្រអប់ ប្រសិនបើអ្នកយល់ព្រម<input type="checkbox"
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
                    <label for="tos">សូមចុចជ្រើសរើសប្រអប់ ប្រសិនបើអ្នកយល់ព្រម<input type="checkbox"
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
                    <label for="privacy">សូមចុចជ្រើសរើសប្រអប់ ប្រសិនបើអ្នកយល់ព្រម<input type="checkbox"
                            class="input-icheck agree" form="agree_form"></label>
                </div>
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-end">
        <div class="col-2">
            <a href="{{ route('admin.members.create') }}" class="btn btn-outline--secondary form-control">ត្រលប់ក្រោយ</a>
        </div>
        <div class="col-2">
            <form action="{{ route('admin.members.createStep3') }}" id="agree_form">
                <button type="submit" class="btn btn-primary form-control">បន្ទាប់</button>
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
            $('.agree').each(function() {
                console.log($(this).is(':checked'))
                if (!($(this).is(':checked'))) {
                    iziToast.warning({
                        message: 'Please agree to our condition before proceeding',
                        position: 'topRight',
                    })
                    return false
                }
            })
        })
    </script>
@endpush
