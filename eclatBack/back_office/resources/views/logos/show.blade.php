@extends('layouts.admin')

@section('title', 'Logo Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Logo Details</h5>
                    <a href="{{ route('admin.logos.index') }}" class="btn btn-secondary btn-sm">Back to Logos</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">ID</label>
                            <p class="form-control-plaintext">{{ $logo->id }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Logo Path/URL</label>
                            <p class="form-control-plaintext">{{ $logo->logo_path }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Alt Text</label>
                            <p class="form-control-plaintext">{{ $logo->alt_text }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Site Title</label>
                            <p class="form-control-plaintext">{{ $logo->site_title ?? 'EPI - Eclat pro Ivoire' }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Preview</label>
                            <div>
                                @if($logo->logo_path)
                                    <!-- Check if it's a full URL or relative path -->
                                    @if(Str::startsWith($logo->logo_path, ['http://', 'https://']))
                                        <img src="{{ $logo->logo_path }}" alt="{{ $logo->alt_text }}" class="img-fluid" style="max-height: 200px;">
                                    @else
                                        <img src="{{ asset($logo->logo_path) }}" alt="{{ $logo->alt_text }}" class="img-fluid" style="max-height: 200px;">
                                    @endif
                                @else
                                    <span>No image available</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Created At</label>
                            <p class="form-control-plaintext">{{ $logo->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Updated At</label>
                            <p class="form-control-plaintext">{{ $logo->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.logos.edit', $logo) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.logos.destroy', $logo) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this logo?')">
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