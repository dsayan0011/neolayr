<link href="<?= base_url('assets/css/bootstrap-toggle.min.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/bootstrap-datepicker.min.css') ?>" rel="stylesheet">
<style type="text/css">
    .offerTypeDisabled{
        cursor: none;
        pointer-events: none;
    }
    .bestSeller{
        display: none;
    }
    .catagory{
        display: none;
    }
</style>
<h1>
    <img src="" class="header-img" style="margin-top:-3px;"> Ratings</h1>
<hr>
<div style="margin-bottom: 20px;">    
    <form method="POST" action="" class="pull-right">
        <label>Ratings</label>
        <input type="hidden" name="showRating" value="<?= $showRating ?>">
        <input <?= $showRating == 1 ? 'checked' : '' ?> data-toggle="toggle" data-for-field="showRating" class="toggle-changer" type="checkbox">
        <button class="btn btn-default" value="" type="submit">
            Save
        </button>
    </form>
    <div class="clearfix"></div>
</div>
<div id="products">
<a href="<?= base_url('admin/rating/add') ?>" class="btn btn-primary btn-xs pull-right" style="margin-bottom:10px;"><b>+</b> Add Review</a>
<?php if ($this->session->flashdata('success')) { ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php } ?>
<div class="row">
        <div class="col-xs-12">
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>User Name</th>
                <th>Product</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Created Date</th>
                <!-- <th>Status</th> -->
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($starRating)) {
                foreach ($starRating as $code) {
                    if ($code['product_status'] == 'inactive') {
                        $tostatus = 'active';
                    } else {
                        $tostatus = 'inactive';
                    }
                    ?>
                    <tr> 
                        <td><?= $code['user_id'] ?></td>
                        <td><?= $code['product_title'] ?></td>
                        <td><?= $code['product_review_rating'] ?></td>
                        <td><?= $code['comment'] ?></td>
                        <td><?= date("d-m-Y h:i:s a", strtotime($code['created_date']));?></td>
                        
                        <!-- <td class="text-center">
                            <a href="<?= base_url('admin/rating?codeid=' . $code['review_id'] . '&tostatus=' . $tostatus) ?>">
                                <?= $code['product_status'] == 'active' ? '<span class="label label-success">Enabled</span>' : '<span class="label label-danger">Disabled</span>' ?>
                            </a>
                        </td> -->
                        <?php if($code['order_id'] == NULL || $code['order_id'] == ''){?>
                        <td class="text-center">
                            <a href="<?= base_url('admin/rating/edit/' . $code['review_id']) ?>" class="btn btn-primary btn-xs">Edit</a>
                        
                            <a href="<?= base_url('admin/rating?delete=' . $code['review_id']) ?>" class="btn btn-danger confirm-delete btn-xs">Delete</a>
                        </td>
                    <?php } else{ ?>
                        <td colspan="6">Order By User</td> 
                    <?php } ?>
                    </tr> 
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="6">No Rating Available</td> 
                </tr> 
            <?php } ?>
        </tbody>
    </table>
</div>
</div>
</div>
</div>
<?= $links_pagination ?>
<!-- add/edit discounts -->

<script src="<?= base_url('assets/js/bootstrap-datepicker.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap-toggle.min.js') ?>"></script>
<script>
                     
$('.datepicker').datepicker({
    format: "dd.mm.yyyy"
});
                       
</script>
