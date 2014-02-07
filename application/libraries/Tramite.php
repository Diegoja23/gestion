<?php
require_once('TipoTramite.php');
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
    
    private $tipo_tramite;//Objeto TipoTramite
    private $id_gestion;
    
    private $documento;    
    private $adjuntos = array();
    
    private $myci;   
    
    /* Constructor */
    public function __construct($params = array())
    {
        foreach ($params as $att => $key)
            $this->$att = $key;   

        $this->myci =& get_instance();       
        
        if(isset($this->id_tipo_tramite) && $this->id_tipo_tramite > 0)
        {
            $TipoTramite = new TipoTramite(array('id_tipo_tramite' => $this->id_tipo_tramite));
            $TipoTramite->getById();
            $this->tipo_tramite = $TipoTramite;
        }
            
    }
    
    /* getters */
    public function getId(){ return $this->id_tramite; }    
        
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
    
    public function getTipoTramite()
    {
        return $this->tipo_tramite;
    }
    
    public function getEstado()
    {
        return $this->estado;
    }
    
    public function getDocumento()
    {
        return $this->documento;
    }   
    
    public function getIdGestion()
    {
        return $this->id_gestion;
    }
    
    public function getAdjuntos(){return $this->adjuntos;}
    
    /* setters */
    public function setDescripcion($descripcion){ $this->descripcion = $descripcion; }
    public function setDocumento($documento){ $this->documento = $documento; }    
    
    public function validar()
    {
        //TODO -- validar
        return true;    
    }
    
    public function add()
    {
        $object_vars=get_object_vars($this);       
        $fieldsTramite = array();
        if($this->fecha_inicio == null || $this->fecha_inicio == '') $this->fecha_inicio = date("Y-m-d");
        foreach($object_vars as $key => $value)        
            if($this->attNotDistinctToTable($key))
                $fieldsTramite[$key] = $value;
             
        $id_tramite = $this->myci->tramites->insert_tramite($fieldsTramite);            
        if(!empty($this->adjuntos) && $id_tramite > 0)
            foreach($this->adjuntos as $adjunto)            
                if(!$this->myci->adjuntos->add($adjunto, $id_tramite)) return false;            
                                                              
        return true;
    }
    
    public function modificar()
    {
        $object_vars=get_object_vars($this);       
        $fieldsTramite = array();
        foreach($object_vars as $key => $value)        
            if($this->attNotDistinctToTable($key))
                $fieldsTramite[$key] = $value;
             
        return $this->myci->tramites->modificar_tramite($fieldsTramite);                           
    }    
    
    public function addAdjunto($Adjunto)
    {
        return ($this->myci->adjuntos->add($Adjunto, $this->id_tramite));     
    }
    

    public function attNotDistinctToTable($att)
    {
        return ($att != 'myci' && $att != 'tipo_tramite' && $att != 'adjuntos');
    } 
        
    public function convertirArray(){
        $object_vars=get_object_vars($this);        
        $fieldsTramite = array();
        foreach($object_vars as $key => $value){                   
            if($key != 'myci'){
                if($key == 'adjuntos')
                    $value = $this->traerAdjuntosDelArray($value);
                else if($key=='tipo_tramite')
                    $value = $this->tipo_tramite->convertirArray();
                $fieldsTramite[$key] = $value;   
            } 
        }
        return $fieldsTramite;
    }
    
    public function getById()
    {
        $array_tramite = $this->myci->tramites->getById($this->id_tramite);        
        $this->materializar($array_tramite[0]);        
        $adjuntos = $this->myci->adjuntos->get_adjuntos($this->id_tramite);               
        foreach ($adjuntos as $a) 
        {
            $attsAdjuntos = array('id' => $a->id_adjunto,'nombre' => $a->nombre, 'archivo' => utf8_encode($a->archivo), 'tipo' => $a->mime, 'from' => 'adjuntos');
            $Adjunto = new Adjunto($attsAdjuntos);               
            array_push($this->adjuntos,$Adjunto);
        }                 
            
        $TipoTramite = new TipoTramite(array('id_tipo_tramite' => $this->id_tipo_tramite));
        $TipoTramite->getById();
        $this->tipo_tramite = $TipoTramite;                    
    }    
    
    public function materializar($params)
    {
        foreach ($params as $att => $key){
            if($att == 'fecha_inicio' || $att=='fecha_fin')
                $this->$att = Common::fromSqlToUsrDate($key);
            else 
                $this->$att = $key;              
        }
    }
    
    function traerAdjuntosDelArray($lista_de_adjuntos)
    {
        $retorno = array();
        foreach($lista_de_adjuntos as $un_adjunto){
            array_push($retorno, $un_adjunto->convertirArray());
        }
        return $retorno;
    }
    
    public function eliminar()
    {
        return $this->myci->tramites->eliminar($this->id_tramite);        
    }

}

?>