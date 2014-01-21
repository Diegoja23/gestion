<?php
/**
 * class Gestion
 * autor: gestion
 * 
 */

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
    private $id_usuario;
    
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
        return $this->id_tipo_gestion;
    }
    
    public function getEstado()
    {
        return $this->estado;
    }
    
    public function getIdGrupo()
    {
        return $this->id_grupo;
    }
    
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    public function add()
    {
        $object_vars=get_object_vars($this);       
        $fieldsGestion = array();
        foreach($object_vars as $key => $value)        
            if($this->attNotDistinctToTable($key))
                $fieldsGestion[$key] = $value;
             
        return $this->myci->gestiones->insert_gestion($fieldsGestion);            
        //$id_persona = $this->myci->personas->insert_persona($fieldsGestion);             
        /*if(!empty($this->adjuntos) && $id_persona > 0)
            foreach($this->adjuntos as $adjunto)            
                if(!$this->myci->datos_complementarios->add($adjunto, $id_persona)) return false;            
          */                                                    
        //return true;

    }

    public function attNotDistinctToTable($att)
    {
        return ($att != 'myci' && $att != 'tipo_gestion');
    }  

}

?>