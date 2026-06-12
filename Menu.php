<?php
	include_once "Guerrero.php";
	include_once "Mago.php";	
	include_once "Arquero.php";
	include_once "Arma.php";
	include_once "Arena.php";
	include_once "Duelo.php";
	include_once "Torneo.php";


 $Variable="a";
 while(!is_numeric($Variable)){
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
		// bastante foreach;
		case '1':
			// Listar todos los personajes.
			
			break;
		case '2':
			// Listar personajes disponibles para duelar.
			break;
		case '3':
			// Listar personajes lesionados.
			break;
		case '4':
			// Listar personajes retirados.
			break;
		case '5':
			// Listar armas disponibles.
			break;
		case '6':
			// Mostrar el arma equipada por cada personaje.
			break;
		case '7':
			// Mostrar todos los duelos realizados.
			break;
		case '8':
			// Mostrar todos los duelos pendientes.
			break;
		case '9':
			// Mostrar el historial de duelos de un personaje.
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
	}
	echo"\n";
}