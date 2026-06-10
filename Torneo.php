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
	public function getPersonajes(){
		return $this->personajes;
	}
	public function setPersonajes($personajes){
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
	public function agregarPersonaje(){
		return ;
	}
	public function agregarArma(){
		return ;
	}
	public function agregarArena(){
		return ;
	}
	public function equiparArma(){
		return ;
	}
	public function registrarDuelo(){
		return ;
	}
	public function realizarDuelo(){
		return ;
	}
	public function listarPersonajes(){
		return ;
	}
	public function listarArmas(){
		return ;
	}
	public function listarArenas(){
		return ;
	}
	public function listarDuelos(){
		$duelos = getDuelos();
		$acumular = 0;
		$i = 1;
		foreach ($duelos as $duelo){
			$acumular = "El duelo ".$i." es ".$duelo."\n";
			$i++;
		}
		return $acumular;
	}
	public function rankingPersonajes(){
		return ;
	}	
}
