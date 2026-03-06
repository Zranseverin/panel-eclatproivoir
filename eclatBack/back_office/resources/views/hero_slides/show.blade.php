@extends('admin.layouts.app')

@section('title', 'Hero Slide Details')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title"><i class="bi bi-eye me-2"></i>Hero Slide Details</h3>
                    <a href="{{ route('admin.hero-slides.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            @if($heroSlide->background_image)
                                <img src="{{ asset($heroSlide->background_image) }}" alt="{{ $heroSlide->title }}" 
                                     class="img-fluid rounded" style="max-height: 400px; width: 100%; object-fit: cover;">
                            @else
                                <div class="bg-light text-center py-5 rounded">
                                    <i class="bi bi-image display-1 text-muted"></i>
                                    <p class="text-muted mt-2">No background image</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <h5 class="text-muted">Title</h5>
                            <p class="fs-5">{{ $heroSlide->title }}</p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <h5 class="text-muted">Subtitle</h5>
                            <p class="fs-5">{{ $heroSlide->subtitle ?? 'N/A' }}</p>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <h5 class="text-muted">Description</h5>
                            <p>{{ $heroSlide->description ?? 'No description provided' }}</p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <h5 class="text-muted">Button 1</h5>
                            <p><strong>Text:</strong> {{ $heroSlide->button1_text ?? 'N/A' }}</p>
                            <p><strong>URL:</strong> {{ $heroSlide->button1_url ?? 'N/A' }}</p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <h5 class="text-muted">Button 2</h5>
                            <p><strong>Text:</strong> {{ $heroSlide->button2_text ?? 'N/A' }}</p>
                            <p><strong>URL:</strong> {{ $heroSlide->button2_url ?? 'N/A' }}</p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <h5 class="text-muted">Status</h5>
                            <p>
                                @if($heroSlide->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <h5 class="text-muted">Order</h5>
                            <p>{{ $heroSlide->order }}</p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <h5 class="text-muted">Created At</h5>
                            <p>{{ $heroSlide->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <h5 class="text-muted">Updated At</h5>
                            <p>{{ $heroSlide->updated_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.hero-slides.edit', $heroSlide->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-1"></i>Edit Slide
                        </a>
                        <form action="{{ route('admin.hero-slides.destroy', $heroSlide->id) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this slide?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-1"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
