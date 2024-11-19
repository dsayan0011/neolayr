<link href="<?= base_url('assets/css/bootstrap-toggle.min.css') ?>" rel="stylesheet">
<style type="text/css">
.box {
            display: flex;
            justify-content: spa;
            flex-flow: row wrap;
            space
          }
</style>
<h1><img src="<?= base_url('assets/imgs/products-img.png') ?>" class="header-img" style="margin-top:-2px;"> Contact Us</h1>
     
    <div class="clearfix"></div>
<hr>

<?php
    if (!empty($contacts)) {
        ?>
     
        <div class="table-responsive">
            <table class="table table-condensed table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Created Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($contacts as $tr) {
                        
                        ?>
                        <tr>
                            <td><?= date('d.M.Y / H:i:s a', strtotime($tr['created_at'])); ?></td>

                            <td><?= $tr['name']; ?></td>
                            
                            <td><?= $tr['email']; ?></td>
                            <td><?= $tr['contact_number']; ?></td>
                            <td><?= $tr['message']; ?></td>
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
