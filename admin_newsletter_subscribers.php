<?php
require_once 'partiels/head.php';
require_once 'partiels/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php require_once 'partiels/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 text-success"><i class="fas fa-envelope me-2"></i>Abonnés à la Newsletter</h1>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card eco-card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-users me-2"></i>Liste des abonnés</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-success">
                                        <tr>
                                            <th>ID</th>
                                            <th>Email</th>
                                            <th>Date d'inscription</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="subscribersTableBody">
                                        <!-- Subscribers will be loaded here via JavaScript -->
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
    fetchNewsletterSubscribers();
});

function fetchNewsletterSubscribers() {
    fetch('api/get_newsletter_subscribers.php')
        .then(response => response.json())
        .then(data => {
            if (data.records && data.records.length > 0) {
                updateSubscribersTable(data.records);
            } else {
                document.getElementById('subscribersTableBody').innerHTML = '<tr><td colspan="5" class="text-center">Aucun abonné trouvé</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error fetching newsletter subscribers:', error);
            document.getElementById('subscribersTableBody').innerHTML = '<tr><td colspan="5" class="text-center">Erreur lors du chargement des abonnés</td></tr>';
        });
}

function updateSubscribersTable(subscribers) {
    const tableBody = document.getElementById('subscribersTableBody');
    if (!tableBody) return;
    
    // Clear existing content
    tableBody.innerHTML = '';
    
    // Add subscribers to table
    subscribers.forEach(subscriber => {
        const row = `
            <tr>
                <td>${subscriber.id}</td>
                <td>${subscriber.email}</td>
                <td>${new Date(subscriber.subscribed_at).toLocaleDateString('fr-FR')}</td>
                <td>
                    <span class="badge bg-success">Actif</span>
                </td>
                <td>
                    <button class="btn btn-sm btn-outline-danger" onclick="unsubscribe('${subscriber.email}')">
                        <i class="fas fa-unsubscribe"></i> Désinscrire
                    </button>
                </td>
            </tr>
        `;
        tableBody.insertAdjacentHTML('beforeend', row);
    });
}

function unsubscribe(email) {
    if (confirm('Êtes-vous sûr de vouloir désinscrire cet email ?')) {
        // In a real implementation, you would call an API to unsubscribe
        alert('Fonction de désinscription - à implémenter');
    }
}
</script>

<?php require_once 'partiels/footer.php'; ?>