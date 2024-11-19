<!-- <section class="breadcrumb-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2>COLLECTION</h2>
                </div>
            </div>
            <div class="col-12">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
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
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="section-b-space ratio_square">
    <div class="collection-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 collection-filter">
                    
                    <div class="collection-filter-block">
                        
                        <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span></div>
                        <form method="GET" action="<?= base_url(uri_string()) ?>" id="filter_form">
                        <?php 
						
						 
						foreach($search as $key=>$value){
							if($key == 'search_in_title' || $key == 'suppliers' || $key == 'state' || $key == 'type'){
							?>
                        <input type="hidden" name="<?= $key ?>" value="<?= $value ?>" />
                        <?php } } ?>
                        <input type="hidden" name="color" id="color" value="" />
                        
						<?php foreach($attributes_set as $attribute){
							 $attributes_options = $this->Public_model->getAllAttributeOption($attribute->attribute_set_id);?>
                                <div class="collection-collapse-block open">
                                    <h3 class="collapse-block-title"><?php echo $attribute->attribute_set_name;?></h3>
                                    <div class="collection-collapse-block-content">
                                    	<?php if($attribute->attribute_set_slug == 'color'){?>
                                        <div class="color-selector">
                                            <ul>
                                            	 <?php foreach($attributes_options as $option){?>
                                                 <li onclick="set_filter_color('<?= $option->attribute_slug?>')" class="color-1 <?php if(in_array($option->attribute_slug,$search)) echo 'active'; ?>" style="background-color: <?= $option->attribute_value?>;"></li>
                                                 <?php } ?>
                                            </ul>
                                        </div>
                                        <?php }else{ ?>
                                        <div class="collection-brand-filter">
                                            <?php foreach($attributes_options as $option){?>
                                            <div class="custom-control custom-checkbox collection-filter-checkbox">
                                                <input type="checkbox" <?php if(in_array($option->attribute_slug,$search)) echo ' checked="checked"'; ?> onchange="submitSortForm()" class="custom-control-input filter_input" value="<?= $option->attribute_slug?>" name="<?= $attribute->attribute_set_slug;?>" id="<?= $option->attribute_title?>">
                                                <label class="custom-control-label" for="<?= $option->attribute_title?>"><?= $option->attribute_title?></label>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                        <?php } ?>
                         
                        </form>
                    </div>
                   
                </div>
                <div class="collection-content col">
                    <div class="page-main-content">
                        <div class="row">
                            <div class="col-sm-12">
                               
                                <div class="collection-product-wrapper">
                                    <div class="product-top-filter">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="filter-main-btn"><span class="filter-btn btn btn-solid btn-theme"><i class="fa fa-filter" aria-hidden="true"></i> Filter</span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="product-filter-content">
                                                    <div class="search-count">
                                                        <h5>Showing <?= sizeof($products);?> of <?= $rowscount; ?> results</h5></div>
                                                    <div class="collection-view">
                                                        <ul>
                                                            <li><i class="fa fa-th grid-layout-view"></i></li>
                                                            <li><i class="fa fa-list-ul list-layout-view"></i></li>
                                                        </ul>
                                                    </div>
                                                    <div class="collection-grid-view">
                                                        <ul>
                                                            <li><a href="javascript:void(0)" class="product-2-layout-view"><ul class="filter-select"><li></li><li></li></ul></a></li>
                                                            <li><a href="javascript:void(0)" class="product-3-layout-view"><ul class="filter-select"><li></li><li></li><li></li></ul></a></li>
                                                            <li><a href="javascript:void(0)" class="product-4-layout-view"><ul class="filter-select"><li></li><li></li><li></li><li></li></ul></a></li>
                                                            <li><a href="javascript:void(0)" class="product-6-layout-view"><ul class="filter-select"><li></li><li></li><li></li><li></li><li></li><li></li></ul></a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-page-filter">
                                                    <form method="GET" id="sortform">
														<?php if(isset($category_details)){?><input type="hidden" name="type" value="<?= $category_details['id'];?>" /><?php } ?>
                                                        <?php if(isset($search) && $search['suppliers']){?>
                                                        <input type="hidden" name="suppliers" value="<?= $search['suppliers']; ?>" />
                                                        <?php } ?>
                                                         <?php if(isset($search) && $search['state']){?>
                                                        <input type="hidden" name="state" value="<?= $search['state']; ?>" />
                                                        <?php } ?>
                                                        
                                                        <select name="orderby" onchange="sort_item(this.value);">
                                                            <option value="default" <?php if(isset($order_by) && $order_by == 'default') echo 'selected="selected"';?>>Default sorting</option>
                                                            <option value="price" <?php if(isset($order_by) && $order_by == 'price') echo 'selected="selected"';?>>Sort by price: low to high</option>
                                                            <option value="price-desc" <?php if(isset($order_by) && $order_by == 'price-desc') echo 'selected="selected"';?>>Sort by price: high to low</option>
                                                        </select>
                                                    </form>
                                                      
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-wrapper-grid">
                                        <div class="row">
                                         <?php 
										   foreach($products as $article){?>
                                            <div class="col-xl-3 col-md-4 col-6 col-grid-box">
                                                <div class="product-box">
                                                    <div class="img-block">
                                                        <a href="<?= LANG_URL . '/' . $article['url'] ?>"><img src="<?= base_url('/attachments/shop_images/' . $article['image']) ?>" class=" img-fluid bg-img" alt=""></a>
                                                        
                                                    </div>
                                                    <div class="product-info">
                                                        <div>
                                                        	<div class="ratings-container">
                                                                <div class="product-ratings">
                                                                    <span class="ratings" style="width:100%">
                                                                        <?php for($i=1;$i<=5;$i++){?>
                                                                                <i class="fa fa-star <?php if($article['rating']>=$i) echo 'active';?>"></i>
                                                                                <?php } ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <a href="<?= LANG_URL . '/' . $article['url'] ?>"><h6><?= character_limiter($article['title'], 20) ?></h6></a>
                                                            <h5><?php if($article['default_price'] != '0') echo CURRENCY.number_format($article['default_price'], 2); else echo 'Coming soon' ?> <strike class="pevious_price"><?= $article['default_old_price'] != '0' ? CURRENCY.number_format($article['default_old_price'], 2):'' ?></strike></h5>
                                                        </div>
                                                        <div class="product-action">
														
                                                            <button tabindex="0" class="addcart-box btn-add-cart btn-add btn btn-solid" data-id="<?= $article['id'] ?>" title="Add to cart"><i class="ti-shopping-cart" ></i> ADD TO CART</button>
                                                          
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                          <?php } ?>
                                            
                                            
                                        </div>
                                    </div>
                                     <?php if ($links_pagination != '') { ?> 
                                    <div class="product-pagination mb-2">
                                        <div class="theme-paggination-block">
                                            <div class="row">
                                                <div class="col-xl-6 col-md-6 col-sm-12">
                                                    <nav aria-label="Page navigation">
                                                       <?= $links_pagination ?>
                                                    </nav>
                                                </div>
                                                <div class="col-xl-6 col-md-6 col-sm-12">
                                                    <div class="product-search-count-bottom"><h5>Showing <?= sizeof($products);?> of <?= $rowscount; ?> results</h5></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->

<main>
            <!-- START BANNER -->
<section class="inner-banner-section position-relative">
    <img src="<?= base_url('/attachments/product_listing/'.$category_banner['image']) ?>" border="0" alt="" class="w-100">
    <div class="inner-page-banner-content position-absolute">
        <div class="container d-flex align-items-center">
            <h1 class="category-name"><?php echo $category_banner['title'] ?></h1>
            <!-- <h1 class="category-name">SHOP <?php echo $category_banner['category'] ?> PRODUCT</h1> -->
        </div>
    </div>
</section>
<!-- END BANNER  -->
<!-- START SHOP PRODUCT -->
<section class="product-listing-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
				<div class="row">
					<div class="col-lg-3"></div>
					<div class="col-lg-12">
                        <div id="" class="d-lg-flex justify-content-between breadcum-wrapper align-items-center">
                            <ol class="breadcrumb d-none d-lg-flex">
                                <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
                                <?php if(isset($search_in_title)){?>
                                    <li class="breadcrumb-item active" aria-current="page"><?= $search_in_title;?></li>
                                <?php } ?>
                                
                                <?php if(isset($fst_category_details)){?><li class="breadcrumb-item"><?= $fst_category_details['name'];?></li><?php } ?>

                                <?php if(isset($sub_category_details)){?><li class="breadcrumb-item"><?= $sub_category_details['name'];?></li><?php } ?>
                                <?php if(isset($category_details)){?> <li class="breadcrumb-item active" aria-current="page"><?= $category_details['name'];?></li><?php } ?>
                    </ol>
						<!-- <div id="" class="d-lg-flex align-items-center justify-content-between"> -->
							<!-- <div class="category-select-list">
								<a href="javascript:void(0)">Category1<span class=""><i class="fas fa-times"></i></span></a>
								<a href="javascript:void(0)">Category2<span class=""><i class="fas fa-times"></i></span></a>
								<a href="javascript:void(0)">Category3<span class=""><i class="fas fa-times"></i></span></a>
								<a href="javascript:void(0)">Category4<span class=""><i class="fas fa-times"></i></span></a>
								<a href="javascript:void(0)">Category5<span class=""><i class="fas fa-times"></i></span></a>
								<a href="javascript:void(0)">Category6<span class=""><i class="fas fa-times"></i></span></a>
							</div> -->
							<div class="sort-by-dropdown">
								<form method="GET" id="sortform">
								<?php if(isset($category_details)){?>
									<input type="hidden" name="type" value="<?= $category_details['category_slug'];?>" /><?php } ?>
                                    <?php if(isset($ingredients)){?>
                                    <input type="hidden" name="ingredients" value="<?= $ingredients;?>" /><?php } ?>

                                     <?php if(isset($searchData['face'])){
                                        foreach($searchData['face'] as $face_item){?>
                                            <input type="hidden" name="face[]" value="<?= $face_item?>" />
                                        <?php }
                                         ?>
                                    <?php } ?>
                                    <?php if(isset($searchData['body'])){
                                        foreach($searchData['body'] as $body_item){?>
                                            <input type="hidden" name="body[]" value="<?= $body_item?>" />
                                        <?php }
                                         ?>
                                    <?php } ?>
                                    <?php if(isset($searchData['hair'])){
                                        foreach($searchData['hair'] as $hair_item){?>
                                            <input type="hidden" name="hair[]" value="<?= $hair_item?>" />
                                        <?php }
                                         ?>
                                    <?php } ?>
                                    <?php if(isset($searchData['skin_concern'])){
                                        foreach($searchData['skin_concern'] as $skin_concern_item){?>
                                            <input type="hidden" name="skin_concern[]" value="<?= $skin_concern_item?>" />
                                        <?php }
                                         ?>
                                    <?php } ?>

                                    <?php if(isset($search_in_title)){?>
                                    <input type="hidden" name="search_in_title" value="<?= $search_in_title?>" /><?php } ?>


								<!-- <?php if(isset($search) && $search['suppliers']){?>
								<input type="hidden" name="suppliers" value="<?= $search['suppliers']; ?>" />
								<?php } ?>
								 <?php if(isset($search) && $search['state']){?>
								<input type="hidden" name="state" value="<?= $search['state']; ?>" />
								<?php } ?> -->
								<select name="orderby" onchange="sort_item(this.value);">
									<option value="" disabled selected>sort by</option>
									<option value="default" <?php if(isset($order_by) && $order_by == 'default') echo 'selected="selected"';?>>Recommended</option>
									<option value="price" <?php if(isset($order_by) && $order_by == 'price') echo 'selected="selected"';?>>Price: Low to high</option>
									<option value="price-desc" <?php if(isset($order_by) && $order_by == 'price-desc') echo 'selected="selected"';?>>Price: High to low</option>
								</select>
								</form>
							</div>
						</div>
					</div>
				</div>
            </div>
            <?php /* ?>
            <div class="col-lg-3">
                <form method="GET" action="<?= base_url(uri_string()) ?>" id="filter_form">
            <?php 
            
            //print_r($search['type']);
            //$cate = array();
            foreach($search as $key=> $value){
                if($key == 'body'){
                    foreach($search['body'] as $item){
                        array_push($search,$item);
                        //array_push($cate,substr($item, 0, strpos($item, "-")));
                    }
                }
                if($key == 'face'){
                    foreach($search['face'] as $faces){
                        array_push($search,$faces);
                    }
                }
                if($key == 'hair'){
                    foreach($search['hair'] as $hairs){
                        array_push($search,$hairs);
                    }
                }
                if($key == 'skin_concern'){
                    foreach($search['skin_concern'] as $skin_concerns){
                        array_push($search,$skin_concerns);
                    }
                }
                if($key == 'search_in_title' || $key == 'suppliers' || $key == 'state' || $key == 'type'){
                ?>
                <?php if($key == 'type'){?>
                    <input type="hidden" name="" value="" />
                    <?php } else { ?>
                            <input type="hidden" name="<?= $key ?>" value="<?= $value ?>" />
                    <?php } ?>

                <?php  } }?>
            
                <div class="product-category-filter">
                    <ul>
                        <li class="main-filter <?php if($searchCategory != '') echo 'close-sign active'?>">
                            <a href="javascript:void(0)">Category</a>
                            <div class="category-panel" style="display: block;">
                                <?php foreach($attributes_set as $attribute){
                 $attributes_options = $this->Public_model->getAllAttributeOption($attribute->attribute_set_id);?>
                                <ul>
                                    <?php if($attribute->attribute_set_name != 'Skin Concern') {?>
                                    <li class="sub-filter">
                                        <a href=""><?php echo $attribute->attribute_set_name;?></a>                                                    
                                        <div class="sub-category-panel" >
                                            <?php foreach($attributes_options as $option){?>
                                            <div class="checkbox">
                                                <label for="<?= $option->attribute_title?>"><input type="checkbox" <?php if(in_array($option->attribute_slug,$search)) echo ' checked="checked"'; ?>
                                                onchange="submitSortForm()"  value="<?= $option->attribute_slug?>" name="<?= $attribute->attribute_set_slug;?>[]" id="<?= $option->attribute_title?>"><?= $option->attribute_title?></label>

                                            </div>
                                            <?php } ?>
                                        </div>
                                    
                                    </li>
                                    <?php } ?>
                                </ul>
                                <?php } ?>
                            </div>
                        
                        </li>
                        <li class="main-filter">
                            <a href="javascript:void(0)">Skin Concern</a>
                            <div class="category-panel">
                                <?php foreach($attributes_set as $attribute){
                 $attributes_options = $this->Public_model->getAllAttributeOption($attribute->attribute_set_id);?>
                                <ul>
                                    <?php if($attribute->attribute_set_name == 'Skin Concern') {?>
                                    <!-- <li class="sub-filter">
                                        <a href=""><?php echo $attribute->attribute_set_name;?></a>                                                    
                                        <div class="category-panel"> -->
                                            <?php foreach($attributes_options as $option){?>
                                            <div class="checkbox">
                                                <label for="<?= $option->attribute_title?>"><input type="checkbox" <?php if(in_array($option->attribute_slug,$search)) echo ' checked="checked"'; ?>
                                                onchange="submitSortForm()"  value="<?= $option->attribute_slug?>" name="<?= $attribute->attribute_set_slug;?>[]" id="<?= $option->attribute_title?>"><?= $option->attribute_title?></label>

                                            </div>
                                            <?php } ?>
                                        <!-- </div>
                                    
                                    </li> -->
                                    <?php } ?>
                                </ul>
                                <?php } ?>
                            </div>
                        
                        </li> 
                        <!-- <li class="sub-filter">
                            <a href="">Skin Concern</a>
                            <div class="checkbox">
                                                <label><input type="checkbox" name="career_state[]" value="facewash">Facewash</label>
                                            </div>
                        </li> -->
                        <!-- <li><a href="<?= LANG_URL . '/category?type=ingredients' ?>">Ingredients</a></li> -->
                        <!-- <li class="main-filter">
							<a href="javascript:void(0)">Ingredients</a>
							<div class="category-panel" >
								<ul>
									<div class="checkbox">
										<label for="aa"><input type="checkbox" onchange="submitSortForm()" value="aa" name="skin_concern[]" id="aa">Ingredients 1</label>
									</div>
									<div class="checkbox">
										<label for="bb"><input type="checkbox" onchange="submitSortForm()" value="bb" name="skin_concern[]" id="bb">Ingredients 2</label>
									</div>
									<div class="checkbox">
										<label for="cc"><input type="checkbox" onchange="submitSortForm()" value="cc" name="skin_concern[]" id="cc">Ingredients 3</label>
									</div>
								</ul>
							</div>
						</li> -->
                    </ul>
                </div>
            </form>
            </div>
            <?php */ ?>
            <div class="col-lg-12">
                <div class="product-listing new-listing-design">
                    <?php if(sizeof($products)>0) {?>
                    <div class="row justify-content-center">
                        <?php 
                               foreach($products as $key => $article){
                                $quantity = $this->Public_model->getquantity($article['id']);
                                ?>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="each-listing-of-product">
                                <div class="product-image">
                                    <!-- <img src="<?= base_url('images/product-listing1.jpg') ?>" border="0" alt="" class="w-100"> -->
                                    <a href="<?= LANG_URL . '/' . $article['url'] ?>"><img src="<?= base_url('/attachments/shop_images/' . $article['image']) ?>" border="0" alt="" class="w-100" alt=""></a>
                                </div>
                                <div class="product-short-decription text-center">
                                    <!-- <p><a href="<?= LANG_URL . '/' . $article['url'] ?>"><?= character_limiter($article['title'], 20) ?></a></p> -->
                                    
                                    <p><a href="<?= LANG_URL . '/' . $article['url'] ?>"><?= $article['product_title'] ?></a></p>
                                    
                                </div>
                                <div class="product-price-and-description text-center">
                                    <?php if($quantity[0]['quantity'] != 0){
                                        ?>
                                    <a href="javascript:void(0)" class="btn-add-cart-list home_cart<?php echo $key ?>" data-id="<?= $article['id'] ?>" data-key="<?= $key ?>">ADD to cart <span>| </span> <?php if($article['default_price'] != '0') echo CURRENCY.number_format($article['default_price'], 2); else echo 'Coming soon' ?> </a>
                                    <a href="<?= base_url('shopping-cart') ?>" class="common-button go_to_cart<?php echo $key ?>" style='display: none;'>Go to Cart</a>
                                    <?php } else{?>
                                         <a href="javascript:void(0)" class="btn-add-cart-list">Coming soon </a>
                                    
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        
                    </div>
                    <?php }else{ ?>
                    <div>No product found!</div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END SHOP PRODUCT -->   

</main>