<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SavedJob;

class HomeController extends Controller
{
    //
    public function index()
    {

        $jobs = Job::inRandomOrder()->limit(6)->get();
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->take(8)->get();

        $newCategories = Category::where('status', 1)->orderBy('name', 'ASC')->get();

        $featuredJobs = Job::where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->with('jobType')
            ->take(6)->get();

        $latestJobs = Job::where('status', 1)
            ->with('jobType')
            ->orderBy('created_at', 'DESC')
            ->take(6)->get();
        $countJobByCategory = Job::select('category_id')->selectRaw('count(*) as total')->groupBy('category_id')->get();
        return view('home', [
            'categories' => $categories,
            'jobs' => $jobs,
            'latestJobs' => $latestJobs,
            'newCategories' => $newCategories,
            'countJobByCategory' => $countJobByCategory,
        ]);
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
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!auth()->check()) {
            return redirect()->route('jobDetail', ['id' => $id])->with('error', 'You need to login first.');
        }
        if (auth()->user()->role == 'admin') {
            return redirect()->route('jobDetail', ['id' => $request->id])->with('error', 'Admin cannot apply for jobs.');
        }
       
        // Lấy thông tin người dùng hiện tại
        $user = Auth::user();

        // Kiểm tra xem người dùng đã cập nhật CV hay chưa
        if (!$user->cv_updated) {
            return redirect()->route('jobDetail', ['id' => $id])->with('error', 'You need to update your CV before applying for jobs.');
        }

        // Tiếp tục xử lý khi người dùng đã cập nhật CV


        $job = Job::where('id', $id)->first();

        // Nếu không tìm thấy công việc trong database
        if (!$job) {
            $message = 'Job does not exist.';
            session()->flash('error', $message);
            return redirect()->route('jobDetail', ['id' => $id])->with('error', $message);
        }

        // Kiểm tra xem người dùng đã apply công việc này chưa
        $jobApplicationCount = Application::where([
            'user_id' => $user->id,
            'job_id' => $id
        ])->count();

        if ($jobApplicationCount > 0) {
            $message = 'You have already applied for this job.';
            session()->flash('error', $message);
            return redirect()->route('jobDetail', ['id' => $id])->with('error', $message);
        }

        // Lưu thông tin application
        $employer_id = $job->user_id;
        $application = new Application();
        $application->job_id = $id;
        $application->user_id = $user->id;
        $application->employer_id = $employer_id;
        $application->applied_date = now();
        $application->save();

        return redirect()->route('jobDetail', ['id' => $id])->with('success', 'Job applied successfully.');
    }

    public function savedJob(Request $request)
    {
        $id = $request->id;
        if (!auth()->check()) {
            return redirect()->route('jobDetail', ['id' => $id])->with('error', 'You need to login first.');
        }
        

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
            return redirect()->route('jobDetail', ['id' => $id])->with('error', 'You already saved this job.');
        }

        $savedJob = new SavedJob;
        $savedJob->job_id = $id;
        $savedJob->user_id = Auth::user()->id;
        $savedJob->save();
        return redirect()->route('jobDetail', ['id' => $id])->with('success', 'Save job successfully.');

    }
    public function deleteapply($id)
    {
        $jobApplication = Application::findOrFail($id);
        $jobApplication->delete();

        return redirect()->route('account.myJobApplications')->with('success', 'Job application deleted successfully.');
    }
    public function deletesave($id)
    {
        $savejobs = SavedJob::findOrFail($id);
        $savejobs->delete();

        return redirect()->route('account.savejobs')->with('success', 'Job saved deleted successfully.');
    }







}