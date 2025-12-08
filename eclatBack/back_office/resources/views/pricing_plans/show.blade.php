@extends('layouts.admin')

@section('title', 'Détails du Plan de Tarification')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Détails du Plan de Tarification</h5>
                    <a href="{{ route('admin.pricing_plans.index') }}" class="btn btn-secondary btn-sm">Retour aux Plans</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">ID</label>
                            <p class="form-control-plaintext">{{ $pricingPlan->id }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Titre</label>
                            <p class="form-control-plaintext">{{ $pricingPlan->title }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Sous-titre</label>
                            <p class="form-control-plaintext">{{ $pricingPlan->subtitle }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Prix</label>
                            <p class="form-control-plaintext">{{ number_format($pricingPlan->price, 2, ',', ' ') }} {{ $pricingPlan->currency }}/{{ $pricingPlan->period }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Texte du Bouton d'Action</label>
                            <p class="form-control-plaintext">{{ $pricingPlan->cta_text }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            @if($pricingPlan->image_url)
                                <div class="mt-2">
                                    <img src="{{ $pricingPlan->image_url }}" alt="{{ $pricingPlan->title }}" style="max-height: 100px;">
                                </div>
                            @else
                                <p class="form-control-plaintext">Aucune image</p>
                            @endif
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Statut</label>
                            <p class="form-control-plaintext">
                                @if($pricingPlan->is_active)
                                    <span class="badge bg-success">Actif</span>
                                @else
                                    <span class="badge bg-secondary">Inactif</span>
                                @endif
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Date de Création</label>
                            <p class="form-control-plaintext">{{ $pricingPlan->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Dernière Modification</label>
                            <p class="form-control-plaintext">{{ $pricingPlan->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">Caractéristiques</label>
                            <div class="form-control-plaintext">
                                {{ $pricingPlan->features }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.pricing_plans.edit', $pricingPlan) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('admin.pricing_plans.destroy', $pricingPlan) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce plan de tarification?')">
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