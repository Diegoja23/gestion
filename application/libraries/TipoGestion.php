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
    
     
    
  
}


?>