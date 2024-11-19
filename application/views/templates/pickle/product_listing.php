<nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
                        <?php if(isset($search) && $search['suppliers']){?>
                        	<li class="breadcrumb-item"><a href="">Suppliers</a></li>
                        	<li class="breadcrumb-item active" aria-current="page"><?= $search['suppliers'];?></li>
                        <?php } ?>
                        <?php if(isset($search) && $search['state']){?>
                        	<li class="breadcrumb-item"><a href="">Location</a></li>
                        	<li class="breadcrumb-item active" aria-current="page"><?= $search['state'];?></li>
                        <?php } ?>
                        <?php if(isset($sub_category_details)){?><li class="breadcrumb-item"><a href="<?= LANG_URL . '/category?type='.$sub_category_details['id'] ?>"><?= $sub_category_details['name'];?></a></li><?php } ?>
                        <?php if(isset($category_details)){?> <li class="breadcrumb-item active" aria-current="page"><?= $category_details['name'];?></li><?php } ?>
                    </ol>
                </div><!-- End .container -->
</nav>
<div class="container">
                <div class="row">
                    <div class="col-lg-12">
                    <?php if(isset($search) && !$search['suppliers'] && !$search['state']){?>
                    <h2 class="subtitle">Search result for "<?php foreach($search as $key=>$item) if($key == 'search_in_title') echo $item;?>"</h2>
                    <?php }else{?>
                        <nav class="toolbox">
                            <div class="toolbox-left">
                                <div class="toolbox-item toolbox-sort">
                                    <div class="select-custom">
                                    	<form method="GET" id="sortform">
                                        	<?php if(isset($category_details)){?><input type="hidden" name="type" value="<?= $category_details['id'];?>" /><?php } ?>
                                            <?php if(isset($search) && $search['suppliers']){?>
                                            <input type="hidden" name="suppliers" value="<?= $search['suppliers']; ?>" />
                                            <?php } ?>
                                             <?php if(isset($search) && $search['state']){?>
                                            <input type="hidden" name="state" value="<?= $search['state']; ?>" />
                                            <?php } ?>
                                            
                                            <select name="orderby" class="form-control" onchange="sort_item(this.value);">
                                                <option value="default" <?php if(isset($order_by) && $order_by == 'default') echo 'selected="selected"';?>>Default sorting</option>
                                                <option value="price" <?php if(isset($order_by) && $order_by == 'price') echo 'selected="selected"';?>>Sort by price: low to high</option>
                                                <option value="price-desc" <?php if(isset($order_by) && $order_by == 'price-desc') echo 'selected="selected"';?>>Sort by price: high to low</option>
                                            </select>
                                        </form>
                                    </div><!-- End .select-custom -->

                                    <a href="#" class="sorter-btn" title="Set Ascending Direction"><span class="sr-only">Set Ascending Direction</span></a>
                                </div><!-- End .toolbox-item -->
                            </div><!-- End .toolbox-left -->

                 			<div class="toolbox-item toolbox-show">
                                <label>Showing <?= sizeof($products);?> of <?= $rowscount; ?> results</label>
                            </div><!-- End .toolbox-item -->

                           
                        </nav>
                        	<?php 
					}
							if(sizeof($products)>0){?>
                            <div class="row row-sm">
                            <?php 
							foreach($products as $article){?>
                            <div class="col-6 col-md-4 col-xl-3">
                                <div class="product-default mb-4">
                                    <figure>
                                        <a href="<?= LANG_URL . '/' . $article['url'] ?>">
                                            <img src="<?= base_url('/attachments/shop_images/' . $article['image']) ?>">
                                        </a>
                                    </figure>
                                    <div class="product-details">
                                        <div class="ratings-container">
                                            <div class="product-ratings">
                                                <span class="ratings" style="width:100%">
                                                	<?php for($i=1;$i<=5;$i++){?>
                                                	<i class="fa fa-star <?php if($article['rating']>=$i) echo 'active';?>"></i>
                                                    <?php } ?>
                                                 </span><!-- End .ratings -->
                                            </div><!-- End .product-ratings -->
                                        </div><!-- End .product-container -->
                                        <h2 class="product-title">
                                             <a href="<?= LANG_URL . '/' . $article['vendor_url'] . '/' . $article['url'] ?>"><?= character_limiter($article['title'], 20) ?></a>
                                        </h2>
                                        <div class="price-box">
                                            <span class="product-price"><?php if($article['default_price'] != '0') echo CURRENCY.number_format($article['default_price'], 2); else echo 'Coming soon' ?> <strike class="pevious_price"><?= $article['default_old_price'] != '0' ? CURRENCY.number_format($article['default_old_price'], 2):'' ?></strike></span>
                                        </div><!-- End .price-box -->
                                        <?php if ($article['city_name']!="") { ?>
                                        <div class="supplier_location-box mb-1"> <i class="icon-location"></i><?= $article['city_name'].", ".$article['state_name'];?></div>
                                       	<?php } ?>
                                        <div class="product-action">
                                         <?php //if ($article['quantity'] > 0){ ?>
                                           <!-- <a href="#" class="btn-icon-wish"><i class="icon-heart"></i></a>-->
                                            <a href="javascript:void(0);" class="btn-icon btn-add-cart btn-add" data-id="<?= $article['id'] ?>">
                                                           <i class="icon-bag"></i>ADD TO CART
                                            </a>
                                                      <?php /*?>  <a href="javascript:void(0);" data-goto="<?= LANG_URL . '/shopping-cart' ?>" class="btn-icon btn-add-cart add-to-cart btn-add" data-id="<?= $article['id'] ?>">
                                                           <i class="icon-shipped"></i>BUY NOW
                                                        </a><?php */?>
                                        <?php //} ?>
                                        </div>
                                    </div><!-- End .product-details -->
                                </div>
                            </div>
                            <?php }?>
                           </div>
                           <?php if ($links_pagination != '') { ?> 
							<nav class="toolbox toolbox-pagination">
                                <?= $links_pagination ?>
                                       
                                <!--<ul class="pagination">
                                    <li class="page-item disabled">
                                        <a class="page-link page-link-btn" href="#"><i class="icon-angle-left"></i></a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                    <li class="page-item"><span>...</span></li>
                                    <li class="page-item"><a class="page-link" href="#">15</a></li>
                                    <li class="page-item">
                                        <a class="page-link page-link-btn" href="#"><i class="icon-angle-right"></i></a>
                                    </li>
                                </ul>-->
                            </nav>
							<?php } }else{ ?>
                            <div class="row row-sm">
                             <div class="col-12 col-md-12 col-xl-12">
                             	<div class="alert alert-info">No Product Found.</div>
                             </div>
                             </div>
                             <?php } ?>
                      
                    </div><!-- End .col-lg-9 -->

                    <?php /*?><aside class="sidebar-shop col-lg-3 order-lg-first">
                        <div class="sidebar-wrapper">
                            <div class="widget">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-body-2" role="button" aria-expanded="true" aria-controls="widget-body-2">Men</a>
                                </h3>

                                <div class="collapse show" id="widget-body-2">
                                    <div class="widget-body">
                                        <ul class="cat-list">
                                            <li><a href="#">Accessories</a></li>
                                            <li><a href="#">Watch Fashion</a></li>
                                            <li><a href="#">Tees, Knits & Polos</a></li>
                                            <li><a href="#">Pants & Denim</a></li>
                                        </ul>
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

                            <div class="widget">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-body-3" role="button" aria-expanded="true" aria-controls="widget-body-3">Price</a>
                                </h3>

                                <div class="collapse show" id="widget-body-3">
                                    <div class="widget-body">
                                        <form action="#">
                                            <div class="price-slider-wrapper">
                                                <div id="price-slider"></div><!-- End #price-slider -->
                                            </div><!-- End .price-slider-wrapper -->

                                            <div class="filter-price-action">
                                                <button type="submit" class="btn btn-primary">Filter</button>

                                                <div class="filter-price-text">
                                                    Price:
                                                    <span id="filter-price-range"></span>
                                                </div><!-- End .filter-price-text -->
                                            </div><!-- End .filter-price-action -->
                                        </form>
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

                            <div class="widget">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-body-4" role="button" aria-expanded="true" aria-controls="widget-body-4">Size</a>
                                </h3>

                                <div class="collapse show" id="widget-body-4">
                                    <div class="widget-body">
                                        <ul class="cat-list">
                                            <li><a href="#">Small</a></li>
                                            <li><a href="#">Medium</a></li>
                                            <li><a href="#">Large</a></li>
                                            <li><a href="#">Extra Large</a></li>
                                        </ul>
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

                            <div class="widget">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-body-5" role="button" aria-expanded="true" aria-controls="widget-body-5">Brand</a>
                                </h3>

                                <div class="collapse show" id="widget-body-5">
                                    <div class="widget-body">
                                        <ul class="cat-list">
                                            <li><a href="#">Adidas</a></li>
                                            <li><a href="#">Calvin Klein (26)</a></li>
                                            <li><a href="#">Diesel (3)</a></li>
                                            <li><a href="#">Lacoste (8)</a></li>
                                        </ul>
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

                            <div class="widget">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-body-6" role="button" aria-expanded="true" aria-controls="widget-body-6">Color</a>
                                </h3>

                                <div class="collapse show" id="widget-body-6">
                                    <div class="widget-body">
                                        <ul class="config-swatch-list">
                                            <li class="active">
                                                <a href="#">
                                                    <span class="color-panel" style="background-color: #1645f3;"></span>
                                                    <span>Blue</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="color-panel" style="background-color: #f11010;"></span>
                                                    <span>Red</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="color-panel" style="background-color: #fe8504;"></span>
                                                    <span>Orange</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="color-panel" style="background-color: #2da819;"></span>
                                                    <span>Green</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->
                        </div><!-- End .sidebar-wrapper -->
                    </aside><?php */?><!-- End .col-lg-3 -->
                </div><!-- End .row -->
</div>
<script src="<?= base_url('templatejs/nouislider.min.js') ?>"></script>