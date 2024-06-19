<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JobController extends Controller
{
    //
    public function create()
    {
        // list categories
        $categories = Category::all()->sortBy('name');
        $jobTypes = JobType::all()->sortBy('name');
        return view('admin.job.create', ['categories' => $categories, 'jobTypes' => $jobTypes]);
        // return view('front.admin.job.create', ['categories' => []]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'job_type_id' => 'required',
            'description' => 'required',
            'company_location' => 'required',
            'salary' => ['required', 'numeric', 'min:1'],
            'company_name' => 'required',
            'experience' => 'required',
        ]);
        Job::create($request->all());
        return redirect()->route('admin.job.create')->with('success', 'Job created successfully');
    }
    public function manage()
    {
        $jobs = Job::latest()->paginate(3);
        foreach ($jobs as $job) {
            $candidates = json_decode($job->candidates);
            // candidates is an array of user ids
            // $candidates = User::whereIn('id', $candidates)->get();
            if ($candidates) {
                $candidates = User::whereIn('id', $candidates)->get();
            } else {
                $candidates = [];
            }
            $job->candidates = $candidates;
        }
        return view('admin.job.manage', ['jobs' => $jobs]);
    }
    public function edit(Job $job)
    {
        $categories = Category::all()->sortBy('name');
        $jobTypes = JobType::all()->sortBy('name');
        return view('admin.job.edit', ['job' => $job, 'categories' => $categories, 'jobTypes' => $jobTypes]);
    }
    public function update(Request $request, Job $job)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'job_type_id' => 'required',
            'description' => 'required',
            'company_location' => 'required',
            'salary' => ['required', 'numeric', 'min:1'],
            'company_name' => 'required',
            'experience' => 'required',
        ]);
        if (
            $job->title == $request->title &&
            $job->category_id == $request->category_id &&
            $job->job_type_id == $request->job_type_id &&
            $job->description == $request->description &&
            $job->company_location == $request->company_location &&
            $job->salary == $request->salary &&
            $job->company_name == $request->company_name &&
            $job->experience == $request->experience
        ) {
            return redirect()->route('admin.job.edit', $job)->with('error', 'No changes made to update');
        }
        $job->update($request->all());
        return redirect()->route('admin.job.edit', $job)->with('success', 'Job updated successfully');
    }
    public function delete(Job $job)
    {
        $job->delete();
        return redirect()->route('admin.job.manage')->with('success', 'Job deleted successfully');
    }
}