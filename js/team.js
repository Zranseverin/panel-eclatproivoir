document.addEventListener('DOMContentLoaded', function() {
    fetchTeamMembers();
});

function fetchTeamMembers() {
    fetch('api/get_team_members.php')
        .then(response => response.json())
        .then(data => {
            if (data.records && data.records.length > 0) {
                updateTeamSection(data.records);
            }
        })
        .catch(error => {
            console.error('Error fetching team members:', error);
        });
}

function updateTeamSection(members) {
    const teamContainer = document.querySelector('.team-carousel');
    if (!teamContainer) return;
    
    // Destroy existing carousel if it exists
    if ($('.team-carousel').hasClass('owl-carousel')) {
        $('.team-carousel').owlCarousel('destroy');
    }
    
    // Clear existing content
    teamContainer.innerHTML = '';
    
    // Add team members dynamically
    members.forEach(member => {
        const memberElement = `
            <div class="team-item">
                <div class="row g-0 bg-light rounded overflow-hidden">
                    <div class="col-12 col-sm-5 h-100">
                        <img class="img-fluid h-100" src="${member.image_url}" style="object-fit: cover;" alt="${member.name}">
                    </div>
                    <div class="col-12 col-sm-7 h-100 d-flex flex-column">
                        <div class="mt-auto p-4">
                            <h3>${member.name}</h3>
                            <h6 class="fw-normal fst-italic text-primary mb-4">${member.role}</h6>
                            <p class="m-0">${member.bio}</p>
                        </div>
                        <div class="d-flex mt-auto border-top p-4">
                            <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-3" href="${member.twitter_url}"><i
                                    class="fab fa-twitter"></i></a>
                            <a class="btn btn-lg btn-primary btn-lg-square rounded-circle me-3" href="${member.facebook_url}"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-lg btn-primary btn-lg-square rounded-circle" href="${member.linkedin_url}"><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        `;
        teamContainer.insertAdjacentHTML('beforeend', memberElement);
    });
    
    // Reinitialize the carousel with the same settings as in main.js
    setTimeout(function() {
        if (typeof $('.team-carousel').owlCarousel === 'function') {
            $(".team-carousel").owlCarousel({
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
        }
    }, 100);
}