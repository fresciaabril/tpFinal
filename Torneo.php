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
			
		}


		public function registrarDuelo(){
			
		}


		public function realizarDuelo(){
			
		}


		// =========================================================================
    // MÉTODOS DE PERSISTENCIA (LISTADOS BD A OBJETOS)
    // =========================================================================

    /**
     * Lista los personajes aplicando filtros variables.
     *  Medoo $database Conexión a la base de datos (Medoo)
     *  $filtros Opcional: Filtros asociativos para el WHERE (Ej: ["estado" => "lesionado"])
     *  Retorna la colección de objetos Personaje, o null si la consulta falla
     */
    public function listarPersonajes($database, $filtros = []) {
        $arrayPersonajes = null;
        $condiciones = $filtros;
        $condiciones["ORDER"] = ["nombre" => "ASC"]; 

        $filas = $database->select("personajes", "*");

        if ($filas !== false) {
            $arrayPersonajes = []; 

            foreach ($filas as $fila) {
                $objPersonaje = null;

                if ($fila['tipoPersonaje'] === 'guerrero') {
                    $objPersonaje = new Guerrero(
                        $fila['nombre'], $fila['nivel'], $fila['puntosVida'], $fila['energia'],
                        $fila['duelosGanados'], $fila['duelosPerdidos'], $fila['estado'],
                        $fila['fuerza'], $fila['armadura'], $fila['id']
                    );
                } elseif ($fila['tipoPersonaje'] === 'mago') {
                    $objPersonaje = new Mago(
                        $fila['nombre'], $fila['nivel'], $fila['puntosVida'], $fila['energia'],
                        $fila['duelosGanados'], $fila['duelosPerdidos'], $fila['estado'],
                        $fila['mana'], $fila['inteligencia'], $fila['id']
                    );
                } elseif ($fila['tipoPersonaje'] === 'arquero') {
                    $objPersonaje = new Arquero(
                        $fila['nombre'], $fila['nivel'], $fila['puntosVida'], $fila['energia'],
                        $fila['duelosGanados'], $fila['duelosPerdidos'], $fila['estado'],
                        $fila['precisionPersonaje'], $fila['velocidad'], $fila['id']
                    );
                }

                if ($objPersonaje !== null && $fila['idArmaEquipada'] !== null) {
                    $datosArma = $database->get("armas", "*", ["id" => $fila['idArmaEquipada']]);
                    if ($datosArma) {
                        $objArma = new Arma(
                            $datosArma['id'], $datosArma['nombre'], $datosArma['tipo'],
                            $datosArma['danioBase'], $datosArma['nivelMinimo'], $datosArma['estado']
                        );
                        $objPersonaje->setArma($objArma); 
                    }
                }

                if ($objPersonaje !== null) {
                    $arrayPersonajes[] = $objPersonaje;
                }
            }
        } else {
            throw new Exception("Error al intentar procesar los registros de personajes.");
        }

        return $arrayPersonajes;
    }

    /**
     * Trae todas las armas desde la base de datos y las convierte en objetos.
     *  Medoo $database Conexión activa del ORM.
     *  Colección de objetos Arma, o null si falla.
     */
    public function listarArmas($database) {
        $arrayArmas = null;
        $filas = $database->select("armas", "*", ["ORDER" => ["nombre" => "ASC"]]);

        if ($filas !== false) {
            $arrayArmas = []; 

            foreach ($filas as $fila) {
                $objArma = new Arma(
                    $fila['id'], 
                    $fila['nombre'], 
                    $fila['tipo'], 
                    $fila['danioBase'], 
                    $fila['nivelMinimo'], 
                    $fila['estado']
                );
                $arrayArmas[] = $objArma;
            }
        } else {
            throw new Exception("Error: No se pudo acceder a la tabla de armas.");
        }

        return $arrayArmas;
    }

    /**
     * Trae todas las arenas desde la base de datos y las convierte en objetos.
     *  Medoo $database Conexión activa del ORM.
     *  Colección de objetos Arena, o null si falla.
     */
    public function listarArenas($database) {
        $arrayArenas = null;
        $filas = $database->select("arenas", "*", ["ORDER" => ["nombre" => "ASC"]]);

        if ($filas !== false) {
            $arrayArenas = []; 

            foreach ($filas as $fila) {
                $objArena = new Arena(
                    $fila['nombre'],
                    $fila['dificultad'],
                    $fila['capacidadPublico'],
                    $fila['clima'],
                    $fila['id']
                );
                $arrayArenas[] = $objArena;
            }
        } else {
            throw new Exception("Error: No se pudo acceder a la tabla de arenas.");
        }

        return $arrayArenas;
    }

    /**
     * Trae todos los duelos vinculando los objetos reales de personajes y arenas por su ID.
     *  Medoo $database Conexión activa del ORM.
     * Colección de objetos Duelo completos, o null si falla.
     */
    public function listarDuelos($database) {
        $arrayDuelos = null;

        $todosLosPersonajes = $this->listarPersonajes($database);
        $todasLasArenas = $this->listarArenas($database);

        $personajesDic = [];
        foreach ($todosLosPersonajes as $p) {
            $personajesDic[$p->getId()] = $p;
        }

        $arenasDic = [];
        foreach ($todasLasArenas as $a) {
            $arenasDic[$a->getId()] = $a;
        }

        $filas = $database->select("duelos", "*");

        if ($filas !== false) {
            $arrayDuelos = [];

            foreach ($filas as $fila) {
                $p1 = $personajesDic[$fila['personaje1_id']] ?? null;
                $p2 = $personajesDic[$fila['personaje2_id']] ?? null;
                $arena = $arenasDic[$fila['arena_id']] ?? null;

                if ($p1 !== null && $p2 !== null && $arena !== null) {
                    $objDuelo = new Duelo(
                        $p1,     
                        $p2,     
                        $arena,  
                        $fila['fecha'],
                        $fila['ganador'] ?? "", 
                        $fila['estado'],
                        $fila['id']
                    );
                    $arrayDuelos[] = $objDuelo;
                }
            }
        } else {
            throw new Exception("Error : No se pudo acceder al historial de duelos.");
        }

        return $arrayDuelos;
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

		public function rankingPersonajes($database) {
            // 1. CORREGIDO: Recibe $database y llama a la nueva función listar() pasándole la conexión
            $arregloPersonajes = [];
            
            // Usamos $this->listar($database) que es tu función unificada
            foreach ($this->listarPersonajes($database) as $personaje) {
                $arregloPersonajes[$personaje->getId()] = $personaje;
            }

            // 2. Usamos uasort llamando a nuestra función 'cmpDuelos' tal cual el ejemplo
            uasort($arregloPersonajes, [$this, 'cmpDuelos']);

            // 3. Ya con el arreglo ordenado, armamos el string para el menú
            $ranking = "--- RANKING DE PERSONAJES ---\n";
            $puesto = 1;
            
            foreach ($arregloPersonajes as $personaje) {
                // Reemplaza el código por el número real que tiene guardado
                $ranking .= "{$puesto}° - " . $personaje->getNombre() . " (" . $personaje->getDuelosGanados() . " victorias)\n";
                $puesto++;
            }

            // 4. UN SOLO return al final de todo el método principal
            return $ranking;
        }
	}
	