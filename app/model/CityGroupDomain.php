<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CityGroupDomain extends Model
{
    use SoftDeletes;

    protected $table = 'citygroup_domains';

    public function cityGroup()
    {
        return $this->belongsTo(
            'App\Model\CityGroup',
            'group_id'
        );
    }
}