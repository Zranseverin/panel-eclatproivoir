@extends('layouts.admin')

@section('title', 'Détails du Service')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Détails du Service</h5>
                    <a href="{{ route('admin.services.index') }}" class="btn btn-secondary btn-sm">Retour aux Services</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">ID</label>
                            <p class="form-control-plaintext">{{ $service->id }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Icône</label>
                            <p class="form-control-plaintext">
                                <i class="{{ $service->icon_class }} fs-4 me-2"></i>
                                {{ $service->icon_class }}
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Titre</label>
                            <p class="form-control-plaintext">{{ $service->title }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Date de Création</label>
                            <p class="form-control-plaintext">{{ $service->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Dernière Modification</label>
                            <p class="form-control-plaintext">{{ $service->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <div class="form-control-plaintext">
                                {{ $service->description }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce service?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection