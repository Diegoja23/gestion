<?php
require_once('Persona.php');
/**
 * class Usuario
 * autor: gestion
 * 
 */

class Usuario extends Persona
{
    
    protected $contrasenia;
    protected $rol;
    protected $ci;
    
    /* Constructor */
    public function __construct($params = array())
    {
        parent::__construct($params);  
    }
    
    
    /* Getters */
    public function getDireccion(){ return $this->direccion; }
                
    public function getTelefono(){return $this->telefono;}
    
    public function getCI(){return $this->ci;}
    
    public function getRol(){return $this->rol;}
    
    /* Setters */

    
    public function exists()
    {
        //TODO
        return false;
    }            
    
 
}


?>