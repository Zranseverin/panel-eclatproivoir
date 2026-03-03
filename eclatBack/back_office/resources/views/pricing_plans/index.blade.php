@extends('layouts.admin')

@section('title', 'Gestion des Plans de Tarification')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Plans de Tarification</h5>
                    <a href="{{ route('admin.pricing_plans.create') }}" class="btn btn-primary btn-sm">Ajouter un Plan</a>
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
                                <th>Titre</th>
                                <th>Sous-titre</th>
                                <th>Prix</th>
                                <th>Image</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pricingPlans as $plan)
                                <tr>
                                    <td>{{ $plan->id }}</td>
                                    <td>{{ $plan->title }}</td>
                                    <td>{{ $plan->subtitle }}</td>
                                    <td>{{ number_format($plan->price, 2, ',', ' ') }} {{ $plan->currency }}/{{ $plan->period }}</td>
                                    <td>
                                        @if($plan->image_url)
                                            <img src="{{ $plan->image_url }}" alt="{{ $plan->title }}" style="max-height: 50px; max-width: 100px;">
                                        @else
                                            <span>Aucune image</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($plan->is_active)
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-secondary">Inactif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.pricing_plans.show', $plan) }}" class="btn btn-sm btn-info">Voir</a>
                                            <a href="{{ route('admin.pricing_plans.edit', $plan) }}" class="btn btn-sm btn-warning">Modifier</a>
                                            <form action="{{ route('admin.pricing_plans.destroy', $plan) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce plan de tarification?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Aucun plan de tarification trouvé</td>
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