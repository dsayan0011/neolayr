<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;">About us</h1>
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
         if (isset($_POST['banner_image']) && $_POST['banner_image'] != null) {
             $image = 'attachments/aboutus/' . $_POST['banner_image'];
             if (!file_exists($image)) {
                 $image = 'attachments/no-image.png';
             }
             ?>
      <p>Current image:</p>
      <div>
         <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
      </div>
      <input type="hidden" name="old_banner_image" value="<?= $_POST['banner_image'] ?>">
      <?php if (isset($_GET['to_lang'])) { ?>
      <input type="hidden" name="banner_image" value="<?= $_POST['banner_image'] ?>">
      <?php
         }
         }
         ?>
      <label for="userfile">Banner Image</label>
      <input type="file" id="userfile" name="userfile">
   </div>
   <div class="form-group for-shop">
      <label for="userfile">Origin Story</label>
      <textarea name="origin_story" id="origin_story" rows="50" class="form-control"><?php echo @$_POST['origin_story']; ?></textarea>
      <script>
         CKEDITOR.replace('origin_story');
         CKEDITOR.config.entities = false;
      </script>
   </div>
   <div class="form-group bordered-group">
      <?php
         if (isset($_POST['origin_image']) && $_POST['origin_image'] != null) {
             $image = 'attachments/aboutus/' . $_POST['origin_image'];
             if (!file_exists($image)) {
                 $image = 'attachments/no-image.png';
             }
             ?>
      <p>Current image:</p>
      <div>
         <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
      </div>
      <input type="hidden" name="old_origin_image" value="<?= $_POST['origin_image'] ?>">
      <?php if (isset($_GET['to_lang'])) { ?>
      <input type="hidden" name="origin_image" value="<?= $_POST['origin_image'] ?>">
      <?php
         }
         }
         ?>
      <label for="origin_image">Origin Image</label>
      <input type="file" id="origin_image" name="origin_image">
   </div>
   <div class="form-group for-shop">
      <label for="userfile">Neo Pro Best</label>
      <textarea name="neo_pro_best" id="neo_pro_best" rows="50" class="form-control"><?php echo @$_POST['neo_pro_best']; ?></textarea>
      <script>
         CKEDITOR.replace('neo_pro_best');
         CKEDITOR.config.entities = false;
      </script>
   </div>
   <div class="form-group for-shop">
      <label for="userfile">Expertise</label>
      <textarea name="expertise" id="expertise" rows="50" class="form-control"><?php echo @$_POST['expertise']; ?></textarea>
      <script>
         CKEDITOR.replace('expertise');
         CKEDITOR.config.entities = false;
      </script>
   </div>
   <div class="form-group bordered-group">
      <?php
         if (isset($_POST['expertise_image']) && $_POST['expertise_image'] != null) {
             $image = 'attachments/aboutus/' . $_POST['expertise_image'];
             if (!file_exists($image)) {
                 $image = 'attachments/no-image.png';
             }
             ?>
      <p>Current image:</p>
      <div>
         <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
      </div>
      <input type="hidden" name="old_expertise_image" value="<?= $_POST['expertise_image'] ?>">
      <?php if (isset($_GET['to_lang'])) { ?>
      <input type="hidden" name="expertise_image" value="<?= $_POST['expertise_image'] ?>">
      <?php
         }
         }
         ?>
      <label for="expertise_image">Expertise Image</label>
      <input type="file" id="expertise_image" name="expertise_image">
   </div>
   <div class="form-group for-shop">
      <label for="userfile">Neolayr Pro Way</label>
      <textarea name="pro_way" id="pro_way" rows="50" class="form-control"><?php echo @$_POST['pro_way']; ?></textarea>
      <script>
         CKEDITOR.replace('pro_way');
         CKEDITOR.config.entities = false;
      </script>
   </div>
   <div class="form-group for-shop">
      <label for="userfile">Dermatologically Tested</label>
      <textarea name="dermatologically_tested" id="dermatologically_tested" rows="50" class="form-control"><?php echo @$_POST['dermatologically_tested']; ?></textarea>
      <script>
         CKEDITOR.replace('dermatologically_tested');
         CKEDITOR.config.entities = false;
      </script>
   </div>
   <div class="form-group bordered-group">
      <?php
         if (isset($_POST['dermatologically_image']) && $_POST['dermatologically_image'] != null) {
             $image = 'attachments/aboutus/' . $_POST['dermatologically_image'];
             if (!file_exists($image)) {
                 $image = 'attachments/no-image.png';
             }
             ?>
      <p>Current image:</p>
      <div>
         <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
      </div>
      <input type="hidden" name="old_dermatologically_image" value="<?= $_POST['dermatologically_image'] ?>">
      <?php if (isset($_GET['to_lang'])) { ?>
      <input type="hidden" name="dermatologically_image" value="<?= $_POST['dermatologically_image'] ?>">
      <?php
         }
         }
         ?>
      <label for="dermatologically_image">Dermatologically Image</label>
      <input type="file" id="dermatologically_image" name="dermatologically_image">
   </div>
   <button type="submit" name="update" class="btn btn-lg btn-default">Update</button>
</form>