(function ($) {
    "use strict";
    
    // Dropdown on mouse hover
    $(document).ready(function () {
        function toggleNavbarMethod() {
            if ($(window).width() > 992) {
                $('.navbar .dropdown').on('mouseover', function () {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseout', function () {
                    $('.dropdown-toggle', this).trigger('click').blur();
                });
            } else {
                $('.navbar .dropdown').off('mouseover').off('mouseout');
            }
        }
        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize newsletter form if it exists
        initializeNewsletterForm();
    });

    function initializeNewsletterForm() {
        const form = document.getElementById('newsletterForm');
        if (!form) return;
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const emailInput = document.getElementById('newsletterEmail');
            const email = emailInput.value.trim();
            
            if (!email) {
                showNewsletterMessage('Veuillez entrer votre email.', 'danger');
                return;
            }
            
            // Simple email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showNewsletterMessage('Veuillez entrer un email valide.', 'danger');
                return;
            }
            
            // Submit subscription via API
            fetch('api/subscribe_newsletter.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message.includes('réussie')) {
                    showNewsletterMessage('Inscription réussie ! Merci de votre intérêt.', 'success');
                    emailInput.value = ''; // Clear the input
                } else {
                    showNewsletterMessage(data.message || 'Erreur lors de l\'inscription.', 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNewsletterMessage('Une erreur est survenue. Veuillez réessayer.', 'danger');
            });
        });
    }

    function showNewsletterMessage(message, type) {
        const messageDiv = document.getElementById('newsletterMessage');
        if (!messageDiv) return;
        
        messageDiv.className = `alert alert-${type} d-block`;
        messageDiv.textContent = message;
        
        // Auto-hide success messages after 5 seconds
        if (type === 'success') {
            setTimeout(() => {
                messageDiv.classList.add('d-none');
            }, 5000);
        }
    }

    // Date and time picker
    $('.date').datetimepicker({
        format: 'L'
    });
    $('.time').datetimepicker({
        format: 'LT'
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Price carousel
    $(window).on('load', function() {
        setTimeout(function() {
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
        }, 100);
    });

    // Team carousel
    $(window).on('load', function() {
        setTimeout(function() {
            $(".team-carousel, .related-carousel").owlCarousel({
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
                    }
                }
            });
        }, 100);
    });

    // Testimonials carousel
    $(window).on('load', function() {
        setTimeout(function() {
            $(".testimonial-carousel").owlCarousel({
                autoplay: true,
                smartSpeed: 1000,
                items: 1,
                dots: true,
                loop: true,
            });
        }, 100);
    });
    
})(jQuery);

