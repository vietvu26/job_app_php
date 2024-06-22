<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Category;
use App\Models\JobType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\error;
use App\Models\CV;
use App\Models\Application;
use App\Models\SavedJob;

class AccountController extends Controller
{
    //
    public function index()
    {
        return view('account.profile');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    public function profile()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        return view('account.profile', [
            'user' => $user,
        ]);
    }
    public function updateProfile(Request $request)
{
    $id = Auth::user()->id;
    $user = User::where('id', $id)->first();

    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'designation' => 'nullable|string|max:255',
        'mobile' => 'nullable|string|max:20'
    ]);

    // Update the user with the validated data
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->designation = $request->input('designation');
    $user->mobile = $request->input('mobile');

    // Handle image upload if applicable
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $filename);
        $user->image = $filename;
    }

    $user->save();

    return redirect()->route('account.profile')->with('success', 'Profile updated successfully.');
}

public function updateProfilePic(Request $request)
{
    $id = Auth::user()->id;

    $validator = Validator::make($request->all(), [
        'image' => 'required|image'
    ]);

    if ($validator->passes()) {
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $imageName = $id . '-' . time() . '.' . $ext;
        $image->move(public_path('/profile_pic/'), $imageName);

        // Create a small thumbnail
        $sourcePath = public_path('/profile_pic/' . $imageName);
        $manager = new ImageManager(Driver::class);
        $image = $manager->read($sourcePath);

        // crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
        $image->cover(150, 150);
        $image->toPng()->save(public_path('/profile_pic/' . $imageName));

        // Delete Old Profile Pic
        File::delete(public_path('/profile_pic/' . Auth::user()->image));
        
        User::where('id', $id)->update(['image' => $imageName]);

        session()->flash('success', 'Profile picture updated successfully.');

        return redirect()->route('account.profile'); 
    } else {
        // Nếu không phải là ảnh, thêm thông báo lỗi và chuyển hướng trở lại
        session()->flash('error', 'The uploaded file must be an image.');
        return  redirect()->route('account.profile');
    }
}

    public function createcv()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $jobTypes = JobType::orderBy('name', 'ASC')->get();

        return view('user.account.job.create', [
            'categories' => $categories,
            'jobTypes' => $jobTypes,

        ]);
    }
    public function savecv(Request $request)
{
    // Validate input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'jobType' => 'required|integer|exists:job_types,id',
        'category' => 'required|integer|exists:categories,id',
        'address' => 'required|string|max:255',
        'education' => 'required|string',
        'work_experience' => 'nullable|string', // Make work_experience nullable since it's optional
        'experience' => 'required|string|max:255',
        'keywords' => 'required|string|max:255',
    ]);

    // Create or update CV details
    $user = auth()->user();

    // Check if the user already has a CV
    $cv = CV::where('user_id', $user->id)->first();

    if ($cv) {
        // Update existing CV
        $cv->update([
            'name' => $request->name,
            'email' => $request->email,
            'job_type_id' => $request->jobType,
            'category_id' => $request->category,
            'address' => $request->address,
            'education' => $request->education,
            'work_experience' => $request->work_experience,
            'experience' => $request->experience,
            'keywords' => $request->keywords,
        ]);
    } else {
        // Create new CV
        CV::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'job_type_id' => $request->jobType,
            'category_id' => $request->category,
            'address' => $request->address,
            'education' => $request->education,
            'work_experience' => $request->work_experience,
            'experience' => $request->experience,
            'keywords' => $request->keywords,
        ]);
    }

    // Update cv_updated field for the user
    $user->cv_updated = true;
    /** @var \App\Models\User $user */
    $user->save();

    return redirect()->back()->with('success', 'CV saved successfully!');
}
    public function myJobApplications(){
        $jobApplications = Application::where('user_id',Auth::user()->id)
                ->with(['job','job.jobType','job.applications'])
                ->orderBy('created_at','DESC')
                ->paginate(10);

        return view('user.account.job.my-job-apply',[
            'jobApplications' => $jobApplications
        ]);
    }
    public function savejobs(){
        $savejobs = SavedJob::where('user_id',Auth::user()->id)
                ->with(['job','job.jobType','job.applications'])
                ->orderBy('created_at','DESC')
                ->paginate(10);

        return view('user.account.job.save-job',[
            'savejobs' => $savejobs
        ]);
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