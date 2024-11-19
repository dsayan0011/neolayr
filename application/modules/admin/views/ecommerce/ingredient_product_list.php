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
    <h1><img src="<?= base_url('assets/imgs/products-img.png') ?>" class="header-img" style="margin-top:-2px;"> Ingredient Product</h1>
    <hr>
    <a href="<?= base_url('admin/ingredient/add_product_list') ?>" class="btn btn-primary btn-xs pull-right" style="margin-bottom:10px;"><b>+</b> Add Ingredient Product</a>
    <div class="row">
        <div class="col-xs-12">
            <?php
            if ($ingredientDetails) {
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Ingredient Type</th>
                                <th width="25%">Long Description</th>
                                <th width="25%">Short Description</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($ingredientDetails as $row) {
                                $u_path = 'attachments/ingredientImages/';
                                if ($row['ingredientImage'] != null && file_exists($u_path . $row['ingredientImage'])) {
                                    $image = base_url($u_path . $row['ingredientImage']);
                                } else {
                                    $image = base_url('attachments/no-image.png');
                                }
                                ?>

                                <tr>                                   
                                    <td>
                                        <?= $row['ingredientsTitle']; ?>
                                    </td>
                                    <td>
                                        <?= character_limiter($row['longDescription'], 100) ?>
                                    </td>
                                    <td>
                                        <?= character_limiter($row['shortDescription'], 100)  ?>
                                    </td>
                                    <td>
                                        <img src="<?= $image ?>" alt="No Image" class="img-thumbnail" style="height:100px;">
                                    </td>
                                    <td>
                                        <?= $row['ingredientsdetaisStatus'] ?>
                                    </td>
                                    
                                    <td>
                                        <div class="pull-right">
                                            <a href="<?= base_url('admin/ingredient/edit_product_list/' . $row['ingredientsDetaisID']) ?>" class="btn btn-info">Edit</a>
                                            <a href="<?= base_url('admin/ingredient/product_list?delete=' . $row['ingredientsDetaisID']) ?>"  class="btn btn-danger confirm-delete">Delete</a>
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