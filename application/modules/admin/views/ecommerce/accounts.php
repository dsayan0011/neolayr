<link href="<?= base_url('assets/css/bootstrap-toggle.min.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/css/bootstrap-datepicker.min.css') ?>" rel="stylesheet">
<div>
    <h1><img src="<?= base_url('assets/imgs/orders.png') ?>" class="header-img" style="margin-top:-2px;"> Accounts </h1>
</div>
<hr>
<?php
    if (!empty($orders)) {
        ?>
        <div class="table-responsive">
            <table class="table table-condensed table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Payment Mathod</th>
                        <th>Payment Status</th>
                        <th class="text-center">Preview</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($orders as $tr) {
                        ?>
                        <tr>
                            <td class="relative" id="order_id-id-<?= $tr['order_id'] ?>">
                                # <?= $tr['order_id'] ?>
                               
                            </td>
                            <td><?= date('d.M.Y / H:i:s', $tr['date']); ?></td>
                            <td><?= $tr['payment_type']?>
                            </td>
                            <td>
                            <?php echo $tr['payment_status'];?>
                            </td>
                            
                            <td class="text-center">
                                <a href="javascript:void(0);" class="btn btn-default more-info" data-toggle="modal" data-target="#modalPreviewMoreInfo" style="margin-top:10%;" data-more-info="<?= $tr['order_id'] ?>">
                                    More Info 
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td class="hidden" id="order-id-<?= $tr['order_id'] ?>">
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
                                                                <?= base_url($product['product_info']['url']) ?>
                                                                <div style=" background-color: #f1f1f1; border-radius: 2px; padding: 2px 5px;">
                                                                    <b>Quantity:</b> <?= $product['product_quantity'] ?> / 
                                                                    <b>Price: <?= $product['product_info']['price'].' '.$this->config->item('currency') ?></b>
                                                                </div>
                                                            </a>
                                                            
                                                            <div class="clearfix"></div>
                                                        </div>
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
                                                	<?= $tr['total_order_price'].' '.$this->config->item('currency') ?>
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
<script src="<?= base_url('assets/js/bootstrap-toggle.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap-datepicker.min.js') ?>"></script>
<script>
                        $('.datepicker').datepicker({
                            format: "dd.mm.yyyy"
                        });
</script>