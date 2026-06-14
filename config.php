<?php

use Medoo\Medoo;

require_once 'Medoo.php';

$database = new Medoo([
    'type' => 'mariadb',
    'host' => 'localhost',
    'database' => 'torneo_duelos',
    'username' => 'root',
    'password' => ''
]);

$personaje = new Guerrero("milo", 1, 100, 50, 0, 0, "espada", 50, 100);
$data = ["nombre" => $personaje->getNombre(), 
    "nivel" => $personaje->getNivel(),
    "puntosVida"  => $personaje->getPuntosVida(),
    "energia" => $personaje->getEnergia(),
    "duelosGanados" => $personaje->getDuelosGanados(),
    "duelosPerdidos" => $personaje->getDuelosPerdidos(),
    "arma" => $personaje->getArma(),
    "fuerza" => $personaje->getFuerza(),
    "armadura" => $personaje->getArmadura()];

$database->insert("personajes", $data);