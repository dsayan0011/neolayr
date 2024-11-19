<link href="<?= base_url('assets/css/bootstrap-toggle.min.css') ?>" rel="stylesheet">
<div>
    <h1><img src="<?= base_url('assets/imgs/orders.png') ?>" class="header-img" style="margin-top:-2px;"> Users <?= isset($_GET['settings']) ? ' / Settings' : '' ?></h1>
    <?php if (!isset($_GET['settings'])) { ?>
        <a href="?settings" class="pull-right orders-settings"><i class="fa fa-cog" aria-hidden="true"></i> <span>Settings</span></a>
    <?php } else { ?>
        <a href="<?= base_url('admin/users') ?>" class="pull-right orders-settings"><i class="fa fa-angle-left" aria-hidden="true"></i> <span>Back</span></a>
    <?php } ?>
</div>
<hr>

<?php
    if (!empty($users)) {
        ?>
     <?php /*?>   <div style="margin-bottom:10px;">
            <select class="selectpicker changeOrder">
                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'id' ? 'selected' : '' ?> value="id">Order by new</option>
                <option <?= (isset($_GET['order_by']) && $_GET['order_by'] == 'processed') || !isset($_GET['order_by']) ? 'selected' : '' ?> value="processed">Order by not processed</option>
            </select>
        </div><?php */?>
        <div class="table-responsive">
            <table class="table table-condensed table-bordered table-striped">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Preview</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($users as $tr) {
						 if ($tr['status'] == 'active') {
                            $class = 'bg-success';
                        }
                        if ($tr['status'] == 'inactive') {
                            $class = 'bg-warning';
                        }
                        
                        ?>
                        <tr>
                            <td class="relative" id="order_id-id-<?= $tr['id'] ?>">
                               	<?= $tr['id'] ?>
                                <?php if ($tr['viewed'] == 0) { ?>
                                    <div id="new-user-alert-<?= $tr['id'] ?>">
                                        <img src="<?= base_url('assets/imgs/new-blinking.gif') ?>" style="width:100px;" alt="blinking">
                                    </div>
                                <?php } ?>
                               
                            </td>
                            <td><?= date('d.M.Y / H:i:s', strtotime($tr['created'])); ?></td>
                            <td>
                                <i class="fa fa-user" aria-hidden="true"></i> 
                                <?= $tr['name'] ?>
                            </td>
                            <td><i class="fa fa-phone" aria-hidden="true"></i> <?= $tr['phone'] ?></td>
                            <td><i class="fa fa-envelope" aria-hidden="true"></i> <?= $tr['email'] ?></td>
                            <td class="<?= $class ?> text-center" data-action-id="<?= $tr['id'] ?>">
                                <div class="status" style="padding:5px; font-size:16px;">
                                    -- <b><?= strtoupper($tr['status']) ?></b> --
                                </div>
                                <?php if($tr['status'] == 'active'){?>
                                <div style="margin-bottom:4px;"><a href="javascript:void(0);" onclick="changeUsersStatus(<?= $tr['id'] ?>, 0)" class="btn btn-danger btn-xs">Deactivate User</a></div>
                                <?php }else{?>
                                <div style="margin-bottom:4px;"><a href="javascript:void(0);" onclick="changeUsersStatus(<?= $tr['id'] ?>, 1)" class="btn btn-success btn-xs">Activate User</a></div>
                                <?php } ?>
								
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0);" class="btn btn-default more-info" data-toggle="modal" data-target="#modalPreviewMoreInfo" style="margin-top:10%;" data-more-info="<?= $tr['id'] ?>">
                                    More Info 
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td class="hidden" id="order-id-<?= $tr['id'] ?>">
                                <div class="table-responsive">
                                    <table class="table more-info-purchase">
                                        <tbody>
                                            <tr>
                                                <td><b>Email</b></td>
                                                <td><a href="mailto:<?= $tr['email'] ?>"><?= $tr['email'] ?></a></td>
                                            </tr>
                                            <tr>
                                                <td><b>Name</b></td>
                                                <td><?= $tr['name'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Phone</b></td>
                                                <td><?= $tr['phone'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Address</b></td>
                                                <td><?= $tr['full_address'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Business Name</b></td>
                                                <td><?= $tr['business_name'] ?></td>
                                            </tr>
                                             <tr>
                                                <td><b>Account Type</b></td>
                                                <td><?= $tr['account_type'] ?></td>
                                            </tr>
                                            
                                            <tr>
                                                <td><b>Account Number</b></td>
                                                <td><?= $tr['account_number'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Gender</b></td>
                                                <td><?= $tr['gender'] ?></td>
                                            </tr>
                                           <tr>
                                                <td><b>Selling Experience</b></td>
                                                <td><?= $tr['selling_experience'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Category</b></td>
                                                <td><?= $tr['category'] ?></td>
                                            </tr>
                                              <tr>
                                                <td><b>Medium</b></td>
                                                <td><?= $tr['medium'] ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?= $links_pagination ?>
    <?php } else { ?>
        <div class="alert alert-info">No users at the moment!</div>
    <?php } ?>   
<hr>

<div class="modal fade" id="modalPreviewMoreInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Preview <b id="client-name"></b></h4>
            </div>
            <div class="modal-body" id="preview-info-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/bootstrap-toggle.min.js') ?>"></script>
