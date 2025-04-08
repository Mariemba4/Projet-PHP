<?php
require_once 'includes/security_headers.php';
require_once 'models/Section.php';
require_once 'models/Student.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$section_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$section_id) die("ID de section invalide");

$section = Section::getById($section_id);
if (!$section) die("Section introuvable");

$students = Student::getBySection($section_id);
$isAdmin = ($_SESSION['role'] === 'admin');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Étudiants <?= htmlspecialchars($section['designation']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header text-white bg-<?= strtolower($section['designation']) ?>">
                <h3>
                    <i class="fas fa-users me-2"></i>
                    <?= htmlspecialchars($section['designation']) ?> - 
                    <?= htmlspecialchars($section['description']) ?>
                </h3>
            </div>
            <div class="card-body">
                <?php if (empty($students)): ?>
                    <div class="alert alert-info">Aucun étudiant dans cette section</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <!-- ... (même structure que list_students.php) ... -->
                        </table>
                    </div>
                <?php endif; ?>
                <a href="list_students.php" class="btn btn-secondary mt-3">
                    <i class="fas fa-arrow-left me-2"></i> Retour
                </a>
            </div>
        </div>
    </div>
</body>
</html>