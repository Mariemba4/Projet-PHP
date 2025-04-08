<?php
require_once 'includes/security_headers.php';

// Vérification de l'authentification
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Configuration des rôles
$isAdmin = ($_SESSION['role'] === 'admin');
$currentUser = htmlspecialchars($_SESSION['username'] ?? 'Utilisateur');

// Gestion de la recherche
$search = htmlspecialchars($_GET['search'] ?? '');

// Chargement des modèles
require_once 'models/Student.php';
require_once 'models/Section.php';
$students = Student::getAll($search);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isAdmin ? 'Gestion' : 'Consultation' ?> des Étudiants</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- DataTables + Buttons -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.4/b-2.3.6/b-html5-2.3.6/datatables.min.css"/>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .card-header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        }
        
        .badge-gl { background-color: #28a745; }
        .badge-rt { background-color: #17a2b8; }
        .badge-iia { background-color: #6f42c1; }
        .badge-imi { background-color: #fd7e14; }
        
        .btn-export {
            margin-right: 5px;
            transition: all 0.3s;
        }
        .btn-export:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-university me-2"></i>Gestion Étudiants
            </a>
            <div class="d-flex align-items-center">
                <span class="navbar-text text-white me-3">
                    <i class="fas fa-user me-1"></i>
                    <?= $currentUser ?>
                    <span class="badge bg-<?= $isAdmin ? 'danger' : 'info' ?> ms-2">
                        <?= $isAdmin ? 'Admin' : 'Étudiant' ?>
                    </span>
                </span>
                <a href="logout.php" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="card shadow-lg border-0">
            <div class="card-header text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">
                        <i class="fas fa-users me-2"></i>
                        Liste des Étudiants
                    </h3>
                    <?php if ($isAdmin): ?>
                    <a href="add_student.php" class="btn btn-success btn-sm">
                        <i class="fas fa-plus-circle me-1"></i> Ajouter
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-body">
                <!-- Formulaire de recherche -->
                <form method="GET" class="mb-4">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search text-primary"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               class="form-control form-control-lg"
                               placeholder="Rechercher un étudiant..."
                               value="<?= $search ?>">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-filter me-1"></i> Filtrer
                        </button>
                    </div>
                </form>

                <!-- Tableau des étudiants -->
                <div class="table-responsive">
                    <table id="studentsTable" class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-user me-1"></i> Nom</th>
                                <th><i class="fas fa-birthday-cake me-1"></i> Naissance</th>
                                <th><i class="fas fa-graduation-cap me-1"></i> Section</th>
                                <?php if ($isAdmin): ?>
                                <th class="text-end"><i class="fas fa-cogs me-1"></i> Actions</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student): 
                                $sectionDesignation = Section::getDesignation($student['section_id']);
                                $badgeClass = strtolower($sectionDesignation);
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($student['name']) ?></td>
                                <td><?= date('d/m/Y', strtotime($student['birthday'])) ?></td>
                                <td>
                                    <?php if ($student['section_id']): ?>
                                    <a href="section_students.php?id=<?= $student['section_id'] ?>" 
                                       class="badge badge-<?= $badgeClass ?> text-decoration-none">
                                        <i class="fas fa-users me-1"></i>
                                        <?= $sectionDesignation ?>
                                    </a>
                                    <?php else: ?>
                                    <span class="badge bg-secondary">Non assigné</span>
                                    <?php endif; ?>
                                </td>
                                <?php if ($isAdmin): ?>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a href="edit_student.php?id=<?= $student['id'] ?>" 
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete_student.php?id=<?= $student['id'] ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Confirmer la suppression ?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables + Extensions -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.4/b-2.3.6/b-html5-2.3.6/datatables.min.js"></script>

    <script>
    $(document).ready(function() {
        var config = {
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json'
            },
            responsive: true,
            pageLength: 10
        };

        <?php if ($isAdmin): ?>
        config.dom = config.dom.replace('p>', 'pB>');
        config.buttons = [
            {
                extend: 'excelHtml5',
                className: 'btn-export btn-success',
                text: '<i class="fas fa-file-excel me-1"></i> Excel',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                extend: 'csvHtml5',
                className: 'btn-export btn-info',
                text: '<i class="fas fa-file-csv me-1"></i> CSV',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                extend: 'pdfHtml5',
                className: 'btn-export btn-danger',
                text: '<i class="fas fa-file-pdf me-1"></i> PDF',
                exportOptions: {
                    columns: [0, 1, 2]
                },
                customize: function(doc) {
                    doc.content[1].table.widths = ['*', '*', '*'];
                }
            }
        ];
        <?php endif; ?>

        $('#studentsTable').DataTable(config);
    });
    </script>
</body>
</html>