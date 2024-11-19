</div>
</div>
</div>
</div>
<?php if ($this->session->userdata('logged_in')) { ?>
<footer><p class="footer-copyright"><?= $footerCopyright ?></p></footer>
<?php } ?>
</div>
<!-- Modal Calculator -->
<div class="modal fade" id="modalCalculator" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Calculator</h4>
            </div>
            <div class="modal-body" id="calculator">
                <div class="hero-unit" id="calculator-wrapper">
                    <div class="row">
                        <div class="col-sm-8">
                            <div id="calculator-screen" class="form-control"></div>
                        </div>
                        <div class="col-sm-1">
                            <div class="visible-xs">
                                =
                            </div>
                            <div class="hidden-xs">
                                =
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div id="calculator-result"  class="form-control">0</div>
                        </div>
                    </div>
                </div>
                <div class="well">
                    <div id="calc-board">
                        <div class="row">
                            <a href="javascript:void(0);" class="btn btn-default" data-constant="SIN" data-key="115">sin</a>
                            <a href="javascript:void(0);" class="btn btn-default" data-constant="COS" data-key="99">cos</a>
                            <a href="javascript:void(0);" class="btn btn-default" data-constant="MOD" data-key="109">md</a>
                            <a href="javascript:void(0);" class="btn btn-danger" data-method="reset" data-key="8">C</a>
                        </div>
                        <div class="row">
                            <a href="javascript:void(0);" class="btn btn-default" data-key="55">7</a>
                            <a href="javascript:void(0);" class="btn btn-default" data-key="56">8</a>
                            <a href="javascript:void(0);" class="btn btn-default" data-key="57">9</a>
                            <a href="javascript:void(0);" class="btn btn-default" data-constant="BRO" data-key="40">(</a>
                            <a href="javascript:void(0);" class="btn btn-default" data-constant="BRC" data-key="41">)</a>
                        </div>
                        <div class="row">
                            <a href="javascript:void(0);" class="btn btn-default" data-key="52">4</a>
                            <a href="javascript:void(0);" class="btn btn-default" data-key="53">5</a>
                            <a href="javascript:void(0);" class="btn btn-default" data-key="54">6</a>
                            <a href="javascript:void(0);" class="btn btn-default" data-constant="MIN" data-key="45">-</a>
                            <a href="javascript:void(0);" class="btn btn-default" data-constant="SUM" data-key="43">+</a>
                        </div>
                        <div class="row">
                            <a href="javascript:void(0);" class="btn btn-default" data-key="49">1</a>
                            <a href="javascript:void(0);" class="btn btn-default" data-key="50">2</a>
                            <a href="javascript:void(0);" class="btn btn-default" data-key="51">3</a>
                            <a href="javascript:void(0);" class="btn btn-default" data-constant="DIV" data-key="47">/</a>
                            <a href="javascript:void(0);" class="btn btn-default" data-constant="MULT" data-key="42">*</a>
                        </div>
                        <div class="row">
                            <a href="javascript:void(0);" class="btn btn-default" data-key="46">.</a>
                            <a href="javascript:void(0);" class="btn btn-default" data-key="48">0</a>
                            <a href="javascript:void(0);" class="btn btn-default" data-constant="PROC" data-key="37">%</a>
                            <a href="javascript:void(0);" class="btn btn-primary" data-method="calculate" data-key="61">=</a>
                        </div>
                    </div>
                </div>
                <div class="well">
                    <legend>History</legend>
                    <div id="calc-panel">
                        <div id="calc-history">
                            <ol id="calc-history-list"></ol>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/bootstrap-select-1.12.1/js/bootstrap-select.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootbox.min.js') ?>"></script>
<script src="<?= base_url('assets/js/zxcvbn.js') ?>"></script>
<script src="<?= base_url('assets/js/zxcvbn_bootstrap3.js') ?>"></script>
<script src="<?= base_url('assets/js/pGenerator.jquery.js') ?>"></script>
<script>
    var urls = {
        changePass: '<?= base_url('admin/changePass') ?>',
        editShopCategorie: '<?= base_url('admin/editshopcategorie') ?>',
        changeTextualPageStatus: '<?= base_url('admin/changePageStatus') ?>',
        removeSecondaryImage: '<?= base_url('admin/removeSecondaryImage') ?>',
        productstatusChange: '<?= base_url('admin/productstatusChange') ?>',
        productsOrderBy: '<?= base_url('admin/products?orderby=') ?>',
        productStatusChange: '<?= base_url('admin/productStatusChange') ?>',
        changeOrdersOrderStatus: '<?= base_url('admin/changeOrdersOrderStatus') ?>',
		shipRocket: '<?= base_url('admin/changeOrdersOrderStatusByShiprocket') ?>',
		changeUserStatus: '<?= base_url('admin/changeUsersStatus') ?>',
        ordersOrderBy: '<?= base_url('admin/orders?order_by=') ?>',
        uploadOthersImages: '<?= base_url('admin/uploadOthersImages') ?>',
        loadOthersImages: '<?= base_url('admin/loadOthersImages') ?>',
        aPlusContent: '<?= base_url('admin/aPlusContent') ?>',
        loadImages: '<?= base_url('admin/loadImages') ?>',
        removeaPlusImages: '<?= base_url('admin/removeaPlusImages') ?>',
        editPositionCategorie: '<?= base_url('admin/changePosition') ?>',
		editTagCategorie: '<?= base_url('admin/changeTag') ?>',
		tracking_details: '<?= base_url('admin/orders/tracking_details') ?>',
		income_details: '<?= base_url('admin/income_details') ?>',
        tagContent: '<?= base_url('admin/tagContent') ?>',
        tagContentImages: '<?= base_url('admin/tagContentImages') ?>',
        removeTagImages: '<?= base_url('admin/removeTagImages') ?>',
        productSync: '<?= base_url('admin/productSync') ?>'
    };
</script>
<script src="<?= base_url('assets/js/mine_admin.js') ?>"></script>
<script type="text/javascript">
function resetAddForm(){
	$('#level_name').val("");
	$('#editLevel').val("");
}
 function cancel_order(order_id){
	 $('#the_id').val(order_id);
	  $('#cancel_modal').modal('show');
 }
  function change_return_order_status(id,order_id,status,return_status){
	 $('#the_id').val(id);
	 $('#to_status').val(status);
	 $('#order_id').val(order_id);
	 $('#return_status').val(return_status);
	 
	 $('#cancel_modal').modal('show');
 }
 function getCity(value){
			$.ajax({
								type: "POST",
								url: "<?php echo site_url('vendorusers/getThanaList'); ?>",
								data: { district:value },
								success: function(data)
								{
									$('#city').html(data);
								}
							 });
		}

</script>
</body>
</html>