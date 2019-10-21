<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanySubCategory extends Model
{
    use SoftDeletes;

    protected $table = 'company_subcategories';
    protected $with = ['category'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'name'];

    public function category()
    {
        return $this->belongsTo(
            'App\Model\CompanyCategory',
            'category_id'
        )->withTrashed();
    }
}
