@extends('layouts.admin')

@section('title', 'Hero Content Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Hero Content Details</h5>
                    <a href="{{ route('admin.hero_contents.index') }}" class="btn btn-secondary btn-sm">Back to Hero Contents</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">ID</label>
                            <p class="form-control-plaintext">{{ $heroContent->id }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Headline</label>
                            <p class="form-control-plaintext">{{ $heroContent->headline }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Subheading</label>
                            <p class="form-control-plaintext">{{ $heroContent->subheading ?? 'N/A' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Primary Button Text</label>
                            <p class="form-control-plaintext">{{ $heroContent->primary_button_text ?? 'N/A' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Primary Button Link</label>
                            <p class="form-control-plaintext">{{ $heroContent->primary_button_link ?? 'N/A' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Secondary Button Text</label>
                            <p class="form-control-plaintext">{{ $heroContent->secondary_button_text ?? 'N/A' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Secondary Button Link</label>
                            <p class="form-control-plaintext">{{ $heroContent->secondary_button_link ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Background Image</label>
                            @if($heroContent->background_image_url)
                                <div class="mt-2">
                                    <img src="{{ $heroContent->background_image_url }}" alt="Background Image" style="max-height: 100px;">
                                </div>
                            @else
                                <p class="form-control-plaintext">N/A</p>
                            @endif
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Background Color</label>
                            <p class="form-control-plaintext">
                                <span class="badge" style="background-color: {{ $heroContent->background_color ?? '#009900' }}">
                                    {{ $heroContent->background_color ?? '#009900' }}
                                </span>
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Text Color</label>
                            <p class="form-control-plaintext">
                                <span class="badge" style="background-color: {{ $heroContent->text_color ?? '#ffffff' }}; color: #000">
                                    {{ $heroContent->text_color ?? '#ffffff' }}
                                </span>
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <p class="form-control-plaintext">
                                @if($heroContent->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Created At</label>
                            <p class="form-control-plaintext">{{ $heroContent->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Updated At</label>
                            <p class="form-control-plaintext">{{ $heroContent->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.hero_contents.edit', $heroContent) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.hero_contents.destroy', $heroContent) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this hero content?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection