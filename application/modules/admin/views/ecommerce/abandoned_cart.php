<link href="<?= base_url('assets/css/bootstrap-toggle.min.css') ?>" rel="stylesheet">
<style type="text/css">
.box {
            display: flex;
            justify-content: spa;
            flex-flow: row wrap;
            space
          }
</style>
<h1><img src="<?= base_url('assets/imgs/products-img.png') ?>" class="header-img" style="margin-top:-2px;"> Abandoned Cart</h1>
     <a href="<?= base_url('admin/sendPush') ?>" class="btn btn-primary btn-xs pull-right" style="margin-bottom:10px;"><b>+</b> Send Notification</a>
    <div class="clearfix"></div>
<hr>

<?php
    if (!empty($abandoned_cart)) {
        ?>
     
        <div class="table-responsive">
            <table class="table table-condensed table-bordered table-striped">
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Created Date</th>
                        <th>Product Name</th>
                        <!-- <th>Notification Send</th> -->
                        <!-- <th>Send Date</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($abandoned_cart as $tr) {
                        $result = $this->Users_model->getProductName($tr['product_id']);
						 if ($tr['send_push'] == '0') {
                            $send_push = 'False';
                        }
                        else{
                             $send_push = 'True';
                        }
                        
                        ?>
                        <tr>
                            <td><?= $tr['name']; ?> <?= $tr['last_name']; ?></td>
                            <td><?= date('d.M.Y / H:i:s', strtotime($tr['created_date'])); ?></td>
                             
                            
                            <td><?= $result['title']; ?></td>
                           
                            <!-- <td>
                                <?= $send_push ?>
                            </td> -->
                            <?php if($tr['push_date'] != ''){?>
                            <!-- <td>
                                <?= date('d.M.Y / H:i:s', strtotime($tr['push_date'])); ?>
                            </td> -->
                            <?php } else{ ?>
                             <!-- <td>
                                
                            </td> -->
                            <?php } ?>
                           
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?= $links_pagination ?>
    <?php } else { ?>
        <div class="alert alert-info">No Data at the moment!</div>
    <?php } ?>   
<hr>


<script src="<?= base_url('assets/js/bootstrap-toggle.min.js') ?>"></script>
