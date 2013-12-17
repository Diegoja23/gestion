<?php
/**
 * class Grupo
 * autor: gestion
 * 
 */

class Grupo
{
    
    private $id_grupo;  
    private $descripcion;
    private $clientes = array();
    private $participantes = array();
    
    private $myci;    
    
        
    /* Constructor */
    public function __construct($params = array())
    {
        foreach ($params as $att => $key)
            $this->$att = $key;   

        $this->myci =& get_instance();       
    }
    
  
}

?>