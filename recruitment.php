<?php include 'partiels/head.php'; ?>
<style>
    /* Design Nature/Lumière/Écologie */
    body {
        background: linear-gradient(135deg, #f8fff8 0%, #e8f5e8 100%);
        position: relative;
        overflow-x: hidden;
    }
    
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: 
            radial-gradient(circle at 20% 80%, rgba(144, 238, 144, 0.1) 0%, transparent 40%),
            radial-gradient(circle at 80% 20%, rgba(152, 251, 152, 0.08) 0%, transparent 40%),
            radial-gradient(circle at 40% 40%, rgba(60, 179, 113, 0.05) 0%, transparent 30%);
        z-index: -1;
    }
    
    .nature-leaf-decoration {
        position: fixed;
        opacity: 0.1;
        z-index: -1;
    }
    
    .leaf-1 {
        top: 10%;
        left: 5%;
        width: 150px;
        height: 150px;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path fill="%233c9d3c" d="M50,5 C70,5 85,25 85,50 C85,75 70,95 50,95 C30,95 15,75 15,50 C15,25 30,5 50,5 Z" /></svg>');
    }
    
    .leaf-2 {
        bottom: 15%;
        right: 8%;
        width: 120px;
        height: 120px;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path fill="%232e8b57" d="M20,20 C40,5 75,10 85,35 C95,60 75,85 50,90 C25,95 5,75 10,50 C15,25 35,20 20,20 Z" /></svg>');
        transform: rotate(45deg);
    }
    
    .sunlight-effect {
        position: fixed;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(ellipse at center, rgba(255,255,200,0.1) 0%, transparent 70%);
        z-index: -1;
    }
    
    /* Cards écologiques améliorées */
    .eco-card {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid #d4edda;
        border-radius: 15px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 100, 0, 0.08);
        overflow: hidden;
        position: relative;
    }
    
    .eco-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, #28a745, #20c997, #28a745);
    }
    
    .eco-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 100, 0, 0.15);
        border-color: #28a745;
    }
    
    .eco-card .card-header {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border-bottom: none;
        position: relative;
        overflow: hidden;
    }
    
    .eco-card .card-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 30px;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2));
    }
    
    /* Formulaire écologique */
    .eco-form {
        background: rgba(255, 255, 255, 0.95);
        border: 2px solid #e8f5e9;
        border-radius: 15px;
        box-shadow: 0 8px 32px rgba(40, 167, 69, 0.1);
        backdrop-filter: blur(10px);
    }
    
    .eco-form .form-control,
    .eco-form .form-select {
        background-color: #f8fff8;
        border: 2px solid #c8e6c9;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .eco-form .form-control:focus,
    .eco-form .form-select:focus {
        background-color: white;
        border-color: #28a745;
        box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
    }
    
    /* Boutons écologiques */
    .btn-eco {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        border-radius: 8px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .btn-eco::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.7s ease;
    }
    
    .btn-eco:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
    }
    
    .btn-eco:hover::before {
        left: 100%;
    }
    
    /* En-tête section recrutement */
    .recruitment-header {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.1) 0%, rgba(32, 201, 151, 0.1) 100%);
        border-radius: 20px;
        padding: 40px;
        position: relative;
        overflow: hidden;
    }
    
    .recruitment-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.8) 0%, transparent 70%);
        z-index: 0;
    }
    
    .recruitment-header > * {
        position: relative;
        z-index: 1;
    }
    
    /* Section offres d'emploi */
    .job-frame {
        background: linear-gradient(135deg, rgba(248, 255, 248, 0.9) 0%, rgba(232, 245, 232, 0.9) 100%);
        border: 2px solid #d4edda;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
    }
    
    .job-frame::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #28a745, #20c997, #28a745, #20c997);
    }
    
    /* Icônes écologiques */
    .eco-icon {
        display: inline-block;
        width: 24px;
        height: 24px;
        margin-right: 10px;
        vertical-align: middle;
    }
    
    .leaf-icon {
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%2328a745"><path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3c.48.17.98.3 1.34.3C19 20 22 3 22 3c-1 2-8 2.25-13 3.25S2 11.5 2 13.5c0 1.78.94 4.11 4 6 1 1 2 1 3 1z"/></svg>');
    }
    
    .sun-icon {
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23ffc107"><circle cx="12" cy="12" r="5"/><path d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72l1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>');
    }
    
    .water-icon {
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23007bff"><path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/></svg>');
    }
    
    /* Badges écologiques */
    .eco-badge {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8em;
        font-weight: 600;
        display: inline-block;
        margin-right: 5px;
        margin-bottom: 5px;
    }
    
    /* Animation feuille qui tombe */
    @keyframes falling-leaf {
        0% {
            transform: translateY(-100px) rotate(0deg);
            opacity: 0;
        }
        10% {
            opacity: 1;
        }
        90% {
            opacity: 1;
        }
        100% {
            transform: translateY(100vh) rotate(360deg);
            opacity: 0;
        }
    }
    
    .falling-leaves {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: -1;
    }
    
    .falling-leaf {
        position: absolute;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="%2328a745"><path d="M10 1c-2 0-4 1-5 3-1 2-1 4 0 6 1 2 3 3 5 3s4-1 5-3c1-2 1-4 0-6-1-2-3-3-5-3z"/></svg>');
        width: 20px;
        height: 20px;
        opacity: 0.3;
        animation: falling-leaf linear infinite;
    }
