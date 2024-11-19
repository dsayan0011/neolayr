<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  |	$route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples:	my-controller/index	-> my_controller/index
  |		my-controller/my-method	-> my_controller/my_method
 */
$route['default_controller'] = 'home';

// Load default conrtoller when have only currency from multilanguage
$route['^(\w{2})$'] = $route['default_controller'];

//$route['summary'] = "ShoppingCartPage";
$route['summary'] = "ShoppingCartPage/summary";

//Checkout
$route['(\w{2})?/?checkout/successcash'] = 'checkout/successPaymentCashOnD';
$route['(\w{2})?/?checkout/successbank'] = 'checkout/successPaymentBank';
$route['(\w{2})?/?checkout/paypalpayment'] = 'checkout/paypalPayment';
$route['(\w{2})?/?checkout/order-error'] = 'checkout/orderError';
$route['(\w{2})?/?checkout/process_payment'] = 'checkout/process_payment';
$route['(\w{2})?/?checkout/process_razorpay_payment'] = 'checkout/process_razorpay_payment';
$route['(\w{2})?/?users/process_razorpay_payment'] = 'users/giftcard_razorpay_payment';



// Ajax called. Functions for managing shopping cart
$route['(\w{2})?/?manageShoppingCart'] = 'home/manageShoppingCart';
$route['(\w{2})?/?clearShoppingCart'] = 'home/clearShoppingCart';
$route['(\w{2})?/?discountCodeChecker'] = 'home/discountCodeChecker';

// home page pagination
$route[rawurlencode('home') . '/(:num)'] = "home/index/$1";
// load javascript language file
$route['loadlanguage/(:any)'] = "Loader/jsFile/$1";
// load default-gradient css
$route['cssloader/(:any)'] = "Loader/cssStyle";

// Template Routes
$route['template/imgs/(:any)'] = "Loader/templateCssImage/$1";
$route['templatecss/imgs/(:any)'] = "Loader/templateCssImage/$1";
$route['templatecss/(:any)'] = "Loader/templateCss/$1";
$route['templatejs/(:any)'] = "Loader/templateJs/$1";
$route['fonts/(:any)'] = "Loader/fonts/$1";
$route['images/(:any)'] = "Loader/images/$1"; 
$route['fancyboxCss/(:any)'] = "Loader/fancyboxCss/$1";
$route['fancyboxJS/(:any)'] = "Loader/fancyboxJS/$1";

// Products urls style
$route['(:any)-(:num)'] = "home/viewProduct/$2";
$route['(\w{2})/(:any)-(:num)'] = "home/viewProduct/$3";
$route['shop-product-(:num)'] = "home/viewProduct/$3";

// blog urls style and pagination
$route['blog/(:num)'] = "blog/index/$1";
$route['blog/(:any)-(:num)'] = "blog/viewPost/$2";
$route['(\w{2})/blog/(:any)-(:num)'] = "blog/viewPost/$3";

// Shopping cart page
$route['shopping-cart'] = "ShoppingCartPage";
$route['(\w{2})/shopping-cart'] = "ShoppingCartPage";
$route['users/update-order-status/(:num)/(:any)'] = "Users/update_order_status/$1/$2";

// Shop page (greenlabel template)
$route['shop'] = "home/shop";
$route['(\w{2})/shop'] = "home/shop";

// Textual Pages links
$route['page/(:any)'] = "page/index/$1";
$route['(\w{2})/page/(:any)'] = "page/index/$2";
//$route['aboutus'] = "Users/aboutus";
$route['reward'] = "Users/reward";
$route['aboutus'] = "Users/aboutus";
$route['refer-friend'] = "Users/refer_friend";
$route['gift'] = "Users/gift";
$route['gift-card-details'] = "Users/gift_card_details";

// Login Public Users Page
$route['login'] = "Users/login";
$route['(\w{2})/login'] = "Users/login";


// Register Public Users Page
$route['register'] = "Users/register";
$route['(\w{2})/register'] = "Users/register";

// Users Profiles Public Users Page
$route['myaccount'] = "Users/myaccount";
$route['myaccount/(:num)'] = "Users/myaccount/$1";
$route['(\w{2})/myaccount'] = "Users/myaccount";
$route['(\w{2})/myaccount/(:num)'] = "Users/myaccount/$2";

