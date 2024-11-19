<nav aria-label="breadcrumb" class="breadcrumb-nav mb-1">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                    </ol>
                </div><!-- End .container -->
</nav>
<div class="container">
                <div class="row">
                <?php
				if ($cartItems['array'] == null) {
					?>
                    <div class="col-lg-12">
						<div class="alert alert-info"><?= lang('no_products_in_cart') ?></div>
                    </div>
					<?php
				} else {?>
                    <div class="col-lg-8">
                        <div class="cart-table-container">
                            <table class="table table-cart">
                                <thead>
                                    <tr>
                                        <th class="product-col">Product</th>
                                        <th class="price-col">Price</th>
                                        <th class="qty-col">Qty</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
								$not_avialable = false;
								foreach ($cartItems['array'] as $item) { ?>
                                <input type="hidden" name="id[]" value="<?= $item['id'] ?>">
                                <input type="hidden" name="quantity[]" value="<?= $item['num_added'] ?>">
                                    <tr class="product-row">
                                        <td class="product-col">
                                            <figure class="product-image-container">
                                                <a href="<?= LANG_URL . '/' . $item['url'] ?>" class="product-image">
                                                    <img src="<?= base_url('/attachments/shop_images/' . $item['image']) ?>" alt="<?= $item['title'] ?>">
                                                </a>
                                            </figure>
                                            <h2 class="product-title">
                                                <a href="<?= LANG_URL . '/' . $item['url'] ?>"><?= $item['title'] ?></a><br />
                                                Weight : <?= $item['weight'] ?> <?= $item['weight_unit'] ?> 
                                                <?php if($item['vendor_status'] == '0' || $item['variant_status']!='show' ){ $not_avialable = true; ?> <span class="not_available">Currently not available</span><?php } ?>
                                            </h2>
                                            
                                             
                                        </td>
                                        <td><?= $item['price'] . CURRENCY ?></td>
                                        <td>
                                        <div class="cart_quanitity input-group">
                                            <span class="quantity-num"> <?= $item['num_added'] ?></span>
                                            <span class="input-group-btn-vertical">
                                                <a class="btn btn-outline bootstrap-touchspin-up icon-up-dir refresh-me add-to-cart <?= $item['quantity'] <= $item['num_added'] ? 'disabled' : '' ?>" data-id="<?= $item['id'] ?>" href="javascript:void(0);"></a>
                                                <a class="btn btn-outline bootstrap-touchspin-down icon-down-dir" onclick="removeProduct(<?= $item['id'] ?>, true)" href="javascript:void(0);"></a>
                                            </span>
                                       	</div>
                                          
                                        </td>
                                        <td><?= $item['sum_price'] . CURRENCY ?></td>
                                    </tr>
                                    <tr class="product-action-row">
                                        <td colspan="4" class="clearfix">
                                            <div class="float-left">
                                                <a href="#" class="btn-move">Move to Wishlist</a>
                                            </div><!-- End .float-left -->
                                            
                                            <div class="float-right">
                                                <a href="javascript:void(0)" onclick="deleteFromCart(<?= $item['id'] ?>)" title="Remove product" class="btn-remove"><span class="sr-only">Remove</span></a>
                                            </div><!-- End .float-right -->
                                        </td>
                                    </tr>
								<?php } ?>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="clearfix">
                                            <div class="float-left">
                                                <a href="<?php echo base_url();?>" class="btn btn-outline-secondary">Continue Shopping</a>
                                            </div><!-- End .float-left -->

                                            <div class="float-right">
                                                <a href="javascript:void(0)" onclick="clearCart()" class="btn btn-outline-secondary btn-clear-cart">Clear Shopping Cart</a>
                                               
                                            </div><!-- End .float-right -->
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div><!-- End .cart-table-container -->

                        <?php /*?><div class="cart-discount">
                            <h4>Apply Discount Code</h4>
                            <form action="#">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" placeholder="Enter discount code"  required>
                                    <div class="input-group-append">
                                        <button class="btn btn-sm btn-primary" type="submit">Apply Discount</button>
                                    </div>
                                </div><!-- End .input-group -->
                            </form>
                        </div><?php */?><!-- End .cart-discount -->
                    </div><!-- End .col-lg-8 -->

                    <div class="col-lg-4">
                        <div class="cart-summary">
                            <h3>Summary</h3>

                           <?php /*?> <h4>
                                <a data-toggle="collapse" href="#total-estimate-section" class="collapsed" role="button" aria-expanded="false" aria-controls="total-estimate-section">Estimate Shipping and Tax</a>
                            </h4>

                            <div class="collapse" id="total-estimate-section">
                                <form action="#">
                                    <div class="form-group form-group-sm">
                                        <label>Country</label>
                                        <div class="select-custom">
                                            <select class="form-control form-control-sm">
                                                <option value="USA">United States</option>
                                                <option value="Turkey">Turkey</option>
                                                <option value="China">China</option>
                                                <option value="Germany">Germany</option>
                                            </select>
                                        </div><!-- End .select-custom -->
                                    </div><!-- End .form-group -->

                                    <div class="form-group form-group-sm">
                                        <label>State/Province</label>
                                        <div class="select-custom">
                                            <select class="form-control form-control-sm">
                                                <option value="CA">California</option>
                                                <option value="TX">Texas</option>
                                            </select>
                                        </div><!-- End .select-custom -->
                                    </div><!-- End .form-group -->

                                    <div class="form-group form-group-sm">
                                        <label>Zip/Postal Code</label>
                                        <input type="text" class="form-control form-control-sm">
                                    </div><!-- End .form-group -->

                                    <div class="form-group form-group-custom-control">
                                        <label>Flat Way</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="flat-rate">
                                            <label class="custom-control-label" for="flat-rate">Fixed $5.00</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .form-group -->

                                    <div class="form-group form-group-custom-control">
                                        <label>Best Rate</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="best-rate">
                                            <label class="custom-control-label" for="best-rate">Table Rate $15.00</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .form-group -->
                                </form>
                            </div><?php */?><!-- End #total-estimate-section -->

                            <table class="table table-totals">
                                <tbody>
                                    <tr>
                                        <td>Subtotal</td>
                                        <td><?= $cartItems['finalSum'] . CURRENCY ?></td>
                                    </tr>

                                    <tr>
                                        <td>Tax</td>
                                        <td>0.00</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Order Total</td>
                                        <td><?= $cartItems['finalSum'] . CURRENCY ?></td>
                                    </tr>
                                </tfoot>
                            </table>

                            <div class="checkout-methods">
                            	<?php 
								if($not_avialable){?>
									<span class="cart_message">One or more item is not avaialbe in your cart. Please remove them to proceed checkout</span>
								<?php }else{ ?>
                                <a href="<?= LANG_URL . '/checkout' ?>" class="btn btn-block btn-sm btn-primary">Go to Checkout</a>
                                <?php } ?>
                                
                            </div><!-- End .checkout-methods -->
                        </div><!-- End .cart-summary -->
                    </div><!-- End .col-lg-4 -->
                    <?php } ?>
                </div><!-- End .row -->
            </div>           
