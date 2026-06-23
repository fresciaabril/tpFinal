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

        public function __construct($nombre, $nivel, $puntosVida, $energia, $duelosGanados, $duelosPerdidos, $armaEquipada, $id = null,  $estado = "Disponible"){
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
            if ($vida < 0) {
                $vida = 0;
            }
            $this->setPuntosVida($vida);
            
            if($this->getPuntosVida() <= 0){
                $this->setEstado("retirado");
            } else if ($this->getPuntosVida() > 0 && $this->getPuntosVida() <= 30 ){
                $this->setEstado("lesionado");
            }
        }


        public function recuperarVida($cantidad){
            $vida = $this->getPuntosVida() + $cantidad;
            if ($vida > 100) {
                $vida = 100;
            }
            $this->setPuntosVida($vida);
            
            if ($this->getPuntosVida() > 30){
                $this->setEstado("disponible");
            } else if ($this->getPuntosVida() > 0 && $this->getPuntosVida() <= 30) {
                $this->setEstado("lesionado");
            }
        }


        public function recuperarEnergia($cantidad){
            $energia = $this->getEnergia() + $cantidad;
            $this->setEnergia($energia);
            return "Energia cargada";
        }


        public function puedeDuelar(){
            $puede = false;
            if( $this->getEstado() == "disponible"){
                $puede = true;
            }
            return $puede;
        }


        public function calcularPoderTotal($modArena){ // Hacer en programa principal con la arena creada / EJ: $modArena = $arena->calcularModificarArena($personaje)
            $dañoArma = 0;
            if( $this->getArma() != null){
                $dañoArma = (int)$this->getArma()->calcularDanio(); //con el $modArena tenemos que devuelve un int para sumar en calcularPoderTotal  
            }
            $poderTotal = (int)$this->calcularPoderBase() + (int)$this->calcularPoderEspecial() + $dañoArma + (int)$modArena;
            return $poderTotal;
        }


        abstract public function calcularPoderBase();

        abstract public function calcularPoderEspecial();

        public function __toString(){
            $mensaje = "No tiene arma equipada";
            if($this->getArma()){
                $mensaje = "Arma equipada: ";
            }
            return 
            "--------------------------------------------------- \n" .
            "Nombre: " . $this->getNombre().
            "\n Nivel: " . $this->getNivel().
            "\n Vida: "  . $this->getPuntosVida().
            "\n Energia: " . $this->getEnergia().
            "\n Duelos ganados: " . $this->getDuelosGanados().
            "\n Duelos perdidos: " . $this->getDuelosPerdidos().
            "\n Estado: " . $this->getEstado().
            "\n" . $mensaje . $this->getArma().
            "\n ID es: " . $this->getId();
        }


        // METODO PARA GUARDAR O ACTUALIZAR EL PERSONAJE EN LA BD
        public function guardar($database){
            $idArma = (int) $this->getArma()?->getId();
            $armaValor = ($idArma > 0) ? $idArma : null;
            $personaje = [
                "nombre"            => $this->getNombre(),
                "nivel"             => $this->getNivel(),
                "puntosVida"        => $this->getPuntosVida(),
                "energia"           => $this->getEnergia(),
                "duelosGanados"     => $this->getDuelosGanados(),
                "duelosPerdidos"    => $this->getDuelosPerdidos(),
                "estado"            => $this->getEstado(),
                "idArmaEquipada"    => $armaValor, 
                "fuerza"            => null,
                "armadura"          => null,
                "mana"              => null,
                "inteligencia"      => null,
                "precisionPersonaje"=> null,
                "velocidad"         => null
            ];

            // instanceof sirve para verificar que pertenezca a una clase
            if ($this instanceof Guerrero) {
                $personaje["fuerza"]   = $this->getFuerza();
                $personaje["armadura"] = $this->getArmadura();
            } elseif ($this instanceof Mago) {
                $personaje["mana"]         = $this->getMana();
                $personaje["inteligencia"] = $this->getInteligencia();
            } elseif ($this instanceof Arquero) {
                $personaje["precisionPersonaje"] = $this->getPrecision();
                $personaje["velocidad"]          = $this->getVelocidad();
            }

            if ($this->getId()) {
                $database->update("personajes", $personaje, ["id" => $this->getId()]);
                echo "\nPersonaje " .$this->getNombre() . " actualizado con éxito \n";
            } else {
                $database->insert("personajes", $personaje);
                // Guardamos el ID autogenerado que nos devuelve Medoo en el atributo de la clase
                $this->setId($database->id());
                echo "\nPersonaje " .$this->getNombre() . " registrado \n";
            }
        }
        

    

    
}