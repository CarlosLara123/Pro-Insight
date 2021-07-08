<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Provider
 */
class Provider extends Model
{
    protected $table = 'provider';

    protected $primaryKey = 'id_provider';

	public $timestamps = false;

    protected $fillable = [
        'name',
        'creation_date',
        'update_date',
    ];

    protected $guarded = [];

}