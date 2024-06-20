@extends('layouts.app')
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
<section class="section-1 py-5">
    <div class="container">
        <div class="card border-0 shadow p-5 card-profile">
            @if ($user->image == null)
                <div class="avt mx-auto">
                    <img src="{{asset('assets/images/avatar7.png') }}" alt="avatar" class="img-fluid">
                </div>
            @else
                <div class="avt mx-auto">
                    <img src="{{asset('profile_pic/' . $user->image) }}" alt="avatar" class="img-fluid">
                </div>
            @endif
            <div class="profile-detail">
                <h3 class="text-center">{{ $user->name }}</h3>
                <div class="profile-item">
                    <p class="fw-bold"><i class="fa fa-map-marker me-2"></i>Address:</p>
                    @if ($cv->address == null)
                        <p>Not Available</p>
                    @else
                        <p>{{ $cv->address }}</p>
                    @endif
                </div>
                <div class="profile-item">
                    <p class="fw-bold"><i class="fa fa-phone me-2"></i>Phone:</p>
                    @if ($user->phone == null)
                        <p>Not Available</p>
                    @else
                        <p>{{ $user->phone }}</p>
                    @endif
                </div>
                <div class="profile-item">
                    <p class="fw-bold"><i class="fa fa-envelope me-2"></i>Email:</p>
                    @if ($user->email == null)
                        <p>Not Available</p>
                    @else
                        <p>{{ $user->email }}</p>
                    @endif
                </div>
                <div class="profile-item">
                    <p class="fw-bold"><i class="fa fa-briefcase me-2"></i>Year of Experience:</p>
                    @if ($cv->experience == null)
                        <p>Not Available</p>
                    @else
                        <p>{{ $cv->experience }} Years</p>
                    @endif
                </div>
                <div class="profile-item">
                    <p class="fw-bold"><i class="fa fa-key me-2"></i>Keywords:</p>
                    @if ($cv->keywords == null)
                        <p>Not Available</p>
                    @else
                        <p>{{ $cv->keywords }}</p>
                    @endif
                </div>
            </div>
            @auth
                @if (@auth()->user()->role == 'admin')
                    <div class="apply-actions">
                        <form
                            action="{{ route('admin.job.review', ['id' => $user->id, 'application_id' => $jobApplication->id]) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-success me-2" name="status" value="accepted"
                                    {{ $jobApplication->status == 'accepted' ? 'disabled' : '' }}>Accept</button>
                                <button type="submit" class="btn btn-danger" name="status" value="rejected"
                                    {{ $jobApplication->status == 'rejected' ? 'disabled' : '' }}>Reject</button>
                            </div>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</section>
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