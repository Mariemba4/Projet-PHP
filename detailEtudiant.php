<?php
// Configuration de la base de données
$host = 'localhost';
$dbname = 'my_database';
$user = 'root';
$pass = 'nader2004%%10&&';

// Vérification de l'ID
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: index.php");
    exit();
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête préparée sécurisée
    $stmt = $pdo->prepare("SELECT * FROM student WHERE id = :id");
    $stmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    
    $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$etudiant) {
        throw new Exception("Étudiant non trouvé");
    }

} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de l'Étudiant</title>
    <style>
        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .detail-group {
            margin: 15px 0;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #2196F3;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Fiche de l'Étudiant</h2>
        
        <div class="detail-group">
            <strong>ID :</strong> <?= htmlspecialchars($etudiant['id']) ?>
        </div>
        
        <div class="detail-group">
            <strong>Nom :</strong> <?= htmlspecialchars($etudiant['name']) ?>
        </div>
        
        <div class="detail-group">
            <strong>Date de naissance :</strong> <?= htmlspecialchars($etudiant['birthday']) ?>
        </div>

        <a href="index.php" class="back-link">← Retour à la liste</a>
    </div>
</body>
</html>