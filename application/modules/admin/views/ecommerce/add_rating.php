<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;">Add Ingredient</h1>
<style type="text/css">
    .offerTypeDisabled{
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
                <label>User Name</label>
                <input type="text" name="user_name" placeholder="User Name" value="<?= @$_POST['user_id'] ?>" class="form-control" required>
     </div>
    <div class="form-group for-shop">
                <label>Rating(Between 1 and 5)</label>
                <input type="number" name="rating" placeholder="Rating" value="<?= @$_POST['rating'] ?>" class="form-control" required min="1" max="5">
     </div>
     
     
    <div class="form-group">
        <label>Product SKU</label>                        
        <select class="selectpicker form-control show-tick show-menu-arrow" name="product_id">
            <option value="">Please select Product</option>
                <?php foreach ($allProduct as $product) {
                 //    if(($_POST['id'] != $product['id']) && ($product['sku'] != '')) {
                 // ?>
                    

                    <option <?= isset($_POST['product_id']) && ($product['id'] == $_POST['product_id']) ? 'selected="selected"' : '' ; ?> value="<?= $product['id'] ?>"><?= $product['sku'] ?></option>

                    
                <?php  } ?>
            </select>
    </div>
    
    <div class="form-group for-shop">
      <label for="userfile">Comment</label>
      <textarea name="comment" id="comment" rows="50" class="form-control"><?= $trans_load != null && isset($trans_load[$language->abbr]['comment']) ? $trans_load[$language->abbr]['comment'] : '' ?><?php echo @$_POST['comment']; ?></textarea>
      <script>
         CKEDITOR.replace('comment');
         CKEDITOR.config.entities = false;
      </script>
   </div>
 <!-- <div class="form-group for-shop">
        <label>Status</label>
        <select class="selectpicker" name="status">
            <option value="Active" <?= isset($_POST['status']) && $_POST['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
            <option value="Inactive" <?= isset($_POST['status']) && $_POST['status'] == 'Inactive' || !isset($_POST['status']) ? 'selected' : '' ?>>Inactive</option>
        </select>
    </div> -->
    <button type="submit" name="submit" class="btn btn-lg btn-default">Publish</button>
</form>
