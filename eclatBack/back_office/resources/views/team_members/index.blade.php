@extends('layouts.admin')

@section('title', 'Gestion des Membres de l\'Équipe')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Membres de l'Équipe</h5>
                    <a href="{{ route('admin.team_members.create') }}" class="btn btn-primary btn-sm">Ajouter un Membre</a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Rôle</th>
                                <th>Image</th>
                                <th>Réseaux Sociaux</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teamMembers as $member)
                                <tr>
                                    <td>{{ $member->id }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->role }}</td>
                                    <td>
                                        @if($member->image_url)
                                            <img src="{{ $member->image_url }}" alt="{{ $member->name }}" style="max-height: 50px; max-width: 100px;">
                                        @else
                                            <span>Aucune image</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            @if($member->twitter_url)
                                                <a href="{{ $member->twitter_url }}" target="_blank" class="text-info">
                                                    <i class="bi bi-twitter"></i>
                                                </a>
                                            @endif
                                            @if($member->facebook_url)
                                                <a href="{{ $member->facebook_url }}" target="_blank" class="text-primary">
                                                    <i class="bi bi-facebook"></i>
                                                </a>
                                            @endif
                                            @if($member->linkedin_url)
                                                <a href="{{ $member->linkedin_url }}" target="_blank" class="text-primary">
                                                    <i class="bi bi-linkedin"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($member->is_active)
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-secondary">Inactif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.team_members.show', $member) }}" class="btn btn-sm btn-info">Voir</a>
                                            <a href="{{ route('admin.team_members.edit', $member) }}" class="btn btn-sm btn-warning">Modifier</a>
                                            <form action="{{ route('admin.team_members.destroy', $member) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce membre de l\'équipe?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Aucun membre d'équipe trouvé</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection