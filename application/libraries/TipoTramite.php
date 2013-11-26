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
    
}


?>