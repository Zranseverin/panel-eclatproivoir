@extends('layouts.admin')

@section('title', 'Gestion des Candidatures')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Summary Cards -->
        <div class="row mb-4">
            <!-- Pending Applications Card -->
            <div class="col-md-3">
                <a href="{{ route('admin.job-applications.index', ['status' => 'pending']) }}" class="text-decoration-none">
                    <div class="card radius-10 border-start border-4 border-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">En attente</p>
                                    <h4 class="my-1 text-warning">{{ $pendingCount ?? 0 }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-light-warning text-warning ms-auto">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Reviewed Applications Card -->
            <div class="col-md-3">
                <a href="{{ route('admin.job-applications.index', ['status' => 'reviewed']) }}" class="text-decoration-none">
                    <div class="card radius-10 border-start border-4 border-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Revues</p>
                                    <h4 class="my-1 text-info">{{ $reviewedCount ?? 0 }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-light-info text-info ms-auto">
                                    <i class="bi bi-eye"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Accepted Applications Card -->
            <div class="col-md-3">
                <a href="{{ route('admin.job-applications.index', ['status' => 'accepted']) }}" class="text-decoration-none">
                    <div class="card radius-10 border-start border-4 border-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Acceptées</p>
                                    <h4 class="my-1 text-success">{{ $acceptedCount ?? 0 }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-light-success text-success ms-auto">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Rejected Applications Card -->
            <div class="col-md-3">
                <a href="{{ route('admin.job-applications.index', ['status' => 'rejected']) }}" class="text-decoration-none">
                    <div class="card radius-10 border-start border-4 border-danger">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Rejetées</p>
                                    <h4 class="my-1 text-danger">{{ $rejectedCount ?? 0 }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-light-danger text-danger ms-auto">
                                    <i class="bi bi-x-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Candidatures</h5>
                    <a href="{{ route('admin.job-applications.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Nouvelle Candidature
                </a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Filter Form -->
                <div class="row mb-3">
                    <div class="col-12">
                        <form method="GET" action="{{ route('admin.job-applications.index') }}" class="row g-3">
                            <div class="col-md-6">
                                <label for="search" class="form-label">Recherche</label>
                                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Nom, email, poste, téléphone...">
                            </div>
                            <div class="col-md-4">
                                <label for="status" class="form-label">Statut</label>
                                <select name="status" id="status" class="form-control" onchange="this.form.submit()">
                                    <option value="">Tous les statuts</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                                    <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Revu</option>
                                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepté</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejeté</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <div class="btn-group" role="group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-funnel"></i> Filtrer
                                    </button>
                                    <a href="{{ route('admin.job-applications.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-clockwise"></i> Réinitialiser
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Civilité</th>
                                <th>Nom Complet</th>
                                <th>Téléphone</th>
                                <th>Email</th>
                                <th>Poste</th>
                               
                                <th>Date de Soumission</th>
                                <th>Statut</th>
                                <th>Détails</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applications as $application)
                            <tr>
                                <td>{{ $application->id }}</td>
                                <td>{{ $application->civilite }}</td>
                                <td>{{ $application->nom_complet }}</td>
                                <td>{{ $application->telephone }}</td>
                                <td>{{ $application->email }}</td>
                                <td>{{ $application->poste }}</td>
                               
                                <td>{{ $application->submitted_at ? $application->submitted_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                <td>
                                    @if($application->status == 'pending')
                                        <span class="badge bg-warning">
                                            <i class="bi bi-clock-history"></i> 
                                        </span>
                                    @elseif($application->status == 'reviewed')
                                        <span class="badge bg-info">
                                            <i class="bi bi-eye"></i> 
                                        </span>
                                    @elseif($application->status == 'accepted')
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> 
                                        </span>
                                    @elseif($application->status == 'rejected')
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle"></i> 
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.job-applications.show', $application) }}" class="btn btn-sm btn-info" title="Voir détails">
                                        <i class="bi bi-eye"></i> 
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">Aucune candidature trouvée.</td>
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