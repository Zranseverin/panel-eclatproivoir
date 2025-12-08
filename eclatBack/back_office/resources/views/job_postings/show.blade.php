@extends('layouts.admin')

@section('title', 'Détails de l\'Offre d\'Emploi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Détails de l'Offre d'Emploi</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.job-postings.edit', $jobPosting) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Modifier
                        </a>
                        <a href="{{ route('admin.job-postings.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informations générales</h6>
                        <table class="table table-borderless">
                            <tr>
                                <th>Titre :</th>
                                <td>{{ $jobPosting->title }}</td>
                            </tr>
                            <tr>
                                <th>Type d'emploi :</th>
                                <td>{{ $jobPosting->employment_type ?? 'Non spécifié' }}</td>
                            </tr>
                            <tr>
                                <th>Statut :</th>
                                <td>
                                    @if($jobPosting->is_active)
                                        <span class="badge bg-success">Actif</span>
                                    @else
                                        <span class="badge bg-danger">Inactif</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Date de création :</th>
                                <td>{{ $jobPosting->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Dernière mise à jour :</th>
                                <td>{{ $jobPosting->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                    
                    @if($jobPosting->image_url)
                    <div class="col-md-6">
                        <h6>Image</h6>
                        <img src="{{ $jobPosting->image_url }}" alt="{{ $jobPosting->title }}" class="img-fluid" style="max-height: 200px;">
                    </div>
                    @endif
                </div>
                
                @if($jobPosting->description)
                <div class="mt-4">
                    <h6>Description</h6>
                    <p>{!! nl2br(e($jobPosting->description)) !!}</p>
                </div>
                @endif
                
                @if($jobPosting->mission)
                <div class="mt-4">
                    <h6>Mission</h6>
                    <p>{!! nl2br(e($jobPosting->mission)) !!}</p>
                </div>
                @endif
                
                @if($jobPosting->responsibilities)
                <div class="mt-4">
                    <h6>Responsabilités</h6>
                    <p>{!! nl2br(e($jobPosting->responsibilities)) !!}</p>
                </div>
                @endif
                
                @if($jobPosting->profile_requirements)
                <div class="mt-4">
                    <h6>Profil requis</h6>
                    <p>{!! nl2br(e($jobPosting->profile_requirements)) !!}</p>
                </div>
                @endif
                
                @if($jobPosting->benefits)
                <div class="mt-4">
                    <h6>Avantages</h6>
                    <p>{!! nl2br(e($jobPosting->benefits)) !!}</p>
                </div>
                @endif
                
                <div class="d-flex justify-content-end mt-4">
                    <form action="{{ route('admin.job-postings.destroy', $jobPosting) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette offre d\'emploi?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection