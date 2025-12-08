@extends('layouts.admin')

@section('title', 'Gestion des Offres d\'Emploi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Offres d'Emploi</h5>
                    <a href="{{ route('admin.job-postings.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Ajouter une offre
                    </a>
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
                                <th>Type d'emploi</th>
                                <th>Statut</th>
                                <th>Date de création</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jobPostings as $jobPosting)
                            <tr>
                                <td>{{ $jobPosting->id }}</td>
                                <td>{{ $jobPosting->title }}</td>
                                <td>{{ $jobPosting->employment_type ?? 'Non spécifié' }}</td>
                                <td>
                                    @if($jobPosting->is_active)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Actif
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle"></i> Inactif
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $jobPosting->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.job-postings.show', $jobPosting) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> Voir
                                        </a>
                                        <a href="{{ route('admin.job-postings.edit', $jobPosting) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Modifier
                                        </a>
                                        <form action="{{ route('admin.job-postings.destroy', $jobPosting) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette offre d\'emploi?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Aucune offre d'emploi trouvée.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $jobPostings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection