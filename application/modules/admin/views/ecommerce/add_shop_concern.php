<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;">Add Concern</h1>
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
                <input type="text" name="title" placeholder="Title" value="<?= @$_POST['title'] ?>" class="form-control" required>
     </div>
    <div class="form-group bordered-group">
        <?php
        if (isset($_POST['concernImage']) && $_POST['concernImage'] != null) {
            $image = 'attachments/concern_images/' . $_POST['concernImage'];
            if (!file_exists($image)) {
                $image = 'attachments/no-image.png';
            }
            ?>
            <p>Current image:</p>
            <div>
                <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
            </div>
            <input type="hidden" name="old_image" value="<?= $_POST['concernImage'] ?>">
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="image" value="<?= $_POST['concernImage'] ?>">
                <?php
            }
        }
        ?>
        <label for="userfile">Concern Image</label>
        <input type="file" id="userfile" name="userfile">
    </div>
    <div class="form-group for-shop">
                <label>Category</label>
                <input type="text" name="category" placeholder="Category" value="<?= @$_POST['category'] ?>" class="form-control" required>
     </div>
    <div class="form-group for-shop">
        <label>Status</label>
        <select class="selectpicker" name="status">
            <option value="active" <?= isset($_POST['status']) && $_POST['status'] == 'active' ? 'selected' : '' ?>>Active</option>
            <option value="inactive" <?= isset($_POST['status']) && $_POST['status'] == 'inactive' || !isset($_POST['status']) ? 'selected' : '' ?>>Inactive</option>
        </select>
    </div>
    <button type="submit" name="submit" class="btn btn-lg btn-default">Publish</button>
</form>