$route['manage-address'] = "Users/manage_address";
$route['manage-address/(:num)'] = "Users/manage_address/$1";
$route['(\w{2})/manage-address'] = "Users/manage_address";
$route['(\w{2})/manage-address/(:num)'] = "Users/manage_address/$2";

$route['add-address'] = "Users/add_address";
$route['edit-address/(:num)'] = "Users/edit_address/$1";
$route['edit-personal-info/(:num)'] = "Users/edit_personal_info/$1";

// Logout Profiles Public Users Page
$route['logout'] = "Users/logout";
$route['(\w{2})/logout'] = "Users/logout";

$route['sitemap.xml'] = "home/sitemap";

// Confirm link
$route['confirm/(:any)'] = "home/confirmLink/$1";

/*
 * Vendor Controllers Routes
 */
$route['vendor/login'] = "vendor/auth/login";
$route['(\w{2})/vendor/login'] = "vendor/auth/login";
$route['vendor/register'] = "vendor/auth/register";
$route['(\w{2})/vendor/register'] = "vendor/auth/register";
$route['vendor/forgotten-password'] = "vendor/auth/forgotten";
$route['(\w{2})/vendor/forgotten-password'] = "vendor/auth/forgotten";
$route['vendor/me'] = "vendor/VendorProfile";
$route['(\w{2})/vendor/me'] = "vendor/VendorProfile";
$route['vendor/logout'] = "vendor/VendorProfile/logout";
$route['(\w{2})/vendor/logout'] = "vendor/VendorProfile/logout";
$route['vendor/products'] = "vendor/Products";
$route['(\w{2})/vendor/products'] = "vendor/Products";
$route['vendor/products/(:num)'] = "vendor/Products/index/$1";
$route['(\w{2})/vendor/products/(:num)'] = "vendor/Products/index/$2";
$route['vendor/add/product'] = "vendor/AddProduct";
$route['(\w{2})/vendor/add/product'] = "vendor/AddProduct";
$route['vendor/edit/product/(:num)'] = "vendor/AddProduct/index/$1";
$route['(\w{2})/vendor/edit/product/(:num)'] = "vendor/AddProduct/index/$1";
$route['vendor/orders'] = "vendor/Orders";
$route['vendor/orders/(:num)'] = "vendor/Orders/index/$1";
$route['(\w{2})/vendor/orders'] = "vendor/Orders";
$route['vendor/uploadOthersImages'] = "vendor/AddProduct/do_upload_others_images";
$route['vendor/loadOthersImages'] = "vendor/AddProduct/loadOthersImages";
$route['vendor/removeSecondaryImage'] = "vendor/AddProduct/removeSecondaryImage";
$route['vendor/delete/product/(:num)'] = "vendor/products/deleteProduct/$1";
$route['(\w{2})/vendor/delete/product/(:num)'] = "vendor/products/deleteProduct/$1";
$route['vendor/view/(:any)'] = "Vendor/index/0/$1";
$route['(\w{2})/vendor/view/(:any)'] = "Vendor/index/0/$2";
$route['vendor/view/(:any)/(:num)'] = "Vendor/index/$2/$1";
$route['(\w{2})/vendor/view/(:any)/(:num)'] = "Vendor/index/$3/$2";
$route['(:any)/(:any)_(:num)'] = "Vendor/viewProduct/$1/$3";
$route['(\w{2})/(:any)/(:any)_(:num)'] = "Vendor/viewProduct/$2/$4";
$route['vendor/changeOrderStatus'] = "vendor/orders/changeOrdersOrderStatus";
$route['category'] = "home/category";
$route['category/(:any)'] = "home/category/$1";
$route['products'] = "home/products";
$route['products/(:any)'] = "home/products/$1";
$route['vendor/return'] = "vendor/order_return";
// Site Multilanguage
$route['^(\w{2})/(.*)$'] = '$2';
$route['forgot-password'] = "Users/forgot_password";
$route['resetpassword/(:any)'] = "Users/resetpassword/$1";
$route['vendor/edit'] = "vendor/VendorProfile/edit";
$route['wishlist'] = "Users/wishlist";

// Ingredients page
$route['ingredient'] = "home/ingredients";
$route['ingredient_details/(:num)'] = "home/ingredient_details/$1";
/*
 * Admin Controllers Routes
 */
// HOME / LOGIN
$route['admin'] = "admin/home/login";
// ECOMMERCE GROUP
$route['admin/publish'] = "admin/ecommerce/publish";
$route['admin/publish/(:num)'] = "admin/ecommerce/publish/index/$1";
$route['admin/removeSecondaryImage'] = "admin/ecommerce/publish/removeSecondaryImage";
$route['admin/products'] = "admin/ecommerce/products";
$route['admin/products/(:num)'] = "admin/ecommerce/products/index/$1";
$route['admin/products_review'] = "admin/ecommerce/products_review";
$route['admin/products_review/(:num)'] = "admin/ecommerce/products_review/index/$1";
$route['admin/update_review?(:any)'] = "admin/ecommerce/products_review/index/$1";
$route['admin/publish_status/(:num)/(:num)'] = "admin/ecommerce/publish/update_status/$1/$2";
$route['admin/doctor_consultation'] = "admin/ecommerce/users/doctor_consultation";
$route['admin/doctor_consultation/(:num)'] = "admin/ecommerce/users/doctor_consultation/$1";
$route['admin/banner'] = "admin/ecommerce/banner";
$route['admin/banner/add'] = "admin/ecommerce/banner/add_banner";
$route['admin/banner/edit/(:num)'] = "admin/ecommerce/banner/edit_banner/$1";
$route['admin/home_banner'] = "admin/settings/home_banner";
$route['admin/return'] = "admin/ecommerce/order_return";
$route['admin/return/(:num)'] = "admin/ecommerce/order_return/index/$1";
$route['admin/changeReturnStatus'] = "admin/ecommerce/order_return/change_return_status";
$route['admin/processReturnOrder/(:num)/(:num)/(:num)/(:num)'] = "admin/ecommerce/order_return/process_return_order/$1/$2/$3/$4";
$route['admin/aboutus/(:num)'] = "admin/ecommerce/Users/aboutus/$1";

$route['admin/aboutusbanner'] = "admin/ecommerce/Users/aboutusbanner";
$route['admin/aboutusbanner/add'] = "admin/ecommerce/Users/add_aboutusbanner";
$route['admin/aboutusbanner/edit/(:num)'] = "admin/ecommerce/Users/edit_aboutusbanner/$1";

/* Ingredient Admin*/
$route['admin/ingredient'] = "admin/ecommerce/ingredient";
$route['admin/ingredient/(:num)'] = "admin/ecommerce/ingredient/index/$1";
$route['admin/ingredient/add'] = "admin/ecommerce/ingredient/add_ingredient";
$route['admin/ingredient/edit/(:num)'] = "admin/ecommerce/ingredient/edit_ingredient/$1";

$route['admin/ingredient_banner'] = "admin/ecommerce/ingredient/ingredient_banner";

/* Ingredient Product */
$route['admin/ingredient/product_list'] = "admin/ecommerce/ingredient/product_list";
$route['admin/ingredient/product_list/(:num)'] = "admin/ecommerce/ingredient/product_list/$1";
$route['admin/ingredient/add_product_list'] = "admin/ecommerce/ingredient/add_ingredient_product";
$route['admin/ingredient/edit_product_list/(:num)'] = "admin/ecommerce/ingredient/edit_ingredient_product/$1";

$route['admin/productStatusChange'] = "admin/ecommerce/products/productStatusChange";
$route['admin/shopcategories'] = "admin/ecommerce/ShopCategories";
$route['admin/shopcategories/(:num)'] = "admin/ecommerce/ShopCategories/index/$1";
$route['admin/editshopcategorie'] = "admin/ecommerce/ShopCategories/editShopCategorie";
$route['admin/orders'] = "admin/ecommerce/orders";
$route['admin/orders/(:num)'] = "admin/ecommerce/orders/index/$1";
$route['admin/changeOrdersOrderStatus'] = "admin/ecommerce/orders/changeOrdersOrderStatus";
$route['admin/orders/process_order'] = "admin/ecommerce/orders/process_order";
$route['admin/changeOrdersOrderStatusByShiprocket'] = "admin/ecommerce/orders/changeOrdersOrderStatusByShiprocket";
$route['admin/brands'] = "admin/ecommerce/brands";
$route['admin/changePosition'] = "admin/ecommerce/ShopCategories/changePosition";
$route['admin/changeTag'] = "admin/ecommerce/ShopCategories/changeTag";
$route['admin/discounts'] = "admin/ecommerce/discounts";
$route['admin/rating'] = "admin/ecommerce/discounts/rating";
$route['admin/rating/(:num)'] = "admin/ecommerce/discounts/rating/$1";
$route['admin/rating/add'] = "admin/ecommerce/discounts/add_rating";
$route['admin/rating/edit/(:num)'] = "admin/ecommerce/discounts/edit_rating/$1";

