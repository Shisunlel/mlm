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
                <li class="bc-active">Third Step</li>
                <li>Fourth Step</li>
                <li>Fifth Step</li>
            </ol>
        </div>
    </div>

    <div class="row my-5">
        <div class="table-responsive">
            <table class="table">
                <form id="member_form" action="{{ route('admin.members.createStep4') }}" method="POST">
                    @csrf
                    <tr>
                        <th>លេខសម្គាល់អ្នកណែនាំ*</th>
                        <td class="d-flex">
                            <x-forms.input name="left" value="{{ $member_info->left ?? '' }}"></x-forms.input>
                            <x-forms.input name="right" value="{{ $member_info->right ?? '' }}"></x-forms.input>
                            <button>បញ្ជាក់</button>
                        </td>
                    </tr>
                    <tr>
                        <th>ឈ្មោះ*</th>
                        <td>
                            <div class="row">
                                <div class="col-12 d-flex">
                                    <span>អក្សរឡាតាំង</span>
                                    <div>
                                        <label for="last_name">នាមត្រកូល</label>
                                        <x-forms.input name="last_name" value="{{ $member_info->last_name ?? '' }}"></x-forms.input>
                                    </div>
                                    <div>
                                        <label for="first_name">នាមខ្លួន</label>
                                        <x-forms.input name="first_name" value="{{ $member_info->first_name ?? '' }}"></x-forms.input>
                                    </div>
                                </div>
                                <div class="col-12 d-flex">
                                    <span>ភាសាខ្មែរ</span>
                                    <div>
                                        <label for="last_name">នាមត្រកូល</label>
                                        <x-forms.input name="last_name_kh" value="{{ $member_info->last_name_kh ?? '' }}"></x-forms.input>
                                    </div>
                                    <div>
                                        <label for="first_name">នាមខ្លួន</label>
                                        <x-forms.input name="first_name_kh" value="{{ $member_info->first_name_kh ?? '' }}"></x-forms.input>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>ភេទ*</th>
                        <td class="d-flex">
                            <label for="">ប្រុស</label><input type="radio" class="form-control" name="gender" value="M" @php if(!empty($member_info->gender)) { if($member_info->gender == 'M') echo 'checked'; } @endphp>
                            <label for="">ស្រី</label><input type="radio" class="form-control" name="gender" value="F" @php if(!empty($member_info->gender)) { if($member_info->gender == 'F') echo 'checked'; } @endphp>
                        </td>
                    </tr>
                    <tr>
                        <th>ថ្ងៃខែឆ្នាំកំណើត*</th>
                        <td class="d-flex">
                            <x-forms.input type="date" name="dob" value="{{ $member_info->dob ?? '' }}"></x-forms.input>
                        </td>
                    </tr>
                    <tr>
                        <th>លេខអត្តសញ្ញាណប័ណ្ណ*</th>
                        <td class="d-flex">
                            <x-forms.input name="id_card" value="{{ $member_info->id_card ?? '' }}"></x-forms.input>
                        </td>
                    </tr>
                    <tr>
                        <th>លេខសម្ងាត់*</th>
                        <td class="d-flex">
                            <x-forms.input type="password" name="password"></x-forms.input>
                        </td>
                    </tr>
                    <tr>
                        <th>បញ្ជាក់លេខសម្ងាត់*</th>
                        <td class="d-flex">
                            <x-forms.input type="password" name="password_confirmation"></x-forms.input>
                        </td>
                    </tr>
                    <tr>
                        <th>លេខសម្ងាត់របស់ភ្ញៀវ*</th>
                        <td class="d-flex">
                            <x-forms.input type="password" name="password_member"></x-forms.input>
                        </td>
                    </tr>
                    <tr>
                        <th>ទូរស័ព្ទ*</th>
                        <td class="d-flex">
                            <x-forms.input type="number" name="phone" value="{{ $member_info->phone ?? '' }}"></x-forms.input>
                        </td>
                    </tr>
                    <tr>
                        <th>អាសយដ្ឋាន*</th>
                        <td class="d-flex">
                            <x-forms.input type="select" name="address" value="{{ $member_info->address ?? '' }}"></x-forms.input>
                        </td>
                    </tr>
                    <tr>
                        <th>សារអេឡិចត្រូនិច*</th>
                        <td class="d-flex">
                            <x-forms.input type="email" name="email" value="{{ $member_info->email ?? '' }}"></x-forms.input>
                        </td>
                    </tr>
                </form>

            </table>
        </div>
    </div>
    <div class="row d-flex justify-content-end">
        <div class="col-2">
            <a href="{{ route('admin.members.createStep2') }}" class="btn btn-outline--secondary form-control">ត្រលប់ក្រោយ</a>
        </div>
        <div class="col-2">
            <a href="#" class="btn btn-primary form-control" onclick="document.querySelector('form#member_form').submit()">បន្ទាប់</a>
        </div>
    </div>
@endsection
