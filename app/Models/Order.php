<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    protected $primaryKey = 'idOrder';

	public $timestamps = false;

    protected $fillable = [
        'idContainer',
        'idAirport',
        'creation_date',
        'update_date',
    ];

    protected $guarded = [];

    public function container(){
        return $this->belongsTo('App\Models\Container','idContainer');
    }

    public function airport(){
        return $this->belongsTo('App\Models\Airport', 'idAirport');
    }
}
