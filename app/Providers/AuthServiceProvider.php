<?php

namespace App\Providers;

use App\Buyer;
use App\Policies\BuyerPolicy;
use App\Policies\ProductPolicy;
use App\Policies\SellerPolicy;
use App\Policies\TransactionPolicy;
use App\Policies\UserPolicy;
use App\Product;
use App\Transaction;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Buyer::class => BuyerPolicy::class,
        Seller::class => SellerPolicy::class,
        User::class => UserPolicy::class,
        Transaction::class => TransactionPolicy::class,
        Product::class => ProductPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('admin-action', function($user) {
            return $user->isAdmin();
        });

        $this->registerPolicies();

        Passport::routes();
        Passport::loadKeysFrom('/storage');
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
        Passport::enableImplicitGrant();
        Passport::tokensCan([
            'purchased-product' => 'Create a new transaction for a specific product',
            'manage-product' => 'Create, read, update, and delete products (CRUD)',
            'manage-account' => 'Read your account data, id, name, email, if verified and if
            admin (cannot read password). Modify your account data (email and password).
            Cannot delete your account',
            'read-general' => 'Read general information like purchasing categories, purchased products,
                        selling products, selling categories, your transactions (purchased and sells)'
        ]);
    }
}
