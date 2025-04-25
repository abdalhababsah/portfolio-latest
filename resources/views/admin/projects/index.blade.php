@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Projects</h4>
            <a href="{{ route('admin.projects.create') }}" class="btn btn-success">New Project</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cover</th>
                            <th>Title (EN)</th>
                            <th>Category</th>
                            <th>Featured</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                        <tr>
                            <td>{{ $project->id }}</td>
                            <td>
                                @if($project->cover_image)
                                    <img src="{{ asset('storage/'.$project->cover_image) }}" alt="Cover" style="height:50px; object-fit:cover;">
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $project->title_en }}</td>
                            <td>{{ $project->category->name_en ?? '—' }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.projects.toggle-featured', $project->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm {{ $project->featured ? 'btn-success' : 'btn-outline-secondary' }}">
                                        {{ $project->featured ? 'Yes' : 'No' }}
                                    </button>
                                </form>
                            </td>
                            <td>{{ $project->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this project?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
