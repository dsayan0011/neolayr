<link href="<?= base_url('assets/css/bootstrap-toggle.min.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/bootstrap-datepicker.min.css') ?>" rel="stylesheet">
<div>
    <h1><img src="<?= base_url('assets/imgs/orders.png') ?>" class="header-img" style="margin-top:-2px;"> Orders <?= isset($_GET['settings']) ? ' / Settings' : '' ?></h1>
    <?php if (!isset($_GET['settings'])) { ?>
        <a href="?settings" class="pull-right orders-settings"><i class="fa fa-cog" aria-hidden="true"></i> <span>Settings</span></a>
    <?php } else { ?>
        <a href="<?= base_url('admin/orders') ?>" class="pull-right orders-settings"><i class="fa fa-angle-left" aria-hidden="true"></i> <span>Back</span></a>
    <?php } $perimission = $this->session->userdata('adminPermission');
	$update_order_perimission = explode(",",$perimission['update_order']);
	$display_order_perimission = explode(",",$perimission['display_order']);?>
</div>
<hr>
<div class="well hidden-xs"> 
                <div class="row">
                	<?php if ($this->session->flashdata('orderstatusError')) { ?>
                        <div class="alert alert-warning"><?= $this->session->flashdata('orderstatusError') ?></div>
                    <?php } ?>
                    <form method="GET" id="searchOrderForm" action="">
                        <div class="col-sm-4">
                            <label>Order Status:</label>
                            <select name="sort_by" class="form-control selectpicker changeOrder">
                            	  <option <?= isset($_GET['sort_by']) && $_GET['sort_by'] == '' ? 'selected=""' : '' ?> value="">All</option>
                                   <?php if(in_array("0",$display_order_perimission)){?><option <?= isset($_GET['sort_by']) && $_GET['sort_by'] == 'orderstatus_0' ? 'selected=""' : '' ?> value="orderstatus_0">Order not processed</option><?php } ?>
                                  <?php if(in_array("1",$display_order_perimission)){?><option <?= isset($_GET['sort_by']) && $_GET['sort_by'] == 'orderstatus_1' ? 'selected=""' : '' ?> value="orderstatus_1">Order processed</option><?php } ?>
                                  <?php if(in_array("2",$display_order_perimission)){?><option <?= isset($_GET['sort_by']) && $_GET['sort_by'] == 'orderstatus_2' ? 'selected=""' : '' ?> value="orderstatus_2">Order shipped</option><?php } ?>
                                  <?php if(in_array("3",$display_order_perimission)){?><option <?= isset($_GET['sort_by']) && $_GET['sort_by'] == 'orderstatus_3' ? 'selected=""' : '' ?> value="orderstatus_3">Order delivered</option><?php } ?>
                                  <?php if(in_array("4",$display_order_perimission)){?><option <?= isset($_GET['sort_by']) && $_GET['sort_by'] == 'orderstatus_4' ? 'selected=""' : '' ?> value="orderstatus_4">Order cancelled</option><?php } ?>
