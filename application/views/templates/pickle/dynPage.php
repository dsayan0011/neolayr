<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
 <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
                    </ol>
                </div><!-- End .container -->
</nav>
 <div class="about-section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="subtitle"><?= $title ?></h2>
                            <?= $content ?>
                        </div><!-- End .col-lg-7 -->
                    </div>
                 </div>
 </div>
