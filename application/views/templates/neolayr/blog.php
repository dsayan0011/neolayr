<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- <div class="mb-4"></div>
<div class="container" id="blog">
    <div class="row eqHeight">
        <div class="col-sm-8 col-md-9">
            <div class="alone title" style="font-size: 30px; text-align: center; padding-bottom: 20px;">
                <span><?= lang('blog') ?></span>
            </div>            
            <div class="row">
                <?php
                if (!empty($posts)) {
                    foreach ($posts as $post) {
                        ?>
                        <div class="col-md-3 blog-col">
                            <div class="thumbnail blog-list">
                                <a href="<?= LANG_URL . '/blog/' . $post['url'] ?>" class="img-container">
                                    <img src="<?= base_url('attachments/blog_images/' . $post['image']) ?>" alt="<?= $post['title'] ?>">
                                </a>
                                <div class="caption" style="margin-top: 10px;">
                                    <h5>
                                        <?= character_limiter($post['title'], 85) ?>
                                    </h5>
                                    <small>
                                        <span>
                                            <i class="fa fa-clock-o"></i>
                                            <?= date('M d, y', $post['time']) ?>
                                        </span>
                                    </small>
                                    <p class="description"><?= character_limiter(strip_tags($post['description']), 30) ?></p>
                                    <a class="btn btn-blog pull-right" href="<?= LANG_URL . '/blog/' . $post['url'] ?>">
                                        <i class="fa fa-long-arrow-right"></i>
                                        <?= lang('read_mode') ?>
                                    </a>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="alert alert-info"><?= lang('no_posts') ?></div>
                <?php } ?>
            </div>
            <?= $links_pagination ?>
        </div>
        <div class="col-sm-4 col-md-3 widget widget-cats" style="line-height:20px;">
            <div id="search-input-blog">
                <div class="input-group">
                    <form method="GET" action="" class="row">
                        <input type="text" class="search-query blog-form-control col-md-6" value="<?= isset($_GET['find']) ? $_GET['find'] : '' ?>" name="find" placeholder="<?= lang('search') ?>" />
                        <span class="input-group-btn">
                            <button class="blogbtn btn-danger col-md-6" type="submit">
                                <span class="glyphicon glyphicon-search">Search</span>
                            </button>
                        </span>
                    </form>
                </div>
            </div>            
            <div class="blog-home-left-categ" style="margin-top: 10px;">
                <?= $archives ?>
            </div>
        </div>    
    </div>
</div>
<div class="mb-4"></div> -->

<main>
            <!-- BLOG LISTING PAGE-->
            <section class="blog-page">
                <div class="container">
                    <h2>Blog</h2>
                    <div class="blog-listing-area">
                        <div class="row">
                            <?php
                if (!empty($posts)) {
                    foreach ($posts as $post) {
                        ?>
                            <div class="col-6 col-lg-4">
                                <div class="each-blog">
                                    <div class="each-blog-image">
                                    <a href="<?= LANG_URL . '/blog/' . $post['url'] ?>">
                                        <img src="<?= base_url('attachments/blog_images/' . $post['image']) ?>" border="0" alt="" class="w-100"></a>
                                    </div>
                                    <div class="blog-content">
                                        <div class="date-area"><?= date('M d, y', $post['time']) ?> </div>
                                        <h4> <a href="<?= LANG_URL . '/blog/' . $post['url'] ?>"><?= character_limiter($post['title'], 85) ?></a></h4>
                                        <p><?= character_limiter(strip_tags($post['description']), 30) ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php
                    }
                } else {
                    ?>
                    <div class="alert alert-info"><?= lang('no_posts') ?></div>
                <?php } ?>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END:BLOG LISTING PAGE-->
            
        </main>