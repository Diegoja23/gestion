<?php

require_once('TipoGestion.php');
require_once('TipoTramite.php');
require_once('Gestion.php');
require_once('Tramite.php');
/**
 * class ServiciosGestion
 * autor: gestion
 * 
 */

class ServiciosGestion
{
    

    /* Constructor */
    public function __construct()
    {
        
    }
    

    public function getTiposGestion()
    {
        $arrayTipos = array();
        $paramsTipo = array();
        $ci =& get_instance();                      
        $data = $ci->gestiones->get_tipos_gestion();
        foreach($data as $t)
        {
            $paramsTipo["id_tipos_gestion"] = $t->id_tipos_gestion;   
            $paramsTipo["descripcion"] = $t->descripcion;    

            $Tipo = new TipoGestion($paramsTipo);   
            $arrayTipos[] = $Tipo;
        }

        return $arrayTipos;
    }  

    public function getTiposTramiteByGestion($id_tipos_gestion)
    {
        $arrayTipos = array();
        $paramsTipo = array();
        $ci =& get_instance(); 
        
        $data = $ci->tramites->get_tipos_tramite_by_gestion($id_tipos_gestion);        
        foreach($data as $t)
        {
            $paramsTipo["id_tipo_tramite"] = $t->id_tipo_tramite;   
            $paramsTipo["descripcion"] = $t->descripcion;    
            $paramsTipo["plantilla"] = $t->plantilla;    

            $Tipo = new TipoTramite($paramsTipo); 
            $arrayTipos[] = $Tipo;
        }

        return $arrayTipos;
    }      
    
    public function agregarGestion($paramsGestion) 
    {
        $Gestion = new Gestion($paramsGestion);
        if($Gestion->validar()) 
            return $Gestion->add();            
        else 
            return false;        
    }    
    
    public function agregarTramite($paramsTramite) 
    {
        $Tramite = new Tramite($paramsTramite);
        //var_dump($Tramite);die();
        if($Tramite->validar()) 
            return $Tramite->add();            
        else 
            return false;        
    }     
    
    public function getTramites($id_gestion = 0)
    {
        $arrayTramites = array();
        $paramsTramite = array();
        $ci =& get_instance();                      
        $data = $ci->tramites->get_tramites($id_gestion);
        foreach($data as $t)
        {
            $paramsTramite["id_tramite"] = $t->id_tramite;   
            $paramsTramite["descripcion"] = $t->descripcion;    
            $paramsTramite["fecha_inicio"] = $t->fecha_inicio;   
            $paramsTramite["fecha_fin"] = $t->fecha_fin;   
            $paramsTramite["estado"] = $t->estado;   
            $paramsTramite["id_tipo_tramite"] = $t->fecha_inicio;   
            $paramsTramite["id_gestion"] = $t->id_gestion;    

            $Tipo = new Tramite($paramsTramite);   
            $arrayTramites[] = $Tipo;
        }

        return $arrayTramites;        
    }
    
    public function getTramiteById($id)
    {
        $un_tramite = new Tramite(array('id_tramite'=>$id)); 
        $un_tramite->getById();
        return $un_tramite;    
    }
            
}


?>