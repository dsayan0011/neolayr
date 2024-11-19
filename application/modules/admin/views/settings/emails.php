<h1><img src="<?= base_url('assets/imgs/email.png') ?>" class="header-img" style="margin-top:-3px;"> Subscribed</h1>
<p>Here are all subscribed emails of users</p>
<hr>
<?php if ($this->session->flashdata('emailDeleted')) { ?>
    <hr>
    <div class="alert alert-info"><?= $this->session->flashdata('emailDeleted') ?></div>
    <?php
}
?>
<div class="table-responsive">
    <table class="table table-condensed table-bordered table-striped custab">
        <thead>
            <tr>
                <th>Email</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($emails->result()) {
                foreach ($emails->result() as $email) {
                    ?>
                    <tr>
                        <td><?= $email->subscriber_email ?></td>
                       <td><?= date('Y.m.d / H.m.s', strtotime($email->subscription_date)) ?></td>
                        <td><a href="?delete=<?= $email->subscriber_id ?>" class="btn-xs btn-danger confirm-delete">Delete</a></td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr><td colspan="5">No emails found!</td></tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?= $links_pagination ?>