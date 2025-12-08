/**
 * Logo Loader Script
 * Dynamically loads the logo image from the API endpoint
 */

document.addEventListener('DOMContentLoaded', function() {
    // Function to load logo image
    function loadLogo() {
        fetch('/ivoirPro/api/get_logo_config.php')
            .then(response => response.json())
            .then(data => {
                if (data.logo_url) {
                    const logoImage = document.getElementById('logoImage');
                    const logoLink = document.getElementById('logoLink');
                    
                    // Use the logo_url directly from the API response
                    logoImage.src = data.logo_url;
                    logoImage.alt = data.alt_text || 'EclatPro Logo';
                    
                    // Update the link if needed
                    logoLink.href = 'index.php';
                }
            })
            .catch(error => {
                console.error('Error loading logo:', error);
                // Keep the default logo if there's an error
            });
    }
    
    // Load the logo when the page loads
    loadLogo();
});