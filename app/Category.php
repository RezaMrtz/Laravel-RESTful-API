<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    /* Transformer Model */
    public  $transformer = CategoryTransformer::class;

    protected $dates = ['deleted_at'];

    protected $hidden = ['pivot'];

    protected $fillable = [
        'name',
        'description',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
