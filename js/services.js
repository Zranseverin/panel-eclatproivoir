document.addEventListener('DOMContentLoaded', function() {
    fetchServices();
});

function fetchServices() {
    fetch('api/get_services.php')
        .then(response => response.json())
        .then(data => {
            if (data.records && data.records.length > 0) {
                updateServicesSection(data.records);
            }
        })
        .catch(error => {
            console.error('Error fetching services:', error);
        });
}

function updateServicesSection(services) {
    const servicesContainer = document.querySelector('#services .row');
    if (!servicesContainer) return;
    
    // Clear existing content
    servicesContainer.innerHTML = '';
    
    // Add services dynamically
    services.forEach(service => {
        const serviceElement = `
            <div class="col-lg-4 col-md-6">
                <div class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                    <div class="service-icon mb-4">
                        <i class="fa fa-2x ${service.icon_class} text-white"></i>
                    </div>
                    <h4 class="mb-3">${service.title}</h4>
                    <p class="m-0">${service.description}</p>
                    <a class="btn btn-lg btn-primary rounded-pill" href="#!">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        `;
        servicesContainer.insertAdjacentHTML('beforeend', serviceElement);
    });
}