$route['admin/video_review'] = "admin/ecommerce/discounts/video_review";
$route['admin/video_review/(:num)'] = "admin/ecommerce/discounts/video_review/$1";
$route['admin/video_review/edit/(:num)'] = "admin/ecommerce/discounts/edit_video_review/$1";

$route['admin/discounts/(:num)'] = "admin/ecommerce/discounts/index/$1";
$route['admin/deliveryCharge'] = "admin/ecommerce/delivery_charges";
$route['admin/deliveryCharge/download'] = "admin/ecommerce/delivery_charges/download";
$route['admin/deliveryCharge/(:num)'] = "admin/ecommerce/delivery_charges/index/$1";
// REPORT GROUP
$route['admin/report'] = "admin/ecommerce/report";
$route['admin/report/product'] = "admin/ecommerce/report/product";
$route['admin/report/user'] = "admin/ecommerce/report/user";
$route['admin/report/subscriber'] = "admin/ecommerce/report/subscriber";
$route['admin/report/order_updates'] = "admin/ecommerce/report/order_updates";
$route['admin/report/advance_order'] = "admin/ecommerce/report/advance_order";
$route['admin/report/return_order'] = "admin/ecommerce/report/return_order";
$route['admin/report/invenoty'] = "admin/ecommerce/report/invenoty";

$route['admin/orders/tracking_details'] = "admin/ecommerce/orders/tracking_details";
$route['admin/cancelOrder'] = "admin/ecommerce/orders/cancelOrder";
$route['admin/userlevel'] = "admin/advanced_settings/userlevel";
// BLOG GROUP
$route['admin/blogpublish'] = "admin/blog/BlogPublish";
$route['admin/blogpublish/(:num)'] = "admin/blog/BlogPublish/index/$1";
$route['admin/blog'] = "admin/blog/blog";
$route['admin/blog/(:num)'] = "admin/blog/blog/index/$1";
// SETTINGS GROUP
$route['admin/settings'] = "admin/settings/settings";
$route['admin/styling'] = "admin/settings/styling";
$route['admin/templates'] = "admin/settings/templates";
$route['admin/titles'] = "admin/settings/titles";
$route['admin/pages'] = "admin/settings/pages";
$route['admin/emails'] = "admin/settings/emails";
$route['admin/emails/(:num)'] = "admin/settings/emails/index/$1";
$route['admin/history'] = "admin/settings/history";
$route['admin/history/(:num)'] = "admin/settings/history/index/$1";
// ADVANCED SETTINGS
$route['admin/languages'] = "admin/advanced_settings/languages";
$route['admin/filemanager'] = "admin/advanced_settings/filemanager";
$route['admin/adminusers'] = "admin/advanced_settings/adminusers";

$route['admin/vendors'] = "admin/advanced_settings/vendorusers";
$route['admin/editVendor/(:num)'] = "admin/advanced_settings/vendorusers/editvendor/$1";
$route['admin/syncVendor/(:num)'] = "admin/advanced_settings/vendorusers/syncvendor/$1";
$route['admin/addVendor'] = "admin/advanced_settings/vendorusers/addvendor";
$route['admin/account'] = "admin/ecommerce/accounts";

$route['admin/pickuplocation'] = "admin/advanced_settings/pickuplocation";
$route['admin/addpickuplocation'] = "admin/advanced_settings/pickuplocation/addlocation";
$route['admin/editpickuplocation/(:num)'] = "admin/advanced_settings/pickuplocation/editlocation/$1";

// TEXTUAL PAGES
$route['admin/pageedit/(:any)'] = "admin/textual_pages/TextualPages/pageEdit/$1";
$route['admin/changePageStatus'] = "admin/textual_pages/TextualPages/changePageStatus";
// LOGOUT
$route['admin/logout'] = "admin/home/home/logout";
// Admin pass change ajax
$route['admin/changePass'] = "admin/home/home/changePass";
$route['admin/uploadOthersImages'] = "admin/ecommerce/publish/do_upload_others_images";
$route['admin/loadOthersImages'] = "admin/ecommerce/publish/loadOthersImages";
$route['vendorusers/getThanaList'] = "admin/advanced_settings/vendorusers/getThanaList";


