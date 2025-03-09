<?php

namespace Modules\Quiz\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionSet extends Model
{
    use HasFactory;
    // protected $connection = 'wordpress';
    protected $table = 'question_sets';
    // protected $primaryKey = 'ID';
    protected $fillable = ['user_id','name','category_topic_id','category_class_id','question_type','questions','total_questions','timeRemaining'];
    // protected $hidden = [];
    // public $timestamps = true;
    // const CREATED_AT ="created_at";
    // const UPDATED_AT ="updated_at";
}
