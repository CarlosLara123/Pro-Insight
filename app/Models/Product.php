<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 */
class Product extends Model
{
    protected $table = 'product';

    protected $primaryKey = 'idProduct';

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