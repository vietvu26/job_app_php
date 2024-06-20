<!DOCTYPE html>
<html class="no-js" lang="en_AU">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>CareerVibe | Find Best Jobs</title>
    <meta name="description" content="" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />
    <meta name="HandheldFriendly" content="True" />
    <meta name="pinterest" content="nopin" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <!-- Fav Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="#" />
</head>

<body data-instant-intensity="mousedown">
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow py-3">
            <div class="container">
                <a class="navbar-brand" href="/">CareerVibe</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-0 ms-sm-0 me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/">Home</a>
                        </li>
                        @auth
                        <!-- @if (@auth()->user()->role == 'admin')
                                                                            <li class="nav-item">
                                                                                <a class="nav-link" aria-current="page" href="{{ route('admin.job.manage') }}">Find
                                                                                    Candidate</a>
                                                                            </li>
                                                                            @elseif (@auth()->user()->role == 'user')
                                                                            <li class="nav-item">
                                                                                <a class="nav-link" aria-current="page" href="jobs.html">Find Jobs</a>
                                                                            </li>
                                                                            @endif -->
                        <!-- Check if role is admin then show link Find Candidate else if role is user then show link Find Jobs   -->
                        @if (auth()->user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('admin.job.manage') }}">Manage
                                Jobs</a>
                        </li>
                        @elseif (auth()->user()->role == 'user')
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('find')}}">Find Jobs</a>
                        </li>
                        @endif

                        @endauth
                    </ul>
                    <!-- check if logged in them hide login button -->
                    @if (!Auth::check())
                    <a class="btn btn-outline-primary me-2" href="{{ route('login') }}" type="submit">Login</a>
                    @endif
                    @if (Auth::check())
                    <a class="btn btn-primary me-2" href="{{ route('account.profile') }}" type="submit">Account</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-primary" href="{{ route('logout') }}"
                            type="submit">Logout</button>
                    </form>
                    @endif
                </div>
            </div>
        </nav>
    </header>
    <main class="min-vh-100">
        @yield('main')
    </main>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('account.updateProfilePic') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary mx-3">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <footer class="bg-dark py-3 bg-2">
        <div class="container">
            <p class="text-center text-white pt-3 fw-bold fs-6">© 2023 xyz company, all right reserved</p>
        </div>
    </footer>
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
    <script src="{{ asset('assets/js/instantpages.5.1.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/lazyload.17.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    @yield('customJs')
</body>


</html>