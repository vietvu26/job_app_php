@extends('layouts.app')

@section('main')
@php
    $user = Auth::user();
@endphp
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('account.sidebar')
            </div>
            <div class="col-lg-9">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <form action="{{ route('account.saveCV') }}" method="POST" id="createCVForm" name="createCVForm">
                    @csrf
                    <div class="card border-0 shadow mb-4">
                        <div class="card-body card-form p-4">
                            <h3 class="fs-4 mb-1">CV Details</h3>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="name" class="mb-2">Name<span class="req">*</span></label>
                                    <input type="text" placeholder="Name" id="name" name="name" class="form-control">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="email" class="mb-2">Email<span class="req">*</span></label>
                                    <input type="text" placeholder="Email" id="email" name="email" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="jobType" class="mb-2">Job Nature<span class="req">*</span></label>
                                    <select name="jobType" id="jobType" class="form-select">
                                        <option value="">Select Job Type</option>
                                        @if ($jobTypes->isNotEmpty())
                                            @foreach ($jobTypes as $jobType)
                                                <option value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="category" class="mb-2">Category<span class="req">*</span></label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Select a Category</option>
                                        @if($categories->isNotEmpty())
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="address" class="mb-2">Address<span class="req">*</span></label>
                                    <input type="text" placeholder="Address" id="address" name="address"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="education" class="mb-2">Education<span class="req">*</span></label>
                                <textarea class="form-control" name="education" id="education" cols="5" rows="5"
                                    placeholder="Description"></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="work_experience" class="mb-2">Work experience</label>
                                <textarea class="form-control" name="work_experience" id="work_experience" cols="5"
                                    rows="5" placeholder="Description"></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="experience" class="mb-2">Experience <span class="req">*</span></label>
                                <select name="experience" id="experience" class="form-control">
                                    <option value="1">1 Year</option>
                                    <option value="2">2 Years</option>
                                    <option value="3">3 Years</option>
                                    <option value="4">4 Years</option>
                                    <option value="5">5 Years</option>
                                    <option value="6">6 Years</option>
                                    <option value="7">7 Years</option>
                                    <option value="8">8 Years</option>
                                    <option value="9">9 Years</option>
                                    <option value="10">10 Years</option>
                                    <option value="10_plus">10+ Years</option>
                                </select>
                                <p></p>
                            </div>

                            <div class="mb-4">
                                <label for="keywords" class="mb-2">Keywords<span class="req">*</span></label>
                                <input type="text" placeholder="keywords" id="keywords" name="keywords"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="card-footer p-4">
                            <button type="submit" class="btn btn-primary">Save CV</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection