@extends('layouts.admin')

@section('title', 'Détails du Membre de l\'Équipe')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Détails du Membre de l'Équipe</h5>
                    <a href="{{ route('admin.team_members.index') }}" class="btn btn-secondary btn-sm">Retour aux Membres</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                @if($teamMember->image_url)
                                    <img src="{{ $teamMember->image_url }}" alt="{{ $teamMember->name }}" class="img-fluid rounded" style="max-height: 300px;">
                                @else
                                    <div class="bg-light p-5 rounded">
                                        <i class="bi bi-person-circle" style="font-size: 5rem;"></i>
                                    </div>
                                @endif
                                <h5 class="mt-3">{{ $teamMember->name }}</h5>
                                <p class="text-muted">{{ $teamMember->role }}</p>
                                
                                <div class="d-flex justify-content-center gap-2 mt-3">
                                    @if($teamMember->twitter_url)
                                        <a href="{{ $teamMember->twitter_url }}" target="_blank" class="btn btn-outline-info btn-sm">
                                            <i class="bi bi-twitter"></i>
                                        </a>
                                    @endif
                                    @if($teamMember->facebook_url)
                                        <a href="{{ $teamMember->facebook_url }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-facebook"></i>
                                        </a>
                                    @endif
                                    @if($teamMember->linkedin_url)
                                        <a href="{{ $teamMember->linkedin_url }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-linkedin"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h5>Informations</h5>
                                <hr>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>ID:</strong></div>
                                    <div class="col-sm-9">{{ $teamMember->id }}</div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Nom:</strong></div>
                                    <div class="col-sm-9">{{ $teamMember->name }}</div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Rôle:</strong></div>
                                    <div class="col-sm-9">{{ $teamMember->role }}</div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Statut:</strong></div>
                                    <div class="col-sm-9">
                                        @if($teamMember->is_active)
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-secondary">Inactif</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Date de création:</strong></div>
                                    <div class="col-sm-9">{{ $teamMember->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Dernière mise à jour:</strong></div>
                                    <div class="col-sm-9">{{ $teamMember->updated_at->format('d/m/Y H:i') }}</div>
                                </div>
                                
                                <h5 class="mt-4">Biographie</h5>
                                <hr>
                                <p>{!! nl2br(e($teamMember->bio)) !!}</p>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ route('admin.team_members.edit', $teamMember) }}" class="btn btn-warning">Modifier</a>
                            
                            <form action="{{ route('admin.team_members.destroy', $teamMember) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce membre de l\'équipe?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection