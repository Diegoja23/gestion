<?php

/**
 * class TipoTramite
 * autor: gestion
 * 
 */

 class TipoTramite
{
    private $id_tipo_tramite;
    private $descripcion;
    private $plantilla;
    private $id_tipos_gestion;
    
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
    public function getIdTiposTramite(){ return $this->id_tipo_tramite; }
                
    public function getDescripcion(){return $this->descripcion;}
    
    public function getPlantilla(){return $this->plantilla;}
      
    /* Setters */
    
    public function setIdTiposGestion($vid_tipo_tramite) { $this->id_tipo_tramite = $vid_tipo_tramite; }
    
    public function setDescripcion($vdescripcion) { $this->descripcion = $vdescripcion; }    

    public function setPlantilla($vplantilla) { $this->plantilla = $vplantilla; }  
    
    
    public function validar()
    {
        //TODO
        return true;    
    }
    
    public function add()
    {
        $object_vars=get_object_vars($this);       
        $fieldsTipoTramite = array();
        foreach($object_vars as $key => $value)        
            if($this->attNotDistinctToTable($key))
                $fieldsTipoTramite[$key] = $value;
             
        return $this->myci->tramites->insert_tipo_tramite($fieldsTipoTramite);           
    }
    
    public function modificar()
    {
        $object_vars=get_object_vars($this);       
        $fieldsTipoTramite = array();
        foreach($object_vars as $key => $value)        
            if($this->attNotDistinctToTable($key))
                $fieldsTipoTramite[$key] = $value;
             
        return $this->myci->tramites->modificar_tipo_tramite($fieldsTipoTramite);                           
    }     
    
    public function attNotDistinctToTable($att)
    {
        return ($att != 'myci');
    }     

    public function getById()
    {
        $array_tipo_tramite = $this->myci->tramites->getTipoTramiteById($this->id_tipo_tramite);        
        $this->materializar($array_tipo_tramite[0]);
    }    
    
    public function materializar($params)
    {
        foreach ($params as $att => $key){
            $this->$att = $key;   
        }
    }
        
    public function convertirArray(){
        $object_vars=get_object_vars($this);        
        $fieldsTipoTramite = array();
        foreach($object_vars as $key => $value){                   
            if($key != 'myci'){
                $fieldsTipoTramite[$key] = $value;   
            } 
        }
        return $fieldsTipoTramite;
    }
}


?>