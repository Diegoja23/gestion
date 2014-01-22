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
    
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
    public function add()
    {
        $object_vars=get_object_vars($this);       
        $fieldsGrupo = array();
        foreach($object_vars as $key => $value)        
            if($this->attNotDistinctToTable($key))
                $fieldsGrupo[$key] = $value;
             
        return $this->myci->grupos->insert_grupo($fieldsGrupo, $this->clientes, $this->participantes);         
    }
    
    public function attNotDistinctToTable($att)
    {
        return ($att != 'myci' && $att != 'clientes' && $att != 'participantes');
    }      
        
    public function convertirArray()
    {
        $object_vars=get_object_vars($this);        
        $fieldsGrupo = array();
        $arrayClientes = array();
        $arrayParticipantes = array();
        foreach($object_vars as $key => $value)
        {                   
            if($this->attNotDistinctToTable($key))
                $fieldsGrupo[$key] = $value;    
            else if($key=='clientes')
            {
                foreach($this->clientes as $cliente)                
                    $arrayClientes[] = $cliente->convertirArray(false);                               
                $fieldsGrupo[$key] = $arrayClientes;                
            }
            else if($key=='participantes')
            {
                foreach($this->participantes as $participante)                
                    $arrayParticipantes[] = $participante->convertirArray(false);                               
                $fieldsGrupo[$key] = $arrayParticipantes;                
            }                       
        }
        return $fieldsGrupo;
    }    
  
}

?>