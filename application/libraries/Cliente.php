<?php
require_once('Persona.php');
/**
 * class Cliente
 * autor: gestion
 * 
 */

class Cliente extends Persona
{
    
    private $direccion;
    private $telefono;
    private $ci;
    
    /* Constructor */
    public function __construct($attr = array())
    {
        //TODO
    }
    
    
    /* Getters */
    public function getDireccion(){ return $this->direccion; }
                
    public function getTelefono(){return $this->telefono;}
    
    public function getCI(){return $this->ci;}
    
    /* Setters */

    
            
}


?>