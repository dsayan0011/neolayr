<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;">Add Banner</h1>
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
   <!--  <div class="form-group for-shop">
                <label>Title</label>
                <input type="text" name="banner_title" placeholder="Title" value="<?= @$_POST['banner_title'] ?>" class="form-control">
     </div> -->
    <div class="form-group bordered-group">
        <?php
        if (isset($_POST['banner_image']) && $_POST['banner_image'] != null) {
            $image = 'attachments/banner_images/' . $_POST['banner_image'];
            if (!file_exists($image)) {
                $image = 'attachments/no-image.png';
            }
            ?>
            <p>Current image:</p>
            <div>
                <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
            </div>
            <input type="hidden" name="old_image" value="<?= $_POST['banner_image'] ?>">
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="image" value="<?= $_POST['banner_image'] ?>">
                <?php
            }
        }
        ?>
        <label for="userfile">Banner Image for Web</label>
        <input type="file" id="userfile" name="userfile">
    </div>

    <div class="form-group bordered-group">
        <?php
        if (isset($_POST['banner_image_mob']) && $_POST['banner_image_mob'] != null) {
            $image = 'attachments/banner_images/' . $_POST['banner_image_mob'];
            if (!file_exists($image)) {
                $image = 'attachments/no-image.png';
            }
            ?>
            <p>Current image:</p>
            <div>
                <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
            </div>
            <input type="hidden" name="old_mob_image" value="<?= $_POST['banner_image_mob'] ?>">
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="banner_image_mob" value="<?= $_POST['banner_image_mob'] ?>">
                <?php
            }
        }
        ?>
        <label for="userfile">Banner Image for Mobile</label>
        <input type="file" id="mobuserfile" name="mobuserfile">
    </div>

    <div class="form-group for-shop">
        <label>Status</label>
        <select class="selectpicker" name="status">
            <option value="active" <?= isset($_POST['status']) && $_POST['status'] == 'active' ? 'selected' : '' ?>>Active</option>
            <option value="inactive" <?= isset($_POST['status']) && $_POST['status'] == 'inactive' || !isset($_POST['status']) ? 'selected' : '' ?>>Inactive</option>
        </select>
    </div>
    <div class="form-group for-shop">
        <label>Banner Link for</label>
        <select class="selectpicker" name="link_for" id="link_for">
            <option value="ingredient" <?= isset($_POST['link_for']) && $_POST['link_for'] == 'ingredient' ? 'selected' : '' ?>>Ingredient</option>
            <option value="pdp" <?= isset($_POST['link_for']) && $_POST['link_for'] == 'pdp' ? 'selected' : '' ?>>PDP</option>
            <option value="plp" <?= isset($_POST['link_for']) && $_POST['link_for'] == 'plp' ? 'selected' : '' ?>>PLP</option>
        </select>
    </div>
    <div class="form-group for-pdp" style="<?= isset($_POST['banner_link_pdp']) && $_POST['banner_link_pdp'] != '' ? '' : 'display: none' ?>">
                <label>Banner Link for PDP</label>
                <input type="text" name="banner_link_pdp" placeholder="Banner Link" value="<?= @$_POST['banner_link_pdp'] ?>" class="form-control" >
     </div>
     <div class="form-group for-plp" style="<?= isset($_POST['banner_link_plp']) && $_POST['banner_link_plp'] != '' ? '' : 'display: none' ?>">
                <label>Banner Link for PLP</label>
                <input type="text" name="banner_link_plp" placeholder="Banner Link" value="<?= @$_POST['banner_link_plp'] ?>" class="form-control" >
     </div>
    <button type="submit" name="submit" class="btn btn-lg btn-default">Publish</button>
</form>

<script type="text/javascript">
      $(document).ready(function(){
        $('#link_for').on('change', function(){ 
            if($(this).val() == 'pdp'){
                 //console.log("pdp");
                 $(".for-pdp").show();
                 $(".for-plp").hide();
            }
            if($(this).val() == 'plp'){
                //console.log("plp");
                $(".for-pdp").hide();
                $(".for-plp").show();
            }
            if($(this).val() == 'ingredient'){
                //console.log("plp");
                $(".for-pdp").hide();
                $(".for-plp").hide();
            }
        })
        });
</script>
