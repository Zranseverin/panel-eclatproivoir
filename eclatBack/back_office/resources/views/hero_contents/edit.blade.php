@extends('layouts.admin')

@section('title', 'Edit Hero Content')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Edit Hero Content</h5>
                    <a href="{{ route('admin.hero_contents.index') }}" class="btn btn-secondary btn-sm">Back to Hero Contents</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.hero_contents.update', $heroContent) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="headline" class="form-label">Headline *</label>
                        <input type="text" class="form-control" id="headline" name="headline" value="{{ old('headline', $heroContent->headline) }}" required>
                        @error('headline')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="subheading" class="form-label">Subheading</label>
                        <input type="text" class="form-control" id="subheading" name="subheading" value="{{ old('subheading', $heroContent->subheading) }}">
                        @error('subheading')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="primary_button_text" class="form-label">Primary Button Text</label>
                        <input type="text" class="form-control" id="primary_button_text" name="primary_button_text" value="{{ old('primary_button_text', $heroContent->primary_button_text) }}">
                        @error('primary_button_text')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="primary_button_link" class="form-label">Primary Button Link</label>
                        <input type="text" class="form-control" id="primary_button_link" name="primary_button_link" value="{{ old('primary_button_link', $heroContent->primary_button_link) }}">
                        @error('primary_button_link')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="secondary_button_text" class="form-label">Secondary Button Text</label>
                        <input type="text" class="form-control" id="secondary_button_text" name="secondary_button_text" value="{{ old('secondary_button_text', $heroContent->secondary_button_text) }}">
                        @error('secondary_button_text')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="secondary_button_link" class="form-label">Secondary Button Link</label>
                        <input type="text" class="form-control" id="secondary_button_link" name="secondary_button_link" value="{{ old('secondary_button_link', $heroContent->secondary_button_link) }}">
                        @error('secondary_button_link')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="background_image" class="form-label">Background Image</label>
                        <input type="file" class="form-control" id="background_image" name="background_image" accept="image/*">
                        @if($heroContent->background_image_url)
                            <div class="mt-2">
                                <img src="{{ $heroContent->background_image_url }}" alt="Current Background" style="max-height: 100px;">
                            </div>
                        @endif
                        @error('background_image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Upload a new background image (JPG, PNG, GIF) or keep the current one</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="background_image_url" class="form-label">Background Image URL</label>
                        <input type="text" class="form-control" id="background_image_url" name="background_image_url" value="{{ old('background_image_url', $heroContent->background_image_url) }}">
                        @error('background_image_url')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Enter a URL for the background image (optional if uploading)</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="background_color" class="form-label">Background Color</label>
                        <input type="color" class="form-control form-control-color" id="background_color" name="background_color" value="{{ old('background_color', $heroContent->background_color) }}">
                        @error('background_color')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="text_color" class="form-label">Text Color</label>
                        <input type="color" class="form-control form-control-color" id="text_color" name="text_color" value="{{ old('text_color', $heroContent->text_color) }}">
                        @error('text_color')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $heroContent->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                        @error('is_active')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update Hero Content</button>
                        <a href="{{ route('admin.hero_contents.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection