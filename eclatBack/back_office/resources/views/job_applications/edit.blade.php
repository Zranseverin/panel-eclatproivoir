@extends('layouts.admin')

@section('title', 'Modifier une Candidature')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Modifier la Candidature</h5>
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

                <form action="{{ route('admin.job-applications.update', $jobApplication) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="civilite" class="form-label">Civilité <span class="text-danger">*</span></label>
                                <select name="civilite" id="civilite" class="form-control" required>
                                    <option value="">Sélectionnez...</option>
                                    <option value="Monsieur" {{ $jobApplication->civilite == 'Monsieur' ? 'selected' : '' }}>Monsieur</option>
                                    <option value="Madame" {{ $jobApplication->civilite == 'Madame' ? 'selected' : '' }}>Madame</option>
                                    <option value="Mademoiselle" {{ $jobApplication->civilite == 'Mademoiselle' ? 'selected' : '' }}>Mademoiselle</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="nom_complet" class="form-label">Nom Complet <span class="text-danger">*</span></label>
                                <input type="text" name="nom_complet" id="nom_complet" class="form-control" value="{{ old('nom_complet', $jobApplication->nom_complet) }}" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="telephone" class="form-label">Téléphone <span class="text-danger">*</span></label>
                                <input type="text" name="telephone" id="telephone" class="form-control" value="{{ old('telephone', $jobApplication->telephone) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $jobApplication->email) }}" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="adresse" class="form-label">Adresse <span class="text-danger">*</span></label>
                        <textarea name="adresse" id="adresse" class="form-control" rows="3" required>{{ old('adresse', $jobApplication->adresse) }}</textarea>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="poste" class="form-label">Poste <span class="text-danger">*</span></label>
                        <input type="text" name="poste" id="poste" class="form-control" value="{{ old('poste', $jobApplication->poste) }}" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="cv" class="form-label">CV (PDF, DOC, DOCX)</label>
                                <input type="file" name="cv" id="cv" class="form-control" accept=".pdf,.doc,.docx">
                                <div class="form-text">Taille maximale : 2 Mo</div>
                                @if($jobApplication->cv_path)
                                    @php
                                        $cvFullPath = storage_path('app/public/' . $jobApplication->cv_path);
                                        $cvExists = file_exists($cvFullPath);
                                        $cvExtension = $cvExists ? strtolower(pathinfo($jobApplication->cv_path, PATHINFO_EXTENSION)) : '';
                                    @endphp
                                    @if($cvExists && in_array($cvExtension, ['pdf']))
                                        <div class="mt-2">
                                            <iframe src="{{ Storage::url($jobApplication->cv_path) }}" width="100%" height="200px"></iframe>
                                        </div>
                                    @elseif(!$cvExists)
                                        <div class="alert alert-warning mt-2">Fichier CV introuvable</div>
                                    @endif
                                    <div class="mt-2">
                                        <a href="{{ route('admin.job-applications.download-cv', $jobApplication) }}" class="btn btn-sm btn-info" target="_blank">Télécharger le CV actuel</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="lettre_motivation" class="form-label">Lettre de Motivation (PDF, DOC, DOCX)</label>
                                <input type="file" name="lettre_motivation" id="lettre_motivation" class="form-control" accept=".pdf,.doc,.docx">
                                <div class="form-text">Taille maximale : 2 Mo</div>
                                @if($jobApplication->lettre_motivation_path)
                                    @php
                                        $letterFullPath = storage_path('app/public/' . $jobApplication->lettre_motivation_path);
                                        $letterExists = file_exists($letterFullPath);
                                        $letterExtension = $letterExists ? strtolower(pathinfo($jobApplication->lettre_motivation_path, PATHINFO_EXTENSION)) : '';
                                    @endphp
                                    @if($letterExists && in_array($letterExtension, ['pdf']))
                                        <div class="mt-2">
                                            <iframe src="{{ Storage::url($jobApplication->lettre_motivation_path) }}" width="100%" height="200px"></iframe>
                                        </div>
                                    @elseif(!$letterExists)
                                        <div class="alert alert-warning mt-2">Fichier lettre de motivation introuvable</div>
                                    @endif
                                    <div class="mt-2">
                                        <a href="{{ route('admin.job-applications.download-lettre-motivation', $jobApplication) }}" class="btn btn-sm btn-info" target="_blank">Télécharger la lettre actuelle</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Statut</label>
                        <select name="status" id="status" class="form-control">
                            <option value="pending" {{ $jobApplication->status == 'pending' ? 'selected' : '' }}>En attente</option>
                            <option value="reviewed" {{ $jobApplication->status == 'reviewed' ? 'selected' : '' }}>Revu</option>
                            <option value="accepted" {{ $jobApplication->status == 'accepted' ? 'selected' : '' }}>Accepté</option>
                            <option value="rejected" {{ $jobApplication->status == 'rejected' ? 'selected' : '' }}>Rejeté</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Mettre à jour
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