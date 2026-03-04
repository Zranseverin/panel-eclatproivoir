@extends('layouts.admin')

@section('title', 'Navbar Brand Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Navbar Brand Configuration</h5>
                    <a href="{{ route('admin.navbar-brands.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i> Add New Configuration
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li><i class="bi bi-exclamation-circle me-2"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Logo Preview</th>
                                <th width="20%">Brand Name</th>
                                <th width="20%">Logo Path</th>
                                <th width="10%">Height</th>
                                <th width="10%">Status</th>
                                <th width="10%">Created</th>
                                <th width="10%" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($brands as $brand)
                                <tr class="{{ $brand->is_active ? '' : 'table-secondary' }}">
                                    <td>{{ $brand->id }}</td>
                                    <td>
                                        @if($brand->logo_path)
                                            <img src="{{ asset($brand->logo_path) }}" 
                                                 alt="{{ $brand->logo_alt }}" 
                                                 style="max-height: 50px; max-width: 100px;">
                                        @else
                                            <span class="text-muted">No Logo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $brand->brand_name ?? 'N/A' }}</strong>
                                    </td>
                                    <td>
                                        <code>{{ Str::limit($brand->logo_path ?? 'N/A', 30) }}</code>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $brand->logo_height }}px</span>
                                    </td>
                                    <td>
                                        @if($brand->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $brand->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="{{ route('admin.navbar-brands.show', $brand) }}" 
                                               class="btn btn-sm btn-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.navbar-brands.edit', $brand) }}" 
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.navbar-brands.destroy', $brand) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Delete this configuration?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="bi bi-inbox display-4 text-muted"></i>
                                        <p class="text-muted mt-2">No brand configurations found</p>
                                    </td>
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
