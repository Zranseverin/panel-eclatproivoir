@extends('layouts.admin')

@section('title', 'Gestion des Témoignages')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Témoignages</h5>
                    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary btn-sm">Ajouter un Témoignage</a>
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
                                <th>Client</th>
                                <th>Entreprise</th>
                                <th>Note</th>
                                <th>Image</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($testimonials as $testimonial)
                                <tr>
                                    <td>{{ $testimonial->id }}</td>
                                    <td>
                                        <strong>{{ $testimonial->client_name }}</strong>
                                        @if($testimonial->client_position)
                                            <br><small class="text-muted">{{ $testimonial->client_position }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $testimonial->company ?? 'N/A' }}</td>
                                    <td>
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $testimonial->rating)
                                                <i class="bi bi-star-fill text-warning"></i>
                                            @else
                                                <i class="bi bi-star text-muted"></i>
                                            @endif
                                        @endfor
                                        <span class="ms-1">({{ $testimonial->rating }}/5)</span>
                                    </td>
                                    <td>
                                        @if($testimonial->client_image_url)
                                            <img src="{{ $testimonial->client_image_url }}" alt="{{ $testimonial->client_name }}" style="max-height: 50px; max-width: 50px;">
                                        @else
                                            <span>Aucune image</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($testimonial->is_active)
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-secondary">Inactif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.testimonials.show', $testimonial) }}" class="btn btn-sm btn-info">Voir</a>
                                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-sm btn-warning">Modifier</a>
                                            <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce témoignage?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Aucun témoignage trouvé</td>
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