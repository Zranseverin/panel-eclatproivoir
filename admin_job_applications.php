<?php
require_once 'partiels/head.php';
require_once 'partiels/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php require_once 'partiels/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 text-success"><i class="fas fa-file-alt me-2"></i>Candidatures</h1>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card eco-card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Liste des candidatures</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-success">
                                        <tr>
                                            <th>ID</th>
                                            <th>Candidat</th>
                                            <th>Poste</th>
                                            <th>Email</th>
                                            <th>Téléphone</th>
                                            <th>Date</th>
                                            <th>Statut</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="applicationsTableBody">
                                        <!-- Applications will be loaded here via JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    fetchJobApplications();
});

function fetchJobApplications() {
    fetch('api/get_job_applications.php')
        .then(response => response.json())
        .then(data => {
            if (data.records && data.records.length > 0) {
                updateApplicationsTable(data.records);
            }
        })
        .catch(error => {
            console.error('Error fetching job applications:', error);
        });
}

function updateApplicationsTable(applications) {
    const tableBody = document.getElementById('applicationsTableBody');
    if (!tableBody) return;
    
    // Clear existing content
    tableBody.innerHTML = '';
    
    // Add applications to table
    applications.forEach(app => {
        const row = `
            <tr>
                <td>${app.id}</td>
                <td>${app.civilite} ${app.nom_complet}</td>
                <td>${app.poste}</td>
                <td>${app.email}</td>
                <td>${app.telephone}</td>
                <td>${new Date(app.submitted_at).toLocaleDateString('fr-FR')}</td>
                <td>
                    <span class="badge bg-${getStatusClass(app.status)}">${app.status}</span>
                </td>
                <td>
                    <button class="btn btn-sm btn-outline-success me-1" onclick="updateStatus(${app.id}, 'reviewed')">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-primary me-1" onclick="updateStatus(${app.id}, 'accepted')">
                        <i class="fas fa-check"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="updateStatus(${app.id}, 'rejected')">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            </tr>
        `;
        tableBody.insertAdjacentHTML('beforeend', row);
    });
}

function getStatusClass(status) {
    switch(status) {
        case 'pending': return 'warning';
        case 'reviewed': return 'info';
        case 'accepted': return 'success';
        case 'rejected': return 'danger';
        default: return 'secondary';
    }
}

function updateStatus(id, status) {
    fetch('api/update_job_application_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: id,
            status: status
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.message.includes('succès')) {
            // Refresh the table
            fetchJobApplications();
        } else {
            alert('Erreur lors de la mise à jour du statut.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Une erreur est survenue.');
    });
}
</script>

<?php require_once 'partiels/footer.php'; ?>