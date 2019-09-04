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
Route::resource('user', 'User\UserController', ['except' => ['create', 'edit']]);

/* Categories */
Route::resource('categories', 'Category\CategoriesController', ['except' => ['create', 'edit']]);

/* Buyers */
Route::resource('buyers', 'Buyer\BuyersController', ['except' => ['create', 'edit']]);

/* Product */
Route::resource('product', 'Product\ProductController', ['only' => ['index', 'show']]);

/* Transactions */
Route::resource('Transaction', 'Transaction\TransactionController', ['only' => ['index', 'show']]);

/* Sellers */
Route::resource('seller', 'Seller\SellerController', ['only' => ['index', 'show']]);
