<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    protected $table = 'airport';

    protected $primaryKey = 'idAirport';

	public $timestamps = false;

    protected $fillable = [
        'name',
        'ubication',
        'maritime',
        'creation_date',
        'update_date',
    ];

    protected $guarded = [];
}
