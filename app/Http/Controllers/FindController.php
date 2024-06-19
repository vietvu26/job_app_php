<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\JobType;
use App\Models\Job;

class FindController extends Controller
{
    public function index(Request $request){
        $categories = Category::where('status',1)->get();
        $jobTypes = JobType::where('status',1)->get();

        $jobs = Job::where('status',1);
        $jobs = $jobs->paginate(6);


        return view('find',[
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'jobs' => $jobs,
            
        ]);
    }
    public function findjob(Request $request)
    {
        // Initialize query builder
        $query = Job::query();
    
        // Apply filters based on user input
        if ($request->filled('keywords')) {
            $query->where('title', 'like', '%' . $request->keywords . '%');
        }
    
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
    
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
    
        if ($request->filled('job_types')) {
            $query->whereIn('job_type_id', $request->job_types);
        }
    
        if ($request->filled('experience')) {
            if ($request->experience == '10+') {
                $query->where('experience', '>=', 10);
            } else {
                $query->where('experience', $request->experience);
            }
        }
    
        // Sorting logic based on 'sort' parameter
        if ($request->filled('sort')) {
            if ($request->sort == 'latest') {
                $query->latest(); // Sort by latest (created_at descending)
            } elseif ($request->sort == 'oldest') {
                $query->oldest(); // Sort by oldest (created_at ascending)
            }
        } else {
            // Default sorting if 'sort' parameter is not provided
            $query->latest(); // Default to latest
        }
    
        // Paginate the results
        $jobs = $query->paginate(9); // Adjust the number as per your pagination needs
    
        // Fetch all categories and job types
        $categories = Category::all();
        $jobTypes = JobType::all();
    
        // Return the view with jobs, categories, and job types
        return view('find', compact('jobs', 'categories', 'jobTypes'));
    }
    
   
}
