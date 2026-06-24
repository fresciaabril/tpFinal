<?php

class Arma {
	private $id;
	private $nombre;
	private $tipo;
	private $danioBase;
	private $nivelMinimo;
	private $estado;

	public function __construct($nombre, $tipo, $danioBase, $nivelMinimo, $estado = "disponible", $id = null){
		$this->id = $id;
		$this->nombre = $nombre;
		$this->tipo = $tipo;
		$this->danioBase = $danioBase;
		$this->nivelMinimo = $nivelMinimo;
		$this->estado = $estado;
	}


	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}


	public function getNombre(){
		return $this->nombre;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}


	public function getTipo(){
		return $this->tipo;
	}

	public function setTipo($tipo){
		$this->tipo = $tipo;
	}


	public function getDanioBase(){
		return $this->danioBase;
	}

	public function setDanioBase($danioBase){
		$this->danioBase = $danioBase;
	}


	public function getNivelMinimo(){
		return $this->nivelMinimo;
	}

	public function setNivelMinimo($nivelMinimo){
		$this->nivelMinimo = $nivelMinimo;
	}


	public function getEstado(){
		return $this->estado;
	}

	public function setEstado($estado){
		$this->estado = $estado;
	}


	// metodos

	public function calcularDanio(){
		return $this->getDanioBase();
	}


	public function puedeSerEquipadaPor(Personaje $personaje){
		$mensaje = "";
        if ($this->getEstado() == 'equipada'){
			$mensaje = "equipada";
		}elseif($this->getEstado() == 'rota'){
			$mensaje = "rota";
		}elseif(($personaje->getNivel() < $this->getNivelMinimo())){
			$mensaje = "nivel bajo";
        }
		
        return $mensaje;
	}

	public function __toString(){
		return 
		"--------------------------------------------------- \n" .
		"Nombre: " . $this->getNombre().
		"\nTipo: " . $this->getTipo().
		"\nDaño base: " . $this->getDanioBase().
		"\nNivel minimo: " . $this->getNivelMinimo().
		"\nEstado: " . $this->getEstado() . 
		"\nID: " . $this->getId() . 
		"\n---------------------------------------------------" ;
	}


	// METODO PARA GUARDAR O ACTUALIZAR EL ARMA EN LA BD
    public function guardar($database){
        
        $arma = [
            "nombre"      => $this->getNombre(),
            "tipo"        => $this->getTipo(),
            "danioBase"   => $this->getDanioBase(),
            "nivelMinimo" => $this->getNivelMinimo(),
            "estado"      => $this->getEstado()
        ];

        if ($this->getId()) {
            // Si ya tiene id, actualizamos el registro
            $database->update("armas", $arma, ["id" => $this->getId()]);
            echo "\nArma ". $this->getNombre(). " actualizada con exito \n";
        } else {
            // Si no la insertamos
            $database->insert("armas", $arma);
            // Seteamos el ID autogenerado en el objeto
            $this->setId($database->id());
            echo "\nArma ". $this->getNombre(). " registrada con éxito \n";
        }
    }


}
