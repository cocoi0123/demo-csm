<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product_type extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'product_types';
    protected $softDelete = true;
    protected $hidden = ['deleted_at'];


    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
