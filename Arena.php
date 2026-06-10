<?php

class Arena {
        
        //Atributos clase
        private $id;
        private $nombre;
        private $dificultad;
        private $capacidadPublico;
        private $clima;

        //Construct
        public function __construct($id=null, $nombre, $dificultad, $capacidadPublico, $clima)
        {
                $this->id = $id;
                $this->nombre = $nombre;
                $this->dificultad = $dificultad;
                $this->capacidadPublico = $capacidadPublico;
                $this->clima = $clima;
        }

        


}
