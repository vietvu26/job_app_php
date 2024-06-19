@extends ('layouts.app')
@section('main')
@if (session('success'))
<div class="success-message">
    <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif
@if (session('error'))
<div class="error-message">
    <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('error') }}
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif
<form action="{{ route('admin.job.update', $job->id) }}" method="post" class="container mt-4 mb-4">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="{{$job->title}}" class="form-control">
        @error('title')
        <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="category_id">Category</label>
        <select name="category_id" id="category_id" class="form-control">
            <option value="">Select Category</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ $category->id == $job->category_id ? 'selected' : '' }}>
                {{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id')
        <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <!-- select job type -->
    <div class="form-group">
        <label for="job_type_id">Job Type</label>
        <select name="job_type_id" id="job_type_id" class="form-control">
            <option value="">Select Job Type</option>
            @foreach($jobTypes as $jobType)
            <option value="{{ $jobType->id }}" {{ $jobType->id == $job->job_type_id ? 'selected' : '' }}>
                {{ $jobType->name }}</option>
            @endforeach
        </select>
        @error('job_type_id')
        <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control">{{ $job->description  }}</textarea>
        @error('description')
        <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="benefits">Benefits</label>
        <textarea name="benefits" id="benefits" class="form-control">{{ $job->benefits  }}</textarea>
        @error('benefits')
        <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="salary">Salary</label>
        <input type="number" name="salary" id="salary" value="{{$job->salary}}" class="form-control">
        @error('salary')
        <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="experience">Experience</label>
        <input type="text" name="experience" id="experience" value="{{$job->experience}}" class="form-control">
        @error('experience')
        <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="company_name">Company name</label>
        <input type="text" name="company_name" id="company_name" value="{{$job->company_name}}" class="form-control">
        @error('company_name')
        <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="company_location">Company location</label>
        <input type="text" name="company_location" id="company_location" value="{{$job->company_location}}"
            class="form-control">
        @error('company_location')
        <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">Update Job</button>
    </div>
</form>
@if (session('success'))
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    let toast = new bootstrap.Toast(document.querySelector('.success-message .toast'))
    toast.show();
});
</script>
@endif
@if (session('error'))
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    let toast = new bootstrap.Toast(document.querySelector('.error-message .toast'))
    toast.show();
});
</script>
@endif
@endsection