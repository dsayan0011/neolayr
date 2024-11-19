<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?= $description ?>">
        <title><?= $title ?></title>	
        <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= base_url('assets/bootstrap-select-1.12.1/bootstrap-select.min.css') ?>">
        <link href="<?= base_url('assets/css/custom-admin.css') ?>" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Inconsolata' rel='stylesheet' type='text/css'>
        <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div id="wrapper">
            <div id="content">
                <?php if ($this->session->userdata('logged_vendor')) { ?>
                    <nav class="navbar navbar-default">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <i class="fa fa-lg fa-bars"></i>
                            </button>
                        </div>
                        <div id="navbar" class="collapse navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li><a href="<?= LANG_URL . '/vendor/me' ?>"><i class="fa fa-home"></i> Home</a></li>
                                <li><a href="<?= LANG_URL . '/vendor/edit' ?>"><i class="fa fa-key" aria-hidden="true"></i> Edit Profile</a>
                                </li>
                                <li><a href="javascript:void(0);" data-toggle="modal" data-target="#modalCalculator"><i class="fa fa-calculator" aria-hidden="true"></i> Calculator</a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="<?= base_url('vendor/logout') ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
                            </ul>
                        </div>
                    </nav>
                <?php } ?>
                <div class="container-fluid">
                    <div class="row">
                        <?php if ($this->session->userdata('logged_vendor')) {
							$perimission = $this->session->userdata('adminPermission');
							 ?>
                            <div class="col-sm-3 col-md-3 col-lg-2 left-side navbar-default">
                                <div class="show-menu">
                                    <a id="show-xs-nav" class="visible-xs" href="javascript:void(0)">
                                        <span class="show-sp">
                                            Show menu
                                            <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i>
                                        </span>
                                        <span class="hidde-sp">
                                            Hide menu
                                            <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i>
                                        </span>
                                    </a>
                                </div>
                                <ul class="sidebar-menu">
                                    <?php 
									if(array_key_exists('publish_product',$perimission) && $perimission['publish_product'] == 1){?>
                                    <li><a href="<?= LANG_URL . '/vendor/add/product' ?>" <?= urldecode(uri_string()) == 'vendor/add/product' ? 'class="active"' : '' ?>><i class="fa fa-edit" aria-hidden="true"></i> Publish product</a></li>
                                    <?php }if(array_key_exists('manage_product',$perimission) && $perimission['manage_product'] == 1){ ?>
                                    <li><a href="<?= LANG_URL . '/vendor/products' ?>" <?= urldecode(uri_string()) == 'vendor/products' ? 'class="active"' : '' ?>><i class="fa fa-files-o" aria-hidden="true"></i> Products</a></li>
                                    <?php }if(array_key_exists('manage_orders',$perimission) && $perimission['manage_orders'] == 1){ ?>
                                    <li>
                                        <a href="<?= LANG_URL . '/vendor/orders' ?>" <?= urldecode(uri_string()) == 'vendor/orders' ? 'class="active"' : '' ?>>
                                            <i class="fa fa-money" aria-hidden="true"></i> Orders 
                                        </a>
                                    </li>
                                     <?php }if(array_key_exists('return_update',$perimission) && $perimission['return_update'] == 1){ ?>
                                    <li><a href="<?= base_url('vendor/return') ?>" <?= urldecode(uri_string()) == 'vendor/return' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i>Returned Order</a></li>
                                    <?php }/*if(array_key_exists('manage_account',$perimission) && $perimission['manage_account'] == 1){ ?>
                                    <li><a href="<?= base_url('vendor/account') ?>" <?= urldecode(uri_string()) == 'vendor/account' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i>Accounts</a></li>
                                    <?php }*/ ?>
                                    <li class="header">REPORT</li>
                                    <?php if(array_key_exists('view_order_report',$perimission) && $perimission['view_order_report'] == 1){ ?>
                                    <li><a href="<?= base_url('vendor/report') ?>" <?= urldecode(uri_string()) == 'vendor/report' ? 'class="active"' : '' ?>><i class="fa fa-file" aria-hidden="true"></i> Order Report</a></li>
                                    <?php } ?>
                                   
                                </ul>
                            </div>
                            <?php }?>
                            <div class="col-sm-9 col-md-9 col-lg-10 col-sm-offset-3 col-md-offset-3 col-lg-offset-2">
                                <div>