<?php /*?>                        <?php if(in_array("5",$display_order_perimission)){?><option <?= isset($_GET['sort_by']) && $_GET['sort_by'] == 'orderstatus_5' ? 'selected=""' : '' ?> value="orderstatus_5">Order Settled</option><?php } ?><?php */?>
                                  <?php if(in_array("6",$display_order_perimission)){?><option <?= isset($_GET['sort_by']) && $_GET['sort_by'] == 'orderstatus_6' ? 'selected=""' : '' ?> value="orderstatus_6">Order returned</option><?php } ?>
                                <?php /*?>  <?php if(in_array("7",$display_order_perimission)){?><option <?= isset($_GET['sort_by']) && $_GET['sort_by'] == 'orderstatus_7' ? 'selected=""' : '' ?> value="orderstatus_7">Order Delivered Returned Sattled</option><?php } ?><?php */?>
                                  <?php if(in_array("8",$display_order_perimission)){?><option <?= isset($_GET['sort_by']) && $_GET['sort_by'] == 'orderstatus_8' ? 'selected=""' : '' ?> value="orderstatus_8">Order Shipped Return</option><?php } ?>
                                 <?php /*?> <?php if(in_array("9",$display_order_perimission)){?><option <?= isset($_GET['sort_by']) && $_GET['sort_by'] == 'orderstatus_9' ? 'selected=""' : '' ?> value="orderstatus_9">Order Returned Sattled</option><?php } ?><?php */?>
                            </select>
                        </div>
                        
                        <div class="col-sm-4">
                            <label>Name:</label>
                            <div class="input-group">
                                <input class="form-control" placeholder="Name" type="text" value="<?= isset($_GET['seller_name']) ? $_GET['seller_name'] : '' ?>" name="seller_name">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit" value="">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>Mobile Number:</label>
                            <div class="input-group">
                                <input class="form-control" placeholder="Mobile Number" type="text" value="<?= isset($_GET['seller_number']) ? $_GET['seller_number'] : '' ?>" name="seller_number">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit" value="">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>Start Date:</label>
                            <div class="input-group">
                            	 <input class="form-control datepicker" name="start_date" value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>" type="text" autocomplete="off">
                                 <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit" value="">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>End Date:</label>
                            <div class="input-group">
                                <input class="form-control datepicker" name="end_date" value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : '' ?>" type="text" autocomplete="off">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit" value="">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>Order:</label>
                            <div class="input-group">
                                <input class="form-control" placeholder="Order Number" type="text" value="<?= isset($_GET['order_number']) ? $_GET['order_number'] : '' ?>" name="order_number">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit" value="">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </form>
                     <div class="col-sm-12" style="float:right; text-align:right; margin-top:10px;">
                    	<a class="btn btn-default" href="<?= base_url('admin/orders') ?>">Clear filter</a>
                    </div>
                </div>
            </div>
            <hr>
