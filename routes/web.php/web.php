<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

use App\CPU\Helpers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Payment_Methods\SslCommerzPaymentController;
use App\Http\Controllers\Payment_Methods\StripePaymentController;
use App\Http\Controllers\Payment_Methods\PaymobController;
use App\Http\Controllers\Payment_Methods\FlutterwaveV3Controller;
use App\Http\Controllers\Payment_Methods\PaytmController;
use App\Http\Controllers\Payment_Methods\PaypalPaymentController;
use App\Http\Controllers\Payment_Methods\PaytabsController;
use App\Http\Controllers\Payment_Methods\LiqPayController;
use App\Http\Controllers\Payment_Methods\RazorPayController;
use App\Http\Controllers\Payment_Methods\SenangPayController;
use App\Http\Controllers\Payment_Methods\MercadoPagoController;
use App\Http\Controllers\Payment_Methods\BkashPaymentController;
use App\Http\Controllers\Payment_Methods\PaystackController;


//for maintenance mode
Route::get('ttt', 'Web\WebController@ttt')->name('ttt');
Route::get('/img/{path}', 'Web\WebController@getImg')->where('path', '.*')->name('imgCompress');
Route::get('maintenance-mode', 'Web\WebController@maintenance_mode')->name('maintenance-mode');

Route::get('salla/oauth/redirect', 'SallaOAuthController@redirect')->name('salla.oauth.redirect');
Route::get('salla/oauth/callback', 'SallaOAuthController@callback')->name('oauth.callback');
Route::get('salla/oauth/refresh', 'SallaOAuthController@refresh')->name('oauth.refresh');

Route::get('zid/oauth/redirect', 'ZidOAuthController@redirect')->name('zid.oauth.redirect');
Route::post('zid/oauth/redirect', 'ZidOAuthController@redirect_post');
Route::any('zid/oauth/callback', 'ZidOAuthController@callback')->name('zid.oauth.callback');

Route::get('/getChildren/{object}/{id}', 'Web\WebController@getChildren')->name('getChildren');

Route::group(['namespace' => 'Web','middleware'=>['maintenance_mode']], function () {
    Route::get('/', 'WebController@home')->name('home');
    Route::get('checkout-complete-by-customer/{order_id}', 'WebController@checkout_with_customer_view');
    Route::get('checkout-complete-by-customer_/{order_id}', 'WebController@checkout_with_customer_view')->name('checkout-complete-by-customer_');
    Route::post('checkout-complete-by-customer', 'WebController@checkout_with_customer')->name('checkout-complete-by-customer');
    Route::post('checkout-complete-by-customer-wallet', 'WebController@checkout_with_customer_wallet')->name('checkout-complete-by-customer-wallet');
    Route::post('set-shipping-method', 'WebController@insert_into_order_shipping')->name('set-order-shipping-method');
});

/*myfatoorah*/
/*Route::get('/myfatoorah', function (){return view('myfatoorah-test');})->name('myfatoorah');*/
Route::post('pay-myfatoorah', 'MyFatoorahController@index')->name('pay-myfatoorah');
Route::get('myfatoorah-callback', 'MyFatoorahController@callback')->name('myfatoorah-callback');
Route::get('myfatoorah-sub-callback', 'MyFatoorahController@sub_callback')->name('myfatoorah-sub-callback');
Route::get('myfatoorah-status', 'MyFatoorahController@getPaymentStatus')->name('myfatoorah-status');
Route::get('myfatoorah-success', 'MyFatoorahController@success')->name('myfatoorah-success');
Route::get('myfatoorah-fail', 'MyFatoorahController@fail')->name('myfatoorah-fail');
Route::post('pay-myfatoorah-order-by-customer', 'MyFatoorahController@myfatoorah_payment_with_customer')->name('pay-myfatoorah-order-by-customer');
/*myfatoorah*/

