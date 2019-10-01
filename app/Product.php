<?php

namespace App;

use App\Seller;
use App\Category;
use App\Transaction;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    const AVAILABLE_PRODUCT = 'available';
    const UNAVAILABLE_PRODUCT = 'unavailable';

    /* Transformer Model */
    public  $transformer = ProductTransformer::class;

    protected $dates = ['deleted_at'];

    protected $hidden = ['pivot'];

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id'
    ];

    /* Available or NOT */
    public function isAvailable()
    {
        $this->status == Product::AVAILABLE_PRODUCT;
    }

    /* Relations */
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,);
    }
}