<?php
if (!isset($_GET['settings'])) {
    if (!empty($orders)) {
        ?>
        <?php /*?><div style="margin-bottom:10px;">
            <select class="selectpicker changeOrder">
                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'id' ? 'selected' : '' ?> value="id">Order by new</option>
                <option <?= (isset($_GET['order_by']) && $_GET['order_by'] == 'orderstatus') || !isset($_GET['order_by']) ? 'selected' : '' ?> value="orderstatus">Order by not orderstatus</option>
            </select>
        </div><?php */?>
        <div class="table-responsive">
            <table class="table table-condensed table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>User Info</th>
                        <th>Payment Info</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Preview</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($orders as $tr) {
                        if ($tr['orderstatus'] == 0) {
                            $class = 'bg-danger';
                            $type = 'Processing';
                        }
                        if ($tr['orderstatus'] == 1) {
                            $class = 'bg-success';
                            $type = 'Processed';
                        }
                        if ($tr['orderstatus'] == 2) {
                            $class = 'bg-warning';
                            $type = 'Shipped';
                        }
						if ($tr['orderstatus'] == 3) {
                            $class = 'bg-info';
                            $type = 'Delivered';
                        }
						if ($tr['orderstatus'] == 4) {
                            $class = 'bg-danger';
                            $type = 'Cancelled';
                        }
						if ($tr['orderstatus'] == 5) {
                            $class = 'bg-success';
                            $type = 'Settled';
                        }
						if ($tr['orderstatus'] == 6) {
                            $class = 'bg-success';
                            $type = 'Returned';
                        }
						if ($tr['orderstatus'] == 7) {
                            $class = 'bg-success';
                            $type = 'Delivered Returned Sattled';
                        }
						if ($tr['orderstatus'] == 8) {
                            $class = 'bg-success';
                            $type = 'Shipped Return';
                        }
						if ($tr['orderstatus'] == 9) {
                            $class = 'bg-success';
                            $type = 'Returned Sattled';
                        }
						
									if(strtolower($tr['payment_type']) != 'cashondelivery')
									{
										if($tr['payment_status'] == 'completed')
											$diaply_button = true;
										else
											$diaply_button = false;
									 }else $diaply_button = true;
									 
                        ?>
                        <tr>
                            <td class="relative" id="order_id-id-<?= $tr['order_id'] ?>">
                                # <?= $tr['order_product_id'] ?>
                                <?php if ($tr['order_viewed'] == 0 && $diaply_button) { ?>
                                    <div id="new-order-alert-<?= $tr['suborder_id'] ?>">
                                        <img src="<?= base_url('assets/imgs/new-blinking.gif') ?>" style="width:100px;" alt="blinking">
                                    </div>
                                <?php } ?>
                                <?php /*?><div class="confirm-result">
                                    <?php if ($tr['confirmed'] == '1') { ?>
                                        <span class="label label-success">Confirmed by email</span>
                                    <?php } else { ?> 
                                        <span class="label label-danger">Not Confirmed</span> 
                                    <?php } ?>
                                </div><?php */?>
                            </td>
                            <td><?= date('d.M.Y / H:i:s', $tr['date']); ?></td>
                            <td>
                                <i class="fa fa-user" aria-hidden="true"></i> <?= $tr['user_name']?><br />
                                <i class="fa fa-phone" aria-hidden="true"></i> <?= $tr['user_phone'] ?>
                            </td>
                            <td>Type : <?= $tr['payment_type']?>
                            <?php if(strtolower($tr['payment_type']) != 'cashondelivery') echo '<br>Status : '.$tr['payment_status'];?>
                            </td>
                            <td class="<?= $class ?> text-center" data-action-id="<?= $tr['suborder_id'] ?>">
                                <div class="status" style="padding:5px; font-size:16px;">
                                    -- <b><?= $type ?></b> --
                                </div>
                                 <?php 
								  if($diaply_button){?>  
                                 <?php if($tr['orderstatus'] != 4 && $tr['orderstatus'] != 5 && $tr['orderstatus'] != 7 && $tr['orderstatus'] != 9){?>
										<?php if($tr['orderstatus']!="0" && $tr['orderstatus']!="1"){?>
                                        <div style="margin-bottom:4px;"><a target="_blank" href="javascript:void(0);" onclick="trackDetails('<?php echo $tr['order_product_id'];?>')" data-toggle="modal" data-target="#track_order" class="btn btn-success btn-xs">Check Delivery Status</a></div>
                                        <br />
                                    	<?php }
										if( $tr['orderstatus']=="2"){ 
											if(in_array("3",$update_order_perimission)){?>
                                        	<div style="margin-bottom:4px;"><a href="javascript:void(0);" onclick="changeOrdersOrderStatus('<?= $tr['order_product_id']?>', 3)" class="btn btn-success btn-xs">Delivered</a></div>
                                        	<?php }if(in_array("8",$update_order_perimission)){?>
                                        	<div style="margin-bottom:4px;"><a href="javascript:void(0);" onclick="changeOrdersOrderStatus('<?= $tr['order_product_id']?>', 8)" class="btn btn-success btn-xs">Returned</a></div>
										<?php } }else if( $tr['orderstatus']=="3"){
											 if(in_array("5",$update_order_perimission)){?>
                                       	 	<?php /*?> <div style="margin-bottom:4px;"><a href="javascript:void(0);" onclick="changeOrdersOrderStatus(<?= $tr['order_product_id']?>, 5)" class="btn btn-success btn-xs">Settled</a></div><?php */?>
                                        	 <?php }  if(in_array("6",$update_order_perimission)){?>
                                             <div style="margin-bottom:4px;"><a href="javascript:void(0);" onclick="changeOrdersOrderStatus('<?= $tr['order_product_id']?>', 6)" class="btn btn-success btn-xs">Returned</a></div>
											 <?php } ?>
                                        <?php }else if( $tr['orderstatus']=="8" && in_array("9",$update_order_perimission)){?>
                                         <?php /*?><div style="margin-bottom:4px;"><a href="javascript:void(0);" onclick="changeOrdersOrderStatus(<?= $tr['order_product_id']?>, 9)" class="btn btn-success btn-xs">Settled</a></div><?php */?>
                                         <?php }else if( $tr['orderstatus']=="6" && in_array("7",$update_order_perimission)){?>
                                         <?php /*?><div style="margin-bottom:4px;"><a href="javascript:void(0);" onclick="changeOrdersOrderStatus(<?= $tr['order_product_id']?>, 7)" class="btn btn-success btn-xs">Settled</a></div><?php */?>
                                        <?php }else if( $tr['orderstatus']=="0"){
                                        		 if(in_array("1",$update_order_perimission)){?>
                                         		<div style="margin-bottom:4px;"><a href="javascript:void(0);" onclick="changeOrdersOrderStatus('<?= $tr['order_product_id']?>', 1, '<?= htmlentities($tr['products']) ?>', '<?= $tr['email'] ?>')" class="btn btn-success btn-xs">Processed</a></div>
										 		 <?php }if(in_array("4",$update_order_perimission)){?>
                                                <div style="margin-bottom:4px;"><a href="javascript:void(0);" onclick="cancel_order('<?= $tr['suborder_id'] ?>')" class="btn btn-danger btn-xs">Cancel</a></div>
										<?php } }else if($tr['orderstatus']=="1"){
												 if(in_array("0",$update_order_perimission)){?>
												 <div style="margin-bottom:4px;"><a href="javascript:void(0);" onclick="changeOrdersOrderStatus('<?= $tr['order_product_id']?>', 0)" class="btn btn-danger btn-xs">Not Processed</a></div>
                                        		 <?php } if(in_array("2",$update_order_perimission)){?>
                                        		 <div style="margin-bottom:4px;"><a href="javascript:void(0);" id="shipped_btn" onclick="changeOrdersOrderStatus('<?= $tr['order_product_id']?>', 2)" class="btn btn-warning btn-xs">Shipped</a></div>
										<?php }  } } else if($tr['orderstatus'] == 5 || $tr['orderstatus'] == 7 || $tr['orderstatus'] == 9){?>
                                        <div style="margin-bottom:4px;"><a target="_blank" href="javascript:void(0);" onclick="trackDetails('<?php echo $tr['order_product_id'];?>')" data-toggle="modal" data-target="#track_order" class="btn btn-success btn-xs">Check Delivery Status</a></div>
                                        <?php } }?>
                                        <div id="loading_wait<?= $tr['order_product_id']?>" style="display:none">Please wait..</div>
                            </td>
                            <td class="text-center">
                            	<?php if(array_key_exists('view_more_info',$perimission) && $perimission['view_more_info'] == 1){ ?>
                                <a href="javascript:void(0);" class="btn btn-default more-info" data-toggle="modal" data-target="#modalPreviewMoreInfo" style="margin-top:10%;" data-more-info="<?= $tr['suborder_id'] ?>">
                                    More Info 
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </a>
                                 <br />
                                <?php }
								 if(array_key_exists('edit_order',$perimission) && $perimission['edit_order'] == 1){ 
										if($tr['orderstatus']!="2" && $tr['orderstatus']!="3" && $tr['orderstatus']!="4" && $tr['orderstatus']!="6" && $tr['orderstatus']!="5"){?>
                                            <a href="javascript:void(0);" class="btn btn-default edit-info" data-toggle="modal" data-target="#modalEditInfo" style="margin-top:10%;" data-edit-info="<?= $tr['order_id'] ?>">
                                                Edit
                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                            </a>
                                <br />
                                <?php } }if(array_key_exists('view_invoice',$perimission) && $perimission['view_invoice'] == 1 && $diaply_button){ 
											if($tr['invoice_file']!=""){?>
                                             <a target="_blank" href="<?= base_url('/invoice/'.$tr['invoice_file']); ?>" class="btn btn-default more-info" style="margin-top:10%;">
                                                Invoice
                                                <i class="fa fa-file" aria-hidden="true"></i>
                                            </a>
                                            <?php } ?>
                                <?php } ?>
                            </td>
                            <td class="hidden" id="order-id-<?= $tr['suborder_id'] ?>">
                                <div class="table-responsive">
                                    <table class="table more-info-purchase">
                                        <tbody>
                                            <tr>
                                                <td><b>Email</b></td>
                                                <td><a href="mailto:<?= $tr['email'] ?>"><?= $tr['email'] ?></a></td>
                                            </tr>
                                             <tr>
                                                <td><b>Name</b></td>
                                                <td><?= $tr['first_name']." ".$tr['last_name'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>City</b></td>
                                                <td><?= $tr['city'] ?></td>
                                            </tr>
                                             <tr>
                                                <td><b>State</b></td>
                                                <td><?= $tr['thana'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Address</b></td>
                                                <td><?= $tr['address'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Postcode</b></td>
                                                <td><?= $tr['post_code'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Notes</b></td>
                                                <td><?= $tr['notes'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Come from site</b></td>
                                                <td>
                                                    <?php if ($tr['referrer'] != 'Direct') { ?>
                                                        <a target="_blank" href="<?= $tr['referrer'] ?>" class="orders-referral">
                                                            <?= $tr['referrer'] ?>
                                                        </a>
                                                    <?php } else { ?>
                                                        Direct traffic or referrer is not visible                       
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Payment Type</b></td>
                                                <td><?= $tr['payment_type'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Discount</b></td>
                                                <td><?= $tr['discount_type'] == 'float' ? '-' . $tr['discount_amount'] : '-' . $tr['discount_amount'] . '%' ?></td>
                                            </tr>
                                            <?php if ($tr['payment_type'] == 'PayPal') { ?>
                                                <tr>
                                                    <td><b>PayPal Status</b></td>
                                                    <td><?= $tr['paypal_status'] ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="2"><b>Products</b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <?php
                                                    $arr_products = unserialize($tr['order_products']);
													$order_total = 0;
                                                    foreach ($arr_products as $product) {
                                                        $total_amount = 0;
                                                        $total_amount += str_replace(' ', '', str_replace(',', '.',$product['product_info']['price']));
                                                        ?>
                                                        <div style="word-break: break-all;">
                                                            <div>
                                                                <img src="<?= base_url('attachments/shop_images/' . $product['product_info']['image']) ?>" alt="Product" style="width:100px; margin-right:10px;" class="img-responsive">
                                                            </div>
                                                            <a data-toggle="tooltip" data-placement="top" title="Click to preview" target="_blank" href="<?= base_url($product['product_info']['url']) ?>">
                                                                <?= base_url($product['product_info']['url']) ?>
                                                                <div style=" background-color: #f1f1f1; border-radius: 2px; padding: 2px 5px;">
                                                                    <b>Quantity:</b> <?= $product['product_quantity'] ?> / 
                                                                    <b>Price: <?= $product['product_info']['price'].' '.$this->config->item('currency') ?></b>
                                                                </div>
                                                            </a>
                                                            
                                                            <div class="clearfix"></div>
                                                        </div>
                                                        <?php $order_total += $total_amount*$product['product_quantity'];?>
                                                        <div style="padding-top:10px; font-size:16px;">Total amount of products: <?= $total_amount*$product['product_quantity'].' '.$this->config->item('currency') ?></div>
                                                        <hr>
                                                    <?php }
                                                    ?>
                                                    <b>Shipping Charge: <?= $tr['shipping_cost'].' '.$this->config->item('currency') ?></b><br />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                	<b>Total Order Amount </b>
                                                </td>
                                                <td>
                                                	<?= $order_total.' '.$this->config->item('currency') ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                            <td class="hidden" id="order-edit-id-<?= $tr['order_id'] ?>">
                                <div class="table-responsive">
                                	<div class="form-group col-sm-6">
                                                <label for="firstNameInput">First Name (<sup><?= lang('requires') ?></sup>)</label>
                                                <input id="firstNameInput" class="form-control" name="first_name" value="<?= $tr['first_name'] ?>" required type="text" placeholder="First Name">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="lastNameInput"><?= lang('last_name') ?> (<sup><?= lang('requires') ?></sup>)</label>
                                                <input id="lastNameInput" class="form-control" name="last_name" value="<?= $tr['last_name'] ?>" required type="text" placeholder="<?= lang('last_name') ?>">
                                            </div>
                                             <div class="form-group col-sm-6">
                                                <label for="phoneInput"><?= lang('phone') ?> (<sup><?= lang('requires') ?></sup>)</label>
                                                <input id="phoneInput" class="form-control" name="phone" value="<?= $tr['phone'] ?>" type="text" required placeholder="<?= lang('phone') ?>">
                                            </div>
                                             <div class="form-group col-sm-6">
                                                <label for="phoneInput"><?= lang('email') ?> (<sup><?= lang('requires') ?></sup>)</label>
                                                <input id="phoneInput" class="form-control" name="email" value="<?= $tr['email'] ?>" type="text" required placeholder="<?= lang('email') ?>">
                                            </div>
                                           <div class="form-group col-sm-12">
                                            	<?php $default_delivery_charges = 0;?>
                                                <label for="cityInput"><?= lang('city') ?> (<sup><?= lang('requires') ?></sup>)</label>
                                                 <select name="city" class="form-control">
                                                 <option  value="<?php echo $tr['city'];?>"><?php echo $tr['city'];?></option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label for="addressInput"><?= lang('address') ?> (<sup><?= lang('requires') ?></sup>)</label>
                                                <textarea id="addressInput" name="address" class="form-control" rows="3"><?= $tr['address'] ?></textarea>
                                            </div>
                                            
                                            <div class="form-group col-sm-6">
                                                <label for="postInput"><?= lang('post_code') ?> (<sup><?= lang('requires') ?></sup>)</label>
                                                <input id="postInput" class="form-control" name="post_code" required value="<?= $tr['post_code'] ?>" type="text" placeholder="<?= lang('post_code') ?>">
                                            </div>
                                             <div class="form-group col-sm-6">
                                                <label for="postInput">State (<sup><?= lang('requires') ?></sup>)</label>
                                                <select name="thana" id="thana" class="form-control">
                                                	<option value="<?php echo $tr['thana'];?>"><?php echo $tr['thana'];?></option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label for="notesInput"><?= lang('notes') ?></label>
                                                <textarea id="notesInput" class="form-control" name="notes" rows="3"><?= $tr['notes'] ?></textarea>
                                            </div>
                                            <div class="form-group col-sm-12">
                                            	<button type="submit" name="edit_order" class="btn btn-default">UPDATE</button>
                                            </div>
                                           
                                    <table class="table more-info-purchase">
                                        <tbody>
                                         
                                            <tr>
                                                <td colspan="2"><b>Products</b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <?php
                                                    $arr_products = unserialize($tr['products']);
                                                    foreach ($arr_products as $product) {
                                                        $total_amount = 0;
                                                        $total_amount += str_replace(' ', '', str_replace(',', '.',$product['product_info']['price']));
                                                        ?>
                                                        <div style="word-break: break-all;">
                                                            <div>
                                                                <img src="<?= base_url('attachments/shop_images/' . $product['product_info']['image']) ?>" alt="Product" style="width:100px; margin-right:10px;" class="img-responsive">
                                                            </div>
                                                            <a data-toggle="tooltip" data-placement="top" title="Click to preview" target="_blank" href="<?= base_url($product['product_info']['url']) ?>">
                                                                
                                                                <div style=" background-color: #f1f1f1; border-radius: 2px; padding: 2px 5px;">
                                                                    <b>Quantity:</b> <?= $product['product_quantity'] ?><br />
                                                                     <b>Price Price: <?= $product['product_info']['price'].' '.$this->config->item('currency') ?></b><br />
                                                                </div>
                                                            </a>
                                                            
                                                            <div class="clearfix"></div>
                                                        </div>
                                                        <div style="padding-top:10px; font-size:16px;">Total amount of products: <?= $total_amount.' '.$this->config->item('currency') ?></div>
                                                        <hr>
                                                    <?php }
                                                    ?>
                                                    
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?= $links_pagination ?>
    <?php } else { ?>
        <div class="alert alert-info">No orders to the moment!</div>
    <?php }
    ?>        
    <hr>
    <?php
}
if (isset($_GET['settings'])) {
    ?>
    <h3>Cash On Delivery</h3>
    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">Change visibility of this purchase option</div>
                <div class="panel-body">
                    <?php if ($this->session->flashdata('cashondelivery_visibility')) { ?>
                        <div class="alert alert-info"><?= $this->session->flashdata('cashondelivery_visibility') ?></div>
                    <?php } ?>
                    <form method="POST" action="">
                        <input type="hidden" name="cashondelivery_visibility" value="<?= $cashondelivery_visibility ?>">
                        <input <?= $cashondelivery_visibility == 1 ? 'checked' : '' ?> data-toggle="toggle" data-for-field="cashondelivery_visibility" class="toggle-changer" type="checkbox">
                        <button class="btn btn-default" value="" type="submit">
                            Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <h3>Online Payment Settings</h3>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">Freecharge Payment</div>
                <div class="panel-body">
                    <?php if ($this->session->flashdata('freecharge_payment')) { ?>
                        <div class="alert alert-info"><?= $this->session->flashdata('freecharge_payment') ?></div>
                    <?php } ?>
                    <form method="POST" action="">
                        <input type="hidden" name="freecharge_payment" value="<?= $freecharge_payment ?>">
                        <input <?= $freecharge_payment == 1 ? 'checked' : '' ?> data-toggle="toggle" data-for-field="freecharge_payment" class="toggle-changer" type="checkbox">
                        <button class="btn btn-default" value="" type="submit">
                            Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">Razopay Payment</div>
                <div class="panel-body">
                    <?php if ($this->session->flashdata('razorpay_payment')) { ?>
                        <div class="alert alert-info"><?= $this->session->flashdata('razorpay_payment') ?></div>
                    <?php } ?>
                    <form method="POST" action="">
                        <input type="hidden" name="razorpay_payment" value="<?= $razorpay_payment ?>">
                        <input <?= $razorpay_payment == 1 ? 'checked' : '' ?> data-toggle="toggle" data-for-field="razorpay_payment" class="toggle-changer" type="checkbox">
                        <button class="btn btn-default" value="" type="submit">
                            Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php /*?><hr>
    <h3>Bank Account Settings</h3>
    <div class="row">
        <div class="col-sm-6">
            <?php if ($this->session->flashdata('bank_account')) { ?>
                <div class="alert alert-info"><?= $this->session->flashdata('bank_account') ?></div>
            <?php } ?>
            <form method="POST" action="">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="2"><b>Pay to - Recipient name/ltd</b></td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="text" name="name" value="<?= $bank_account != null ? $bank_account['name'] : '' ?>" class="form-control" placeholder="Example: BoxingTeam Ltd."></td>
                            </tr>
                            <tr>
                                <td><b>IBAN</b></td>
                                <td><b>BIC</b></td>
                            </tr>
                            <tr>
                                <td><input type="text" class="form-control" value="<?= $bank_account != null ? $bank_account['iban'] : '' ?>" name="iban" placeholder="Example: BG11FIBB329291923912301230"></td>
                                <td><input type="text" class="form-control" value="<?= $bank_account != null ? $bank_account['bic'] : '' ?>" name="bic" placeholder="Example: FIBBGSF"></td>
                            </tr>
                            <tr>
                                <td colspan="2"><b>Bank</b></td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="text" value="<?= $bank_account != null ? $bank_account['bank'] : '' ?>" name="bank" class="form-control" placeholder="Example: First Investment Bank"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <input type="submit" class="form-control" value="Save Bank Account Settings">
            </form>
        </div>
    </div><?php */?>
<?php } ?>
<!-- Modal for more info buttons in orders -->
<div class="modal fade" id="modalPreviewMoreInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Preview <b id="client-name"></b></h4>
            </div>
            <div class="modal-body" id="preview-info-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="track_order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Tracking Details <b id="client-name"></b></h4>
            </div>
            <div class="modal-body" id="preview-info-body">
              <div class="table-responsive" id="tracking_details_info">
              		Loading Tracking Information ...
			
              </div>
            </div>
          
        </div>
    </div>
</div>
<div class="modal fade" id="modalEditInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Order Information <b id="client-name"></b></h4>
            </div>
            <form method="post">
            <input type="hidden" name="order_id" id="order_id" value="" />
            <div class="modal-body" id="preview-edit-body">

            </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="cancel_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Enter Cancel Reason <b id="client-name"></b></h4>
            </div>
            <div class="modal-body">
              <form method="POST" action="<?= base_url('admin/cancelOrder') ?>">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td><input type="text" class="form-control" value="" name="cancel_reason" placeholder="Enter Cancel Reason"></td>
                                
                            </tr>
                        </tbody>
                    </table>
                </div>
                <input type="hidden" name="the_id" value="" id="the_id"  />
                 <input type="hidden" name="to_status" value="4"  />
                <input type="submit" class="form-control" value="Save">
            </form>
            </div>
          
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/bootstrap-toggle.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap-datepicker.min.js') ?>"></script>
<script>
                        $('.datepicker').datepicker({
                            format: "dd.mm.yyyy"
                        });
</script>