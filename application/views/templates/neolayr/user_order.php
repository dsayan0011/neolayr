<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- <section class="breadcrumb-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2>My Orders</h2>
                </div>
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Orders</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="section-b-space">
    <div class="container">
        <div class="row">
        	<div class="col-lg-3">
                <div class="account-sidebar"><a class="popup-btn">my order</a></div>
                <div class="dashboard-left">
                    <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span></div>
                    <div class="block-content">
                        <ul>
                           <li > <a href="<?= LANG_URL . '/users/dashboard' ?>"> <?= lang('vendor_dashboard') ?> </a> </li>
                              <li class="active"> <a href="<?= LANG_URL . '/users/orders' ?>"> <?= lang('my_order') ?> </a> </li>
                              <li class=""> <a href="<?= LANG_URL . '/users/profile' ?>"> <?= lang('my_acc') ?> </a> </li>
                              <li class="last"> <a href="<?= LANG_URL . '/users/logout' ?>"> <?= lang('logout') ?> </a> </li>
                        </ul>
                    </div>
                </div>
            </div>
             <div class="col-lg-9">
                <div class="dashboard-right">
                    <div class="dashboard">
                    	<div class="card">
                                    <div class="card-header">
                                       My Orders
                                    </div>

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
                                         <div class=" product-pagination">
										  <?= $links_pagination ?>
                                        </div>
                                    </div>
                                </div>
                                
                    </div>
                </div>
             </div>
        </div>
    </div>
