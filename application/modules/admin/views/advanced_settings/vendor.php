<div id="users">
    <h1><img src="<?= base_url('assets/imgs/admin-user.png') ?>" class="header-img" style="margin-top:-3px;">Vendors</h1> 
    <hr>
    <?php if (validation_errors()) { ?>
        <hr>
        <div class="alert alert-danger"><?= validation_errors() ?></div>
        <hr>
        <?php
    }
    if ($this->session->flashdata('result_add')) {
        ?>
        <hr>
        <div class="alert alert-warning"><?= $this->session->flashdata('result_add') ?></div>
        <hr>
        <?php
    }
    if ($this->session->flashdata('result_delete')) {
        ?>
        <hr>
        <div class="alert alert-success"><?= $this->session->flashdata('result_delete') ?></div>
        <hr>
        <?php
    }
    ?>
    <a href="<?= LANG_URL . '/admin/addVendor' ?>" class="btn btn-primary btn-xs pull-right" style="margin-bottom:10px;"><b>+</b> Add new user</a>
    <div class="clearfix"></div>
    <?php
    if ($users->result()) {
        ?>
        <div class="table-responsive">
            <table class="table table-striped custab">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Nickname</th>
                        <th>Vendor Name</th>
                        <th>Warehouse Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <?php foreach ($users->result() as $user) {
					 ?>
                    <tr>
                        <td><?= $user->id ?></td>
                        <td><?= $user->nickname ?></td>
                        <td><?= $user->name ?></td>
                        <td><?= $user->warehouse_name ?></td>
                        <td><?= $user->phone ?></td>
                        <td><?= $user->email ?></td>
                        <td><?= $user->address.",City - ".$user->city_name.",State - ".$user->state_name.", Pincode - ".$user->pincode ?></td>
                        <td><?= $user->vendor_status ?></td>
                        <td class="text-center">
                            <div>
                            	<a href="<?= LANG_URL . '/admin/syncVendor' ?>/<?= $user->id ?>">Sync Address</a> | 
                                <a href="?delete=<?= $user->id ?>" class="confirm-delete">Delete</a> | 
                                <a href="<?= LANG_URL . '/admin/editVendor' ?>/<?= $user->id ?>">Edit</a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    <?php } else { ?>
        <div class="clearfix"></div><hr>
        <div class="alert alert-info">No users found!</div>
    <?php } ?>

</div>
<script>
<?php if (isset($_GET['edit'])) { ?>
        $(document).ready(function () {
            $("#add_edit_users").modal('show');
        });
<?php } ?>
</script>