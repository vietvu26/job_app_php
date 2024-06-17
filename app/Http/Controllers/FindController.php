<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\JobType;
use App\Models\Job;

class FindController extends Controller
{
    public function index(){
        $categories = Category::orderBy('name', 'ASC')->get();
        $jobTypes = JobType::orderBy('name', 'ASC')->get();
        $jobs = Job::inRandomOrder()->limit(6)->get();

        return view('find',[
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'jobs' => $jobs
        ]);
    }
   
}
