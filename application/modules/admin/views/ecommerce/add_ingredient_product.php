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
                <label>Title</label>
                <input type="text" name="title" placeholder="Title" value="<?= @$_POST['title'] ?>" class="form-control" required>
     </div>
     <div class="form-group bordered-group">
        <?php
        if (isset($_POST['ingredientImage']) && $_POST['ingredientImage'] != null) {
            $image = 'attachments/ingredientImages/' . $_POST['ingredientImage'];
            if (!file_exists($image)) {
                $image = 'attachments/no-image.png';
            }
            ?>
            <p>Current image:</p>
            <div>
                <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
            </div>
            <input type="hidden" name="old_image" value="<?= $_POST['ingredientImage'] ?>">
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="image" value="<?= $_POST['ingredientImage'] ?>">
                <?php
            }
        }
        ?>
        <label for="userfile">Ingredient Image</label>
        <input type="file" id="userfile" name="userfile">
    </div>
     <div class="form-group">
        <label>Ingredients</label>                        
        <select class="selectpicker form-control show-tick show-menu-arrow" name="ingredientsID" id="ingredientsID" required>
            <option value="" <?= isset($_POST['ingredients_id']) && $_POST['ingredients_id'] == '' ? 'selected' : '' ?> class="<?= isset($_POST['ingredients_id']) ? 'offerTypeDisabled' : 'offerTypeDisabled' ?>">Please Select Offer Type</option>
            <?php foreach ($allIngredient as $item) { ?>                          
                    <option <?= isset($_POST['ingredients_id']) && ($item['ingredientsID'] == $_POST['ingredients_id']) ? 'selected="selected"' : '' ?> value="<?= $item['ingredientsID'] ?>">
                       <?php echo $item['ingredientsTitle']; ?>
                    </option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label>Product</label>                        
        <select class="selectpicker form-control show-tick show-menu-arrow" name="product_sku[]" multiple="multiple">
                <?php foreach ($allProduct as $product) {
                 //    if(($_POST['id'] != $product['id']) && ($product['sku'] != '')) {
                 // ?>

                    <option <?php if(isset($_POST['product_sku']) && in_array($product['sku'],$productBought)) echo 'selected'; ?> value="<?= $product['sku'] ?>"><?= $product['sku'] ?></option>
                <?php  } ?>
            </select>
    </div>
     <div class="form-group for-shop">
                <label>Short Description</label>
                <input type="text" name="shortDescription" placeholder="Short Description" value="<?= @$_POST['shortDescription'] ?>" class="form-control" required>
     </div>
    <div class="form-group for-shop">
      <label for="userfile">Long Description</label>
      <textarea name="longDescription" id="longDescription" rows="50" class="form-control"><?= $trans_load != null && isset($trans_load[$language->abbr]['longDescription']) ? $trans_load[$language->abbr]['longDescription'] : '' ?><?php echo @$_POST['longDescription']; ?></textarea>
      <script>
         CKEDITOR.replace('longDescription');
         CKEDITOR.config.entities = false;
      </script>
   </div>
 <div class="form-group for-shop">
        <label>Status</label>
        <select class="selectpicker" name="status">
            <option value="Active" <?= isset($_POST['status']) && $_POST['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
            <option value="Inactive" <?= isset($_POST['status']) && $_POST['status'] == 'Inactive' || !isset($_POST['status']) ? 'selected' : '' ?>>Inactive</option>
        </select>
    </div>
    <button type="submit" name="submit" class="btn btn-lg btn-default">Publish</button>
</form>
