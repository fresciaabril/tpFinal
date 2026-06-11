<?php

class Arena {
        
        //Atributos clase
        private $id;
        private $nombre;
        private $dificultad;
        private $capacidadPublico;
        private $clima;

        //Construct
        public function __construct( $nombre, $dificultad, $capacidadPublico, $clima, $id=null)
        {
                $this->id = $id;
                $this->nombre = $nombre;
                $this->dificultad = $dificultad;
                $this->capacidadPublico = $capacidadPublico;
                $this->clima = $clima;
        }

        //getters
        public function getId(){
                return $this->id;
        }
        public function getNombre(){
                return $this->nombre;
        }
        public function getDificultad(){
                return $this->dificultad;
        }
        public function getCapacidadPublico(){
                return $this->capacidadPublico;
        }
        public function getClima(){
                return $this->clima;
        }

        //setters
        public function setId($id){
                $this->id = $id;
        }
        public function setNombre($nombre){
                $this->nombre = $nombre;
        }
        public function setDificultad($dificultad){
                $this->dificultad = $dificultad;
        }
        public function setCapacidadPublico($capacidadPublico){
                $this->capacidadPublico = $capacidadPublico;
        }
        public function setClima($clima){
                $this->clima = $clima;
        }

        //Too string
        public function __toString()
        {
                $respuesta = "Nombre de arena = {$this->getNombre()} \n Dificultad de arena = {$this->getDificultad()} \n Capacidad = {$this->getCapacidadPublico()} \n Clima = {$this->getClima()}";
                return $respuesta;
        }

        //Metodo calcular modificador de arena (Personaje $personaje)
        public function calcularModificadorArena($objPersonaje){
                
        }
}
