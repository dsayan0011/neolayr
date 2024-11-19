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
    <h1><img src="<?= base_url('assets/imgs/products-img.png') ?>" class="header-img" style="margin-top:-2px;"> Products</h1>
    <hr>
    <div class="row">
        <div class="col-xs-12">
            <?php
            if ($products) {
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Review</th>
                                <th>Rating</th>
                                <th>User</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($products as $row) {
                                $u_path = 'attachments/shop_images/';
                                if ($row->image != null && file_exists($u_path . $row->image)) {
                                    $image = base_url($u_path . $row->image);
                                } else {
                                    $image = base_url('attachments/no-image.png');
                                }
                                ?>

                                <tr>
                                    <td>
                                        <img src="<?= $image ?>" alt="No Image" class="img-thumbnail" style="height:100px;">
                                    </td>
                                    <td>
                                        <?= $row->title ?>
                                    </td>
                                  	 <td>
                                        <?= $row->comment ?>
                                    </td>
                                   <td>
                                        <?= $row->rating ?>
                                    </td>
                                    <td><?= $row->name?></td>
                                    <td>
                                        <div class="pull-right">
                                        <?php if($row->status == 'inactive'){?>
                                            <a href="<?= base_url('admin/update_review?id=' . $row->review_id.'&action=active') ?>" class="btn btn-info">Approve</a>
                                        <?php } else{?>   
                                          <a href="<?= base_url('admin/update_review?id=' . $row->review_id.'&action=inactive') ?>" class="btn btn-info">Decline</a>
                                         <?php } ?>
                                            <a target="_blank" href="<?= LANG_URL . '/' . $row->url ?>" class="btn btn-info">View Product</a>
                                            <a href="<?= base_url('admin/update_review?id=' . $row->review_id.'&action=delete') ?>"  class="btn btn-danger confirm-delete">Delete</a>
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
            <div class ="alert alert-info">No products found!</div>
        <?php } ?>
    </div>