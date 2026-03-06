@extends('admin.layouts.app')

@section('title', 'View About Us Content')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title"><i class="bi bi-eye me-2"></i>About Us Details</h3>
                    <div>
                        <a href="{{ route('admin.about-us.edit', $aboutUs->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('admin.about-us.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Title</h5>
                            <p>{{ $aboutUs->title }}</p>
                            
                            <h5>Subtitle</h5>
                            <p>{{ $aboutUs->subtitle ?? 'N/A' }}</p>
                            
                            <h5>Description</h5>
                            <p>{{ $aboutUs->description }}</p>
                            
                            <h5>Status</h5>
                            <p>
                                @if($aboutUs->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </p>
                        </div>
                        
                        <div class="col-md-6">
                            @if($aboutUs->image_path)
                                <h5>Image</h5>
                                <img src="{{ asset($aboutUs->image_path) }}" alt="About Image" class="img-fluid rounded">
                            @endif
                        </div>
                    </div>
                    
                    @if($aboutUs->feature1_icon || $aboutUs->feature2_icon || $aboutUs->feature3_icon || $aboutUs->feature4_icon)
                    <hr>
                    <h5>Features</h5>
                    <div class="row">
                        @if($aboutUs->feature1_icon)
                        <div class="col-md-3 mb-3">
                            <div class="text-center p-3 border rounded">
                                <i class="{{ $aboutUs->feature1_icon }} fa-2x text-primary mb-2"></i>
                                <h6>{{ $aboutUs->feature1_title ?? 'Feature 1' }}</h6>
                            </div>
                        </div>
                        @endif
                        
                        @if($aboutUs->feature2_icon)
                        <div class="col-md-3 mb-3">
                            <div class="text-center p-3 border rounded">
                                <i class="{{ $aboutUs->feature2_icon }} fa-2x text-primary mb-2"></i>
                                <h6>{{ $aboutUs->feature2_title ?? 'Feature 2' }}</h6>
                            </div>
                        </div>
                        @endif
                        
                        @if($aboutUs->feature3_icon)
                        <div class="col-md-3 mb-3">
                            <div class="text-center p-3 border rounded">
                                <i class="{{ $aboutUs->feature3_icon }} fa-2x text-primary mb-2"></i>
                                <h6>{{ $aboutUs->feature3_title ?? 'Feature 3' }}</h6>
                            </div>
                        </div>
                        @endif
                        
                        @if($aboutUs->feature4_icon)
                        <div class="col-md-3 mb-3">
                            <div class="text-center p-3 border rounded">
                                <i class="{{ $aboutUs->feature4_icon }} fa-2x text-primary mb-2"></i>
                                <h6>{{ $aboutUs->feature4_title ?? 'Feature 4' }}</h6>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                    
                    <hr>
                    <small class="text-muted">
                        Created: {{ $aboutUs->created_at->format('d/m/Y H:i') }} | 
                        Updated: {{ $aboutUs->updated_at->format('d/m/Y H:i') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
