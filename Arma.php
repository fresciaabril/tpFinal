<?php

class Arma {
	private int $id;
	private string $nombre;
	private string $tipo;
	private int $danioBase;
	private int $nivelMinimo;
	private string $estado;

	public function __construct($nombre, $tipo, $danioBase, $nivelMinimo, $estado = "disponible", $id = null ){
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
        if ($this->getEstado() === 'disponible' && $personaje->getNivel() > $this->getNivelMinimo()){
        	$bandera=true;
        }
        return $bandera;
	}

	public function __toString(){
		return 
		"--------------------------------------------------- \n" .
		"Nombre: " . $this->getNombre().
		"\n Tipo: " . $this->getTipo().
		"\n Daño base: " . $this->getDanioBase().
		"\n Nivel minimo: " . $this->getNivelMinimo().
		"\n Estado: " . $this->getEstado() . 
		"\n ---------------------------------------------------" ;
	}

}