Route::get('notifications', 'Web\WebController@notifications')->name('notifications');
Route::get('notifications/get', 'Web\WebController@notifications_get')->name('notifications.get');
Route::get('notifications/read/{id}', 'Web\WebController@notifications_read')->name('notifications.read');

Route::post('/currency', 'Web\CurrencyController@changeCurrency')->name('currency.change');

Route::group(['namespace' => 'Web'], function () {


    Route::get('terms', 'WebController@termsandCondition')->name('terms');
    Route::get('privacy-policy', 'WebController@privacy_policy')->name('privacy-policy');
    Route::get('warranty-policy', 'WebController@warranty_policy')->name('warranty-policy');
    Route::get('about-us', 'WebController@about_us')->name('about-us');
    //FAQ route
    Route::get('helpTopic', 'WebController@helpTopic')->name('helpTopic');
    //Contacts
    Route::get('contacts', 'WebController@contacts')->name('contacts');
    Route::group(['prefix' => 'contact', 'as' => 'contact.'], function () {
        Route::post('store', 'WebController@contact_store')->name('store');
        Route::get('/code/captcha/{tmp}', 'WebController@captcha')->name('default-captcha');
    });
    Route::any('get-shipping-areas', 'UserProfileController@get_shipping_areas')->name('get-shipping-areas');
});


Route::group(['namespace' => 'Web','middleware'=>['maintenance_mode','customer']], function () {

    Route::get('subscriptions', 'UserProfileController@subscriptions')->name('subscriptions');
    Route::get('subscriptions/pay/{plan_id}', 'UserProfileController@subscriptions_pay')->name('subscriptions-pay');
    Route::get('checkout-complete-wallet', 'WebController@checkout_complete_wallet')->name('checkout-complete-wallet');


    Route::get('quick-view', 'WebController@quick_view')->name('quick-view');
    Route::get('searched-products', 'WebController@searched_products')->name('searched-products');

    Route::group(['middleware'=>['customer']], function () {
        Route::get('checkout-details', 'WebController@checkout_details')->name('checkout-details');
        Route::get('checkout-shipping', 'WebController@checkout_shipping')->name('checkout-shipping')->middleware('customer');
        Route::get('checkout-payment', 'WebController@checkout_payment')->name('checkout-payment')->middleware('customer');
        Route::get('checkout-review', 'WebController@checkout_review')->name('checkout-review')->middleware('customer');
        Route::get('checkout-complete', 'WebController@checkout_complete')->name('checkout-complete')->middleware('customer');
        Route::post('checkout-complete', 'WebController@checkout_complete')->middleware('customer');
        Route::post('offline-payment-checkout-complete', 'WebController@offline_payment_checkout_complete')->name('offline-payment-checkout-complete')->middleware('customer');
        Route::get('order-placed', 'WebController@order_placed')->name('order-placed')->middleware('customer');
        Route::get('shop-cart', 'WebController@shop_cart')->name('shop-cart');
        Route::post('order_note', 'WebController@order_note')->name('order_note');
        Route::get('digital-product-download/{id}', 'WebController@digital_product_download')->name('digital-product-download')->middleware('customer');
        Route::get('submit-review/{id}','UserProfileController@submit_review')->name('submit-review');
        Route::post('review', 'ReviewController@store')->name('review.store');
        Route::get('deliveryman-review/{id}','ReviewController@delivery_man_review')->name('deliveryman-review');
        Route::post('submit-deliveryman-review','ReviewController@delivery_man_submit')->name('submit-deliveryman-review');

        Route::get('/salla/products/sync/{skip}', 'WebController@products_sync')->name('salla.products.sync');
        Route::get('/salla/products/delete', 'WebController@products_delete')->name('salla.products.delete');
        Route::delete('/salla/products/bulk_delete', 'WebController@products_bulk_delete')->name('salla.products.bulk.delete');
        Route::delete('/salla/products/bulk_delete_linked', 'WebController@products_bulk_delete_linked')->name('salla.linkedproducts.bulk.delete');

        Route::post('linked-products', 'WebController@linkedProducts')->name('linked-products');
        Route::get('linked-products-check', 'WebController@linkedProducts_check')->name('linked-products.check');
        Route::get('linked-products', 'WebController@linkedProducts_get')->name('linked-products-get');
        Route::get('linked-products/options/{option}/{value}', 'WebController@linked_products_options')->name('linked-products-options');
        Route::get('linked-products-add', 'WebController@linkedProducts_add')->name('linked-products.add');
        Route::post('linked-products-add', 'WebController@linkedProducts_add')->name('linked-products.addall');
        Route::get('linked-products-remove', 'WebController@linkedProducts_remove')->name('linked-products.remove');
        Route::get('linked-products-delete', 'WebController@linkedProductsRemoveDelete')->name('linked-products.delete');
        Route::get('linked-products-sync-delete', 'WebController@product_deleted_sync')->name('linked-products.deleted-sync');
        Route::post('linked-products/price/edit', 'WebController@linkedProducts_price_edit')->name('linked-products.price.edit');
        Route::get('list_skip', 'WebController@list_skip')->name('list_skip');

        Route::get('linked-accounts', 'WebController@linkedAccounts')->name('linked-accounts');
        Route::get('linked-accounts-delete/{id}', 'WebController@linkedAccounts_delete')->name('linked-accounts-delete');
        Route::get('search-shop', 'WebController@search_shop')->name('search-shop');

        Route::get('categories', 'WebController@all_categories')->name('categories');
        Route::get('category-ajax/{id}', 'WebController@categories_by_category')->name('category-ajax');

        Route::get('brands', 'WebController@all_brands')->name('brands');
        Route::get('sellers', 'WebController@all_sellers')->name('sellers');
        Route::get('seller-profile/{id}', 'WebController@seller_profile')->name('seller-profile');

        // 11
        Route::get('pay-offline-method-list', 'WebController@pay_offline_method_list')->name('pay-offline-method-list')->middleware('guestCheck');
        // 11

        Route::get('/product/{slug}', 'WebController@product')->name('product');
        Route::get('products', 'WebController@products')->name('products');
        Route::get('products-lazy', 'WebController@products')->name('products_lazy');
        Route::get('orderDetails', 'WebController@orderdetails')->name('orderdetails');
        Route::get('discounted-products', 'WebController@discounted_products')->name('discounted-products');
        Route::post('review-list-product','WebController@review_list_product')->name('review-list-product');
        //Chat with seller from product details
        Route::get('chat-for-product', 'WebController@chat_for_product')->name('chat-for-product');
        Route::get('flash-deals/{id}', 'WebController@flash_deals')->name('flash-deals');

        Route::get('wishlists', 'WebController@viewWishlist')->name('wishlists')->middleware('customer');
        Route::post('store-wishlist', 'WebController@storeWishlist')->name('store-wishlist');
        Route::post('delete-wishlist', 'WebController@deleteWishlist')->name('delete-wishlist');

        Route::group(['prefix' => 'track-order', 'as' => 'track-order.'], function () {
            Route::get('', 'UserProfileController@track_order')->name('index');
            Route::get('result-view', 'UserProfileController@track_order_result')->name('result-view');
            Route::get('last', 'UserProfileController@track_last_order')->name('last');
            Route::any('result', 'UserProfileController@track_order_result')->name('result');
        });


        Route::group(['prefix' => 'education' , 'as' => 'education.'], function () {
            Route::get('/', 'EducationController@home')->name('home');
            Route::get('category/{slug}', 'EducationController@category')->name('category');
            Route::get('article/{slug}', 'EducationController@article')->name('article');
            Route::post('search', 'EducationController@search');

            Route::group(['prefix' => 'back-end' , 'as' => 'back-end.'], function () {
                Route::get('articles', 'EducationController@article_index')->name('articles');
                Route::get('articles/edit/{id}', 'EducationController@article_edit')->name('articles.edit');
                Route::get('articles/add', 'EducationController@article_create')->name('articles.add');
                Route::post('articles/update', 'EducationController@article_update')->name('articles.update');
                Route::post('articles/store', 'EducationController@article_store')->name('articles.store');
                Route::post('articles/delete', 'EducationController@article_destroy')->name('articles.delete');
                Route::delete('articles-bulk-delete', 'EducationController@article_bulkDelete')->name('articles-bulk-delete');
                Route::post('/article-upload', 'EducationController@uploadVideo')->name('articles.uploadv');


                Route::get('categories', 'EducationController@category_index')->name('categories');
                Route::get('categories/edit/{id}', 'EducationController@category_edit')->name('categories.edit');
                Route::get('categories/add', 'EducationController@category_create')->name('categories.add');
                Route::post('categories/store', 'EducationController@category_store')->name('categories.store');
                Route::post('categories/delete', 'EducationController@category_destroy')->name('categories.delete');
                Route::post('categories/update', 'EducationController@category_update')->name('categories.update');
                Route::delete('categories-bulk-delete', 'EducationController@category_bulkDelete')->name('categories-bulk-delete');

                Route::get('/check-url/{slug}', function($slug) {
                    return Helpers::isurlexist($slug);
                });


            });

        });

        //check done
        Route::group(['prefix' => 'cart', 'as' => 'cart.'], function () {
            Route::post('variant_price', 'CartController@variant_price')->name('variant_price');
            Route::post('add', 'CartController@addToCart')->name('add');
            Route::post('remove', 'CartController@removeFromCart')->name('remove');
            Route::post('remove-all', 'CartController@deleteCart')->name('remove-all');
            Route::post('nav-cart-items', 'CartController@updateNavCart')->name('nav-cart');
            Route::post('updateQuantity', 'CartController@updateQuantity')->name('updateQuantity');
        });

        //delegates
        Route::group(['prefix' => 'delegates', 'as' => 'delegates.'], function () {
            Route::get('list', 'DelegatedStoreController@list')->name('list');
            Route::get('add', 'DelegatedStoreController@add')->name('add');
            Route::post('store', 'DelegatedStoreController@store')->name('store');
            Route::post('status-update', 'DelegatedStoreController@status')->name('status-update');
            Route::delete('delete/{id}', 'DelegatedStoreController@delete')->name('delete');
            Route::get('edit/{id}', 'DelegatedStoreController@edit')->name('edit');
            Route::post('update', 'DelegatedStoreController@update')->name('update');
            Route::post('update/{id}', 'DelegatedStoreController@update_role')->name('custom-role.update');

        });
    });

    //wallet payment

    Route::post('subscription', 'WebController@subscription')->name('subscription');












    //profile Route

    Route::get('user-account', 'UserProfileController@user_account')->name('user-account');
    Route::post('user-account-update', 'UserProfileController@user_update')->name('user-update');
    Route::post('delegate-account-update', 'DelegatedStoreController@delegate_update')->name('delegate-update');
    Route::post('user-account-picture', 'UserProfileController@user_picture')->name('user-picture');
    Route::get('account-address', 'UserProfileController@account_address')->name('account-address');
    Route::post('account-address-store', 'UserProfileController@address_store')->name('address-store');
    Route::get('account-address-delete', 'UserProfileController@address_delete')->name('address-delete');
    ROute::get('account-address-edit/{id}','UserProfileController@address_edit')->name('address-edit');
    ROute::post('default-address','UserProfileController@change_default_address')->name('default-address-edit');
    Route::post('account-address-update', 'UserProfileController@address_update')->name('address-update');
    Route::get('account-payment', 'UserProfileController@account_payment')->name('account-payment');
    Route::get('account-oder', 'UserProfileController@account_oder')->name('account-oder');
    Route::get('orders', 'WebController@orders')->name('orders');
    Route::get('sync_orders', 'WebController@sync_orders')->name('sync_orders');
    Route::get('sync_orders_skip', 'WebController@sync_orders_skip')->name('sync_orders_skip');
    Route::get('orders/{id}', 'WebController@orders_show')->name('orders.show');
    Route::get('account-order-details', 'UserProfileController@account_order_details')->name('account-order-details')->middleware('customer');
    Route::get('generate-invoice/{id}', 'UserProfileController@generate_invoice')->name('generate-invoice');
    Route::get('account-wishlist', 'UserProfileController@account_wishlist')->name('account-wishlist'); //add to card not work
    Route::get('refund-request/{id}','UserProfileController@refund_request')->name('refund-request');
    Route::get('refund-details/{id}','UserProfileController@refund_details')->name('refund-details');
    Route::post('refund-store','UserProfileController@store_refund')->name('refund-store');
    Route::get('account-tickets', 'UserProfileController@account_tickets')->name('account-tickets');
    Route::get('order-cancel/{id}', 'UserProfileController@order_cancel')->name('order-cancel');
    Route::post('ticket-submit', 'UserProfileController@ticket_submit')->name('ticket-submit');
    Route::get('account-delete/{id}','UserProfileController@account_delete')->name('account-delete');
    // Chatting start
    Route::get('chat/{type}', 'ChattingController@chat_list')->name('chat');
    Route::get('messages', 'ChattingController@messages')->name('messages');
    Route::post('messages-store', 'ChattingController@messages_store')->name('messages_store');
    // chatting end

    //Support Ticket
    Route::group(['prefix' => 'support-ticket', 'as' => 'support-ticket.'], function () {
        Route::get('{id}', 'UserProfileController@single_ticket')->name('index');
        Route::post('{id}', 'UserProfileController@comment_submit')->name('comment');
        Route::get('delete/{id}', 'UserProfileController@support_ticket_delete')->name('delete');
        Route::get('close/{id}', 'UserProfileController@support_ticket_close')->name('close');
    });

    Route::get('account-transaction', 'UserProfileController@account_transaction')->name('account-transaction');
    Route::get('account-wallet-history', 'UserProfileController@account_wallet_history')->name('account-wallet-history');

    Route::get('wallet','UserWalletController@index')->name('wallet');
    Route::get('charge-wallet','UserWalletController@charge')->name('charge-wallet');
    Route::get('loyalty','UserLoyaltyController@index')->name('loyalty');
    Route::post('loyalty-exchange-currency','UserLoyaltyController@loyalty_exchange_currency')->name('loyalty-exchange-currency');





    //sellerShop
    Route::get('shopView/{id}', 'WebController@seller_shop')->name('shopView');
    Route::post('shopView/{id}', 'WebController@seller_shop_product');

    //top Rated
    Route::get('top-rated', 'WebController@top_rated')->name('topRated');
    Route::get('best-sell', 'WebController@best_sell')->name('bestSell');
    Route::get('new-product', 'WebController@new_product')->name('newProduct');


});