</section>

 -->

 <main>
            <!-- PERSONAL INFO PAGE -->
            <section class="personal-info">
                <div class="container">
                    <div class="personal-information text-center">
                        <div class="personal-info-image mx-auto">
                            <img src="<?= base_url('images/user-5.png'); ?>" border="0" alt="">
                        </div>
                        <p>Hello</p>
                        <h2><?php echo $_SESSION['logged_user_name'];?></h2>
                    </div>
                    <div class="personal-info-detailed-content row no-gutters flex-row-reverse">
                        
                        <div class="personal-info-detailed-content-right col-lg-8">
                            <div class="label-area d-flex justify-content-between">
                                <div class="order-title-area">
                                    <div class="">
                                        <h4>My orders</h4>
                                    </div>  
                                        
                                    <div class="">
                                        <form method="GET" id="sortOrder">
                                        <select name="sortby" class="input-style" onchange="sort_order(this.value);">
                                            <option value="all" <?php if(isset($sort_by) && $sort_by == 'all') echo 'selected="selected"';?>>All</option>
                                            <option value="6month" <?php if(isset($sort_by) && $sort_by == '6month') echo 'selected="selected"';?>>Last 6 month</option>
                                            <option value="12month" <?php if(isset($sort_by) && $sort_by == '12month') echo 'selected="selected"';?>>Last 12 month</option>
                                        </select>
                                        </form>
                                    </div>
                                
                                </div>
                            </div>
                            <!-- each order start -->
                            <?php foreach ($getOrder as $orders) {
                                $result = $this->Public_model->getUserOrdersHistoryTwo($orders['id']);
                                
                             ?>
                            <?php /* if(sizeof($result)>0){ */ ?>
                            <div class="each-order-n">
                                <div class="order-top">
                                    <div class="row">
                                        <?php
                                            $date = date_create($orders['updated_date']);
                                            //echo date_format($date, 'jS \o\f F Y');
                                            ?>
                                        <div class="col-4">
                                            <h4>Order placed: <?= date_format($date, 'd/m/Y'); ?></h4>
                                        </div>
                                        <div class="col-4">
                                            <h4>Order Total: <?= $orders['total_order_price']; ?></h4>
                                        </div>
                                        <div class="col-4">
                                            <h4>Order ID: #<?= $orders['order_id'] ?></h4>
                                            <p><a href="<?= LANG_URL . '/users/order/'.$orders['id'] ?>">View details</a></p>
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class="order-middle">
                                    <div class="row">
                                        <?php foreach ($result as $product) { 
                                            $arr_product = unserialize($product['order_products']);
                                            //print_r($arr_product);
                                            //foreach ($arr_order as $product) {
                                                 $productInfo = modules::run('admin/ecommerce/products/getProductInfo', $arr_product['product_info']['id'], true);
                                            //print_r($arr_order);
                                            ?>

                                        <div class="col-3 col-lg-2">
                                            <img src="<?= base_url('attachments/shop_images/' . $arr_product['product_info']['image']) ?>" width="100%" height="auto" border="0" alt="">
                                        </div>
                                        <div class="col-6 col-lg-5">
                                            <a href="<?= LANG_URL . '/' . $productInfo['url'] ?>">
                                            <p class="order-title"><?= $productInfo['product_title'] ?></p>
                                        </a>
                                            <div class="row pqty">
                                                <div class="col-6">
                                                    <p>Unit price <strong><?= CURRENCY.($product['unit_price']+ $product['reward_amount'])?></strong></p>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <p>Quantity: <strong><?= $arr_product['product_quantity'];?></strong></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-2 hide-on-mobile">
                                            
                                        </div>
                                        <div class="col-3 col-lg-3">
                                            <p class="ordfer-on">Status <br><strong><?= $product['status']; ?></strong></p>
                                            <p class="ordfer-on">Updated Date <br><strong><?= date_format($date, 'd/m/Y'); ?></strong></p>
                                            <!-- <p>Delivery expected by <br><strong>10-04-2023</strong></p> -->
                                        </div>
                                         <hr>
                                    <?php  }?>

                                    </div>
                                </div>
                                
                            </div>
                        <?php } ?>
                         <div class="product-pagination">
                          <?= $links_pagination ?>
                        </div>
                         <div class="col-xl-12 col-md-12 col-12" id="no_wishlist_item" style="display:<?php echo sizeof($getOrder)>0?'none':'block';?>">
                                No Order Found !!!
                            </div>
                            <!-- each order end -->
                            <!-- each order start -->
                            <!-- <div class="each-order-n">
                                <div class="order-top">
                                    <div class="row">
                                        <div class="col-6">
                                            <h4>Order ID: 39570248u73</h4>
                                        </div>
                                        <div class="col-6 text-right">
                                            <a href="order-three.html"><img src="<?= base_url('images/track.png') ?>" width="20" height="26" border="0" alt="">Track</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-middle">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <img src="<?= base_url('images/product-listing1-Copy.jpg') ?>" width="100%" height="auto" border="0" alt="">
                                        </div>
                                        <div class="col-lg-5">
                                            <p>Neolayr Pro Prohair Quick Hair Fall Control Solution 40 ML</p>
                                            <div class="row pqty">
                                                <div class="col-6">
                                                    <p>₹340.00</p>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <p>Quantity: <strong>3</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            
                                        </div>
                                        <div class="col-lg-3">
                                            <p class="ordfer-on">Ordered on <br><strong>06-04-2023</strong></p>
                                            <p>Delivery expected by <br><strong>10-04-2023</strong></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-bottom">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p><a href="">Cancel</a></p>
                                        </div>
                                        <div class="col-lg-3">
                                            <p><a href="order-two.html">View details</a></p>
                                        </div>
                                        <div class="col-lg-3">
                                            <p>Status: <span class="Delivered">Delivered</span></p>
                                        </div>
                                        <div class="col-lg-3">
                                            <p>Order total: <strong>₹340.00</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <!-- each order end -->
                            <!-- each order start -->
                            <!-- <div class="each-order-n">
                                <div class="order-top">
                                    <div class="row">
                                        <div class="col-6">
                                            <h4>Order ID: 39570248u73</h4>
                                        </div>
                                        <div class="col-6 text-right">
                                            <a href="order-three.html"><img src="<?= base_url('images/track.png') ?>" width="20" height="26" border="0" alt="">Track</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-middle">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <img src="<?= base_url('images/product-listing1-Copy.jpg') ?>" width="100%" height="auto" border="0" alt="">
                                        </div>
                                        <div class="col-lg-5">
                                            <p>Neolayr Pro Prohair Quick Hair Fall Control Solution 40 ML</p>
                                            <div class="row pqty">
                                                <div class="col-6">
                                                    <p>₹340.00</p>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <p>Quantity: <strong>3</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            
                                        </div>
                                        <div class="col-lg-3">
                                            <p class="ordfer-on">Ordered on <br><strong>06-04-2023</strong></p>
                                            <p>Delivery expected by <br><strong>10-04-2023</strong></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-bottom">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <p><a href="">Cancel</a></p>
                                        </div>
                                        <div class="col-lg-3">
                                            <p><a href="order-two.html">View details</a></p>
                                        </div>
                                        <div class="col-lg-3">
                                            <p>Status: <span class="Canceled">Canceled</span></p>
                                        </div>
                                        <div class="col-lg-3">
                                            <p>Order total: <strong>₹340.00</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <!-- each order end -->
                        </div>
                        <div class="personal-info-detailed-content-left col-lg-4">
                            <ul>
                                <li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6.png') ?>" width="21" height="25" border="0" alt=""></span>Account Settings</a>
                                    <ul>
                                        <li><a href="<?= LANG_URL . '/users/profile' ?>">Personal information</a></li>
                                        <li><a href="<?= LANG_URL . '/manage-address' ?>">Manage address</a></li>
                                    </ul>
                                </li>
                                <li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6-copy.png') ?>" width="25" height="25" border="0" alt=""></span>Order history</a>
                                    <ul style="display:block">
                                        <li class="active"><a href="<?= LANG_URL . '/users/orders' ?>">MY ORDERS</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?= LANG_URL . '/users/wishlist' ?>"><span><img src="<?= base_url('images/user-6-copy-4.png') ?>" width="23" height="21" border="0" alt=""></span>Wishlist</a></li>
                                <li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6-copy-6.png') ?>" width="23" height="23" border="0" alt=""></span>Rewards</a>
                                    <ul>
                                        <li><a href="<?= LANG_URL . '/users/reward' ?>">Manage Reward</a></li>
                                        <li><a href="<?= LANG_URL . '/refer-friend' ?>">Refer friends</a></li>
                                    </ul>
                                </li>
                                <li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/gift-card.png') ?>" width="21" height="25" border="0" alt=""></span>Gift Voucher</a>
                                    <ul>
                                        <li><a href="<?= LANG_URL . '/users/gift' ?>">Gift Card</a></li>
                                        <li><a href="<?= LANG_URL . '/gift-card-details' ?>">Gift Card Details</a></li>
                                    </ul>
                                </li>
                                 <!-- <li><a href="<?= LANG_URL . '/users/gift' ?>"><span><img src="<?= base_url('images/gift-card.png') ?>" width="21" height="23" border="0" alt=""></span>Gift Voucher</a></li> -->
                                <li><a href="<?= LANG_URL . '/users/logout' ?>"><span><img src="<?= base_url('images/user-6-copy-8.png') ?>" width="21" height="23" border="0" alt=""></span>Logout</a></li>
                            </ul>
                        </div>
                    </div>
                   
                </div>
            </section>
            <!-- END:PERSONAL INFO PAGE -->
            
        </main>