<?php
class Etudiant {
    public $nom;
    public $notes = [];

    public function __construct($nom, $notes) {
        $this->nom = $nom;
        $this->notes = $notes;
    }

    public function getNom() {
        return $this->nom;
    }

    public function calculerMoyenne() {
        if (count($this->notes) == 0) return 0;
        return array_sum($this->notes) / count($this->notes);
    }

    public function afficherNotes() {
        echo "<div class='etudiant'>";
        echo "<h3>{$this->nom}</h3>";

        foreach ($this->notes as $note) {
            if ($note > 10) {
                $couleur = 'rgb(202, 225, 179)';
            } else if ($note < 10) {
                $couleur = 'rgb(234, 178, 179)';
            } else {
                $couleur = 'rgb(239, 206, 166)';
            }
            echo "<div class='note' style='background-color: $couleur;'>$note</div>";
        }

        $moyenne = $this->calculerMoyenne();
        echo "<div class='moyenne'>Votre moyenne est " . number_format($moyenne, 10) . "</div>";
        echo "</div>";
    }
}

$etudiants = [
    new Etudiant("Aymen", [11, 13, 18, 7, 10, 13, 2, 5, 1]),
    new Etudiant("Skander", [15, 9, 8, 16])
];
?>
	

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes des étudiants</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            gap: 20px;
            padding: 20px;
        }
        .etudiant {
            border: 1px solid #ccc;
            padding: 10px;
            width: 200px;
            border-radius: 5px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .note {
            padding: 5px;
            margin: 5px 0;
            text-align: center;
            color: white;
            font-weight: bold;
            border-radius: 3px;
        }
        .moyenne {
            background-color: lightblue;
            padding: 5px;
            margin-top: 10px;
            text-align: center;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <?php
    foreach ($etudiants as $etudiant) {
        $etudiant->afficherNotes();
    }
    ?>
</body>
</html>


