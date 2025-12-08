<?php
require_once 'partiels/head.php';
require_once 'partiels/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php require_once 'partiels/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 text-success"><i class="fas fa-image me-2"></i>Configuration du Logo</h1>
            </div>

            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="card eco-card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Modifier le Logo</h5>
                        </div>
                        <div class="card-body">
                            <form id="logoConfigForm">
                                <div class="mb-3">
                                    <label for="logoPath" class="form-label text-success">Chemin du Logo</label>
                                    <input type="text" class="form-control" id="logoPath" placeholder="img/logo.jpg" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="altText" class="form-label text-success">Texte Alternatif</label>
                                    <input type="text" class="form-control" id="altText" placeholder="EclatPro Logo">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label text-success">Aperçu du Logo</label>
                                    <div class="border rounded p-3 text-center">
                                        <img id="logoPreview" src="" alt="Logo Preview" class="img-fluid" style="max-height: 100px;">
                                        <p class="mt-2 mb-0 text-muted" id="logoAltText"></p>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-2"></i>Enregistrer les Modifications
                                </button>
                            </form>
                            
                            <div id="message" class="mt-3"></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-4">
                    <div class="card eco-card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Instructions</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Téléchargez votre logo dans le dossier <code>img/</code>
                                </li>
                                <li class="list-group-item">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Utilisez un format PNG, JPG ou SVG pour de meilleurs résultats
                                </li>
                                <li class="list-group-item">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    La taille recommandée est de 200x100 pixels
                                </li>
                                <li class="list-group-item">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Le texte alternatif est important pour l'accessibilité
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    fetchLogoConfig();
    initializeLogoForm();
});

function fetchLogoConfig() {
    fetch('api/get_logo_config.php')
        .then(response => response.json())
        .then(data => {
            if (data.logo_path) {
                document.getElementById('logoPath').value = data.logo_path;
                document.getElementById('altText').value = data.alt_text || 'Logo';
                updateLogoPreview(data.logo_path, data.alt_text || 'Logo');
            }
        })
        .catch(error => {
            console.error('Error fetching logo config:', error);
        });
}

function updateLogoPreview(path, alt) {
    const preview = document.getElementById('logoPreview');
    const altText = document.getElementById('logoAltText');
    
    if (preview && altText) {
        preview.src = path;
        preview.onerror = function() {
            this.src = 'img/logo.jpg'; // Fallback to default logo
        };
        altText.textContent = alt;
    }
}

function initializeLogoForm() {
    const form = document.getElementById('logoConfigForm');
    if (!form) return;
    
    // Update preview when inputs change
    document.getElementById('logoPath').addEventListener('input', function() {
        const path = this.value;
        const alt = document.getElementById('altText').value || 'Logo';
        updateLogoPreview(path, alt);
    });
    
    document.getElementById('altText').addEventListener('input', function() {
        const path = document.getElementById('logoPath').value;
        const alt = this.value || 'Logo';
        updateLogoPreview(path, alt);
        document.getElementById('logoAltText').textContent = alt;
    });
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const logoPath = document.getElementById('logoPath').value.trim();
        const altText = document.getElementById('altText').value.trim() || 'Logo';
        
        if (!logoPath) {
            showMessage('Veuillez entrer le chemin du logo.', 'danger');
            return;
        }
        
        // Submit update via API
        fetch('api/update_logo_config.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                logo_path: logoPath,
                alt_text: altText
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message.includes('succès')) {
                showMessage('Configuration du logo mise à jour avec succès.', 'success');
                updateLogoPreview(logoPath, altText);
            } else {
                showMessage(data.message || 'Erreur lors de la mise à jour.', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Une erreur est survenue. Veuillez réessayer.', 'danger');
        });
    });
}

function showMessage(message, type) {
    const messageDiv = document.getElementById('message');
    if (!messageDiv) return;
    
    messageDiv.className = `alert alert-${type}`;
    messageDiv.textContent = message;
    
    // Auto-hide success messages after 5 seconds
    if (type === 'success') {
        setTimeout(() => {
            messageDiv.classList.remove('alert-success');
            messageDiv.classList.add('d-none');
        }, 5000);
    }
}
</script>

<?php require_once 'partiels/footer.php'; ?>