<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class AttackPokemon {
    public $attackMinimal;
    public $attackMaximal;
    public $specialAttack;
    public $probabilitySpecialAttack;

    public function __construct($min, $max, $special, $prob) {
        $this->attackMinimal = $min;
        $this->attackMaximal = $max;
        $this->specialAttack = $special;
        $this->probabilitySpecialAttack = $prob;
    }
}

class Pokemon {
    protected $name;
    protected $type = 'Normal';
    protected $hp;
    protected $attackPokemon;

    public function __construct($name, $hp, $attackPokemon) {
        $this->name = $name;
        $this->hp = $hp;
        $this->attackPokemon = $attackPokemon;
    }

    public function attack(Pokemon $target) {
        $attackPoints = rand($this->attackPokemon->attackMinimal, $this->attackPokemon->attackMaximal);

        if (rand(1, 100) <= $this->attackPokemon->probabilitySpecialAttack) {
            $attackPoints *= $this->attackPokemon->specialAttack;
            echo "{$this->name} uses special attack! ";
        }

        $effectiveDamage = $this->calculateEffectiveness($target, $attackPoints);
        $target->hp -= $effectiveDamage;

        echo "{$this->name} attacks {$target->name} for $effectiveDamage damage. ";
        echo "{$target->name} has {$target->hp} HP left.<br>";
    }

    protected function calculateEffectiveness(Pokemon $target, $damage) {
        return $damage;
    }

    public function isDead() {
        return $this->hp <= 0;
    }

    public function getName() {
        return $this->name;
    }

    public function getType() {
        return $this->type;
    }

    public function resetHP($hp = 100) {
        $this->hp = $hp;
    }
}

class PokemonFeu extends Pokemon {
    protected $type = 'Fire';

    protected function calculateEffectiveness(Pokemon $target, $damage) {
        if ($target->getType() == 'Plant') return $damage * 2;
        if ($target->getType() == 'Water' || $target->getType() == 'Fire') return $damage * 0.5;
        return $damage;
    }
}

class PokemonEau extends Pokemon {
    protected $type = 'Water';

    protected function calculateEffectiveness(Pokemon $target, $damage) {
        if ($target->getType() == 'Fire') return $damage * 2;
        if ($target->getType() == 'Water' || $target->getType() == 'Plant') return $damage * 0.5;
        return $damage;
    }
}

class PokemonPlante extends Pokemon {
    protected $type = 'Plant';

    protected function calculateEffectiveness(Pokemon $target, $damage) {
        if ($target->getType() == 'Water') return $damage * 2;
        if ($target->getType() == 'Plant' || $target->getType() == 'Fire') return $damage * 0.5;
        return $damage;
    }
}

function initPokemonBattle() {
    $attack = new AttackPokemon(10, 15, 2, 30);

    $charizard = new PokemonFeu('Charizard', 100, $attack);
    $blastoise = new PokemonEau('Blastoise', 100, $attack);
    $venusaur = new PokemonPlante('Venusaur', 100, $attack);

    return [$charizard, $blastoise, $venusaur];
}

function simulateBattle(Pokemon $pokemon1, Pokemon $pokemon2) {
    $pokemon1->resetHP();
    $pokemon2->resetHP();

    echo "<div style='border: 1px solid #ccc; padding: 10px; margin-bottom: 20px;'>";
    echo "<h3>Battle between {$pokemon1->getName()} ({$pokemon1->getType()}) vs {$pokemon2->getName()} ({$pokemon2->getType()})</h3>";

    $round = 1;
    while (!$pokemon1->isDead() && !$pokemon2->isDead()) {
        echo "<p><strong>Round $round:</strong> ";
        $pokemon1->attack($pokemon2);
        if ($pokemon2->isDead()) break;
        $pokemon2->attack($pokemon1);
        echo "</p>";
        $round++;
        if ($round > 20) break;
    }

    $winner = $pokemon1->isDead() ? $pokemon2 : $pokemon1;
    echo "<h4 style='color: green;'>🏆 {$winner->getName()} wins the battle!</h4>";
    echo "</div>";
}

echo "<!DOCTYPE html><html><head><title>Pokemon Battle</title></head><body>";
echo "<h1>Pokemon Type Battle Simulation</h1>";

list($charizard, $blastoise, $venusaur) = initPokemonBattle();

simulateBattle($charizard, $venusaur);
simulateBattle($blastoise, $charizard);
simulateBattle($venusaur, $blastoise);

echo "</body></html>";
