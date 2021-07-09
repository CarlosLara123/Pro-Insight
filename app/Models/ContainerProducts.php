<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ContainerProducts
 */

class ContainerProducts extends Model
{
    protected $table = 'container_products';

    protected $primaryKey = 'idContainerProducts';

	public $timestamps = false;

    protected $fillable = [
        'idContainer',
        'idProduct',
        'creation_date',
        'update_date'
    ];

    protected $guarded = [];

    public function product(){
        return $this->belongsTo('App\Models\Product','idProduct');
    }

    public function container(){
        return $this->belongsTo('App\Models\Container', 'idContainer');
    }
}
