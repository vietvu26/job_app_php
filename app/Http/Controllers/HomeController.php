<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        $categories = Category::all();
        // get random jobs
        $jobs = Job::inRandomOrder()->limit(6)->get();
        $lastestJobs = Job::latest()->limit(6)->get();
        return view('front.home', ['categories' => $categories, 'jobs' => $jobs], ['lastestJobs' => $lastestJobs]);
    }
}