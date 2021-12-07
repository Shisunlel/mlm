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
                                <th scope="col">@lang('Member')</th>
                                <th scope="col">@lang('Username')</th>
                                <th scope="col">@lang('Email')</th>
                                <th scope="col">@lang('Phone')</th>
                                <th scope="col">@lang('Joined At')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td data-label="@lang('User')">
                                    <div class="user">
                                        <div class="thumb">
                                            <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'.$user->image,imagePath()['profile']['user']['size'])}}" alt="@lang('image')">
                                        </div>
                                        <span class="name">{{$user->fullname}}</span>
                                    </div>
                                </td>
                                <td data-label="@lang('Username')"><a href="{{ route('admin.users.detail', $user->id) }}">{{ $user->username }}</a></td>
                                <td data-label="@lang('Email')">{{ $user->email }}</td>
                                <td data-label="@lang('Phone')">{{ $user->mobile }}</td>
                                <td data-label="@lang('Joined At')">{{ showDateTime($user->created_at) }}</td>
                                <td data-label="@lang('Action')">
                                    <a href="{{ route('admin.users.detail', $user->id) }}" class="icon-btn mr-2" data-toggle="tooltip" data-original-title="@lang('Details')">
                                        <i class="las la-desktop text--shadow"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="icon-btn deleteBtn" data-toggle="tooltip" data-id="{{ $user->id }}" data-original-title="@lang('Removes')">
                                        <i class="las la-times text--shadow"></i>
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
                    {{ paginateLinks($users) }}
                </div>
            </div><!-- card end -->
        </div>


    </div>

    <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Remove Members')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.users.destroy') }}" method="POST" id="formDel">
                    @csrf
                    <input type="hidden" name="id" id="delId">
                    <div class="modal-body text-center">
                        <h4>@lang('Are you sure?')</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Delete')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        'use strict';
        (function($){
            $('.deleteBtn').on('click', function(){
                const del_modal = $('#deleteModal')
                const id = $(this).data('id')
                del_modal.find('#formDel #delId').val(id)
                del_modal.modal('show')
            })
        })(jQuery)
    </script>
@endpush



@push('breadcrumb-plugins')
    <a href="{{ route('admin.members.create') }}" class="btn btn--primary box--shadow1 text--small mx-1"><i class="fa fa-fw fa-plus"></i>@lang('Add Users')</a>
    <form action="{{ route('admin.users.search', $scope ?? str_replace('admin.users.', '', request()->route()->getName())) }}" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('ID or name')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush
