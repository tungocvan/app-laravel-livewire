<?php

namespace Modules\Quiz\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'category_class_id', 'category_topic_id','question_type','question_level','question_details'];
    // protected $connection = 'wordpress';
    // protected $table = 'wp_users';
    // protected $primaryKey = 'ID';
    // protected $fillable = [];
    // protected $hidden = [];
    // public $timestamps = true;
    // const CREATED_AT ="created_at";
    // const UPDATED_AT ="updated_at";
}
