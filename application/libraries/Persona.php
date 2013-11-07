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
    
    // Instancia codeIgniters
    protected $myci;
    /* Constructor */
    public function __construct($params = array())
    {
        foreach ($params as $att => $key)
            $this->$att = $key;   

        $this->myci =& get_instance();
        $this->loadDataModel();
        //TODO
    }
    
    
    /* Getters */
    public function getNombre(){ return $this->nombre; }
                
    public function getApellido(){return $this->apellido;}
    
    public function getMail(){return $this->email;}
    
    /* Setters */
    
    public function setNombre($nombre) { $this->nombre = $nombre; }
    
    public function setApellido($apellido) { $this->apel = $nombre; }    

    
    
    /* Database */
    private function loadDataModel()
    {
        $this->myci =& get_instance();
        $this->loadDatabase();
        $this->setModel();  
    }    
    
    private function loadDatabase()
    {
        if (!is_null($this->myci))      
            $this->myci->load->database('gestion', false, true);                                
    }
    
    private function setModel()
    {
        if (!is_null($this->myci))      
            $this->myci->load->model('personas', 'p');                                        
    }           
  
}


?>