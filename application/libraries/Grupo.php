<?php
/**
 * class Grupo
 * autor: gestion
 * 
 */
require_once("Cliente.php");
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
    
    public function getClientes()
    {
        return $this->clientes;
    }
    
    public function getParticipantes()
    {
        return $this->participantes;
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
    
    public function replace()
    {
        $object_vars=get_object_vars($this);       
        $fieldsGrupo = array();
        foreach($object_vars as $key => $value)        
            if($this->attNotDistinctToTable($key))
                $fieldsGrupo[$key] = $value;
             
        return $this->myci->grupos->replace_grupo($fieldsGrupo, $this->clientes, $this->participantes);         
    }    
    
    public function eliminar()
    {
        return $this->myci->grupos->eliminar_grupo($this->id_grupo);
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

    public function fill()
    {
        $array_grupo = $this->myci->grupos->get_grupo_by_id($this->id_grupo);    
        $array_id_personas = $this->myci->grupos->get_id_rol_personas_by_grupo($this->id_grupo);
        $clientes = $participantes = array();        
        foreach($array_id_personas as $obj_id_persona)
        {            
            $Participante = new Participante(array('id_persona' => $obj_id_persona->id_persona));
            $Participante->fillById();            
            if($obj_id_persona->rol == 'c')
                $clientes[] = $Participante;
            else $participantes[] = $Participante;
        }
        $this->clientes = $clientes;
        $this->participantes = $participantes;
        $this->materializar($array_grupo[0]);   
    }
    
    private function materializar($params)
    {
        foreach ($params as $att => $key){
            $this->$att = $key;   
        }
    }
          
  
}

?>