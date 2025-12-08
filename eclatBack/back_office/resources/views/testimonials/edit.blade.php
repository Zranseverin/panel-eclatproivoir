@extends('layouts.admin')

@section('title', 'Modifier un Témoignage')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Modifier un Témoignage</h5>
                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary btn-sm">Retour aux Témoignages</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="client_name" class="form-label">Nom du Client *</label>
                        <input type="text" class="form-control" id="client_name" name="client_name" value="{{ old('client_name', $testimonial->client_name) }}" required>
                        @error('client_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="client_position" class="form-label">Poste du Client</label>
                                <input type="text" class="form-control" id="client_position" name="client_position" value="{{ old('client_position', $testimonial->client_position) }}">
                                @error('client_position')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="company" class="form-label">Entreprise</label>
                                <input type="text" class="form-control" id="company" name="company" value="{{ old('company', $testimonial->company) }}">
                                @error('company')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="testimonial_text" class="form-label">Texte du Témoignage *</label>
                        <textarea class="form-control" id="testimonial_text" name="testimonial_text" rows="4" required>{{ old('testimonial_text', $testimonial->testimonial_text) }}</textarea>
                        @error('testimonial_text')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="rating" class="form-label">Note (1-5 étoiles)</label>
                        <select class="form-control" id="rating" name="rating">
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('rating', $testimonial->rating) == $i ? 'selected' : '' }}>{{ $i }} étoile{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                        @error('rating')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Nouvelle Image du Client</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Téléchargez une nouvelle image pour ce client (laissez vide pour conserver l'image actuelle)</div>
                    </div>
                    
                    @if($testimonial->client_image_url)
                    <div class="mb-3">
                        <label class="form-label">Image Actuelle</label>
                        <div>
                            <img src="{{ $testimonial->client_image_url }}" alt="{{ $testimonial->client_name }}" style="max-height: 100px;">
                        </div>
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <label for="client_image_url" class="form-label">URL de l'Image du Client</label>
                        <input type="text" class="form-control" id="client_image_url" name="client_image_url" value="{{ old('client_image_url', $testimonial->client_image_url) }}">
                        @error('client_image_url')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Ou entrez une URL d'image (optionnel si vous téléchargez une image)</div>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Témoignage Actif</label>
                        @error('is_active')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">Mettre à Jour</button>
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection