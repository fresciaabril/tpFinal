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