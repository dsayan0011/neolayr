<div id="users">
    <h1><img src="<?= base_url('assets/imgs/admin-user.png') ?>" class="header-img" style="margin-top:-3px;">Pickup Location</h1> 
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
     <a href="<?= LANG_URL . '/admin/addpickuplocation' ?>" class="btn btn-primary btn-xs pull-right" style="margin-bottom:10px;"><b>+</b> Add new location</a>
    <div class="clearfix"></div>
    <?php
    if ($locations->result()) {
        ?>
        <div class="table-responsive">
            <table class="table table-striped custab">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Warehouse Name</th>
                        <th>Address</th>
                         <th>Pincode</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <?php foreach ($locations->result() as $location) {
					 ?>
                    <tr>
                        <td><?= $location->id ?></td>
                        <td><?= $location->name ?></td>
                        <td><?= $location->warehouse_name ?></td>
                        <td><?= $location->address.",City - ".$location->city_name.",State - ".$location->state_name ?></td>
                        <td><?= $location->pincode ?></td>
                        <td><?= $location->location_status ?></td>
                        <td class="text-center">
                            <div>
                                <a href="?delete=<?= $location->id ?>" class="confirm-delete">Delete</a> | 
                                <a href="<?= LANG_URL . '/admin/editpickuplocation' ?>/<?= $location->id ?>">Edit</a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    <?php } else { ?>
        <div class="clearfix"></div><hr>
        <div class="alert alert-info">No Location found!</div>
    <?php } ?>

</div>
<script>
<?php if (isset($_GET['edit'])) { ?>
        $(document).ready(function () {
            $("#add_edit_users").modal('show');
        });
<?php } ?>
</script>