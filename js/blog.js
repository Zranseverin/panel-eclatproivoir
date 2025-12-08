document.addEventListener('DOMContentLoaded', function() {
    fetchBlogPosts();
});

function fetchBlogPosts() {
    fetch('api/get_blog_posts.php')
        .then(response => response.json())
        .then(data => {
            if (data.records && data.records.length > 0) {
                updateBlogSection(data.records);
                // Adjust blog card heights after content is loaded
                setTimeout(adjustBlogCardHeights, 100);
            }
        })
        .catch(error => {
            console.error('Error fetching blog posts:', error);
        });
}

function updateBlogSection(posts) {
    const blogContainer = document.querySelector('#blog-posts-container');
    if (!blogContainer) return;
    
    // Clear existing content
    blogContainer.innerHTML = '';
    
    // Add blog posts dynamically
    posts.forEach(post => {
        const postElement = `
            <div class="col-xl-4 col-lg-6">
                <div class="bg-light rounded overflow-hidden blog-post-card">
                    <img class="img-fluid w-100 blog-post-image" src="${post.image_url}" alt="${post.title}">
                    <div class="p-4 blog-post-content">
                        <a class="h3 d-block mb-3 blog-post-title" href="#!">${post.title}</a>
                        <p class="m-0 blog-post-subtitle">${post.subtitle}</p>
                    </div>
                    <div class="d-flex justify-content-between border-top p-4 blog-post-meta">
                        <div class="d-flex align-items-center">
                            <img class="rounded-circle me-2" src="${post.author_image_url}" width="25" height="25" alt="${post.author}">
                            <small>${post.author}</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <small class="ms-3"><i class="far fa-eye text-primary me-1"></i>${post.views}</small>
                            <small class="ms-3"><i class="far fa-comment text-primary me-1"></i>${post.comments}</small>
                        </div>
                    </div>
                </div>
            </div>
        `;
        blogContainer.insertAdjacentHTML('beforeend', postElement);
    });
}

function adjustBlogCardHeights() {
    // Get all blog post cards
    const blogCards = document.querySelectorAll('.blog-post-card');
    
    // Reset heights
    blogCards.forEach(card => {
        card.style.height = 'auto';
    });
    
    // Find the maximum height
    let maxHeight = 0;
    blogCards.forEach(card => {
        const cardHeight = card.offsetHeight;
        if (cardHeight > maxHeight) {
            maxHeight = cardHeight;
        }
    });
    
    // Apply consistent height
    if (maxHeight > 0) {
        blogCards.forEach(card => {
            card.style.height = maxHeight + 'px';
        });
    }
    
    // Ensure images have fixed height
    const blogImages = document.querySelectorAll('.blog-post-image');
    blogImages.forEach(img => {
        img.style.height = '200px';
        img.style.objectFit = 'cover';
        img.style.objectPosition = 'center';
    });
}

// Adjust card heights on window resize
window.addEventListener('resize', function() {
    setTimeout(adjustBlogCardHeights, 100);
});