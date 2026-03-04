@extends('layouts.admin')

@section('title', 'Navbar Brand Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0"><i class="bi bi-menu-button-wide me-2"></i>Navbar Brand Details</h5>
                    <a href="{{ route('admin.navbar-brands.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Back to List
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Status Badge -->
                <div class="mb-4">
                    @if($navbarBrand->is_active)
                        <span class="badge bg-success fs-6">
                            <i class="bi bi-check-circle me-1"></i>Active
                        </span>
                    @else
                        <span class="badge bg-secondary fs-6">
                            <i class="bi bi-x-circle me-1"></i>Inactive
                        </span>
                    @endif
                </div>

                <!-- Logo Preview -->
                <div class="mb-4 p-3 bg-light rounded text-center">
                    <h6 class="mb-3">Logo Preview</h6>
                    @if($navbarBrand->logo_path)
                        <img src="{{ asset($navbarBrand->logo_path) }}" 
                             alt="{{ $navbarBrand->logo_alt }}" 
                             style="max-height: {{ $navbarBrand->logo_height }}px; max-width: 300px;">
                    @else
                        <p class="text-muted mb-0">No logo configured</p>
                    @endif
                </div>

                <!-- Configuration Details -->
                <h6 class="border-bottom pb-2 mb-3">Logo Configuration</h6>
                <table class="table table-bordered mb-4">
                    <tbody>
                        <tr>
                            <th style="width: 30%;">Logo Path</th>
                            <td><code>{{ $navbarBrand->logo_path ?? 'Not set' }}</code></td>
                        </tr>
                        <tr>
                            <th>Logo Alt Text</th>
                            <td>{{ $navbarBrand->logo_alt ?? 'Not set' }}</td>
                        </tr>
                        <tr>
                            <th>Logo Height</th>
                            <td>
                                <span class="badge bg-info">{{ $navbarBrand->logo_height }}px</span>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Brand Information -->
                <h6 class="border-bottom pb-2 mb-3">Brand Information</h6>
                <table class="table table-bordered mb-4">
                    <tbody>
                        <tr>
                            <th style="width: 30%;">Brand Name</th>
                            <td><strong>{{ $navbarBrand->brand_name ?? 'Not set' }}</strong></td>
                        </tr>
                        <tr>
                            <th>Brand Link URL</th>
                            <td><code>{{ $navbarBrand->brand_url ?? 'Not set' }}</code></td>
                        </tr>
                    </tbody>
                </table>

                <!-- Timestamps -->
                <div class="mt-4 p-3 bg-light rounded">
                    <small class="text-muted">
                        <i class="bi bi-clock-history me-2"></i>
                        Created: <strong>{{ $navbarBrand->created_at->format('M d, Y H:i:s') }}</strong> | 
                        Updated: <strong>{{ $navbarBrand->updated_at->format('M d, Y H:i:s') }}</strong>
                    </small>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('admin.navbar-brands.edit', $navbarBrand) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-2"></i>Edit this Configuration
                    </a>
                    <form action="{{ route('admin.navbar-brands.destroy', $navbarBrand) }}" 
                          method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this configuration?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
