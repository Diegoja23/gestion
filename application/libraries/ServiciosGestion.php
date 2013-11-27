<?php

require_once('TipoGestion.php');
require_once('TipoTramite.php');
require_once('Gestion.php');
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
        //var_dump($Cliente);die();
        if($Gestion->validar()) 
            return $Gestion->add();            
        else 
            return false;        
    }    
            
}


?>