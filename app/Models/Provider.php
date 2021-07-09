<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Provider
 */
class Provider extends Model
{
    protected $table = 'provider';

    protected $primaryKey = 'idProvider';

	public $timestamps = false;

    protected $fillable = [
        'name',
        'creation_date',
        'update_date',
    ];

    protected $guarded = [];

}