</style>

<body>
    <!-- Effets de feuilles qui tombent -->
    <div class="falling-leaves" id="fallingLeaves"></div>
    
    <!-- Décorations feuilles -->
    <div class="nature-leaf-decoration leaf-1"></div>
    <div class="nature-leaf-decoration leaf-2"></div>
    
    <!-- Effet lumière du soleil -->
    <div class="sunlight-effect"></div>
    
    <?php include 'partiels/header.php'; ?>
    <?php include 'partiels/sidebar.php'; ?>

    <!-- Recruitment Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="recruitment-header text-center mx-auto mb-5">
                        <h5 class="d-inline-block text-white text-uppercase border-bottom border-5" style="border-color: #fff!important; background: #28a745; padding: 5px 20px; border-radius: 30px;">
                            <i class="fas fa-leaf me-2"></i>Recrutement Écologique
                        </h5>
                        <h1 class="display-4 mt-4" style="color: #2e7d32;">
                            <span class="eco-icon leaf-icon"></span>
                            Rejoignez notre équipe verte
                        </h1>
                        <p class="lead" style="color: #388e3c;">
                            Nous recherchons des passionnés de propreté et d'écologie pour contribuer à un environnement plus sain.
                        </p>
                        
                        <div class="mt-4">
                            <span class="eco-badge">
                                <i class="fas fa-recycle me-1"></i> Éco-responsable
                            </span>
                            <span class="eco-badge">
                                <i class="fas fa-sun me-1"></i> Énergie positive
                            </span>
                            <span class="eco-badge">
                                <i class="fas fa-seedling me-1"></i> Développement durable
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Job Postings Display Frame -->
            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="text-center mb-4">
                        <h2 class="text-success">
                            <span class="eco-icon sun-icon"></span>
                            Offres d'emploi vertes
                        </h2>
                        <p class="text-muted">Postes dans le domaine de la propreté et de l'environnement</p>
                    </div>
                </div>
                
                <!-- Frame/Display Container -->
                <div class="col-lg-12">
                    <div class="job-frame p-4">
                        <div class="row">
                            <!-- Job postings will be dynamically loaded here by jobs.js -->
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Application Form Section -->
            <div class="row justify-content-center" id="application-form">
                <div class="col-lg-12">
                    <div class="text-center mb-4">
                        <h2 class="text-success">
                            <i class="fas fa-seedling me-2"></i>Postuler maintenant
                        </h2>
                        <p class="lead text-muted">Rejoignez notre mouvement pour un environnement plus propre</p>
                    </div>
                </div>
                
                <div class="col-lg-8">
                    <div class="eco-form p-5">
                       
                        
                        <form id="applicationForm" method="POST" enctype="multipart/form-data">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label text-success">
                                        <i class="fas fa-user me-2"></i>Civilité *
                                    </label>
                                    <select class="form-select" name="civilite" required>
                                        <option value="">Sélectionnez votre civilité</option>
                                        <option value="Monsieur">Monsieur</option>
                                        <option value="Madame">Madame</option>
                                        <option value="Mademoiselle">Mademoiselle</option>
                                    </select>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label text-success">
                                        <i class="fas fa-id-card me-2"></i>Nom complet *
                                    </label>
                                    <input type="text" class="form-control" name="nom_complet" placeholder="Entrez votre nom complet" required>
                                </div>
                                
                                <div class="col-12 col-sm-6">
                                    <label class="form-label text-success">
                                        <i class="fas fa-phone me-2"></i>Téléphone *
                                    </label>
                                    <input type="tel" class="form-control" name="telephone" placeholder="Entrez votre numéro de téléphone" required>
                                </div>
                                
                                <div class="col-12 col-sm-6">
                                    <label class="form-label text-success">
                                        <i class="fas fa-envelope me-2"></i>Email *
                                    </label>
                                    <input type="email" class="form-control" name="email" placeholder="Entrez votre email" required>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label text-success">
                                        <i class="fas fa-map-marker-alt me-2"></i>Adresse *
                                    </label>
                                    <textarea class="form-control" name="adresse" placeholder="Entrez votre adresse complète" required rows="3"></textarea>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label text-success">
                                        <i class="fas fa-briefcase me-2"></i>Poste souhaité *
                                    </label>
                                    <select class="form-select" name="poste" required>
                                        <option value="">Sélectionnez le poste auquel vous postulez</option>
                                        <option value="Agent de Nettoyage Écologique">Agent de Nettoyage Écologique</option>
                                        <option value="Jardinier Paysagiste Bio">Jardinier Paysagiste Bio</option>
                                        <option value="Technicien Énergies Vertes">Technicien Énergies Vertes</option>
                                        <option value="Coordinateur Écologie">Coordinateur Écologie</option>
                                        <option value="Autre">Autre</option>
                                    </select>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label text-success">
                                        <i class="fas fa-file-pdf me-2"></i>Télécharger votre CV *
                                    </label>
                                    <input type="file" class="form-control" name="cv" accept=".pdf,.doc,.docx,.txt" required>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i> Formats acceptés : PDF, DOC, DOCX, TXT (Max 5MB)
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label text-success">
                                        <i class="fas fa-file-alt me-2"></i>Lettre de motivation *
                                    </label>
                                    <input type="file" class="form-control" name="lettre_motivation" accept=".pdf,.doc,.docx,.txt" required>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i> Formats acceptés : PDF, DOC, DOCX, TXT (Max 5MB)
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="conditions" required>
                                        <label class="form-check-label text-muted" for="conditions">
                                            <i class="fas fa-leaf me-1 text-success"></i>
                                            J'accepte le traitement écologique de mes données pour ma candidature *
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-12 mt-4">
                                    <button class="btn-eco w-100 py-3" type="submit">
                                        <i class="fas fa-paper-plane me-2"></i>Envoyer ma candidature verte
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Success message -->
                        <div id="successMessage" class="alert alert-success mt-4 d-none">
                            <h4 class="alert-heading"><i class="fas fa-check-circle me-2"></i>Merci pour votre candidature!</h4>
                            <p>Votre candidature a été soumise avec succès. Nous vous contacterons dans les plus brefs délais.</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Recruitment End -->

    <?php include 'partiels/footer.php'; ?>
    
    <script>
        // Animation feuilles qui tombent
        function createFallingLeaves() {
            const container = document.getElementById('fallingLeaves');
            const leafCount = 15;
            
            for (let i = 0; i < leafCount; i++) {
                const leaf = document.createElement('div');
                leaf.className = 'falling-leaf';
                
                // Position aléatoire
                const leftPos = Math.random() * 100;
                leaf.style.left = leftPos + '%';
                
                // Animation aléatoire
                const duration = 10 + Math.random() * 20;
                const delay = Math.random() * 20;
                leaf.style.animationDuration = duration + 's';
                leaf.style.animationDelay = delay + 's';
                
                // Taille aléatoire
                const size = 10 + Math.random() * 20;
                leaf.style.width = size + 'px';
                leaf.style.height = size + 'px';
                
                // Opacité aléatoire
                leaf.style.opacity = 0.1 + Math.random() * 0.2;
                
                container.appendChild(leaf);
            }
        }
        
        // Initialiser au chargement
        document.addEventListener('DOMContentLoaded', function() {
            createFallingLeaves();
            
            // Ajouter Font Awesome si non présent
            if (!document.querySelector('link[href*="font-awesome"]')) {
                const faLink = document.createElement('link');
                faLink.rel = 'stylesheet';
                faLink.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css';
                document.head.appendChild(faLink);
            }
        });
    </script>
</body>
</html>