//Seller shop apply
Route::group(['prefix' => 'shop', 'as' => 'shop.', 'namespace' => 'Seller\Auth'], function () {
    Route::get('apply', 'RegisterController@create')->name('apply');
    Route::post('apply', 'RegisterController@store');

});



//Seller shop apply
Route::group(['prefix' => 'coupon', 'as' => 'coupon.', 'namespace' => 'Web'], function () {
    Route::post('apply', 'CouponController@apply')->name('apply');
    Route::get('remove', 'CouponController@remove')->name('remove');
});
//check done

$is_published = 0;
try {
    $full_data = include('Modules/Gateways/Addon/info.php');
    $is_published = $full_data['is_published'] == 1 ? 1 : 0;
} catch (\Exception $exception) {
}


// if (!$is_published) {
    Route::group(['prefix' => 'payment'], function () {

        //Fatoora
        Route::group(['prefix' => 'fatoorah', 'as' => 'fatoorah.'], function () {
            Route::any('pay/', 'FatoorahPaymentController@index')->name('index');
            Route::post('checkout', 'FatoorahPaymentController@checkout')->name('checkout');
            Route::get('paymentstatus', 'FatoorahPaymentController@check_payment')->name('paymentstatus');
        });

        //SSLCOMMERZ
        Route::group(['prefix' => 'sslcommerz', 'as' => 'sslcommerz.'], function () {
            Route::get('pay', 'SslCommerzPaymentController@index')->name('pay');
            Route::post('success', 'SslCommerzPaymentController@success')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
            Route::post('failed', 'SslCommerzPaymentController@failed')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
            Route::post('canceled', 'SslCommerzPaymentController@canceled')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //STRIPE
        Route::group(['prefix' => 'stripe', 'as' => 'stripe.'], function () {
            Route::get('pay', 'StripePaymentController@index')->name('pay');
            Route::get('token', 'StripePaymentController@payment_process_3d')->name('token');
            Route::get('success', 'StripePaymentController@success')->name('success');
        });

        //RAZOR-PAY
        Route::group(['prefix' => 'razor-pay', 'as' => 'razor-pay.'], function () {
            Route::get('pay', 'RazorPayController@index');
            Route::post('payment', 'RazorPayController@payment')->name('payment')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //PAYPAL
        Route::group(['prefix' => 'paypal', 'as' => 'paypal.'], function () {
            Route::get('pay', 'PaypalPaymentController@payment');
            Route::any('success', 'PaypalPaymentController@success')->name('success')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);;
            Route::any('cancel', 'PaypalPaymentController@cancel')->name('cancel')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //SENANG-PAY
        Route::group(['prefix' => 'senang-pay', 'as' => 'senang-pay.'], function () {
            Route::get('pay', 'SenangPayController@index');
            Route::any('callback', 'SenangPayController@return_senang_pay')
            ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //PAYTM
        Route::group(['prefix' => 'paytm', 'as' => 'paytm.'], function () {
            Route::get('pay', 'PaytmController@payment');
            Route::any('response', 'PaytmController@callback')->name('response')
            ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //FLUTTERWAVE
        Route::group(['prefix' => 'flutterwave-v3', 'as' => 'flutterwave-v3.'], function () {
            Route::get('pay', 'FlutterwaveV3Controller@initialize')->name('pay');
            Route::get('callback', 'FlutterwaveV3Controller@callback')->name('callback');
        });

        //PAYSTACK
        Route::group(['prefix' => 'paystack', 'as' => 'paystack.'], function () {
            Route::get('pay', 'PaystackController@index')->name('pay');
            Route::post('payment', 'PaystackController@redirectToGateway')->name('payment');
            Route::get('callback', 'PaystackController@handleGatewayCallback')->name('callback');
        });

        //BKASH
        Route::group(['prefix' => 'bkash', 'as' => 'bkash.'], function () {
            Route::get('make-payment', 'BkashPaymentController@make_tokenize_payment')->name('make-payment');
            Route::any('callback', 'BkashPaymentController@callback')->name('callback')
            ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //Liqpay
        Route::group(['prefix' => 'liqpay', 'as' => 'liqpay.'], function () {
            Route::get('payment', 'LiqPayController@payment')->name('payment');
            Route::any('callback', 'LiqPayController@callback')->name('callback')
            ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //MERCADOPAGO
        Route::group(['prefix' => 'mercadopago', 'as' => 'mercadopago.'], function () {
            Route::get('pay', 'MercadoPagoController@index')->name('index');
            Route::post('make-payment', 'MercadoPagoController@make_payment')->name('make_payment');
        });

        //PAYMOB
        Route::group(['prefix' => 'paymob', 'as' => 'paymob.'], function () {
            Route::any('pay', 'PaymobController@credit')->name('pay');
            Route::any('callback', 'PaymobController@callback')->name('callback')
            ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //PAYTABS
        Route::group(['prefix' => 'paytabs', 'as' => 'paytabs.'], function () {
            Route::any('pay', 'PaytabsController@payment')->name('pay');
            Route::any('callback', 'PaytabsController@callback')->name('callback')
            ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
            Route::any('response', 'PaytabsController@response')->name('response')
            ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //xendit
        Route::group(['prefix' => 'xendit', 'as' => 'xendit.'], function () {
            Route::get('pay', 'XenditPaymentController@payment')->name('pay');
            Route::any('callback', 'XenditPaymentController@callBack')->name('callback')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //amazon
        Route::group(['prefix' => 'amazon', 'as' => 'amazon.'], function () {
            Route::get('pay', 'AmazonPaymentController@payment')->name('pay');
            Route::any('callback', 'AmazonPaymentController@callBackResponse')->name('callBackResponse')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
            Route::any('callbackstatus', 'AmazonPaymentController@callback')->name('callBack')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //iyzipay
        Route::group(['prefix' => 'iyzipay', 'as' => 'iyzipay.'], function () {
            Route::get('pay', 'IyziPayController@index')->name('index');
            Route::get('payment', 'IyziPayController@payment')->name('payment');
            Route::any('callback', 'IyziPayController@callback')->name('callback')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //Hyperpay
        Route::group(['prefix' => 'hyperpay', 'as' => 'hyperpay.'], function () {
            Route::get('pay', 'HyperPayController@payment')->name('pay');
            Route::any('callback', 'HyperPayController@callback')->name('callback')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //foloosi
        Route::group(['prefix' => 'foloosi', 'as' => 'foloosi.'], function () {
            Route::any('pay', 'FoloosiPaymentController@payment')->name('payment')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
            Route::any('callback', 'FoloosiPaymentController@callback')->name('callback')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //CCavenue
        Route::group(['prefix' => 'ccavenue', 'as' => 'ccavenue.'], function () {
            Route::any('pay', 'CCavenueController@payment')->name('payment-request');
            Route::any('payment-response', 'CCavenueController@payment_response_process')->name('payment-response')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
            Route::any('payment-cancel', 'CCavenueController@payment_cancel')->name('payment-cancel')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //Pvit
        Route::group(['prefix' => 'pvit', 'as' => 'pvit.'], function () {
            Route::any('pay', 'PvitController@payment')->name('pay')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
            Route::any('callback', 'PvitController@callBack')->name('callBack')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //moncash
        Route::group(['prefix' => 'moncash', 'as' => 'moncash.'], function () {
            Route::get('pay', 'MoncashController@payment')->name('payment');
            Route::any('callback', 'MoncashController@callback')->name('callback')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //thawani
        Route::group(['prefix' => 'thawani', 'as' => 'thawani.'], function () {
            Route::get('pay', 'ThawaniPaymentController@checkout')->name('payment');
            Route::get('success', 'ThawaniPaymentController@success')->name('success');
            Route::get('cancel', 'ThawaniPaymentController@cancel')->name('cancel');
        });

        //tap
        Route::group(['prefix' => 'tap', 'as' => 'tap.'], function () {
            Route::get('pay', 'TapPaymentController@payment')->name('payment');
            Route::any('callback', 'TapPaymentController@callback')->name('callback')
            ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //viva wallet
        Route::group(['prefix' => 'viva', 'as' => 'viva.'], function () {
            Route::get('pay', 'VivaWalletController@payment')->name('payment');
            Route::get('success-callback', 'VivaWalletController@success')->name('success');
            Route::get('fail', 'VivaWalletController@fail')->name('fail');
        });

        // Hubtel Payment
        Route::group(['prefix' => 'hubtel', 'as' => 'hubtel.'], function () {
            Route::any('pay', 'HubtelPaymentController@payment')->name('payments');
            Route::any('callback', 'HubtelPaymentController@callback')->name('callback')
            ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
            Route::get('success', 'HubtelPaymentController@success')->name('success');
            Route::get('cancel', 'HubtelPaymentController@cancel')->name('cancel');
        });

        // Maxicash Payment
        Route::group(['prefix' => 'maxicash', 'as' => 'maxicash.'], function () {
            Route::get('index', 'MaxiCashController@index')->name('index');
            Route::get('pay', 'MaxiCashController@payment')->name('payment');
            Route::any('callback/{payment_id}/{status}', 'MaxiCashController@callback')->name('callback')
            ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //Esewa Payment Gateway
        Route::group(['prefix' => 'esewa', 'as' => 'esewa.'], function () {
            Route::get('pay', 'EsewaPaymentController@payment')->name('payment');
            Route::get('verify/{payment_id}', 'EsewaPaymentController@verify')->name('verify');
        });

        // Swish Payment Gateway
        Route::group(['prefix' => 'swish', 'as' => 'swish.'], function () {
            Route::any('pay', 'SwishPaymentController@index')->name('payment');
            Route::post('make-payment', 'SwishPaymentController@makePayment')->name('make-payment')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
            Route::post('callback', 'SwishPaymentController@callback')->name('callback')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
            Route::post('m-callback', 'SwishPaymentController@swish_m_callback')->name('m-callback')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
            Route::get('check-payment', 'SwishPaymentController@check_payment')->name('check-payment');
        });

        //MTN MOMO
        Route::group(['prefix' => 'momo', 'as' => 'momo.'], function () {
            Route::any('callback', 'MomoPayController@callback')->name('callback')
            ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
            Route::any('make-payment', 'MomoPayController@makePayment')->name('make-payment');
            Route::any('pay', 'MomoPayController@payment')->name('payment');
        });

        //Pay Fast
        Route::group(['prefix' => 'payfast', 'as' => 'payfast.'], function () {
            Route::get('pay', 'PayFastController@payment')->name('payment');
            Route::any('callback', 'PayFastController@callback')->name('callback')
            ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //World Pay
        Route::group(['prefix' => 'worldpay', 'as' => 'worldpay.'], function () {
            Route::get('pay', 'WorldPayController@index')->name('pay');
            Route::post('payment', 'WorldPayController@payment')->name('payment');
            Route::get('jwt', 'WorldPayController@generate_jwt');
        });

        //Six Cash
        Route::group(['prefix' => 'sixcash', 'as' => 'sixcash.'], function () {
            Route::any('pay', 'SixcashPaymentController@payment')->name('pay');
            Route::any('callback', 'SixcashPaymentController@callback')->name('payment');
        });

        //PHONEPE
        Route::group(['prefix' => 'phonepe', 'as' => 'phonepe.'], function () {
            Route::any('pay', 'PhonepeController@payment')->name('pay');
            Route::any('callback', 'PhonepeController@callback')->name('callback');
            Route::any('redirect', 'PhonepeController@redirect')->name('redirect')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //Cash Free
        Route::group(['prefix' => 'cashfree', 'as' => 'cashfree.'], function () {
            Route::any('pay', 'CashFreePaymentController@payment')->name('pay');
            Route::any('callback', 'CashFreePaymentController@callback')->name('payment')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

        //Instamojo
        Route::group(['prefix' => 'instamojo', 'as' => 'instamojo.'], function () {
            Route::any('pay', 'InstamojoPaymentController@payment')->name('pay');
            Route::any('callback', 'InstamojoPaymentController@callback')->name('payment')
                ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
        });

    });
// }

Route::get('web-payment', 'Customer\PaymentController@web_payment_success')->name('web-payment-success');
Route::get('payment-success', 'Customer\PaymentController@success')->name('payment-success');
Route::get('payment-fail', 'Customer\PaymentController@fail')->name('payment-fail');

Route::get('/test', function (){
    return 0;
});

