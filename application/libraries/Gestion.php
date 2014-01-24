<?php
/**
 * class Gestion
 * autor: gestion
 * 
 */
require_once('Grupo.php');

class Gestion
{
    
    private $id_gestion; 
    private $descripcion;
    private $fecha_inicio;
    private $fecha_fin;
    private $estado;
    private $id_tipo_gestion;
    private $tipo_gestion;
    private $id_grupo;
    private $grupo;
    private $id_usuario;
    
    private $tramites;
    
    private $myci;
    
    /* Constructor */
    public function __construct($params = array())
    {
        foreach ($params as $att => $key)
            $this->$att = $key;   

        $this->myci =& get_instance();       
    }

    /* getters */
    public function getId(){ return $this->id_gestion; }
    
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }
    
    public function getFechaFin()
    {
        return $this->fecha_fin;
    }
    
    public function getTipoGestion()
    {
        return $this->tipo_gestion;
    }
    
    public function getEstado()
    {
        return $this->estado;
    }
    
    public function getIdGrupo()
    {
        return $this->id_grupo;
    }
    
    public function getGrupo()
    {
        return $this->grupo;
    }
    
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }
    
    public function getTramites()
    {
        return $this->tramites;
    }
    
    /* setters */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;
    }

    public function validar()
    {
        //TODO
        return true;    
    }
    
    public function add()
    {
        $object_vars=get_object_vars($this);       
        $fieldsGestion = array();
        foreach($object_vars as $key => $value)        
            if($this->attNotDistinctToTable($key))
                $fieldsGestion[$key] = $value;
                                
        $id_grupo = $this->grupo->add();      
        if($id_grupo > 0)            
        {
            $fieldsGestion['id_grupo'] = $id_grupo;   
            return $this->myci->gestiones->insert_gestion($fieldsGestion);            
        }        
        return false;                       

    }

    public function attNotDistinctToTable($att)
    {        
        return ($att != 'myci' && $att != 'tipo_gestion' && $att != 'grupo' && $att != 'tramites');
    }
    
    public function convertirArray(){
        $object_vars=get_object_vars($this);        
        $fieldsGestion = $arrayTramites = array();        
        foreach($object_vars as $key => $value)
        {                   
            if($this->attNotDistinctToTable($key))
                $fieldsGestion[$key] = $value;   
            else if($key=='tipo_gestion')
                $fieldsGestion[$key] = $this->tipo_gestion->convertirArray();
            else if($key=='grupo')
                $fieldsGestion[$key] = $this->grupo->convertirArray();
            else if($key=='tramites')
            {
                foreach($this->tramites as $tramite)                
                    $arrayTramites[] = $tramite->convertirArray();                               
                    $fieldsGestion[$key] = $arrayTramites;                  
            }
            
        }
        return $fieldsGestion;
    }
}
?>