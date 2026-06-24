<?php 

    class Arquero extends Personaje{
        private $precision;
        private $velocidad;

        public function __construct($nombre, $nivel, $puntosVida, $energia, $duelosGanados, $duelosPerdidos, $estado = "Disponible", $precision = 0, $velocidad = 0, $id = null){
            parent::__construct($nombre, $nivel, $puntosVida, $energia, $duelosGanados, $duelosPerdidos, null, $id, $estado);
            $this->precision = $precision;
            $this->velocidad = $velocidad;
        }

         
        public function getPrecision(){
            return $this->precision;
        }

        public function setPrecision($precision){
            $this->precision = $precision;
        }


        public function getVelocidad(){
            return $this->velocidad;
        }
 
        public function setVelocidad($velocidad){
            $this->velocidad = $velocidad;
        }


        public function calcularPoderBase(){
            return $this->getNivel() * 12 + $this->getPrecision() ;
        }

        
        public function calcularPoderEspecial(){
            return ($this->precision * 2) + $this->getVelocidad();
        }


        public function __toString(){
            return parent::__toString().
            "\nPrecision: " . $this->getPrecision().
            "\nVelocidad: " . $this->getVelocidad().
            "\n---------------------------------------------------";
        }
    }