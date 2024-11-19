<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;">Add Store</h1>
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
                <label>Store Name</label>
                <input type="text" name="store_name" placeholder="Store Name" value="<?= @$_POST['store_name'] ?>" class="form-control" required>
     </div>
    <div class="form-group for-shop">
                <label>Store City</label>
                <input type="text" name="store_city" placeholder="Store City" value="<?= @$_POST['store_city'] ?>" class="form-control" required>
     </div>
     <div class="form-group for-shop">
                <label>Store State</label>
                <input type="text" name="store_state" placeholder="Store State" value="<?= @$_POST['store_state'] ?>" class="form-control" required>
     </div>
     <div class="form-group for-shop">
                <label>Store latitude</label>
                <input type="text" name="store_latitude" placeholder="Store latitude" value="<?= @$_POST['store_latitude'] ?>" class="form-control" required>
     </div>
     <div class="form-group for-shop">
                <label>Store longitude</label>
                <input type="text" name="store_longitude" placeholder="Store State" value="<?= @$_POST['store_longitude'] ?>" class="form-control" required>
     </div>
     <div class="form-group for-shop">
                <label>Store Pincode</label>
                <input type="text" name="store_pincode" placeholder="Store State" value="<?= @$_POST['store_pincode'] ?>" class="form-control" required>
     </div>
      <div class="form-group for-shop">
                <label>Store Address</label>
                <textarea class="form-control" name="store_address" placeholder="Store Address" required><?php  echo $_POST['store_address'];?></textarea>
     </div>

    <div class="form-group for-shop">
        <label>Status</label>
        <select class="selectpicker" name="store_status">
            
            <option value="active" <?= isset($_POST['store_status']) && $_POST['store_status'] == 'active' ? 'selected' : '' ?>>Active</option>
            <option value="inactive" <?= isset($_POST['store_status']) && $_POST['store_status'] == 'inactive' || !isset($_POST['store_status']) ? 'selected' : '' ?>>Inactive</option>
        </select>
    </div>
    
    <button type="submit" name="submit" class="btn btn-lg btn-default">Publish</button>
</form>
