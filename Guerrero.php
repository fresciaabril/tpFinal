<?php 
    class Guerrero extends Personaje{
        private $fuerza;
        private $armadura;

        public function __construct($nombre, $nivel, $puntosVida, $energia, $duelosGanados, $duelosPerdidos, $estado = "disponible", $fuerza = 0, $armadura = 0, $id = null){
            parent::__construct($nombre, $nivel, $puntosVida, $energia, $duelosGanados, $duelosPerdidos, null, $id, $estado);
            $this->fuerza = $fuerza;
            $this->armadura = $armadura;
        }


        public function getFuerza(){
            return $this->fuerza;
        }

        public function setFuerza($fuerza){
            $this->fuerza = $fuerza;
        }


         public function getArmadura(){
            return $this->armadura;
        }

        public function setArmadura($armadura){
            $this->armadura = $armadura;
        }


        public function calcularPoderBase(){
            return $this->getNivel() * 15;
        }

        
        public function calcularPoderEspecial(){
            return ($this->getFuerza() * 2) + $this->getArmadura();
        }

       
        public function __toString(){
            return parent::__toString().
            "\nFuerza: " . $this->getFuerza().
            "\nArmadura: " . $this->getArmadura().
            "\n---------------------------------------------------";
        }

    }