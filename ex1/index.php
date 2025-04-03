<?php
require_once 'pokemon.php';
echo "<link rel='stylesheet' href='style.css'>";

function displayPokemon(Pokemon $pokemon) {
    echo "<div class='pokemon-card'>";
    echo "<h3>{$pokemon->name}</h3>";
    echo "<img src='{$pokemon->url}' alt='{$pokemon->name}' />";
    echo "<p>Points: {$pokemon->hp}</p>";
    echo "<p>Min Attack Points: {$pokemon->attackPokemon->attackMinimal}</p>";
    echo "<p>Max Attack Points: {$pokemon->attackPokemon->attackMaximal}</p>";
    echo "<p>Special Attack: {$pokemon->attackPokemon->specialAttack}</p>";
    echo "<p>Probability Special Attack: {$pokemon->attackPokemon->probabilitySpecialAttack}</p>";
    echo "</div>";
}

$pokemon1 = new Pokemon("Dracaufeu Gigamax", "images/pokeman2.jpeg", 200, new AttackPokemon(10, 100, 3, 20));
$pokemon2 = new Pokemon("Dracaufeu Gigamax", "images/pokeman1.jpg", 200, new AttackPokemon(30, 80, 5, 20));

$round = 1;
while (!$pokemon1->isDead() && !$pokemon2->isDead()) {
    echo "<div class='round'>";
    echo "<h3>Round $round</h3>";

    echo "<div class='pokemon-display'>";
    displayPokemon($pokemon1);
    displayPokemon($pokemon2);
    echo "</div>";

    $damage1 = $pokemon1->attackPokemon->getAttack();
    $pokemon2->hp -= $damage1;

    if ($pokemon2->isDead()) {
        echo "<div class='winner-box'>";
        echo "<h2>Le vainqueur est {$pokemon1->name}!</h2>";
        echo "<img src='images/pokeman1.jpg' alt='{$pokemon1->name}' class='winner-img' />";
        echo "</div>";
        break;
    }

    $damage2 = $pokemon2->attackPokemon->getAttack();
    $pokemon1->hp -= $damage2;

    if ($pokemon1->isDead()) {
        echo "<div class='winner-box'>";
        echo "<h2>Le vainqueur est {$pokemon2->name}!</h2>";
        echo "<img src='images/pokeman2.jpeg' alt='{$pokemon2->name}' class='winner-img' />";
        echo "</div>";
        break;
    }

    echo "<div class='damage-box'>";
    echo "<p>$damage1</p>";
    echo "<p>$damage2</p>";
    echo "</div>";

    echo "</div>";
    $round++;
}

echo "</div>";
?>
