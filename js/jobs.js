document.addEventListener('DOMContentLoaded', function() {
    fetchJobPostings();
    initializeApplicationForm();
});

function fetchJobPostings() {
    fetch('api/get_job_postings.php')
        .then(response => response.json())
        .then(data => {
            if (data.records && data.records.length > 0) {
                updateJobPostingsSection(data.records);
            }
        })
        .catch(error => {
            console.error('Error fetching job postings:', error);
        });
}

function updateJobPostingsSection(jobPostings) {
    const jobFrame = document.querySelector('.job-frame .row');
    if (!jobFrame) return;
    
    // Clear existing content
    jobFrame.innerHTML = '';
    
    // Add job postings dynamically
    jobPostings.forEach(job => {
        // Convert newline characters to <br> tags
        const responsibilitiesList = job.responsibilities.split('\n').map(item => 
            `<li><i class="fas fa-check-circle text-success me-2"></i>${item}</li>`
        ).join('');
        
        const profileItems = job.profile_requirements.split('\n').map(item => 
            `• ${item}`
        ).join('<br>');
        
        const benefitsItems = job.benefits.split('\n').map(item => 
            `• ${item}`
        ).join('<br>');
        
        const jobElement = `
            <div class="col-lg-6 mb-4">
                <div class="eco-card h-100">
                    <div class="card-header text-white">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="mb-0">${job.title}</h4>
                                <small>${job.employment_type}</small>
                            </div>
                            <span class="badge ${job.badge_class}">${job.badge_text}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-success">
                            <i class="fas fa-leaf me-2"></i>Description du poste :
                        </h5>
                        <p class="card-text">${job.description}</p>
                        
                        <!-- Mission section added after description -->
                        <h5 class="card-title text-success mt-4">
                            <i class="fas fa-bullseye me-2"></i>Mission :
                        </h5>
                        <p class="card-text">${job.mission}</p>
                        
                        <h5 class="card-title text-success mt-4">
                            <i class="fas fa-tasks me-2"></i>Responsabilités :
                        </h5>
                        <ul class="list-unstyled">
                            ${responsibilitiesList}
                        </ul>
                        
                        <div class="row mt-4">
                            <div class="col-6">
                                <h6 class="text-success">
                                    <i class="fas fa-user me-2"></i>Profil :
                                </h6>
                                <small class="text-muted">${profileItems}</small>
                            </div>
                            <div class="col-6">
                                <h6 class="text-success">
                                    <i class="fas fa-gift me-2"></i>Avantages :
                                </h6>
                                <small class="text-muted">${benefitsItems}</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i> Poste disponible immédiatement
                            </small>
                            <!-- Application link added -->
                            <a href="recruitment.php#application-form" class="btn btn-sm btn-outline-success">
                                <i class="fas fa-paper-plane me-1"></i>Postuler
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;
        jobFrame.insertAdjacentHTML('beforeend', jobElement);
    });
}

function initializeApplicationForm() {
    const form = document.getElementById('applicationForm');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Create FormData object to handle file uploads
        const formData = new FormData(form);
        
        // Submit application via API with file uploads
        fetch('process_application.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.message.includes('succès')) {
                // Hide form and show success message
                form.classList.add('d-none');
                document.getElementById('successMessage').classList.remove('d-none');
            } else {
                alert('Erreur lors de la soumission de la candidature. Veuillez réessayer.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue. Veuillez réessayer.');
        });
    });
}