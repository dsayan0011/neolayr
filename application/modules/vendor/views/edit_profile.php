<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<h1><img src="<?= base_url('assets/imgs/admin-user.png') ?>" class="header-img" style="margin-top:-3px;"> Edit Profile</h1>
<hr>
 <?php
    if ($this->session->flashdata('result_add')) {
        ?>
        <hr>
        <div class="alert alert-warning"><?= $this->session->flashdata('result_add') ?></div>
        <hr>
        <?php
    }
    ?>
<form method="POST">
 <input type="hidden" name="edit" value="<?= isset($vendor_details) ? $vendor_details['id'] : '0' ?>">
	<div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" required value="<?= isset($vendor_details['name']) ? $vendor_details['name'] : '' ?>" class="form-control" id="name">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" value="" id="password">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" required class="form-control" value="<?= isset($vendor_details['email']) ? $vendor_details['email'] : '' ?>" id="email">
                        </div>
                       
      <input type="submit" name="submit" class="btn btn-lg btn-default" />

    <?php if ($this->uri->segment(3) !== null) { ?>
        <a href="<?= base_url('admin/vendors') ?>" class="btn btn-lg btn-default">Cancel</a>
    <?php } ?>
</form>