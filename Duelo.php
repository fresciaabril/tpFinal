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

	public function __construct( $personaje1, $personaje2, $arena, $fecha, $ganador, $estado, $id = null) {
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
		$puede = false;
		$personaje1 = $this->getPersonaje1();
		$personaje2 = $this->getPersonaje2();
		if($this->getPersonaje1()->getId() != $this->getPersonaje2()->getId()){
			if($personaje1->getEstado() === "disponible" && $personaje2->getEstado() === "disponible"){
				$puede = true;
			}
		}
		return $puede;
	}

	public function realizarDuelo(){
		return ;
	}

	public function ganador($personaje){
		$nivel = $personaje->getNivel() + 1;
		$personaje->setNivel($nivel);

		$energia = $personaje->getEnergia() + 5;
		$personaje->setEnergia($energia);

		$cant = $personaje->getDuelosGanados() + 1;
		$personaje->setDuelosGanados($cant);
	}



	public function obtenerGanador(){
		$ganador = null;
		$personaje1 = $this->getPersonaje1();
		$modArena1 = $this->getArena()->calcularModificadorArena($personaje1);
		$poder1 = $personaje1->calcularPoderTotal($modArena1);

		$personaje2 = $this->getPersonaje2();
		$modArena2 = $this->getArena()->calcularModificadorArena($personaje2);
		$poder2 = $personaje2->calcularPoderTotal($modArena2);

		if($poder1 > $poder2){
			$ganador = $personaje1;
			$this->ganador($personaje1);

			$danio1 = $poder1 - $poder2;
			$personaje2->recibirDanio($danio1);

			$cantPerdidos = $personaje2->getDuelosPerdidos() + 1;
			$personaje2->setDuelosPerdidos($cantPerdidos);

			$energia = $personaje2-> getEnergia() - 2;
			$personaje2->setEnergia($energia);

		}else{
			$ganador = $personaje2;
			$this->ganador($personaje2);

			$danio2 = $poder2 - $poder1;
			$personaje1->recibirDanio($danio2);

			$cantPerdidos = $personaje1->getDuelosPerdidos() + 1;
			$personaje1->setDuelosPerdidos($cantPerdidos);

			$energia = $personaje1-> getEnergia() - 2;
			$personaje1->setEnergia($energia);
		}
		return $ganador;
	}

	// public function __toString(){
		
	// }

}
