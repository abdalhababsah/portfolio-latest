{{-- resources/views/admin/services/index.blade.php --}}
@extends('admin.layout.app')

@section('content')
<div class="container-fluid">

    {{-- Page title & “add” button --}}
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Services</h4>

            <a href="{{ route('admin.services.create') }}" class="btn btn-success">
                <i class="ti ti-plus me-1"></i> Add New Service
            </a>
        </div>
    </div>

    {{-- flash message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>
        </div>
    @endif

    {{-- table --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cover</th>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Created</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($services as $service)
                            <tr>
                                <td>{{ $service->id }}</td>

                                {{-- cover image --}}
                                <td>
                                    @if($service->cover_image)
                                        <img src="{{ asset('storage/'.$service->cover_image) }}"
                                             alt="{{ $service->title_en }}"
                                             style="height:50px; width:auto; object-fit:cover;">
                                    @else
                                        —
                                    @endif
                                </td>

                                {{-- titles --}}
                                <td>
                                    <div>{{ $service->title_en }}</div>
                                    @if($service->title_ar)
                                        <small class="text-muted" dir="rtl">{{ $service->title_ar }}</small>
                                    @endif
                                </td>

                                {{-- price --}}
                                <td>
                                    {{ $service->price }} {{ $service->currency }}
                                    {{ $service->unit_en ? '/'.$service->unit_en : '' }}
                                </td>

                                <td>{{ $service->created_at->format('d/m/Y') }}</td>

                                {{-- action buttons --}}
                                <td class="text-center">
                                    <div class="btn-group" role="group">

                                        <a href="{{ route('admin.services.show', $service->id) }}"
                                           class="btn btn-sm btn-info"
                                           title="View">
                                            <i class="ti ti-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.services.edit', $service->id) }}"
                                           class="btn btn-sm btn-primary"
                                           title="Edit">
                                            <i class="ti ti-pencil"></i>
                                        </a>

                                        <form action="{{ route('admin.services.destroy', $service->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete this service (and all images)?')"
                                              style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    title="Delete">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No services found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection