@extends('admin.layouts.app')

@section('panel')
    <div class="row mb-none-30">

        <div class="col-xl-3 col-lg-5 col-md-5 mb-30">

            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body p-0">
                    <div class="p-3 bg--white">
                        <div class="">
                            <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . $user->image, imagePath()['profile']['user']['size']) }}"
                                alt="@lang('profile-image')" class="b-radius--10 w-100">
                        </div>
                        <div class="mt-15">
                            <h4 class="">{{ $user->fullname }}</h4>
                            <span class="text--small">@lang('Joined At
                                ')<strong>{{ showDateTime($user->created_at, 'd M, Y h:i A') }}</strong></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
                <div class="card-body p-0">
                    <div class="p-3 bg--white">
                        <div class="mb-1">
                            <h4 class="">@lang('admin.document')</h4>
                        </div>
                        <div class="form-group">
                            <div class="image-upload">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview" style="background-image: url({{ getImage(imagePath()['profile']['document']['path'] . '/' . $user->document, imagePath()['profile']['document']['size']) }})">
                                            <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input form="update_user" type="file" class="profilePicUpload" name="document" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                        <label for="profilePicUpload1" class="bg--success">@lang('Upload admin.document')</label>
                                        <a href="{{ getImage(imagePath()['profile']['document']['path'] . '/' . $user->document, imagePath()['profile']['document']['size']) }}" target="_blank">
                                            <label for="download" class="bg--primary">@lang('Preview admin.document')</label></a>
                                        <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg'), @lang('png').</b> @lang('Image will be resized into 1000x1000px') </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('admin.user_info')</h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('admin.upline')
                            <span class="font-weight-bold">{{ $user->username }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('admin.direct_sponsor')
                            <span class="font-weight-bold"> {{ $ref_id->fullnamecap ?? 'N/A' }} {{ isset($ref_id->id) ? "($ref_id->id)" : ' ' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('admin.total_own_pv')
                            <span class="font-weight-bold"><a href="{{ route('admin.report.single.bvLog', $user->id) }}">
                                    {{ getAmount($user->balance) }} </a></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('admin.left_member')
                            <span
                                class="font-weight-bold">{{ getChildPV($user->id, 1, 0, 1) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('admin.right_member')
                            <span
                                class="font-weight-bold">{{ getChildPV($user->id, 2, 0, 1) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('admin.status')
                            @switch($user->status)
                                @case(1)
                                    <span class="badge badge-pill bg--success">@lang('Active')</span>
                                @break
                                @case(0)
                                    <span class="badge badge-pill bg--danger">@lang('Inactive')</span>
                                @break
                            @endswitch
                        </li>

                    </ul>
                </div>
            </div>
            <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('User action')</h5>
                    <a data-toggle="modal" href="#addSubModal" class="btn btn--success btn--shadow btn-block btn-lg">
                        @lang('admin.add_sub_pv')
                    </a>
                    <a href="{{ route('admin.users.login.history.single', $user->id) }}"
                        class="btn btn--primary btn--shadow btn-block btn-lg">
                        @lang('Login Logs')
                    </a>
                    <a href="{{ route('admin.users.single.tree', $user->username) }}"
                        class="btn btn--primary btn--shadow btn-block btn-lg">
                        @lang('admin.member_tree')
                    </a>
                    <a href="{{route('admin.users.ref',$user->id)}}"
                       class="btn btn--info btn--shadow btn-block btn-lg">
                        @lang('Member Referrals')
                    </a>
                    <a data-toggle="modal" href="#resetPWModal" class="btn btn--secondary btn--shadow btn-block btn-lg">
                        @lang('admin.reset_pw')
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-9 col-lg-7 col-md-7 mb-30">
            <div class="row mb-none-30">

                <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--orange b-radius--10 box-shadow has--link">
                        <a href="{{ route('admin.report.refCom') }}?userID={{ $user->id }}"
                            class="item--link"></a>
                        <div class="icon">
                            <i class="la la-hand-holding-usd"></i>
                        </div>
                        <div class="details">
                            <div class="numbers">
                                <span class="amount">{{ getAmount($user->total_ref_com) }}</span>
                                <span class="currency-sign">{{ $general->cur_text }}</span>
                            </div>
                            <div class="desciption">
                                <span>@lang('admin.total_referral_commission')</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--success b-radius--10 box-shadow has--link">
                        <a href="#"
                            class="item--link"></a>
                        <div class="icon">
                            <i class="la la-money-bill-wave"></i>
                        </div>
                        <div class="details">
                            <div class="numbers">
                                <span class="amount">0</span>
                                <span class="currency-sign">{{ $general->cur_text }}</span>
                            </div>
                            <div class="desciption">
                                <span>@lang('admin.total_referral_commission_and_withdraw')</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--indigo b-radius--10 box-shadow has--link">
                        <a href="{{ route('admin.report.single.bvLog', $user->id) }}?type=addpv"
                            class="item--link"></a>
                        <div class="icon">
                            <i class="la la-wallet"></i>
                        </div>
                        <div class="details">
                            <div class="numbers">
                                <span class="amount">{{ getAmount($user->balance) }}</span>
                            </div>
                            <div class="desciption">
                                <span>@lang('admin.total_own_pv')</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--yellow b-radius--10 box-shadow has--link">
                        <a href="#"
                            class="item--link"></a>
                        <div class="icon">
                            <i class="la la-money-check"></i>
                        </div>
                        <div class="details">
                            <div class="numbers">
                                <span class="amount">0</span>
                                <span class="currency-sign">{{ $general->cur_text }}</span>
                            </div>
                            <div class="desciption">
                                <span>@lang('admin.total_pending_referral')</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--blue-gray b-radius--10 box-shadow has--link">
                        <a href="#"
                            class="item--link"></a>
                        <div class="icon">
                            <i class="la la-cut"></i>
                        </div>
                        <div class="details">
                            <div class="numbers">
                                <span class="amount">0</span>
                            </div>
                            <div class="desciption">
                                <span>@lang('admin.total_spent_pv')</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--17 b-radius--10 box-shadow has--link">
                        <a href="{{ route('admin.report.single.bvLog', $user->id) }}?type=leftpv"
                            class="item--link"></a>
                        <div class="icon">
                            <i class="las la-arrow-alt-circle-left"></i>
                        </div>
                        <div class="details">
                            <div class="numbers">
                                <span class="amount">{{ getAmount(getChildPV($user->id, 1),0) }}</span>
                            </div>
                            <div class="desciption">
                                <span>@lang('admin.total_left_pv')</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--light-blue b-radius--10 box-shadow has--link">
                        <a href="{{ route('admin.report.single.bvLog', $user->id) }}?type=rightpv"
                            class="item--link"></a>
                        <div class="icon">
                            <i class="las la-arrow-alt-circle-right"></i>
                        </div>
                        <div class="details">
                            <div class="numbers">
                                <span class="amount">{{ getAmount(getChildPV($user->id, 2),0) }}</span>
                            </div>
                            <div class="desciption">
                                <span>@lang('admin.total_right_pv')</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                    <div class="dashboard-w1 bg--5 b-radius--10 box-shadow has--link">
                        <a href="#"
                            class="item--link"></a>
                        <div class="icon">
                            <i class="la la-la-money-check-alt"></i>
                        </div>
                        <div class="details">
                            <div class="numbers">
                                <span class="amount">0</span>
                            </div>
                            <div class="desciption">
                                <span>@lang('admin.total_pending_pv')</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            


            <div class="card mt-50">
                <div class="card-body">
                    <h5 class="card-title mb-50 border-bottom pb-2">@lang('Information')</h5>

                    <form id="update_user" action="{{ route('admin.users.update', [$user->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('form.last_name') <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="lastname"
                                        value="{{ $user->lastname }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('form.first_name')<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="firstname"
                                        value="{{ $user->firstname }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('form.last_name') KH<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="lastname_kh"
                                        value="{{ $user->lastname_kh }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('form.first_name') KH<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="firstname_kh"
                                        value="{{ $user->firstname_kh }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label font-weight-bold">@lang('form.position')<span
                                        class="text-danger">*</span></label>
                                    <select name="position" class="w-100 nice-select">
                                        @foreach ($plans as $plan)
                                            <option value="{{ $plan->id }}" {{ $plan->id === $user->plan_id ? 'selected' : '' }}>{{ $plan->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('form.phone') <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="mobile" value="{{ $user->mobile }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('form.id_card') <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="idcard" value="{{ $user->idcard }}">
                                </div>
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('form.house') </label>
                                    <input class="form-control" type="text" name="house"
                                        value="{{ $user->address->no ?? '' }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('form.street') </label>
                                    <input class="form-control" type="text" name="street"
                                        value="{{ $user->address->street ?? '' }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('form.village') </label>
                                    <input class="form-control" type="text" name="village"
                                        value="{{ $user->address->village ?? '' }}">
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="form-control-label font-weight-bold">@lang('form.commune') </label>
                                    <input class="form-control" type="text" name="commune"
                                        value="{{ $user->address->commune ?? '' }}">
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('form.district') </label>
                                    <input class="form-control" type="text" name="district"
                                        value="{{ $user->address->district ?? '' }}">
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('form.province') </label>
                                    <input class="form-control" type="text" name="province"
                                        value="{{ $user->address->province ?? '' }}">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-12">
                                <label class="form-control-label font-weight-bold">@lang('Status') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                    data-toggle="toggle" data-on="Active" data-off="Inactive" data-width="100%"
                                    name="status" @if ($user->status) checked @endif>
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Save Changes')
                                    </button>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
                        <div class="card-body p-0">
                            <div class="p-3 bg--white">
                                <div class="mb-1">
                                    <h4 class="">@lang('form.id_card_front')</h4>
                                </div>
                                <div class="form-group">
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="background-image: url({{ getImage(imagePath()['profile']['idcard']['path'] . '/' . $user->idcard_image, imagePath()['profile']['idcard']['size']) }})">
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input form="update_user" type="file" class="profilePicUpload" name="idcard_image" id="profilePicUpload3" accept=".png, .jpg, .jpeg">
                                                <label for="profilePicUpload3" class="bg--success">@lang('Upload ')@lang('form.id_card_front')</label>
                                                <a href="{{ getImage(imagePath()['profile']['idcard']['path'] . '/' . $user->idcard_image, imagePath()['profile']['idcard']['size']) }}" target="_blank">
                                                    <label for="download" class="bg--primary">@lang('Preview ')@lang('form.id_card_front')</label></a>
                                                <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg'), @lang('png').</b> @lang('Image will be resized into 1000x1000px') </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
                        <div class="card-body p-0">
                            <div class="p-3 bg--white">
                                <div class="mb-1">
                                    <h4 class="">@lang('form.id_card_back')</h4>
                                </div>
                                <div class="form-group">
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="background-image: url({{ getImage(imagePath()['profile']['idcard_back']['path'] . '/' . $user->idcard_image_back, imagePath()['profile']['idcard_back']['size']) }})">
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input form="update_user" type="file" class="profilePicUpload" name="idcard_image_back" id="profilePicUpload3" accept=".png, .jpg, .jpeg">
                                                <label for="profilePicUpload3" class="bg--success">@lang('Upload ')@lang('form.id_card_back')</label>
                                                <a href="{{ getImage(imagePath()['profile']['idcard_back']['path'] . '/' . $user->idcard_image_back, imagePath()['profile']['idcard_back']['size']) }}" target="_blank">
                                                    <label for="download" class="bg--primary">@lang('Preview ')@lang('form.id_card_back')</label></a>
                                                <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg'), @lang('png').</b> @lang('Image will be resized into 1000x1000px') </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
    </div>



    {{-- Add Sub Balance MODAL --}}
    <div id="addSubModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add / Subtract Balance')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.users.addSubBalance', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="checkbox" data-width="100%" data-height="44px" data-onstyle="-success"
                                    data-offstyle="-danger" data-toggle="toggle" data-on="Add Balance"
                                    data-off="Subtract Balance" name="act" checked>
                            </div>


                            <div class="form-group col-md-12">
                                <label>@lang('Amount')<span class="text-danger">*</span></label>
                                <div class="input-group has_append">
                                    <input type="text" name="amount" class="form-control"
                                        placeholder="Please provide positive amount">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--success">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="resetPWModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Reset Password')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.users.resetPassword', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>@lang('Password')<span class="text-danger">*</span></label>
                                <div class="input-group has_append">
                                    <input type="text" name="password" class="form-control"
                                        placeholder="Please provide strong password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--success">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
