@extends('layouts.admin')

@section('title', 'Créer une Candidature')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Nouvelle Candidature</h5>
                    <a href="{{ route('admin.job-applications.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Retour à la liste
                </a>
                </div>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.job-applications.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="civilite" class="form-label">Civilité <span class="text-danger">*</span></label>
                                <select name="civilite" id="civilite" class="form-control" required>
                                    <option value="">Sélectionnez...</option>
                                    <option value="Monsieur">Monsieur</option>
                                    <option value="Madame">Madame</option>
                                    <option value="Mademoiselle">Mademoiselle</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="nom_complet" class="form-label">Nom Complet <span class="text-danger">*</span></label>
                                <input type="text" name="nom_complet" id="nom_complet" class="form-control" value="{{ old('nom_complet') }}" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="telephone" class="form-label">Téléphone <span class="text-danger">*</span></label>
                                <input type="text" name="telephone" id="telephone" class="form-control" value="{{ old('telephone') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="adresse" class="form-label">Adresse <span class="text-danger">*</span></label>
                        <textarea name="adresse" id="adresse" class="form-control" rows="3" required>{{ old('adresse') }}</textarea>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="poste" class="form-label">Poste <span class="text-danger">*</span></label>
                        <input type="text" name="poste" id="poste" class="form-control" value="{{ old('poste') }}" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="cv" class="form-label">CV (PDF, DOC, DOCX)</label>
                                <input type="file" name="cv" id="cv" class="form-control" accept=".pdf,.doc,.docx">
                                <div class="form-text">Taille maximale : 2 Mo</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="lettre_motivation" class="form-label">Lettre de Motivation (PDF, DOC, DOCX)</label>
                                <input type="file" name="lettre_motivation" id="lettre_motivation" class="form-control" accept=".pdf,.doc,.docx">
                                <div class="form-text">Taille maximale : 2 Mo</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Statut</label>
                        <select name="status" id="status" class="form-control">
                            <option value="pending" selected>En attente</option>
                            <option value="reviewed">Revu</option>
                            <option value="accepted">Accepté</option>
                            <option value="rejected">Rejeté</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Créer
                        </button>
                        <a href="{{ route('admin.job-applications.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection