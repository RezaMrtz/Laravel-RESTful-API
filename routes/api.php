<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Users */
Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);

/* Categories */
Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);

/* Buyers */
Route::resource('buyers', 'Buyer\BuyerController', ['except' => ['create', 'edit']]);

/* Product */
Route::resource('products', 'Product\ProductController', ['only' => ['index', 'show']]);

/* Transactions */
Route::resource('transactions', 'Transaction\TransactionController', ['only' => ['index', 'show']]);

/* Sellers */
Route::resource('sellers', 'Seller\SellerController', ['only' => ['index', 'show']]);


