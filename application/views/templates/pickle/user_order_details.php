<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= LANG_URL . '/users/dashboard' ?>"><?= lang('my_acc') ?></a></li>
                        <li class="breadcrumb-item"><a href="<?= LANG_URL . '/users/orders' ?>">My Order</a></li>
                        <li class="breadcrumb-item active" aria-current="page">#<?= $orders_info['order_id'] ?></li>
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
                                      <h3>Order Ref #(<?= $orders_info['order_product_id'] ?>)</h3>
                                      <h4>Order Date : <?= date('F d,Y', $orders_info['date']) ?></h4>
                                    </div><!-- End .card-header -->

                                    <div class="card-body">
                                         <div class="row order-success-sec">
                                                <div class="col-md-12">
                                                    <?php
                                                                if ($orders_info['orderstatus'] == 0) {
																	$type = 'Processing';
																}
																if ($orders_info['orderstatus'] == 1) {
																	$type = 'Processed';
																}
																if ($orders_info['orderstatus'] == 2) {
																	$type = 'Shipped';
																}
																if ($orders_info['orderstatus'] == 3) {
																	$type = 'Delivered';
																}
																if ($orders_info['orderstatus'] == 4) {
																	$type = 'Canceled';
																}
																if ($orders_info['orderstatus'] == 5) {
																	$type = 'Settled';
																}
																if ($orders_info['orderstatus'] == 6) {
																	$type = 'Returned';
																}
																if ($orders_info['orderstatus'] == 7) {
																	$type = 'Delivered Returned Sattled';
																}
																if ($orders_info['orderstatus'] == 8) {
																	$type = 'Shipped Return';
																}
																if ($orders_info['orderstatus'] == 9) {
																	$type = 'Returned Sattled';
																}
                                                    ?>
                                                   
                                                </div>
                                                <div class="col-sm-6">
                                                    <h4>summery</h4>
                                                    <ul class="order-detail">
                                                        <li>Order Status: <?php echo  $type;?></li>
                                                        <li>Payment Method: <?= $orders_info['payment_type'] ?></li>
                                                        <?php if(strtolower($orders_info['payment_type']) != 'cashondelivery'){?>
                                                        <li>Payment Status: <?= $orders_info['payment_status'] ?></li>
                                                        <?php } ?>
                                                        <li>Email: <?= $orders_info['email'] ?></li>
                                                    </ul>
                                                    <br />
                                                    <h4>shipping address</h4>
                                                    <ul class="order-detail">
                                                        <li><?= $orders_info['first_name']." ".$orders_info['last_name'] ?></li>
                                                        <li><?= $orders_info['address'] ?></li>
                                                        <li>State : <?= $orders_info['thana'] ?></li>
                                                        <li><?= $orders_info['city'].". Pincode : ".$orders_info['post_code'] ?></li>
                                                        <li>Contact No. <?= $orders_info['phone'] ?></li>
                                                        <li><?= $orders_info['notes'] ?></li>
                                                    </ul>
                                                    <br />
                                                </div>
                                                <div class="col-sm-6 fl-right">
                                                     <?php if(strtolower($orders_info['payment_type']) != 'cashondelivery')
													 	   {
															    if($orders_info['payment_status'] == 'completed')
																$diaply_button = true;
																else
																$diaply_button = false;
														   }else $diaply_button = true;
														 if($diaply_button){?>  
														   
                                                		<a target="_blank" href="<?= base_url('/invoice/'.$orders_info['invoice_file']); ?>" class="btn btn-primary">Invoice</a>
                                                        <br />
                                                        <br />
                                                       <?php if($orders_info['orderstatus'] == "0"){?>
                                                        <a onclick="confirm_delete('<?=$orders_info['order_product_id'];?>')" href="javascript:void(0)" class="btn btn-primary">Cancel Order</a>
                                                        <?php }if($orders_info['orderstatus'] == "2"  || $orders_info['orderstatus'] == "3" || $orders_info['orderstatus'] == "5" || $orders_info['orderstatus'] == "6"){ ?>
                                                         <a href="javascript:void(0);" onclick="trackDetails(<?php echo $orders_info['order_product_id'];?>)" class="track_order btn btn-primary" data-toggle="modal" data-target="#track_order" style="margin-top:10%;">Track Order</a>
                                                        <?php } 
														 }?>
                                                       
                                                       
                                                </div>
                                                
                                            </div>
                                            <?php if($orders_info['orderstatus'] != 4){?>
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
                                                            <div class="confirm <?php if($orders_info['orderstatus'] == 0 || $orders_info['orderstatus'] == 1 || $orders_info['orderstatus'] == 2 || $orders_info['orderstatus'] == 3) echo 'active';?>">
                                                                <div class="imgcircle">
                                                                    <img src="<?= base_url('assets/imgs/confirm.png') ?>" alt="confirm order">
                                                                </div>
                                                                <span class="line <?php if($orders_info['orderstatus'] == 0 || $orders_info['orderstatus'] == 1 || $orders_info['orderstatus'] == 2 || $orders_info['orderstatus'] == 3) echo 'active';?>"></span>
                                                                <p>Placed</p>
                                                            </div>
                                                            <div class="process <?php if($orders_info['orderstatus'] == 0 || $orders_info['orderstatus'] == 1 || $orders_info['orderstatus'] == 2 || $orders_info['orderstatus'] == 3) echo 'active';?>">
                                                                <div class="imgcircle">
                                                                    <img src="<?= base_url('assets/imgs/quality.png') ?>" alt="process order">
                                                                </div>
                                                                <span class="line <?php if($orders_info['orderstatus'] == 1 || $orders_info['orderstatus'] == 2 || $orders_info['orderstatus'] == 3) echo 'active';?>"></span>
                                                                <p>Processing</p>
                                                            </div>
                                                            <div class="quality <?php if($orders_info['orderstatus'] == 1 || $orders_info['orderstatus'] == 2 || $orders_info['orderstatus'] == 3) echo 'active';?>">
                                                                <div class="imgcircle">
                                                                    <img src="<?= base_url('assets/imgs/process.png') ?>" alt="quality check">
                                                                </div>
                                                                <span class="line <?php if($orders_info['orderstatus'] == 2 || $orders_info['orderstatus'] == 3) echo 'active';?>"></span>
                                                                <p>Processed</p>
                                                            </div>
                                                            <div class="dispatch <?php if($orders_info['orderstatus'] == 2 || $orders_info['orderstatus'] == 3) echo 'active';?>">
                                                                <div class="imgcircle">
                                                                    <img src="<?= base_url('assets/imgs/dispatch.png') ?>" alt="dispatch product">
                                                                </div>
                                                                <span class="line <?php if($orders_info['orderstatus'] == 3) echo 'active';?>"></span>
                                                                <p>Shipped</p>
                                                            </div>
                                                            <div class="delivery <?php if($orders_info['orderstatus'] == 3) echo 'active';?>">
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
                                            <div class="product-order">
                                            <h3>your order details</h3>
                                            <?php
                                              $arr_products = unserialize($orders_info['order_products']);
                                              $total = 0;
											  $counter = 1;
                                              foreach ($arr_products as $product) {
                                                  $productInfo = modules::run('admin/ecommerce/products/getProductInfo', $product['product_info']['id'], true);
                                                  ?>
                                                <div class="row product-order-detail">
                                                    <div class="col-3"><img src="<?= base_url('attachments/shop_images/' . $product['product_info']['image']) ?>" alt="<?= $productInfo['title'] ?>" class="img-fluid blur-up lazyload"></div>
                                                    <div class="col-3 order_detail">
                                                        <div>
                                                            <h4>product name</h4>
                                                            <h5><a href="<?= base_url($product['product_info']['url']) ?>"> <?= $productInfo['title'] ?></a></h5></div>
                                                    </div>
                                                    <div class="col-3 order_detail">
                                                        <div>
                                                            <h4>quantity</h4>
                                                            <h5><?= $product['product_quantity'];?></h5></div>
                                                    </div>
                                                    <div class="col-3 order_detail">
                                                        <div>
                                                            <h4>price</h4>
                                                            <h5><?= $product['product_info']['price']*$product['product_quantity']. CURRENCY;?></h5></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                   <div class="col-12">
                                                	 <div class="text-right">
                                                        <a class="btn btn-success btn-green open_review_box" data-target="<?=$counter;?>" id="review_btn<?=$counter;?>" href="javascript:void(0)">Leave a Review</a>
                                                     </div>
                                                     <div class="post-review-box" style="display:none;" id="reviewbox<?=$counter;?>">
                                                      <div class="row">
                                                        <div class="col-md-12">
                                                            <form accept-charset="UTF-8" action="" method="post">
                                                                <textarea class="form-control animated" cols="50" id="comment<?=$counter;?>" name="comment<?=$counter;?>" placeholder="Enter your review here..." rows="5"></textarea>
                                                
                                                                <div class="text-right">
                                                                    <div class="stars starrr" data-rating="0"></div>
                                                                    <a class="btn btn-danger btn-sm close-review" data-target="<?=$counter;?>" href="javascript:void(0)" id="close-review-box<?=$counter;?>" style="display:none; margin-right: 10px;">
                                                                    	<span class="glyphicon glyphicon-remove"></span>Cancel
                                                                    </a>
                                                                    <button class="btn btn-success btn-lg submit_review" data-reload="false" data-target="<?=$counter;?>" type="button" data-order-id="<?=$orders_info['order_product_id'];?>" data-product-id="<?=$product['product_info']['id'];?>">Save</button>
                                                                    <br />
                                            						<span style="display:none;" id="review_save<?=$counter;?>"><img src="<?= base_url('assets/imgs/load.gif') ?>" /> Submitting your review. Please wait..</span>
                                                                </div>
                                                            </form>
                                                        </div>
                                                       </div>
                                                    </div>
                                                   </div>
                                                </div>
                                                <?php $total +=$product['product_info']['price']*$product['product_quantity']; 
												$counter++;
												} ?>
                                            
                                             <div class="total-sec">
                                                <ul>
                                                    <li>subtotal <span><?=number_format($total,2). CURRENCY?></span></li>
                                                    <?php if($orders_info['discount_amount']>0){?>
                                                    <li>Discount <span>-<?=number_format($orders_info['discount_amount'],2). CURRENCY?></span></li>
                                                    <?php } ?>
                                                   <?php /*?> <li>shipping <span>+<?= number_format($orders_info['shipping_cost'],2). CURRENCY ?></span></li><?php */?>
                                                    
                                                </ul>
                                            </div>
                                            <div class="final-total">                       
                                                <h3>total <span><?= number_format($orders_info['total_order_price'],2). CURRENCY ?></span></h3>
                                            </div>
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