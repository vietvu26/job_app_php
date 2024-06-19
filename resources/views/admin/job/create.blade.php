@extends ('layouts.app')
@section('main')
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
<form action="{{ route('admin.job.store') }}" method="post" class="container mt-4 mb-4">
    @csrf
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="{{old('title')}}" class="form-control">
        @error('title')
        <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="category_id">Category</label>
        <select name="category_id" id="category_id" class="form-control">
            <option value="">Select Category</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
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
            <option value="{{ $jobType->id }}">{{ $jobType->name }}</option>
            @endforeach
        </select>
        @error('job_type_id')
        <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control">{{old('description')}}</textarea>
        @error('description')
        <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="benefits">Benefits</label>
        <textarea name="benefits" id="benefits" class="form-control">{{old('benefits')}}</textarea>
        @error('benefits')
        <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="salary">Salary</label>
        <input type="number" name="salary" id="salary" value="{{old('salary')}}" class="form-control">
        @error('salary')
        <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="experience">Experience require</label>
        <select name="experience" id="experience" class="form-control">
            <option value="">Select Experience</option>
            @for ($i = 1; $i <= 10; $i++) <option value="{{ $i }}">{{ $i }} Year{{ $i > 1 ? 's' : '' }}</option>
                @endfor
                <option value="10+">10+ Years</option>
        </select>
        @error('experience')
        <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="company_name">Company name</label>
        <input type="text" name="company_name" id="company_name" value="{{old('company_name')}}" class="form-control">
        @error('company_name')
        <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="company_location">Company location</label>
        <input type="text" name="company_location" id="company_location" value="{{old('company_location')}}"
            class="form-control">
        @error('company_location')
        <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group mt-4">
        <button type="submit" class="btn btn-primary">Create Job</button>
    </div>
</form>
@if (session('success'))
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    var toast = new bootstrap.Toast(document.querySelector('.toast'));
    toast.show();
});
</script>
@endif
@endsection