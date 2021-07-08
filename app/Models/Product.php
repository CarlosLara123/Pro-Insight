<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Provider
 */
class Product extends Model
{
    protected $table = 'Product';

    protected $primaryKey = 'id_product';

	public $timestamps = false;

    protected $fillable = [
        'name',
        'sku',
        'presentation',
        'volume',
        'unit',
        'photo',
        'creation_date',
        'update_date'
    ];

    protected $guarded = [];

}