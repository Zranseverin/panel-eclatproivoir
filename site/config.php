<?php

// Try multiple approaches for Docker connectivity
$possibleUrls = [
    'http://nginx:80/api', // Docker internal network (from within container)
    'http://host.docker.internal:8000/api', // Docker desktop (from host)
    'http://localhost:8000/api', // Direct localhost
];

$configEndpoint = '/v1/config';
$apiBaseUrl = 'http://host.docker.internal:8000/api'; // default

foreach ($possibleUrls as $url) {
    try {
        $testUrl = $url . $configEndpoint;
        $ch = curl_init($testUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200 && $response) {
            $data = json_decode($response, true);
            if ($data && isset($data['success']) && $data['success']) {
                $apiBaseUrl = $url;
                break;
            }
        }
    } catch (Exception $e) {
        continue;
    }
}

/**
 * Fetch site configuration from the API
 * 
 * @return array|null Returns configuration data or null if fetch fails
 */
function getSiteConfig() {
    global $apiBaseUrl, $configEndpoint;
    
    // Try to fetch from API
    $url = $apiBaseUrl . $configEndpoint;
    
    try {
        // Use cURL to fetch the configuration
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 5 second timeout
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For local development
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($httpCode === 200 && $response) {
            $data = json_decode($response, true);
            if ($data && isset($data['success']) && $data['success'] && isset($data['data'])) {
                return $data['data'];
            }
        }
    } catch (Exception $e) {
        // Log error for debugging
        error_log('Failed to fetch site config: ' . $e->getMessage());
    }
    
    // Return default configuration if API fetch fails
    return [
        'logo_path' => 'img/Imediat 07.png',
        'alt_text' => 'EPI Logo',
        'site_title' => 'EPI - Eclat pro Ivoire'
    ];
}

/**
 * Get the site title
 * 
 * @param string|null $suffix Optional suffix to append (e.g., page name)
 * @return string The complete page title
 */
function getSiteTitle($suffix = null) {
    $config = getSiteConfig();
    $title = $config['site_title'] ?? 'EPI - Eclat pro Ivoire';
    
    if ($suffix) {
        $title .= ' - ' . $suffix;
    }
    
    return $title;
}

/**
 * Get the logo URL
 * 
 * @return string The path to the site logo
 */
function getLogoUrl() {
    global $apiBaseUrl;
    $config = getSiteConfig();
    $logoPath = $config['logo_path'] ?? 'img/Imediat 07.png';
    
    // If empty, return default
    if (empty($logoPath)) {
        return 'img/Imediat 07.png';
    }
    
    // If it's already a full URL (starts with http or https), return it as is
    if (strpos($logoPath, 'http') === 0) {
        return $logoPath;
    }
    
    // If it's a storage path (starts with /storage), reconstruct the full URL
    if (strpos($logoPath, '/storage') === 0) {
        // Remove /api from the base URL to get the root URL
        $baseUrl = preg_replace('/\/api$/', '', $apiBaseUrl);
        return $baseUrl . $logoPath;
    }
    
    // Otherwise, return as relative path (local file)
    return $logoPath;
}

/**
 * Get the logo alt text
 * 
 * @return string The alt text for the logo
 */
function getLogoAlt() {
    $config = getSiteConfig();
    return $config['alt_text'] ?? 'EPI Logo';
}

/**
 * Get header contact configuration from the API
 * 
 * @return array Header contact information with phone, email, address, and social media links
 */
function getHeaderContact() {
    $apiBaseUrl = getenv('LARAVEL_API_URL') ?: 'http://host.docker.internal:8000/api';
    $endpoint = '/v1/header-contact';
    
    try {
        $ch = curl_init($apiBaseUrl . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200 && $response) {
            $data = json_decode($response, true);
            if ($data && isset($data['success']) && $data['success'] && isset($data['data'])) {
                return $data['data'];
            }
        }
    } catch (Exception $e) {
        error_log('Failed to fetch header contact: ' . $e->getMessage());
    }
    
    // Return default values if API fetch fails
    return [
        'phone' => '+225 345 6789',
        'email' => 'info@example.com',
        'address' => '123 Street, New York, USA',
        'facebook' => '',
        'twitter' => '',
        'linkedin' => '',
        'instagram' => '',
        'youtube' => ''
    ];
}

/**
 * Get active navbar items from the API
 * 
 * @return array Active navbar items with dropdown structure
 */
function getActiveNavbarItems() {
    $apiBaseUrl = getenv('LARAVEL_API_URL') ?: 'http://host.docker.internal:8000/api';
    $endpoint = '/v1/navbar';
    
    try {
        $ch = curl_init($apiBaseUrl . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200 && $response) {
            $data = json_decode($response, true);
            if ($data && isset($data['success']) && $data['success'] && isset($data['data'])) {
                return $data['data'];
            }
        }
    } catch (Exception $e) {
        error_log('Failed to fetch navbar items: ' . $e->getMessage());
    }
    
    // Return default fallback menu if API fails
    return [
        [
            'id' => 1,
            'title' => 'Accueil',
            'url' => 'index.php',
            'is_active' => true,
            'children' => []
        ],
        [
            'id' => 2,
            'title' => 'A propos',
            'url' => 'about.php',
            'is_active' => true,
            'children' => []
        ],
        [
            'id' => 3,
            'title' => 'Service',
            'url' => 'service.php',
            'is_active' => true,
            'children' => []
        ],
        [
            'id' => 4,
            'title' => 'Prix',
            'url' => 'price.php',
            'is_active' => true,
            'children' => []
        ],
        [
            'id' => 5,
            'title' => 'Pages',
            'url' => '#',
            'is_active' => true,
            'children' => [
                ['id' => 6, 'title' => 'Blog Grid', 'url' => 'blog.php'],
                ['id' => 7, 'title' => 'Blog Detail', 'url' => 'detail.php'],
                ['id' => 8, 'title' => 'The Team', 'url' => 'team.php'],
                ['id' => 9, 'title' => 'Testimonial', 'url' => 'testimonial.php'],
                ['id' => 10, 'title' => 'Appointment', 'url' => 'appointment.php'],
                ['id' => 11, 'title' => 'Search', 'url' => 'search.php'],
            ]
        ],
        [
            'id' => 12,
            'title' => 'Contact',
            'url' => 'contact.php',
            'is_active' => true,
            'children' => []
        ]
    ];
}

/**
 * Get navbar brand configuration from the API
 * 
 * @return array Navbar brand information with logo path, alt text, brand name, and settings
 */
function getNavbarBrand() {
    $apiBaseUrl = getenv('LARAVEL_API_URL') ?: 'http://host.docker.internal:8000/api';
    $endpoint = '/v1/navbar-brand';
    
    try {
        $ch = curl_init($apiBaseUrl . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200 && $response) {
            $data = json_decode($response, true);
            if ($data && isset($data['success']) && $data['success'] && isset($data['data'])) {
                return $data['data'];
            }
        }
    } catch (Exception $e) {
        error_log('Failed to fetch navbar brand: ' . $e->getMessage());
    }
    
    // Return default values if API fails
    return [
        'logo_path' => 'img/logo.jpg',
        'logo_alt' => 'eclat pro ivoir',
        'brand_name' => 'EPI - Eclat pro Ivoire',
        'brand_url' => 'index.php',
        'logo_height' => 100,
        'is_active' => true
    ];
}

/**
 * Get active hero slides from the API
 * 
 * @return array Active hero slides for the carousel
 */
function getHeroSlides() {
    $apiBaseUrl = getenv('LARAVEL_API_URL') ?: 'http://host.docker.internal:8000/api';
    $endpoint = '/v1/hero-slides/active';
    
    try {
        $ch = curl_init($apiBaseUrl . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200 && $response) {
            $data = json_decode($response, true);
            if ($data && isset($data['success']) && $data['success'] && isset($data['data'])) {
                return $data['data'];
            }
        }
    } catch (Exception $e) {
        error_log('Failed to fetch hero slides: ' . $e->getMessage());
    }
    
    // Return default slides if API fails
    return [
        [
            'title' => 'Welcome To Medinova',
            'subtitle' => 'Best Healthcare Solution In Your City',
            'background_image' => 'img/hero.jpg',
            'button1_text' => 'Find Doctor',
            'button1_url' => '#!',
            'button2_text' => 'Appointment',
            'button2_url' => '#!',
        ],
        [
            'title' => 'Quality Healthcare',
            'subtitle' => 'Advanced Medical Technology',
            'background_image' => 'img/about.jpg',
            'button1_text' => 'Learn More',
            'button1_url' => '#!',
            'button2_text' => 'Services',
            'button2_url' => '#!',
        ],
        [
            'title' => 'Expert Doctors',
            'subtitle' => 'Trusted Medical Professionals',
            'background_image' => 'img/team-1.jpg',
            'button1_text' => 'Meet Our Team',
            'button1_url' => '#!',
            'button2_text' => 'Contact',
            'button2_url' => '#!',
        ]
    ];
}

/**
 * Get active about us content from the API
 * 
 * @return array|null About us content or null if not found
 */
function getAboutUsContent() {
    $apiBaseUrl = getenv('LARAVEL_API_URL') ?: 'http://host.docker.internal:8000/api';
    $endpoint = '/v1/about-us';
    
    try {
        $ch = curl_init($apiBaseUrl . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200 && $response) {
            $data = json_decode($response, true);
            if ($data && isset($data['success']) && $data['success'] && isset($data['data'])) {
                return $data['data'];
            }
        }
    } catch (Exception $e) {
        error_log('Failed to fetch about us content: ' . $e->getMessage());
    }
    
    // Return default content if API fails
    return [
        'title' => 'About Us',
        'subtitle' => 'Best Medical Care For Yourself and Your Family',
        'description' => 'Tempor erat elitr at rebum at at clita aliquyam consetetur. Diam dolor diam ipsum et, tempor voluptua sit consetetur sit. Aliquyam diam amet diam et eos sadipscing labore. Clita erat ipsum et lorem et sit, sed stet no labore lorem sit. Sanctus clita duo justo et tempor consetetur takimata eirmod, dolores takimata consetetur invidunt magna dolores aliquyam dolores dolore. Amet erat amet et magna',
        'image_path' => 'img/about.jpg',
        'feature1_icon' => 'fa fa-user-md',
        'feature1_title' => 'Qualified Doctors',
        'feature2_icon' => 'fa fa-procedures',
        'feature2_title' => 'Emergency Services',
        'feature3_icon' => 'fa fa-microscope',
        'feature3_title' => 'Accurate Testing',
        'feature4_icon' => 'fa fa-ambulance',
        'feature4_title' => 'Free Ambulance',
    ];
}
