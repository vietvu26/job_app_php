<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SavedJob;

class HomeController extends Controller
{
    //
    public function index()
    {
        $categories = Category::all();
        // get random jobs
        $jobs = Job::inRandomOrder()->limit(6)->get();
        $lastestJobs = Job::latest()->limit(6)->get();
        $countJobByCategory = Job::select('category_id')->selectRaw('count(*) as total')->groupBy('category_id')->get();
        return view('home', ['categories' => $categories, 'jobs' => $jobs, 'lastestJobs' => $lastestJobs, 'countJobByCategory' => $countJobByCategory]);
    }
    public function detail($id)
    {
        $job = Job::where([
            'id' => $id,
            'status' => 1,
        ])->with(['jobType', 'category'])->first();
        if ($job == null) {
            abort(404);
        }
        return view('user.account.job.jobDetail', ['job' => $job]);
    }

    public function applyJob(Request $request)
    {
        $id = $request->id;

        $job = Job::where('id', $id)->first();

        // If job not found in db
        if ($job == null) {
            $message = 'Job does not exist.';
            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }
        $jobApplicationCount = Application::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();

        if ($jobApplicationCount > 0) {
            $message = 'You already applied on this job.';
            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }
        $employer_id = $job->user_id;
        $application = new Application();
        $application->job_id = $id;
        $application->user_id = Auth::user()->id;
        $application->employer_id = $employer_id;
        $application->applied_date = now();
        $application->save();
        return redirect()->route('jobDetail', ['id' => $id])->with('success', 'Apply job successfully.');

    }
    public function savedJob(Request $request)
    {
        $id = $request->id;

        $job = Job::where('id', $id)->first();

        // If job not found in db
        if ($job == null) {
            $message = 'Job does not exist.';
            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }
        $count = SavedJob::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();

        if ($count > 0) {
            session()->flash('error', 'You already saved this job.');

            return response()->json([
                'status' => false,
            ]);
        }

        $savedJob = new SavedJob;
        $savedJob->job_id = $id;
        $savedJob->user_id = Auth::user()->id;
        $savedJob->save();
        return redirect()->route('jobDetail', ['id' => $id])->with('success', 'Save job successfully.');

    }


}