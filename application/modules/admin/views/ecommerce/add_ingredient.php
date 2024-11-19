<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;">Add Ingredient</h1>
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
                <input type="text" name="ingredientsTitle" placeholder="Title" value="<?= @$_POST['ingredientsTitle'] ?>" class="form-control" required>
     </div>
   <!--  <div class="form-group for-shop">
      <label for="userfile">Description</label>
      <textarea name="description" id="description" rows="50" class="form-control"><?= $trans_load != null && isset($trans_load[$language->abbr]['description']) ? $trans_load[$language->abbr]['description'] : '' ?><?php echo @$_POST['description']; ?></textarea>
      <script>
         CKEDITOR.replace('description');
         CKEDITOR.config.entities = false;
      </script>
   </div> -->

    <div class="form-group for-shop">
        <label>Status</label>
        <select class="selectpicker" name="status">
            <option value="Active" <?= isset($_POST['status']) && $_POST['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
            <option value="Inactive" <?= isset($_POST['status']) && $_POST['status'] == 'Inactive' || !isset($_POST['status']) ? 'selected' : '' ?>>Inactive</option>
        </select>
    </div>
    <button type="submit" name="submit" class="btn btn-lg btn-default">Publish</button>
</form>
