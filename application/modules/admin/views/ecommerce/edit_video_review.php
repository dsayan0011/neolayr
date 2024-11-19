<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;">Edit Video Review</h1>
<style type="text/css">
    .video_review_sku{
        cursor: none;
    }
    
</style>
<hr>
<?php
$timeNow = time();
if (validation_errors()) {
    ?>
    <hr>
    <div class="alert alert-danger"><?= validation_errors() ?></div>
    <hr>
    <?php
}
if ($this->session->flashdata('result_publish')) {
    ?>
    <hr>
    <div class="alert alert-success"><?= $this->session->flashdata('result_publish') ?></div>
    <hr>
    <?php
}
?>
<form method="POST" action="" enctype="multipart/form-data">
    <div class="form-group for-shop">
                <label>SKU</label>
                <input type="text" id="video_review_sku" name="video_review_sku" placeholder="SKU" value="<?= @$_POST['video_review_sku'] ?>" class="form-control" disabled >
     </div>
     <div class="form-group for-shop">
                <label>Title</label>
                <textarea cols="40" rows="5" name="video_title" wrap=physical class="form-control video_title" value="<?= @$_POST['video_title'] ?>"><?= $_POST['video_title'] ?></textarea>
     </div>
    <div class="form-group for-shop">
                <label>Link</label>
                <textarea cols="40" rows="5" name="video_review_link" wrap=physical class="form-control video_review_link" value="<?= @$_POST['video_review_link'] ?>" required><?= $_POST['video_review_link'] ?></textarea>
                <!-- <textarea name="video_review_link" rows="4" cols="50" class="form-control video_review_sku" value="<?= @$_POST['video_review_link'] ?>"><?= $_POST['video_review_link'] ?>
                </textarea> -->
     </div>
    
 
    <button type="submit" name="submit" class="btn btn-lg btn-default">Publish</button>
</form>
<br>
<p style="color: red; font-size: 15px;">1. Use Comma Separated value for both TITLE & LINK(Without Space)</p>
<p style="color: red; font-size: 15px;">2. Example : Title - Lorem ipsum,Lorem ipsum,,Lorem ipsum</p>
<p style="color: red; font-size: 15px;">3. Example : Link - https://www.youtube.com/embed/m91SBnRxlYQ?si=Rjtwh-dgRWgM-_Hi,https://www.youtube.com/embed/eKFTSSKCzWA?si=0JlLpFnb-y9RRJ9Z,https://www.youtube.com/embed/eKFTSSKCzWA?si=0JlLpFnb-y9RRJ9Z</p>
<p style="color: red; font-size: 15px;">4.Please remember youtube link should be Embed link</p>
<script type="text/javascript">
    //$('textarea[name="video_review_link"]').focus().setSelectionRange(0,0);
</script>
