<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- <div class="mb-4"></div>
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
<div class="mb-4"></div> -->

<main>
            <!-- BLOG DETAILS PAGE-->
            <section class="blog-details-page">
                <div class="container">
                    <h1><?= $article['title'] ?></h1>
                    <h2><?= character_limiter($article['title'], 85) ?></h2>
                    <div class="profile-and-date-area">
                        <ul>
                            <!-- <li><span class=""><i class="fa-regular fa-user"></i></span>John Doe</li> -->
                            <li><span class=""><i class="fa-solid fa-calendar-days"></i></span><?= date('M d, y', $article['time']) ?></li>
                        </ul>
                    </div>
                    <div class="blog-details-content">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="blog-details-content-left d-lg-flex">
                                    <div class="blog-social-left d-inline-block">
                                        <ul>
                                            <li><a href="<?= $footerSocialInstagram ?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                            <li><a href="<?= $footerSocialFacebook ?>" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
                                            <li><a href="<?= $footerSocialLinkedin ?>" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a></li>
                                            <li><a href="<?= $footerSocialTwitter ?>" target="_blank"><i class="fa-brands fa-twitter"></i></a></li>
                                            

                                        </ul>
                                    </div>
                                    <div class="blog-detailed-content">
                                        <img src="<?= base_url('attachments/blog_images/' . $article['image']) ?>" border="0" alt="" class="w-100">
                                        <p><?= $article['description'] ?></p>
                                        <!-- <div class="about-blog-author d-flex">
                                            <div class="about-blog-author-image">
                                                <img src="<?= base_url('images/akash-palkhiwala_300.jpg') ?>" border="0" alt="">
                                            </div>
                                            <div class="about-blog-author-info">
                                                <h4>John Doe</h4>
                                                <h6>Chief Executive Officer</h6>
                                                <a href="">See more article from this author <br> About this author</a>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 blog-listing-area">
                                <?php foreach ($getBlog as $post) {
                                    
                                ?>
                                <div class="each-blog">
                                    <div class="each-blog-image">
                                        <a href="<?= LANG_URL . '/blog/' . $post['url'] ?>"><img src="<?= base_url('attachments/blog_images/' . $post['image']) ?>" border="0" alt="" class="w-100"></a>
                                    </div>
                                    <div class="blog-content">
                                        <div class="date-area"><?= date('M d, y', $post['time']) ?></div>
                                        <h4><?= character_limiter($post['title'], 50) ?></h4>
                                        <p><?= character_limiter(strip_tags($post['description']), 500) ?></p>
                                    </div>
                                </div>
                               <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END:BLOG DETAILS PAGE-->
            
            <!-- END FOOTER-->
        </main>