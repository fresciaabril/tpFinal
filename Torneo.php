<?php
	include_once 'Arma.php';
	include_once 'Arena.php';
    include_once 'config.php';
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
        private $db;
		

		public function __construct() {
            global $database;
			$this->personajes = [];
			$this->armas = [];
			$this->arenas = [];
			$this->duelos = [];
            $this->db = $database;
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

        
        // BUSCAR UN PERSONAJE POR ID Y TRANSFORMARLO EN OBJETO
        public function obtenerPersonajePorId($id) {
            $personaje = $this->db->get("personajes", "*", ["id" => $id]);
            $obj = null;

            if ($personaje) {
                $objArma = null;
                if (!empty($personaje["arma"])) {
                    $objArma = $this->obtenerArmaPorId($personaje["arma"]);
                }

                //DEPENDE EL TIPO DE PERSONAJE
                if ($personaje["fuerza"] !== null) {
                    // Es un Guerrero
                    $obj = new Guerrero(
                        $personaje["nombre"], 
                        $personaje["nivel"], 
                        $personaje["puntosVida"], 
                        $personaje["energia"], 
                        $personaje["duelosGanados"], 
                        $personaje["duelosPerdidos"], 
                        $objArma, 
                        $personaje["id"], 
                        $personaje["estado"]
                    );
                    $obj->setFuerza($personaje["fuerza"]);
                    $obj->setArmadura($personaje["armadura"]);

                } elseif ($personaje["mana"] !== null) {
                    // Es un Mago
                    $obj = new Mago(
                        $personaje["nombre"], 
                        $personaje["nivel"], 
                        $personaje["puntosVida"], 
                        $personaje["energia"], 
                        $personaje["duelosGanados"], 
                        $personaje["duelosPerdidos"], 
                        $objArma, 
                        $personaje["id"], 
                        $personaje["estado"]
                    );
                    $obj->setMana($personaje["mana"]);
                    $obj->setInteligencia($personaje["inteligencia"]);

                } else {
                    // Es un Arquero
                    $obj = new Arquero(
                        $personaje["nombre"], 
                        $personaje["nivel"], 
                        $personaje["puntosVida"], 
                        $personaje["energia"], 
                        $personaje["duelosGanados"], 
                        $personaje["duelosPerdidos"], 
                        $objArma, 
                        $personaje["id"], 
                        $personaje["estado"]
                    );
                    $obj->setPrecision($personaje["precision"]);
                    $obj->setVelocidad($personaje["velocidad"]);
                }
            }
            return $obj;
        }

        
        // BUSCAR UN ARMA POR ID Y TRANSFORMARLA EN OBJETO
        public function obtenerArmaPorId($id) {
            $arma = $this->db->get("armas", "*", ["id" => $id]);
            $objArma = null;
            if ($arma) {
                $objArma = new Arma(
                    $arma["id"], 
                    $arma["nombre"], 
                    $arma["tipo"], 
                    $arma["danioBase"], 
                    $arma["nivelMinimo"], 
                    $arma["estado"]
                );
            }
            return $objArma;
        }


        public function equiparArma($personaje, $arma) {
            $resultado = [
                "exito"   => false,
                "mensaje" => ""
            ];

            if (!$personaje->puedeDuelar()) {
                $resultado["mensaje"] = "El personaje no está disponible.\n";
            } elseif (!$arma->puedeSerEquipadaPor($personaje)) {
                $resultado["mensaje"] = "\n❌ El arma no puede ser equipada (no cumple nivel o está rota/ocupada).\n";
              }else {
                if ($personaje->getArma() !== null) {
                    $personaje->getArma()->setEstado("disponible");
                }
                $personaje->setArma($arma);
                $arma->setEstado("equipada");

                $resultado["mensaje"] = $personaje->getNombre() . "equipó " . $arma->getNombre(). "\n";
                $resultado["exito"]   = true;
            }
            return $resultado;
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


        /**
         * FUNCIÓN AUXILIAR PARA EL UASORT()
         * Compara la cantidad de duelos ganados entre dos objetos personaje.
         * Ponemos al menor abajo (devuelve 1) para que el ranking quede descendente
         */

        private function cmpDuelos($a, $b) {
            $orden = 0;

            if ($a->getDuelosGanados() == $b->getDuelosGanados()) {
                // Si tienen las mismas victorias, quedan en la misma posición
                $orden = 0;
            } elseif ($a->getDuelosGanados() < $b->getDuelosGanados()) {
                // Si el primero tiene MENOS victorias que el segundo, lo manda para abajo
                $orden = 1; 
            } else {
                // Si el primero tiene MÁS victorias, lo sube en el ranking
                $orden = -1;
            }

            // Un solo return al final con el resultado de la comparación (-1, 0 o 1)
            return $orden;
        }


		public function rankingPersonajes($database) {
            $arregloPersonajes = [];
            
            // Usamos $this->listar($database) que es tu función unificada
            foreach ($this->listarPersonajes($database) as $personaje) {
                $arregloPersonajes[$personaje->getId()] = $personaje;
            }

            // Usamos uasort llamando a nuestra función 'cmpDuelos' tal cual el ejemplo
            uasort($arregloPersonajes, [$this, 'cmpDuelos']);
            $ranking = "--- RANKING DE PERSONAJES ---\n";
            $puesto = 1;
            foreach ($arregloPersonajes as $personaje) {
                // Reemplaza el código por el número real que tiene guardado
                $ranking .= "{$puesto}° - " . $personaje->getNombre() . " (" . $personaje->getDuelosGanados() . " victorias)\n";
                $puesto++;
            }
            return $ranking;
        }


        public function registrarDuelo($duelo){
            $colDuelos = $this->getDuelos();
            array_push($colDuelos, $duelo);
            $this->setDuelos($colDuelos);
        }


        public function realizarDuelo(){
            foreach($this->getDuelos() as $duelo){
                if($duelo->getEstado() == true){
                    $this->registrarDuelo($duelo);
                }
            }
        }
        
        
	}
	