@extends('layouts.admin')

@section('title', 'Créer un Plan de Tarification')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Créer un Plan de Tarification</h5>
                    <a href="{{ route('admin.pricing_plans.index') }}" class="btn btn-secondary btn-sm">Retour aux Plans</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pricing_plans.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre *</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="subtitle" class="form-label">Sous-titre *</label>
                        <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ old('subtitle') }}" required>
                        @error('subtitle')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="price" class="form-label">Prix *</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ old('price') }}" required>
                                @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="currency" class="form-label">Devise *</label>
                                <input type="text" class="form-control" id="currency" name="currency" value="{{ old('currency', 'FCFA') }}" required>
                                @error('currency')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="period" class="form-label">Période *</label>
                                <input type="text" class="form-control" id="period" name="period" value="{{ old('period', 'Mois') }}" required>
                                @error('period')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Téléchargez une image pour ce plan de tarification</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="image_url" class="form-label">URL de l'Image</label>
                        <input type="text" class="form-control" id="image_url" name="image_url" value="{{ old('image_url') }}">
                        @error('image_url')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Ou entrez une URL d'image (optionnel si vous téléchargez une image)</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="features" class="form-label">Caractéristiques *</label>
                        <textarea class="form-control" id="features" name="features" rows="4" required>{{ old('features') }}</textarea>
                        <div class="form-text">Entrez les caractéristiques séparées par des virgules ou saisissez du texte libre</div>
                        @error('features')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="cta_text" class="form-label">Texte du Bouton d'Action *</label>
                        <input type="text" class="form-control" id="cta_text" name="cta_text" value="{{ old('cta_text', 'Choisir') }}" required>
                        @error('cta_text')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Plan Actif</label>
                        @error('is_active')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">Créer le Plan</button>
                        <a href="{{ route('admin.pricing_plans.index') }}" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection