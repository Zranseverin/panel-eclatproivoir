@extends('layouts.admin')

@section('title', 'Détails de la Candidature')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Détails de la Candidature</h5>
                    <a href="{{ route('admin.job-applications.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Retour à la liste
                </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th>ID:</th>
                                <td>{{ $jobApplication->id }}</td>
                            </tr>
                            <tr>
                                <th>Civilité:</th>
                                <td>{{ $jobApplication->civilite }}</td>
                            </tr>
                            <tr>
                                <th>Nom Complet:</th>
                                <td>{{ $jobApplication->nom_complet }}</td>
                            </tr>
                            <tr>
                                <th>Téléphone:</th>
                                <td>{{ $jobApplication->telephone }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $jobApplication->email }}</td>
                            </tr>
                            <tr>
                                <th>Adresse:</th>
                                <td>{{ $jobApplication->adresse }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th>Poste:</th>
                                <td>{{ $jobApplication->poste }}</td>
                            </tr>
                            <tr>
                                <th>CV:</th>
                                <td>
                                    @if($jobApplication->cv_path)
                                        @php
                                            $cvFullPath = storage_path('app/public/' . $jobApplication->cv_path);
                                            $cvExists = file_exists($cvFullPath);
                                            $cvExtension = $cvExists ? strtolower(pathinfo($jobApplication->cv_path, PATHINFO_EXTENSION)) : '';
                                        @endphp
                                        @if($cvExists && in_array($cvExtension, ['pdf']))
                                            <div class="mb-2">
                                                <iframe src="{{ Storage::url($jobApplication->cv_path) }}" width="100%" height="300px"></iframe>
                                            </div>
                                        @elseif(!$cvExists)
                                            <div class="alert alert-warning">Fichier CV introuvable</div>
                                        @endif
                                        <a href="{{ route('admin.job-applications.download-cv', $jobApplication) }}" class="btn btn-sm btn-info" target="_blank">
                                        <i class="bi bi-download"></i> Télécharger le CV
                                    </a>
                                    @else
                                        <span>Non fourni</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Lettre de Motivation:</th>
                                <td>
                                    @if($jobApplication->lettre_motivation_path)
                                        @php
                                            $letterFullPath = storage_path('app/public/' . $jobApplication->lettre_motivation_path);
                                            $letterExists = file_exists($letterFullPath);
                                            $letterExtension = $letterExists ? strtolower(pathinfo($jobApplication->lettre_motivation_path, PATHINFO_EXTENSION)) : '';
                                        @endphp
                                        @if($letterExists && in_array($letterExtension, ['pdf']))
                                            <div class="mb-2">
                                                <iframe src="{{ Storage::url($jobApplication->lettre_motivation_path) }}" width="100%" height="300px"></iframe>
                                            </div>
                                        @elseif(!$letterExists)
                                            <div class="alert alert-warning">Fichier lettre de motivation introuvable</div>
                                        @endif
                                        <a href="{{ route('admin.job-applications.download-lettre-motivation', $jobApplication) }}" class="btn btn-sm btn-info" target="_blank">
                                        <i class="bi bi-download"></i> Télécharger la lettre
                                    </a>
                                    @else
                                        <span>Non fournie</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Date de Soumission:</th>
                                <td>{{ $jobApplication->submitted_at ? $jobApplication->submitted_at->format('d/m/Y H:i') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Statut:</th>
                                <td>
                                    @if($jobApplication->status == 'pending')
                                        <span class="badge bg-warning">
                                            <i class="bi bi-clock-history"></i> En attente
                                        </span>
                                    @elseif($jobApplication->status == 'reviewed')
                                        <span class="badge bg-info">
                                            <i class="bi bi-eye"></i> Revu
                                        </span>
                                    @elseif($jobApplication->status == 'accepted')
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Accepté
                                        </span>
                                    @elseif($jobApplication->status == 'rejected')
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle"></i> Rejeté
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Date de Création:</th>
                                <td>{{ $jobApplication->created_at ? $jobApplication->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Dernière Modification:</th>
                                <td>{{ $jobApplication->updated_at ? $jobApplication->updated_at->format('d/m/Y H:i') : 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.job-applications.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Retour à la liste
                </a>
                <div>
                    <!-- Action Buttons -->
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $jobApplication->id }}">
                        <i class="bi bi-eye"></i> Revu
                    </button>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#acceptModal{{ $jobApplication->id }}">
                        <i class="bi bi-check-circle"></i> Accepter
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $jobApplication->id }}">
                        <i class="bi bi-x-circle"></i> Rejeter
                    </button>
                    
                    <a href="{{ route('admin.job-applications.edit', $jobApplication) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Modifier
                    </a>
                    <form action="{{ route('admin.job-applications.destroy', $jobApplication) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette candidature?')">
                            <i class="bi bi-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
                </div>
                
                <!-- Review Modal -->
                <div class="modal fade" id="reviewModal{{ $jobApplication->id }}" tabindex="-1" aria-labelledby="reviewModalLabel{{ $jobApplication->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="reviewModalLabel{{ $jobApplication->id }}">Marquer comme revu</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.job-applications.update-status', $jobApplication) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="modal-body">
                                    <input type="hidden" name="status" value="reviewed">
                                    <p>Êtes-vous sûr de vouloir marquer cette candidature comme revue ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-warning">Marquer comme revu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Accept Modal -->
                <div class="modal fade" id="acceptModal{{ $jobApplication->id }}" tabindex="-1" aria-labelledby="acceptModalLabel{{ $jobApplication->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="acceptModalLabel{{ $jobApplication->id }}">Accepter la candidature</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.job-applications.update-status', $jobApplication) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="modal-body">
                                    <input type="hidden" name="status" value="accepted">
                                    <div class="mb-3">
                                        <label for="interview_date" class="form-label">Date de l'entretien</label>
                                        <input type="datetime-local" class="form-control" id="interview_date" name="interview_date" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="accept_message" class="form-label">Message personnalisé (optionnel)</label>
                                        <textarea class="form-control" id="accept_message" name="accept_message" rows="3" placeholder="Un message personnalisé à envoyer au candidat..."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-success">Envoyer l'invitation</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Reject Modal -->
                <div class="modal fade" id="rejectModal{{ $jobApplication->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $jobApplication->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="rejectModalLabel{{ $jobApplication->id }}">Rejeter la candidature</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.job-applications.update-status', $jobApplication) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="modal-body">
                                    <input type="hidden" name="status" value="rejected">
                                    <div class="mb-3">
                                        <label for="reject_reason" class="form-label">Motif du rejet <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="reject_reason" name="reject_reason" rows="4" required placeholder="Expliquez pourquoi la candidature est rejetée..."></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="reject_message" class="form-label">Message personnalisé (optionnel)</label>
                                        <textarea class="form-control" id="reject_message" name="reject_message" rows="3" placeholder="Un message personnalisé à envoyer au candidat..."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-danger">Envoyer le rejet</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection