<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CV extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'name', 'email', 'job_type_id', 'category_id', 'address', 'education', 'work_experience', 'experience', 'keywords'
    ];
    protected $table = 'cv';
}
