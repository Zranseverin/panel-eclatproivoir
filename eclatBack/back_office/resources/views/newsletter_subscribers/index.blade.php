@extends('layouts.admin')

@section('title', 'Gestion des Abonnés Newsletter')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Abonnés Newsletter</h5>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exportModal">
                            <i class="bi bi-download"></i> Exporter
                        </button>
                        <button type="button" class="btn btn-primary btn-sm" id="openSendEmailModal" disabled>
                            <i class="bi bi-envelope"></i> Envoyer Email
                        </button>
                    </div>
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
                        <form method="GET" action="{{ route('admin.newsletter-subscribers.index') }}" class="row g-3">
                            <div class="col-md-6">
                                <label for="search" class="form-label">Recherche par email</label>
                                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Email...">
                            </div>
                            <div class="col-md-4">
                                <label for="status" class="form-label">Statut</label>
                                <select name="status" id="status" class="form-control" onchange="this.form.submit()">
                                    <option value="">Tous les statuts</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <div class="btn-group" role="group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-funnel"></i> Filtrer
                                    </button>
                                    <a href="{{ route('admin.newsletter-subscribers.index') }}" class="btn btn-secondary">
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
                                <th>
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th>#</th>
                                <th>Email</th>
                                <th>Date d'inscription</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subscribers as $subscriber)
                            <tr>
                                <td>
                                    <input type="checkbox" class="subscriber-checkbox" value="{{ $subscriber->id }}" data-email="{{ $subscriber->email }}">
                                </td>
                                <td>{{ $subscriber->id }}</td>
                                <td>{{ $subscriber->email }}</td>
                                <td>{{ $subscriber->subscribed_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($subscriber->is_active)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Actif
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle"></i> Inactif
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-success toggle-status" 
                                                data-id="{{ $subscriber->id }}" 
                                                data-status="{{ $subscriber->is_active ? 0 : 1 }}">
                                            {{ $subscriber->is_active ? 'Désactiver' : 'Activer' }}
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-subscriber" 
                                                data-id="{{ $subscriber->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Aucun abonné trouvé.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Bulk Actions -->
                <div class="row mt-3">
                    <div class="col-12">
                        <button type="button" class="btn btn-danger btn-sm" id="bulkDeleteBtn" disabled>
                            <i class="bi bi-trash"></i> Supprimer sélectionnés
                        </button>
                    </div>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $subscribers->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Send Email Modal -->
<div class="modal fade" id="sendEmailModal" tabindex="-1" aria-labelledby="sendEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendEmailModalLabel">Envoyer un email aux abonnés sélectionnés</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="sendEmailForm" action="{{ route('admin.newsletter-subscribers.send-email') }}" method="POST">
                    @csrf
                    <input type="hidden" name="subscriber_ids" id="subscriberIdsInput">
                    
                    <div class="mb-3">
                        <label for="selectedSubscribers" class="form-label">Abonnés sélectionnés:</label>
                        <div id="selectedSubscribers" class="border p-2 bg-light" style="max-height: 150px; overflow-y: auto;">
                            Aucun abonné sélectionné
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="emailSubject" class="form-label">Sujet de l'email:</label>
                        <input type="text" class="form-control" id="emailSubject" name="subject" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="emailBody" class="form-label">Contenu de l'email:</label>
                        <textarea class="form-control" id="emailBody" name="body" rows="6" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="sendEmailSubmitBtn">
                    <i class="bi bi-envelope"></i> Envoyer
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer cet abonné ? Cette action est irréversible.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<form id="toggleStatusForm" method="POST" style="display: none;">
    @csrf
    @method('PUT')
    <input type="hidden" name="is_active" id="toggleStatusValue">
</form>

<form id="deleteSubscriberForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<form id="bulkDeleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkboxes
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.subscriber-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkDeleteButton();
        updateSendEmailButton();
    });

    // Update bulk delete button state
    document.querySelectorAll('.subscriber-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBulkDeleteButton();
            updateSendEmailButton();
        });
    });

    function updateBulkDeleteButton() {
        const checkedBoxes = document.querySelectorAll('.subscriber-checkbox:checked');
        document.getElementById('bulkDeleteBtn').disabled = checkedBoxes.length === 0;
    }
    
    function updateSendEmailButton() {
        const checkedBoxes = document.querySelectorAll('.subscriber-checkbox:checked');
        document.getElementById('openSendEmailModal').disabled = checkedBoxes.length === 0;
    }

    // Open Send Email Modal
    document.getElementById('openSendEmailModal').addEventListener('click', function() {
        const checkedBoxes = document.querySelectorAll('.subscriber-checkbox:checked');
        
        if (checkedBoxes.length > 0) {
            // Update the selected subscribers list in the modal
            const selectedSubscribersDiv = document.getElementById('selectedSubscribers');
            selectedSubscribersDiv.innerHTML = '';
            
            const ids = [];
            checkedBoxes.forEach(checkbox => {
                ids.push(checkbox.value);
                const email = checkbox.getAttribute('data-email');
                const emailSpan = document.createElement('span');
                emailSpan.className = 'badge bg-primary me-1 mb-1';
                emailSpan.textContent = email;
                selectedSubscribersDiv.appendChild(emailSpan);
            });
            
            // Set the hidden input value
            document.getElementById('subscriberIdsInput').value = ids.join(',');
            
            // Show the modal using Bootstrap's native method
            try {
                const sendEmailModal = new bootstrap.Modal(document.getElementById('sendEmailModal'));
                sendEmailModal.show();
            } catch (error) {
                // Fallback: manually show the modal
                const modalElement = document.getElementById('sendEmailModal');
                modalElement.style.display = 'block';
                modalElement.classList.add('show');
                document.body.classList.add('modal-open');
                
                // Add close functionality
                const closeButtons = modalElement.querySelectorAll('[data-bs-dismiss="modal"]');
                closeButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        modalElement.style.display = 'none';
                        modalElement.classList.remove('show');
                        document.body.classList.remove('modal-open');
                    });
                });
            }
        } else {
            alert('Veuillez sélectionner au moins un abonné.');
        }
    });

    // Toggle subscriber status
    document.querySelectorAll('.toggle-status').forEach(button => {
        button.addEventListener('click', function() {
            const subscriberId = this.getAttribute('data-id');
            const newStatus = this.getAttribute('data-status');
            
            const form = document.getElementById('toggleStatusForm');
            form.action = `/admin/newsletter-subscribers/${subscriberId}`;
            document.getElementById('toggleStatusValue').value = newStatus;
            form.submit();
        });
    });

    // Delete subscriber
    let deleteSubscriberId = null;
    document.querySelectorAll('.delete-subscriber').forEach(button => {
        button.addEventListener('click', function() {
            deleteSubscriberId = this.getAttribute('data-id');
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (deleteSubscriberId) {
            const form = document.getElementById('deleteSubscriberForm');
            form.action = `/admin/newsletter-subscribers/${deleteSubscriberId}`;
            form.submit();
        }
    });

    // Bulk delete
    document.getElementById('bulkDeleteBtn').addEventListener('click', function() {
        const checkedBoxes = document.querySelectorAll('.subscriber-checkbox:checked');
        if (checkedBoxes.length > 0) {
            const ids = Array.from(checkedBoxes).map(checkbox => checkbox.value);
            
            const form = document.getElementById('bulkDeleteForm');
            form.action = "{{ route('admin.newsletter-subscribers.bulk-delete') }}";
            
            // Clear previous inputs
            while (form.firstChild) {
                form.removeChild(form.firstChild);
            }
            
            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);
            
            // Add method
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);
            
            // Add IDs
            ids.forEach(id => {
                const idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = 'ids[]';
                idInput.value = id;
                form.appendChild(idInput);
            });
            
            form.submit();
        }
    });

    // Submit email form
    document.getElementById('sendEmailSubmitBtn').addEventListener('click', function() {
        const subject = document.getElementById('emailSubject').value.trim();
        const body = document.getElementById('emailBody').value.trim();
        
        if (subject === '' || body === '') {
            alert('Veuillez remplir tous les champs obligatoires.');
            return;
        }
        
        // Show loading state
        const submitBtn = this;
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Envoi...';
        submitBtn.disabled = true;
        
        // Submit form
        document.getElementById('sendEmailForm').submit();
    });
});
</script>
@endsection