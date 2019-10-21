<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyType extends Model
{
    use SoftDeletes;

    protected $table = 'company_type';
    public $timestamps = false;

    public function companies()
    {
        return $this->hasMany(
            'App\Model\Company',
            'company_type'
        );
    }
}
