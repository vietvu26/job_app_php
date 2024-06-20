@extends('layouts.app')
@section('main')
<section class="section-0 lazy d-flex bg-image-style dark align-items-center " class=""
    data-bg="assets/images/banner5.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12 col-xl-8">
                <h1>Find your dream job</h1>
                <p>Thounsands of jobs available.</p>
                <div class="banner-btn mt-5"><a href="#" class="btn btn-primary mb-4 mb-sm-0">Explore Now</a></div>
            </div>
        </div>
    </div>
</section>
<style>
.job-description {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>

<section class="section-1 py-5 ">
    <div class="container">
        <div class="card border-0 shadow p-5">
            <form action="{{ route("findjob") }}">
                <div class="row">
                    <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                        <input type="text" class="form-control" name="keywords" id="keywords" placeholder="Keywords">
                    </div>
                    <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                        <input type="text" class="form-control" name="location" id="location" placeholder="Location">
                    </div>
                    <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                        <select name="category" id="category" class="form-control">
                            <option value="">Select a Category</option>
                            @if ($newCategories->isNotEmpty())
                                @foreach ($newCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class=" col-md-3 mb-xs-3 mb-sm-3 mb-lg-0">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-block">Search</button>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
</section>
<section class="section-2 bg-2 py-5">
    <div class="container">
        <h2>Popular Categories</h2>
        <div class="row pt-5">
            @foreach ($categories as $category)
                        <div class="col-lg-4 col-xl-3 col-md-6">
                            <div class="single_catagory">
                                @if (@auth()->user()->role == 'admin')
                                    <a href="{{ route('admin.job.manage', ['category' => $category->id]) }}">
                                        <h4 class="pb-2">{{ $category->name }}</h4>
                                    </a>
                                @else
                                    <a href="{{ route('findjob', ['category' => $category->id]) }}">
                                        <h4 class="pb-2">{{ $category->name }}</h4>
                                    </a>
                                @endif
                                @php
                                    $jobCount = 0;
                                    foreach ($countJobByCategory as $count) {
                                        if ($count->category_id == $category->id) {
                                            $jobCount = $count->total;
                                            break;
                                        }
                                    }
                                @endphp
                                <p class="mb-0"> <span>{{ $jobCount }}</span> Available position</p>
                            </div>
                        </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section-3  py-5">
    <div class="container">
        <h2>Featured Jobs</h2>
        <div class="row pt-5">
            <div class="job_listing_area">
                <div class="job_lists">
                    <div class="row">
                        @foreach ($jobs as $job)
                            <div class="col-md-4">
                                <div class="card border-0 p-3 shadow mb-4">
                                    <div class="card-body">
                                        <h3 class="border-0 fs-5 pb-2 mb-0">{{ $job->title }}</h3>
                                        <p class="job-description">{{ $job->description }}</p>
                                        <div class="bg-light p-3 border">
                                            <p class="mb-0 job-item">
                                                <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                <span class="ps-1 location">{{ $job->company_location }}</span>
                                            </p>
                                            <p class="mb-0">
                                                <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                <span class="ps-1">{{$job->jobType->name}}</span>
                                            </p>
                                            <p class="mb-0">
                                                <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                <span class="ps-1">{{ $job->salary }}</span>
                                            </p>
                                        </div>
                                        <div class="d-grid mt-3">
                                            @if (@auth()->user()->role == 'admin')
                                                <a href="{{ route('admin.job.edit',$job->id) }}"
                                                    class="btn btn-primary btn-lg">Manage</a>
                                            @else
                                                <a href="{{ route('jobDetail', $job->id) }}"
                                                    class="btn btn-primary btn-lg">Details</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-3 bg-2 py-5">
    <div class="container">
        <h2>Latest Jobs</h2>
        <div class="row pt-5">
            <div class="job_listing_area">
                <div class="job_lists">
                    <div class="row">
                        @foreach ($latestJobs as $lastestJob)
                            <div class="col-md-4">
                                <div class="card border-0 p-3 shadow mb-4">
                                    <div class="card-body">
                                        <h3 class="border-0 fs-5 pb-2 mb-0">{{ $lastestJob->title }}</h3>
                                        <p class="job-description">{{ $lastestJob->description }}</p>
                                        <div class="bg-light p-3 border">
                                            <p class="mb-0 job-item">
                                                <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                <span class="ps-1 location">{{ $lastestJob->company_location }}</span>
                                            </p>
                                            <p class="mb-0">
                                                <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                <span class="ps-1">{{$lastestJob->jobType->name}}</span>
                                            </p>
                                            <p class="mb-0">
                                                <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                <span class="ps-1">{{ $lastestJob->salary }}</span>
                                            </p>
                                        </div>
                                        <div class="d-grid mt-3">
                                            @if (@auth()->user()->role == 'admin')
                                                <a href="{{ route('admin.job.edit',$job->id) }}"
                                                    class="btn btn-primary btn-lg">Manage</a>
                                            @else
                                                <a href="{{ route('jobDetail', $lastestJob->id) }}"
                                                    class="btn btn-primary btn-lg">Details</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection