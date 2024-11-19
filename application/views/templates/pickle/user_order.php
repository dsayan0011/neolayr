<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
 <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= LANG_URL . '/users/dashboard' ?>"><?= lang('my_acc') ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Order</li>
                    </ol>
                </div><!-- End .container -->
 </nav>
<div class="container">
                <div class="row">
                    <div class="col-lg-9 order-lg-last dashboard-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                       My Orders
                                    </div><!-- End .card-header -->

                                    <div class="card-body">
                                        <div class="table-responsive">
                                          <table class="table">
                                              <thead>
                                                <tr>
                                                  <th><?= lang('usr_order_id') ?></th>
                                                  <th><?= lang('usr_order_date') ?></th>
                                                  <th>Status</th>
                                                  <th></th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                <?php
                                                        if (!empty($orders_history)) {
                                                            foreach ($orders_history as $order) {
                                                                if($order['orderstatus'] == '0')
																$order_status = "Processing";
																elseif($order['orderstatus'] == '1')
																$order_status = "orderstatus";
																elseif($order['orderstatus'] == '2')
																$order_status = "Shipped";
																elseif($order['orderstatus'] == '3')
																$order_status = "Delivered";
																elseif($order['orderstatus'] == '4')
																$order_status = "Cancelled";
																elseif($order['orderstatus'] == '5')
																$order_status = "Settled";
																elseif ($order['orderstatus'] == 6) {
																$order_status = 'Returned';
																}
																elseif ($order['orderstatus'] == 7) {
																$order_status = 'Delivered Returned Sattled';
																}
																elseif ($order['orderstatus'] == 8) {
																$order_status = 'Shipped Return';
																}
																elseif ($order['orderstatus'] == 9) {
																$order_status = 'Returned Sattled';
																}
                                                                
                                                                $subtotal_price = 0;
                                                                $arr_products = unserialize($order['products']);
                                                                /*foreach ($arr_products as $product) {
                                                                    $subtotal_price += ($product['product_info']['price']*$product['product_quantity']);
                                                                }*/
                                                                ?>
                                                <tr>
                                                  <td><a href="<?= LANG_URL . '/users/order/'.$order['order_product_id'] ?>">#
                                                    <?= $order['order_product_id'] ?></a></td>
                                                  <td><?= date('d.m.Y', $order['date']) ?></td>
                                                  <td><?= $order_status;?></td>
                                                  <td><a href="<?= LANG_URL . '/users/order/'.$order['order_product_id'] ?>" title="View Order"> <i class="fa fa-eye" aria-hidden="true"></i> </a></td>
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
                                         <div class="pull-right">
										  <?= $links_pagination ?>
                                        </div>
                                    </div><!-- End .card-body -->
                                </div><!-- End .card -->
                            </div><!-- End .col-md-6 -->
                        </div><!-- End .row -->
                    </div><!-- End .col-lg-9 -->

                    <aside class="sidebar col-lg-3">
                        <div class="widget widget-dashboard">
                            <h3 class="widget-title">My Account</h3>

                            <ul class="list">
                              <li> <a href="<?= LANG_URL . '/users/dashboard' ?>"> <?= lang('vendor_dashboard') ?> </a> </li>
                              <li class="active"> <a href="<?= LANG_URL . '/users/orders' ?>"> <?= lang('my_order') ?> </a> </li>
                              <li class=""> <a href="<?= LANG_URL . '/users/profile' ?>"> <?= lang('my_acc') ?> </a> </li>
                              <li> <a href="<?= LANG_URL . '/users/logout' ?>"> <?= lang('logout') ?> </a> </li>
                            </ul>
                        </div><!-- End .widget -->
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div>