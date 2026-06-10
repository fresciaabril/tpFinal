<?php
// id
// nombre
// tipo
// danioBase
// nivelMinimo
// estado (disponible, equipada, rota)

// calcularDanio()
// puedeSerEquipadaPor(Personaje $personaje)

// Un arma rota no puede equiparse.
// Un personaje debe cumplir el nivel mínimo para equipar un arma.
// Un arma equipada no puede asignarse a otro personaje
require_once 'config.php';
class Arma {
	private int $id;
	private string $nombre;
	private string $tipo;
	private int $danioBase;
	private int $nivelMinimo;
	private string $estado;

	public function __construct($id, $nombre, $tipo, $danioBase, $nivelMinimo, $estado) {
		$this->id = $id;
		$this->nombre = $nombre;
		$this->tipo = $tipo;
		$this->danioBase = $danioBase;
		$this->nivelMinimo = $nivelMinimo;
		$this->estado = $estado;
	}
	public function getId(){
		return $this->id;
	}
	public function setId($id){
		$this->id = $id;
	}
	public function getNombre(){
		return $this->nombre;
	}
	public function setNombre($nombre){
		$this->nombre = $nombre;
	}
	public function getTipo(){
		return $this->tipo;
	}
	public function setTipo($tipo){
		$this->tipo = $tipo;
	}
	public function getDanioBase(){
		return $this->danioBase;
	}
	public function setDanioBase($danioBase){
		$this->danioBase = $danioBase;
	}
	public function getNivelMinimo(){
		return $this->nivelMinimo;
	}
	public function setNivelMinimo($nivelMinimo){
		$this->nivelMinimo = $nivelMinimo;
	}
	public function getEstado(){
		return $this->estado;
	}
	public function setEstado($estado){
		$this->estado = $estado;
	}
	// metodos
	public function calcularDanio(){
		return $this->getDanioBase();
	}
	public function puedeSerEquipadaPor(Personaje $personaje){
		$bandera=false;
        if ($this->estado === 'disponible'){
        	if($personaje->getNivel() > $this->nivelMinimo){
        		$bandera=true;
        	}
        }
        return $bandera;
	}
}
