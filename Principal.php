<?php
	include_once "Torneo.php";

	// DECLARACIÓN GLOBAL AL PRINCIPIO
	global $database;

	$torneo = new torneo();

	// echo" El nombre del juego ;( que queria:
	// echo" _____ _            _____ _     _             _____                _ _     \n";
	// echo"|_   _| |          |  ___| |   | |           /  ___|              | | |    \n";
	// echo"  | | | |__   ___  | |__ | | __| | ___ _ __  \ `--.  ___ _ __ ___ | | |___ \n";
	// echo"  | | | '_ \ / _ \ |  __|| |/ _` |/ _ \ '__|  `--. \/ __| '__/ _ \| | / __|\n";
	// echo"  | | | | | |  __/ | |___| | (_| |  __/ |    /\__/ / (__| | | (_) | | \__\ \n";
	// echo"  \_/ |_| |_|\___| \____/|_|\____|\___|_|    \____/ \___|_|  \___/|_|_|__/ \n";




do{		
echo"---------------------------------------------------------------------------
MENU:
1. Registrar personajes
2. Registrar armas
3. Registrar arenas
4. Equipar armas
5. Registrar duelos
6. Ejecutar duelos pendientes
7. Recuperar personajes lesionados
8. Consultar rankings
9. Consultar historial de personajes
--------------------------------------------------------------------------- \n";

		echo"Ingrese opcion: ";
		(int)$Variable = trim(fgets(STDIN));
  
		switch($Variable){
			case '1':
				// Registrar personajes
				echo "Ingrese nombre: ";
				$nombre = trim(fgets(STDIN));
				
				echo"Seleccione tipo de personaje:\n 1: Guerrero \n 2: Mago \n 3: Arquero \n ";
				$tipo = trim(fgets(STDIN));

				switch($tipo) {
					case '1':
						echo "Ingrese Fuerza: ";
						$fuerza = (int)trim(fgets(STDIN));
						echo "Ingrese Armadura: ";
						$armadura = (int)trim(fgets(STDIN));
						$objPersonaje = new Guerrero($nombre, 1, 100, 100, 0, 0, "disponible",  $fuerza, $armadura);
						break;

					case '2':
						echo "Ingrese Mana: ";
						$mana = (int)trim(fgets(STDIN));
						echo "Ingrese Inteligencia: ";
						$inteligencia = (int)trim(fgets(STDIN));
						$objPersonaje = new Mago($nombre, 1, 100, 100, 0, 0, "disponible", $mana, $inteligencia);
						break;

					case '3':
						echo "Ingrese Precisión: ";
						$precisionPersonaje = (int)trim(fgets(STDIN));
						echo "Ingrese Velocidad: ";
						$velocidad = (int)trim(fgets(STDIN));
						$objPersonaje = new Arquero($nombre, 1, 100, 100, 0, 0, "disponible", $precisionPersonaje, $velocidad);
						break;

					default:
						echo "Tipo no válido. \n";
						$objPersonaje = null;
						break;
				}

				
				// Si se creó llamamos a guardar
				if ($objPersonaje != null){
					$objPersonaje->guardar($database);
					echo $objPersonaje; 
				}
				break;

			case '2':
				// Registrar armas
				echo "Ingrese nombre del arma: ";
				$nomArma = trim(fgets(STDIN));
				
				echo "Ingrese tipo de arma (Espada, Baston, Arco): ";
				$tipoArma = trim(fgets(STDIN));
				if($tipoArma == "1"){
					$tipoArma = "espada";
				}if($tipoArma == "2"){
					$tipoArma = "baston";
				}if($tipoArma == "3"){
					$tipoArma = "arco";
				}

				echo "Ingrese daño base: ";
				$danio = (int)trim(fgets(STDIN));

				echo "Ingrese nivel mínimo requerido: ";
				$nivelMin = (int)trim(fgets(STDIN));
				$objArma = new Arma($nomArma, $tipoArma, $danio, $nivelMin,);

				if ($objArma != null) {
					$objArma->guardar($database);
				}
				break;

			case '3':
				// Registrar arenas
                echo "---------------------------------------------------\n";
                echo "-- Registro de Nueva Arena de Combate --\n";
                
                $topArena = $torneo->arenaMasPopular($database);
                if ($topArena != null) {
                    echo "La arena más popular actualmente es: '" . $topArena->getNombre() . "-Clima: " . $topArena->getClima() . "-\n";
                    echo "Considerá crear una arena distinta \n";
                }
                echo "---------------------------------------------------\n";

                echo "Ingrese nombre de la arena: ";
                $nomArena = trim(fgets(STDIN));
                
                echo "Ingrese dificultad: ";
                $dificultad = trim(fgets(STDIN));

                echo "Ingrese capacidad de público: ";
                $capacidad = (int)trim(fgets(STDIN));

                echo "Seleccione clima con un numero:\n 1: normal \n 2: lluvia \n 3: tormenta \n 4: niebla \n";
                $Clima = trim(fgets(STDIN));

                switch($Clima) {
                    case '1': 
                        $clima = "normal"; 
                        break;
                    case '2': 
                        $clima = "lluvia"; 
                        break;
                    case '3': 
                        $clima = "tormenta"; 
                        break;
                    case '4': 
                        $clima = "niebla"; 
                        break; 
                    default:
                        echo "Opción no válida. Se asignará clima 'normal' por defecto.\n";
                        $clima = "normal";
                        break;
                }

                $objArena = new Arena($nomArena, $dificultad, $capacidad, $clima);

                if ($objArena != null) {
                    $objArena->guardar($database);
                }

				break;

			case '4':
				// Equipar armas
                // 1. Mostrar los personajes registrados para ver sus ids
                $listaPersonajes = $database->select("personajes", ["id", "nombre", "nivel", "estado"]);
                echo "---------------------------------------------------\n";
                echo "--Personajes registrados-- \n";
                foreach ($listaPersonajes as $personaje) {
                    $objPersonaje = $torneo->obtenerPersonajePorId($personaje['id']);
                    if ($objPersonaje != null) {
                        echo $objPersonaje; 
                    }
                }

                echo "---------------------------------------------------\n";
                echo "-- Armas Disponibles para Equipar -- \n";
                
                $armasDisponibles = $torneo->listarArmasDisponibles($database);
                
                if (count($armasDisponibles) > 0) {
                    foreach ($armasDisponibles as $objArma) {
                        echo $objArma; 
                    }
                } else {
                    echo "\n No hay armas disponibles en el inventario en este momento.\n";
                }
                echo "---------------------------------------------------\n";

                echo "Ingrese el ID del Personaje: ";
                $idPersonaje = (int)trim(fgets(STDIN));

                echo "Ingrese el ID del Arma a equipar: ";
                $idArma = (int)trim(fgets(STDIN));

                $personajeObj = $torneo->obtenerPersonajePorId($idPersonaje);
                $armaObj = $torneo->obtenerArmaPorId($idArma);

                if ($personajeObj != null && $armaObj != null) {
                    $respuesta = $torneo->equiparArma($personajeObj, $armaObj);
                    echo $respuesta["mensaje"];
                    if ($respuesta["exito"]) {
                        $personajeObj->guardar($database);
                        $armaObj->guardar($database);
                    }

                } else {
                    echo "\n El personaje o el arma no existen en el sistema \n";
                }
				break;

			case '5':
				// Registrar duelos
                echo "---------------------------------------------------\n";
                echo "   Personajes disponibles para el Duelo \n";
                echo "---------------------------------------------------\n";
                
                $personajesDisponibles = $torneo->listarPersonajes($database, ["estado" => "disponible"]);

                if (count($personajesDisponibles) > 0) {
                    foreach ($personajesDisponibles as $objPersonaje) {
                        echo $objPersonaje; 
                    }
                } else {
                    echo "\n No hay ningún personaje disponible para pelear en este momento.\n";
                }

                $listaArenas = $database->select("arenas", ["id"]);
                echo "---------------------------------------------------\n";
                echo "  Arenas disponibles  \n";
                foreach ($listaArenas as $arenaItem) {
                    $objArena = $torneo->obtenerArenaPorId($arenaItem['id'], $database);
                    if ($objArena != null) {
                        echo $objArena; 
                    }
                }
                echo "---------------------------------------------------\n";

                echo "Ingrese ID del Personaje 1: ";
                $idP1 = (int)trim(fgets(STDIN));

                echo "Ingrese ID del Personaje 2: ";
                $idP2 = (int)trim(fgets(STDIN));

                echo "Ingrese ID de la Arena de combate: ";
                $idArena = (int)trim(fgets(STDIN));

                $personaje1 = $torneo->obtenerPersonajePorId($idP1);
                $personaje2 = $torneo->obtenerPersonajePorId($idP2);
                $arena = $torneo->obtenerArenaPorId($idArena, $database);

                if ($personaje1 != null && $personaje2 != null && $arena != null) {
                    $exito = $torneo->registrarDuelo($personaje1, $personaje2, $arena);
                    if ($exito) {
                        echo "Duelo agendado en la arena " . $arena->getNombre() . "\n";
                    } else {
                        echo "No se pudo agendar el duelo. Revisá los personajes.\n";
                    }
                } else {
                    echo "\n Alguno de los personajes o la arena elegida no existen en el sistema.\n";
                }
				break;

			case '6':			
				// Ejecutar duelos pendientes
                $todosLosDuelos = $torneo->listarDuelos($database);
                $hayPendientes = false;

                echo "---------------------------------------------------\n";
                echo "-- DUELOS PENDIENTES DE EJECUCIÓN --\n";
                
                //  muestra solo los que están pendientes
                foreach ($todosLosDuelos as $duelo) {
                    if ($duelo->getEstado() === 'pendiente') {
                        // Mostramos el id, nombres de los personajes y la arena
                        echo "ID DUELO: " . $duelo->getId() . "\n" . 
                             $duelo->getPersonaje1()->getNombre() . "\n" . 
                             $duelo->getPersonaje2()->getNombre() . " [Arena: " . 
                             $duelo->getArena()->getNombre() . "]\n";
                        $hayPendientes = true;
                    }
                }

                if ($hayPendientes) {
                    echo "---------------------------------------------------\n";
                    echo "Ingrese el ID del duelo que desea ejecutar: ";
                    $idDueloElegido = (int)trim(fgets(STDIN));

                    // 3. Buscamos el objeto Duelo ingresado
                    $dueloApelear = null;
                    foreach ($todosLosDuelos as $duelo) {
                        if ($duelo->getId() === $idDueloElegido && $duelo->getEstado() === 'pendiente') {
                            $dueloApelear = $duelo;
                        }
                    }

                    if ($dueloApelear != null) {
                        $nombreGanador = $torneo->ejecutarDuelo($dueloApelear);
                        
                        echo "\n COMBATE TERMINADO \n";
                        echo "Ganador: " . $nombreGanador . "\n";
                    } else {
                        echo "\n El ID ingresado no corresponde a un duelo pendiente.\n";
                    }
                } else {
                    echo "No hay duelos pendientes en este momento.\n";
                }
				break;

			case '7':
				// Recuperar personajes lesionados
			
                $lesionados = $database->select("personajes", ["id"], ["estado" => "lesionado"]);
                $hayLesionados = false;

                echo "---------------------------------------------------\n";
                echo "-- PERSONAJES LESIONADOS --\n";

                foreach ($lesionados as $personLesionado) {
                    $objPersonaje = $torneo->obtenerPersonajePorId($personLesionado['id']);
                    if ($objPersonaje != null) {
                        echo "ID: " . $objPersonaje->getId() . "\n Nombre: " . $objPersonaje->getNombre() . 
                             "\n Vida actual: " . $objPersonaje->getPuntosVida() . "\n";
                        $hayLesionados = true;
                    }
                }

                if ($hayLesionados) {
                    echo "---------------------------------------------------\n";
                    echo "Ingrese el ID del personaje que desea curar: ";
                    $idCurar = (int)trim(fgets(STDIN));

                    $personajeAcurar = $torneo->obtenerPersonajePorId($idCurar);

                    if ($personajeAcurar != null && $personajeAcurar->getEstado() == 'lesionado') {
        
                        $torneo->recuperarPersonaje($personajeAcurar);
                        
                        echo "\n" . $personajeAcurar->getNombre() . " ha sido curado \n";
                    } else {
                        echo "\nEl ID ingresado no corresponde a un personaje lesionado \n";
                    }
                } else {
                    echo "No hay personajes lesionados en este momento \n";
                }
				break;

			case '8':
				// Consultar rankings
				echo "---------------------------------------------------\n";
                $ranking = $torneo->rankingPersonajes($database);
                echo $ranking;
                
                $masGanador = $torneo->personajeConMasVictorias($database);
                if ($masGanador != null) {
                    echo "Personaje con mas victorias: " . $masGanador->getNombre() . " (" . $masGanador->getDuelosGanados() . " victorias)\n\n";
                }

                $porcentajes = $torneo->calcularPorcentajeVictorias($database);
                echo $porcentajes . "\n";
                echo "---------------------------------------------------\n";
				break;
			case '9':
				// Consultar historial de personajes (consulta 6, 7, 8 y 9 )
                $listaPersonajes = $database->select("personajes", ["id", "nombre"]);
                echo "---------------------------------------------------\n";
                echo "-- CONSULTA DE HISTORIALES Y DETALLES --\n";
                foreach ($listaPersonajes as $personaje) {
                    echo "ID: " . $personaje['id'] . " | Nombre: " . $personaje['nombre'] . "\n";
                }
                echo "---------------------------------------------------\n";

                echo "Ingrese el ID del personaje para ver sus datos y duelos: ";
                $idBuscar = (int)trim(fgets(STDIN));

                $personajeObj = $torneo->obtenerPersonajePorId($idBuscar);
                
                if ($personajeObj != null) {
                    echo "\n -DETALLES DEL PERSONAJE- \n";
                    echo $personajeObj . "\n";

                    $encontroDuelos = false;
                    $colDuelos = $torneo->listarDuelos($database);
                    
                    $realizadosTexto = "";
                    $pendientesTexto = "";

                    if ($colDuelos != null) {
                        foreach ($colDuelos as $duelo) {
                            if ($duelo->getPersonaje1()->getId() == $idBuscar || $duelo->getPersonaje2()->getId() == $idBuscar) {
                                if ($duelo->getEstado() === 'realizado') {
                                    $realizadosTexto .= $duelo . "\n";
                                } else {
                                    $pendientesTexto .= $duelo . "\n";
                                }
                                $encontroDuelos = true;
                            }
                        }
                    }

                    echo "---------------------------------------------------\n";
                    echo " HISTORIAL DE COMBATES:\n";
                    if ($encontroDuelos) {
                        echo "\n[Duelos Realizados] \n" . (count($colDuelos) > 0 && $realizadosTexto != "" ? $realizadosTexto : "Ninguno.\n");
                        echo "\n[Duelos Pendientes] \n" . (count($colDuelos) > 0 && $pendientesTexto != "" ? $pendientesTexto : "Ninguno.\n");
                    } else {
                        echo "Este personaje no posee enfrentamientos agendados en el sistema.\n";
                    }
                } else {
                    echo "\n El ID ingresado no corresponde a ningún personaje.\n";
                }
                echo "---------------------------------------------------\n";
                break;
				
			default:
				echo "\n".$Variable." no es una opcion\n";
				$Variable = "Error";
		}
	}while(repetir());
	function repetir(){
		echo"\n";
		echo"Quiere volver al menu? (si/no) \n";
		$respuesta=trim(fgets(STDIN));
		if($respuesta == "si"){
			$respuesta = true;
		}else{
			$respuesta = false;
		}
		return $respuesta;
	}