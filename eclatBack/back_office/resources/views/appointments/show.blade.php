@extends('layouts.admin')

@section('title', 'Détails du Rendez-vous')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Détails du Rendez-vous</h5>
                    <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary btn-sm">Retour aux Rendez-vous</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h5>Informations du Rendez-vous</h5>
                                <hr>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>ID:</strong></div>
                                    <div class="col-sm-9">{{ $appointment->id }}</div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Type de Service:</strong></div>
                                    <div class="col-sm-9">{{ $appointment->service_type }}</div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Fréquence:</strong></div>
                                    <div class="col-sm-9">{{ $appointment->frequency }}</div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Nom du Client:</strong></div>
                                    <div class="col-sm-9">{{ $appointment->name }}</div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Email:</strong></div>
                                    <div class="col-sm-9">{{ $appointment->email }}</div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Téléphone:</strong></div>
                                    <div class="col-sm-9">{{ $appointment->phone }}</div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Date Souhaitée:</strong></div>
                                    <div class="col-sm-9">{{ $appointment->desired_date->format('d/m/Y') }}</div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Date de Création:</strong></div>
                                    <div class="col-sm-9">{{ $appointment->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Dernière Mise à Jour:</strong></div>
                                    <div class="col-sm-9">{{ $appointment->updated_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ route('admin.appointments.edit', $appointment) }}" class="btn btn-warning">Modifier</a>
                            
                            <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rendez-vous?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5>Actions Rapides</h5>
                                <hr>
                                <div class="d-grid gap-2">
                                    <a href="mailto:{{ $appointment->email }}" class="btn btn-primary">Envoyer un Email</a>
                                    <a href="tel:{{ $appointment->phone }}" class="btn btn-success">Appeler</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection