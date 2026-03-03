@extends('layouts.admin')

@section('title', 'Configuration Email')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Configuration Email</h5>
                    <a href="{{ route('admin.email-configs.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Nouvelle Configuration
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
                                <th>Hôte SMTP</th>
                                <th>Nom d'utilisateur</th>
                                <th>Adresse Expéditeur</th>
                                <th>Nom Expéditeur</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($emailConfigs as $config)
                            <tr>
                                <td>{{ $config->id }}</td>
                                <td>{{ $config->host }}:{{ $config->port }}</td>
                                <td>{{ $config->username }}</td>
                                <td>{{ $config->from_address }}</td>
                                <td>{{ $config->from_name }}</td>
                                <td>
                                    <a href="{{ route('admin.email-configs.edit', $config) }}" class="btn btn-sm btn-warning" title="Modifier">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </a>
                                    <form action="{{ route('admin.email-configs.destroy', $config) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette configuration ?')">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Aucune configuration email trouvée.</td>
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