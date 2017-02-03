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
                            <h5>Change password</h5>
                        </div>

                        <div class="ibox-content">
                            <div style="width: 400px; margin-left: auto; margin-right: auto; margin-top: 150px; margin-bottom: 150px;">
                                <form role="form" id="pwdform">
                                    <div class="form-group"><label>Old password*</label> <input type="password" placeholder="Old password" class="form-control required" name="old_password" id="old_password"></div>
                                    <div class="form-group"><label>New password*</label> <input type="password" placeholder="New password" class="form-control required" name="new_password" id="new_password"></div>
                                    <div class="form-group"><label>Confirm password*</label> <input type="password" placeholder="Confirm password" class="form-control required" name="confirm_password" id="confirm_password"></div>

                                    <button class="btn block full-width m-b btn-primary" type="submit" onclick="on_save()"><strong>Save</strong></button>

                                </form>
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
    });

    function on_save()
    {
        $('#pwdform').validate({
            errorPlacement: function (error, element) {
                element.before(error);
            },
            rules: {
                old_password: {
                    remote: {
                        url: "<?php echo site_url('admin/check_oldpassword'); ?>",
                        type: "post",
                        data: {
                            password: function() {
                                return $('#old_password').val();
                            }
                        }
                    }
                },
                new_password: {
                    required: true,
                    minlength : 8,
                    maxlength : 32,
                    regx: "Please enter a valid password (least 1 symbol() and least 1 digit and alphabet)"
                },
                confirm_password: {
                    equalTo: "#new_password"
                }
            },
            submitHandler: function() {
                console.log('submit');

                $.ajax({
                    async: true,
                    url: "<?php echo site_url('admin/change_password') ?>",
                    dataType: "json",
                    type: "POST",
                    data: {
                        password: $('#new_password').val()
                    },
                    success: function(json) {
                        alert('Password changed.');
                    },
                    error: function(xhr, errStr) {
                    //        alert(errStr);
                    }
                });
            }
        });
    }

</script>