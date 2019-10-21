<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CityGroup extends Model
{
    use SoftDeletes;

    protected $table = 'citygroups';

    public function cities() {
        return $this->hasMany(
            'App\Model\City',
            'group_id'
        );
    }
}
