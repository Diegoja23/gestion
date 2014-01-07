<?php

/**
 * class Adjunto
 * autor: gestion
 * Manejador de archivos adjuntos para trámites y clientes
 * 
 */

class Adjunto
{
    
    private $id;
    private $archivo;
    private $nombre;
    private $tipo;
    
    private $myci;       
    /* Constructor */
    public function __construct($params = array())
    {
        foreach ($params as $att => $key)
            $this->$att = $key;  
        
        $this->myci =& get_instance();
                       
    }
    
    public function getId()
    {
        return $this->id;
    }
        
    public function getArchivo()
    {
        return $this->archivo;
    }
    
    public function getNombre()
    {
        return $this->nombre;
    }    
    
    public function getTipo()
    {
        return $this->tipo;
    }     

    public function Eliminar()
    {
        return $this->myci->adjuntos->eliminar($this->id);             
    }
    
    public function convertirArray()
    {
        $object_vars=get_object_vars($this);        
        $fieldsTramite = array();
        foreach($object_vars as $key => $value)        
            if($key != 'myci'){
                $fieldsTramite[$key] = $value;   
            }        
        return $fieldsTramite;
    }
            
}


?>