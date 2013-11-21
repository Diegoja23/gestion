<?php

/**
 * class Persona
 * autor: gestion
 * 
 */

abstract class Persona
{
    protected $id_persona;
    protected $nombre;
    protected $apellido;
    protected $email;
    protected $adjuntos = array();
    
    // Instancia codeIgniters
    protected $myci;
    /* Constructor */
    public function __construct($params = array())
    {
        foreach ($params as $att => $key)
            $this->$att = $key;   

        $this->myci =& get_instance();
        //TODO
    }
    
    
    /* Getters */
    public function getNombre(){ return $this->nombre; }
                
    public function getApellido(){return $this->apellido;}
    
    public function getMail(){return $this->email;}
    
    /* Setters */
    
    public function setNombre($nombre) { $this->nombre = $nombre; }
    
    public function setApellido($apellido) { $this->apel = $nombre; }    
    

    abstract public function exists();
      
}


?>