<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="inner-nav">
  <div class="container"> 
       <ul class="list-inline">
            <li><a href="<?= LANG_URL ?>"><i class="fa fa-home" aria-hidden="true"></i></a> > </li>

                        <li><a href="<?= LANG_URL . '/users/dashboard' ?>"><?= lang('my_acc') ?></a> ></li>
    
        <li class="active"><?= lang('my_order') ?></li>
      </ul>
	</div>
</div>
<div class="container user-page">
  <div class="row">
    <div class="col-sm-3">
      <div class="my-account loginmodal-container">
        <h1>
          <div class="sidebar-menu">
            <ul class="list-inline">
              <li class=""> <a href="<?= LANG_URL . '/users/dashboard' ?>"> <i class="fa fa-dashboard" aria-hidden="true"></i> <?= lang('vendor_dashboard') ?> </a> </li>
              <li class="active"> <a href="<?= LANG_URL . '/users/orders' ?>"> <i class="fa fa-cart-arrow-down" aria-hidden="true"></i> <?= lang('my_order') ?> </a> </li>
              <li class=""> <a href="<?= LANG_URL . '/users/profile' ?>"> <i class="fa fa-user-circle-o" aria-hidden="true"></i> <?= lang('my_acc') ?> </a> </li>
              <li> <a href="<?= LANG_URL . '/users/logout' ?>"> <i class="fa fa-sign-out" aria-hidden="true"></i> <?= lang('logout') ?> </a> </li>
            </ul>
          </div>
        </h1>
        <br>
      </div>
    </div>
    <div class="col-sm-9">
      <?= lang('user_order_history') ?>
      <div class="clearfix"></div>
      <div class="content-right clearfix">
        <div class="index-table">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th><?= lang('usr_order_id') ?></th>
                  <th><?= lang('usr_order_date') ?></th>
                  <th>Status</th>
                  <th>Total</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                        if (!empty($orders_history)) {
                            foreach ($orders_history as $order) {
								if($order['processed'] == '0')
								$order_status = "Processing";
								elseif($order['processed'] == '1')
								$order_status = "Processed";
								elseif($order['processed'] == '2')
								$order_status = "Shipped";
								elseif($order['processed'] == '3')
								$order_status = "Delivered";
								elseif($order['processed'] == '4')
								$order_status = "Cancelled";
								elseif($order['processed'] == '5')
								$order_status = "Settled";
								elseif ($order['processed'] == 6) {
								$order_status = 'Returned';
								}
								elseif ($order['processed'] == 7) {
								$order_status = 'Delivered Returned Sattled';
								}
								elseif ($order['processed'] == 8) {
								$order_status = 'Shipped Return';
								}
								elseif ($order['processed'] == 9) {
								$order_status = 'Returned Sattled';
								}
								
								$subtotal_price = 0;
								$arr_products = unserialize($order['products']);
								/*foreach ($arr_products as $product) {
									$subtotal_price += ($product['product_info']['price']*$product['product_quantity']);
								}*/
                                ?>
                <tr>
                  <td>#
                    <?= $order['order_id'] ?></td>
                  <td><?= date('d.m.Y', $order['date']) ?></td>
                  <td><?= $order_status;?></td>
                  <td><?= $order['total_order_price'] . CURRENCY;?></td>
                  <td><a href="<?= LANG_URL . '/users/order/'.$order['order_id'] ?>" class="btn-view" data-toggle="tooltip" title="" rel="tooltip" data-original-title="View Order"> <i class="fa fa-eye" aria-hidden="true"></i> </a></td>
                </tr>
                <?php
                            }
                        } else {
                            ?>
                <tr>
                  <td colspan="5"><?= lang('usr_no_orders') ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="pull-right">
          <?= $links_pagination ?>
        </div>
      </div>
    </div>
  </div>
</div>
