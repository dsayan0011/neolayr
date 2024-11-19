<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="inner-nav">
  <div class="container">
    <ul class="list-inline">
      <li><a href="<?= LANG_URL ?>"><i class="fa fa-home" aria-hidden="true"></i></a> > </li>
      <li><a href="<?= LANG_URL . '/users/dashboard' ?>">
        <?= lang('my_acc') ?>
        </a> ></li>
      <li class="active">
        <?= lang('my_order') ?>
      </li>
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
              <li class=""> <a href="<?= LANG_URL . '/users/dashboard' ?>"> <i class="fa fa-dashboard" aria-hidden="true"></i>
                <?= lang('vendor_dashboard') ?>
                </a> </li>
              <li class="active"> <a href="<?= LANG_URL . '/users/orders' ?>"> <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                <?= lang('my_order') ?>
                </a> </li>
              <li class=""> <a href="<?= LANG_URL . '/users/profile' ?>"> <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                <?= lang('my_acc') ?>
                </a> </li>
              <li> <a href="<?= LANG_URL . '/users/logout' ?>"> <i class="fa fa-sign-out" aria-hidden="true"></i>
                <?= lang('logout') ?>
                </a> </li>
            </ul>
          </div>
        </h1>
        <br>
      </div>
    </div>
    <div class="col-sm-9">
      <?= lang('user_order_history') ?>
       <div class="row order_wrapper">
         <div class="order_header">View Order : <?= lang('usr_order_id') ?>(#<?= $orders_info['order_id'] ?>)</div>
         <div class="col-md-6 col-sm-6">
            <div class="order-details">
              <h5>Order Details</h5>
              <div class="table-responsive">
               <table class="table">
                  <tbody>
                  	 <tr>
                      <td><?= lang('usr_order_date') ?>:</td>
                      <td><?= date('d.m.Y', $orders_info['date']) ?></td>
                    </tr>
                    <tr>
                      <td>Order Status:</td>
                      <td><?php
					  					if ($orders_info['processed'] == 0) {
                                            $type = 'Processing';
                                        }
                                        if ($orders_info['processed'] == 1) {
                                            $type = 'Processed';
                                        }
                                        if ($orders_info['processed'] == 2) {
                                            $type = 'Shipped';
                                        }
                                        if ($orders_info['processed'] == 3) {
                                            $type = 'Delivered';
                                        }
                                        if ($orders_info['processed'] == 4) {
                                            $type = 'Canceled';
                                        }
										if ($orders_info['processed'] == 5) {
                                            $type = 'Settled';
                                        }
										if ($orders_info['processed'] == 6) {
											$type = 'Returned';
										}
										if ($orders_info['processed'] == 7) {
											$type = 'Delivered Returned Sattled';
										}
										if ($orders_info['processed'] == 8) {
											$type = 'Shipped Return';
										}
										if ($orders_info['processed'] == 9) {
											$type = 'Returned Sattled';
										}
							echo  $type;
					  		 ?>
                      </td>
                    </tr>
               
                    <tr>
                      <td>Payment Method:</td>
                      <td>Cash On Delivery</td>
                    </tr>
                    <tr>
                      <td>Email:</td>
                      <td><?= $orders_info['email'] ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-sm-6">
          	<div class="action_div pull-right">
            		<?php if($orders_info['processed'] == "0"){?>
            		<a href="<?= LANG_URL . '/users/update-order-status/'.$orders_info['order_id'] ?>/cancel" class="btn btn-default">Cancel Order</a>
                    <?php }if($orders_info['processed'] == "1" || $orders_info['processed'] == "2"){ ?>
                     <a href="javascript:void(0);" onclick="trackDetails(<?php echo $orders_info['order_id'];?>)" class="track_order btn-add" data-toggle="modal" data-target="#track_order" style="margin-top:10%;">Track Order</a>
                    <?php } ?>
            </div>
          
          </div>
        </div>
        <div class="row">
          
          <div class="col-md-6 col-sm-6">
            <div class="order-address">
              <h5>Shipping Address</h5>
              <span>Name : <?= $orders_info['first_name']." ".$orders_info['last_name'] ?></span> <span>Address : <?= $orders_info['address'] ?></span><span>State : <?= $orders_info['thana'] ?></span> <span>Contact : <?= $orders_info['phone'] ?></span> <span></span> <span>City : <?= $orders_info['city'].". Pincode : ".$orders_info['post_code'] ?></span> <span><?= $orders_info['notes'] ?></span> </div>
          </div>
        </div>
       <?php if($orders_info['processed'] != 4){?>
                    <div class="row order_wrapper shipping">
                         <div class="order-details">
                              <div class="content2">
                                <div class="content2-header1">
                                    <p>Order Placed : <span><?= date('F d,Y', $orders_info['date']) ?></span></p>
                                </div>
                                <div class="content2-header1">
                                    <p>Status : <span><?php echo $type;?></span></p>
                                </div>
                                <div class="content2-header1">
                                    <p>Expected Date : <span><?= date('F d,Y', $orders_info['expected_delivery_date']) ?></span></p>
                                </div>
                                <div class="clear"></div>
                            </div>
                             <div class="content3">
                                <div class="shipment">
                                    <div class="confirm <?php if($orders_info['processed'] == 0 || $orders_info['processed'] == 1 || $orders_info['processed'] == 2 || $orders_info['processed'] == 3) echo 'active';?>">
                                        <div class="imgcircle">
                                            <img src="<?= base_url('assets/imgs/confirm.png') ?>" alt="confirm order">
                                        </div>
                                        <span class="line <?php if($orders_info['processed'] == 0 || $orders_info['processed'] == 1 || $orders_info['processed'] == 2 || $orders_info['processed'] == 3) echo 'active';?>"></span>
                                        <p>Placed</p>
                                    </div>
                                    <div class="process <?php if($orders_info['processed'] == 0 || $orders_info['processed'] == 1 || $orders_info['processed'] == 2 || $orders_info['processed'] == 3) echo 'active';?>">
                                        <div class="imgcircle">
                                            <img src="<?= base_url('assets/imgs/quality.png') ?>" alt="process order">
                                        </div>
                                        <span class="line <?php if($orders_info['processed'] == 1 || $orders_info['processed'] == 2 || $orders_info['processed'] == 3) echo 'active';?>"></span>
                                        <p>Processing</p>
                                    </div>
                                    <div class="quality <?php if($orders_info['processed'] == 1 || $orders_info['processed'] == 2 || $orders_info['processed'] == 3) echo 'active';?>">
                                        <div class="imgcircle">
                                            <img src="<?= base_url('assets/imgs/process.png') ?>" alt="quality check">
                                        </div>
                                        <span class="line <?php if($orders_info['processed'] == 2 || $orders_info['processed'] == 3) echo 'active';?>"></span>
                                        <p>Processed</p>
                                    </div>
                                    <div class="dispatch <?php if($orders_info['processed'] == 2 || $orders_info['processed'] == 3) echo 'active';?>">
                                        <div class="imgcircle">
                                            <img src="<?= base_url('assets/imgs/dispatch.png') ?>" alt="dispatch product">
                                        </div>
                                        <span class="line <?php if($orders_info['processed'] == 3) echo 'active';?>"></span>
                                        <p>Shipped</p>
                                    </div>
                                    <div class="delivery <?php if($orders_info['processed'] == 3) echo 'active';?>">
                                        <div class="imgcircle">
                                            <img src="<?= base_url('assets/imgs/delivery.png') ?>" alt="delivery">
                                        </div>
                                        <p>Delivered</p>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                            </div>
                     </div>
                    <?php } ?>
        <div class="clearfix"></div>
        <div class="col-md-12 clearfix">
          <div class="row">
            <div class="cart-list">
              <div class="table-responsive">
                <table class="table">
                  <thead class="hidden-xs">
                    <tr>
                      <th>Product</th>
                      <th>Unit Price</th>
                      <th>Line Total</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $arr_products = unserialize($orders_info['products']);
				  $total = 0;
				  foreach ($arr_products as $product) {
                       $productInfo = modules::run('admin/ecommerce/products/getProductInfo', $product['product_info']['id'], true);
					   ?>
                        <tr>
                          <td> <span> <img src="<?= base_url('attachments/shop_images/' . $product['product_info']['image']) ?>" alt="<?= $productInfo['title'] ?>" width="100"></span><h5> <a href="<?= base_url($product['product_info']['url']) ?>">  <?= $productInfo['title'] ?>  </a> </h5> <span>Quantity : <?= $product['product_quantity'];?></span></td>
                        
                          <td>
                            <span><?= $product['product_info']['price']. CURRENCY?></span></td>
                         
                          <td>
                            <span><?= $product['product_info']['price']*$product['product_quantity']. CURRENCY?></span></td>
                         
                        </tr>
                     <?php $total +=$product['product_info']['price']*$product['product_quantity'];  } ?>
                     <tr>
                     	  <td></td>
                          <td>Subtotal</td>
                          <td><?=number_format($total,2). CURRENCY?></td>
                         
                        </tr>
                         <tr>
                     	  <td></td>
                          <td>Shipping</td>
                          <td><?=number_format($orders_info['shipping_cost'],2). CURRENCY?></td>
                         
                        </tr>
                         <tr>
                     	  <td></td>
                          <td>Total</td>
                          <td><?=number_format($orders_info['total_order_price'],2). CURRENCY?></td>
                         
                        </tr>
                  </tbody>
                </table>
              </div>
            </div>
            
          </div>
        </div>
      
    </div>
  </div>
</div>
<div class="modal fade" id="track_order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Tracking Details <b id="client-name"></b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                
            </div>
            <div class="modal-body" id="preview-info-body">
              <div class="table-responsive" id="tracking_details_info">
				Loading Tracking Information ...
              </div>
            </div>
          
        </div>
    </div>
</div>
