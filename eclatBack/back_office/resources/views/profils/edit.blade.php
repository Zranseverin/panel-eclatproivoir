@extends('layouts.admin')

@section('title', 'Mon Profil')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Modifier mon profil</h5>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nom_complet" class="form-label">Nom complet</label>
                            <input type="text" class="form-control" id="nom_complet" name="nom_complet" value="{{ old('nom_complet', $admin->nom_complet) }}" required>
                            @error('nom_complet')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="numero" class="form-label">Numéro de téléphone</label>
                            <input type="text" class="form-control" id="numero" name="numero" value="{{ old('numero', $admin->numero) }}" required>
                            @error('numero')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $admin->email) }}" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="photo" class="form-label">Photo de profil</label>
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                            @error('photo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            
                            @if($admin->photo)
                                <div class="mt-2">
                                    <img src="{{ asset($admin->photo) }}" alt="Photo de profil" class="img-thumbnail" width="100">
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        <a href="{{ route('admin.profile.password') }}" class="btn btn-outline-secondary">Changer le mot de passe</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection