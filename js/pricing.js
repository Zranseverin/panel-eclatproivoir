document.addEventListener('DOMContentLoaded', function() {
    fetchPricingPlans();
});

function fetchPricingPlans() {
    fetch('api/get_pricing_plans.php')
        .then(response => response.json())
        .then(data => {
            if (data.records && data.records.length > 0) {
                updatePricingSection(data.records);
            }
        })
        .catch(error => {
            console.error('Error fetching pricing plans:', error);
        });
}

function updatePricingSection(plans) {
    const pricingContainer = document.querySelector('.price-carousel');
    if (!pricingContainer) return;
    
    // Destroy existing carousel if it exists
    if ($('.price-carousel').hasClass('owl-carousel')) {
        $('.price-carousel').owlCarousel('destroy');
    }
    
    // Clear existing content
    pricingContainer.innerHTML = '';
    
    // Add plans dynamically
    plans.forEach(plan => {
        const planElement = `
            <div class="bg-light rounded text-center">
                <div class="position-relative">
                    <img class="img-fluid rounded-top" src="${plan.image_url}" alt="${plan.subtitle}">
                    <div class="position-absolute w-100 h-100 top-50 start-50 translate-middle rounded-top d-flex flex-column align-items-center justify-content-center"
                        style="background: rgba(29, 42, 77, .8);">
                        <h3 class="text-white">${plan.title}</h3>
                        <h1 class="display-4 text-white mb-0">
                            <small class="align-top fw-normal"
                                style="font-size: 22px; line-height: 45px;">${plan.currency}</small>${plan.price > 0 ? plan.price : '??'}<small
                                class="align-bottom fw-normal" style="font-size: 16px; line-height: 40px;">/
                                ${plan.period}</small>
                        </h1>
                    </div>
                </div>
                <div class="text-center py-5">
                    ${plan.features.map(feature => `<p>${feature}</p>`).join('')}
                    <a href="#!" class="btn btn-primary rounded-pill py-3 px-5 my-2">${plan.cta_text}</a>
                </div>
            </div>
        `;
        pricingContainer.insertAdjacentHTML('beforeend', planElement);
    });
    
    // Reinitialize the carousel with the same settings as in main.js
    setTimeout(function() {
        if (typeof $('.price-carousel').owlCarousel === 'function') {
            $(".price-carousel").owlCarousel({
                autoplay: true,
                smartSpeed: 1000,
                margin: 45,
                dots: false,
                loop: true,
                nav : true,
                navText : [
                    '<i class="bi bi-arrow-left"></i>',
                    '<i class="bi bi-arrow-right"></i>'
                ],
                responsive: {
                    0:{
                        items:1
                    },
                    992:{
                        items:2
                    },
                    1200:{
                        items:3
                    }
                }
            });
        }
    }, 100);
}
// Pricing Carousel Enhancement
document.addEventListener('DOMContentLoaded', function() {
    // Ensure consistent card sizing after carousel initialization
    function adjustPricingCards() {
        const pricingCards = document.querySelectorAll('.price-carousel .rounded.text-center');
        
        // Reset heights
        pricingCards.forEach(card => {
            card.style.height = 'auto';
        });
        
        // Find the maximum height
        let maxHeight = 0;
        pricingCards.forEach(card => {
            const cardHeight = card.offsetHeight;
            if (cardHeight > maxHeight) {
                maxHeight = cardHeight;
            }
        });
        
        // Apply consistent height
        if (maxHeight > 0) {
            pricingCards.forEach(card => {
                card.style.height = maxHeight + 'px';
            });
        }
        
        // Ensure image containers have fixed height
        const imageContainers = document.querySelectorAll('.price-carousel .position-relative');
        imageContainers.forEach(container => {
            container.style.height = '200px';
        });
    }
    
    // Adjust card sizes after carousel initialization
    setTimeout(adjustPricingCards, 100);
    
    // Re-adjust on window resize
    window.addEventListener('resize', function() {
        setTimeout(adjustPricingCards, 100);
    });
    
    // If Owl Carousel is used, listen for its events
    if (typeof jQuery !== 'undefined' && typeof jQuery.fn.owlCarousel !== 'undefined') {
        jQuery('.price-carousel').on('initialized.owl.carousel', function() {
            setTimeout(adjustPricingCards, 100);
        });
        
        jQuery('.price-carousel').on('resized.owl.carousel', function() {
            setTimeout(adjustPricingCards, 100);
        });
        
        jQuery('.price-carousel').on('translated.owl.carousel', function() {
            setTimeout(adjustPricingCards, 100);
        });
    }
});