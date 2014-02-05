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
        if($this->fecha_inicio == null) $this->fecha_inicio = date("Y-m-d");        
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

    public function modificar()
    {
        $continue=true;
        $object_vars=get_object_vars($this);       
        $fieldsGestion = array();
        foreach($object_vars as $key => $value)        
            if($this->attNotDistinctToTable($key) && $key != 'id_tipo_gestion')//el tipo de gestion no es modificable ya que de este dependen la lista de tramites
                $fieldsGestion[$key] = $value;
             
        if(!empty($this->grupo))             
            if (!$this->grupo->replace()) $continue=false;            
            
        if($continue) return $this->myci->gestiones->modificar_gestion($fieldsGestion);             
        return false;             
    } 
    
    public function eliminar()
    {
        if(!isset($this->grupo) || $this->grupo==null) $this->grupo = new Grupo(array('id_grupo' =>$this->id_grupo));
         
        if($this->myci->gestiones->eliminar_gestion($this->id_gestion)) 
        {
            $this->grupo->eliminar();
            return true;
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
            else if($key=='grupo' && is_object($this->grupo))
                $fieldsGestion[$key] = $this->grupo->convertirArray();
            else if($key=='tramites' && is_array($this->tramites))
            {
                foreach($this->tramites as $tramite)                
                    $arrayTramites[] = $tramite->convertirArray();                               
                    $fieldsGestion[$key] = $arrayTramites;                  
            }            
        }
        return $fieldsGestion;
    }
    
    public function getById()
    {
        $array_gestion = $this->myci->gestiones->getById($this->id_gestion);  
        $this->materializar($array_gestion[0]); 
        
        $tramites_data = $this->myci->tramites->get_tramites($this->id_gestion);
        $arrayTramites = array();
        foreach($tramites_data as $t)
        {
            $paramsTramite["id_tramite"] = $t->id_tramite;   
            $paramsTramite["descripcion"] = $t->descripcion;    
            $paramsTramite["fecha_inicio"] = Common::fromSqlToUsrDate($t->fecha_inicio);   
            $paramsTramite["fecha_fin"] = Common::fromSqlToUsrDate($t->fecha_fin);   
            $paramsTramite["estado"] = $t->estado;   
            $paramsTramite["id_tipo_tramite"] = $t->id_tipo_tramite;    
            $paramsTramite["id_gestion"] = $t->id_gestion;   
            $paramsTramite["documento"] = $t->documento;     
            $paramsTramite["adjuntos"] = array();
                       
            $TipoTramite = new TipoTramite(array('id_tipo_tramite' => $t->id_tipo_tramite));
            $TipoTramite->getById();
            $paramsTramite['tipo_tramite'] = $TipoTramite;
            
            $Tramite = new Tramite($paramsTramite);   
            $arrayTramites[] = $Tramite;
        }        
        $this->tramites = $arrayTramites;
        
        $Grupo = new Grupo(array('id_grupo' => $this->id_grupo));
        $Grupo->fill();            
        $this->grupo = $Grupo;
        
        $TipoGestion = new TipoGestion(array('id_tipos_gestion' => $this->id_tipo_gestion));
        $TipoGestion->getById();
        
        $this->tipo_gestion=$TipoGestion;
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
}
?>