<?php


/**
 * class TipoGestion
 * autor: gestion
 * 
 */

class TipoGestion
{
    private $id_tipos_gestion;
    private $descripcion;
    
    // Instancia codeIgniters
    private $myci;
    /* Constructor */
    public function __construct($params = array())
    {
        foreach ($params as $att => $key)
            $this->$att = $key;   

        $this->myci =& get_instance();
    }
    
    
    /* Getters */
    public function getIdTiposGestion(){ return $this->id_tipos_gestion; }
                
    public function getDescripcion(){return $this->descripcion;}
      
    /* Setters */
    
    public function setIdTiposGestion($vid_tipos_gestion) { $this->id_tipos_gestion = $vid_tipos_gestion; }
    
    public function setDescripcion($vdescripcion) { $this->descripcion = $vdescripcion; }    
    
    public function validar()
    {
        //TODO
        return true;    
    }
    
    public function add()
    {
        $object_vars=get_object_vars($this);       
        $fieldsTipoGestion = array();
        foreach($object_vars as $key => $value)        
            if($this->attNotDistinctToTable($key))
                $fieldsTipoGestion[$key] = $value;
             
        return $this->myci->gestiones->insert_tipo_gestion($fieldsTipoGestion);            
    }
        
    public function getById()
    {
        $array_tipo_gestion = $this->myci->gestiones->getTipoById($this->id_tipos_gestion);        
        $this->materializar($array_tipo_gestion[0]);
    }    
    
    public function materializar($params)
    {
        foreach ($params as $att => $key){
            $this->$att = $key;   
        }
    }    
    
    public function attNotDistinctToTable($att)
    {       
        return ($att != 'myci');
    }
        
    public function convertirArray(){
        $object_vars=get_object_vars($this);        
        $fieldsTipoGestion = array();
        foreach($object_vars as $key => $value){                   
            if($this->attNotDistinctToTable($key))
                $fieldsTipoGestion[$key] = $value;               
        }
        return $fieldsTipoGestion;
    }
    
     
    
  
}


?>