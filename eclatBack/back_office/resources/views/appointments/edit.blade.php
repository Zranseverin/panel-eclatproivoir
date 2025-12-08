@extends('layouts.admin')

@section('title', 'Modifier un Rendez-vous')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Modifier un Rendez-vous</h5>
                    <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary btn-sm">Retour aux Rendez-vous</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="service_type" class="form-label">Type de Service *</label>
                                <input type="text" class="form-control" id="service_type" name="service_type" value="{{ old('service_type', $appointment->service_type) }}" required>
                                @error('service_type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="frequency" class="form-label">Fréquence *</label>
                                <input type="text" class="form-control" id="frequency" name="frequency" value="{{ old('frequency', $appointment->frequency) }}" required>
                                @error('frequency')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom du Client *</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $appointment->name) }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $appointment->email) }}" required>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Téléphone *</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $appointment->phone) }}" required>
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="desired_date" class="form-label">Date Souhaitée *</label>
                        <input type="date" class="form-control" id="desired_date" name="desired_date" value="{{ old('desired_date', $appointment->desired_date->format('Y-m-d')) }}" required>
                        @error('desired_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">Mettre à Jour</button>
                        <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection