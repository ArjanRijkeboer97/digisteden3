<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CityDomain extends Model
{
    use SoftDeletes;

    protected $table = 'city_domains';

    public function city()
    {
        return $this->belongsTo(
            'App\Model\City',
            'city_id'
        );
    }
}