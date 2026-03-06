


    <?php
require_once __DIR__ . '/../config.php';
$contact = getHeaderContact();
?>

    <div class="container-fluid py-2 border-bottom d-none d-lg-block">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-lg-start mb-2 mb-lg-0">
                    <div class="d-inline-flex align-items-center">
                        <?php if (!empty($contact['phone'])): ?>
                        <a class="text-decoration-none text-body pe-3" href="tel:<?php echo htmlspecialchars($contact['phone']); ?>">
                            <i class="bi bi-telephone me-2"></i><?php echo htmlspecialchars($contact['phone']); ?>
                        </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($contact['email'])): ?>
                        <?php if (!empty($contact['phone'])): ?>
                        <span class="text-body">|</span>
                        <?php endif; ?>
                        <a class="text-decoration-none text-body px-3" href="mailto:<?php echo htmlspecialchars($contact['email']); ?>">
                            <i class="bi bi-envelope me-2"></i><?php echo htmlspecialchars($contact['email']); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6 text-center text-lg-end">
                    <div class="d-inline-flex align-items-center">
                        <?php if (!empty($contact['facebook'])): ?>
                        <a class="text-body px-2" href="<?php echo htmlspecialchars($contact['facebook']); ?>" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($contact['twitter'])): ?>
                        <a class="text-body px-2" href="<?php echo htmlspecialchars($contact['twitter']); ?>" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($contact['linkedin'])): ?>
                        <a class="text-body px-2" href="<?php echo htmlspecialchars($contact['linkedin']); ?>" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($contact['instagram'])): ?>
                        <a class="text-body px-2" href="<?php echo htmlspecialchars($contact['instagram']); ?>" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($contact['youtube'])): ?>
                        <a class="text-body ps-2" href="<?php echo htmlspecialchars($contact['youtube']); ?>" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>