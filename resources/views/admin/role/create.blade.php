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
                                  <input type="checkbox" class="check_all input-icheck" > Select All </label>
                              </div>
                        </div>
                        <div class="col-md-7">
                            <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="view.plans"> {{ __('permission.view.plans') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="edit.plans"> {{ __('permission.edit.plans') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="destroy.plans"> {{ __('permission.destroy.plans') }}
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
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="view.members"> {{ __('permission.view.members') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="edit.members"> {{ __('permission.edit.members') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="destroy.members"> {{ __('permission.destroy.members') }}
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
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="view.users"> {{ __('permission.view.users') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="edit.users"> {{ __('permission.edit.users') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="destroy.users"> {{ __('permission.destroy.users') }}
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
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="view.settings"> {{ __('permission.view.settings') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="edit.settings"> {{ __('permission.edit.settings') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="destroy.settings"> {{ __('permission.destroy.settings') }}
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
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="view.logo_settings"> {{ __('permission.view.logo_settings') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="edit.logo_settings"> {{ __('permission.edit.logo_settings') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="destroy.logo_settings"> {{ __('permission.destroy.logo_settings') }}
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
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="view.languages"> {{ __('permission.view.languages') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="edit.languages"> {{ __('permission.edit.languages') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="destroy.languages"> {{ __('permission.destroy.languages') }}
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
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="view.pages"> {{ __('permission.view.pages') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="edit.pages"> {{ __('permission.edit.pages') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="destroy.pages"> {{ __('permission.destroy.pages') }}
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
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="view.sections"> {{ __('permission.view.sections') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="edit.sections"> {{ __('permission.edit.sections') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="destroy.sections"> {{ __('permission.destroy.sections') }}
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
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="view.roles"> {{ __('permission.view.roles') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="edit.roles"> {{ __('permission.edit.roles') }}
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" name="permission[]" id="" class="input-icheck" value="destroy.roles"> {{ __('permission.destroy.roles') }}
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