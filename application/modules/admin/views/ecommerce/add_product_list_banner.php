<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;">Add Product List Banner</h1>
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
    <input type="hidden" value="<?= isset($_POST['folder']) ? $_POST['folder'] : $timeNow ?>" name="folder">
    <div class="form-group for-shop">
                <label>Title</label>
                <input type="text" name="title" placeholder="Title" value="<?= @$_POST['title'] ?>" class="form-control">
     </div>
    <div class="form-group for-shop">
                <label>Category</label>
                <!-- <input type="text" name="category" placeholder="Category" value="<?= @$_POST['category'] ?>" class="form-control" required> -->
                <select class="selectpicker form-control show-tick show-menu-arrow" name="category" id="category" required>
                <option value="" <?= isset($_POST['category']) && $_POST['category'] == '' ? 'selected' : '' ?> class="<?= isset($_POST['category']) ? 'offerTypeDisabled' : 'offerTypeDisabled' ?>">Please Select Category </option>
                <?php foreach ($categoryList as $item) { ?>                          
                        <option <?= isset($_POST['category']) && ($item['category_slug'] == $_POST['category']) ? 'selected="selected"' : '' ?> value="<?= $item['category_slug'] ?>">
                           <?php echo $item['name']; ?>
                        </option>
                <?php } ?>
            </select>
     </div>
    <div class="form-group bordered-group">
        <?php
        if (isset($_POST['image']) && $_POST['image'] != null) {
            $image = 'attachments/product_listing/' . $_POST['image'];
            if (!file_exists($image)) {
                $image = 'attachments/no-image.png';
            }
            ?>
            <p>Current image:</p>
            <div>
                <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
            </div>
            <input type="hidden" name="old_image" value="<?= $_POST['image'] ?>">
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="image" value="<?= $_POST['image'] ?>">
                <?php
            }
        }
        ?>
        <label for="userfile"> Image</label>
        <input type="file" id="userfile" name="userfile">
    </div>

   
    <button type="submit" name="submit" class="btn btn-lg btn-default">Publish</button>
</form>
