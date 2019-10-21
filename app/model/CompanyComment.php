<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CompanyComment extends Model
{
    protected $table = 'company_comments';

    public function CompanyComments()
    {
        return $this->belongsTo('App\Model\Company', 'comment_id', 'id');
    }
}
