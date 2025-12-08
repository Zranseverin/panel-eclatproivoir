@extends('layouts.admin')

@section('title', 'Détails du Témoignage')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Détails du Témoignage</h5>
                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary btn-sm">Retour aux Témoignages</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                @if($testimonial->client_image_url)
                                    <img src="{{ $testimonial->client_image_url }}" alt="{{ $testimonial->client_name }}" class="img-fluid rounded" style="max-height: 300px;">
                                @else
                                    <div class="bg-light p-5 rounded">
                                        <i class="bi bi-person-circle" style="font-size: 5rem;"></i>
                                    </div>
                                @endif
                                <h5 class="mt-3">{{ $testimonial->client_name }}</h5>
                                @if($testimonial->client_position)
                                    <p class="text-muted">{{ $testimonial->client_position }}</p>
                                @endif
                                @if($testimonial->company)
                                    <p class="text-muted">{{ $testimonial->company }}</p>
                                @endif
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
                                    <div class="col-sm-9">{{ $testimonial->id }}</div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Nom du Client:</strong></div>
                                    <div class="col-sm-9">{{ $testimonial->client_name }}</div>
                                </div>
                                
                                @if($testimonial->client_position)
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Poste:</strong></div>
                                    <div class="col-sm-9">{{ $testimonial->client_position }}</div>
                                </div>
                                @endif
                                
                                @if($testimonial->company)
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Entreprise:</strong></div>
                                    <div class="col-sm-9">{{ $testimonial->company }}</div>
                                </div>
                                @endif
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Note:</strong></div>
                                    <div class="col-sm-9">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $testimonial->rating)
                                                <i class="bi bi-star-fill text-warning"></i>
                                            @else
                                                <i class="bi bi-star text-muted"></i>
                                            @endif
                                        @endfor
                                        <span class="ms-1">({{ $testimonial->rating }}/5)</span>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Statut:</strong></div>
                                    <div class="col-sm-9">
                                        @if($testimonial->is_active)
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-secondary">Inactif</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Date de création:</strong></div>
                                    <div class="col-sm-9">{{ $testimonial->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Dernière mise à jour:</strong></div>
                                    <div class="col-sm-9">{{ $testimonial->updated_at->format('d/m/Y H:i') }}</div>
                                </div>
                                
                                <h5 class="mt-4">Témoignage</h5>
                                <hr>
                                <p>{!! nl2br(e($testimonial->testimonial_text)) !!}</p>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-warning">Modifier</a>
                            
                            <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce témoignage?')">
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