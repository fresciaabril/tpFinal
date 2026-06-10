<?php
require_once 'config.php';
class Duelo {
	private int $id;
	private string $personaje1;
	private string $personaje2;
	private int $arena;
	private int $fecha;
	private string $estado; // pendiente, realizado, cancelado
	private string $ganador;

	public function __construct($id, $personaje1, $personaje2, $arena, $fecha, $estado, $ganador) {
		$this->id = $id;
		$this->personaje1 = $personaje1;
		$this->personaje2 = $personaje2;
		$this->arena = $arena;
		$this->fecha = $fecha;
		$this->estado = $estado;
		$this->ganador = $ganador;
	}
	public function puedeRealizarse(){
		return ;
	}
	// metodos
	public function realizarDuelo(){
		return ;
	}
	public function obtenerGanador(){
		return ;
	}
}