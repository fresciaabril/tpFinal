<?php
    class Mago extends Personaje{
        private $mana;
        private $inteligencia;

        public function __construct($nombre, $nivel, $puntosVida, $energia, $duelosGanados, $duelosPerdidos, $estado, $mana, $inteligencia, $id = null){
            parent::__construct($nombre, $nivel, $puntosVida, $energia, $duelosGanados, $duelosPerdidos, $estado, $id);
            $this->mana = $mana;
            $this->inteligencia = $inteligencia;
        }


        public function getMana(){
            return $this->mana;
        }
 
        public function setMana($mana){
            $this->mana = $mana;
        }

        
        public function getInteligencia(){
            return $this->inteligencia;
        }

        
        public function setInteligencia($inteligencia){
            $this->inteligencia = $inteligencia;
        }


        public function calcularPoderBase(){
            return ($this->getNivel() * 10) + $this->getMana();
        }

        
        public function calcularPoderEspecial(){
            return $this->getMana() + ($this->getInteligencia() * 3);
        }

         
        
    }