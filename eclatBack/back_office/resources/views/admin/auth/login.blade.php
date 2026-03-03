<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administrateur</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #059669;
            --primary-dark: #047857;
            --primary-light: #d1fae5;
            --glass-bg: rgba(255, 255, 255, 0.9);
            --glass-border: rgba(255, 255, 255, 0.2);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            min-height: 100vh;
        }
        
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
            border-radius: 20px;
        }
        
        .logo-container {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            box-shadow: 0 10px 20px rgba(5, 150, 105, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            position: relative;
        }
        
        .logo-container::before {
            content: '';
            position: absolute;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.2);
        }
        
        .logo-icon {
            z-index: 1;
            color: white;
            font-size: 1.8rem;
        }
        
        /* Image logo */
        .logo-image {
            z-index: 1;
            width: 40px;
            height: 40px;
            object-fit: contain;
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(5, 150, 105, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(5, 150, 105, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(5, 150, 105, 0);
            }
        }
        
        .form-control-custom {
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            transition: all 0.3s ease;
        }
        
        .form-control-custom:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 4;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            border: none;
            border-radius: 12px;
            padding: 0.75rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(5, 150, 105, 0.2);
            background: linear-gradient(135deg, #047857 0%, #0d9669 100%);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #dee2e6;
        }
        
        .divider span {
            padding: 0 15px;
            color: #6c757d;
            background-color: white;
        }
        
        .background-blobs {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.7;
        }
        
        .blob-1 {
            top: 10%;
            left: 20%;
            width: 300px;
            height: 300px;
            background-color: #d1fae5;
            animation: blob1 20s infinite linear;
        }
        
        .blob-2 {
            top: 60%;
            right: 20%;
            width: 250px;
            height: 250px;
            background-color: #a7f3d0;
            animation: blob2 25s infinite linear;
        }
        
        .blob-3 {
            bottom: 10%;
            left: 50%;
            width: 200px;
            height: 200px;
            background-color: #6ee7b7;
            animation: blob3 30s infinite linear;
        }
        
        @keyframes blob1 {
            0% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0, 0) scale(1); }
        }
        
        @keyframes blob2 {
            0% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(-40px, 30px) scale(1.05); }
            66% { transform: translate(20px, -20px) scale(0.95); }
            100% { transform: translate(0, 0) scale(1); }
        }
        
        @keyframes blob3 {
            0% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(25px, 40px) scale(1.07); }
            66% { transform: translate(-30px, -25px) scale(0.93); }
            100% { transform: translate(0, 0) scale(1); }
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            z-index: 5;
        }
        
        .password-toggle:hover {
            color: #495057;
        }
        
        .error-message {
            font-size: 0.875rem;
            display: flex;
            align-items: center;
        }
        
        @media (max-width: 768px) {
            .glass-card {
                margin: 1rem;
                padding: 1.5rem !important;
            }
            
            .logo-container {
                width: 60px;
                height: 60px;
            }
            
            .logo-container::before {
                width: 40px;
                height: 40px;
            }
            
            .logo-icon {
                font-size: 1.5rem;
            }
            
            .logo-image {
                width: 34px;
                height: 34px;
            }
            
            .blob {
                display: none;
            }
        }
        
        .session-status {
            border-radius: 10px;
            border-left: 4px solid var(--primary-color);
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .form-check-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(5, 150, 105, 0.25);
        }
    </style>
</head>
<body>
    <!-- Background Animation -->
    <div class="background-blobs">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>
    
    <div class="login-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="glass-card p-4 p-md-5">
                        <!-- Header avec logo -->
                        <div class="text-center mb-4">
                            <div class="logo-container pulse-animation">
                                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="logo-image">
                            </div>
                            <h2 class="h3 fw-bold text-dark mb-2">
                                Connexion Administrateur
                            </h2>
                            <p class="text-muted mb-0">
                                Accédez au panneau d'administration sécurisé
                            </p>
                        </div>
                        
                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-success session-status d-flex align-items-center mb-4" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <div>{{ session('status') }}</div>
                            </div>
                        @endif
                        
                        <!-- Login Form -->
                        <form method="POST" action="{{ route('admin.login.post') }}">
                            @csrf
                            
                            <!-- Email Address -->
                            <div class="mb-4">
                                <label for="email" class="form-label fw-medium text-dark">
                                    <i class="bi bi-envelope me-1 text-success"></i>
                                    Adresse Email
                                </label>
                                <div class="position-relative">
                                    <i class="bi bi-person input-icon"></i>
                                    <input type="email" 
                                           class="form-control form-control-custom ps-4" 
                                           id="email" 
                                           name="email" 
                                           placeholder="admin@exemple.com" 
                                           value="{{ old('email') }}" 
                                           required>
                                </div>
                                @error('email')
                                    <div class="error-message text-danger mt-2">
                                        <i class="bi bi-exclamation-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <!-- Password -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="password" class="form-label fw-medium text-dark">
                                        <i class="bi bi-key me-1 text-success"></i>
                                        Mot de passe
                                    </label>
                                    <a href="#" class="text-decoration-none text-success small fw-medium">
                                        Mot de passe oublié?
                                    </a>
                                </div>
                                <div class="position-relative">
                                    <i class="bi bi-lock input-icon"></i>
                                    <input type="password" 
                                           class="form-control form-control-custom ps-4" 
                                           id="password" 
                                           name="password" 
                                           placeholder="••••••••" 
                                           required>
                                    <button type="button" class="password-toggle" id="togglePassword">
                                        <i class="bi bi-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="error-message text-danger mt-2">
                                        <i class="bi bi-exclamation-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <!-- Remember Me -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                    <label class="form-check-label text-dark" for="remember_me">
                                        Se souvenir de moi sur cet appareil
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-login text-white fw-medium" id="loginButton">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>
                                    Se connecter
                                </button>
                            </div>
                            
                            <!-- Divider -->
                            <div class="divider">
                                <span class="text-muted">Accès sécurisé</span>
                            </div>
                            
                            <!-- Security Info -->
                            <div class="alert alert-light border mb-0">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-info-circle text-success"></i>
                                    </div>
                                   
                                </div>
                            </div>
                        </form>
                        
                        <!-- Footer -->
                        <div class="text-center mt-4 pt-3 border-top">
                            <p class="text-muted small mb-0">
                                © 2025 Admin Panel. Tous droits réservés.
                                <span class="mx-2">•</span>
                                <i class="bi bi-shield-check text-success me-1"></i>
                                Version 2.1.4
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            }
        });
        
        // Form submission animation
        const form = document.querySelector('form');
        const loginButton = document.getElementById('loginButton');
        
        form.addEventListener('submit', function(e) {
            const originalText = loginButton.innerHTML;
            loginButton.innerHTML = '<i class="bi bi-arrow-clockwise spin me-2"></i> Connexion en cours...';
            loginButton.disabled = true;
            
            // Add spin animation class
            const spinner = loginButton.querySelector('.bi-arrow-clockwise');
            spinner.classList.add('spin-animation');
            
            // If form is invalid, reset button
            if (!form.checkValidity()) {
                setTimeout(() => {
                    loginButton.innerHTML = originalText;
                    loginButton.disabled = false;
                }, 1000);
            }
        });
        
        // Add spin animation style
        const style = document.createElement('style');
        style.textContent = `
            .spin-animation {
                animation: spin 1s linear infinite;
            }
            
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            
            .form-control:focus {
                border-color: #059669;
                box-shadow: 0 0 0 0.25rem rgba(5, 150, 105, 0.25);
            }
        `;
        document.head.appendChild(style);
        
        // Add focus effect to form controls
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
    </script>
</body>
</html>