<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CityUser extends Model
{
    use SoftDeletes;
    protected $table = 'city_user';

    public $timestamps = false;

    protected $with = ['city'];

    public function city()
    {
        return $this->belongsTo(
            'App\Model\City',
            'city_id'
        );
    }

    public function user()
    {
        return $this->hasMany(
            'App\Model\User',
            'user_id'
        );
    }
}