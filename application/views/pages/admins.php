<div id="wrapper">
    <div id="page-wrapper" class="gray-bg">

        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <a href="<?php echo site_url("admin/logout"); ?>">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Admin Users</h5>
                        </div>

                        <div class="ibox-content" style="min-height: 530px;">

                            <div class="row">
                                <div class="col-lg-12">
                                    <a data-toggle="modal" class="btn btn-primary" href="#modal-form-new" <?php if ($this->session->userdata('login_permission') == 0) echo "disabled"; ?>>New Admin</a>
                                </div>
                            </div>

                            <!-- modal form 'new' -->
                            <div id="modal-form-new" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12"><h3 class="m-t-none m-b">New Admin User</h3>

                                                    <p>Create new admin user.</p>

                                                    <form role="form" id="modalform">
                                                        <div class="form-group"><label>Username*</label> <input type="text" placeholder="Username" class="form-control required" name="username" id="username"></div>
                                                        <div class="form-group"><label>Password*</label> <input type="password" placeholder="Password" class="form-control required" name="password" id="password"></div>
                                                        <div class="form-group"><label>Confirm*</label> <input type="password" placeholder="Confirm password" class="form-control required" name="confirm" id="confirm"></div>
                                                        <div class="form-group">
                                                            <label>Role*</label>
                                                            <select class="form-control required" name="adminflag" id="adminflag">
                                                                <option value="1">Read/Write</option>
                                                                <option value="0">Read only</option>
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit" onclick="on_create()"><strong>Create</strong></button>
                                                            <button class="btn btn-sm btn-primary pull-right m-t-n-xs" style="margin-right: 20px;" type="button" onclick="on_cancel_new()"><strong>Cancel</strong></button>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal form 'edit' -->
                            <div id="modal-form-edit" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12"><h3 class="m-t-none m-b">Edit Admin User</h3>

                                                    <p>Change admin user.</p>

                                                    <form role="form" id="modalform_edit">
                                                        <input type="hidden" id="username_old" value="">
                                                        <input type="hidden" id="adminflag_old" value="">
                                                        <div class="form-group"><label>Username*</label> <input type="text" placeholder="Username" class="form-control required" name="username_edit" id="username_edit"></div>

                                                        <div class="form-group"><label>Password*</label> <input type="password" placeholder="Password" class="form-control " name="password_edit" id="password_edit"></div>
                                                        <div class="form-group"><label>Confirm*</label> <input type="password" placeholder="Confirm password" class="form-control " name="confirm_edit" id="confirm_edit"></div>

                                                        <div class="form-group" id="role_group">
                                                            <label>Role*</label>
                                                            <select class="form-control required" name="adminflag_edit" id="adminflag_edit">
                                                                <option value="1">Read/Write</option>
                                                                <option value="0">Read only</option>
                                                            </select>
                                                        </div>

                                                        <div>
                                                            <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit" onclick="on_edit_done()"><strong>Change</strong></button>
                                                            <button class="btn btn-sm btn-primary pull-right m-t-n-xs" style="margin-right: 20px;" type="button" onclick="on_cancel_edit()"><strong>Cancel</strong></button>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- confirm modal form -->
                            <div id="modal-confirm" class="modal fade" aria-hidden="true" aria-labelledby="confirm-modal-label">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <input type="hidden" id="modal-opener" value="">
                                        <input type="hidden" id="modal-return" value="">
                                        <input type="hidden" id="modal-callback" value="">
                                        <input type="hidden" id="modal-param" value="">

                                        <div class="modal-header">
                                            <h4 class="modal-title" id="confirm-modal-label">Confirm dialog</h4>
                                        </div>

                                        <div class="modal-body">
                                            <p id="modal-message"></p>
                                        </div>

                                        <div class="modal-footer" style="padding: 10px 20px 5px">
                                            <button class="btn btn-sm btn-primary pull-right" data-dismiss="modal">Cancel</button>
                                            <button class="btn btn-sm btn-primary pull-right" style="margin-right: 10px;" onclick="on_ok_confirm()">Ok</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- admin user table -->
                            <div class="tooltip-demo" style="width: 50%; min-height: 450px;">
                                <table class="table table-bordered" style="margin-bottom: 0px;" id="photo_table">
                                    <tbody id="users_body">

                                    <tr>
                                        <th>#</th>

                                        <th>Username</th>
                                        <th>Permission</th>

                                        <th>Actions</th>
                                    </tr>

                                    <?php
                                    for($i=0; $i<count($data_list); $i++)
                                    {
                                        ?>

                                        <tr>
                                            <td style="display: none"><?php echo $data_list['username']; ?></td>
                                            <td><?php echo ($offset + $i + 1); ?></td>

                                            <td><?php echo $data_list[$i]['username']; ?></td>
                                            <td>
                                                <?php
                                                if ($data_list[$i]['adminflag'] == 0) {
                                                    echo "Read Only";
                                                }
                                                else {
                                                    echo "Read/Write";
                                                }
                                                ?>
                                            </td>

                                            <td style="padding-top: 1px; padding-bottom: 0px; text-align: center; vertical-align: middle;">

                                                <?php
                                                // delete button
                                                if ($data_list[$i]['adminflag'] < 2 && $data_list[$i]['username'] != $this->session->userdata('login_user'))
                                                {
                                                ?>
                                                    <a class="btn btn-sm btn-white btn-action" onclick="on_delete('<?php echo $data_list[$i]['username']; ?>');" data-toggle="tooltip" data-placement="bottom" title="Delete" <?php if ($this->session->userdata('login_permission') == 0) echo "disabled"; ?>><img src="<?php echo base_url();?>inspinia_admin/img/icon/delete.png"></a>
                                                <?php
                                                }

                                                // edit button
                                                if ($data_list[$i]['adminflag'] <= $this->session->userdata('login_permission'))
                                                {
                                                ?>
                                                    <a class="btn btn-sm btn-white btn-action" onclick="on_edit('<?php echo $data_list[$i]['username']; ?>', '<?php echo $data_list[$i]['adminflag']; ?>');" data-toggle="tooltip" data-placement="bottom" title="Edit" <?php if ($this->session->userdata('login_permission') == 0 && $data_list[$i]['username'] != $this->session->userdata('login_user')) echo "disabled"; ?>><img src="<?php echo base_url();?>inspinia_admin/img/icon/change-account.png"></a>
                                                <?php
                                                }
                                                ?>


                                            </td>
                                        </tr>

                                    <?php
                                    }
                                    ?>

                                    </tbody>
                                </table>

                                <div class="row">
                                    <div class="col col-lg-12">
                                        <ul class="pagination pagination-sm no-margin pull-right" id="pagenation_wrapper">
                                            <?php echo $pagenation; ?>
                                        </ul>
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

