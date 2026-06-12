<?php
// Representa el torneo completo.
class Torneo {
	// colecciones
	private $personajes;
	private $armas;
	private $arenas;
	private $duelos;

	public function __construct($personajes, $armas, $arenas, $duelos) {
		$this->personajes = $personajes;
		$this->armas = $armas;
		$this->arenas = $arenas;
		$this->duelos = $duelos;
	}


	public function getPersonaje(){
		return $this->personajes;
	}

	public function setPersonaje($personajes){
		$this->personajes = $personajes;
	}


	public function getArmas(){
		return $this->armas;
	}

	public function setArmas($armas){
		$this->armas = $armas;
	}


	public function getArenas(){
		return $this->arenas;
	}

	public function setArenas($arenas){
		$this->arenas = $arenas;
	}


	public function getDuelos(){
		return $this->duelos;
	}

	public function setDuelos($duelos){
		$this->duelos = $duelos;
	}


	public function getPersonajes(){
		return $this->personajes;
	}

	public function setPersonajes($personajes){
		$this->personajes = $personajes;
	}


	// metodos

	public function agregarPersonaje($personaje){
		array_push($this->personajes, $personaje);
	}


	public function agregarArma($arma){
		array_push($this->armas, $arma);
	}


	public function agregarArena($arena){
		array_push($this->arenas, $arena);
	}


	public function equiparArma(){
		
	}


	public function registrarDuelo(){
		
	}


	public function realizarDuelo(){
		
	}


	public function listarPersonajes(){
		$cadena = "";
		foreach($this->getPersonaje() as $personaje){
			$cadena .= $personaje . "\n";
		}
		return $cadena;
	}


	public function listarArmas(){
		$cadena = "";
		foreach($this->getArmas() as $arma){
			$cadena .= $arma . "\n";
		}
		return $cadena;
	}


	public function listarArenas(){
		$cadena = "";
		foreach($this->getArenas() as $arena){
			$cadena .= $arena . "\n";
		}
		return $cadena;
	}


	public function listarDuelos(){
		$cadena = "";
		foreach($this->getDuelos() as $personaje){
			$cadena .= $personaje . "\n";
		}
		return $cadena;
	}


	public function rankingPersonajes(){ //SOLO LOS QUE TIENEN MAS DE 5 PARTIDAS GANADAS APARECEN
		$ranking = "";
		foreach($this->getPersonaje() as $personaje){
			if($personaje->getDuelosGanados() >= 5){
				$ranking .= $personaje . "\n";
			}
		}
		return $ranking;
	}	
}