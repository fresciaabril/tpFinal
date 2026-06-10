<?php
// Representa un enfrentamiento entre dos personajes.
class Duelo {
	private $id;
	private $personaje1;
	private $personaje2;
	private $arena;
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
	public function getId(){
		return $this->id;
	}
	public function setId($id){
		$this->id = $id;
	}
	public function getPersonaje1(){
		return $this->personaje1;
	}
	public function setPersonaje1($personaje1){
		$this->personaje1 = $personaje1;
	}
	public function getPersonaje2(){
		return $this->personaje2;
	}
	public function setPersonaje2($personaje2){
		$this->personaje2 = $personaje2;
	}
	public function getArena(){
		return $this->arena;
	}
	public function setArena($arena){
		$this->arena = $arena;
	}
	public function getFecha(){
		return $this->fecha;
	}
	public function setFecha($fecha){
		$this->fecha = $fecha;
	}
	public function getEstado(){
		return $this->estado;
	}
	public function setEstado($estado){
		$this->estado = $estado;
	}
	public function getGanador(){
		return $this->ganador;
	}
	public function setGanador($ganador){
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
