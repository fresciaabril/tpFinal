<?php
include "Personaje.php";

class Arena
{

        //Atributos clase
        private $id;
        private $nombre;
        private $dificultad;
        private $capacidadPublico;
        private $clima; //Normal / LLuvia / tormenta / niebla

        //Construct
        public function __construct($nombre, $dificultad, $capacidadPublico, $clima, $id = null)
        {
                $this->id = $id;
                $this->nombre = $nombre;
                $this->dificultad = $dificultad;
                $this->capacidadPublico = $capacidadPublico;
                $this->clima = $clima;
        }

        //getters
        public function getId()
        {
                return $this->id;
        }
        public function getNombre()
        {
                return $this->nombre;
        }
        public function getDificultad()
        {
                return $this->dificultad;
        }
        public function getCapacidadPublico()
        {
                return $this->capacidadPublico;
        }
        public function getClima()
        {
                return $this->clima;
        }

        //setters
        public function setId($id)
        {
                $this->id = $id;
        }
        public function setNombre($nombre)
        {
                $this->nombre = $nombre;
        }
        public function setDificultad($dificultad)
        {
                $this->dificultad = $dificultad;
        }
        public function setCapacidadPublico($capacidadPublico)
        {
                $this->capacidadPublico = $capacidadPublico;
        }
        public function setClima($clima)
        {
                $this->clima = $clima;
        }

        //Too string
        public function __toString()
        {
                $respuesta =
                        "--------------------------------------------------- \n
                Nombre de arena = {$this->getNombre()} \n
                Dificultad de arena = {$this->getDificultad()} \n
                Capacidad = {$this->getCapacidadPublico()} \n
                Clima = {$this->getClima()} \n
                ID = {$this->getId()} \n
                --------------------------------------------------- \n";
                return $respuesta;
        }

        //Metodo calcular modificador de arena (Personaje $personaje)
        public function calcularModificadorArena(Personaje $objPersonaje)
        {
                $modificador = 0;
                switch ($this->getClima())
                {
                        case "lluvia":
                                if ($objPersonaje instanceof Arquero) {
                                        $modificador = -10;
                                } else if ($objPersonaje instanceof Mago) {
                                        $modificador = 5;
                                }
                                // Guerrero queda en 0
                                break;

                        case "tormenta":
                                if ($objPersonaje instanceof Mago) {
                                        $modificador = 15;
                                } else if ($objPersonaje instanceof Arquero) {
                                        $modificador = -5;
                                } else if ($objPersonaje instanceof Guerrero) {
                                        $modificador = -5;
                                }
                                break;

                        case "niebla":
                                if ($objPersonaje instanceof Arquero) {
                                        $modificador = -15;
                                } else if ($objPersonaje instanceof Guerrero) {
                                        $modificador = 5;
                                }
                                // Mago queda en 0
                                break;

                                // clima "normal": no entra a ningun case y devuelve 0
                }

                return $modificador;
        }

        
        public function guardar($database){
                $arena = [
                "nombre"           => $this->getNombre(),
                "dificultad"       => $this->getDificultad(),
                "capacidadPublico" => $this->getCapacidadPublico(),
                "clima"            => $this->getClima()
                ];

                if ($this->getId()) {
                        $database->update("arenas", $arena, ["id" => $this->getId()]);
                        echo "\nArena " . $this->getNombre() . " actualizada con éxito \n";
                } else {
                        $database->insert("arenas", $arena);
                        $this->setId($database->id());
                        echo "\nArena " . $this->getNombre() . " registrada \n";
                }
        }
}
