<!-- Display all categories -->
@extends ('layouts.app')
@section('main')
<div class="container manage-category mt-4">
    <a href="{{ route('admin.category.create') }}" class="btn btn-primary">Create Category</a>
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection