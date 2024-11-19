<div id="languages">
    <h1><img src="<?= base_url('assets/imgs/categories.jpg') ?>" class="header-img" style="margin-top:-2px;"> Registration Categories</h1> 
    <hr>
    <?php if (validation_errors()) { ?>
        <div class="alert alert-danger"><?= validation_errors() ?></div>
        <hr>
        <?php
    }
    if ($this->session->flashdata('result_add')) {
        ?>
        <div class="alert alert-success"><?= $this->session->flashdata('result_add') ?></div>
        <hr>
        <?php
    }
    if ($this->session->flashdata('result_delete')) {
        ?>
        <div class="alert alert-success"><?= $this->session->flashdata('result_delete') ?></div>
        <hr>
        <?php
    }
    ?>
    <a href="javascript:void(0);" data-toggle="modal" data-target="#add_edit_articles" class="btn btn-primary btn-xs pull-right" style="margin-bottom:10px;"><b>+</b> Add category</a>
    <div class="clearfix"></div>
    <?php
    if (!empty($categories)) {
        ?>
        <div class="table-responsive">
            <table class="table table-striped custab">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Name</th>
                         <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <?php
                $i = 1;
                foreach ($categories as $categorie) {
                    ?>
                    <tr>
                        <td><?= $categorie['id'] ?></td>
                        <td><?= $categorie['title'] ?></td>
                        <td><?= $categorie['status'] ?></td>
                        <td class="text-center">
                        	<a href="<?= base_url('admin/registration-categories/?edit=' . $categorie['id']) ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                            <a href="<?= base_url('admin/registration-categories/?delete=' . $categorie['id']) ?>" class="btn btn-danger btn-xs confirm-delete"><span class="glyphicon glyphicon-remove"></span> Del</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
        <?php
        echo $links_pagination;
    } else {
        ?>
        <div class="clearfix"></div><hr>
        <div class="alert alert-info">No registration categories found! please add one</div>
    <?php } ?>

    <!-- add edit home categorie -->
    <div class="modal fade" id="add_edit_articles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add Category</h4>
                    </div>
                    <div class="modal-body">
                        <?php foreach ($languages as $language) { ?>
                            <input type="hidden" name="translations[]" value="<?= $language->abbr ?>">
                        <?php } foreach ($languages as $language) { ?>
                            <div class="form-group">
                                <label>Name (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                                <input type="text" value="<?php if(isset($_POST['title'])) echo $_POST['title'];?>" name="categorie_name" class="form-control">
                            </div>
                        <?php } ?>
                        <input type="hidden" id="editLevel" name="edit" value="<?= isset($_GET['edit']) ? $_GET['edit'] : '0' ?>">
                        <div class="form-group">
                            <label>Status:</label>
                            <select class="form-control" name="status">
                                <option <?php if(isset($_POST['status']) && ($_POST['status'] == 'active')) echo 'selected="selected"';?>  value="active">Active</option>
                                <option <?php if(isset($_POST['status']) && ($_POST['status'] == 'inactive')) echo 'selected="selected"';?> value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
<?php if (isset($_GET['edit'])) { ?>
        $(document).ready(function () {
            $("#add_edit_articles").modal('show');
        });
<?php } ?>
</script>
