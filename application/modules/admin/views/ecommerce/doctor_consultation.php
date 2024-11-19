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
    <h1><img src="<?= base_url('assets/imgs/products-img.png') ?>" class="header-img" style="margin-top:-2px;"> Doctor Consultation</h1>
    <hr>
    <!-- <a href="<?= base_url('admin/ingredient/add') ?>" class="btn btn-primary btn-xs pull-right" style="margin-bottom:10px;"><b>+</b> Add Ingredient</a> -->
    <div class="row">
        <div class="col-xs-12">
            <?php
            if ($doctorConsultation) {
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <!-- <th width="50%">Description</th> -->
                                <th>Mobile</th>
                                <th>State</th>
                                <th>City</th>
                                <th>Created Date</th>
                                <!-- <th class="text-right">Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($doctorConsultation as $row) {
                                $state = $this->Users_model->getState($row->state);
                                $city = $this->Users_model->getCity($row->city);
                                ?>

                                <tr>                                   
                                    <td>
                                        <?= $row->name ?>
                                    </td>
                                    <td>
                                        <?= $row->mobile_number ?>
                                    </td>
                                    <td>
                                        <?= $state['state_name'] ?>
                                    </td>
                                    <td>
                                        <?= $city['name'] ?>
                                    </td>
                                    <td>
                                        <?= $row->created_date ?>
                                    </td>
                                    
                                   <!--  <td>
                                        <div class="pull-right">
                                            <a href="<?= base_url('admin/ingredient/edit/' . $row->ingredientsID) ?>" class="btn btn-info">Edit</a>
                                            <a href="<?= base_url('admin/ingredient?delete=' . $row->ingredientsID) ?>"  class="btn btn-danger confirm-delete">Delete</a>
                                        </div>
                                    </td> -->
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