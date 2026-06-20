<?php
	require_once 'config.php';
	include_once 'Arma.php';
	include_once 'Arena.php';
	include_once 'Guerrero.php';
	include_once 'Mago.php';
	include_once 'Arquero.php';
	include_once 'Duelo.php';
	
	class Torneo {
		// colecciones
		private $personajes = [];
		private $armas = [];
		private $arenas = [];
		private $duelos = [];
		

		public function __construct() {
			$this->personajes = [];
			$this->armas = [];
			$this->arenas = [];
			$this->duelos = [];
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
			foreach($this->getArmas as $arma){
				$estado = $arma->getEstado();
				if($estado == "disponible"){
					foreach ($this->getPersonaje() as $personaje){
						$personaje->setArma($arma);
					}
				}
			}
		}
		public function listarPersonajes(){
			$cadena = [];
			foreach($this->getPersonaje() as $personaje){
				array_push($cadena, $personaje);
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
			$cadena = [];
			foreach($this->getDuelos() as $duelo){
				array_push($cadena, $duelo);
			}
			return $cadena;
		}


		//FUNCION PARA IMPLEMENTAR CON EL UASORT()
		private function cmpDuelos($a, $b) {
			// Comparamos los duelos ganados de dos objetos personaje
			if ($a->getDuelosGanados() == $b->getDuelosGanados()) {
				$orden = 0;
			} elseif ($a->getDuelosGanados() < $b->getDuelosGanados()) {
				// Ponemos el menor abajo para que el ranking quede DESCENDENTE
				$orden = 1; 
			} else {
				$orden = -1;
			}
			return $orden;
		}

		public function rankingPersonajes() {
			// 1. Armamos el arreglo asociativo de objetos usando el ID de la base de datos como índice
			$arregloPersonajes = [];
			foreach ($this->listarPersonajes() as $personaje) {
				$arregloPersonajes[$personaje->getId()] = $personaje;
			}

			// 2. Usamos uasort llamando a nuestra función 'cmpDuelos' tal cual el ejemplo
			uasort($arregloPersonajes, [$this, 'cmpDuelos']);

			// 3. Ya con el arreglo ordenado, armamos el string para el menú
			$ranking = "--- RANKING DE PERSONAJES ---\n";
			$puesto = 1;
			
			foreach ($arregloPersonajes as $personaje) {
				//reemplaza el código por el número real que tiene guardado "{$puesto}° - " y queda asi "1° - "
				$ranking .= "{$puesto}° - " . $personaje->getNombre() . " (" . $personaje->getDuelosGanados() . " victorias)\n";
				$puesto++;
			}

			// 4. retornamos
			return $ranking;
		}



		public function realizarDuelo(){
			
		}

		public function registrarDuelo(){
			
		}


	}
	