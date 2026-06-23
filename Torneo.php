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
                if (!empty($personaje["idArmaEquipada"])) {
                    $objArma = $this->obtenerArmaPorId($personaje["idArmaEquipada"]);
                }

                // DEPENDE DEL TIPO DE PERSONAJE 
                if ($personaje["tipoPersonaje"] == 'guerrero') {
                    $obj = new Guerrero(
                        $personaje["nombre"], 
                        $personaje["nivel"], 
                        $personaje["puntosVida"], 
                        $personaje["energia"], 
                        $personaje["duelosGanados"], 
                        $personaje["duelosPerdidos"], 
                        $personaje["estado"], 
                        $personaje["fuerza"], 
                        $personaje["armadura"], 
                        $personaje["id"]     
                    );
                    $obj->setArma($objArma);

                } elseif ($personaje["tipoPersonaje"] == 'mago') {
                    $obj = new Mago(
                        $personaje["nombre"], 
                        $personaje["nivel"], 
                        $personaje["puntosVida"], 
                        $personaje["energia"], 
                        $personaje["duelosGanados"], 
                        $personaje["duelosPerdidos"], 
                        $personaje["estado"], 
                        $personaje["mana"], 
                        $personaje["inteligencia"], 
                        $personaje["id"]     
                    );
                    $obj->setArma($objArma);

                } elseif ($personaje["tipoPersonaje"] == 'arquero') {
                    $obj = new Arquero(
                        $personaje["nombre"], 
                        $personaje["nivel"], 
                        $personaje["puntosVida"], 
                        $personaje["energia"], 
                        $personaje["duelosGanados"], 
                        $personaje["duelosPerdidos"], 
                        $personaje["estado"], 
                        $personaje["precisionPersonaje"], 
                        $personaje["velocidad"], 
                        $personaje["id"]     
                    );
                    $obj->setArma($objArma);
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
                    $arma["nombre"], 
                    $arma["tipo"], 
                    $arma["danioBase"], 
                    $arma["nivelMinimo"], 
                    $arma["estado"],
                    $arma["id"] 
                );
            }
            return $objArma;
        }


        public function obtenerArenaPorId($id, $database) {
        // 1. Buscamos todas las columnas que necesitemos en la tabla arenas
        $resultado = $database->get("arenas", 
                ["id", "nombre", "dificultad", "capacidadPublico", "clima"], 
                ["id" => $id]
        );

        if ($resultado) {
                $objArena = new Arena(
                        $resultado['nombre'], 
                        $resultado['dificultad'], 
                        $resultado['capacidadPublico'], 
                        $resultado['clima'],
                        $resultado['id']
                );
        } else {
                $objArena = null;
        }

        return $objArena;
    }


        public function equiparArma($personaje, $arma) {
            $resultado = [
                "exito"   => false,
                "mensaje" => ""
            ];

            if (!$personaje->puedeDuelar()) {
                $resultado["mensaje"] = "El personaje no está disponible.\n";
            } elseif (!$arma->puedeSerEquipadaPor($personaje)) {
                $resultado["mensaje"] = "\n El arma no puede ser equipada.\n";
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

        //1. Listar todos los personajes
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
                    if ($datoPersonaje['tipoPersonaje'] == 'guerrero') {
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
            $todosLosPersonajes = $this->listarPersonajes($database);
            $todasLasArenas = $this->listarArenas($database);

            $personajesCol = [];
            foreach ($todosLosPersonajes as $personaje) {
                $personajesCol[$personaje->getId()] = $personaje;
            }

            $arenasCol = [];
            foreach ($todasLasArenas as $arena) {
                $arenasCol[$arena->getId()] = $arena;
            }

            $filas = $database->select("duelos", "*");

            if ($filas !== false) {
                $colDuelos = [];

                foreach ($filas as $fila) {
                    $persona1 = $personajesCol[$fila['idPersonaje1']] ?? null;
                    $persona2 = $personajesCol[$fila['idPersonaje2']] ?? null;
                    $arena = $arenasCol[$fila['idArena']] ?? null;

                    if ($persona1 !== null && $persona2 !== null && $arena !== null) {
                        $objDuelo = new Duelo(
                            $persona1,     
                            $persona2,     
                            $arena,  
                            $fila['fecha'],
                            $fila['ganador'] ?? "", 
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

        // 5. LISTAR ARMAS DISPONIBLES
        public function listarArmasDisponibles($database) {
            $colArmas = null;
            $datosArmas = $database->select("armas", "*", [
                "estado" => "disponible",
                "ORDER" => ["nombre" => "ASC"]
            ]);
            if ($datosArmas != false) {
                $colArmas = []; 
                foreach ($datosArmas as $datoArma) {
                    $objArma = new Arma(
                        $datoArma['nombre'], 
                        $datoArma['tipo'], 
                        $datoArma['danioBase'], 
                        $datoArma['nivelMinimo'], 
                        $datoArma['estado'],
                        $datoArma['id']
                    );
                    array_push($colArmas, $objArma);
                }
            }
            return $colArmas;
        }

        // 11. MOSTRAR EL PERSONAJE CON MAYOR CANTIDAD DE VICTORIAS
        public function personajeConMasVictorias($database) {
            // Traemos el que tenga más victorias ordenando de forma descendente y pidiendo límite 1
            $datos = $database->select("personajes", "id", [
                "ORDER" => ["duelosGanados" => "DESC"],
                //trae solo la primer fila, que al argregarlo de forma desc queda primero el que tiene mas victorias
                "LIMIT" => 1
            ]);
            
            $objPersonaje = null;
            if (count($datos) > 0) {
                $objPersonaje = $this->obtenerPersonajePorId($datos[0]);
            }
            return $objPersonaje;
        }

        // 12. MOSTRAR EL PORCENTAJE DE VICTORIAS DE CADA PERSONAJE
        public function calcularPorcentajeVictorias($database) {
            $lista = $this->listarPersonajes($database);
            $mensaje = "--- PORCENTAJE DE VICTORIAS ---\n";
            
            foreach ($lista as $personaje) {
                $totales = $personaje->getDuelosGanados() + $personaje->getDuelosPerdidos();
                $porcentaje = 0;
                if ($totales > 0) {
                    $porcentaje = ($personaje->getDuelosGanados() / $totales) * 100;
                }                                         //round sirve para redondear decimales,y que queden los primeros 2 num
                $mensaje .= $personaje->getNombre() . ": " . round($porcentaje, 2) . "% de victorias \n Jugados: " . $totales . "\n";
            }
            return $mensaje;
        }

        // 13. MOSTRAR LA ARENA DONDE MÁS DUELOS SE REALIZARON
        public function arenaMasPopular($database) {
            // select agrupado y ordenando por el conteo de filas
            $resultado = $database->select("duelos", "idArena", [
                "GROUP" => "idArena",
                "ORDER" => [ "idArena" => "DESC" ],
                "LIMIT" => 1
            ]);

            $objArena = null;
            
            if (count($resultado) > 0) {
                $objArena = $this->obtenerArenaPorId($resultado[0], $database);
            }
            
            return $objArena;
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
                $ranking .= $puesto . ") " . $personaje->getNombre() . " '" . $personaje->getDuelosGanados() . " victorias' \n";
                $puesto++;
            }
            return $ranking;
        }


        public function registrarDuelo($personaje1, $personaje2, $arena) {
            $exito = true;

            if ($personaje1->getId() === $personaje2->getId()) {
                $exito = false; 
            } elseif (!$personaje1->puedeDuelar()) {
                $exito = false;
            } elseif (!$personaje2->puedeDuelar()) {
                $exito = false;
            }

            if ($exito) {
                $fechaTexto = date('Y-m-d H:i:s');
                $objDuelo = new Duelo($personaje1, $personaje2, $arena, $fechaTexto, null, "pendiente");
                
                $colDuelos = $this->getDuelos();
                array_push($colDuelos, $objDuelo);
                $this->setDuelos($colDuelos);

                // Inserción limpia en Medoo sin corchetes colgados
                $this->db->insert("duelos", [
                    "idPersonaje1" => $objDuelo->getPersonaje1()->getId(),
                    "idPersonaje2" => $objDuelo->getPersonaje2()->getId(),
                    "idArena"      => $objDuelo->getArena()->getId(),
                    "fecha"        => $objDuelo->getFecha(),
                    "estado"       => $objDuelo->getEstado(),
                    "idGanador"    => null
                ]);
            }
            return $exito;
        }

        public function ejecutarDuelo($objDuelo) {
            $mensajeRetorno = "No se pudo realizar el duelo";
            if ($objDuelo->realizarDuelo()) {
                $personaje1 = $objDuelo->getPersonaje1();
                $personaje2 = $objDuelo->getPersonaje2();
                $personaje1->guardar($this->db);
                $personaje2->guardar($this->db);
                
                // Guardamos el estado y el ID en la tabla duelos
                $objDuelo->guardar($this->db);
                $mensajeRetorno = $objDuelo->getGanador()->getNombre();
            }
            return $mensajeRetorno;
        }

        public function recuperarPersonaje($objPersonaje) {
            $objPersonaje->recuperarVida(50);
            $objPersonaje->guardar($this->db);
            $operacionExitosa = true;
            return $operacionExitosa;
        }
    }