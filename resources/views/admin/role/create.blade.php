@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body">
                    <form action="{{ route('admin.backend-users.roles.store') }}" method="POST">
                        @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="role_name">Role Name:*</label>
                                <input type="text" name="name" class="form-control" placeholder="role name" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="permission">Permissions:</label>
                        </div>
                    </div>
                    
                    <div class="row check_group">
                        <div class="col-md-3">
                            <h4>Plans</h4>
                        </div>
                        <div class="col-md-2">
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" class="check_all input-icheck"> Select All </label>
                              </div>
                        </div>
                        <div class="col-md-7">
                            <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="view.plans"></x-forms.checkbox> {{ __('permission.view.plans') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="edit.plans"></x-forms.checkbox> {{ __('permission.edit.plans') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="destroy.plans"></x-forms.checkbox> {{ __('permission.destroy.plans') }}
                                  </label>
                                </div>
                              </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row check_group">
                        <div class="col-md-3">
                            <h4>Members</h4>
                        </div>
                        <div class="col-md-2">
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" class="check_all input-icheck"> Select All </label>
                              </div>
                        </div>
                        <div class="col-md-7">
                            <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="view.members"></x-forms.checkbox> {{ __('permission.view.members') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="edit.members"></x-forms.checkbox> {{ __('permission.edit.members') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="destroy.members"></x-forms.checkbox> {{ __('permission.destroy.members') }}
                                  </label>
                                </div>
                              </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row check_group">
                        <div class="col-md-3">
                            <h4>Users</h4>
                        </div>
                        <div class="col-md-2">
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" class="check_all input-icheck"> Select All </label>
                              </div>
                        </div>
                        <div class="col-md-7">
                            <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="view.users"></x-forms.checkbox> {{ __('permission.view.users') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="edit.users"></x-forms.checkbox> {{ __('permission.edit.users') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="destroy.users"></x-forms.checkbox> {{ __('permission.destroy.users') }}
                                  </label>
                                </div>
                              </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row check_group">
                        <div class="col-md-3">
                            <h4>Settings</h4>
                        </div>
                        <div class="col-md-2">
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" class="check_all input-icheck"> Select All </label>
                              </div>
                        </div>
                        <div class="col-md-7">
                            <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="view.settings"></x-forms.checkbox> {{ __('permission.view.settings') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="edit.settings"></x-forms.checkbox> {{ __('permission.edit.settings') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="destroy.settings"></x-forms.checkbox> {{ __('permission.destroy.settings') }}
                                  </label>
                                </div>
                              </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row check_group">
                        <div class="col-md-3">
                            <h4>Logo</h4>
                        </div>
                        <div class="col-md-2">
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" class="check_all input-icheck" > Select All </label>
                              </div>
                        </div>
                        <div class="col-md-7">
                            <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="view.logo_settings"></x-forms.checkbox> {{ __('permission.view.logo_settings') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="edit.logo_settings"></x-forms.checkbox> {{ __('permission.edit.logo_settings') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="destroy.logo_settings"></x-forms.checkbox> {{ __('permission.destroy.logo_settings') }}
                                  </label>
                                </div>
                              </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row check_group">
                        <div class="col-md-3">
                            <h4>Languages</h4>
                        </div>
                        <div class="col-md-2">
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" class="check_all input-icheck" > Select All </label>
                              </div>
                        </div>
                        <div class="col-md-7">
                            <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="view.languages"></x-forms.checkbox> {{ __('permission.view.languages') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="edit.languages"></x-forms.checkbox> {{ __('permission.edit.languages') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="destroy.languages"></x-forms.checkbox> {{ __('permission.destroy.languages') }}
                                  </label>
                                </div>
                              </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row check_group">
                        <div class="col-md-3">
                            <h4>Pages</h4>
                        </div>
                        <div class="col-md-2">
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" class="check_all input-icheck" > Select All </label>
                              </div>
                        </div>
                        <div class="col-md-7">
                            <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="view.pages"></x-forms.checkbox> {{ __('permission.view.pages') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="edit.pages"></x-forms.checkbox> {{ __('permission.edit.pages') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="destroy.pages"></x-forms.checkbox> {{ __('permission.destroy.pages') }}
                                  </label>
                                </div>
                              </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row check_group">
                        <div class="col-md-3">
                            <h4>Sections</h4>
                        </div>
                        <div class="col-md-2">
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" class="check_all input-icheck" > Select All </label>
                              </div>
                        </div>
                        <div class="col-md-7">
                            <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="view.sections"></x-forms.checkbox> {{ __('permission.view.sections') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="edit.sections"></x-forms.checkbox> {{ __('permission.edit.sections') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="destroy.sections"></x-forms.checkbox> {{ __('permission.destroy.sections') }}
                                  </label>
                                </div>
                              </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row check_group">
                        <div class="col-md-3">
                            <h4>Roles</h4>
                        </div>
                        <div class="col-md-2">
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" class="check_all input-icheck" > Select All </label>
                              </div>
                        </div>
                        <div class="col-md-7">
                            <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="view.roles"></x-forms.checkbox> {{ __('permission.view.roles') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="edit.roles"></x-forms.checkbox> {{ __('permission.edit.roles') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <x-forms.checkbox value="destroy.roles"></x-forms.checkbox> {{ __('permission.destroy.roles') }}
                                  </label>
                                </div>
                              </div>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-outline--primary">Save</button>
                        </div>
                    </div>
                </form>
                </div>
            </div><!-- card end -->
        </div>

    </div>

@endsection

@push('script')
<script>
        //initialize iCheck
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
</script>
@endpush