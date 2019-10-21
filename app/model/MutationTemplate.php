<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MutationTemplate extends Model
{
    use SoftDeletes;

    protected $table = 'mutation_mail_templates';
}
