<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JobController extends Controller
{
    //
    public function create()
    {
        // list categories
        $categories = Category::all();
        return view('admin.job.create', ['categories' => $categories]);
        // return view('front.admin.job.create', ['categories' => []]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'description' => 'required',
            'location' => 'required',
            'salary' => ['required', 'numeric', 'min:1'],
            'company' => 'required',
            'email' => ['required', 'email'],
            'phone' => ['required', 'numeric', 'digits:10'],
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
        return view('admin.job.edit', ['job' => $job]);
    }
    public function update(Request $request, Job $job)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'salary' => ['required', 'numeric', 'min:1'],
            'company' => 'required',
            'email' => ['required', 'email'],
            'phone' => ['required', 'numeric', 'digits:10'],
        ]);
        if ($job->title == $request->title && $job->description == $request->description && $job->location == $request->location && $job->salary == $request->salary && $job->company == $request->company && $job->email == $request->email && $job->phone == $request->phone) {
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