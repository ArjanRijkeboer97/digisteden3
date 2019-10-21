<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;

    protected $table = 'cities';
    protected $with = ['cityGroup'];

    public function cityGroup()
    {
        return $this->belongsTo(
            'App\Model\CityGroup',
            'group_id'
        );
    }
}
