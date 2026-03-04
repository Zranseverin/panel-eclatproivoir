@extends('layouts.admin')

@section('title', 'Add New Logo')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Add New Logo</h5>
                    <a href="{{ route('admin.logos.index') }}" class="btn btn-secondary btn-sm">Back to Logos</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.logos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="logo_image" class="form-label">Logo Image</label>
                        <input type="file" class="form-control" id="logo_image" name="logo_image" accept="image/*" required>
                        @error('logo_image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Upload a logo image (JPG, PNG, GIF)</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="alt_text" class="form-label">Alt Text</label>
                        <input type="text" class="form-control" id="alt_text" name="alt_text" value="{{ old('alt_text') }}">
                        @error('alt_text')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="site_title" class="form-label">Site Title</label>
                        <input type="text" class="form-control" id="site_title" name="site_title" value="{{ old('site_title', 'EPI - Eclat pro Ivoire') }}">
                        @error('site_title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-text">This title will appear in the browser tab</div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Save Logo</button>
                        <a href="{{ route('admin.logos.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection