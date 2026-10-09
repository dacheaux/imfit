<?php


//Generisemo svim korisnicima qr-code
Route::get('generate-qrcode', 'QrcodeController@generateQrCode');
Route::get('generate-accounts', 'AccountController@generateAccount');



Route::get('/', 'HomeController@index')->name('home');
Route::get('/o-nama', 'HomeController@about')->name('about');
Route::get('/galerija', 'HomeController@gallery')->name('gallery');


// Qr Code
Route::resource('/qrcode', 'QrcodeController',  ['only' => ['index']]);

// Profil
Route::resource('/profil', 'ProfileController',  ['only' => ['index', 'update']]);

// Moji Termini
Route::get('/termini', 'UserTermsController@index');

Route::post('/odlozi-termin', ['as' => 'frontterms.delayed', 'uses' => 'UserTermsController@delayedTerm']);

// Moj racun
Route::get('/racun', 'AccountController@index');
Route::get('/poruceni-planovi', 'AccountUserPlansController@index');


// Moji Clanarina

Route::post('updatePauseOn/{id}', [ 'as'=>'userplans.setpauseon', 'uses' => 'UserPlansController@updatePauseOn']);
Route::post('updatePauseOff/{id}', [ 'as'=>'userplans.setpauseoff', 'uses' => 'UserPlansController@updatePauseOff']);
Route::get('/extra/{planId}', 'UserPlansController@getExtraPlan');

Route::get('/clanarina', 'UserPlansController@index');
Route::post('/poruci-paket', 'UserPlansController@store');
Route::post('/aktiviraj-paket', 'UserPlansController@activatePlan');
Route::post('/pauziraj-paket', 'UserPlansController@pausePlan');

Route::post('/poruci-plan-racun', 'AccountUserPlansController@store');

// Termini
Route::get('/zakazi-trening', 'TermsController@index');
// Terms data
Route::get('dataTerms' ,['as' => 'frontterms.data', 'uses' => 'TermsController@dataTerms']);
Route::post('bookingTerms' ,['as' => 'frontterms.booking', 'uses' => 'TermsController@bookingTerms']);

// Blog
Route::get('/treninzi', 'PostsController@index');
Route::get('/treninzi/pretraga', 'PostsController@searchByTermPaginated');
Route::get('/treninzi/{slug}', 'PostsController@show');
Route::get('/treninzi/tag/{slug}', 'PostsController@getByTag');
// Komentari
Route::post('/treninzi/komentar/{id}', 'PostsController@postComment');
Route::post('/treninzi/komentar/{id}/odgovor/{comid}', 'PostsController@postReply');
// Kontakt
Route::get('/kontakt', 'HomeController@contact')->name('contact');
Route::post('kontakt', 'ContactController@store');
// Shop
Route::get('/shop', 'ShopController@index');
Route::post('/shop/order' ,['as' => 'shop.order', 'uses' => 'ShopController@order']);
Route::get('/placanja', 'ShopController@payments');

//Single slika
Route::get('/slika/{id}/{title}', 'HomeController@singlePciture');

// Admin Panel
Route::group(['prefix' => 'aptreneri', 'middleware' => ['role:trener', 'auth'], 'as' => 'aptreneri.' ], function() {
    // Dashboard
    Route::get('/', 'Aptreneri\AdminController@index');
    // Entrances
    Route::resource('entrances', 'Aptreneri\EntryController',  ['only' => ['index']]);
    // Terms
    Route::resource('terms', 'Aptreneri\TermsController',  ['only' => ['index', 'show']]);

    Route::resource('users', 'Admin\UsersController', ['except' => ['show']]);
    Route::post('users/{id}/qrcode', ['as' => 'users.qrcode.store', 'uses' => 'Admin\UsersController@storeQrcode']);

    // Ajax Data Terms
    Route::get('dataTerms' ,['as' => 'terms.data', 'uses' => 'Aptreneri\TermsController@dataTerms']);
    Route::get('entryData',['as' => 'entrances.data', 'uses' => 'Aptreneri\EntryController@entryData']);
    Route::get('usersData',['as' => 'users.data', 'uses' => 'Admin\UsersController@usersData']);
});

// Admin Panel
Route::group(['prefix' => 'admin', 'middleware' => ['role:admin', 'auth'], 'as' => 'admin.' ], function() {
    // Dashboard
    Route::get('/', 'Admin\AdminController@index');
    Route::post('door', ['as' => 'post.doors', 'uses' => 'Admin\AdminController@openTheDoor']);

    // User Plans
    Route::resource('userplans', 'Admin\UserPlansController',  ['except' => ['show']]);
    // Plans
    Route::resource('plans', 'Admin\PlansController',  ['except' => ['show']]);
    // Accounts
    Route::resource('accounts', 'Admin\AccountController',  ['except' => ['show']]);
    // AccountPlans
    Route::resource('accountplans', 'Admin\AccountPlansController',  ['except' => ['show']]);
    // AccountPlansUser Plans
    Route::resource('accountuserplans', 'Admin\AccountUserPlansController',  ['except' => ['show', 'edit']]);

    //CATEGORIES
    Route::get('categories/', 'Admin\CategoriesController@index')->name('categories.index');
    Route::post('categories/save-nested-categories', 'Admin\CategoriesController@saveNestedCategories')->name('categories.save-nested-categories');
    Route::get('categories/create', 'Admin\CategoriesController@create')->name('categories.create');
    Route::post('categories/save', 'Admin\CategoriesController@store')->name('categories.store');
    Route::get('categories/edit/{id}', 'Admin\CategoriesController@edit')->name('categories.edit');
    Route::get('categories/remove/{id}', 'Admin\CategoriesController@remove')->name('categories.remove');

    // PRODUCTS
    Route::resource('products', 'Admin\ProductsController',  ['except' => ['show']]);
    Route::delete('/image-product', 'Admin\ProductsController@imageDelete');
    Route::put('updatevisible/{id}', 'Admin\ProductsController@updatevisible');
    Route::get('productsData','Admin\ProductsController@productsData')->name('products.data');
    Route::post('reorderProductsData','Admin\ProductsController@reorderData')->name('products.order');

    //ORDERS
    Route::resource('orders', 'Admin\OrdersController');
    Route::get('ordersData', 'Admin\OrdersController@OrdersData')->name('ordersData');
    Route::put('ordersStatus/{id}', 'Admin\OrdersController@update')->name('ordersStatus');


    // Workouts
    Route::resource('workouts', 'Admin\WorkoutsController',  ['except' => ['show']]);
    //Coaches
    Route::resource('coaches', 'Admin\CoachesController',  ['only' => ['index']]);
    // Ajax Data Coaches
    Route::get('dataCoaches' ,['as' => 'coaches.data', 'uses' => 'Admin\CoachesController@dataCoaches']);

    Route::get('terms/get-term-patterns',['as' => 'terms.getTermPatterns', 'uses' =>  'Admin\TermsController@getTermPatterns']);
    Route::post('terms/apply-term-patterns',['as' => 'terms.applyTermPatterns', 'uses' =>  'Admin\TermsController@applyTermPatterns']);

    Route::resource('termpatterns', 'Admin\TermpatternController');
    // Terms
    Route::resource('terms', 'Admin\TermsController');

    // Entrances
    Route::resource('entrances', 'Admin\EntryController',  ['only' => ['index', 'destroy']]);

    Route::post('terms/delayeduser/{id}', 'Admin\TermsController@delayeduser');
    // Ajax Data Terms
    Route::get('dataTerms' ,['as' => 'terms.data', 'uses' => 'Admin\TermsController@dataTerms']);

    // Global config
    Route::resource('globalconf', 'Admin\GlobalConfController', ['only' => ['index', 'update']]);
    // Contacts
    Route::resource('contacts', 'Admin\ContactController', ['only' => ['index', 'update', 'destroy']]);
    // Posts
    Route::resource('posts', 'Admin\PostsController',  ['except' => ['show']]);
    // Tags
    Route::resource('tags', 'Admin\TagsController',  ['except' => ['show']]);
    // Gallery photos
    Route::resource('photos', 'Admin\PhotosController',  ['except' => ['show']]);
    // Edit ajax photo
    Route::get('photos/edit',['as'=>'photos.editphoto', 'uses'=> 'Admin\PhotosController@editPhoto']);
    // Delete ajax photo
    Route::delete('photos',['as'=>'photos.deletephoto', 'uses'=> 'Admin\PhotosController@destroyPhoto']);

    // Image delete
    Route::delete('/image-post', 'Admin\PostsController@imageDelete');
    Route::delete('/image-photos', 'Admin\PhotosController@imageDelete');

    // Users and Profile
    Route::resource('users', 'Admin\UsersController', ['except' => ['show']]);
    Route::post('users/{id}/qrcode', ['as' => 'users.qrcode.store', 'uses' => 'Admin\UsersController@storeQrcode']);
    Route::get('profile', ['as' => 'users.profile', 'uses' => 'Admin\UsersController@profile']);
    //Route::put('profile',['as' => 'users.uprofile', 'uses' => 'Admin\UsersController@updateProfile']);

    // Update UserPlans
    Route::put('updatePlan/{id}', 'Admin\UserPlansController@updatePlan');
    Route::put('updateAccountPlan/{id}', 'Admin\AccountUserPlansController@updateAccountPlan');
    Route::post('updatePauseOn/{id}', [ 'as'=>'userplans.setpauseon', 'uses' => 'Admin\UserPlansController@updatePauseOn']);
    Route::post('updatePauseOff/{id}', [ 'as'=>'userplans.setpauseoff', 'uses' => 'Admin\UserPlansController@updatePauseOff']);
    // Update Active
    Route::put('updateactive/{id}', 'Admin\PostsController@updateactive');
    Route::put('updateplans/{id}', 'Admin\PlansController@updateSeen');
    Route::put('updateaccountplans/{id}', 'Admin\AccountPlansController@updateActive');

    // DataTables data
    Route::get('usersData',['as' => 'users.data', 'uses' => 'Admin\UsersController@usersData']);
    Route::get('contactsData',['as' => 'contacts.data', 'uses' => 'Admin\ContactController@contactsData']);
    Route::get('postsData',['as' => 'posts.data', 'uses' => 'Admin\PostsController@postsData']);
    Route::get('workoutsData',['as' => 'workouts.data', 'uses' => 'Admin\WorkoutsController@workoutsData']);
    Route::get('plansData',['as' => 'plans.data', 'uses' => 'Admin\PlansController@plansData']);
    Route::get('accountuserplansData',['as' => 'accountuserplans.data', 'uses' => 'Admin\AccountUserPlansController@accountuserplansData']);
    Route::get('accountsData',['as' => 'accounts.data', 'uses' => 'Admin\AccountController@accountsData']);
    Route::get('accountplansData',['as' => 'accountplans.data', 'uses' => 'Admin\AccountPlansController@accountplansData']);
    Route::get('userplansData',['as' => 'userplans.data', 'uses' => 'Admin\UserPlansController@userplansData']);
    Route::get('tagsData',['as' => 'tags.data', 'uses' => 'Admin\TagsController@tagsData']);
    Route::get('photosData',['as' => 'photos.data', 'uses' => 'Admin\PhotosController@photosData']);
    Route::post('reorderData',['as' => 'photos.order', 'uses' => 'Admin\PhotosController@reorderData']);
    Route::get('entryData',['as' => 'entrances.data', 'uses' => 'Admin\EntryController@entryData']);

    Route::get('termpatternsData',['as' => 'termpatterns.data', 'uses' => 'Admin\TermpatternController@termpatternsData']);

    // Ajax requests
    Route::get('posts_tags', ['as'=>'posts.tags', 'uses'=>'Admin\PostsController@searchTags']);
    Route::get('get_tags', ['as'=>'posts.gettags', 'uses'=>'Admin\PostsController@getTags']);
});

//Tinymce Image upload
Route::get('route/used/for/image/upload', function() {
    return view('admin._image-dialog');
});
Route::post('/image/upload', [
    'as' => 'image.upload',
    'uses' => 'Admin\ControllerCustom@imageUpload'
]);
Auth::routes();
