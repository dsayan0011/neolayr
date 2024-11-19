<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;">Product Bulk Upload</h1>
<hr>
<?php if ($this->session->userdata('successfully')) { ?>
       <div class="alert alert-success"> <?= $this->session->userdata('successfully') ?> </div>
       <?php 
       $this->session->unset_userdata('successfully');
       } 
       ?>
       <?php if ($this->session->userdata('unsuccessfully')) { ?>
       <div class="alert alert-danger"> <?= $this->session->userdata('unsuccessfully') ?> </div>
       <?php 
       $this->session->unset_userdata('unsuccessfully');
       }
?>
 <form role="form"  method="post" action="<?php echo base_url()?>admin/importProductData" enctype="multipart/form-data">
   
    <div class="form-group bordered-group">
     
            
        <label for="userfile">Select Excel</label>
        <input type="file" name="file" id="file" required>
    </div>

   
    <input type="submit" value="Bulk Upload" class="btn btn-info">
</form>
 <p>Download Sample Excel File <a download href="<?php echo base_url('attachments/samples/products.xlsx') ?>">Click Here</a></p>
 <p>Download Sample Shop Category File <a download href="<?php echo base_url()?>admin/exportShopCategory">Click Here</a></p>
 <!-- <p>Download Sample Category File <a download href="<?php echo base_url()?>admin/exportCategory">Click Here</a></p> -->
 <p>** SKU, IMAGE NAME, SHOP CATEGORIE, TITLE, DESCRIPTION, PRICE, PRODUCT TYPE, QUANTITY, WEIGHT, WEIGHT UNIT ARE MANDATORY FIELDS.</p>
 <!-- <p>** BODY, FACE, HAIR (One of these three is mandatory).</p> -->