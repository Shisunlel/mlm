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
        <h5 class="my-2">ពត៌មានពីអ្នកស្នើសុំ</h5>
        <div class="table-responsive">
            <table class="table">
                <form action="">
                    <tr>
                        <th>ឈ្មោះ*</th>
                        <td>
                            <div class="row">
                                <div class="col-12 d-flex">
                                    <span>អក្សរឡាតាំង</span>
                                    <div>
                                        {{ $member_info->first_name }}
                                    </div>
                                </div>
                                <div class="col-12 d-flex">
                                    <span>ភាសាខ្មែរ</span>
                                    <div>
                                        {{ $member_info->first_name_kh }}
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <div>
                            <th>ថ្ងៃខែឆ្នាំកំណើត*</th>
                            <td class="d-flex">
                                {{ $member_info->dob }}
                            </td>
                        </div>
                        <div>
                            <th>ភេទ*</th>
                            <td class="d-flex">
                                {{ $member_info->gender }}
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div>
                            <th>លេខអត្តសញ្ញាណប័ណ្ណ*</th>
                            <td class="d-flex">
                                {{ $member_info->id_card }}
                            </td>
                        </div>
                        <div>
                            <th>ទូរស័ព្ទ*</th>
                            <td class="d-flex">
                                {{ $member_info->phone }}
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <th>អាសយដ្ឋាន*</th>
                        <td class="d-flex">
                            {{ $member_info->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>សារអេឡិចត្រូនិច*</th>
                        <td class="d-flex">
                            {{ $member_info->email }}
                        </td>
                    </tr>
                </form>

            </table>
        </div>
    </div>

    <div class="row my-5">
        <h5 class="my-2">ពត៌មានអំពីអ្នកណែនាំ</h5>
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <div>
                    <th>ឈ្មោះ*</th>
                    <td>ជន</td>
                </div>
                <div>
                    <th>លេខសម្គាល់*</th>
                    <td>12131</td>
                </div>
                </tr>
                <tr>
                    <th>ឈ្មោះមជ្ឍមណ្ឌល</th>
                    <td>Phnom Pneh</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row d-flex justify-content-end">
        <div class="col-2">
            <a href="{{ route('admin.members.createStep3') }}" class="btn btn-outline--secondary form-control">ត្រលប់ក្រោយ</a>
        </div>
        <div class="col-2">
            <a href="{{ route('admin.members.createStep5') }}" class="btn btn-primary form-control">បន្ទាប់</a>
        </div>
    </div>
@endsection
