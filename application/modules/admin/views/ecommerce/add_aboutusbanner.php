<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;">Add About Us Banner</h1>
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
    
    
    <div class="form-group bordered-group">
        <?php
        if (isset($_POST['image']) && $_POST['image'] != null) {
            $image = 'attachments/aboutUsBanner/' . $_POST['image'];
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
        <label for="userfile"> Web Image</label>
        <input type="file" id="userfile" name="userfile">
    </div>

   <div class="form-group bordered-group">
        <?php
        if (isset($_POST['mob_image']) && $_POST['mob_image'] != null) {
            $image = 'attachments/aboutUsBanner/' . $_POST['mob_image'];
            if (!file_exists($image)) {
                $image = 'attachments/no-image.png';
            }
            ?>
            <p>Current image:</p>
            <div>
                <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
            </div>
            <input type="hidden" name="old_mob_image" value="<?= $_POST['mob_image'] ?>">
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="mob_image" value="<?= $_POST['mob_image'] ?>">
                <?php
            }
        }
        ?>
        <label for="mobImage"> Mobile Image</label>
        <input type="file" id="mobImage" name="mobImage">
    </div>

    <button type="submit" name="submit" class="btn btn-lg btn-default">Publish</button>
</form>
