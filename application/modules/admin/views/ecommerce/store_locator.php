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
    <h1><img src="<?= base_url('assets/imgs/products-img.png') ?>" class="header-img" style="margin-top:-2px;"> Store</h1>
    <hr>
    <a href="<?= base_url('admin/store/add') ?>" class="btn btn-primary btn-xs pull-right" style="margin-bottom:10px;"><b>+</b> Add Store</a>
    <div class="row">
        <div class="col-xs-12">
            <?php
            if ($storeLocator) {
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Pincode</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($storeLocator as $row) {                                
                                ?>

                                <tr>
                                    <td>
                                        <?= $row->storeLocatorID ?>
                                    </td>
                                    <td>
                                        <?= $row->store_name ?>
                                    </td>
                                    <td>
                                        <?= $row->store_city ?>
                                    </td>
                                    <td>
                                        <?= $row->store_state ?> 
                                    </td>
                                    <td>
                                        <?= $row->store_pincode ?> 
                                    </td>
                                    <td>
                                        <?= $row->store_status ?>
                                    </td>
                                    
                                    <td>
                                        <div class="pull-right">
                                            <a href="<?= base_url('admin/store/edit/' . $row->storeLocatorID) ?>" class="btn btn-info">Edit</a>
                                            <a href="<?= base_url('admin/store?delete=' . $row->storeLocatorID) ?>"  class="btn btn-danger confirm-delete">Delete</a>
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
            <div class ="alert alert-info">No Store found!</div>
        <?php } ?>
    </div>