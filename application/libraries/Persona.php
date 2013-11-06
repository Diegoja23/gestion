<?php

/**
 * class Persona
 * autor: gestion
 * 
 */

class Persona
{
    private $nombre;
    private $apellido;
    private $email;
    
    // Instancia codeIgniters
    protected $myci;
    /* Constructor */
    public function __construct($attr = array())
    {
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
    
    public function setNombre($nombre) { $this->nombre = $nombre; }
    
    
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
    
    
    
    

    /* Miembros estáticos, manejan funcionalidad de todos */
    public static function getAllPerson()
    {
        $arrayPersonas = array();
        $paramsPersona = array();
        $ci =& get_instance();                      
        $data = $ci->p->get_all_personas();
        foreach($data as $p)
        {
            $paramsPersona["GenreId"] = $p->GenreId;    
            $Persona = new Persona($paramsPersona);   
            $arrayPersonas[] = $Persona;
        }
        
        return $arrayPersonas;
    }    
}


?>