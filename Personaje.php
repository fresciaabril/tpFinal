<?php
    abstract class Personaje{
        private $id;
        private $nombre;
        private $nivel;
        private $puntosVida;
        private $energia;
        private $duelosGanados;
        private $duelosPerdidos;
        private $estado;       // disponible / lesionado / retirado //
        private $objArmaEquipada;

        public function __construct($nombre, $nivel, $puntosVida, $energia, $duelosGanados, $duelosPerdidos, $armaEquipada, $id = null,  $estado = "disponible"){
            $this->id = $id;
            $this->nombre = $nombre;
            $this->nivel = $nivel;
            $this->puntosVida = $puntosVida;
            $this->energia = $energia;
            $this->duelosGanados = $duelosGanados;
            $this->duelosPerdidos = $duelosPerdidos;
            $this->estado = $estado;
            $this->objArmaEquipada = $armaEquipada;
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

         
        public function getNivel(){
            return $this->nivel;
        }

        public function setNivel($nivel){
            $this->nivel = $nivel;
        }

        
        public function getPuntosVida(){
            return $this->puntosVida;
        }

        public function setPuntosVida($puntosVida){
            $this->puntosVida = $puntosVida;
        }

         
        public function getEnergia(){
            return $this->energia;
        }
 
        public function setEnergia($energia){
            $this->energia = $energia;
        }

         
        public function getDuelosGanados(){
            return $this->duelosGanados;
        }
 
        public function setDuelosGanados($duelosGanados){
            $this->duelosGanados = $duelosGanados;
        }

        
        public function getDuelosPerdidos(){
            return $this->duelosPerdidos;
        }

        public function setDuelosPerdidos($duelosPerdidos){
            $this->duelosPerdidos = $duelosPerdidos;
        }

        
        public function getEstado(){
            return $this->estado;
        }

        public function setEstado($estado){
            $this->estado = $estado;
        }

        public function getArma(){
            return $this->objArmaEquipada;
        }

        public function setArma($arma){
            $this->objArmaEquipada = $arma;
        }


        public function recibirDanio($cantidad){
            $vida = $this->getPuntosVida() - $cantidad;
            $this->setPuntosVida($vida);
            if($this->getPuntosVida() <= 0){
                $estado = "retirado";
                $this->setEstado($estado);
            } else if ($this->getPuntosVida() > 0 && $this->getPuntosVida() < 30 ){
                $estado = "lesionado";
                $this->setEstado($estado);
            }
        }


        public function recuperarVida($cantidad){
            $vida = $this->getPuntosVida() + $cantidad;
            $this->setPuntosVida($vida);
            if ($this->getPuntosVida() > 0  && $this->getPuntosVida() < 30 ){
                $estado = "retirado";
                $this->setEstado($estado);
            } else{
                $estado = "disponible";
                $this->setEstado($estado);
            }
        }


        public function recuperarEnergia($cantidad){
            $energia = $this->getEnergia() + $cantidad;
            $this->setEnergia($energia);
            return "Energia cargada";
        }


        public function puedeDuelar(){
            $puede = false;
            if( $this->getEstado() != "lesionado"){
                $puede = true;
            }
            return $puede;
        }


        public function calcularPoderTotal($modArena){ // Hacer en programa principal con la arena creada / EJ: $modArena = $arena->calcularModificarArena($personaje)
            $dañoArma = $this->getArma()->calcularDanio(); //con el $modArena tenemos que devuelve un int para sumar en calcularPoderTotal  
            $poderTotal = $this->calcularPoderBase() + $this->calcularPoderEspecial() + $dañoArma + $modArena;
            return $poderTotal;
        }


        abstract public function calcularPoderBase();


        abstract public function calcularPoderEspecial();

        public function __toString(){
            return 
            "--------------------------------------------------- \n" .
            "Nombre: " . $this->getNombre().
            "\n Nivel: " . $this->getNivel().
            "\n Vida: "  . $this->getPuntosVida().
            "\n Energia: " . $this->getEnergia().
            "\n Duelos ganados: " . $this->getDuelosGanados().
            "\n Duelos perdidos: " . $this->getDuelosPerdidos().
            "\n Estado: " . $this->getEstado().
            "\n Arma equipada: \n" . $this->getArma();
        }

    }