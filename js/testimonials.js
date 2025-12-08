document.addEventListener('DOMContentLoaded', function() {
    fetchTestimonials();
});

function fetchTestimonials() {
    fetch('api/get_testimonials.php')
        .then(response => response.json())
        .then(data => {
            if (data.records && data.records.length > 0) {
                updateTestimonialsSection(data.records);
            }
        })
        .catch(error => {
            console.error('Error fetching testimonials:', error);
        });
}

function updateTestimonialsSection(testimonials) {
    const testimonialsContainer = document.querySelector('.testimonial-carousel');
    if (!testimonialsContainer) return;
    
    // Destroy existing carousel if it exists
    if ($('.testimonial-carousel').hasClass('owl-carousel')) {
        $('.testimonial-carousel').owlCarousel('destroy');
    }
    
    // Clear existing content
    testimonialsContainer.innerHTML = '';
    
    // Add testimonials dynamically
    testimonials.forEach(testimonial => {
        // Generate star ratings
        let stars = '';
        for (let i = 0; i < testimonial.rating; i++) {
            stars += '<i class="fa fa-star text-warning"></i>';
        }
        
        const testimonialElement = `
            <div class="testimonial-item text-center">
                <div class="position-relative mb-5">
                    <img class="img-fluid rounded-circle mx-auto" src="${testimonial.client_image_url}" alt="${testimonial.client_name}">
                    <div class="position-absolute top-100 start-50 translate-middle d-flex align-items-center justify-content-center bg-white rounded-circle"
                        style="width: 60px; height: 60px;">
                        <i class="fa fa-quote-left fa-2x text-primary"></i>
                    </div>
                </div>
                <p class="fs-4 fw-normal">${testimonial.testimonial_text}</p>
                <hr class="w-25 mx-auto">
                <h3>${testimonial.client_name}</h3>
                <h6 class="fw-normal text-primary mb-3">${testimonial.client_position}, ${testimonial.company}</h6>
                <div class="d-flex justify-content-center">
                    ${stars}
                </div>
            </div>
        `;
        testimonialsContainer.insertAdjacentHTML('beforeend', testimonialElement);
    });
    
    // Reinitialize the carousel with the same settings as in main.js
    setTimeout(function() {
        if (typeof $('.testimonial-carousel').owlCarousel === 'function') {
            $(".testimonial-carousel").owlCarousel({
                autoplay: true,
                smartSpeed: 1000,
                items: 1,
                dots: true,
                loop: true,
            });
        }
    }, 100);
}