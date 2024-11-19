<div id="products">
    <?php
    if ($this->session->flashdata('result_delete')) {
        ?>
        <hr>
        <div class="alert alert-success"><?= $this->session->flashdata('result_delete') ?></div>
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
    <h1><img src="<?= base_url('assets/imgs/products-img.png') ?>" class="header-img" style="margin-top:-2px;"> Ingredient</h1>
    <hr>
    <a href="<?= base_url('admin/ingredient/add') ?>" class="btn btn-primary btn-xs pull-right" style="margin-bottom:10px;"><b>+</b> Add Ingredient</a>
    <div class="row">
        <div class="col-xs-12">
            <form method="POST" action="<?= base_url('admin/ingredient_banner') ?>" enctype="multipart/form-data">
               <div class="form-group for-shop">
                <label>Title</label>
                <input type="text" name="banner_title" placeholder="Title" value="<?= @$_POST['banner_title'] ?>" class="form-control">
     </div>
               <div class="form-group bordered-group">
                  <?php
                     if (isset($_POST['ingredient_banner_image']) && $_POST['ingredient_banner_image'] != null) {
                         $image = 'attachments/ingredient_banner/' . $_POST['ingredient_banner_image'];
                         if (!file_exists($image)) {
                             $image = 'attachments/no-image.png';
                         }
                         ?>
                  <p>Current image:</p>
                  <div>
                     <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
                  </div>
                  <input type="hidden" name="old_ingredient_banner_image" value="<?= $_POST['ingredient_banner_image'] ?>">
                  <?php if (isset($_GET['to_lang'])) { ?>
                  <input type="hidden" name="ingredient_banner_image" value="<?= $_POST['ingredient_banner_image'] ?>">
                  <?php
                     }
                     }
                     ?>
                  <label for="userfile">Ingredient Image</label>
                  <input type="file" id="userfile" name="userfile">
               </div>
               <button type="submit" name="update" class="btn btn-lg btn-success">Update</button>
            </form>
            <br>
            <?php
            if ($ingredient) {
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <!-- <th width="50%">Description</th> -->
                                <th>Status</th>
                                <th>Created</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($ingredient as $row) {
                                ?>

                                <tr>                                   
                                    <td>
                                        <?= $row->ingredientsTitle ?>
                                    </td>
                                    <!-- <td>
                                        <?= $row->description ?>
                                    </td> -->
                                    <td>
                                        <?= $row->status ?>
                                    </td>
                                    <td>
                                        <?= $row->created_at ?>
                                    </td>
                                    
                                    <td>
                                        <div class="pull-right">
                                            <a href="<?= base_url('admin/ingredient/edit/' . $row->ingredientsID) ?>" class="btn btn-info">Edit</a>
                                            <a href="<?= base_url('admin/ingredient?delete=' . $row->ingredientsID) ?>"  class="btn btn-danger confirm-delete">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?= $links_pagination ?>
            </div>
            <?php
        } else {
            ?>
            <div class ="alert alert-info">No ingredient found!</div>
        <?php } ?>
    </div>