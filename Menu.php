<?php
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
	echo"1. Listar todos los personajes.\n2. Listar personajes disponibles para duelar.\n3. Listar personajes lesionados.\n4. Listar personajes retirados.\n5. Listar armas disponibles.\n6. Mostrar el arma equipada por cada personaje.\n7. Mostrar todos los duelos realizados.\n8. Mostrar todos los duelos pendientes.\n9. Mostrar el historial de duelos de un personaje.\n10. Mostrar el ranking de personajes ordenado por cantidad de victorias.\n11. Mostrar el personaje con mayor cantidad de victorias.\n12. Mostrar el porcentaje de victorias de cada personaje.\n13. Mostrar la arena donde más duelos se realizaron.\n";
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