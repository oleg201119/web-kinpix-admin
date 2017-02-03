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
                            <h5>Total Users: <?php echo $total_user; ?></h5>
                        </div>

                        <div class="ibox-content">

                            <div class="row">
                                <div class="col-lg-12">
                                    <form class="form-horizontal" action="<?php echo site_url('admin/search_user/0'); ?>" method="post">
                                        <div class="form-group">
                                            <!-- Search flag -->
                                            <input type="hidden" name="search_start" value="1">
                                            <!-- Search field -->
                                            <label class="col-lg-1 control-label">Search:</label>
                                            <div class="col-lg-2">
                                                <select class="form-control m-b" name="search_field" id="search_field">
                                                    <option value="email" <?php if ($search_field == 'email') echo 'selected'; ?>>Email</option>
                                                    <option value="lastname" <?php if ($search_field == 'lastname') echo 'selected'; ?>>Last Name</option>
                                                    <option value="pin" <?php if ($search_field == 'pin') echo 'selected'; ?>>PIN</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 search_field">
                                                <input type="search" class="form-control" name="search_val" id="search_val" placeholder="Search Word" value="<?php echo $search_val; ?>">
                                            </div>

                                            <!-- Sort field -->
                                            <label class="col-lg-1 control-label">Sort:</label>
                                            <div class="col-lg-4">
                                                <select class="form-control m-b" name="sort_field" id="sort_field">

                                                    <option value="accounttype" <?php if ($sort_field == 'accounttype') echo 'selected'; ?>>Account Type</option>
                                                    <option value="totalphoto" <?php if ($sort_field == 'totalphoto') echo 'selected'; ?>>Total Photos</option>
                                                    <option value="totalfriends" <?php if ($sort_field == 'totalfriends') echo 'selected'; ?>>Total Friends</option>

                                                    <option value="lastlogindate" <?php if ($sort_field == 'lastlogindate') echo 'selected'; ?>>Last Activity Date</option>
                                                    <option value="last30dayslogincount" <?php if ($sort_field == 'last30dayslogincount') echo 'selected'; ?>>Activity in the last 0-30 days</option>
                                                    <option value="last90dayslogincount" <?php if ($sort_field == 'last90dayslogincount') echo 'selected'; ?>>Activity in the last 31-90 days</option>
                                                    <option value="last30daysphotocount" <?php if ($sort_field == 'last30daysphotocount') echo 'selected'; ?>>Shared Photos in the last 0-30 days</option>
                                                    <option value="last90daysphotocount" <?php if ($sort_field == 'last90daysphotocount') echo 'selected'; ?>>Shared Photos in the last 31-90 days</option>

                                                    <option value="deviceplatform" <?php if ($sort_field == 'deviceplatform') echo 'selected'; ?>>User Platform</option>
                                                    <option value="pin" <?php if ($sort_field == 'pin') echo 'selected'; ?>>PIN</option>
                                                    <option value="firstname" <?php if ($sort_field == 'firstname') echo 'selected'; ?>>First Name</option>
                                                    <option value="lastname" <?php if ($sort_field == 'lastname') echo 'selected'; ?>>Last  Name</option>
                                                    <option value="city" <?php if ($sort_field == 'city') echo 'selected'; ?>>City</option>
                                                    <option value="state" <?php if ($sort_field == 'state') echo 'selected'; ?>>State</option>
                                                    <option value="country" <?php if ($sort_field == 'country') echo 'selected'; ?>>Country</option>

                                                    <option value="accountcreatedate" <?php if ($sort_field == 'accountcreatedate') echo 'selected'; ?>>Account Creation Date</option>

                                                    <option value="iaptype" <?php if ($sort_field == 'iaptype') echo 'selected'; ?>>In-App Purchase Type</option>
                                                    <option value="accountsuspenddate" <?php if ($sort_field == 'accountsuspenddate') echo 'selected'; ?>>Date Last Suspended</option>
                                                    <option value="accountstatus" <?php if ($sort_field == 'accountstatus') echo 'selected'; ?>>Account Status</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-1 order_field">
                                                <select class="form-control m-b" name="order_field" id="order_field">
                                                    <option value="asc" <?php if ($order_field == 'asc') echo 'selected'; ?>>ASC</option>
                                                    <option value="desc" <?php if ($order_field == 'desc') echo 'selected'; ?>>DESC</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-1 search_btn">
                                                <button class="btn btn-primary pull-left" type="submit"><strong>Go!</strong></button>
                                            </div>

                                        </div>
                                    </form>

                                </div>
                            </div>

                            <!-- modal form -->
                            <div id="modal-form" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12"><h3 class="m-t-none m-b">Change account type</h3>

                                                    <p>You can change <span id="account_name" style="font-weight: 900;"></span>'s account type.</p>

                                                    <form role="form" id="modalform">
                                                        <input type="hidden" name="account_id" id="account_id">
                                                        <div class="form-group"><label>Account Type</label>
                                                            <select class="form-control m-b" name="account_type" id="account_type">
                                                                <option value="0">Free level</option>
                                                                <option value="1">+2 package</option>
                                                                <option value="2">+5 package</option>
                                                                <option value="3">+10 package</option>
                                                                <option value="4">Unlimit</option>
                                                            </select>
                                                        </div>

                                                        <div>
                                                            <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="button" onclick="do_changetype()"><strong>Change</strong></button>
                                                            <button class="btn btn-sm btn-primary pull-right m-t-n-xs" style="margin-right: 20px;" type="button" onclick="on_cancel()"><strong>Cancel</strong></button>
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


                            <div class="table-responsive tooltip-demo" style="display: block; overflow-x: auto;">
                                <table class="table table-bordered" style="margin-bottom: 0px;" id="users_table">
                                    <tbody id="users_body" style="height: 450px; overflow-y: auto; overflow-x: hidden; display: block;">

                                    <tr>
                                        <th style="width: 85px">#</th>

                                        <th style="width: 130px">First Name</th>
                                        <th style="width: 130px">Last Name</th>

                                        <th style="width: 200px">Email Address</th>
                                        <th style="width: 125px">PIN</th>

                                        <th style="width: 90px">Account Creation Date</th>
                                        <th style="width: 85px">Account Type</th>
                                        <th style="width: 100px">Account Status</th>

                                        <th style="width: 85px">Total Photos</th>
                                        <th style="width: 85px">Total Friends</th>

                                        <th style="width: 85px">User Platform</th>

                                        <th style="width: 85px">Last Activity Date</th>

                                        <th style="width: 115px">Activity in the last 0-30 days</th>
                                        <th style="width: 115px">Activity in the last 31-90 days</th>
                                        <th style="width: 115px">Shared Photos in the last 0-30 days</th>
                                        <th style="width: 115px">Shared Photos in the last 31-90 days</th>

                                        <th style="width: 130px">City</th>
                                        <th style="width: 130px">State</th>
                                        <th style="width: 150px">Country</th>

                                        <th style="width: 95px">Last In-App Purchase Date</th>
                                        <th style="width: 90px">In-App Purchase Type</th>
                                        <th style="width: 90px">Date Last Suspended</th>
                                        <th style="width: 180px">Actions</th>

                                    </tr>

                                    <?php
                                    for($i=0; $i<count($data_list); $i++)
                                    {
                                        ?>

                                        <tr>
                                            <td style="display: none"><?php echo $data_list['userid']; ?></td>
                                            <td><?php echo ($offset + $i + 1); ?></td>

                                            <td><?php echo $data_list[$i]['firstname']; ?></td>
                                            <td><?php echo $data_list[$i]['lastname']; ?></td>

                                            <td><?php echo $data_list[$i]['email']; ?></td>
                                            <td><?php echo $data_list[$i]['pin']; ?></td>

                                            <td><?php echo $data_list[$i]['accountcreatedate']; ?></td>
                                            <td>
                                                <?php
                                                if ($data_list[$i]['accounttype'] == 0) {
                                                    echo "Free";
                                                }
                                                else if ($data_list[$i]['accounttype'] == 1) {
                                                    echo "+2,000";
                                                }
                                                else if ($data_list[$i]['accounttype'] == 2) {
                                                    echo "+5,000";
                                                }
                                                else if ($data_list[$i]['accounttype'] == 3) {
                                                    echo "+10,000";
                                                }
                                                else if ($data_list[$i]['accounttype'] == 4) {
                                                    echo "Unlimit";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($data_list[$i]['accountstatus'] == 0) {
                                                    echo "Pending";
                                                }
                                                else if ($data_list[$i]['accountstatus'] == 1) {
                                                    echo "Active";
                                                }
                                                else if ($data_list[$i]['accountstatus'] == 2) {
                                                    echo "Suspended";
                                                }
                                                ?>
                                            </td>

                                            <td><?php echo $data_list[$i]['totalphoto']; ?></td>
                                            <td><?php echo $data_list[$i]['totalfriends']; ?></td>

                                            <td><?php echo $data_list[$i]['deviceplatform']; ?></td>

                                            <td><?php echo $data_list[$i]['lastlogindate']; ?></td>

                                            <td><?php echo $data_list[$i]['last30dayslogincount']; ?></td>
                                            <td><?php echo $data_list[$i]['last90dayslogincount']; ?></td>
                                            <td><?php echo $data_list[$i]['last30daysphotocount']; ?></td>
                                            <td><?php echo $data_list[$i]['last90daysphotocount']; ?></td>

                                            <td><?php echo $data_list[$i]['city']; ?></td>
                                            <td><?php echo $data_list[$i]['state']; ?></td>
                                            <td><?php echo $data_list[$i]['country']; ?></td>

                                            <td><?php echo $data_list[$i]['iaplastdate']; ?></td>
                                            <td>
                                                <?php
                                                if ($data_list[$i]['iaptype'] == 0) {
                                                    echo "Free";
                                                }
                                                else if ($data_list[$i]['iaptype'] == 1) {
                                                    echo "+2,000";
                                                }
                                                else if ($data_list[$i]['iaptype'] == 2) {
                                                    echo "+5,000";
                                                }
                                                else if ($data_list[$i]['iaptype'] == 3) {
                                                    echo "+10,000";
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $data_list[$i]['accountsuspenddate']; ?></td>

                                            <td style="padding-top: 1px; padding-bottom: 0px; text-align: center;">
                                                <?php
                                                if ($data_list[$i]['accountstatus'] == 0) // Pending
                                                {
                                                ?>
                                                <a class="btn btn-sm btn-white btn-action" onclick="on_accept('<?php echo $data_list[$i]['userid']; ?>', '<?php echo $data_list[$i]['firstname']; ?>', '<?php echo $data_list[$i]['lastname']; ?>');" data-toggle="tooltip" data-placement="bottom" title="Accept" <?php if ($this->session->userdata('login_permission') == 0) echo "disabled"; ?>><img src="<?php echo base_url();?>inspinia_admin/img/icon/accept.png"></a>
                                                <a class="btn btn-sm btn-white btn-action" onclick="on_reject('<?php echo $data_list[$i]['userid']; ?>', '<?php echo $data_list[$i]['firstname']; ?>', '<?php echo $data_list[$i]['lastname']; ?>');" data-toggle="tooltip" data-placement="bottom" title="Reject" <?php if ($this->session->userdata('login_permission') == 0) echo "disabled"; ?>><img src="<?php echo base_url();?>inspinia_admin/img/icon/reject.png"></a>
                                                <?php
                                                }
                                                else if ($data_list[$i]['accountstatus'] == 1) // Active
                                                {
                                                ?>

                                                <a class="btn btn-sm btn-white btn-action" onclick="on_suspend('<?php echo $data_list[$i]['userid']; ?>', '<?php echo $data_list[$i]['firstname']; ?>', '<?php echo $data_list[$i]['lastname']; ?>');" data-toggle="tooltip" data-placement="bottom" title="Suspend" <?php if ($this->session->userdata('login_permission') == 0) echo "disabled"; ?>><img src="<?php echo base_url();?>inspinia_admin/img/icon/suspend.png"></a>
                                                <a class="btn btn-sm btn-white btn-action" onclick="on_delete('<?php echo $data_list[$i]['userid']; ?>', '<?php echo $data_list[$i]['firstname']; ?>', '<?php echo $data_list[$i]['lastname']; ?>');" data-toggle="tooltip" data-placement="bottom" title="Delete" <?php if ($this->session->userdata('login_permission') == 0) echo "disabled"; ?>><img src="<?php echo base_url();?>inspinia_admin/img/icon/delete.png"></a>
                                                <?php
                                                }
                                                else if ($data_list[$i]['accountstatus'] == 2) // Suspended
                                                {
                                                ?>
                                                <a class="btn btn-sm btn-white btn-action" onclick="on_unsuspend('<?php echo $data_list[$i]['userid']; ?>', '<?php echo $data_list[$i]['firstname']; ?>', '<?php echo $data_list[$i]['lastname']; ?>');" data-toggle="tooltip" data-placement="bottom" title="Unsuspend" <?php if ($this->session->userdata('login_permission') == 0) echo "disabled"; ?>><img src="<?php echo base_url();?>inspinia_admin/img/icon/accept.png"></a>
                                                <a class="btn btn-sm btn-white btn-action" onclick="on_delete('<?php echo $data_list[$i]['userid']; ?>', '<?php echo $data_list[$i]['firstname']; ?>', '<?php echo $data_list[$i]['lastname']; ?>');" data-toggle="tooltip" data-placement="bottom" title="Delete" <?php if ($this->session->userdata('login_permission') == 0) echo "disabled"; ?>><img src="<?php echo base_url();?>inspinia_admin/img/icon/delete.png"></a>
                                                <?php
                                                }
                                                ?>

                                                <a class="btn btn-sm btn-white btn-action" onclick="on_changetype('<?php echo $data_list[$i]['userid']; ?>', '<?php echo $data_list[$i]['firstname']; ?>', '<?php echo $data_list[$i]['lastname']; ?>', '<?php echo $data_list[$i]['accounttype']; ?>');" data-toggle="tooltip" data-placement="bottom" title="Change type" <?php if ($this->session->userdata('login_permission') == 0) echo "disabled"; ?>><img src="<?php echo base_url();?>inspinia_admin/img/icon/change-account.png"></a>
                                                <a class="btn btn-sm btn-white btn-action" onclick="on_download('<?php echo $data_list[$i]['userid']; ?>', '<?php echo $data_list[$i]['firstname']; ?>', '<?php echo $data_list[$i]['lastname']; ?>');" data-toggle="tooltip" data-placement="bottom" title="Download photos" <?php if ($this->session->userdata('login_permission') == 0) echo "disabled"; ?>><img src="<?php echo base_url();?>inspinia_admin/img/icon/download.png"></a>

                                            </td>
                                        </tr>

                                    <?php
                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col col-lg-2">
                                    <button class="btn btn-sm btn-primary" style="margin-top: 20px" onclick="on_export()">Export to CSV</button>
                                </div>
                                <div class="col col-lg-10">
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

<script type="text/javascript">

    function on_accept(userid, firstname, lastname)
    {
        open_confirm('accept', "Please confirm if you would like to accept \"" + firstname + " " + lastname + "\" for a KinPix Account?", 'do_accept', userid);
    }

    function do_accept(userid)
    {
        location.href="<?php echo site_url('admin/accept_user/'); ?>" + "/" + userid;
    }

    function on_reject(userid, firstname, lastname)
    {
        open_confirm('reject', "Please confirm if you would like to reject \"" + firstname + " " + lastname + "\" for a KinPix Account?", 'do_reject', userid);
    }

    function do_reject(userid)
    {
        location.href="<?php echo site_url('admin/reject_user/'); ?>" + "/" + userid;
    }

    function on_delete(userid, firstname, lastname)
    {
        open_confirm('delete', "Please confirm if you would like to remove \"" + firstname + " " + lastname + "\" for a KinPix Account?", 'do_delete', userid);
    }

    function do_delete(userid)
    {
        location.href="<?php echo site_url('admin/delete_user/'); ?>" + "/" + userid;
    }

    function on_suspend(userid, firstname, lastname)
    {
        open_confirm('suspend', "Please confirm if you would like to suspend \"" + firstname + " " + lastname + "\" for a KinPix Account?", 'do_suspend', userid);
    }

    function do_suspend(userid)
    {
        location.href="<?php echo site_url('admin/suspend_user/'); ?>" + "/" + userid;
    }

    function on_unsuspend(userid, firstname, lastname)
    {
        open_confirm('unsuspend', "Please confirm if you would like to unsuspend \"" + firstname + " " + lastname + "\" for a KinPix Account?", 'do_unsuspend', userid);
    }

    function do_unsuspend(userid)
    {
        location.href="<?php echo site_url('admin/unsuspend_user/'); ?>" + "/" + userid;
    }

    function on_download(userid, firstname, lastname)
    {
        open_confirm('download', "Please confirm if you would like to download all photos of \"" + firstname + " " + lastname + "\"", 'do_download', userid);
    }

    function do_download(userid)
    {

    }

    function on_cancel()
    {
        $('#modal-form').modal('hide');
    }

    function on_changetype(userid, firstname, lastname, accounttype)
    {
        $('#account_id').val(userid);
        $('#account_name').html(firstname + ' ' + lastname);
        $('#account_type').val(accounttype);

        $('#modal-form').modal('show');
    }

    function do_changetype()
    {
        $('#modal-form').modal('hide');

        $.ajax({
            async: true,
            url: "<?php echo site_url('admin/change_usertype') ?>",
            dataType: "json",
            type: "POST",
            data: {
                userid: $('#account_id').val(),
                usertype: $('#account_type').val()
            },
            success: function(json) {

                location.href="<?php echo site_url('admin/search_user/'); ?>" + "/" + <?php echo $offset; ?>;
            },
            error: function(xhr, errStr) {
                //    alert(errStr);
            }
        });
    }

    function on_export()
    {
        location.href="<?php echo site_url('admin/export_csv'); ?>";
    }

    $(document).ready(function() {
        $('#modal-confirm').on('hidden.bs.modal', function(e) {

            if ($('#modal-return').val() == '1')
            {
                var callback_func = $('#modal-callback').val();
                var callback_param = $('#modal-param').val();

                window[callback_func](callback_param);
            }
        });
    });

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