<script type="text/javascript">

    $(document).ready(function() {
        $.validator.addMethod("regx", function(value, element) {
            return /^[A-Za-z0-9\d~!@#$%^&*()\-=_+{}\[\]|\\;:'",.\/<>?`]*$/.test(value) // consists of only these
                && /[~!@#$%^&*()\-=_+{}\[\]|\\;:'",.\/<>?`]/.test(value) // has a symbol
                && /\d/.test(value) // has a digit
        }, "Enter symbol, digit and alphabet");

        $.validator.addMethod("regx_edit", function(value, element) {
            if (value.length == 0) return true;
            else return /^[A-Za-z0-9\d~!@#$%^&*()\-=_+{}\[\]|\\;:'",.\/<>?`]*$/.test(value) // consists of only these
                && /[~!@#$%^&*()\-=_+{}\[\]|\\;:'",.\/<>?`]/.test(value) // has a symbol
                && /\d/.test(value) // has a digit
        }, "Enter symbol, digit and alphabet");


        $('#modal-confirm').on('hidden.bs.modal', function(e) {

            if ($('#modal-return').val() == '1')
            {
                var callback_func = $('#modal-callback').val();
                var callback_param = $('#modal-param').val();

                window[callback_func](callback_param);
            }
        });
    });

    function on_create()
    {
        $('#modalform').validate({
            errorPlacement: function (error, element) {
                element.before(error);
            },
            rules: {
                username: {
                    remote: {
                        url: "<?php echo site_url('admin/check_adminname'); ?>",
                        type: "post",
                        data: {
                            username: function() {
                                return $('#username').val();
                            }
                        }
                    }
                },
                password: {
                    required: true,
                    minlength : 8,
                    maxlength : 32,
                    regx: "Please enter a valid password (least 1 symbol() and least 1 digit and alphabet)"
                },
                confirm: {
                    equalTo: "#password"
                }
            },
            submitHandler: function() {

                $.ajax({
                    async: true,
                    url: "<?php echo site_url('admin/new_admin') ?>",
                    dataType: "json",
                    type: "POST",
                    data: {
                        username: $('#username').val(),
                        password: $('#password').val(),
                        adminflag: $('#adminflag').val()
                    },
                    success: function(json) {

                        if (json['result'] >= 0)
                        {
                            $('#modal-form-new').modal('hide');

                            $('#modal-form-new').on('hidden.bs.modal', function(e) {
                                location.href = "<?php echo site_url('admin/admins/0') ?>";
                            });
                        }
                        else
                        {
                            $('#username').val('');
                            $('#password').val('');
                            $('#confirm').val('');
                        }
                    },
                    error: function(xhr, errStr) {
                            alert(errStr);
                    }
                });
            }
        });
    }

    function on_delete(username)
    {
        open_confirm('delete', "Please confirm if you would like to remove \"" + username + "\" for a KinPix Admin account?", 'do_delete', username);
    }

    function do_delete(username)
    {
        location.href="<?php echo site_url('admin/delete_admin/'); ?>" + "/" + username;
    }

    function on_edit(username, adminflag)
    {
        $('#username_old').val(username);
        $('#username_edit').val(username);
        $('#adminflag_old').val(adminflag);

        $('#password_edit').val('');
        $('#confirm_edit').val('');

        $('#adminflag_edit').val(adminflag);

        if (adminflag == '2' || adminflag == '0')
        {
            // Hide role
            $('#role_group').hide();
        }
        else
        {
            // Show role
            $('#role_group').show();
        }

        $('#modal-form-edit').modal('show');
    }

    function on_edit_done()
    {
        $('#modalform_edit').validate({
            errorPlacement: function (error, element) {
                element.before(error);
            },
            rules: {
                username_edit: {

                    remote: {
                        url: "<?php echo site_url('admin/check_adminname_edit'); ?>",
                        type: "post",
                        data: {
                            username: function() {
                                return $('#username_edit').val();
                            },
                            username_old: function() {
                                return $('#username_old').val();
                            }
                        }
                    }
                },
                password_edit: {
                    required: false,
                    minlength : 0,
                    maxlength : 32,
                    regx_edit: "Please enter a valid password (least 1 symbol() and least 1 digit and alphabet)"
                },
                confirm_edit: {
                    equalTo: "#password_edit"
                }
            },
            submitHandler: function() {

                var adminflag = $('#adminflag_edit').val();
                if ( $('#adminflag_old').val() == '2')
                    adminflag = 2;

                if ($('#username_old').val() == $('#username_edit').val() && $('#password_edit').val() == '' && $('#confirm_edit').val() == '' && $('#adminflag_old').val() == adminflag)
                {
                    $('#modal-form-edit').modal('hide');
                    return;
                }



                $.ajax({
                    async: true,
                    url: "<?php echo site_url('admin/edit_admin') ?>",
                    dataType: "json",
                    type: "POST",
                    data: {
                        username_old: $('#username_old').val(),
                        username: $('#username_edit').val(),
                        password: $('#password_edit').val(),
                        adminflag: adminflag
                    },
                    success: function(json) {

                        if (json['result'] >= 0)
                        {
                            $('#modal-form-edit').modal('hide');

                            $('#modal-form-edit').on('hidden.bs.modal', function(e) {
                                location.href = "<?php echo site_url('admin/admins/0') ?>";
                            });
                        }
                        else
                        {

                        }
                    },
                    error: function(xhr, errStr) {
                        alert(errStr);
                    }
                });
            }
        });
        $('#username_edit').valid();
    }

    function on_cancel_new()
    {
        $('#modal-form-new').modal('hide');
    }

    function on_cancel_edit()
    {
        $('#modal-form-edit').modal('hide');
    }

    function open_confirm(opener, message, callback, param)
    {
        $('#modal-opener').val(opener);
        $('#modal-return').val('0');
        $('#modal-message').html(message);
        $('#modal-callback').val(callback);
        $('#modal-param').val(param);

        $('#modal-confirm').modal('show');
    }

    function on_ok_confirm()
    {
        $('#modal-return').val('1');
        $('#modal-confirm').modal('hide');
    }

</script>