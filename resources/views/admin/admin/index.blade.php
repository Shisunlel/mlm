@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('User')</th>
                                <th scope="col">@lang('Username')</th>
                                <th scope="col">@lang('Email')</th>
                                <th scope="col">@lang('Joined At')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($admins as $admin)
                            <tr>
                                <td data-label="@lang('User')">
                                    <div class="user">
                                        <div class="thumb">
                                            <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'.$admin->image,imagePath()['profile']['user']['size'])}}" alt="@lang('image')">
                                        </div>
                                        <span class="name">{{$admin->name}}</span>
                                    </div>
                                </td>
                                <td data-label="@lang('Username')"><a href="{{ route('admin.users.detail', $admin->id) }}">{{ $admin->username }}</a></td>
                                <td data-label="@lang('Email')">{{ $admin->email }}</td>
                                <td data-label="@lang('Created At')">{{ showDateTime($admin->created_at) }}</td>
                                <td data-label="@lang('Action')">
                                    <a href="{{ route('admin.users.detail', $admin->id) }}" class="icon-btn" data-toggle="tooltip" data-original-title="@lang('Details')">
                                        <i class="las la-desktop text--shadow"></i>
                                    </a>
                                </td>
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
                    {{ paginateLinks($admins) }}
                </div>
            </div><!-- card end -->
        </div>

    </div>

    {{-- Add METHOD MODAL --}}
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Add New Pages')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.backend-users.store')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label> @lang('name')</label>
                            <input type="text" class="form-control form-control-lg" placeholder="@lang('name')" name="name" value="{{old('name')}}" required>
                        </div>
                        <div class="form-group">
                            <label> @lang('username')</label>
                            <input type="text" class="form-control form-control-lg" name="username" placeholder="@lang('username')" value="{{old('username')}}" required>
                        </div>
                        <div class="form-group">
                            <label> @lang('password')</label>
                            <input type="password" class="form-control form-control-lg" name="password" placeholder="@lang('password')" required>
                        </div>
                        <div class="form-group">
                            <label> @lang('email')</label>
                            <input type="email" class="form-control form-control-lg" name="email" placeholder="@lang('email')" value="{{old('email')}}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="importModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Import Users')</h5>
                    <a href="{{ asset('assets/files/import_users.xls') }}" class="btn btn-success ml-auto" download=""><i class="fa fa-download"></i> @lang('Import User Template')</a>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.backend-users.import')}}" method="POST" enctype="multipart/form-data" onsubmit="return validateFile()">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label> @lang('File To Import')</label>
                            <input type="file" class="form-control form-control-lg" name="users_import" id="users_import" accept=".xls,.xlsx,.csv" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection



@push('breadcrumb-plugins')
    <a href="javascript:void(0)" class="btn btn--primary box--shadow1 text--small addBtn my-1"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
    <a href="javascript:void(0)" class="btn btn--primary box--shadow1 text--small importBtn my-1"><i class="fa fa-fw fa-plus"></i>@lang('Import Users')</a>
    <a href="{{route('admin.backend-users.export')}}" class="btn btn--primary box--shadow1 text--small my-1"><i class="fa fa-fw fa-plus"></i>@lang('Export Users')</a>
    <form action="{{ route('admin.users.search', $scope ?? str_replace('admin.users.', '', request()->route()->getName())) }}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Username or email')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush

@push('script')
<script>
    'use strict';
        (function($){

            $('.addBtn').on('click', function () {
                var modal = $('#addModal');
                modal.find('input[name=id]').val($(this).data('id'))
                modal.modal('show');
            });

            $('.importBtn').on('click', () => {
                const imp_modal = $('#importModal')
                imp_modal.modal('show')
            })

        })(jQuery)

function validateFile(){
    const fileVal = $('#users_import').val();
    const allowedExt = /(\.xls|\.xlsx|\.csv)$/i
    if(!allowedExt.exec(fileVal)){
        notify('error', 'Supported file type .xls, .xlsx, .csv')
        return false
    }
    return true
}
</script>
@endpush