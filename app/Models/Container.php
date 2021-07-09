<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Container
 */
class Container extends Model
{
    protected $table = 'container';

    protected $primaryKey = 'idContainer';

	public $timestamps = false;

    protected $fillable = [
        'arrival_date',
        'destination',
        'quantityProducts',
        'creation_date',
        'update_date',
    ];

    protected $guarded = [];
}