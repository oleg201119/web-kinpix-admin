<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>
            <h1 class="logo-name">&nbsp;</h1>
            <img src="<?php echo base_url();?>inspinia_admin/img/logo/logo.png">
        </div>
        <h3 style="color: #bfbfbf">Welcome to KinPix Admin</h3>

        <form class="m-t" role="form">
            <div class="form-group">
                <input type="text" id="username" class="form-control" placeholder="Username" required="">
            </div>
            <div class="form-group">
                <input type="password" id="password" class="form-control" placeholder="Password" required="">
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b" onclick="login(); return false;">Login</button>
        </form>
        <p class="m-t"> <small style="font-weight: 900">KINPIX &copy; 2015</small> </p>
    </div>
</div>

<script type="text/javascript">

    function login() {

        $.ajax({
            async: true,
            url: "<?php echo site_url('admin/login') ?>",
            dataType: "json",
            type: "POST",
            data: {
                username: $('#username').val(),
                password: $('#password').val()
            },
            success: function(json) {

                if (json['result'] >= 0)
                {
                    location.href = "<?php echo site_url('admin/search_user/0') ?>";
                }
                else
                {
                    $('#username').val('');
                    $('#password').val('');
                }
            },
            error: function(xhr, errStr) {
                //    alert(errStr);
            }
        });
    }

</script>