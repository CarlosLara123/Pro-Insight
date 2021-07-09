<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductProviders extends Model
{
    protected $table = 'product_providers';

    protected $primaryKey = 'idProductProviders';

	public $timestamps = false;

    protected $fillable = [
        'idProduct',
        'idProvider',
        'price',
        'creation_date',
        'update_date'
    ];

    protected $guarded = [];

    public function product(){
        return $this->belongsTo('App\Models\Product','idProduct');
    }

    public function provider(){
        return $this->belongsTo('App\Models\Provider', 'idProvider');
    }
}
