@extends('layouts.admin')

@section('title', 'Gestion des Rendez-vous')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Rendez-vous</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary btn-sm">Ajouter un Rendez-vous</a>
                        <!-- Import Button -->
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="bi bi-upload"></i> Importer
                        </button>
                    </div>
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
                        <form method="GET" action="{{ route('admin.appointments.index') }}" class="row g-3">
                            <div class="col-md-4">
                                <label for="search" class="form-label">Recherche</label>
                                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Nom, email, service, téléphone...">
                            </div>
                            <div class="col-md-3">
                                <label for="start_date" class="form-label">Date de début</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="end_date" class="form-label">Date de fin</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <div class="btn-group" role="group">
                                    <button type="submit" class="btn btn-primary">Filtrer</button>
                                    <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary">Réinitialiser</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Export Button -->
                <div class="row mb-3">
                    <div class="col-12">
                        <form method="GET" action="{{ route('admin.appointments.export') }}" class="d-inline">
                            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="bi bi-download"></i> Exporter vers Excel
                            </button>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Service</th>
                                <th>Fréquence</th>
                                <th>Nom du Client</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Date Souhaitée</th>
                                <th>Date de Création</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($appointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->id }}</td>
                                    <td>{{ $appointment->service_type }}</td>
                                    <td>{{ $appointment->frequency }}</td>
                                    <td>{{ $appointment->name }}</td>
                                    <td>{{ $appointment->email }}</td>
                                    <td>{{ $appointment->phone }}</td>
                                    <td>{{ $appointment->desired_date->format('d/m/Y') }}</td>
                                    <td>{{ $appointment->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.appointments.show', $appointment) }}" class="btn btn-sm btn-info">Voir</a>
                                            <a href="{{ route('admin.appointments.edit', $appointment) }}" class="btn btn-sm btn-warning">Modifier</a>
                                            <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rendez-vous?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Aucun rendez-vous trouvé</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Importer des Rendez-vous</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.appointments.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">Fichier Excel (.xlsx, .xls, .csv)</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".xlsx,.xls,.csv" required>
                        <div class="form-text">
                            Le fichier doit contenir les colonnes suivantes : 
                            Type de Service, Fréquence, Nom du Client, Email, Date Souhaitée, Téléphone
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Importer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection