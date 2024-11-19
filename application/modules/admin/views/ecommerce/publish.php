<style>
    /*.product_add{
        display: none;
    }
    .regime_hide{
        display: none;
    }*/
    .productTypeDisabled{
        cursor: none;
        pointer-events: none;
    }
    .regime_product{
        height: 200px;
        width: 100%;
        overflow-x: hidden;
        overflow-y: scroll;
/*        background: rgba(0, 128, 0, 0.3);*/
        padding: 5px;
        font-size: 12px;
        letter-spacing: 2px;
/*        text-align: justify;*/
        border: 1px solid black;

    }
    /*.publish{
        display: none;
    }*/
</style>
<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;"> Publish product</h1>
<hr>
<?php
$timeNow = time();
if (validation_errors()) {
    ?>
    <hr>
    <div class="alert alert-danger"><?= validation_errors() ?></div>
    <hr>
    <?php
}
if ($this->session->flashdata('result_publish')) {
    ?>
    <hr>
    <div class="alert alert-success"><?= $this->session->flashdata('result_publish') ?></div>
    <hr>
    <?php
}
?>
<form method="POST" action="" enctype="multipart/form-data">
    <input type="hidden" value="<?= isset($_POST['folder']) ? $_POST['folder'] : $timeNow ?>" name="folder">
    
    <div id="product_add" class="<?= isset($_POST['id']) ? '' : 'product_add' ?>">
     <!-- <div class="form-group for-shop regime_product <?= $_POST['product_type'] == 'regime' ? '' : 'regime_hide' ?> " id="for_regime">
        <b>Regime Product</b><br><br>
        <?php foreach ($getRegimeProduct as $item) { ?>
            <input type="checkbox" id="regime_product" name="regime_product[]" value="<?= $item['productID'] ?>" <?php if(in_array($item['productID'],$regimeProduct)) echo 'checked'; ?>>
            <label for="regime_product" > <?= $item['productTitle'] ?></label>
            
            <?php } ?>
    </div> -->
    
    <div class="form-group available-translations">
        <b>Languages</b>
        <?php foreach ($languages as $language) { ?>
            <button type="button" data-locale-change="<?= $language->abbr ?>" class="btn btn-default locale-change text-uppercase <?= $language->abbr == MY_DEFAULT_LANGUAGE_ABBR ? 'active' : '' ?>">
                <img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">
                <?= $language->abbr ?>
            </button>
        <?php } ?>
    </div>
    <?php
    $i = 0;
    foreach ($languages as $language) {
        ?>
        <div class="locale-container locale-container-<?= $language->abbr ?>" <?= $language->abbr == MY_DEFAULT_LANGUAGE_ABBR ? 'style="display:block;"' : '' ?>>
            <input type="hidden" name="translations[]" value="<?= $language->abbr ?>">
            <div class="form-group"> 
                <label>Title (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <input type="text" name="title[]" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['title']) ? $trans_load[$language->abbr]['title'] : '' ?>" class="form-control">
            </div>

            <!-- <div class="form-group">
                <a href="javascript:void(0);" class="btn btn-default showSliderDescrption" data-descr="<?= $i ?>">Show Slider Description <span class="glyphicon glyphicon-circle-arrow-down"></span></a>
            </div> -->
            <div class="theSliderDescrption" id="theSliderDescrption-<?= $i ?>" <?= isset($_POST['in_slider']) && $_POST['in_slider'] == 1 ? 'style="display:block;"' : '' ?>>
                <div class="form-group">
                    <label for="basic_description<?= $i ?>">Slider Description (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                    <textarea name="basic_description[]" id="basic_description<?= $i ?>" rows="50" class="form-control"><?= $trans_load != null && isset($trans_load[$language->abbr]['basic_description']) ? $trans_load[$language->abbr]['basic_description'] : '' ?></textarea>
                    <script>
                        CKEDITOR.replace('basic_description<?= $i ?>');
                        CKEDITOR.config.entities = false;
                    </script>
                </div>
            </div>
            <div class="form-group">
                <label for="description<?= $i ?>">Description (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <textarea name="description[]" id="description<?= $i ?>" rows="50" class="form-control"><?= $trans_load != null && isset($trans_load[$language->abbr]['description']) ? $trans_load[$language->abbr]['description'] : '' ?></textarea>
                <script>
                    CKEDITOR.replace('description<?= $i ?>');
                    CKEDITOR.config.entities = false;
                </script>
            </div>
           <!--  <div class="form-group for-shop">
                <label>Offer Price (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <input type="text" name="default_price[]" placeholder="without currency at the end" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['default_price']) ? $trans_load[$language->abbr]['default_price'] : '' ?>" class="form-control">
            </div>
            <div class="form-group for-shop">
                <label>Actual Price (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <input type="text" name="default_old_price[]" placeholder="without currency at the end" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['default_old_price']) ? $trans_load[$language->abbr]['default_old_price'] : '' ?>" class="form-control">
            </div> -->
          
        </div>
        <?php
        $i++;
    }
    ?>
    <div class="form-group bordered-group">
        <?php
        if (isset($_POST['image']) && $_POST['image'] != null) {
            $image = 'attachments/shop_images/' . $_POST['image'];
            if (!file_exists($image)) {
                $image = 'attachments/no-image.png';
            }
            ?>
            <p>Current image:</p>
            <div>
                <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
            </div>
            <input type="hidden" name="old_image" value="<?= $_POST['image'] ?>">
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="image" value="<?= $_POST['image'] ?>">
                <?php
            }
        }
        ?>
        <label for="userfile">Cover Image</label>
        <input type="file" id="userfile" name="userfile">
    </div>
    <div class="form-group bordered-group">
        <div class="others-images-container">
            <?= $otherImgs ?>
        </div>
        <a href="javascript:void(0);" data-toggle="modal" data-target="#modalMoreImages" class="btn btn-default">Upload more images</a>
    </div>
    <div class="form-group bordered-group">
        <div class="plus-images-container">
            <?= $plusImgs ?>
        </div>
        <a href="javascript:void(0);" data-toggle="modal" data-target="#oneMoreImages" class="btn btn-default">Upload A+ images</a>
    </div>
    <div class="form-group for-shop">
        <label>SKU</label>
        <input type="text" placeholder="SKU" name="sku" value="<?= @$_POST['sku'] ?>" class="form-control">
    </div>
    <div class="form-group for-shop">
        <label>HSN Code</label>
        <input type="text" placeholder="HSN Code" name="hsn_code" value="<?= @$_POST['hsn_code'] ?>" class="form-control">
    </div>
    <div class="form-group for-shop">
        <label>Shop Categories</label>
        <select class="selectpicker form-control show-tick show-menu-arrow" name="shop_categorie[]" multiple>
            <?php foreach ($shop_categories as $key_cat => $shop_categorie) { 
                //print_r($shop_categorie); exit;
                ?>
                <option <?php if(isset($_POST['shop_categorie']) && in_array($key_cat,$shopCategorie)) echo 'selected'; ?>  value="<?= $key_cat ?>">
                    <?php
                    foreach ($shop_categorie['info'] as $nameAbbr) {
                        if ($nameAbbr['abbr'] == $this->config->item('language_abbr')) {
                            echo $nameAbbr['name'];
                        }
                    }
                    ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group for-shop">
            <label>Related Product</label>
            <select class="selectpicker form-control show-tick show-menu-arrow" name="related_products[]" multiple="multiple">
                <?php foreach ($allProduct as $product) {
                    if($_POST['id'] != $product['id'] && $product['sku'] != '') {
                 ?>

                    <option <?php if(isset($_POST['id']) && in_array($product['sku'],$relatedProduct)) echo 'selected'; ?> value="<?= $product['sku'] ?>"><?= $product['sku'] ?></option>
                <?php } } ?>
            </select>
        </div>
        <div class="form-group for-shop">
            <label>Frequently Bougth product</label>
            <select class="selectpicker form-control show-tick show-menu-arrow" name="frequently_bought[]" multiple="multiple">
                <?php foreach ($allProduct as $product) {
                    if(($_POST['id'] != $product['id']) && ($product['sku'] != '')) {
                 ?>

                    <option <?php if(isset($_POST['frequently_bought']) && in_array($product['sku'],$frequentlyBought)) echo 'selected'; ?> value="<?= $product['sku'] ?>"><?= $product['sku'] ?></option>
                <?php } } ?>
            </select>
        </div>
            <div class="form-group"> 
                <label>WHAT IS IT? (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <input type="text" placeholder="WHAT IS IT?" name="what_is_it" value="<?= @$_POST['what_is_it'] ?>" class="form-control">
                
            </div>

            <div class="form-group"> 
                <label>WHY DO YOU NEED IT? (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <input type="text" placeholder="WHY DO YOU NEED IT?" name="why_do_you_ned_it" value="<?= @$_POST['why_do_you_ned_it'] ?>" class="form-control">
                
            </div>

            <div class="form-group"> 
                <label>HOW DOSE IT HELP? (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <input type="text" placeholder="HOW DOSE IT HELP?" name="how_dose_it_help" value="<?= @$_POST['how_dose_it_help'] ?>" class="form-control">
            </div>
            <div class="form-group"> 
                <label>WHEN TO USE? (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <input type="text" placeholder="WHEN TO USE?" name="when_to_use" value="<?= @$_POST['when_to_use'] ?>" class="form-control">
            </div>
            <div class="form-group"> 
                <label>WHERE TO APPLY? (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <input type="text" placeholder="WHERE TO APPLY?" name="where_to_apply" value="<?= @$_POST['where_to_apply'] ?>" class="form-control">
            </div>
            <div class="form-group"> 
                <label>WHO IS IT FOR? (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <input type="text" placeholder="WHO IS IT FOR?" name="who_is_it_for" value="<?= @$_POST['who_is_it_for'] ?>" class="form-control">
            </div>
    <?php if ($showBrands == 1) { ?>
        <div class="form-group for-shop">
            <label>Brand</label>
            <select class="selectpicker" name="brand_id">
                <?php foreach ($brands as $brand) { ?>
                    <option <?= isset($_POST['brand_id']) && $_POST['brand_id'] == $brand['id'] ? 'selected' : '' ?> value="<?= $brand['id'] ?>"><?= $brand['name'] ?></option>
                <?php } ?>
            </select>
        </div>
    <?php } if ($virtualProducts == 1) { ?>
        <div class="form-group for-shop">
            <label>Virtual Products <a href="javascript:void(0);" data-toggle="modal" data-target="#virtualProductsHelp"><i class="fa fa-question-circle" aria-hidden="true"></i></a></label>
            <textarea class="form-control" name="virtual_products"><?= @$_POST['virtual_products'] ?></textarea>
        </div>
    <?php } ?>
    <div class="form-group for-shop">
        <label>Product Type</label>
        <select class="selectpicker form-control" name="product_type" id="productType">          
            <option value="" <?= isset($_POST['product_type']) && $_POST['product_type'] == '' ? 'selected' : '' ?> class="<?= isset($_POST['product_type']) ? 'productTypeDisabled' : 'productTypeDisabled' ?>">Please Select Product Type</option>
            <option value="single" <?= isset($_POST['product_type']) && $_POST['product_type'] == 'single' ? 'selected' : '' ?>>Single Product</option>
            <option value="regime" <?= isset($_POST['product_type']) && $_POST['product_type'] == 'regime' ? 'selected' : '' ?>>Regime Product</option>
        </select>
    </div>
    <div class="form-group for-shop">
        <label>Trending Product</label>
        <select class="selectpicker form-control" name="is_trending_product">
            <option value="no" <?= isset($_POST['is_trending_product']) && $_POST['is_trending_product'] == 'no' ? 'selected' : '' ?>>No</option>
            <option value="yes" <?= isset($_POST['is_trending_product']) && $_POST['is_trending_product'] == 'yes' || !isset($_POST['is_trending_product']) ? 'selected' : '' ?>>Yes</option>
        </select>
    </div>
    <div class="form-group for-shop">
        <label>Featured Products</label>
        <select class="selectpicker form-control" name="is_featured_products">
            <option value="no" <?= isset($_POST['is_featured_products']) && $_POST['is_featured_products'] == 'no' ? 'selected' : '' ?>>No</option>
            <option value="yes" <?= isset($_POST['is_featured_products']) && $_POST['is_featured_products'] == 'yes' || !isset($_POST['is_featured_products']) ? 'selected' : '' ?>>Yes</option>
        </select>
    </div>
    <!-- <div class="form-group for-shop">
        <label>Display In Home</label>
        <select class="selectpicker form-control" name="in_slider">
            <option value="1" <?= isset($_POST['in_slider']) && $_POST['in_slider'] == 1 ? 'selected' : '' ?>>Yes</option>
            <option value="0" <?= isset($_POST['in_slider']) && $_POST['in_slider'] == 0 || !isset($_POST['in_slider']) ? 'selected' : '' ?>>No</option>
        </select>
    </div> -->
    <div class="form-group for-shop">
        <label>Best Seller Product</label>
        <select class="selectpicker form-control" name="is_best_seller">
            <option value="no" <?= isset($_POST['is_best_seller']) && $_POST['is_best_seller'] == 'no' ? 'selected' : '' ?>>No</option>
            <option value="yes" <?= isset($_POST['is_best_seller']) && $_POST['is_best_seller'] == 'yes' || !isset($_POST['is_best_seller']) ? 'selected' : '' ?>>Yes</option>
        </select>
    </div>
    <div class="form-group for-shop">
        <label>Newly Launch Product</label>
        <select class="selectpicker form-control" name="is_newly_launch">
            <option value="no" <?= isset($_POST['is_newly_launch']) && $_POST['is_newly_launch'] == 'no' ? 'selected' : '' ?>>No</option>
            <option value="yes" <?= isset($_POST['is_newly_launch']) && $_POST['is_newly_launch'] == 'yes' || !isset($_POST['is_newly_launch']) ? 'selected' : '' ?>>Yes</option>
        </select>
    </div>
    <div class="form-group for-shop">
        <label>Giftset Product</label>
        <select class="selectpicker form-control" name="is_giftset">
            <option value="no" <?= isset($_POST['is_giftset']) && $_POST['is_giftset'] == 'no' ? 'selected' : '' ?>>No</option>
            <option value="yes" <?= isset($_POST['is_giftset']) && $_POST['is_giftset'] == 'yes' || !isset($_POST['is_giftset']) ? 'selected' : '' ?>>Yes</option>
        </select>
    </div>
    <div class="form-group for-shop">
        <label>Position</label>
        <input type="text" placeholder="Position number" name="position" value="<?= @$_POST['position'] ?>" class="form-control">
    </div>
    <div class="form-group for-shop">
        <label>Product Video</label>
        <input type="text" placeholder="Product Video" name="product_video" value="<?= @$_POST['product_video'] ?>" class="form-control">
    </div>
    <div class="form-group for-shop">
        <label>Image ALT</label>
        <input type="text" placeholder="Image ALT" name="image_alt" value="<?= @$_POST['image_alt'] ?>" class="form-control">
    </div>
    <div class="form-group for-shop">
         <label>Tags</label>
        <!-- <input type="text" placeholder="Enter Tags" name="tags" value="<?= @$_POST['tag'] ?>" class="form-control"> -->
            <select class="selectpicker form-control show-tick show-menu-arrow" name="tag[]" multiple="multiple">
                <?php foreach ($getTags as $tag) {
                    //if($_POST['id'] != $product['id'] && $product['sku'] != '') {
                 ?>

                    <option <?php if(isset($_POST['tag']) && in_array($tag['ingredientsID'],$tags)) echo 'selected'; ?> value="<?= $tag['ingredientsID'] ?>"><?= $tag['ingredientsTitle'] ?></option>
                <?php  } ?>
            </select>
    </div>
    <div class="form-group bordered-group">
       
        <div class="tag-images-container">
            <?= $tagImgs ?>
        </div>
        <a href="javascript:void(0);" data-toggle="modal" data-target="#tagImages" class="btn btn-default">Upload Good To Know Images</a>
    </div>
    <!-- <div class="form-group for-shop">
        <label>Courier Charge</label>
        <select class="selectpicker" name="courier_charge">
            <option value="yes" <?= isset($_POST['courier_charge']) && $_POST['courier_charge'] == 'yes' ? 'selected' : '' ?>>Yes</option>
            <option value="no" <?= isset($_POST['courier_charge']) && $_POST['courier_charge'] == 'no' || !isset($_POST['courier_charge']) ? 'selected' : '' ?>>No</option>
        </select>
    </div>
    <div class="form-group for-shop">
        <label>Rating</label>
         <input type="text" placeholder="Overall Rating" name="rating" value="<?= @$_POST['rating'] ?>" class="form-control">
    </div> -->
    <!-- <div class="form-group for-shop">
        <label>Min Age</label>
        <input type="text" placeholder="" name="min_age" value="<?= @$_POST['min_age'] ?>" class="form-control">
    </div> 
    <div class="form-group for-shop">
        <label>Max Age</label>
        <input type="text" placeholder="" name="max_age" value="<?= @$_POST['max_age'] ?>" class="form-control">
    </div>
     <div class="form-group for-shop">
        <label>Age Unit</label>
        <select class="selectpicker" name="age_unit">
            <option value="year" <?= isset($_POST['age_unit']) && $_POST['age_unit'] == 'year' ? 'selected' : '' ?>>Year</option>
            <option value="month" <?= isset($_POST['age_unit']) && $_POST['age_unit'] == 'month' || !isset($_POST['age_unit']) ? 'selected' : '' ?>>Month</option>
        </select>
    </div> -->
    <!-- <div class="form-group for-shop">
        <label>Vendor</label>
        <select class="selectpicker" name="vendor_id">
            <?php foreach ($vendors->result() as $vendor) { ?>
                    <option <?= isset($_POST['vendor_id']) && $_POST['vendor_id'] == $vendor->id ? 'selected' : '' ?> value="<?= $vendor->id ?>"><?= $vendor->warehouse_name ?></option>
            <?php } ?>
        </select>
    </div>
     <div class="form-group for-shop">
        <label>Days To Deliver</label>
        <input type="number" placeholder="" name="days_to_deliver" value="<?= @$_POST['days_to_deliver'] ?>" class="form-control">
    </div> -->
    <p><b>Product Attrbutes</b></p>
     <hr />
    <div class="form-group for-shop">
        <label>Body</label>
        <select class="selectpicker form-control show-tick show-menu-arrow" name="body[]" multiple>
            <?php foreach ($body as $value) {
                    //if($_POST['id'] != $product['id'] && $product['sku'] != '') {
                 ?>
        <option <?php if(isset($_POST['body']) && in_array($value['attribute_slug'],$bodys)) echo 'selected'; ?> value="<?= $value['attribute_slug'] ?>"><?= $value['attribute_title'] ?></option>
    <?php } ?>
        <!-- <option value="" <?= isset($_POST['body']) && $_POST['body'] == '' ? 'selected' : '' ?>>Select Value</option>
        <option value="body-oil" <?= isset($_POST['body']) && $_POST['body'] == 'body-oil' ? 'selected' : '' ?>>Body Oil</option>
        <option value="body-serum" <?= isset($_POST['body']) && $_POST['body'] == 'body-serum' ? 'selected' : '' ?>>Body serum</option>
        <option value="body-cream" <?= isset($_POST['body']) && $_POST['body'] == 'body-cream' ? 'selected' : '' ?>>Body Cream</option>
        <option value="body-wash" <?= isset($_POST['body']) && $_POST['body'] == 'body-wash' ? 'selected' : '' ?>>Body Wash</option> -->
    </select>
    </div>
    <div class="form-group for-shop">
        <label>Face</label>
        <select class="selectpicker form-control show-tick show-menu-arrow" name="face[]" multiple>
             <?php foreach ($faca as $value) {
                    //if($_POST['id'] != $product['id'] && $product['sku'] != '') {
                 ?>
        <option <?php if(isset($_POST['face']) && in_array($value['attribute_slug'],$facas)) echo 'selected'; ?> value="<?= $value['attribute_slug'] ?>"><?= $value['attribute_title'] ?></option>
    <?php } ?>
    </select>
    </div>
    <?php /*?> <div class="form-group for-shop">
        <label>Lip</label>
        <select class="selectpicker form-control" name="lip">
        <option value="" <?= isset($_POST['lip']) && $_POST['lip'] == '' ? 'selected' : '' ?>>Select Value</option>
        <!-- <option value="serums" <?= isset($_POST['face']) && $_POST['face'] == 'serums' ? 'selected' : '' ?>>Serums</option>
        <option value="facewash" <?= isset($_POST['face']) && $_POST['face'] == 'facewash' ? 'selected' : '' ?>>Facewash</option>
        <option value="cleansers" <?= isset($_POST['face']) && $_POST['face'] == 'cleansers' ? 'selected' : '' ?>>Cleansers</option>
        <option value="moisturisers" <?= isset($_POST['face']) && $_POST['face'] == 'moisturisers' ? 'selected' : '' ?>>Moisturisers</option> -->
    </select>
    </div> <?php */ ?>
    <div class="form-group for-shop">
        <label>Hair</label>
        <select class="selectpicker form-control show-tick show-menu-arrow" name="hair[]" multiple>
            <?php foreach ($hair as $value) {
                    //if($_POST['id'] != $product['id'] && $product['sku'] != '') {
                 ?>
        <option <?php if(isset($_POST['hair']) && in_array($value['attribute_slug'],$hairs)) echo 'selected'; ?> value="<?= $value['attribute_slug'] ?>"><?= $value['attribute_title'] ?></option>
    <?php } ?>
</select>
        <!-- <select class="selectpicker form-control" name="hair">
        <option value="" <?= isset($_POST['hair']) && $_POST['hair'] == '' ? 'selected' : '' ?>>Select Value</option>
        <option value="hair-serums" <?= isset($_POST['hair']) && $_POST['hair'] == 'hair-serums' ? 'selected' : '' ?>>Hair-Serums</option>
        <option value="shampoos" <?= isset($_POST['hair']) && $_POST['hair'] == 'shampoos' ? 'selected' : '' ?>>Shampoos</option>
        <option value="conditioners" <?= isset($_POST['hair']) && $_POST['hair'] == 'conditioners' ? 'selected' : '' ?>>Conditioners</option>
    </select> -->
    </div>
   <?php /*?> <div class="form-group for-shop">
        <label>Kits</label>
        <select class="selectpicker form-control" name="kits">
        <option value="" <?= isset($_POST['kits']) && $_POST['kits'] == '' ? 'selected' : '' ?>>Select Value</option>
        <option value="trial-kit" <?= isset($_POST['kits']) && $_POST['kits'] == 'trial-kit' ? 'selected' : '' ?>>Trial-kits</option>
        
    </select>
    </div> <?php */ ?>
    <div class="form-group for-shop">
        <label>Skin Concern</label>
        <select class="selectpicker form-control show-tick show-menu-arrow" name="skin_concern[]" multiple>
            <?php foreach ($skin_concern as $value) {
                    //if($_POST['id'] != $product['id'] && $product['sku'] != '') {
                 ?>
        <option <?php if(isset($_POST['skin_concern']) && in_array($value['attribute_slug'],$skin_concerns)) echo 'selected'; ?> value="<?= $value['attribute_slug'] ?>"><?= $value['attribute_title'] ?></option>
        <?php } ?>
        
    </select>
    </div> 
     <!-- <p><b>Product Attrbutes</b></p>
     <hr /> -->
      <?php foreach($attributes_set as $attribute){
           $attributes_options = $this->Products_model->getAllAttributeOption($attribute->attribute_set_id);

           if($attribute->attribute_set_name != 'Color' && $attribute->attribute_set_name != 'Gender' && $attribute->attribute_set_name != 'Manufacturer' && $attribute->attribute_set_name != 'Material' && $attribute->attribute_set_name != 'Toy Type'){
         ?>
     <!-- <div class="form-group for-shop">
         <label><?php echo $attribute->attribute_set_name;?></label>
         <select class="form-control" name="attributes[]">
            <?php foreach($attributes_options as $option){
                   $selected = "";
                    foreach($product_attribute as $prev_attribute){
                        if($prev_attribute->attribute == $attribute->attribute_set_slug && $prev_attribute->attribute_value == $option->attribute_slug){
                            $selected = 'selected="selected"';
                        }
                    }
                ?>
                <option <?=$selected?> value="<?= $attribute->attribute_set_slug."/".$option->attribute_slug?>"><?= $option->attribute_title?></option>
            <?php } ?>
         </select>
         
    </div> -->
    <?php } }?>
    
    
    
    
    <div class="col-md-12 nopadding">
       <?php foreach($variants as $variant){?>
        <div class="col-md-12 nopadding">
        <div class="form-group for-shop col-md-2 nopadding">
        	<div class="form-group for-shop col-md-6 nopadding">
                <label>Weight</label>
                <input type="text" placeholder="Product weight" name="weight[]" value="<?= $variant['weight'] ?>" class="form-control">
            </div>
            <div class="form-group for-shop col-md-6 nopadding">
            <label>Unit</label>
            <select class="form-control" name="weight_unit[]" style="width:100%;">
                <option value="ML" <?= $variant['weight_unit'] == 'ML' ? 'selected' : '' ?>>ML</option>
                <option value="grams" <?= $variant['weight_unit'] == 'grams' ? 'selected' : '' ?>>Grams</option>
            </select>
            </div>
        </div>
        <!-- <div class="form-group for-shop col-md-2 nopadding">
                    <label>Vendor Price (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                    <input type="text" name="vendor_price[]" placeholder="vendor price without currency at the end" value="<?= $variant['vendor_price'] ?>" class="form-control">
        </div> -->
         <!-- <div class="form-group for-shop col-md-2 nopadding">
                    <label>Offer Price (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                    <input type="text" name="price[]" placeholder="without currency at the end" value="<?=$variant['price'] ?>" class="form-control">
         </div> -->
         <div class="form-group for-shop col-md-2 nopadding">
                    <label>Actual Price (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                    <input type="text" name="old_price[]" placeholder="without currency at the end" value="<?= $variant['old_price'] ?>" class="form-control">
         </div>
          <div class="form-group for-shop col-md-2 nopadding">
            <label>Quantity</label>
            <input type="text" placeholder="number" name="quantity[]" value="<?= $variant['quantity'] ?>" class="form-control" id="quantity">
          </div>
          <!-- <div class="form-group for-shop col-md-2 nopadding">
            <label>Length</label>
            <input type="text" placeholder="number" name="length[]" value="<?= $variant['length'] ?>" class="form-control" id="length">
          </div>
          <div class="form-group for-shop col-md-2 nopadding">
            <label>Width</label>
            <input type="text" placeholder="number" name="width[]" value="<?= $variant['width'] ?>" class="form-control" id="width">
          </div>
          <div class="form-group for-shop col-md-2 nopadding">
            <label>Height</label>
            <input type="text" placeholder="number" name="height[]" value="<?= $variant['height'] ?>" class="form-control" id="height">
          </div> -->
          <div class="form-group for-shop col-md-2 nopadding">
            <label>Action</label>
            <select class="form-control" name="status[]" style="width:100%;">
                <option value="<?= $variant['variant_id']; ?>_hide" <?= isset($variant['status']) && $variant['status'] == 'hide' ? 'selected' : '' ?>>Hide</option>
                <option value="<?= $variant['variant_id']; ?>_show" <?= isset($variant['status']) && $variant['status'] == 'show' ? 'selected' : '' ?>>Show</option>
                <option value="<?= $variant['variant_id']; ?>_remove" <?= isset($variant['status']) && $variant['status'] == 'remove' ? 'selected' : '' ?>>Remove</option>
            </select>
          </div>
          
          </div>
          <?php } ?>
             
         
          <div id="education_fields" class="education_fields"> </div> 
          <?php if ($this->uri->segment(3) == null) { ?>  
           <div class="form-group for-shop col-md-2 nopadding education_fields-btn" id="education_fields-btn">
               <div class="input-group-btn">
                <button class="btn btn-success" style="margin-top:23px" type="button"  onclick="education_fields();">Add Variants <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
               </div>
          </div>
          <?php } ?>
         <div class="form-group for-shop col-md-12 nopadding publish" id="publish">
            <button type="submit" name="submit" class="btn btn-lg btn-default btn-publish">Publish</button>
            <?php if ($this->uri->segment(3) !== null) { ?>
                <a href="<?= base_url('admin/products') ?>" class="btn btn-lg btn-default">Cancel</a>
            <?php } ?>
         </div>  
     </div>     
            
               
      
    </div>
</form>
<!-- Modal Upload More Images -->
<div class="modal fade" id="modalMoreImages" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Upload more images</h4>
            </div>
            <div class="modal-body">
                <form id="uploadImagesForm">
                    <div class="form-group for-shop">
                        <label>SKU</label>
                        <input type="text" placeholder="SKU" name="sku_no" value="<?= @$_POST['sku'] ?>" class="form-control">
                    </div>
                    <input type="hidden" value="<?= isset($_POST['folder']) ? $_POST['folder'] : $timeNow ?>" name="folder">
                    <label for="others">Select images</label>
                    <input type="file" name="others[]" id="others" multiple />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default finish-upload">
                    <span class="finish-text">Finish</span>
                    <img src="<?= base_url('assets/imgs/load.gif') ?>" class="loadUploadOthers" alt="">
                </button>
            </div>
        </div>
    </div>
</div>
<!-- virtualProductsHelp -->
<div class="modal fade" id="virtualProductsHelp" tabindex="-1" role="dialog" aria-labelledby="virtualProductsHelp">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">What are virtual products?</h4>
            </div>
            <div class="modal-body">
                Sometimes we want to sell products that are for electronic use such as books. In the box below, you can enter links to products that can be downloaded after you confirm the order as "Processed" through the "Orders" tab, an email will be sent to the customer entered with the entire text entered in the "virtual products" field.
                We have left only the possibility to add links in this field because sometimes it is necessary that the electronic stuff you provide for downloading will be uploaded to other servers. If you want, you can add your files to "file manager" and take the links to them to add to the "virtual products"
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="oneMoreImages" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Upload more Other images</h4>
            </div>
            <div class="modal-body">
                <form id="oneMoreuploadImagesForm">
                    <div class="form-group for-shop">
                        <label>SKU</label>
                        <input type="text" placeholder="SKU" name="sku_nos" value="<?= @$_POST['sku'] ?>" class="form-control">
                    </div>
                    <input type="hidden" value="<?= isset($_POST['plus_folder']) ? $_POST['plus_folder'] : $timeNow ?>" name="plus_folder">
                    <label for="others_more">Select images</label>
                    <input type="file" name="others_more[]" id="others_more" multiple />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default finish-upload-more">
                    <span class="finish-text">Finish</span>
                    <img src="<?= base_url('assets/imgs/load.gif') ?>" class="loadUploadOthers" alt="">
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tagImages" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Upload Tag images</h4>
            </div>
            <div class="modal-body">
                <form id="tagImagesForm">
                    <div class="form-group for-shop">
                        <label>SKU</label>
                        <input type="text" placeholder="SKU" name="sku_tag" value="<?= @$_POST['sku'] ?>" class="form-control">
                    </div>
                    <input type="hidden" value="<?= isset($_POST['tag_folder']) ? $_POST['tag_folder'] : $timeNow ?>" name="tag_folder">
                    <label for="tag_images">Select images</label>
                    <input type="file" name="tag_images[]" id="tag_images" multiple />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default finish-tag_images">
                    <span class="finish-text">Finish</span>
                    <img src="<?= base_url('assets/imgs/load.gif') ?>" class="loadUploadOthers" alt="">
                </button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var room = 1;
function education_fields() {
 
    room++;
    var objTo = document.getElementById('education_fields')
    var divtest = document.createElement("div");
	divtest.setAttribute("class", "form-group removeclass"+room);
	var rdiv = 'removeclass'+room;
    divtest.innerHTML = '<input type="hidden" name="status[]" value="default"><div class="col-md-12 nopadding"><div class="form-group for-shop col-md-2 nopadding">'+
        '<div class="form-group for-shop col-md-6 nopadding"><label>Weight</label>'+
        '<input type="text" placeholder="Product weight" name="weight[]" value="" class="form-control">'+
		 '</div><div class="form-group for-shop col-md-6 nopadding">'+
            '<label>Unit</label>'+
            '<select class="form-control" name="weight_unit[]" style="width:100%;">'+
                '<option value="ML">ML</option>'+
                '<option value="GRAMS">GRAMS</option>'+
            '</select>'+
            '</div>'+
    '</div>'+         
     '<div class="form-group for-shop col-md-2 nopadding">'+
                '<label>Actual Price (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>'+
                '<input type="text" name="old_price[]" placeholder="without currency at the end" value="" class="form-control">'+
     '</div>'+
      '<div class="form-group for-shop col-md-2 nopadding">'+
        '<label>Quantity</label>'+
        '<input type="text" placeholder="number" name="quantity[]" value="" class="form-control" id="quantity">'+
      '</div>'+
      '</div>';
    
    objTo.appendChild(divtest)
}
   function remove_education_fields(rid) {
	   $('.removeclass'+rid).remove();
   }

   $(document).ready(function(){
    $('#productType').on('change', function(){
        if($(this).val() == 'single'){
            $("#product_add").show();
            $("#for_regime").hide();
        }
        else{
            $("#product_add").show();
            $("#for_regime").show();
        }
        
    });
});
   $("#education_fields-btn").click(function(){
    $(".education_fields-btn").hide();
    $(".publish").show();
});
</script>