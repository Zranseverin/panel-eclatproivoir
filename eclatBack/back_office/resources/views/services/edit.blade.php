@extends('layouts.admin')

@section('title', 'Modifier un Service')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Modifier un Service</h5>
                    <a href="{{ route('admin.services.index') }}" class="btn btn-secondary btn-sm">Retour aux Services</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.services.update', $service) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="icon_class" class="form-label">Classe d'Icône *</label>
                        <input type="text" class="form-control" id="icon_class" name="icon_class" value="{{ old('icon_class', $service->icon_class) }}" required>
                        <div class="form-text">Exemple: bi bi-globe, fa fa-star, etc.</div>
                        @error('icon_class')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre *</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $service->title) }}" required>
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description *</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $service->description) }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">Mettre à jour le Service</button>
                        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection