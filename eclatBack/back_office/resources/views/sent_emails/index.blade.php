@extends('layouts.admin')

@section('title', 'Emails Envoyés')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Emails Envoyés</h5>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Filter Form -->
                <div class="row mb-3">
                    <div class="col-12">
                        <form method="GET" action="{{ route('admin.sent-emails.index') }}" class="row g-3">
                            <div class="col-md-6">
                                <label for="search" class="form-label">Recherche</label>
                                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Destinataire, sujet...">
                            </div>
                            <div class="col-md-4">
                                <label for="status" class="form-label">Statut</label>
                                <select name="status" id="status" class="form-control" onchange="this.form.submit()">
                                    <option value="">Tous les statuts</option>
                                    <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Envoyés</option>
                                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Échoués</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <div class="btn-group" role="group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-funnel"></i> Filtrer
                                    </button>
                                    <a href="{{ route('admin.sent-emails.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-clockwise"></i> Réinitialiser
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Destinataire</th>
                                <th>Sujet</th>
                                <th>Statut</th>
                                <th>Date d'envoi</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sentEmails as $email)
                            <tr>
                                <td>{{ $email->id }}</td>
                                <td>
                                    <strong>{{ $email->to_name }}</strong><br>
                                    <small>{{ $email->to_email }}</small>
                                </td>
                                <td>{{ $email->subject }}</td>
                                <td>
                                    @if($email->status == 'sent')
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Envoyé
                                        </span>
                                    @elseif($email->status == 'failed')
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle"></i> Échoué
                                        </span>
                                    @endif
                                </td>
                                <td>{{ ($email->created_at && !is_null($email->created_at)) ? $email->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('admin.sent-emails.show', $email) }}" class="btn btn-sm btn-info" title="Voir détails">
                                        <i class="bi bi-eye"></i> Voir
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Aucun email envoyé trouvé.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $sentEmails->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection