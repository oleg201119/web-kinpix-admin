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
                            <h5>Help</h5>
                        </div>

                        <div class="ibox-content">
                            <button id="edit" class="btn btn-primary btn-w-m" onclick="edit()" type="button" <?php if ($this->session->userdata('login_permission') == 0) echo "disabled"; ?>>Edit</button>
                            <button id="save" class="btn btn-success btn-w-m" onclick="save()" type="button" <?php if ($this->session->userdata('login_permission') == 0) echo "disabled"; ?>>Save</button>

                            <div class="click2edit wrapper" style="min-height: 500px; border: 1px solid #e7eaec;">
                                <?php echo $content; ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">

    function edit() {
        $('.click2edit').summernote({focus: true});
    };

    function save() {
        var content = $('.click2edit').code();
        $('.click2edit').destroy();

        $.ajax({
            async: true,
            url: "<?php echo site_url('admin/save_content') ?>",
            dataType: "json",
            type: "POST",
            data: {
                screen: 'help',
                content: content
            },
            success: function(json) {
                //
            },
            error: function(xhr, errStr) {
                //    alert(errStr);
            }
        });
    };

</script>