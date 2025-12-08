@extends('layouts.admin')

@section('title', 'Logo Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Logo Management</h5>
                    <a href="{{ route('admin.logos.create') }}" class="btn btn-primary btn-sm">Add New Logo</a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Logo</th>
                                <th>Alt Text</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logos as $logo)
                                <tr>
                                    <td>{{ $logo->id }}</td>
                                    <td>
                                        @if($logo->logo_path)
                                            <!-- Check if it's a full URL or relative path -->
                                            @if(Str::startsWith($logo->logo_path, ['http://', 'https://']))
                                                <img src="{{ $logo->logo_path }}" alt="{{ $logo->alt_text }}" style="max-height: 50px; max-width: 100px;">
                                            @else
                                                <img src="{{ asset($logo->logo_path) }}" alt="{{ $logo->alt_text }}" style="max-height: 50px; max-width: 100px;">
                                            @endif
                                        @else
                                            <span>No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $logo->alt_text }}</td>
                                    <td>{{ $logo->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.logos.edit', $logo) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this logo?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No logos found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection