<?php 
    class Guerrero extends Personaje{
        private $fuerza;
        private $armadura;

        public function __construct($nombre, $nivel, $puntosVida, $energia, $duelosGanados, $duelosPerdidos, $estado, $fuerza,$armadura, $id = null ){
            parent::__construct($nombre, $nivel, $puntosVida, $energia, $duelosGanados, $duelosPerdidos, $estado, $id);
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
            "\n Fuerza: " . $this->getFuerza().
            "\n Armadura: " . $this->getArmadura().
            "\n---------------------------------------------------";
        }

    }