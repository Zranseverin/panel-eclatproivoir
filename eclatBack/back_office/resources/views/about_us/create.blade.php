@extends('layouts.admin')

@section('title', 'Create About Us Content')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="bi bi-plus-circle me-2"></i>Create New About Us Content</h3>
                    <a href="{{ route('admin.about-us.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.about-us.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <!-- Main Content -->
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title *</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="subtitle" class="form-label">Subtitle</label>
                                    <input type="text" class="form-control @error('subtitle') is-invalid @enderror" 
                                           id="subtitle" name="subtitle" value="{{ old('subtitle') }}">
                                    @error('subtitle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description *</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="image_path" class="form-label">About Image</label>
                                    <input type="file" class="form-control @error('image_path') is-invalid @enderror" 
                                           id="image_path" name="image_path" accept="image/*">
                                    <small class="text-muted">Recommended size: 600x700px</small>
                                    @error('image_path')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Features Section -->
                            <div class="col-md-4">
                                <h5 class="mb-3">Features (Icons & Titles)</h5>
                                
                                <div class="mb-3">
                                    <label for="feature1_icon" class="form-label">Feature 1 Icon</label>
                                    <input type="text" class="form-control @error('feature1_icon') is-invalid @enderror" 
                                           id="feature1_icon" name="feature1_icon" value="{{ old('feature1_icon') }}" 
                                           placeholder="e.g., fa fa-user-md">
                                    <small class="text-muted">FontAwesome class</small>
                                    @error('feature1_icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="feature1_title" class="form-label">Feature 1 Title</label>
                                    <input type="text" class="form-control @error('feature1_title') is-invalid @enderror" 
                                           id="feature1_title" name="feature1_title" value="{{ old('feature1_title') }}">
                                    @error('feature1_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr>

                                <div class="mb-3">
                                    <label for="feature2_icon" class="form-label">Feature 2 Icon</label>
                                    <input type="text" class="form-control @error('feature2_icon') is-invalid @enderror" 
                                           id="feature2_icon" name="feature2_icon" value="{{ old('feature2_icon') }}" 
                                           placeholder="e.g., fa fa-procedures">
                                    @error('feature2_icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="feature2_title" class="form-label">Feature 2 Title</label>
                                    <input type="text" class="form-control @error('feature2_title') is-invalid @enderror" 
                                           id="feature2_title" name="feature2_title" value="{{ old('feature2_title') }}">
                                    @error('feature2_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr>

                                <div class="mb-3">
                                    <label for="feature3_icon" class="form-label">Feature 3 Icon</label>
                                    <input type="text" class="form-control @error('feature3_icon') is-invalid @enderror" 
                                           id="feature3_icon" name="feature3_icon" value="{{ old('feature3_icon') }}" 
                                           placeholder="e.g., fa fa-microscope">
                                    @error('feature3_icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="feature3_title" class="form-label">Feature 3 Title</label>
                                    <input type="text" class="form-control @error('feature3_title') is-invalid @enderror" 
                                           id="feature3_title" name="feature3_title" value="{{ old('feature3_title') }}">
                                    @error('feature3_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr>

                                <div class="mb-3">
                                    <label for="feature4_icon" class="form-label">Feature 4 Icon</label>
                                    <input type="text" class="form-control @error('feature4_icon') is-invalid @enderror" 
                                           id="feature4_icon" name="feature4_icon" value="{{ old('feature4_icon') }}" 
                                           placeholder="e.g., fa fa-ambulance">
                                    @error('feature4_icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="feature4_title" class="form-label">Feature 4 Title</label>
                                    <input type="text" class="form-control @error('feature4_title') is-invalid @enderror" 
                                           id="feature4_title" name="feature4_title" value="{{ old('feature4_title') }}">
                                    @error('feature4_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Create About Us Content
                            </button>
                            <a href="{{ route('admin.about-us.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
