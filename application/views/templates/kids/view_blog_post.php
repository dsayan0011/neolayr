<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="mb-4"></div><!-- margin -->
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-md-9">
            <div class="alone title" style="font-size: 30px; text-align: center;">
                <span><?= $article['title'] ?></span>
            </div>
            <span class="blog-preview-time" style="font-size: 14px;">
                <i class="fa fa-clock-o"></i>
                <?= date('M d, y', $article['time']) ?>
            </span>
            <div class="thumbnail blog-detail-thumb" style="margin-top: 10px; margin-bottom: 20px; text-align: center;">
                <img src="<?= base_url('attachments/blog_images/' . $article['image']) ?>" alt="<?= $article['title'] ?>">
            </div>
            <div class="blog-description">
                <?= $article['description'] ?>
            </div>
        </div>
        <div class="col-sm-4 col-md-3 widget widget-cats" style="line-height:20px; padding: 20px;">
            <div style="text-align: center; padding-top: 22px;">
            <a href="<?= LANG_URL . '/blog' ?>" class="blogbtn btn-danger" style="margin-bottom: 20px;"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> <?= lang('go_back_blog') ?></a>
            </div>
            <div style="margin-bottom: 20px; margin-top: 30px;">
                <?= $archives ?>
            </div>
        </div>        
    </div>
</div>
<div class="mb-4"></div><!-- margin -->