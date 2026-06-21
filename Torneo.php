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
			foreach($this->getArmas() as $arma){
				$estado = $arma->getEstado();
				if($estado == "disponible"){
					foreach ($this->getPersonaje() as $personaje){
						$personaje->setArma($arma);
					}
				}
			}
		}


    

    /**
     * Lista los personajes aplicando filtros variables.
     * $database Conexión a la base de datos
     * $filtros Filtros asociativos opcionales para el WHERE
     * Colección de objetos Personaje*/

        public function listarPersonajes($database, $filtros = []) {
            $colPersonajes = null;
            
            // Copiamos los filtros y los ordenamos en forma ascendente
            $condiciones = $filtros;
            $condiciones["ORDER"] = ["nombre" => "ASC"]; 

            // SELECT * FROM personajes WHERE [filtros] ORDER BY nombre ASC
            $datosPersonajes = $database->select("personajes", "*");

            // si se pudo hacer la consulta es true
            if ($datosPersonajes !== false) {
                $colPersonajes = []; 

                // Recorremos los registros que nos pasa  la base de datos 
                foreach ($datosPersonajes as $datoPersonaje) {
                    $objPersonaje = null;

                    // verificamos el tipo de clase hija 
                    if ($datoPersonaje['tipoPersonaje'] === 'guerrero') {
                        $objPersonaje = new Guerrero(
                            $datoPersonaje['nombre'], 
                            $datoPersonaje['nivel'], 
                            $datoPersonaje['puntosVida'], 
                            $datoPersonaje['energia'],
                            $datoPersonaje['duelosGanados'], 
                            $datoPersonaje['duelosPerdidos'], 
                            $datoPersonaje['estado'],
                            $datoPersonaje['fuerza'], 
                            $datoPersonaje['armadura'], 
                            $datoPersonaje['id']
                        );
                    } elseif ($datoPersonaje['tipoPersonaje'] === 'mago') {
                        $objPersonaje = new Mago(
                            $datoPersonaje['nombre'], 
                            $datoPersonaje['nivel'], 
                            $datoPersonaje['puntosVida'], 
                            $datoPersonaje['energia'],
                            $datoPersonaje['duelosGanados'], 
                            $datoPersonaje['duelosPerdidos'], 
                            $datoPersonaje['estado'],
                            $datoPersonaje['mana'], 
                            $datoPersonaje['inteligencia'], 
                            $datoPersonaje['id']
                        );
                    } elseif ($datoPersonaje['tipoPersonaje'] === 'arquero') {
                        $objPersonaje = new Arquero(
                            $datoPersonaje['nombre'], 
                            $datoPersonaje['nivel'], 
                            $datoPersonaje['puntosVida'], 
                            $datoPersonaje['energia'],
                            $datoPersonaje['duelosGanados'], 
                            $datoPersonaje['duelosPerdidos'], 
                            $datoPersonaje['estado'],
                            $datoPersonaje['precisionPersonaje'], 
                            $datoPersonaje['velocidad'], 
                            $datoPersonaje['id']
                        );
                    }

                    //Si el idArmaEquipada esta en la bd
                    if ($objPersonaje !== null && $datoPersonaje['idArmaEquipada'] !== null) {
                        // buscamos los datos por su id
                        $datosArma = $database->get("armas", "*", ["id" => $datoPersonaje['idArmaEquipada']]);
                        if ($datosArma) {
                            // Creamos el objeto Arma
                            $objArma = new Arma(
                                $datosArma['id'], 
                                $datosArma['nombre'], 
                                $datosArma['tipo'],
                                $datosArma['danioBase'], 
                                $datosArma['nivelMinimo'], 
                                $datosArma['estado']
                            );
                            // seteamos el arma 
                            $objPersonaje->setArma($objArma); 
                        }
                    }

                    // Si el objeto personaje se armó lo agregamos a la coleccion
                    if ($objPersonaje !== null) {
                        array_push($colPersonajes, $objPersonaje);
                    }
                }
            } else {
                // Si la base de datos falla, damos un mensaje de error
                // el throw new Exception tira un mensaje si no se pudo cargar el personaje en la bd
                throw new Exception("Error al intentar procesar los registros de personajes");
            }
            return $colPersonajes;
        }


    /**
     * Trae todas las armas desde la base de datos y las convierte en objetos.
     * $database Conexión activa del ORM.
     *  Colección de objetos Arma.
     */

        public function listarArmas($database) {
            $colArmas = null;
            $datosArmas = $database->select("armas", "*", ["ORDER" => ["nombre" => "ASC"]]);
            if ($datosArmas !== false) {
                $colArmas = []; 
                foreach ($datosArmas as $datoArma) {
                    $objArma = new Arma(
                        $datoArma['id'], 
                        $datoArma['nombre'], 
                        $datoArma['tipo'], 
                        $datoArma['danioBase'], 
                        $datoArma['nivelMinimo'], 
                        $datoArma['estado']
                    );
                    array_push($colArmas, $objArma);
                }
            } else {
                // mensaje de error
                throw new Exception("No se pudo acceder a la tabla de armas");
            }
            return $colArmas;
        }


    /**
     * Trae todas las arenas desde la base de datos y las convierte en objetos.
     * $database Conexión activa del ORM.
     * Colección de objetos Arena.
     */

        public function listarArenas($database) {
            $colArenas = null;
    
            //SELECT * FROM arenas ORDER BY nombre ASC
            $datosArenas = $database->select("arenas", "*", ["ORDER" => ["nombre" => "ASC"]]);

            // Controlamos que la comunicación con phpMyAdmin haya funcionado
            if ($datosArenas !== false) {
                $colArenas = []; 
                foreach ($datosArenas as $datosArena) {
                    $objArena = new Arena(
                        $datosArena['nombre'],
                        $datosArena['dificultad'],
                        $datosArena['capacidadPublico'],
                        $datosArena['clima'],
                        $datosArena['id']
                    );
                    array_push($colArenas, $objArena);
                }
            } else {
                throw new Exception("Error: No se pudo acceder a la tabla de arenas.");
            }
            return $colArenas;
        }



    /**
     * Trae todos los duelos vinculando los objetos reales de personajes y arenas por su ID.
     * $database Conexión activa del ORM.
     * Colección de objetos Duelo completos.
     */
        
        public function listarDuelos($database) {
            $colDuelos = null;

            // 1. EFICIENCIA EN MEMORIA: Traemos todos los personajes y arenas ya convertidos en objetos
            $todosLosPersonajes = $this->listarPersonajes($database);
            $todasLasArenas = $this->listarArenas($database);

            // 2. Creamos un diccionario asociativo para buscar personajes al toque por su ID
            $personajesDic = [];
            foreach ($todosLosPersonajes as $p) {
                $personajesDic[$p->getId()] = $p;
            }

            // 3. Creamos un diccionario asociativo para buscar arenas al toque por su ID
            $arenasDic = [];
            foreach ($todasLasArenas as $a) {
                $arenasDic[$a->getId()] = $a;
            }

            // 4. Le pedimos a Medoo los registros puros de la tabla: SELECT * FROM duelos
            $filas = $database->select("duelos", "*");

            // Validamos el estado de la query
            if ($filas !== false) {
                $colDuelos = [];

                // Recorremos cada fila de la tabla duelos
                foreach ($filas as $fila) {
                    // si esta el id de ese personaje/arena le pasa todos sus datos, sino lo deja en nulo
                    $persona1 = $personajesDic[$fila['personaje1_id']] ?? null;
                    $persona2 = $personajesDic[$fila['personaje2_id']] ?? null;
                    $arena = $arenasDic[$fila['arena_id']] ?? null;

                    if ($persona1 !== null && $persona2 !== null && $arena !== null) {
                        $objDuelo = new Duelo(
                            $persona1,     
                            $persona2,     
                            $arena,  
                            $fila['fecha'],
                            $fila['ganador'] ?? "", //esto es por si no tiene un valor lo dejamos en vacio
                            $fila['estado'],
                            $fila['id']
                        );
                        array_push($colDuelos, $objDuelo);
                    }
                }
            } else {
                throw new Exception("No se pudo acceder al historial de duelos.");
            }
            return $colDuelos;
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
	