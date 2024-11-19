<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
    <?= purchase_steps(1, 2, 3) ?>
    <div class="alert alert-success"><?= lang('c_o_d_order_completed') ?></div>
     <br />
    <a class="btn btn-primary" href="<?= LANG_URL . '/users/orders' ?>">Click here to view your order</a>
</div>