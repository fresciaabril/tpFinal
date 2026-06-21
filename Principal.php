<?php
include_once "Torneo.php";
$torneo = new torneo();
// echo" _____ _            _____ _     _             _____                _ _     \n";
// echo"|_   _| |          |  ___| |   | |           /  ___|              | | |    \n";
// echo"  | | | |__   ___  | |__ | | __| | ___ _ __  \ `--.  ___ _ __ ___ | | |___ \n";
// echo"  | | | '_ \ / _ \ |  __|| |/ _` |/ _ \ '__|  `--. \/ __| '__/ _ \| | / __|\n";
// echo"  | | | | | |  __/ | |___| | (_| |  __/ |    /\__/ / (__| | | (_) | | \__\ \n";
// echo"  \_/ |_| |_|\___| \____/|_|\____|\___|_|    \____/ \___|_|  \___/|_|_|__/ \n";
// echo"Quiere registrar armas, personajes y arenas del juego? (si/no) ";
// $inicio = trim(fgets(STDIN));
$inicio="si";
if($inicio == "no"){
	echo"Todavia no diseñamos el juego para que construyas los personajes (etc) a tu manera.";
	}else{
// Poder hacer:
// Registrar personajes. /
// Registrar armas. /
// Registrar arenas. /
// Equipar armas. /
$torneo->equiparArma();
$datosPorTabla = [
    'armas' => [
        ['nombre' => 'Espada de Hierro', 'tipo' => 'espada', 'danioBase' => 20, 'nivelMinimo' => 1, 'estado' => 'disponible'],
        ['nombre' => 'Báculo Arcano', 'tipo' => 'baculo', 'danioBase' => 25, 'nivelMinimo' => 2, 'estado' => 'disponible'],
        ['nombre' => 'Arco Élfico', 'tipo' => 'arco', 'danioBase' => 18, 'nivelMinimo' => 1, 'estado' => 'disponible'],
        ['nombre' => 'Hacha Pesada', 'tipo' => 'hacha', 'danioBase' => 30, 'nivelMinimo' => 3, 'estado' => 'disponible'],
        ['nombre' => 'Daga Rápida', 'tipo' => 'daga', 'danioBase' => 12, 'nivelMinimo' => 1, 'estado' => 'disponible']
    ],
    'arenas' => [
        ['nombre' => 'Coliseo Central', 'dificultad' => 3, 'capacidadPublico' => 5000, 'clima' => 'normal'],
        ['nombre' => 'Bosque Nublado', 'dificultad' => 4, 'capacidadPublico' => 1200, 'clima' => 'niebla'],
        ['nombre' => 'Templo de la Tormenta', 'dificultad' => 5, 'capacidadPublico' => 2000, 'clima' => 'tormenta'],
        ['nombre' => 'Puerto Bajo la Lluvia', 'dificultad' => 2, 'capacidadPublico' => 800, 'clima' => 'lluvia']
    ],
	'personajes' => [
		['nombre' => 'Thorgar', 'tipoPersonaje' => 'guerrero', 'nivel' => 3, 'puntosVida' => 100, 'energia' => 90, 'fuerza' => 18, 'armadura' => 12, 'mana' => null, 'inteligencia' => null, 'precisionPersonaje' => null, 'velocidad' => null],
		['nombre' => 'Elandra', 'tipoPersonaje' => 'mago', 'nivel' => 4, 'puntosVida' => 80, 'energia' => 100, 'mana' => 35, 'inteligencia' => 20, 'fuerza' => null, 'armadura' => null, 'precisionPersonaje' => null, 'velocidad' => null],
		['nombre' => 'Lorian', 'tipoPersonaje' => 'arquero', 'nivel' => 2, 'puntosVida' => 90, 'energia' => 95, 'precisionPersonaje' => 22, 'velocidad' => 18, 'fuerza' => null, 'armadura' => null, 'mana' => null, 'inteligencia' => null],
		['nombre' => 'Brakka', 'tipoPersonaje' => 'guerrero', 'nivel' => 1, 'puntosVida' => 100, 'energia' => 80, 'fuerza' => 14, 'armadura' => 8, 'mana' => null, 'inteligencia' => null, 'precisionPersonaje' => null, 'velocidad' => null]
    ]
];

$algoFallo = false;
$mensajeError = "";

foreach ($datosPorTabla as $tabla => $registros){
    // Medoo insert(). Devuelve true si funciona, false o lanza warning si falla.
    
    if(!$database->insert($tabla, $registros)){
        $algoFallo = true;
        $mensajeError = "Error al insertar en: $tabla";
        break; 
    }
    
    echo "Tabla '$tabla': Datos insertados.\n";
}

if ($algoFallo){
    echo "\n Error: ".$mensajeError;
    echo "\n El script se detuvo. Revisa la tabla ".$tabla;
}else{
    echo "\n ¡Todo correcto!\n";
}
// Falta Registrar duelos.
// Ejecutar duelos pendientes.
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
		do{		
echo"---------------------------------------------------------------------------
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
14. Recuperar personajes lesionados.
--------------------------------------------------------------------------- \n";
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
				//  Mostrar el arma equipada por cada personaje				
					$listarArmas = " ";
					foreach($torneo->listarArmas($database) as $armas){
						$listarArmas .= $armas;
					}
					$arma = $listarArmas[0];
					// echo "Las armas equipadas son: \n";
					print_r($arma);
					/*public function equiparArma(){
						foreach($this->getArmas() as $arma){
							$estado = $arma->getEstado();
							if($estado == "disponible"){
								foreach ($this->getPersonaje() as $personaje){
									$personaje->setArma($arma);
								}
							}
						}
					}*/
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
			case '14';
				// Recuperar personajes lesionados.
				break;
			default:
				echo "\n".$Variable." no es una opcion\n";
				$Variable = "Error";
		}
		}while(repetir());
	}
	function repetir(){
		echo"\n";
		echo"Quiere volver a repetir? (si/no) ";
		$respuesta=trim(fgets(STDIN));
		if($respuesta == "si"){
			$respuesta = true;
		}else{
			$respuesta = false;
		}
		return $respuesta;
	}
	}