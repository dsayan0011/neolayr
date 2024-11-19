<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loop
{

    private static $CI;

    public function __construct()
    {
        self::$CI = & get_instance();
    }

    static function getCartItems($cartItems)
    {
        if (!empty($cartItems['array'])) {
            ?>
            <li class="cleaner text-right">
                <a href="javascript:void(0);" class="btn-blue-round" onclick="clearCart()">
                    <?= lang('clear_all') ?>
                </a>
            </li>
            <?php
            foreach ($cartItems['array'] as $cartItem) {
                ?>
                <li class="shop-item" data-artticle-id="<?= $cartItem['id'] ?>">
                    <div class="media">
                        <a href="<?= LANG_URL . '/' . $cartItem['url'] ?>">
                            <img alt="<?= $cartItem['title'] ?>" class="mr-3" src="<?= base_url('/attachments/shop_images/' . $cartItem['image']) ?>">
                        </a>
                        <div class="media-body">
                            <a href="<?= LANG_URL . '/' . $cartItem['url'] ?>">
                                <h4><?= $cartItem['title'] ?></h4>
                            </a>
                            <h4>
                                <span><?= $cartItem['num_added'] ?> x <?= CURRENCY ?><?= $cartItem['price'];?></span>
                            </h4>
                        </div>
                    </div>
                    <div class="close-circle">
                        <a href="javascript:void(0)" onclick="removeProduct(<?= $cartItem['id'] ?>)">
                            <i class="ti-trash" aria-hidden="true"></i>
                        </a>
                    </div>
                </li>
                
                
                
        
                <?php
            }
            ?>
            <li class="divider"></li>
            <li class="text-center">
                <a style="font-size: 20px; background: #fe3a3a; padding: 10px; color: #ffffff;" class="go-checkout btn btn-default btn-sm" href="<?= LANG_URL . '/shopping-cart' ?>">
                    <?=
                    !empty($cartItems['array']) ? '<i class="fa fa-check"></i> '
                            . lang('checkout') . ' - <span class="finalSum">' . $cartItems['finalSum']
                            . '</span>' . CURRENCY : '<span class="no-for-pay">' . lang('no_for_pay') . '</span>'
                    ?>
                </a>
            </li>
        <?php } else {
            ?>
            <li class="text-center"><?= lang('no_products') ?></li>
            <?php
        }
    }

    static public function getProducts($products, $classes = '', $carousel = false)
    {
        if ($carousel == true) {
            ?>
            <div class="carousel slide" id="small_carousel" data-ride="carousel" data-interval="3000">
                <ol class="carousel-indicators">
                    <?php
                    $i = 0;
                    while ($i < count($products)) {
                        if ($i == 0)
                            $active = 'active';
                        else
                            $active = '';
                        ?>
                        <li data-target="#small_carousel" data-slide-to="<?= $i ?>" class="<?= $active ?>"></li>
                        <?php
                        $i++;
                    }
                    ?>
                </ol>
                <div class="carousel-inner">
                    <?php
                }
                $i = 0;
                foreach ($products as $article) {
                    if ($i == 0 && $carousel == true) {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                    ?>
                    <div class="product-list <?= $carousel == true ? 'item' : '' ?> <?= $classes ?> <?= $active ?>">
                        <div class="inner">
                            <div class="img-container">
                                <a href="<?= $article['vendor_url'] == null ? LANG_URL . '/' . $article['url'] : LANG_URL . '/' . $article['vendor_url'] . '/' . $article['url'] ?>">
                                    <img src="<?= base_url('/attachments/shop_images/' . $article['image']) ?>" alt="<?= str_replace('"', "'", $article['title']) ?>">
                                </a>
                            </div>
                            <h2>
                                <a href="<?= $article['vendor_url'] == null ? LANG_URL . '/' . $article['url'] : LANG_URL . '/' . $article['vendor_url'] . '/' . $article['url'] ?>"><?= character_limiter($article['title'], 70) ?></a>
                            </h2>
                            <div class="price">
                                <span class="underline"><?= lang('price') ?>: <span><?= $article['price'] != '' ? number_format($article['price'], 2) : 0 ?><?= CURRENCY ?></span></span>
                                <?php
                                if ($article['old_price'] != '' && $article['old_price'] != 0 && $article['price'] != '' && $article['price'] != 0) {
                                    $percent_friendly = number_format((($article['old_price'] - $article['price']) / $article['old_price']) * 100) . '%';
                                    ?>
                                    <span class="price-down"><?= $percent_friendly ?></span>
                                <?php } ?>
                            </div>
                            <div class="price-discount <?= $article['old_price'] == '' ? 'invisible' : '' ?>">
                                <?= lang('old_price') ?>: <span><?= $article['old_price'] != '' ? number_format($article['old_price'], 2) . CURRENCY : '' ?></span>
                            </div>
                            <?php if (self::$CI->load->get_var('publicQuantity') == 1) { ?>
                                <div class="quantity">
                                    <?= lang('in_stock') ?>: <span><?= $article['quantity'] ?></span>
                                </div>
                            <?php } if (self::$CI->load->get_var('moreInfoBtn') == 1) { ?>
                                <a href="<?= $article['vendor_url'] == null ? LANG_URL . '/' . $article['url'] : LANG_URL . '/' . $article['vendor_url'] . '/' . $article['url'] ?>" class="info-btn gradient-color">
                                    <span class="text-to-bg"><?= lang('info_product_list') ?></span>
                                </a>
                            <?php } ?>
                            <div class="add-to-cart">
                                <a href="javascript:void(0);" class="add-to-cart btn-add" data-goto="<?= LANG_URL . '/shopping-cart' ?>" data-id="<?= $article['id'] ?>">
                                    <img class="loader" src="<?= base_url('assets/imgs/ajax-loader.gif') ?>" alt="Loding">
                                    <span class="text-to-bg"><?= lang('add_to_cart') ?></span>
                                </a>
                            </div>
                            <div class="add-to-cart">
                                <a href="javascript:void(0);" class="add-to-cart btn-add more-blue" data-goto="<?= LANG_URL . '/checkout' ?>" data-id="<?= $article['id'] ?>">
                                    <img class="loader" src="<?= base_url('assets/imgs/ajax-loader.gif') ?>" alt="Loding">
                                    <span class="text-to-bg"><?= lang('buy_now') ?></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                    $i++;
                }
                if ($carousel == true) {
                    ?>
                </div>
                <a class="left carousel-control" href="#small_carousel" role="button" data-slide="prev">
                    <i class="fa fa-5x fa-angle-left" aria-hidden="true"></i>
                </a>
                <a class="right carousel-control" href="#small_carousel" role="button" data-slide="next">
                    <i class="fa fa-5x fa-angle-right" aria-hidden="true"></i>
                </a>
            </div>
            <?php
        }
    }

}
