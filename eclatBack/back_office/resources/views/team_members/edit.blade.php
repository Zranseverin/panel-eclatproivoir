@extends('layouts.admin')

@section('title', 'Modifier un Membre de l\'Équipe')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Modifier un Membre de l'Équipe</h5>
                    <a href="{{ route('admin.team_members.index') }}" class="btn btn-secondary btn-sm">Retour aux Membres</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.team_members.update', $teamMember) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom Complet *</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $teamMember->name) }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="role" class="form-label">Rôle *</label>
                        <input type="text" class="form-control" id="role" name="role" value="{{ old('role', $teamMember->role) }}" required>
                        @error('role')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="bio" class="form-label">Biographie *</label>
                        <textarea class="form-control" id="bio" name="bio" rows="4" required>{{ old('bio', $teamMember->bio) }}</textarea>
                        @error('bio')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Nouvelle Image du Membre</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Téléchargez une nouvelle image pour ce membre de l'équipe (laissez vide pour conserver l'image actuelle)</div>
                    </div>
                    
                    @if($teamMember->image_url)
                    <div class="mb-3">
                        <label class="form-label">Image Actuelle</label>
                        <div>
                            <img src="{{ $teamMember->image_url }}" alt="{{ $teamMember->name }}" style="max-height: 100px;">
                        </div>
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <label for="image_url" class="form-label">URL de l'Image</label>
                        <input type="text" class="form-control" id="image_url" name="image_url" value="{{ old('image_url', $teamMember->image_url) }}">
                        @error('image_url')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Ou entrez une URL d'image (optionnel si vous téléchargez une image)</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="twitter_url" class="form-label">URL Twitter</label>
                                <input type="url" class="form-control" id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $teamMember->twitter_url) }}">
                                @error('twitter_url')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="facebook_url" class="form-label">URL Facebook</label>
                                <input type="url" class="form-control" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $teamMember->facebook_url) }}">
                                @error('facebook_url')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="linkedin_url" class="form-label">URL LinkedIn</label>
                                <input type="url" class="form-control" id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $teamMember->linkedin_url) }}">
                                @error('linkedin_url')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $teamMember->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Membre Actif</label>
                        @error('is_active')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">Mettre à Jour</button>
                        <a href="{{ route('admin.team_members.index') }}" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection