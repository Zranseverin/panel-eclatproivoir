@extends('layouts.admin')

@section('title', 'Gestion des Services')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Services</h5>
                    <a href="{{ route('admin.services.create') }}" class="btn btn-primary btn-sm">Ajouter un Service</a>
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
                                <th>Icône</th>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $service)
                                <tr>
                                    <td>{{ $service->id }}</td>
                                    <td>
                                        <i class="{{ $service->icon_class }}"></i>
                                        <span class="d-block small">{{ $service->icon_class }}</span>
                                    </td>
                                    <td>{{ $service->title }}</td>
                                    <td>{{ Str::limit($service->description, 100) }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.services.show', $service) }}" class="btn btn-sm btn-info">Voir</a>
                                            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-warning">Modifier</a>
                                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce service?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Aucun service trouvé</td>
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