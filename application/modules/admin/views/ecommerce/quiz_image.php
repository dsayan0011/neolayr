<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;">Quiz Image</h1>
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
        if (isset($_POST['quiz_image']) && $_POST['quiz_image'] != null) {
            $image = 'attachments/quiz/' . $_POST['quiz_image'];
            if (!file_exists($image)) {
                $image = 'attachments/no-image.png';
            }
            ?>
            <p>Current image:</p>
            <div>
                <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
            </div>
            <input type="hidden" name="old_image" value="<?= $_POST['quiz_image'] ?>">
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="image" value="<?= $_POST['quiz_image'] ?>">
                <?php
            }
        }
        ?>
        <label for="userfile"> Image</label>
        <input type="file" id="userfile" name="userfile">
    </div>

   
    <button type="submit" name="submit" class="btn btn-lg btn-default">Publish</button>
</form>
