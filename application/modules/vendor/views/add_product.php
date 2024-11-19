<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;"> Publish product</h1>
<hr>
<?php
$timeNow = time();
?>
<form method="POST" action="" enctype="multipart/form-data">
    <input type="hidden" value="<?= isset($_POST['folder']) ? $_POST['folder'] : $timeNow ?>" name="folder">
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

            <div class="form-group">
                <a href="javascript:void(0);" class="btn btn-default showSliderDescrption" data-descr="<?= $i ?>">Show Slider Description <span class="glyphicon glyphicon-circle-arrow-down"></span></a>
            </div>
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
            <?php /*?> <div class="form-group for-shop">
                <label>Default Price (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <input type="text" name="default_vendor_price[]" placeholder="vendor price without currency at the end" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['default_vendor_price']) ? $trans_load[$language->abbr]['default_vendor_price'] : '' ?>" class="form-control">
            </div>
           <div class="form-group for-shop">
                <label>Offer Price (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <input type="text" name="price[]" placeholder="without currency at the end" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['price']) ? $trans_load[$language->abbr]['price'] : '' ?>" class="form-control">
            </div>
            <div class="form-group for-shop">
                <label>Actual Price (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <input type="text" name="old_price[]" placeholder="without currency at the end" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['old_price']) ? $trans_load[$language->abbr]['old_price'] : '' ?>" class="form-control">
            </div><?php */?>
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
    <div class="form-group for-shop">
        <label>Shop Categories</label>
        <select class="selectpicker form-control show-tick show-menu-arrow" name="shop_categorie">
            <?php foreach ($shop_categories as $key_cat => $shop_categorie) { ?>
                <option <?= isset($_POST['shop_categorie']) && $_POST['shop_categorie'] == $key_cat ? 'selected=""' : '' ?> value="<?= $key_cat ?>">
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
    <?php if ($showBrands == 1) { ?>
        <div class="form-group for-shop">
            <label>Brand</label>
            <select class="selectpicker" name="brand_id">
                <?php foreach ($brands as $brand) { ?>
                    <option <?= isset($_POST['brand_id']) && $_POST['brand_id'] == $brand['id'] ? 'selected' : '' ?> value="<?= $brand['id'] ?>"><?= $brand['name'] ?></option>
                <?php } ?>
            </select>
        </div>
    <?php }else{ ?>
    <input type="hidden" name="brand_id" value="" />
    <?php } ?>
      <div class="form-group for-shop">
        <label>Courier Charge</label>
        <select class="selectpicker" name="courier_charge">
            <option value="yes" <?= isset($_POST['courier_charge']) && $_POST['courier_charge'] == 'yes' ? 'selected' : '' ?>>Yes</option>
            <option value="no" <?= isset($_POST['courier_charge']) && $_POST['courier_charge'] == 'no' || !isset($_POST['courier_charge']) ? 'selected' : '' ?>>No</option>
        </select>
    </div>
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
                <option value="kg" <?= $variant['weight_unit'] == 'kg' ? 'selected' : '' ?>>Kg</option>
                <option value="grams" <?= $variant['weight_unit'] == 'grams' ? 'selected' : '' ?>>Grams</option>
                <option value="litre" <?= $variant['weight_unit'] == 'litre' ? 'selected' : '' ?>>Litre</option>
            </select>
            </div>
        </div>
        <div class="form-group for-shop col-md-2 nopadding">
                    <label>Price (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                    <input type="text" name="vendor_price[]" placeholder="vendor price without currency at the end" value="<?= $variant['vendor_price'] ?>" class="form-control" disabled>
        </div>
          <div class="form-group for-shop col-md-2 nopadding">
            <label>Quantity</label>
            <input type="text" placeholder="number" name="quantity[]" value="<?= $variant['quantity'] ?>" class="form-control" id="quantity">
          </div>
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
             
         
          <div id="education_fields"> </div>   
           <div class="form-group for-shop col-md-2 nopadding">
               <div class="input-group-btn">
                <button class="btn btn-success" style="margin-top:23px" type="button"  onclick="education_fields();">Add Variants <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
               </div>
          </div>
           
     </div>
    <button type="submit" name="submit" class="btn btn-lg btn-default btn-publish">Publish</button>
    <?php if ($this->uri->segment(3) !== null) { ?>
        <a href="<?= base_url('vendor/products') ?>" class="btn btn-lg btn-default">Cancel</a>
    <?php } ?>
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
                '<option value="kg">Kg</option>'+
                '<option value="grams">Grams</option>'+
                '<option value="litre">Litre</option>'+
            '</select>'+
            '</div>'+
    '</div>'+
    '<div class="form-group for-shop col-md-2 nopadding">'+
                '<label>Price (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>'+
                '<input type="text" name="vendor_price[]" placeholder="vendor price without currency at the end" value="" class="form-control">'+
    '</div>'+
      '<div class="form-group for-shop col-md-2 nopadding">'+
        '<label>Quantity</label>'+
        '<input type="text" placeholder="number" name="quantity[]" value="" class="form-control" id="quantity">'+
      '</div>'+      
      '<div class="form-group for-shop col-md-2 nopadding">'+
           '<div class="input-group-btn">'+
            '<button class="btn btn-danger" style="margin-top:23px" type="button"  onclick="remove_education_fields('+ room +');"> <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </button>'+
           '</div>'+
      '</div></div>';
    
    objTo.appendChild(divtest)
}
   function remove_education_fields(rid) {
	   $('.removeclass'+rid).remove();
   }
</script>
