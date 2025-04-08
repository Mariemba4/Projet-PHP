<?php
require_once 'includes/security_headers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'models/User.php';
    
    $user = User::authenticate($_POST['username'], $_POST['password']);
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];
        header('Location: list_students.php');
        exit;
    }
    $error = "Identifiants incorrects !";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - AcademicManager</title>
    
    <!-- Bootstrap 5 + Icônes -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- CSS Personnalisé -->
    <link rel="stylesheet" href="css/custom.css">
    
    <style>
        .login-gradient {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        }
        
        .login-card {
            border-radius: 1.5rem;
            box-shadow: 0 15px 30px rgba(0,0,0,0.12);
        }
        
        .form-control-lg {
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
        }
    </style>
</head>
<body class="login-gradient min-vh-100">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card login-card">
                    <div class="card-body p-5">
                        <!-- En-tête -->
                        <div class="text-center mb-5">
                            <div class="mb-4">
                                <i class="bi bi-shield-lock-fill text-primary fs-1"></i>
                            </div>
                            <h1 class="h3 fw-bold mb-2">AcademicManager</h1>
                            <p class="text-muted">Plateforme de gestion académique</p>
                        </div>

                        <!-- Formulaire -->
                        <form method="POST">
                            <?php if(isset($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <?= $error ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php endif; ?>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Nom d'utilisateur</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-person-fill"></i>
                                    </span>
                                    <input type="text" 
                                           name="username" 
                                           class="form-control form-control-lg"
                                           placeholder="Entrez votre identifiant"
                                           required
                                           autofocus>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock-fill"></i>
                                    </span>
                                    <input type="password" 
                                           name="password" 
                                           class="form-control form-control-lg"
                                           placeholder="••••••••"
                                           required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary-custom w-100 btn-lg">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                            </button>

                            <div class="text-center mt-4">
                                <a href="#!" class="text-decoration-none small text-muted">
                                    Mot de passe oublié ?
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>