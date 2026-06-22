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
						if ($objPersonaje instanceof Guerrero){// Prueba accediendo a sus métodos
							echo $objPersonaje;
						}else{echo "\n [ERROR] No se pudo crear el personaje.\n";}
						break;

					case '2':
						echo "Ingrese Mana: ";
						$mana = (int)trim(fgets(STDIN));
						echo "Ingrese Inteligencia: ";
						$inteligencia = (int)trim(fgets(STDIN));
						$objPersonaje = new Mago($nombre, 1, 100, 100, 0, 0, null, $mana, $inteligencia);
						if ($objPersonaje instanceof Mago){// Prueba accediendo a sus métodos
							echo $objPersonaje;
						}else{echo "\n [ERROR] No se pudo crear el personaje.\n";}

						break;

					case '3':
						echo "Ingrese Precisión: ";
						$precisionPersonaje = (int)trim(fgets(STDIN));
						echo "Ingrese Velocidad: ";
						$velocidad = (int)trim(fgets(STDIN));
						$objPersonaje = new Arquero($nombre, 1, 100, 100, 0, 0, null, $precisionPersonaje, $velocidad);
						if ($objPersonaje instanceof Arquero){// Prueba accediendo a sus métodos
							echo $objPersonaje;
						}else{echo "\n [ERROR] No se pudo crear el personaje.\n";}

						break;

					default:
						echo "Tipo no válido. \n";
						$objPersonaje = null;
						break;
				}
				// Si se creó llamamos a guardar
				if ($objPersonaje !== null){
					$objPersonaje->guardar($database);
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

				if ($objArma !== null) {
					$objArma->guardar($database);
				}
				break;

			case '3':
				// Registrar arenas
				echo "Ingrese nombre de la arena: ";
				$nomArena = trim(fgets(STDIN));
				
				echo "Ingrese dificultad: ";
				$dificultad = trim(fgets(STDIN));

				echo "Ingrese capacidad de público: ";
				$capacidad = (int)trim(fgets(STDIN));

				echo "Seleccione clima con un numero:\n1: normal \n2: lluvia \n3: tormenta \n4: niebla \n";
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

				if ($objArena !== null) {
					$objArena->guardar($database);
				}
				break;

			case '4':
				// Equipar armas
				$listaArmas = $database->select("armas", ["id", "nombre", "nivelMinimo", "estado"]);
				echo "---------------------------------------------------\n";
				echo "[ Armas registradas ]:\n";
				foreach ($listaArmas as $arma) {
					echo "ID: ". $arma['id'] .
					 "| Arma: " . $arma['nombre'] .
					  " Nivel Mín: " . $arma['nivelMinimo'] . 
					  " Estado: " . $arma['estado'] . "\n";
				}
				echo "---------------------------------------------------\n";

				echo "Ingrese el ID del Personaje: ";
				$personaje = (int)trim(fgets(STDIN));

				echo "Ingrese el ID del Arma a equipar: ";
				$arma = (int)trim(fgets(STDIN));

				$torneo->equiparArma($personaje, $arma);
				break;

			case '5':
				// Registrar duelos
					echo "funciona";
				break;

			case '6':			
				// Ejecutar duelos pendientes
					echo "funciona";
				break;

			case '7':
				// Recuperar personajes lesionados
				echo "funciona";
				break;

			case '8':
				// Consultar rankings
				$ranking=$torneo->rankingPersonajes($database);
				echo$ranking;
				echo "funciona";
				break;
			case '9':
				// Consultar historial de personajes
				// como lo ideé, no estoy seguro
				/*foreach($torneo->listarDuelos($database) as $duelo){
					if ($duelo->getPersonaje1() == $mensaje){
						$historialPersonaje.=$duelo;
					}
					if ($duelo->getPersonaje2() == $mensaje){
						$historialPersonaje.=$duelo;
					}
				}
				print_r($historialPersonaje); */
				echo "funciona";
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