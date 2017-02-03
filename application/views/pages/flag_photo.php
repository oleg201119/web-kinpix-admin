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
                            <h5>Flagged Photos</h5>
                        </div>

                        <div class="ibox-content">

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

                            <div class=" tooltip-demo photo_table_wrapper">
                                <table class="table table-bordered" style="margin-bottom: 0px;" id="photo_table">
                                    <tbody id="users_body">

                                    <tr>
                                        <th>#</th>

                                        <th>Accuser</th>
                                        <th>Photo</th>
                                        <th>Photo Owner</th>

                                        <th>Accused Date</th>

                                        <th>Actions</th>
                                    </tr>

                                    <?php
                                    for($i=0; $i<count($data_list); $i++)
                                    {
                                        ?>

                                        <tr>
                                            <td style="display: none"><?php echo $data_list['photoid']; ?></td>
                                            <td style="vertical-align: middle; text-align: center;"><?php echo ($offset + $i + 1); ?></td>

                                            <td style="vertical-align: middle; text-align: center;">
                                                <?php echo $data_list[$i]['flagfirstname'] . " " . $data_list[$i]['flaglastname']; ?>
                                            </td>
                                            <td style="vertical-align: middle; text-align: center; padding: 5px;">
                                                <a class="fancybox" href="<?php echo $data_list[$i]['photourl']; ?>">
                                                    <img src="<?php echo $data_list[$i]['thumburl']; ?>" style="width: 100px; height: 100px; margin-bottom: 0px;">
                                                </a>
                                            </td>

                                            <td style="vertical-align: middle; text-align: center;">
                                                <?php echo $data_list[$i]['ownfirstname'] . " " . $data_list[$i]['ownlastname']; ?>
                                            </td>

                                            <td style="vertical-align: middle; text-align: center;"><?php echo $data_list[$i]['flagdate']; ?></td>

                                            <td style="padding-top: 1px; padding-bottom: 0px; text-align: center; vertical-align: middle;">
                                                <a class="btn btn-sm btn-white btn-action" onclick="on_ignore('<?php echo $data_list[$i]['photoid']; ?>');" data-toggle="tooltip" data-placement="bottom" title="Ignore" <?php if ($this->session->userdata('login_permission') == 0) echo "disabled"; ?>><img src="<?php echo base_url();?>inspinia_admin/img/icon/ignore.png"></a>
                                                <a class="btn btn-sm btn-white btn-action" onclick="on_delete('<?php echo $data_list[$i]['photoid']; ?>');" data-toggle="tooltip" data-placement="bottom" title="Delete" <?php if ($this->session->userdata('login_permission') == 0) echo "disabled"; ?>><img src="<?php echo base_url();?>inspinia_admin/img/icon/delete.png"></a>
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

    function on_delete(photoid)
    {
        open_confirm('delete', "Please confirm if you would like to remove this photo", 'do_delete', photoid);
    }

    function do_delete(photoid)
    {
        location.href="<?php echo site_url('admin/delete_photo/'); ?>" + "/" + photoid;
    }

    function on_ignore(photoid)
    {
        open_confirm('ignore', "Please confirm if you would like to ignore this accusation", 'do_ignore', photoid);
    }

    function do_ignore(photoid)
    {
        location.href="<?php echo site_url('admin/ignore_accusation/'); ?>" + "/" + photoid;
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