$route['admin/aPlusContent'] = "admin/ecommerce/publish/aPlusContent_upload";
$route['admin/loadImages'] = "admin/ecommerce/publish/loadImages";
$route['admin/removeaPlusImages'] = "admin/ecommerce/publish/removeaPlusImages";

$route['admin/tagContent'] = "admin/ecommerce/publish/tag_images_upload";
$route['admin/tagContentImages'] = "admin/ecommerce/publish/loadTagImages";
$route['admin/removeTagImages'] = "admin/ecommerce/publish/removeTagImages";
/*
  | -------------------------------------------------------------------------
  | Sample REST API Routes
  | -------------------------------------------------------------------------
 */
$route['api/products/(\w{2})/get'] = 'Api/Products/all/$1';
$route['api/product/(\w{2})/(:num)/get'] = 'Api/Products/one/$1/$2';
$route['api/product/set'] = 'Api/Products/set';
$route['api/product/(\w{2})/delete'] = 'Api/Products/productDel/$1';
$route['api/order/update'] = 'Api/Orders/set';
$route['syncData/syncOrder'] = 'admin/ecommerce/orders/syncOrder';

$route['getToken'] = 'home/getToken';
$route['create_category'] = 'home/create_category';
/* Store Locator */

$route['admin/store'] = "admin/ecommerce/store";
$route['admin/store/(:num)'] = "admin/ecommerce/store/index/$1";
$route['admin/store/add'] = "admin/ecommerce/store/add_store";
$route['admin/store/edit/(:num)'] = "admin/ecommerce/store/edit_store/$1";

/* Shop Concern */
$route['admin/shopConcern'] = "admin/home/home/shop_concern";
$route['admin/shopConcern/(:num)'] = "admin/home/home/shop_concern/$1";
$route['admin/shopConcern/add'] = "admin/home/home/add_shop_concern";
$route['admin/shopConcern/edit/(:num)'] = "admin/home/home/edit_concern/$1";

$route['admin/product_list_banner'] = "admin/home/home/product_list_banner";
$route['admin/product_list_banner/(:num)'] = "admin/home/home/product_list_banner/$1";
$route['admin/product_list_banner/add'] = "admin/home/home/add_product_list_banner";
 $route['admin/product_list_banner/edit/(:num)'] = "admin/home/home/edit_product_list_banner/$1";

 $route['admin/quiz_image/(:num)'] = "admin/home/home/quiz_image/$1";

/* testimonials */
$route['admin/testimonial'] = "admin/home/home/testimonial";
$route['admin/testimonial/(:num)'] = "admin/home/home/testimonial/$1";
$route['admin/testimonial/add'] = "admin/home/home/add_testimonial";
$route['admin/testimonial/edit/(:num)'] = "admin/home/home/edit_testimonial/$1";

/*  Regime shop */
$route['admin/regime'] = "admin/home/home/regime";
$route['admin/regime/add'] = "admin/home/home/add_regime";
$route['admin/regime/edit/(:num)'] = "admin/home/home/edit_regime/$1";

$route['admin/products_bulk_upload'] = "admin/ecommerce/products/products_bulk_upload";
$route['admin/importProductData'] = "admin/ecommerce/products/importProductData";
$route['admin/exportShopCategory'] = "admin/ecommerce/products/shop_category_export";
$route['admin/exportCategory'] = "admin/ecommerce/products/category_export";

$route['admin/productSync'] = "admin/ecommerce/products/productSync";
$route['admin/productExport'] = "admin/ecommerce/products/product_export";

$route['admin/abandoned_cart'] = "admin/ecommerce/Users/abandoned_cart";
$route['admin/abandoned_cart/(:num)'] = "admin/ecommerce/Users/abandoned_cart/$1";
$route['admin/sendPush'] = "admin/ecommerce/Users/sendPush";

$route['admin/contact_us'] = "admin/ecommerce/Users/contact_us"; 
$route['admin/contact_us/(:num)'] = "admin/ecommerce/Users/contact_us/$1";

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
