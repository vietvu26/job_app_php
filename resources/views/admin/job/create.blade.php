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
    <!-- select category -->
    <div class="form-group">
        <label for="category">Category</label>
        <select name="category" id="category" class="form-control">
            <option value="">Select Category</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category')
        <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control">{{old('description')}}</textarea>
        @error('description')
        <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="location">Location</label>
        <input type="text" name="location" id="location" value="{{old('location')}}" class="form-control">
        @error('location')
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
        <label for="company">Company</label>
        <input type="text" name="company" id="company" value="{{old('company')}}" class="form-control">
        @error('company')
        <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{old('email')}}" class="form-control">
        @error('email')
        <div class="error-validate mt-3">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="number" name="phone" id="phone" value="{{old('phone')}}" class="form-control">
        @error('phone')
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