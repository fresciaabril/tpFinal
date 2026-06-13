<?php

	include_once "Torneo.php";

	$torneo = new torneo();


	echo"
---------------------------------------------------------------------------
MENU:
1. Listar todos los personajes
2. Listar personajes disponibles para duelar
3. Listar personajes lesionados
4. Listar personajes retirados
5. Listar armas disponibles
6. Mostrar el arma equipada por cada personaje
7. Mostrar todos los duelos realizados
8. Mostrar todos los duelos pendientes
9. Mostrar el historial de duelos de un personaje
10. Mostrar el ranking de personajes ordenado por cantidad de victorias
11. Mostrar el personaje con mayor cantidad de victorias
12. Mostrar el porcentaje de victorias de cada personaje.
13. Mostrar la arena donde más duelos se realizaron
--------------------------------------------------------------------------- \n";
	echo"Ingrese opcion: ";
	$Variable = trim(fgets(STDIN));
	switch($Variable){
		case '1':
			// Listar todos los personajes.
			$lista = "" ;
			foreach ($torneo->listarPersonajes() as $personaje ){
				$lista .= $personaje;
			}
				echo "Los personajes son: \n" . $lista;
			break;
		case '2':
			// Listar personajes disponibles para duelar.
			$disponibles = "";
			foreach($torneo->listarPersonajes() as $personaje){
				if($personaje->puedeDuelar() == true){
					$disponibles .= $personaje;
				}
			}
			echo "Los personajes disponibles para poder duelar son: \n" . $disponibles;
			break;
		case '3':
			// Listar personajes lesionados.
			$lesionados = "";
			foreach($torneo->listarPersonajes() as $personaje){
				if($personaje->getEstado() == "lesionado"){
					$lesionados .= $personaje;
				}
			}
			echo "Los personajes lesionados son: \n" . $lesionados;
			break;
		case '4':
			// Listar personajes retirados.
			$retirado = "";
			foreach($torneo->listarPersonajes() as $personaje){
				if($personaje->getEstado() == "retirado"){
					$retirado .= $personaje;
				}
			}
			echo "Los personajes retirados son: \n" . $retirado;
			break;
		case '5':
			// Listar armas disponibles.
				echo "Las armas disponibles son: \n" . $torneo->listarArmas();
			break;
		case '6':
			// Mostrar el arma equipada por cada personaje.
			break;
		case '7':
			// Mostrar todos los duelos realizados.
			$realizados = "";
			foreach($torneo->listarDuelos() as $duelo){
				if ($duelo->getEstado() == "realizado"){
					$realizados .= $duelo;
				}
			}
			echo "Los duelos realizados son: \n" .	$realizados;
			break;
		case '8':
			// Mostrar todos los duelos pendientes.
			$pendientes = "";
			foreach($torneo->listarDuelos() as $duelo){
				if ($duelo->getEstado() == "pendiente"){
					$pendientes .= $duelo;
				}
			}
			echo "Los duelos realizados son: \n" .	$pendientes;
			break;
		case '9':
			// Mostrar el historial de duelos de un personaje.
			$historial = "";
			foreach($torneo->listarPersonajes() as $personaje){
				foreach ($torneo->listarDuelos() as $duelo){
					
				}
			}
			break;
		case '10':
			// Mostrar el ranking de personajes ordenado por cantidad de victorias.
			break;
		case '11':
			// Mostrar el personaje con mayor cantidad de victorias.
			break;
		case '12':
			// Mostrar el porcentaje de victorias de cada personaje.
			break;
		case '13':
			// Mostrar la arena donde más duelos se realizaron.
			break;
		default:
			echo "\n".$Variable." no es una opcion\n";
			$Variable = "Error";
	
	echo"\n";
}