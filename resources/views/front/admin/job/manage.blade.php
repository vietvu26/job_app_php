@extends ('front.layouts.app')
@section('main')
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
                        <th class="fw-bold">Email</th>
                        <th class="fw-bold">Phone</th>
                        <th class="fw-bold">Candidates</th>
                        <th class="fw-bold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobs as $job)
                        <tr>
                            <td>{{ $job->title }}</td>
                            <td>{{ $job->description }}</td>
                            <td>{{ $job->location }}</td>
                            <td>{{ $job->salary }}</td>
                            <td>{{ $job->company }}</td>
                            <td>{{ $job->email }}</td>
                            <td>{{ $job->phone }}</td>
                            <!-- $job->candidates is return value like this ["1","2","3"] and the data type is string -->
                            <!-- route to link profile of each user -->
                            <td>
                                @if (count($job->candidates) == 0)
                                    No candidates
                                @else
                                    @foreach ($job->candidates as $candidate)
                                        <a href="{{ route('admin.login', $candidate) }}"
                                            class="list-candidate">{{ $candidate->name }}</a>
                                    @endforeach
                                @endif
                            </td>
                            <td class="btn-action">
                                <a href="{{ route('admin.job.edit', $job->id) }}" class="btn btn-primary">Edit</a>
                                <a href="{{ route('admin.job.delete', $job->id) }}"
                                    class="btn btn-danger delete-button mt-2" onclick="deleteJob({{$job->id}})">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
</div>
<script>
function deleteJob(id) {
    if (confirm('Are you sure you want to delete this job?')) {
        window.location.href = '/admin/job/delete/' + id;
    }
}
</script>
@endsection