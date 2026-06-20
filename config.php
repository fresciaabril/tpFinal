<?php

// 1. Indicamos el uso del namespace de Medoo
use Medoo\Medoo;

// 2. Incluimos el framework Medoo que ya tenés hecho
require_once 'Medoo.php';

// 3. Inicializamos la conexión a la base de datos con tus parámetros
$database = new Medoo([
    'type' => 'mariadb',
    'host' => 'localhost',
    'database' => 'torneo_duelos',
    'username' => 'root',
    'password' => ''
]);

/*
 * =========================================================================
 * EJEMPLO DE INSERCIÓN COMPATIBLE
 * =========================================================================
 
/*
// Ejemplo con un Guerrero:
$personaje = new Guerrero("milo", 1, 100, 50, 0, 0, "disponible", 50, 100);

// Para cumplir con tu columna "arma" (que guarda un identificador entero o string),
// verificamos si tiene un objeto Arma asignado. Si no, va como null.
$armaValor = ($personaje->getArma() !== null) ? $personaje->getArma()->getId() : null;

$data = [
    "nombre"         => $personaje->getNombre(), 
    "nivel"          => $personaje->getNivel(),
    "puntosVida"     => $personaje->getPuntosVida(),
    "energia"        => $personaje->getEnergia(),
    "duelosGanados"  => $personaje->getDuelosGanados(),
    "duelosPerdidos" => $personaje->getDuelosPerdidos(),
    "estado"         => $personaje->getEstado(),
    "arma"           => $armaValor, // Se inserta el ID o NULL en tu columna exacta
    
    // Columnas del Guerrero
    "fuerza"         => $personaje->getFuerza(),
    "armadura"       => $personaje->getArmadura(),
    
    // Al ser un Guerrero, el resto de las columnas específicas van explícitamente en NULL
    "mana"           => null,
    "inteligencia"   => null,
    "precision"      => null,
    "velocidad"      => null
];

// Medoo procesará la inserción respetando tu tabla tal cual está en la captura
$database->insert("personajes", $data*/

