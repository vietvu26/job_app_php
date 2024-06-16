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
        'category',
        'description',
        'location',
        'salary',
        'company',
        'email',
        'phone',
    ];
    protected $hidden = [
        '_token',
    ];
}