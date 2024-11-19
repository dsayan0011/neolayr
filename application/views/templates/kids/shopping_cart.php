<section class="breadcrumb-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2>cart</h2>
                </div>
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cart</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="cart-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
             <?php
				if ($cartItems['array'] == null) {
					?>
                   <div class="alert alert-info"><?= lang('no_products_in_cart') ?></div>
					<?php
				} else {?>
                
                <table class="table cart-table table-responsive-xs striped-table">
                    <thead>
                    <tr class="table-head">
                        <th scope="col">image</th>
                        <th scope="col">product name</th>
                        <th scope="col">price</th>
                        <th scope="col">quantity</th>
                        <th scope="col">action</th>
                        <th scope="col">total</th>
                    </tr>
                    </thead>
                    
                    <?php
					$not_avialable = false;
					foreach ($cartItems['array'] as $item) { ?>
                    <input type="hidden" name="id[]" value="<?= $item['id'] ?>">
                    <input type="hidden" name="quantity[]" value="<?= $item['num_added'] ?>">
                    <tbody>
                    <tr>
                        <td>
                            <a href="<?= LANG_URL . '/' . $item['url'] ?>"><img src="<?= base_url('/attachments/shop_images/' . $item['image']) ?>" alt=""></a>
                        </td>
                        <td><a href="<?= LANG_URL . '/' . $item['url'] ?>"><?= $item['title'] ?></a>
                         <?php if($item['vendor_status'] == '0' || $item['variant_status']!='show' || $item['quantity']<1 ){ $not_avialable = true; ?> <span class="not_available">Currently not available</span><?php } ?>
                            <div class="mobile-cart-content row">
                                <div class="col-xs-3">
                                    <div class="qty-box">
                                        <div class="input-group cart_quanitity">
                                        	<span class="quantity-num"> <?= $item['num_added'] ?></span>
                                            <span class="input-group-btn-vertical">
                                                <a class="btn btn-outline bootstrap-touchspin-up icon-up-dir refresh-me add-to-cart <?= $item['quantity'] <= $item['num_added'] ? 'disabled' : '' ?>" data-id="<?= $item['id'] ?>" href="javascript:void(0);"></a>
                                                <a class="btn btn-outline bootstrap-touchspin-down icon-down-dir" onclick="removeProduct(<?= $item['id'] ?>, true)" href="javascript:void(0);"></a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <h2 class="td-color"><?= CURRENCY.$item['price']?></h2></div>
                                <div class="col-xs-3">
                                    <h2 class="td-color"><a href="javascript:void(0)" onclick="deleteFromCart(<?= $item['id'] ?>)" class="icon"><i class="ti-close"></i></a></h2></div>
                            </div>
                        </td>
                        <td>
                            <h2><?= CURRENCY.$item['price']?></h2></td>
                        <td>
                            <div class="qty-box">
                                <div class="input-group cart_quanitity">
                                    <span class="quantity-num"> <?= $item['num_added'] ?></span>
                                    <span class="input-group-btn-vertical">
                                                <a class="btn btn-outline bootstrap-touchspin-up icon-up-dir refresh-me add-to-cart <?= $item['quantity'] <= $item['num_added'] ? 'disabled' : '' ?>" data-id="<?= $item['id'] ?>" href="javascript:void(0);"><i class="fa fa-angle-up"></i></a>
                                                <a class="btn btn-outline bootstrap-touchspin-down icon-down-dir" onclick="removeProduct(<?= $item['id'] ?>, true)" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td><a href="javascript:void(0)" onclick="deleteFromCart(<?= $item['id'] ?>)" class="icon"><i class="ti-close"></i></a></td>
                        <td>
                            <h2 class="td-color"><?= CURRENCY.$item['sum_price']?></h2></td>
                    </tr>
                    </tbody>
                  <?php } ?>
                </table>
                <table class="table cart-table table-responsive-md">
                    <tfoot>
                    <tr>
                        <td>total price :</td>
                        <td>
                            <h2><?= CURRENCY.$cartItems['finalSum'] ?></h2></td>
                    </tr>
                    </tfoot>
                </table>
                <?php } ?>
            </div>
        </div>
        <div class="row cart-buttons">
            <div class="col-6"><a href="<?php echo base_url();?>" class="btn btn-solid">continue shopping</a></div>
            <div class="col-6">
           						<?php 
								if($not_avialable){?>
									<span class="cart_message">One or more item is not avaialbe in your cart. Please remove them to proceed checkout</span>
								<?php }else{ ?>
                                <a href="<?= LANG_URL . '/checkout' ?>" class="btn btn-solid">Go to Checkout</a>
                                <?php } ?>
			</div>
        </div>
    </div>
</section>