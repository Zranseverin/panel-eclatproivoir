<?php
require_once __DIR__ . '/../config.php';
$navItems = getActiveNavbarItems();
$navbarBrand = getNavbarBrand();
$current_page = basename($_SERVER['PHP_SELF']);
?><div class="container-fluid sticky-top bg-white shadow-sm">
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0">
                <a href="<?php echo htmlspecialchars($navbarBrand['brand_url']); ?>" class="navbar-brand">
                    <img src="<?php echo htmlspecialchars($navbarBrand['logo_path']); ?>" 
                         alt="<?php echo htmlspecialchars($navbarBrand['logo_alt']); ?>" 
                         style="height: <?php echo $navbarBrand['logo_height']; ?>px;">
                   
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <?php foreach ($navItems as $item): ?>
                            <?php if (!empty($item['children']) && is_array($item['children'])): ?>
                                <!-- Dropdown menu -->
                                <div class="nav-item dropdown">
                                    <a href="<?php echo htmlspecialchars($item['url']); ?>" 
                                       class="nav-link dropdown-toggle"
                                       data-bs-toggle="dropdown">
                                        <?php echo htmlspecialchars($item['title']); ?>
                                    </a>
                                    <div class="dropdown-menu m-0">
                                        <?php foreach ($item['children'] as $child): ?>
                                            <a href="<?php echo htmlspecialchars($child['url']); ?>" 
                                               class="dropdown-item <?php echo $current_page === ltrim($child['url'], '/') ? 'active' : ''; ?>">
                                                <?php echo htmlspecialchars($child['title']); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <!-- Regular menu item -->
                                <a href="<?php echo htmlspecialchars($item['url']); ?>" 
                                   class="nav-item nav-link <?php echo $current_page === ltrim($item['url'], '/') ? 'active' : ''; ?>">
                                    <?php echo htmlspecialchars($item['title']); ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </nav>
        </div>