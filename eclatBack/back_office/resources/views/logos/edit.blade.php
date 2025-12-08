@extends('layouts.admin')

@section('title', 'Edit Logo')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Edit Logo</h5>
                    <a href="{{ route('admin.logos.index') }}" class="btn btn-secondary btn-sm">Back to Logos</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.logos.update', $logo) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="logo_image" class="form-label">Logo Image</label>
                        <input type="file" class="form-control" id="logo_image" name="logo_image" accept="image/*">
                        @if($logo->logo_path)
                            <div class="mt-2">
                                <!-- Check if it's a full URL or relative path -->
                                @if(Str::startsWith($logo->logo_path, ['http://', 'https://']))
                                    <img src="{{ $logo->logo_path }}" alt="{{ $logo->alt_text }}" style="max-height: 100px;">
                                @else
                                    <img src="{{ asset($logo->logo_path) }}" alt="{{ $logo->alt_text }}" style="max-height: 100px;">
                                @endif
                            </div>
                        @endif
                        @error('logo_image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Upload a new logo image (JPG, PNG, GIF) or leave blank to keep current image</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="alt_text" class="form-label">Alt Text</label>
                        <input type="text" class="form-control" id="alt_text" name="alt_text" value="{{ old('alt_text', $logo->alt_text) }}">
                        @error('alt_text')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update Logo</button>
                        <a href="{{ route('admin.logos.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection