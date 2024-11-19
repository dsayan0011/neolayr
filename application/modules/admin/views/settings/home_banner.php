<h1><img src="<?= base_url('assets/imgs/settings-page.png') ?>" class="header-img" style="margin-top:-3px;">Home Banner</h1>
<hr>
<div class="row">
	<div class="col-md-12">
    	<?php if ($this->session->flashdata('banner_update')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('banner_update') ?></div>
        <?php } ?>
        <?php if ($this->session->flashdata('banner_update_image')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('banner_update_image') ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Main Banner section one(390x143 px)</div>
            <div class="panel-body">
                <?php
				 $u_path = 'attachments/banner_images/';
                 if ($main_banner_section1 != null && file_exists($u_path . $main_banner_section1)) {
                            $image = base_url($u_path . $main_banner_section1);
                  } else {
                             $image = base_url('attachments/no-image.png');
                 }
				?>
                <img src="<?= $image ?>" style="height:143px" alt="No Image. Upload new!" class="img-responsive">
                <hr>
                <form accept-charset="utf-8" method="post" enctype="multipart/form-data" action="">
                     <div class="form-group for-shop">
                    	<input type="file" name="main_banner_section1" />
                     </div>
                     <div class="form-group for-shop">
                        <label>Banner Link</label>
                        <input type="text" name="main_banner_section1_link" placeholder="Banner Link" value="<?= @$main_banner_section1_link ?>" class="form-control" required>
                     </div>
                    
                    <input type="submit" value="Update" name="main_banner_section1_update" class="btn btn-default" />
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Main Banner section two(390x143 px)</div>
            <div class="panel-body">
                <?php 
				 $u_path = 'attachments/banner_images/';
                 if ($main_banner_section2 != null && file_exists($u_path . $main_banner_section2)) {
                            $image = base_url($u_path . $main_banner_section2);
                  } else {
                             $image = base_url('attachments/no-image.png');
                 }
				?>
                <img src="<?= $image ?>" style="height:143px" alt="No Image. Upload new!" class="img-responsive">
                <hr>
                <form accept-charset="utf-8" method="post" enctype="multipart/form-data" action="">
                     <div class="form-group for-shop">
                    	<input type="file" name="main_banner_section2" />
                     </div>
                     <div class="form-group for-shop">
                        <label>Banner Link</label>
                        <input type="text" name="main_banner_section2_link" placeholder="Banner Link" value="<?= @$main_banner_section2_link ?>" class="form-control" required>
                     </div>
                    
                    <input type="submit" value="Update" name="main_banner_section2_update" class="btn btn-default" />
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Main Banner section three(390x143 px)</div>
            <div class="panel-body">
                <?php 
				 $u_path = 'attachments/banner_images/';
                 if ($main_banner_section3 != null && file_exists($u_path . $main_banner_section3)) {
                            $image = base_url($u_path . $main_banner_section3);
                  } else {
                             $image = base_url('attachments/no-image.png');
                 }
				?>
                <img src="<?= $image ?>" style="height:143px" alt="No Image. Upload new!" class="img-responsive">
                <hr>
                <form accept-charset="utf-8" method="post" enctype="multipart/form-data" action="">
                     <div class="form-group for-shop">
                    	<input type="file" name="main_banner_section3" />
                     </div>
                     <div class="form-group for-shop">
                        <label>Banner Link</label>
                        <input type="text" name="main_banner_section3_link" placeholder="Banner Link" value="<?= @$main_banner_section3_link ?>" class="form-control" required>
                     </div>
                    
                    <input type="submit" value="Update" name="main_banner_section3_update" class="btn btn-default" />
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Side Banner section(220x660 px)</div>
            <div class="panel-body">
                <?php  
				 $u_path = 'attachments/banner_images/';
                 if ($side_banner != null && file_exists($u_path . $side_banner)) {
                            $image = base_url($u_path . $side_banner);
                  } else {
                             $image = base_url('attachments/no-image.png');
                 }
				?>
                <img src="<?= $image ?>" style="height:143px" alt="No Image. Upload new!" class="img-responsive">
                <hr>
                <form accept-charset="utf-8" method="post" enctype="multipart/form-data" action="">
                     <div class="form-group for-shop">
                    	<input type="file" name="side_banner" />
                     </div>
                     <div class="form-group for-shop">
                        <label>Banner Link</label>
                        <input type="text" name="side_banner_link" placeholder="Banner Link" value="<?= @$side_banner_link ?>" class="form-control" required>
                     </div>
                    
                    <input type="submit" value="Update" name="side_banner_update" class="btn btn-default" />
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Bottom Banner section one(675x260 px)</div>
            <div class="panel-body">
                <?php 
				 $u_path = 'attachments/banner_images/';
                 if ($footer_banner_section1 != null && file_exists($u_path . $footer_banner_section1)) {
                            $image = base_url($u_path . $footer_banner_section1);
                  } else {
                             $image = base_url('attachments/no-image.png');
                 }
				?>
                <img src="<?= $image ?>" style="height:143px" alt="No Image. Upload new!" class="img-responsive">
                <hr>
                <form accept-charset="utf-8" method="post" enctype="multipart/form-data" action="">
                     <div class="form-group for-shop">
                    	<input type="file" name="footer_banner_section1" />
                     </div>
                     <div class="form-group for-shop">
                        <label>Banner Link</label>
                        <input type="text" name="footer_banner_section1_link" placeholder="Banner Link" value="<?= @$footer_banner_section1_link ?>" class="form-control" required>
                     </div>
                    
                    <input type="submit" value="Update" name="footer_banner_section1_update" class="btn btn-default" />
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Bottom Banner section two(675x260 px)</div>
            <div class="panel-body">
                <?php 
				 $u_path = 'attachments/banner_images/';
                 if ($footer_banner_section2 != null && file_exists($u_path . $footer_banner_section2)) {
                            $image = base_url($u_path . $footer_banner_section2);
                  } else {
                             $image = base_url('attachments/no-image.png');
                 }
				?>
                <img src="<?= $image ?>" style="height:143px" alt="No Image. Upload new!" class="img-responsive">
                <hr>
                <form accept-charset="utf-8" method="post" enctype="multipart/form-data" action="">
                     <div class="form-group for-shop">
                    	<input type="file" name="footer_banner_section2" />
                     </div>
                     <div class="form-group for-shop">
                        <label>Banner Link</label>
                        <input type="text" name="footer_banner_section2_link" placeholder="Banner Link" value="<?= @$footer_banner_section2_link ?>" class="form-control" required>
                     </div>
                    
                    <input type="submit" value="Update" name="footer_banner_section2_update" class="btn btn-default" />
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="panel panel-success col-h">
            <div class="panel-heading">Bottom Banner section three(560x280 px)</div>
            <div class="panel-body">
                <?php 
				 $u_path = 'attachments/banner_images/';
                 if ($footer_banner_section3 != null && file_exists($u_path . $footer_banner_section3)) {
                            $image = base_url($u_path . $footer_banner_section3);
                  } else {
                             $image = base_url('attachments/no-image.png');
                 }
				?>
                <img src="<?= $image ?>" style="height:143px" alt="No Image. Upload new!" class="img-responsive">
                <hr>
                <form accept-charset="utf-8" method="post" enctype="multipart/form-data" action="">
                     <div class="form-group for-shop">
                    	<input type="file" name="footer_banner_section3" />
                     </div>
                     <div class="form-group for-shop">
                        <label>Banner Link</label>
                        <input type="text" name="footer_banner_section3_link" placeholder="Banner Link" value="<?= @$footer_banner_section3_link ?>" class="form-control" required>
                     </div>
                    
                    <input type="submit" value="Update" name="footer_banner_section3_update" class="btn btn-default" />
                </form>
            </div>
        </div>
    </div>
</div>