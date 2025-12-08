 <!-- Navbar Start -->
    <div class="container-fluid sticky-top bg-white shadow-sm">
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0">
                <a href="index.php" class="navbar-brand" id="logoLink">
                    <?php
                    // Default logo path as fallback
                    $defaultLogoPath = 'http://127.0.0.1:8000/storage/logos/iZABrj5awcNfNW5bj8pKHJ65hofQcSUfx1ho0iWh.png';
                    
                    // Try to get logo from API
                    $apiUrl = 'http://localhost/ivoirPro/api/get_logo_config.php';
                    
                    // Use cURL for more reliable fetching
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $apiUrl);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                    $logoData = curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                    
                    // Check if the request was successful
                    if ($logoData !== false && $httpCode == 200) {
                        $logoConfig = json_decode($logoData, true);
                        if (isset($logoConfig['logo_url']) && !empty($logoConfig['logo_url'])) {
                            $defaultLogoPath = $logoConfig['logo_url'];
                        }
                    }
                    ?>
                    <img src="<?php echo $defaultLogoPath; ?>" alt="EclatPro Logo" class="img-fluid" style="max-height: 50px; width: auto;" id="logoImage">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="index.php" class="nav-item nav-link active">Accueil</a>
                        <a href="#!" class="nav-item nav-link">À Propos</a>
                        <a href="#services" class="nav-item nav-link">Services</a>
                        <a href="#!" class="nav-item nav-link">Formules</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu m-0">
                                <a href="#!" class="dropdown-item">Actualités</a>
                                <a href="#!" class="dropdown-item">Détails Actualités</a>
                                <a href="#!" class="dropdown-item">Notre Équipe</a>
                                <a href="#!" class="dropdown-item">Témoignages</a>
                                <a href="#!" class="dropdown-item">Devis</a>
                                <a href="#!" class="dropdown-item">Recherche</a>
                                <a href="recruitment.php" class="dropdown-item">Recrutement</a>
                            </div>
                        </div>
                        <a href="#!" class="nav-item nav-link">Contact</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->
<script>
// Load logo configuration dynamically
document.addEventListener('DOMContentLoaded', function() {
    fetchLogoConfiguration();
});

function fetchLogoConfiguration() {
    // Only run this on pages that have the logo elements
    const logoImage = document.getElementById('logoImage');
    const logoLink = document.getElementById('logoLink');
    
    if (!logoImage || !logoLink) return;
    
    // Use absolute path to ensure it works from any page
    fetch('/ivoirPro/api/get_logo_config.php')
        .then(response => response.json())
        .then(data => {
            if (data.logo_url) {
                logoImage.src = data.logo_url;
                logoImage.alt = data.alt_text || 'Logo';
            }
        })
        .catch(error => {
            console.error('Error loading logo configuration:', error);
            // Fallback to default logo is already handled by PHP
        });
}
</script>