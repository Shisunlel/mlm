@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body">
                    <form action="{{ route('admin.backend-users.roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="role_name">Role Name:*</label>
                                <input type="text" name="name" class="form-control" placeholder="role name" value="{{ $role->name }}" required>
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
                                  <input type="checkbox" class="check_all input-icheck" > Select All </label>
                              </div>
                        </div>
                        <div class="col-md-7">
                            <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="view.plans" {{ in_array('view.plans', $role_permissions) ? 'checked' : '' }} > {{ __('permission.view.plans') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="edit.plans" {{ in_array('edit.plans', $role_permissions) ? 'checked' : '' }}> {{ __('permission.edit.plans') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="destroy.plans" {{ in_array('destroy.plans', $role_permissions) ? 'checked' : '' }}> {{ __('permission.destroy.plans') }}
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
                                  <input type="checkbox" class="check_all input-icheck" > Select All </label>
                              </div>
                        </div>
                        <div class="col-md-7">
                            <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="view.members" {{ in_array('view.members', $role_permissions) ? 'checked' : '' }}> {{ __('permission.view.members') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="edit.members" {{ in_array('edit.members', $role_permissions) ? 'checked' : '' }}> {{ __('permission.edit.members') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="destroy.members" {{ in_array('destroy.members', $role_permissions) ? 'checked' : '' }}> {{ __('permission.destroy.members') }}
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
                                  <input type="checkbox" class="check_all input-icheck" > Select All </label>
                              </div>
                        </div>
                        <div class="col-md-7">
                            <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="view.users" {{ in_array('view.users', $role_permissions) ? 'checked' : '' }}> {{ __('permission.view.users') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="edit.users" {{ in_array('edit.users', $role_permissions) ? 'checked' : '' }}> {{ __('permission.edit.users') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="destroy.users" {{ in_array('destroy.users', $role_permissions) ? 'checked' : '' }}> {{ __('permission.destroy.users') }}
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
                                  <input type="checkbox" class="check_all input-icheck" > Select All </label>
                              </div>
                        </div>
                        <div class="col-md-7">
                            <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="view.settings" {{ in_array('edit.settings', $role_permissions) ? 'checked' : '' }}> {{ __('permission.view.settings') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="edit.settings" {{ in_array('edit.settings', $role_permissions) ? 'checked' : '' }}> {{ __('permission.edit.settings') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="destroy.settings" {{ in_array('destroy.settings', $role_permissions) ? 'checked' : '' }}> {{ __('permission.destroy.settings') }}
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
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="view.logo_settings" {{ in_array('view.logo_settings', $role_permissions) ? 'checked' : '' }}> {{ __('permission.view.logo_settings') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="edit.logo_settings" {{ in_array('edit.logo_settings', $role_permissions) ? 'checked' : '' }}> {{ __('permission.edit.logo_settings') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="destroy.logo_settings" {{ in_array('destroy.logo_settings', $role_permissions) ? 'checked' : '' }}> {{ __('permission.destroy.logo_settings') }}
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
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="view.languages" {{ in_array('view.languages', $role_permissions) ? 'checked' : '' }}> {{ __('permission.view.languages') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="edit.languages" {{ in_array('edit.languages', $role_permissions) ? 'checked' : '' }}> {{ __('permission.edit.languages') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="destroy.languages" {{ in_array('destroy.languages', $role_permissions) ? 'checked' : '' }}> {{ __('permission.destroy.languages') }}
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
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="view.pages" {{ in_array('view.pages', $role_permissions) ? 'checked' : '' }}> {{ __('permission.view.pages') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="edit.pages" {{ in_array('edit.pages', $role_permissions) ? 'checked' : '' }}> {{ __('permission.edit.pages') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="destroy.pages" {{ in_array('destroy.pages', $role_permissions) ? 'checked' : '' }}> {{ __('permission.destroy.pages') }}
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
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="view.sections" {{ in_array('view.sections', $role_permissions) ? 'checked' : '' }}> {{ __('permission.view.sections') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="edit.sections" {{ in_array('edit.sections', $role_permissions) ? 'checked' : '' }}> {{ __('permission.edit.sections') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="destroy.sections" {{ in_array('destroy.sections', $role_permissions) ? 'checked' : '' }}> {{ __('permission.destroy.sections') }}
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
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="view.roles" {{ in_array('view.roles', $role_permissions) ? 'checked' : '' }}> {{ __('permission.view.roles') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="edit.roles" {{ in_array('edit.roles', $role_permissions) ? 'checked' : '' }}> {{ __('permission.edit.roles') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="destroy.roles" {{ in_array('destroy.roles', $role_permissions) ? 'checked' : '' }}> {{ __('permission.destroy.roles') }}
                                  </label>
                                </div>
                              </div>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-outline--primary">Update</button>
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