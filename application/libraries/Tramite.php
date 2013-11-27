<?php
/**
 * class Tramite
 * autor: gestion
 * 
 */

class Tramite
{
    
    private $id_tramite;  
    private $descripcion;
    private $fecha_inicio;
    private $fecha_fin;
    private $estado;
    
    private $id_tipo_tramite;
    
    private $tipo_tramite;//Objecto TipoTramite
    private $id_gestion;
    
    private $adjuntos = array();
    
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
        return $this->id_tramite;
    }    
        
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
    public function getEstado()
    {
        return $this->estado;
    }
    
    
    public function validar()
    {
        //TODO -- validar
        return true;    
    }
    
    public function add()
    {
        $object_vars=get_object_vars($this);       
        $fieldsTramite = array();
        foreach($object_vars as $key => $value)        
            if($this->attNotDistinctToTable($key))
                $fieldsTramite[$key] = $value;
             
        return $this->myci->tramites->insert_tramite($fieldsTramite);            
        //$id_persona = $this->myci->personas->insert_persona($fieldsGestion);             
        /*if(!empty($this->adjuntos) && $id_persona > 0)
            foreach($this->adjuntos as $adjunto)            
                if(!$this->myci->datos_complementarios->add($adjunto, $id_persona)) return false;            
          */                                                    
        //return true;

    }

    public function attNotDistinctToTable($att)
    {
        return ($att != 'myci' && $att != 'tipo_tramite' && $att != 'adjuntos');
    }  

}

?>