@extends ('front.layouts.app')
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
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control">{{ $job->description  }}</textarea>
        @error('description')
            <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="location">Location</label>
        <input type="text" name="location" id="location" value="{{$job->location}}" class="form-control">
        @error('location')
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
        <label for="company">Company</label>
        <input type="text" name="company" id="company" value="{{$job->company}}" class="form-control">
        @error('company')
            <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{$job->email}}" class="form-control">
        @error('email')
            <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="number" name="phone" id="phone" value="{{$job->phone}}" class="form-control">
        @error('phone')
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