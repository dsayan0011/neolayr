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
    <img src="" class="header-img" style="margin-top:-3px;"> Video Review</h1>
<hr>

<div id="products">

<?php if ($this->session->flashdata('success')) { ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php } ?>
<div class="row">
        <div class="col-xs-12">
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>SKU</th>
                <th width="60%">Link</th>
                <th>Title</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($allProduct)) {
                foreach ($allProduct as $code) {
                        $review = $this->Discounts_model->getVideoReview($code['sku']);
                    ?>
                    <tr> 
                        <td><?= $code['sku'] ?></td>
                        <td><?= $review['video_review_link'] ?></td>
                        <td><?= $review['video_title'] ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('admin/video_review/edit/' . $code['sku']) ?>" class="btn btn-primary ">Edit</a>
                            <?php if($review['video_review_link'] != ''){?>
                            <a href="<?= base_url('admin/video_review?delete=' .$code['sku']) ?>"  class="btn btn-danger  confirm-delete">Delete</a>
                        <?php } ?>
                        
                        </td>
                    
                    </tr> 
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="6">No Video Review Available</td> 
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
