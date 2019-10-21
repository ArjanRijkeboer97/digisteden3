<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Lecturize\Tags\Traits\HasTags;

class CompanyShadow extends Model
{
    use SoftDeletes;
    use Sluggable;
    use HasTags;


    protected $table = 'company_shadow';
    protected $with = ['type', 'subCategory'];
    public $timestamps = false;

    // koppelingen toevoegen aan company_shadow
    public function type()
    {
        return $this->belongsTo(
            'App\Model\CompanyType',
            'type_id'
        )
            ->withDefault(['name' => '<span class="text-danger font-weight-bold">[-- Geen Type --]</span>']);
    }

    public function subCategory()
    {
        return $this->belongsTo(
            'App\Model\CompanySubCategory',
            'subCategory_id'
        );
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
