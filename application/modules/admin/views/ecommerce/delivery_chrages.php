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
    <h1><img src="<?= base_url('assets/imgs/products-img.png') ?>" class="header-img" style="margin-top:-2px;"> Delivery Charges</h1>
    <hr>
    <div class="row">
        <div class="col-xs-12">
        <div class="well hidden-xs"> 
                <div class="row">
                    <form method="post" enctype="multipart/form-data">
                    <div class="form-group bordered-group">
						<p>To change delivery time and delivery cost download the Excell file from the below link. Make the nesseccery changes and upload again.</p>
                            
                        <label for="userfile">Upload File</label>
                        <input type="file" id="userfile" name="userfile" required>
                    </div>
    
                     <button type="submit" name="submit" class="btn btn-lg btn-default">Update</button>   
                     <a class="btn btn-lg btn-default" href="<?= base_url('admin/deliveryCharge/download') ?>">Download File</a>
                    </form>
                </div>
            </div>
            <?php
            if ($delivery) {
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>District Name</th>
                                <th>Delivery Time</th>
                                <th>Delivery Charges</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($delivery as $row) {
                                ?>

                                <tr>
                                    <td>
                                        <?= $row->state_name ?>
                                    </td>
                                    <td>
                                        <?= $row->delivery_time ?>
                                    </td>
                                   <td><?= $row->delivery_charges ?></td>
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
            <div class ="alert alert-info">No Data found!</div>
        <?php } ?>
    </div>