<?php

/**
 * class Cliente
 * autor: gestion
 * 
 */

class Cliente
{
    
    private $nombre;
    private $apellido;
    private $ci;
    
    /* Constructor */
    public function __construct($attr = array())
    {
        //TODO
    }
    
    
    /* Getters */
    public function getNombre(){ return $this->nombre; }
                
    public function getApellido(){return $this->nombre;}
    
    public function getCI(){return $this->ci;}
    
    /* Setters */
    
    public function setNombre($nombre) { $this->nombre = $nombre; }
    
            
}


?>