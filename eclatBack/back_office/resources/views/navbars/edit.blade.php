@extends('layouts.admin')

@section('title', 'Edit Menu Item')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Menu Item</h5>
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

                <form action="{{ route('admin.navbars.update', $navbar) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <h6 class="border-bottom pb-2">Basic Information</h6>
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Menu Title <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $navbar->title) }}"
                                   required>
                            <small class="text-muted">This is the text that will appear in the menu</small>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="url" class="form-label">URL <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('url') is-invalid @enderror" 
                                   id="url" 
                                   name="url" 
                                   value="{{ old('url', $navbar->url) }}"
                                   required>
                            <small class="text-muted">The link URL (can be a PHP file or path)</small>
                            @error('url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="route_name" class="form-label">Laravel Route Name (Optional)</label>
                            <input type="text" 
                                   class="form-control @error('route_name') is-invalid @enderror" 
                                   id="route_name" 
                                   name="route_name" 
                                   value="{{ old('route_name', $navbar->route_name) }}">
                            <small class="text-muted">If using Laravel routes, enter the route name here</small>
                            @error('route_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="border-bottom pb-2">Menu Configuration</h6>

                        <div class="mb-3">
                            <label for="parent_id" class="form-label">Parent Menu (for dropdowns)</label>
                            <select class="form-select @error('parent_id') is-invalid @enderror" 
                                    id="parent_id" 
                                    name="parent_id">
                                <option value="">-- Top Level Menu --</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id', $navbar->parent_id) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->title }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Select a parent to create a dropdown submenu item</small>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="order" class="form-label">Display Order</label>
                            <input type="number" 
                                   class="form-control @error('order') is-invalid @enderror" 
                                   id="order" 
                                   name="order" 
                                   value="{{ old('order', $navbar->order) }}"
                                   min="0">
                            <small class="text-muted">Lower numbers appear first in the menu</small>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $navbar->is_active) ? 'checked' : '' }}>
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
                            <i class="bi bi-check-lg me-2"></i>Update Menu Item
                        </button>
                        <a href="{{ route('admin.navbars.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-lg me-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
