@extends('layouts.admin')

@section('title', 'Modifier une Offre d\'Emploi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Modifier une Offre d'Emploi</h5>
                    <a href="{{ route('admin.job-postings.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.job-postings.update', $jobPosting) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">Titre de l'offre *</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $jobPosting->title) }}" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="employment_type" class="form-label">Type d'emploi</label>
                                <input type="text" class="form-control" id="employment_type" name="employment_type" value="{{ old('employment_type', $jobPosting->employment_type) }}">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="badge_text" class="form-label">Texte du badge</label>
                                <input type="text" class="form-control" id="badge_text" name="badge_text" value="{{ old('badge_text', $jobPosting->badge_text) }}">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="badge_class" class="form-label">Classe du badge</label>
                                <select class="form-control" id="badge_class" name="badge_class">
                                    <option value="bg-success" {{ old('badge_class', $jobPosting->badge_class) == 'bg-success' ? 'selected' : '' }}>Succès (Vert)</option>
                                    <option value="bg-primary" {{ old('badge_class', $jobPosting->badge_class) == 'bg-primary' ? 'selected' : '' }}>Principal (Bleu)</option>
                                    <option value="bg-warning" {{ old('badge_class', $jobPosting->badge_class) == 'bg-warning' ? 'selected' : '' }}>Avertissement (Orange)</option>
                                    <option value="bg-danger" {{ old('badge_class', $jobPosting->badge_class) == 'bg-danger' ? 'selected' : '' }}>Danger (Rouge)</option>
                                    <option value="bg-info" {{ old('badge_class', $jobPosting->badge_class) == 'bg-info' ? 'selected' : '' }}>Info (Bleu clair)</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image_url" class="form-label">URL de l'image</label>
                                <input type="text" class="form-control" id="image_url" name="image_url" value="{{ old('image_url', $jobPosting->image_url) }}">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="is_active" class="form-label">Statut</label>
                                <select class="form-control" id="is_active" name="is_active">
                                    <option value="1" {{ old('is_active', $jobPosting->is_active) ? 'selected' : '' }}>Actif</option>
                                    <option value="0" {{ old('is_active', $jobPosting->is_active) == '0' ? 'selected' : '' }}>Inactif</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $jobPosting->description) }}</textarea>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="mission" class="form-label">Mission</label>
                                <textarea class="form-control" id="mission" name="mission" rows="4">{{ old('mission', $jobPosting->mission) }}</textarea>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="responsibilities" class="form-label">Responsabilités</label>
                                <textarea class="form-control" id="responsibilities" name="responsibilities" rows="4">{{ old('responsibilities', $jobPosting->responsibilities) }}</textarea>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="profile_requirements" class="form-label">Profil requis</label>
                                <textarea class="form-control" id="profile_requirements" name="profile_requirements" rows="4">{{ old('profile_requirements', $jobPosting->profile_requirements) }}</textarea>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="benefits" class="form-label">Avantages</label>
                                <textarea class="form-control" id="benefits" name="benefits" rows="4">{{ old('benefits', $jobPosting->benefits) }}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.job-postings.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection