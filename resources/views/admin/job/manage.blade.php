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
<div class="container mt-4 h-100 manage-job">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('admin.job.create') }}" class="btn btn-primary">Create Job</a>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th class="fw-bold">Title</th>
                        <th class="fw-bold">Description</th>
                        <th class="fw-bold">Location</th>
                        <th class="fw-bold">Salary</th>
                        <th class="fw-bold">Company</th>
                        <th class="fw-bold">Candidates</th>
                        <th class="fw-bold">Status</th>
                        <th class="fw-bold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($jobs->isNotEmpty())
                        @foreach($jobs as $job)
                            <tr>
                                <td>{{ $job->title }}</td>
                                <td>
                                    <p class="truncate-text">{!! nl2br(e($job->description)) !!}</p>
                                </td>
                                <td>{{ $job->company_location }}</td>
                                <td>{{ number_format($job->salary, 0, '.', '.') }}</td>
                                <td>{{ $job->company_name }}</td>
                                <td>
                                    @if ($job->candidates->count() == 0)
                                        <span>No candidates</span>
                                    @else
                                        @foreach ($job->candidates as $candidate)
                                            <a href="{{ route('profile', ['user_id' => $candidate->id, 'id' => $job->id]) }}"
                                                class="candidate-profile">{{$candidate->name}}</a>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if ($job->status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="btn-action">
                                    <a href="{{ route('admin.job.edit', $job->id) }}"
                                        class="btn btn-primary edit-button">Edit</a>
                                    <form action="{{ route('admin.job.delete', $job->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete-button mt-2"
                                            onclick="return confirm('Are you sure you want to delete this job? This action cannot be undone.')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-center">No jobs found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
</div>
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
@endsection