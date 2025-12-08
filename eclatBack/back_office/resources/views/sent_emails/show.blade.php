@extends('layouts.admin')

@section('title', 'Détails de l\'Email Envoyé')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Détails de l'Email Envoyé</h5>
                    <a href="{{ route('admin.sent-emails.index') }}" class="btn btn-secondary btn-sm">
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
                                <td>{{ $sendMail->id }}</td>
                            </tr>
                            <tr>
                                <th>Destinataire:</th>
                                <td>
                                    <strong>{{ $sendMail->to_name }}</strong><br>
                                    <small>{{ $sendMail->to_email }}</small>
                                </td>
                            </tr>
                            <tr>
                                <th>Sujet:</th>
                                <td>{{ $sendMail->subject }}</td>
                            </tr>
                            <tr>
                                <th>Statut:</th>
                                <td>
                                    @if($sendMail->status == 'sent')
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Envoyé
                                        </span>
                                    @elseif($sendMail->status == 'failed')
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle"></i> Échoué
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th>Date d'envoi:</th>
                                <td>{{ ($sendMail->created_at && !is_null($sendMail->created_at)) ? $sendMail->created_at->format('d/m/Y H:i:s') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Dernière modification:</th>
                                <td>{{ ($sendMail->updated_at && !is_null($sendMail->updated_at)) ? $sendMail->updated_at->format('d/m/Y H:i:s') : 'N/A' }}</td>
                            </tr>
                            @if($sendMail->status == 'failed')
                            <tr>
                                <th>Message d'erreur:</th>
                                <td>
                                    <div class="alert alert-danger">
                                        {{ $sendMail->error_message ?? 'Aucun message d\'erreur disponible' }}
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h6>Contenu HTML:</h6>
                        <div class="border p-3 bg-light">
                            {!! $sendMail->body ?? 'Contenu non disponible' !!}
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h6>Contenu Texte:</h6>
                        <div class="border p-3 bg-light">
                            <pre>{{ $sendMail->alt_body ?? 'Contenu non disponible' }}</pre>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.sent-emails.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Retour à la liste
                </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection