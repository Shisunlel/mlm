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
                                <th scope="col">@lang('Roles')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($roles as $role)
                            <tr>
                                <td data-label="@lang('Roles')">{{ $role->name }}</td>
                                <td data-label="@lang('Action')">
                                    <a href="{{ route('admin.backend-users.roles.edit', ['id' => $role->id])}}" class="icon-btn" data-toggle="tooltip" data-original-title="@lang('Details')">
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
                    {{ paginateLinks($roles) }}
                </div>
            </div><!-- card end -->
        </div>

    </div>

@endsection



@push('breadcrumb-plugins')
    <a href="{{route('admin.backend-users.roles.create')}}" class="btn btn--primary box--shadow1 text--small"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
@endpush