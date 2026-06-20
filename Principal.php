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
// Poder hacer:
// Registrar personajes.
// Registrar armas.
// Registrar arenas.
// Equipar armas.
// Registrar duelos.
// Ejecutar duelos pendientes.
// Recuperar personajes lesionados.
// Consultar rankings.
// Consultar historial de personajes.
	$Variable="a";
	while(!is_numeric($Variable)){
		/* Inspiracion
		function solicitarNumeroEntre($min, $max) {
			//int $numero
			$numero = trim(fgets(STDIN));
			while (!(is_numeric($numero) && is_int($numero + 0) && ($numero >= $min && $numero <= $max))) {
				echo "Debe ingresar un número entre " . $min . " y " . $max . ": ";
				$numero = trim(fgets(STDIN));
			}
		
			return $numero;
		}
		*/
		echo"1. Listar todos los personajes.\n2. Listar personajes disponibles para duelar.\n3. Listar personajes lesionados.\n4. Listar personajes retirados.\n5. Listar armas disponibles.\n6. Mostrar el arma equipada por cada personaje.\n7. Mostrar todos los duelos realizados.\n8. Mostrar todos los duelos pendientes.\n9. Mostrar el historial de duelos de un personaje.\n10. Mostrar el ranking de personajes ordenado por cantidad de victorias.\n11. Mostrar el personaje con mayor cantidad de victorias.\n12. Mostrar el porcentaje de victorias de cada personaje.\n13. Mostrar la arena donde más duelos se realizaron.\n";
		echo"Ingrese opcion: ";
		(int)$Variable = trim(fgets(STDIN));
		switch($Variable){
			case '1':
				// Listar todos los personajes.
				$lista = "" ;
				foreach ($torneo->listarPersonajes($database) as $personaje ){
					$lista .= $personaje;
				}
					echo "Los personajes son: \n" . $lista;
				break;
			case '2':
				// Listar personajes disponibles para duelar.
				$disponibles = "";
				foreach($torneo->listarPersonajes($database) as $personaje){
					if($personaje->puedeDuelar() == true){
						$disponibles .= $personaje;
					}
				}
				echo "Los personajes disponibles para poder duelar son: \n" . $disponibles;
				break;
			case '3':
				// Listar personajes lesionados.
				$lesionados = "";
				foreach($torneo->listarPersonajes($database) as $personaje){
					if($personaje->getEstado() == "lesionado"){
						$lesionados .= $personaje;
					}
				}
				echo "Los personajes lesionados son: \n" . $lesionados;
				break;
			case '4':
				// Listar personajes retirados.
				$retirado = "";
				foreach($torneo->listarPersonajes($database) as $personaje){
					if($personaje->getEstado() == "retirado"){
						$retirado .= $personaje;
					}
				}
				echo "Los personajes retirados son: \n" . $retirado;
				break;
			case '5':
				// Listar armas disponibles.
					$listarArmas = " ";
					foreach($torneo->listarArmas($database) as $armas){
						$listarArmas .= $armas;
					}
					
					echo "Las armas disponibles son: \n" . $listarArmas;
				break;
			case '6':
				// Mostrar el arma equipada por cada personaje.
				break;
			case '7':
				// Mostrar todos los duelos realizados.
				$realizados = "";
				foreach($torneo->listarDuelos($database) as $duelo){
					if ($duelo->getEstado() == "realizado"){
						// $realizados .= $duelo;
					}
				}
				echo "Los duelos realizados son: \n" .	$realizados;
				break;
			case '8':
				// Mostrar todos los duelos pendientes.
				$pendientes = "";
				foreach($torneo->listarDuelos($database) as $duelo){
					if ($duelo->getEstado() == "pendiente"){
						// $pendientes .= $duelo->__toString();
					}
				}
				echo "Los duelos realizados son: \n" .	$pendientes;
				break;
			case '9':
				// Mostrar el historial de duelos de un personaje.
				// $historial = "";
				// foreach($torneo->listarPersonajes() as $personaje){
				// 	foreach ($torneo->listarDuelos() as $duelo){
						
				// 	}
				// }
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
}
