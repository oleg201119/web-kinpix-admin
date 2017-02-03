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
                            <h5>Admin Setting</h5>
                        </div>

                        <div class="ibox-content">
                            <div style="width: 300px; margin-left: auto; margin-right: auto; margin-top: 200px; margin-bottom: 200px;">
                                <form role="form">
                                    <div class="form-group"><label>Image scaling range:(10 ~ 100)</label> <input type="text" placeholder="Image scale" class="form-control" name="comprate" id="comprate" value="<?php echo $settings['comprate']; ?>" <?php if ($this->session->userdata('login_permission') == 0) echo "disabled"; ?>></div>

                                    <div class="checkbox"><label> <input type="checkbox" <?php if ($settings['autosignflag'] == 1) echo "checked";?> name="autosignflag" id="autosignflag" <?php if ($this->session->userdata('login_permission') == 0) echo "disabled"; ?>> Auto user singup </label></div>

                                        <button class="btn block full-width m-b btn-primary" type="button" onclick="on_save()" <?php if ($this->session->userdata('login_permission') == 0) echo "disabled"; ?>><strong>Save</strong></button>

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

    function on_save()
    {
        $.ajax({
            async: true,
            url: "<?php echo site_url('admin/set_settings') ?>",
            dataType: "json",
            type: "POST",
            data: {
                comprate: $('#comprate').val(),
                autosignflag: $('#autosignflag').val()
            },
            success: function(json) {

                alert('Settings saved.');
            },
            error: function(xhr, errStr) {
                //    alert(errStr);
            }
        });
    }

</script>