document.addEventListener('DOMContentLoaded', function() {
    fetchHeroContent();
});

function fetchHeroContent() {
    fetch('api/get_hero_content.php')
        .then(response => response.json())
        .then(data => {
            if (data.id) {
                updateHeroSection(data);
            }
        })
        .catch(error => {
            console.error('Error fetching hero content:', error);
        });
}

function updateHeroSection(heroContent) {
    const heroSection = document.querySelector('.hero-header');
    if (!heroSection) return;
    
    // Update the headline
    const headlineElement = heroSection.querySelector('h1.display-1');
    if (headlineElement) {
        headlineElement.textContent = heroContent.headline;
    }
    
    // Update the subheading
    const subheadingElement = heroSection.querySelector('h5');
    if (subheadingElement) {
        subheadingElement.innerHTML = heroContent.subheading;
    }
    
    // Update primary button
    const primaryButton = heroSection.querySelector('a.btn-light');
    if (primaryButton) {
        primaryButton.textContent = heroContent.primary_button_text;
        primaryButton.href = heroContent.primary_button_link;
    }
    
    // Update secondary button
    const secondaryButton = heroSection.querySelector('a.btn-outline-light');
    if (secondaryButton) {
        secondaryButton.textContent = heroContent.secondary_button_text;
        secondaryButton.href = heroContent.secondary_button_link;
    }
    
    // Update background image if provided with fixed sizing
    if (heroContent.background_image_url) {
        heroSection.style.backgroundImage = `url('${heroContent.background_image_url}')`;
        heroSection.style.backgroundSize = 'cover'; // Cover the container
        heroSection.style.backgroundPosition = 'center'; // Center the image
        heroSection.style.backgroundRepeat = 'no-repeat'; // No repetition
        heroSection.style.minHeight = '500px'; // Fixed minimum height
    }
    
    // Update background color if provided (fallback if no image)
    if (heroContent.background_color && !heroContent.background_image_url) {
        heroSection.style.backgroundColor = heroContent.background_color;
        heroSection.style.minHeight = '500px'; // Fixed minimum height
    }
    
    // Update text color if provided
    if (heroContent.text_color) {
        const textElements = heroSection.querySelectorAll('h1, h5, a');
        textElements.forEach(element => {
            element.style.color = heroContent.text_color;
        });
    }
}