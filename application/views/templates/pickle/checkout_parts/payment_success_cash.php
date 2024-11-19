<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="section-b-space light-layout">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="success-text"><i class="fa fa-check-circle" aria-hidden="true"></i>
                    <h2>thank you</h2>
                    <p>Your order has been placed successfully.</p>
                    <p>Order ID:#<?= $orders_info['order_id'] ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-b-space">
    <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product-order">
                        <h3>your order details</h3>
                         <?php
                          $arr_products = unserialize($orders_info['products']);
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
                                    <h5> <?= $productInfo['title'] ?></h5></div>
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
                                                                    <button class="btn btn-success btn-lg submit_review" data-target="<?=$counter;?>" data-reload="false" type="button" data-order-id="" data-product-id="<?=$product['product_info']['id'];?>">Save</button>
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
                                <li>shipping <span><?= number_format(($orders_info['shipping_cost']),2). CURRENCY ?></span></li>
                            </ul>
                        </div>
                        <div class="final-total">
                            <h3>total <span><?= number_format($orders_info['total_order_price'],2). CURRENCY ?></span></h3></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row order-success-sec">
                        <div class="col-sm-6">
                            <h4>summery</h4>
                            <ul class="order-detail">
                                <li>order ID: <?= $orders_info['order_id'] ?></li>
                                <li>Order Date: <?= date('F d,Y', $orders_info['date']) ?></li>
                                <li>Order Total: <?= $orders_info['total_order_price']. CURRENCY ?></li>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <h4>shipping address</h4>
                            <ul class="order-detail">
                                <li><?= $orders_info['first_name']." ".$orders_info['last_name'] ?></li>
                                <li><?= $orders_info['address'] ?></li>
                                <li><?= $orders_info['city'].", Pincode : ".$orders_info['post_code'] ?></li>
                                <li><?= "State : ".$orders_info['thana'] ?></li>
                                <li>Contact No. <?= $orders_info['phone'] ?></li>
                                <li><?= $orders_info['notes'] ?></li>
                            </ul>
                        </div>
                        <div class="col-sm-12 payment-mode">
                            <h4>payment method</h4>
                            <p><?= strtoupper($orders_info['payment_type']) ?></p>
                        </div>
                        <div class="col-md-12">
                            <div class="delivery-sec">
                                <h3>expected date of delivery</h3>
                                <h2><?= date('F d,Y', ($orders_info['expected_delivery_date'])) ?></h2></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 </section>