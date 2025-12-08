document.addEventListener('DOMContentLoaded', function() {
    // Handle appointment form submission
    const appointmentForm = document.querySelector('#appointmentForm');
    if (appointmentForm) {
        appointmentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(appointmentForm);
            const appointmentData = {
                service_type: formData.get('service_type'),
                frequency: formData.get('frequency'),
                name: formData.get('name'),
                email: formData.get('email'),
                desired_date: formData.get('desired_date'),
                phone: formData.get('phone')
            };
            
            // Send data to API
            fetch('api/create_appointment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(appointmentData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Appointment was created.') {
                    alert('Votre demande de devis a été envoyée avec succès!');
                    appointmentForm.reset();
                } else {
                    alert('Erreur lors de l\'envoi de votre demande. Veuillez réessayer.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur s\'est produite. Veuillez réessayer.');
            });
        });
    }
});