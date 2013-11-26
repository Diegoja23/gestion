<?php
/**
 * class Grupo
 * autor: gestion
 * 
 */

class Grupo
{
    
    private $id_gestion;  
    private $fecha_inicio;
    private $fecha_fin;
    private $estado;
    private $id_tipo_gestion;
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
        return ($att != 'myci');
    }  

}

?>