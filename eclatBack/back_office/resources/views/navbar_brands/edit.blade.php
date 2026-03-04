@extends('layouts.admin')

@section('title', 'Edit Navbar Brand Configuration')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Navbar Brand Configuration</h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.navbar-brands.update', $navbarBrand) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <h6 class="border-bottom pb-2">Logo Configuration</h6>
                        
                        <div class="mb-3">
                            <label for="logo_upload" class="form-label">Upload New Logo Image</label>
                            <input type="file" 
                                   class="form-control @error('logo_upload') is-invalid @enderror" 
                                   id="logo_upload" 
                                   name="logo_upload" 
                                   accept="image/*"
                                   onchange="previewLogo(event)">
                            <small class="text-muted">Upload new logo to replace current one (PNG, JPG, GIF - Max 2MB)</small>
                            @error('logo_upload')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <!-- Current Logo Display -->
                            <div class="mt-3 p-3 bg-light rounded">
                                <strong>Current Logo:</strong><br>
                                @if($navbarBrand->logo_path && file_exists(public_path($navbarBrand->logo_path)))
                                    <img src="{{ asset($navbarBrand->logo_path) }}" 
                                         alt="{{ $navbarBrand->logo_alt }}" 
                                         style="max-width: 300px; max-height: {{ $navbarBrand->logo_height }}px; margin-top: 10px; border: 1px solid #ddd; padding: 5px;">
                                @else
                                    <p class="text-muted mb-0">No logo uploaded yet</p>
                                @endif
                            </div>
                            
                            <!-- New Logo Preview -->
                            <div class="mt-3" id="logo_preview_container" style="display: none;">
                                <strong>New Logo Preview:</strong><br>
                                <img id="logo_preview" src="" alt="New Logo Preview" 
                                     style="max-width: 300px; max-height: 150px; border: 1px solid #ddd; padding: 10px; border-radius: 5px; margin-top: 10px;">
                                <p class="text-muted mt-2 mb-0" id="logo_filename"></p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="logo_path" class="form-label">Or Enter Logo Path Manually</label>
                            <input type="text" 
                                   class="form-control @error('logo_path') is-invalid @enderror" 
                                   id="logo_path" 
                                   name="logo_path" 
                                   value="{{ old('logo_path', $navbarBrand->logo_path) }}">
                            <small class="text-muted">If not uploading, keep existing path or enter new relative path</small>
                            @error('logo_path')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="logo_alt" class="form-label">Logo Alt Text</label>
                            <input type="text" 
                                   class="form-control @error('logo_alt') is-invalid @enderror" 
                                   id="logo_alt" 
                                   name="logo_alt" 
                                   value="{{ old('logo_alt', $navbarBrand->logo_alt) }}">
                            <small class="text-muted">Alternative text for accessibility</small>
                            @error('logo_alt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="logo_height" class="form-label">Logo Height (pixels)</label>
                            <input type="number" 
                                   class="form-control @error('logo_height') is-invalid @enderror" 
                                   id="logo_height" 
                                   name="logo_height" 
                                   value="{{ old('logo_height', $navbarBrand->logo_height) }}"
                                   min="10" max="500">
                            <small class="text-muted">Height of logo in pixels (10-500)</small>
                            @error('logo_height')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="border-bottom pb-2">Brand Information</h6>

                        <div class="mb-3">
                            <label for="brand_name" class="form-label">Brand/Company Name</label>
                            <input type="text" 
                                   class="form-control @error('brand_name') is-invalid @enderror" 
                                   id="brand_name" 
                                   name="brand_name" 
                                   value="{{ old('brand_name', $navbarBrand->brand_name) }}">
                            <small class="text-muted">Official company/brand name</small>
                            @error('brand_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="brand_url" class="form-label">Brand Link URL</label>
                            <input type="text" 
                                   class="form-control @error('brand_url') is-invalid @enderror" 
                                   id="brand_url" 
                                   name="brand_url" 
                                   value="{{ old('brand_url', $navbarBrand->brand_url) }}">
                            <small class="text-muted">URL when clicking on brand/logo</small>
                            @error('brand_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $navbarBrand->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active (visible on website)
                            </label>
                            @error('is_active')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>Update Configuration
                        </button>
                        <a href="{{ route('admin.navbar-brands.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-lg me-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewLogo(event) {
    const file = event.target.files[0];
    if (file) {
        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert('Please select an image file (PNG, JPG, GIF)');
            event.target.value = '';
            return;
        }
        
        // Validate file size (2MB max)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB');
            event.target.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('logo_preview').src = e.target.result;
            document.getElementById('logo_preview_container').style.display = 'block';
            document.getElementById('logo_filename').textContent = 'Selected: ' + file.name;
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
