@extends('layouts.admin')

@section('title', 'Modifier la Configuration Email')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Modifier la Configuration Email</h5>
                    <a href="{{ route('admin.email-configs.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Retour à la liste
                </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.email-configs.update', $emailConfig) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="host" class="form-label">Hôte SMTP *</label>
                            <input type="text" class="form-control @error('host') is-invalid @enderror" 
                                   id="host" name="host" value="{{ old('host', $emailConfig->host) }}" required>
                            @error('host')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="port" class="form-label">Port SMTP *</label>
                            <input type="number" class="form-control @error('port') is-invalid @enderror" 
                                   id="port" name="port" value="{{ old('port', $emailConfig->port) }}" required>
                            @error('port')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="username" class="form-label">Nom d'utilisateur SMTP *</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                   id="username" name="username" value="{{ old('username', $emailConfig->username) }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="password" class="form-label">Mot de passe SMTP *</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" value="{{ old('password', $emailConfig->password) }}" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="encryption" class="form-label">Chiffrement SMTP *</label>
                            <select class="form-select @error('encryption') is-invalid @enderror" 
                                    id="encryption" name="encryption" required>
                                <option value="tls" {{ old('encryption', $emailConfig->encryption) == 'tls' ? 'selected' : '' }}>TLS</option>
                                <option value="ssl" {{ old('encryption', $emailConfig->encryption) == 'ssl' ? 'selected' : '' }}>SSL</option>
                            </select>
                            @error('encryption')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="from_address" class="form-label">Adresse Email Expéditeur *</label>
                            <input type="email" class="form-control @error('from_address') is-invalid @enderror" 
                                   id="from_address" name="from_address" value="{{ old('from_address', $emailConfig->from_address) }}" required>
                            @error('from_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="from_name" class="form-label">Nom Expéditeur *</label>
                            <input type="text" class="form-control @error('from_name') is-invalid @enderror" 
                                   id="from_name" name="from_name" value="{{ old('from_name', $emailConfig->from_name) }}" required>
                            @error('from_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.email-configs.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Annuler
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