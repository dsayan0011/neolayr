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
    <li class="breadcrumb-item"><a href="<?= LANG_URL . '/users/dashboard' ?>"><?= lang('my_acc') ?></a></li>
    <li class="breadcrumb-item"><a href="<?= LANG_URL . '/users/orders' ?>">My Order</a></li>
    <li class="breadcrumb-item active" aria-current="page">#<?= $orders_info['order_id'] ?></li>
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
<div class="account-sidebar"><a class="popup-btn">my account</a></div>
<div class="dashboard-left">
<div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span></div>
<div class="block-content">
    <ul>
       <li class=""> <a href="<?= LANG_URL . '/users/dashboard' ?>"> <?= lang('vendor_dashboard') ?> </a> </li>
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
                  <h3>Order Ref #(<?= $orders_info['order_product_id'] ?>)</h3>
                  <h4>Order Date : <?= date('F d,Y', $orders_info['date']) ?></h4>
                </div>

                <div class="card-body">
                     <div class="row order-success-sec">
                     		 <?php 
							   if ($this->session->flashdata('userError')) {
								if (is_array($this->session->flashdata('userError'))) {
									$usr_err = implode('<br>', $this->session->flashdata('userError'));
								} else {
									$usr_err = $this->session->flashdata('userError');
								}
								?>
								 <div class="col-md-12">
									<div class="alert alert-danger" role="alert">
									 <?= $usr_err; ?>
									</div>
								 </div>
								<?php
								}
								if ($this->session->flashdata('userSuccess')) {
											if (is_array($this->session->flashdata('userSuccess'))) {
												$usr_err = implode('<br>', $this->session->flashdata('userSuccess'));
											} else {
												$usr_err = $this->session->flashdata('userSuccess');
											}
											?>
												<div class="alert alert-success" role="alert">
												 <?= $usr_err; ?>
												</div>
																<?php
								}
							?>
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
                                   <?php if($orders_info['orderstatus'] == "2"  || $orders_info['orderstatus'] == "3" || $orders_info['orderstatus'] == "5" || $orders_info['orderstatus'] == "6"){ ?>
                                     <a href="javascript:void(0);" onclick="trackDetails('<?php echo $orders_info['order_product_id'];?>')" class="track_order btn btn-primary" data-toggle="modal" data-target="#track_order" style="margin-top:10%;">Track Order</a>
                                    <?php } 
									 }?>
                                   
                                   
                            </div>
                            
                        </div>
                        <?php if($orders_info['orderstatus'] != 4){?>
                        <div class="row order_wrapper shipping">
                             <div class="order-details" style="width:100%">
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
                                <div class="col-3"><img src="<?= base_url('attachments/shop_images/' . $product['product_info']['image']) ?>" alt="<?= $productInfo['title'] ?>" class="img-fluid"></div>
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
                                        <h5><?= CURRENCY.$product['product_info']['price']*$product['product_quantity'];?></h5></div>
                                </div>
                            </div>
                            <div class="row">
                               <div class="col-12">
                            	 <div class="text-right">
                                    <a class="btn btn-success btn-green open_review_box" data-target="<?=$counter;?>" id="review_btn<?=$counter;?>" href="javascript:void(0)">Leave a Review</a>
                                    <?php 
									
									 $order_date = $orders_info['date'];
									 $diff = abs(time() - $order_date);  
									 $years = floor($diff / (365*60*60*24));  
									 $months = floor(($diff - $years * 365*60*60*24)/ (30*60*60*24));
									 $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
									 if($days<=30 && $diaply_button && $orders_info['orderstatus'] !='0' && !isset($product['product_returned'])){
									 ?>
                                     <a class="btn btn-success btn-danger open_return_box" data-target="<?=$counter;?>" id="return_btn<?=$counter;?>" href="javascript:void(0)">Report</a>
                                     <?php } ?>
                                 </div>
                                 <div class="post-review-box" style="display:none;" id="returnbox<?=$counter;?>">
                                  <div class="row">
                                    <div class="col-md-12">
                                        <form accept-charset="UTF-8" action="<?php echo site_url('home/ruturn_order'); ?>" method="post" enctype="multipart/form-data">
                                        	<input type="hidden" name="order_id<?=$counter;?>" value="<?=$orders_info['order_product_id'];?>" />
                                            <input type="hidden" name="product_id<?=$counter;?>" value="<?=$product['product_info']['id'];?>" />
                                            <input type="hidden" name="variant_id<?=$counter;?>" value="<?=$product['product_info']['variant_id'];?>" />
                                            
                                            <input type="hidden" name="order_product_counter" value="<?=$counter;?>" />
                                            <label>Report an Issue</label>
                                        	<select onchange="getSubReason(this.value,<?=$counter;?>)" class="form-control animated" id="return_reason<?=$counter;?>" name="return_reason<?=$counter;?>">
                                            	<option value="" disabled="disabled" selected="selected">Select Reason</option>
												<?php foreach($return_reason as $reason){?>
                                            	<option value="<?= $reason['id'];?>"><?= $reason['title'];?></option>
                                                <?php } ?>
                                            </select>
                                            <select onchange="open_others(this.value,<?=$counter;?>)" style="display:none" class="form-control animated" id="return_sub_reason<?=$counter;?>" name="return_sub_reason<?=$counter;?>">
                       
                                            </select>
                                            
                                            <input type="text" class="form-control animated" id="others_reason<?=$counter;?>" name="others_reason<?=$counter;?>" style="display:none" placeholder="Please type your issues" />
                                            
                                            <input type="file" class="form-control animated" name="return_image<?=$counter;?>" id="return_image<?=$counter;?>" style="display:none" />
                                            <p>Instruction: Click & upload a well-lit image that clearly indicate the issue.</p>
                                            
                                            <div class="text-right">
                                                <a class="btn btn-solid close-return" data-target="<?=$counter;?>" href="javascript:void(0)" id="close-return-box<?=$counter;?>" style="display:none; margin-right: 10px;">
                                                	<span class="glyphicon glyphicon-remove"></span>Cancel
                                                </a>
                                                <button class="btn btn-solid submit_reutrn_request" data-reload="true" data-target="<?=$counter;?>" type="submit" data-variant-id="<?=$product['product_info']['variant_id'];?>" data-product-id="<?=$product['product_info']['id'];?>" data-order-id="<?=$orders_info['order_product_id'];?>">Report</button>
                                                <br />
                        						<span style="display:none;" id="return_save<?=$counter;?>"><img src="<?= base_url('assets/imgs/load.gif') ?>" /> Submitting your return request. Please wait..</span>
                                            </div>
                                        </form>
                                    </div>
                                   </div>
                                </div>
                                 <div class="post-review-box" style="display:none;" id="reviewbox<?=$counter;?>">
                                  <div class="row">
                                    <div class="col-md-12">
                                        <form accept-charset="UTF-8" action="" method="post">
                                            <textarea class="form-control animated" cols="50" id="comment<?=$counter;?>" name="comment<?=$counter;?>" placeholder="Enter your review here..." rows="5"></textarea>
                            
                                            <div class="text-right">
                                                <div class="stars starrr" data-rating="0"></div>
                                                <a class="btn btn-solid close-review" data-target="<?=$counter;?>" href="javascript:void(0)" id="close-review-box<?=$counter;?>" style="display:none; margin-right: 10px;">
                                                	<span class="glyphicon glyphicon-remove"></span>Cancel
                                                </a>
                                                <button class="btn btn-solid submit_review" data-reload="false" data-target="<?=$counter;?>" type="button" data-order-id="<?=$orders_info['order_product_id'];?>" data-product-id="<?=$product['product_info']['id'];?>">Save</button>
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
                                <li>subtotal <span><?=CURRENCY.number_format($total,2)?></span></li>
                                <?php if($orders_info['discount_amount']>0){?>
                                <li>Discount <span>-<?=CURRENCY.number_format($orders_info['discount_amount'],2)?></span></li>
                                <?php } ?>
                               <?php /*?> <li>shipping <span>+<?= number_format($orders_info['shipping_cost'],2). CURRENCY ?></span></li><?php */?>
                                
                            </ul>
                        </div>
                        <div class="final-total">                       
                            <h3>total <span><?= CURRENCY.number_format($orders_info['total_order_price'],2) ?></span></h3>
                        </div>
                    </div>
                </div>
            </div>
            
</div>
</div>
</div>
</div>
</div>
</section>
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
</div> -->

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
            
            <div class="personal-info-detailed-content-right invoice-details col-lg-8">
                 <?php
    
            if ($this->session->flashdata('orderCancel')) {
                ?>
                <hr>
                <div class="alert alert-success"><?= $this->session->flashdata('orderCancel') ?></div>
                <hr>
                <?php
            } 
            ?>
               <div class="label-area d-flex justify-content-between">
                  <div class="order-title-area invoice-area">
                     <div class="">
                        <h4>Order ID: <?= $orders_info[0]['order_id'] ?></h4>
                        <p>Placed On: <strong><?= date('d/m/Y', $orders_info[0]['date']) ?></strong></p>
                     </div>
                     <div class="">
                        <a href="<?= base_url('/invoice/'.$orders_info[0]['invoice_file']); ?>" target="_blank"><img src="<?= base_url('images/bill.png') ?>" width="13" height="16" border="0" alt="">Invoice</a>
                     </div>
                  </div>
               </div>
               <div class="invoic-price">
                  <div class="row">
                     <div class="col-lg-5">
                        <strong>Order Details</strong>
                        <table>
                           <tr>
                              <td>Order ID :</td>
                              

                              
                              <td><?= $orders_info[0]['order_id'] ?></td>
                         
                           </tr>
                           <tr>
                              <td>Sub Total</td>
                              <?php if($orders_info[0]['discountTypes'] == '7'){?>
                                <td><?=CURRENCY.number_format($orders_info[0]['total_order_price_two'] + $orders_info[0]['discount_amount'],2)?></td>
                              <?php } else {?>
                                 <td><?=CURRENCY.number_format($orders_info[0]['total_order_price_two'],2)?></td>
                                 <?php } ?>
                           </tr>
                           <tr>
                              <td>Coupon Discount:</td>
                              <td><span class="">(-)<?= CURRENCY.number_format($orders_info[0]['discount_amount'],2) ?></span></td>
                           </tr>
                           <tr>
                              <td>Shipping Cost :</td>
                              <td><span class="">(+)<?= CURRENCY.number_format($orders_info[0]['order_shipping_cost'],2) ?></span></td>
                           </tr>
                            <?php if($orders_info[0]['paid_amount']>0){?>
                           <tr>
                              <td>Paid By Point:</td>
                              <td><span class="">(-)<?= CURRENCY.number_format($orders_info[0]['paid_amount'],2) ?></span></td>
                           </tr>
                       <?php } ?>
                       <?php if($orders_info[0]['gift_amount']>0){?>
                           <tr>
                              <td>Gift Coupon:</td>
                              <td><span class="">(-)<?= CURRENCY.number_format($orders_info[0]['gift_amount'],2) ?></span></td>
                           </tr>
                           <?php } ?>
                           <?php if($orders_info[0]['referral_amount']>0){?>
                           <tr>
                              <td>Referral Discount:</td>
                              <td><span class="">(-)<?= CURRENCY.number_format($orders_info[0]['referral_amount'],2) ?></span></td>
                           </tr>
                           <?php } ?>
                           <tr class="invoice-totla">
                              <td><strong>Total:</strong></td>
                              <td><?= CURRENCY.number_format($orders_info[0]['total_order_price'],2) ?></td>
                           </tr>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="invoice-address">
                  <p>Shipping Address</p>
                  <p><strong><?= $orders_info[0]['first_name']." ".$orders_info[0]['last_name'] ?>,</strong><br>
                     <?= $orders_info[0]['address'] ?><br>
                     <?= $orders_info[0]['city']."<br>".$orders_info[0]['post_code'] ?>,<br> <?= $orders_info[0]['thana'] ?><br>
                     Contact No. <?= $orders_info[0]['phone'] ?><br>
                     Payment type : <?= $orders_info[0]['payment_type'] ?><br>
                     <?php if($orders_info[0]['payment_type'] != 'cashOnDelivery'){?>
                     Payment Status : <?= $orders_info[0]['payment_status'] ?>
                     <?php } ?>
                  </p>
               </div>
               <?php
                  $counter = 1;
                  foreach ($orders_info as $value) {
                       //echo "<pre>";
                        //print_r($value); 
                    $arr_products = unserialize($value['order_products']);
                    
                    //print_r($arr_products['product_info']);
                    $total = 0;
                    
                    // foreach ($arr_products as $product) {
                        $productInfo = modules::run('admin/ecommerce/products/getProductInfo', $arr_products['product_info']['id'], true);
                      $isReview =   $this->Public_model->isReview($value['order_id'],$arr_products['product_info']['id'], $_SESSION['logged_name']);
                      //echo $isReview;
                    //     ?>
               <div class="invoice-product">
                  <div class="order-middle">
                     <div class="row">
                        <div class="col-3 col-md-2">
                           <img src="<?= base_url('attachments/shop_images/' . $arr_products['product_info']['image']) ?>" width="100%" height="auto" border="0" alt="">
                        </div>
                        <div class="col-9 col-md-10">
                           <div class="track-outer">
                              <div class="">
                                 <a href="<?= LANG_URL . '/' . $productInfo['url'] ?>"><p><?= $productInfo['title'] ?></p></a>
                              </div>
                              <!-- start track -->
                              <div class>
                                 <a href="javascript:void(0)" id="cncstoreloc" data-toggle="modal" data-target="#track-popup" onclick="orderTracking('<?php echo $value['order_id'];?>','<?php echo $arr_products['product_info']['sku'];?>')">TRACK </a>
                              </div>
                              <!-- end track -->
                           </div>
						   <!-- Modal -->
							<div id="track-popup" class="modal fade" role="dialog">
								<div class="modal-dialog">
									<!-- Modal content-->
									<div class="modal-content">
										<div class="text-left">
											<button type="button" class="close" data-dismiss="modal">&times;</button>								  
											<div class="modal-body">
												<div class="order-track">
													<p class="track-title"><strong>Track Order</strong></p>
													<div id="tracking-pre"></div>
													<div id="tracking">
													   
													</div>
												 </div>
											</div>	
										</div>
									</div>
								</div>
							</div>
							<!-- ********************* -->
                           
                           <!-- *************************** -->
                           <div class="row pqty">
                              <div class="col-4">
                                 <p><?= CURRENCY.($value['unit_price']+ $value['reward_amount']);?></p>
                              </div>
                              <div class="col-4 text-right">
                                 <p>Quantity: <strong><?= $arr_products['product_quantity'];?></strong></p>
                              </div>
                              <?php   if($value['status'] == 'delivered' && $isReview == 0){  ?>
                              <div class="col-4 text-right" id="reviewBox<?=$counter;?>">
                                 <a href="javascript:void(0)" class="comment-text">REVIEW</a>
                              </div>
                          <?php  }   ?>
                           </div>
                        </div>
                        <!-- <div class="col-lg-2">
                           </div> -->
                        <!-- <div class="col-lg-3">
                           <p class="ordfer-on">Ordered on <br><strong>06-04-2023</strong></p>
                           <p>Delivery expected by <br><strong>10-04-2023</strong></p>
                           </div> -->
                     </div>
                  </div>
                 
                  <div class="invoice-bottm">
                    <div class=" comment-box">
                        <form method="post" action="">
                            <h5>Message</h5>
                            <textarea name="" rows="" cols="" placeholder="Leave your comment" class="input-style" id="comment<?=$counter;?>" name="comment<?=$counter;?>"></textarea>
                            <div class="review-area-new">
                            <div class="stars starrr" data-rating="0"></div>
                            
                            <div class="text-right">
                            <button class="gn-button small new-input-style buy_gift submit_review" data-reload="false" data-target="<?=$counter;?>" type="button" data-order-id="<?=$value['order_id'];?>" data-product-id="<?=$arr_products['product_info']['id'];?>">Save</button>
                            
                            <button type="button" class="gn-button small new-input-style buy_gift cancel-review" data-target="<?=$counter;?>" href="javascript:void(0)" id="close-review-box<?=$counter;?>">Cancel</button>
                            </div>
                            <br />
                            <!-- <span style="display:none;" id="review_save<?=$counter;?>"><img src="<?= base_url('assets/imgs/load.gif') ?>" /> Submitting your review. Please wait..</span> -->
                        </div>
                            
                        </form>
                     </div>
                     <ul>
                        <?php if($value['status'] == 'processing' || $value['status'] == 'Created' || $value['status'] == 'Packed' || $value['status'] == 'CREATED' || $value['status'] == 'created'){?>
                        <li><a onclick="confirm_cancel('<?=$value['order_productID'];?>')" href="javascript:void(0)">Cancel</a></li>
                        <?php }?>
                        <?php if($value['status'] == 'delivered'){?>
                            <?php 
                            $result = $this->Public_model->getOrderTrackingData($value['order_id'],$value['order_product_id']);
                            $now = time(); 
                            //$order_date = $value['date'];
                            $order_date = strtotime($result['updated_date']);
                            $datediff = $now - $order_date;
                            $days = round($datediff / (60 * 60 * 24));
                            
                             
                                //echo $days;
                             ?>
                        <li><a onclick="confirm_return('<?=$value['order_productID'];?>')" href="javascript:void(0)">Return</a></li>
                        <?php } ?>
                        <!-- <li><a href="javascript:void(0)" onclick="genarate_invoice();">Invoice</a></li> -->
                     </ul>
                  </div>
              
               </div>
               <?php   $total +=$product['product_info']['price']*$product['product_quantity']; 
                  $counter++;
                  }
                  ?>
            </div>
            <div class="personal-info-detailed-content-left col-lg-4">
               <ul>
                  <li class="submenu">
                     <a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6.png') ?>" width="21" height="25" border="0" alt=""></span>Account Settings</a>
                     <ul>
                        <li><a href="<?= LANG_URL . '/users/profile' ?>">Personal information</a></li>
                        <li><a href="<?= LANG_URL . '/users/manage_address' ?>">Manage address</a></li>
                     </ul>
                  </li>
                  <li class="submenu">
                     <a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6-copy.png') ?>" width="25" height="25" border="0" alt=""></span>Order history</a>
                     <ul style="display:block">
                        <li class="active"><a href="<?= LANG_URL . '/users/orders' ?>">MY ORDERS</a></li>
                     </ul>
                  </li>
                  <li><a href="<?= LANG_URL . '/users/wishlist' ?>"><span><img src="<?= base_url('images/user-6-copy-4.png') ?>" width="23" height="21" border="0" alt=""></span>Wishlist</a></li>
                  <li class="submenu"><a href="javascript:void(0)"><span><img src="<?= base_url('images/user-6-copy-6.png') ?>" width="23" height="23" border="0" alt=""></span>Rewards</a>
                        <ul>
                            <li><a href="<?= LANG_URL . '/users/reward' ?>">Manage Reward</a></li>
                            <li><a href="<?= LANG_URL . '/users/refer_friend' ?>">Refer friends</a></li>
                        </ul>
                    </li>
                   <li><a href="<?= LANG_URL . '/users/gift' ?>"><span><img src="<?= base_url('images/gift-card.png') ?>" width="21" height="23" border="0" alt=""></span>Gift Voucher</a></li>
                  <li><a href="<?= LANG_URL . '/users/logout' ?>"><span><img src="<?= base_url('images/user-6-copy-8.png') ?>" width="21" height="23" border="0" alt=""></span>Logout</a></li>
               </ul>
            </div>
         </div>
      </div>
   </section>
   <!-- END:PERSONAL INFO PAGE -->
   <!-- SITE FOOTER-->
   <!-- END FOOTER-->
</main>