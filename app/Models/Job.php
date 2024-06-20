<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $table = 'jobs';
    protected $fillable = [
        'title',
        'category_id',
        'job_type_id',
        'user_id',
        'salary',
        'description',
        'benefits',
        'experience',
        'company_location',
        'company_name',
        // 'user_id',
    ];
    protected $hidden = [
        '_token',
    ];
    public function jobType()
    {
        return $this->belongsTo(JobType::class, 'job_type_id');
    }
    public function category()
    {
        return $this->belongsTo(JobType::class, 'category_id');
    }
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

}