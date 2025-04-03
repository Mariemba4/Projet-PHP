<?php

class AttackPokemon {
    public $attackMinimal;
    public $attackMaximal;
    public $specialAttack;
    public $probabilitySpecialAttack;

    public function __construct($attackMinimal, $attackMaximal, $specialAttack, $probabilitySpecialAttack) {
        $this->attackMinimal = $attackMinimal;
        $this->attackMaximal = $attackMaximal;
        $this->specialAttack = $specialAttack;
        $this->probabilitySpecialAttack = $probabilitySpecialAttack;
    }

    public function getAttack() {
        $random = rand(0, 100);
        $attackPower = rand($this->attackMinimal, $this->attackMaximal);

        if ($random <= $this->probabilitySpecialAttack) {
            $attackPower *= $this->specialAttack;
        }

        return $attackPower;
    }
}

class Pokemon {
    public $name;
    public $url;
    public $hp;
    public $attackPokemon;

    public function __construct($name, $url, $hp, AttackPokemon $attackPokemon) {
        $this->name = $name;
        $this->url = $url;
        $this->hp = $hp;
        $this->attackPokemon = $attackPokemon;
    }
    	
    public function getName() {
        return $this->name;}
    public function getUrl() {
        return $this->url;}
    public function getHp() {
        return $this->hp;}
    public function getAttackPokemon() {
        return $this->attackPokemon;}
    public function setName($name) {
        $this->name = $name;}
    public function setUrl($url) {
        $this->url = $url;}
    public function setHp($hp) {
        $this->hp = $hp;}
    public function setAttackPokemon(AttackPokemon $attackPokemon) {
        $this->attackPokemon = $attackPokemon;}

        	
     public function isDead() {
        return $this->hp <= 0;}

    public function attack(Pokemon $p) {
        $attackPoints = $this->attackPokemon->getAttack();
        if ($attackPoints > 0) {
            $isSpecialAttack = $attackPoints != rand($this->attackPokemon->attackMinimal, $this->attackPokemon->attackMaximal);
            if ($isSpecialAttack) {
                $damage = $attackPoints * $this->attackPokemon->specialAttack;
                echo $this->name . " attaque " . $p->getName() . " avec une attaque spéciale, infligeant " . $damage . " points de dégâts!\n";
            } else {
                $damage = $attackPoints;
                echo $this->name . " attaque " . $p->getName() . " avec une attaque normale, infligeant " . $damage . " points de dégâts.\n";
            }

            $p->setHp($p->getHp() - $damage);
            if ($p->isDead()) {
                echo $p->getName() . " est mort!";
            }
        }
    }

    public function whoAmI() {
        echo "Nom : " . $this->name . "\n";
        echo "URL de l'image : " . $this->url . "\n";
        echo "HP : " . $this->hp . "\n";
    }
}


?>

