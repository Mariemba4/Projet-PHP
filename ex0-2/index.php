<?php
require_once 'Session.php';

$session = new Session();
$session->start();

if (!$session->has('visits')) {
    $session->set('visits', 1);
    $message = "Bienvenue sur notre plateforme.";
} else {
    $visits = $session->get('visits') + 1;
    $session->set('visits', $visits);
    $message = "Merci pour votre fidélité, c’est votre $visits ème visite.";
}

if (isset($_POST['reset'])) {
    $session->destroy();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Session</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            text-align: center;
            background: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color:rgb(32, 96, 149);
        }
        button {
            background-color:rgb(116, 148, 193);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color:rgb(69, 133, 160);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= $message; ?></h1>
        <form method="POST">
            <button type="submit" name="reset">Réinitialiser la session</button>
        </form>
    </div>
</body>
</html>
