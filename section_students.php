<?php
require_once 'includes/security_headers.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$section_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$section_id) {
    die("ID de section invalide");
}

require_once 'models/Section.php';
$students = Section::getStudents($section_id);
$sectionName = Section::getDesignation($section_id);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Étudiants de la section <?= htmlspecialchars($sectionName) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h3>
                    <i class="fas fa-users mr-2"></i>
                    Étudiants de la section : <?= htmlspecialchars($sectionName) ?>
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Nom</th>
                            <th>Date de naissance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?= htmlspecialchars($student['name']) ?></td>
                            <td><?= date('d/m/Y', strtotime($student['birthday'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="list_students.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
            </div>
        </div>
    </div>
</body>
</html>