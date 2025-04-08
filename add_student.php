<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'includes/security_headers.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        require_once 'models/Student.php';
        require_once 'config/Database.php';

        // Validation
        $data = [
            'name' => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'birthday' => $_POST['birthday'],
            'section_id' => filter_input(INPUT_POST, 'section_id', FILTER_VALIDATE_INT)
        ];

        // Vérification finale
        if (empty($data['name']) || empty($data['birthday']) || !$data['section_id']) {
            throw new Exception("Veuillez remplir tous les champs correctement");
        }

        // Insertion
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO students (name, birthday, section_id) VALUES (?, ?, ?)");
        $stmt->execute([$data['name'], $data['birthday'], $data['section_id']]);

        header('Location: list_students.php');
        exit;

    } catch (PDOException $e) {
        die("Erreur SQL : " . $e->getMessage());
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

// Récupération des sections
require_once 'models/Section.php';
$sections = Section::findAll();
?>

<!-- En-tête -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <!-- En-tête de page -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-4">
                <h2 class="h3 font-weight-bold text-primary mb-3 mb-md-0">
                    <i class="fas fa-user-plus mr-2"></i>Nouvel Étudiant
                </h2>
                <a href="list_students.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
                </a>
            </div>

            <!-- Carte principale -->
            <div class="card shadow">
                <div class="card-header bg-primary text-white py-3">
                    <h3 class="h5 mb-0"><i class="fas fa-edit mr-2"></i>Formulaire d'inscription</h3>
                </div>
                
                <div class="card-body p-4">
                    <form method="POST" novalidate>
                        <!-- Section Informations -->
                        <div class="mb-4">
                            <h4 class="h5 font-weight-bold mb-4 text-primary">
                                <i class="fas fa-id-card mr-2"></i>Informations personnelles
                            </h4>
                            
                            <div class="row">
                                <!-- Nom complet -->
                                <div class="col-12 mb-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-user"></i>
                                            </span>
                                        </div>
                                        <input type="text" 
                                               name="name" 
                                               class="form-control form-control-lg"
                                               placeholder="Jean Dupont"
                                               pattern="[A-Za-zÀ-ÿ\s\-]{2,50}"
                                               required>
                                        <div class="invalid-feedback">
                                            Veuillez entrer un nom valide (2-50 caractères)
                                        </div>
                                    </div>
                                </div>

                                <!-- Date de naissance -->
                                <div class="col-md-6 mb-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="date" 
                                               name="birthday" 
                                               class="form-control form-control-lg"
                                               required 
                                               max="<?= date('Y-m-d') ?>">
                                    </div>
                                </div>

                                <!-- Sélection de section -->
                                <div class="col-md-6 mb-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-university"></i>
                                            </span>
                                        </div>
                                        <select name="section_id" 
                                                class="form-control form-control-lg" 
                                                required>
                                            <option value="">Choisir une section</option>
                                            <?php foreach ($sections as $section): ?>
                                            <option value="<?= $section->id ?>">
                                                <?= htmlspecialchars($section->designation) ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="border-top pt-4 mt-4">
                            <div class="d-flex justify-content-between">
                                <button type="reset" class="btn btn-outline-danger">
                                    <i class="fas fa-undo mr-2"></i>Réinitialiser
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-2"></i>Enregistrer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Validation Bootstrap 4
(function() {
  'use strict';
  window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');
    Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>