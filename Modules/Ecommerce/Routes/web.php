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

Route::name('ecommerce.')->prefix('ecommerce')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Start Admin Area
    |--------------------------------------------------------------------------
     */

    Route::namespace ('Admin')->prefix('admin')->name('admin.')->group(function () {
        Route::namespace ('Auth')->group(function () {
            Route::get('/', 'LoginController@showLoginForm')->name('login');
            Route::post('/', 'LoginController@login')->name('login');
            Route::get('logout', 'LoginController@logout')->name('logout');
            // Admin Password Reset
            Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
            Route::post('password/reset', 'ForgotPasswordController@sendResetLinkEmail');
            Route::post('password/verifycode', 'ForgotPasswordController@verifyCode')->name('password.verify.code');
            Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.change-link');
            Route::post('password/reset/change', 'ResetPasswordController@reset')->name('password.change');
        });

        Route::middleware('admin')->group(function () {
            Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
            Route::get('profile', 'AdminController@profile')->name('profile');
            Route::post('profile', 'AdminController@profileUpdate')->name('profile.update');
            Route::get('password', 'AdminController@password')->name('password');
            Route::post('password', 'AdminController@passwordUpdate')->name('password.update');

            // Customers
            Route::get('customers/', 'ManageUsersController@allUsers')->name('users.all');
            Route::get('customers/active', 'ManageUsersController@activeUsers')->name('users.active');
            Route::get('customers/banned', 'ManageUsersController@bannedUsers')->name('users.banned');
            Route::get('customers/email-verified', 'ManageUsersController@emailVerifiedUsers')->name('users.emailVerified');
            Route::get('customers/email-unverified', 'ManageUsersController@emailUnverifiedUsers')->name('users.emailUnverified');
            Route::get('customers/sms-unverified', 'ManageUsersController@smsUnverifiedUsers')->name('users.smsUnverified');
            Route::get('customers/sms-verified', 'ManageUsersController@smsVerifiedUsers')->name('users.smsVerified');
            Route::get('customers/{scope}/search', 'ManageUsersController@search')->name('users.search');
            Route::get('customer/detail/{id}', 'ManageUsersController@detail')->name('users.detail');
            Route::post('customer/update/{id}', 'ManageUsersController@update')->name('users.update');

            Route::get('customer/send_email/{id}', 'ManageUsersController@showEmailSingleForm')->name('users.email.single');
            Route::post('customer/send_email/{id}', 'ManageUsersController@sendEmailSingle')->name('users.email.single');
            Route::get('customer/transactions/{id}', 'ManageUsersController@transactions')->name('users.transactions');
            Route::get('customer/payments/{id}', 'ManageUsersController@deposits')->name('users.deposits');
            // Login History
            Route::get('customers/login/history/{id}', 'ManageUsersController@userLoginHistory')->name('users.login.history.single');
            Route::get('customers/login/history', 'ManageUsersController@loginHistory')->name('users.login.history');
            Route::get('customers/login/ipHistory/{ip}', 'ManageUsersController@loginIpHistory')->name('users.login.ipHistory');

            Route::get('customers/send_email', 'ManageUsersController@showEmailAllForm')->name('users.email.all');
            Route::post('customers/send_email', 'ManageUsersController@sendEmailAll')->name('users.email.send');

            //Category Setting
            Route::get('product/categories', 'CategoryController@index')->name('category.all');
            Route::get('product/categories/trashed', 'CategoryController@trashed')->name('category.trashed');
            Route::get('product/categories/trashed/search/', 'CategoryController@categoryTrashedSearch')->name('category.trashed.search');
            Route::post('product/category/create/{id}', 'CategoryController@store')->name('category-store')->where('id', '[0-9]+');
            Route::post('product/category/delete/{id}', 'CategoryController@delete')->name('category.delete')->where('id', '[0-9]+');

            //Brand
            Route::get('product/brands', 'BrandController@index')->name('brand.all');
            Route::post('product/brand/create/{id}', 'BrandController@store')->name('brand.store');
            Route::post('product/brand/{id}', 'BrandController@delete')->name('brand.delete')->where('id', '[0-9]+');

            Route::get('product/brands/search/', 'BrandController@brandSearch')->name('brand.search');
            Route::get('product/brands/trashed', 'BrandController@trashed')->name('brand.trashed');
            Route::get('product/brands/trashed/search/', 'BrandController@brandTrashedSearch')->name('brand.trashed.search');
            Route::post('product/brand/set-top/', 'BrandController@setTop')->name('brand.settop');

            //Product Attributes
            Route::get('attribute-types', 'ProductAttributeController@index')->name('attributes');
            Route::get('attribute/create', 'ProductAttributeController@create')->name('attributes.create');
            Route::post('attribute/create/{id}', 'ProductAttributeController@store')->name('attributes.store');
            Route::get('attribute/edit/{id}/', 'ProductAttributeController@edit')->name('attributes.edit');
            Route::post('attribute/{id}', 'ProductAttributeController@delete')->name('attributes.delete');

            //Manage Products
            Route::get('product/all', 'ProductController@index')->name('products.all');
            Route::get('product/create', 'ProductController@create')->name('products.create');
            Route::post('product/store/{id}', 'ProductController@store')->name('products.product-store');
            Route::get('product/edit/{id}/{slug}', 'ProductController@edit')->name('products.edit')->where('id', '[0-9]+');
            Route::post('product/delete/{id}', 'ProductController@delete')->name('products.delete')->where('id', '[0-9]+');
            Route::get('product/search/', 'ProductController@productSearch')->name('products.search');
            Route::get('product/trashed', 'ProductController@trashed')->name('products.trashed');
            Route::get('product/trashed/search', 'ProductController@productTrashedSearch')->name('products.trashed.search');
            Route::post('product-highlight', 'ProductController@highlight')->name('products.highlight');

            Route::get('product/reviews', 'ProductController@reviews')->name('product.reviews');
            Route::get('product/reviews/trashed', 'ProductController@trashedReviews')->name('product.reviews.trashed');
            Route::get('product/reviews/search/{key?}', 'ProductController@reviewSerach')->name('product.reviews.search');

            Route::post('product/reviews/{id}', 'ProductController@reviewDelete')->name('product.review.delete');

            Route::get('product/add-variant/{id}', 'ProductController@createAttribute')->name('products.attribute-add');
            Route::post('product/add-variant/{id}', 'ProductController@storeAttribute')->name('products.attribute-store');
            Route::get('product/edit-variant/{pid}/{aid}', 'ProductController@editAttribute')->name('products.attribute-edit');
            Route::post('product/edit-variant-update/{id}', 'ProductController@updateAttribute')->name('products.attribute-update');
            Route::post('product/delete-variant/{id}', 'ProductController@deleteAttribute')->name('products.attribute-delete');

            Route::get('product/add-variant-images/{id}', 'ProductController@addVariantImages')->name('products.add-variant-images');
            Route::post('product/add-variant-images/{id}', 'ProductController@saveVariantImages');

            //Stock
            Route::get('product/stock', 'ProductStockController@stock')->name('products.stock');
            Route::any('product/stock/create/{product_id}', 'ProductStockController@stockCreate')->name('products.stock.create');
            Route::post('product/add-to-stock/{product_id}', 'ProductStockController@stockAdd')->name('products.stock.add');
            Route::get('product/stock/{id}/', 'ProductStockController@stockLog')->name('products.stock.log');

            Route::get('product/stocks', 'ProductStockController@stocks')->name('products.stocks');
            Route::get('product/stocks/low', 'ProductStockController@stocksLow')->name('products.stocks.low');
            Route::get('product/stocks/empty', 'ProductStockController@stocksEmpty')->name('products.stocks.empty');

            //Coupons
            Route::get('promotion/coupons', 'CouponController@index')->name('coupon.index');
            Route::get('promotion/coupon/create', 'CouponController@create')->name('coupon.create');
            Route::get('promotion/coupon/edit/{id}', 'CouponController@edit')->name('coupon.edit');
            Route::post('promotion/coupon/save/{id}', 'CouponController@save')->name('coupon.store');
            Route::post('promotion/coupon/delete/{id}', 'CouponController@delete')->name('coupon.delete');
            Route::post('promotion/couponstatus', 'CouponController@changeStatus')->name('coupon.status');

            Route::get('products_for_coupon', 'CouponController@prordutsForCoupon')->name('products_for_coupon');

            //Offers
            Route::get('promotion/offers', 'OfferController@index')->name('offer.index');
            Route::get('promotion/offer/create', 'OfferController@create')->name('offer.create');
            Route::get('promotion/offer/edit/{id}', 'OfferController@edit')->name('offer.edit');
            Route::post('promotion/offer/save/{id}', 'OfferController@save')->name('offer.store');
            Route::post('promotion/offer/delete/{id}', 'OfferController@delete')->name('offer.delete');
            Route::get('products_for_offer', 'OfferController@prordutsForOffer')->name('products_for_offer');
            Route::post('promotion/offerstatus', 'OfferController@changeStatus')->name('offer.status');

            //Order
            Route::post('orders', 'OrderController@changeStatus')->name('order.status');
            Route::get('orders/', 'OrderController@ordered')->name('order.index');
            Route::get('orders/pending', 'OrderController@pending')->name('order.to_deliver');
            Route::get('orders/processing', 'OrderController@onProcessing')->name('order.on_processing');
            Route::get('orders/dipatched', 'OrderController@dispatched')->name('order.dispatched');
            Route::get('orders/delivered', 'OrderController@deliveredOrders')->name('order.delivered');
            Route::get('orders/canceled', 'OrderController@canceledOrders')->name('order.canceled');
            Route::get('orders/cod', 'OrderController@codOrders')->name('order.cod');
            Route::post('orders/send_cancelation_alert/{id}', 'OrderController@orderSendCancalationAlert')->name('order.send_cancelation_alert');
            Route::get('order/details/{id}', 'OrderController@orderDetails')->name('order.details');

            // Report
            Route::get('report/transaction', 'ReportController@transaction')->name('report.transaction');
            Route::get('report/transaction/search', 'ReportController@transactionSearch')->name('report.transaction.search');
            Route::get('report/user_transaction/{id}/search', 'ReportController@userTransactionSearch')->name('report.transaction.user_search');

            Route::get('report/order/', 'ReportController@order')->name('report.order');
            Route::get('report/order/search', 'ReportController@orderSearch')->name('report.order.search');
            Route::get('report/user_order/{id}', 'ReportController@orderByUser')->name('report.order.user');
            Route::get('report/user_order/{id}/search', 'ReportController@userOrderSearch')->name('report.order.user_search');

            Route::name('frontend.')->prefix('store-front')->group(function () {
                Route::get('templates', 'FrontendController@templates')->name('templates');
                Route::post('templates', 'FrontendController@templatesActive')->name('templates.active');

                Route::get('manage-contents/{key}', 'FrontendController@frontendSections')->name('sections');
                Route::post('manage-contents/frontend-content/{key}', 'FrontendController@frontendContent')->name('sections.content');
                Route::get('manage-contents/frontend-element/{key}/{id?}', 'FrontendController@frontendElement')->name('sections.element');
                Route::post('remove', 'FrontendController@remove')->name('remove');

            });
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Start User Area
    |--------------------------------------------------------------------------
     */

    Route::name('user.')->prefix('user')->group(function () {
        Route::middleware('auth')->group(function () {

            Route::middleware(['checkStatus'])->group(function () {

                // Deposit
                Route::any('/payment', 'Gateway\PaymentController@deposit')->name('deposit');
                Route::post('payment/insert', 'Gateway\PaymentController@depositInsert')->name('deposit.insert');
                Route::get('payment/preview', 'Gateway\PaymentController@depositPreview')->name('deposit.preview');
                Route::get('payment/confirm', 'Gateway\PaymentController@depositConfirm')->name('deposit.confirm');
                Route::get('payment/manual', 'Gateway\PaymentController@manualDepositConfirm')->name('deposit.manual.confirm');
                Route::post('payment/manual', 'Gateway\PaymentController@manualDepositUpdate')->name('deposit.manual.update');
                Route::get('payment/history', 'UserController@depositHistory')->name('deposit.history');

                Route::get('checkout/', 'CartController@checkout')->name('checkout');
                Route::post('/checkout/{type}', 'OrderController@confirmOrder')->name('checkout-to-payment');

                //Order
                Route::get('orders/{type}', 'OrderController@orders')->name('orders');
                Route::get('order/{order_number}', 'OrderController@orderDetails')->name('order');
                Route::get('product_review', 'UserController@productsReview')->name('product.to_review');
                Route::post('product_review/add', 'UserController@addReview')->name('product.review');

            });
        });
    });

    Route::middleware('auth')->group(function () {
        Route::get('/index', 'SiteController@index')->name('home');

        Route::get('print/{order}', 'SiteController@printInvoice')->name('print.invoice');

        Route::get('/contact', 'SiteController@contact')->name('contact');
        Route::get('/about', 'SiteController@aboutUs')->name('about_us');
        Route::post('/contact', 'SiteController@contactSubmit')->name('contact.send');
        Route::get('/change/{lang?}', 'SiteController@changeLanguage')->name('lang');

        Route::get('products', 'SiteController@products')->name('products');
        Route::get('products/filter', 'SiteController@products')->name('products.filter');
        Route::get('product/details/{id}/{order_id?}', 'SiteController@productDetails')->name('product.details');
        Route::get('product/detail/{id}/{slug}/', 'SiteController@productDetails')->name('product.detail');

        Route::get('product/get-stock-by-variant/', 'SiteController@getStockByVariant')->name('product.get-stock-by-variant');
        Route::get('product/get-image-by-variant/', 'SiteController@getImageByVariant')->name('product.get-image-by-variant');

        Route::get('/products/search/', 'SiteController@productSearch')->name('product.search');
        Route::get('/products/search/{perpage?}', 'SiteController@productSearch')->name('product.search.filter');

        Route::get('product/load_review', 'SiteController@loadMore')->name('product_review.load_more');

        Route::get('category/{id}/{slug}', 'SiteController@productsByCategory')->name('products.category');
        Route::get('category/filter/{id}/{slug}', 'SiteController@productsByCategory')->name('category.filter')->where('id', '[0-9]+');
        Route::get('categories', 'SiteController@categories')->name('categories');

        Route::get('brands', 'SiteController@brands')->name('brands');
        Route::get('brands/{id}/{slug}', 'SiteController@productsByBrand')->name('products.brand')->where('id', '[0-9]+');
        Route::get('brands/filter/{id}/{slug}', 'SiteController@productsByBrand')->name('brands.filter')->where('id', '[0-9]+');

        Route::get('track_order', 'SiteController@trackOrder')->name('orderTrack');
        Route::post('track_order', 'SiteController@getOrderTrackData')->name('order-track');

        //Pages
        Route::get('faqs/', 'SiteController@faqs')->name('faqs');

        Route::get('/{id}/{slug}', 'SiteController@page')->name('pages');
        Route::get('terms-conditions/', 'SiteController@termsConditions')->name('terms-conditions');
        Route::get('returns-exchanges/', 'SiteController@returnsExchanges')->name('returns-exchanges');
        Route::get('shipping-delivery/', 'SiteController@shippingDelivery')->name('shipping-delivery');
        Route::get('quick-view/', 'SiteController@quickView')->name('quick-view');

        Route::get('placeholder/image/{size}', 'SiteController@placeholderImage')->name('placeholder.image');

        //Compare
        Route::get('add_to_compare/', 'SiteController@addTocompare')->name('add-to-compare');
        Route::get('get-compare-data/', 'SiteController@getCompare')->name('get-compare-data');
        Route::get('compare/', 'SiteController@compare')->name('compare');
        Route::post('remove_from_compare/{id}', 'SiteController@removeFromcompare')->name('del-from-compare');

        //Subscription

        Route::post('/subscribe', 'SiteController@addSubscriber')->name('subscribe');

        //Cart\
        Route::post('add_to_cart/', 'CartController@addToCart')->name('add-to-cart');
        Route::get('get_cart/', 'CartController@getCart')->name('get-cart-data');
        Route::get('get_cart-total/', 'CartController@getCartTotal')->name('get-cart-total');

        Route::get('mycart/', 'CartController@shoppingCart')->name('shopping-cart');

        Route::post('apply_coupon/', 'CouponController@applyCoupon')->name('applyCoupon');
        Route::post('remove_coupon/', 'CouponController@removeCoupon')->name('removeCoupon');
        Route::post('remove_cart_item/{id}', 'CartController@removeCartItem')->name('remove-cart-item');

        Route::post('update_cart_item/{id}', 'CartController@updateCartItem')->name('update-cart-item');

        //Wishlist
        Route::get('add_to_wishlist/', 'WishlistController@addToWishList')->name('add-to-wishlist');
        Route::get('get_wishlist_data/', 'WishlistController@getWsihList')->name('get-wishlist-data');

        Route::get('get_wishlist_total/', 'WishlistController@getWsihListTotal')->name('get-wishlist-total');

        Route::get('wishlist/', 'WishlistController@wishList')->name('wishlist');
        Route::get('wishlist/remove/{id}', 'WishlistController@removeFromwishList')->name('removeFromWishlist')->where('id', '[0-9]+');;

        //Compare
        Route::get('add_to_compare/', 'SiteController@addTocompare')->name('addToCompare');
        Route::get('get_compare_data/', 'SiteController@getCompare')->name('get-compare-data');
        Route::get('compare/', 'SiteController@compare')->name('compare');
        Route::post('remove_from_compare/{id}', 'SiteController@removeFromcompare')->name('del-from-compare');
    });
});
