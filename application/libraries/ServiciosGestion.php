<?php

require_once('TipoGestion.php');
require_once('TipoTramite.php');
require_once('Gestion.php');
require_once('Tramite.php');
require_once('Adjunto.php');
require_once('Common.php');


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
    
    public function getGestiones()
    {
        $arrayGestiones = array();
        $paramsGestion = array();
        $ci =& get_instance();                      
        $data = $ci->gestiones->get_gestiones();
        foreach($data as $g)
        {                            
            $paramsGestion["id_gestion"] = $g->id_gestion;   
            $paramsGestion["descripcion"] = $g->descripcion;    
            $paramsGestion["fecha_inicio"] = Common::fromSqlToUsrDate($g->fecha_inicio);    
            $paramsGestion["fecha_fin"] = Common::fromSqlToUsrDate($g->fecha_fin); 
            $paramsGestion["estado"] = $g->estado;
            $paramsGestion["id_tipo_gestion"] = $g->id_tipo_gestion;
            $paramsGestion["id_grupo"] = $g->id_grupo;
            $paramsGestion["id_usuario"] = $g->id_usuario;
            /* Objeto grupo de TipoGestion para gestion */
            $TipoGestion = new TipoGestion(array('id_tipos_gestion' => $g->id_tipo_gestion)); 
            $TipoGestion->getById();            
            $paramsGestion["tipo_gestion"] = $TipoGestion;
            /* Objeto grupo de Grupo para gestion */
            $Grupo = new Grupo(array('id_grupo' => $g->id_grupo));
            $Grupo->fill();            
            $paramsGestion['grupo'] = $Grupo;
            /* lista de tramites perteneciente al adjunto, false en segundo parámetro para q no cargue los adjuntos, 
             * no los necesitamos para e listado de trámties dentro de gestiones*/
            $paramsGestion['tramites'] = $this->getTramites($g->id_gestion, false);                        

            $Gestion = new Gestion($paramsGestion);   
            $arrayGestiones[] = $Gestion;
        }

        return $arrayGestiones;
    }     

    public function getTiposTramiteByTipoGestion($id_tipos_gestion)
    {
        $arrayTipos = array();
        $paramsTipo = array();
        $ci =& get_instance(); 
        
        $data = $ci->tramites->get_tipos_tramite_by_tipos_gestion($id_tipos_gestion);        
        foreach($data as $t)
        {
            $paramsTipo["id_tipo_tramite"] = $t->id_tipo_tramite;   
            $paramsTipo["descripcion"] = $t->descripcion;    
            $paramsTipo["plantilla"] = $t->plantilla;
            $paramsTipo["id_tipos_gestion"] = $id_tipos_gestion;                

            $Tipo = new TipoTramite($paramsTipo); 
            $arrayTipos[] = $Tipo;
        }

        return $arrayTipos;
    }      
    
    public function agregarGestion($paramsGestion, $grupo) 
    {
        $Gestion = new Gestion($paramsGestion);
        $Gestion->setGrupo($grupo);
        
        if($Gestion->validar()) 
            return $Gestion->add();            
        else 
            return false;        
    }    
    
    public function modificarGestion($paramsGestion, $grupo = array()) 
    {
        $Gestion = new Gestion($paramsGestion);
        $Gestion->setGrupo($grupo);
        
        if($Gestion->validar()) 
            return $Gestion->modificar();            
        else 
            return false;        
    }     
    
    public function eliminarGestion($paramsGestion)
    {
        $Gestion = new Gestion($paramsGestion);        
        return $Gestion->eliminar();                   
    }
    
    public function getGestionById($id_gestion)
    {
        $Gestion = new Gestion(array('id_gestion' => $id_gestion));
        $Gestion->getById();
        return $Gestion;
    }
    
    public function agregarTipoGestion($paramsTipoGestion) 
    {
        $TipoGestion = new TipoGestion($paramsTipoGestion);
        
        if($TipoGestion->validar()) 
            return $TipoGestion->add();            
        else 
            return false;        
    }    
    
    public function modificarTipoGestion($paramsTipoGestion) 
    {
        $TipoGestion = new TipoGestion($paramsTipoGestion);
        
        if($TipoGestion->validar()) 
            return $TipoGestion->modificar();            
        else 
            return false;        
    }      
        
    
    public function agregarTramite($paramsTramite, $paramsAdjuntos = array()) 
    {
        $paramsTramite['adjuntos'] = array();
        foreach ($paramsAdjuntos as $p) 
        {
            $attsAdjuntos = array('nombre' => $p['nombre'], 'archivo' => $p['archivo'], 'tipo' => $p['tipo'], 'from' => 'adjuntos');
            $Adjunto = new Adjunto($attsAdjuntos);
            array_push($paramsTramite['adjuntos'], $Adjunto);  
           
        }        
        $Tramite = new Tramite($paramsTramite);
        //var_dump($Tramite);die();
        if($Tramite->validar()) 
            return $Tramite->add();            
        else 
            return false;        
    }            
    
    public function modificarTramite($unTramite)
    {
        if($unTramite->validar()) 
            return $unTramite->modificar();            
        else 
            return false;                 
    }
    
    public function agregarAdjuntoAlTramite($id_tramite,$el_adjunto)
    {
        $Tramite = new Tramite(array('id_tramite' => $id_tramite));        
        $attsAdjuntos = array('nombre' => $el_adjunto['nombre'], 'archivo' => $el_adjunto['archivo'], 'tipo' => $el_adjunto['tipo']);
        $Adjunto = new Adjunto($attsAdjuntos);
        return $Tramite->addAdjunto($Adjunto);
    }
    
        
    public function getTramites($id_gestion = 0, $adjuntos=true)
    {
        $arrayTramites = array();
        $paramsTramite = array();
        $ci =& get_instance();                      
        $data = $ci->tramites->get_tramites($id_gestion);
        foreach($data as $t)
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
            
            if($adjuntos)
            {
                $adjuntos = $ci->adjuntos->get_adjuntos($t->id_tramite);               
                foreach ($adjuntos as $a) 
                {
                    $attsAdjuntos = array('id' => $a->id_adjunto,'nombre' => $a->nombre, 'archivo' => $a->archivo, 'tipo' => $a->mime, 'from' => 'adjuntos');
                    $Adjunto = new Adjunto($attsAdjuntos);               
                    array_push($paramsTramite["adjuntos"],$Adjunto);
                }                 
            }            
            $TipoTramite = new TipoTramite(array('id_tipo_tramite' => $t->id_tipo_tramite));
            $TipoTramite->getById();
            $paramsTramite['tipo_tramite'] = $TipoTramite;
            
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
    
    public function getBlob($id)
    {
        $ci =& get_instance();
        $data = $ci->adjuntos->get_blob($id);
        return ($data[0]->archivo);      
    }    
    
    public function eliminarAdjuntoTramite($id)
    {
        $Adjunto = new Adjunto(array('id' => $id, 'from' => 'adjuntos'));
        return $Adjunto->Eliminar();  
    }    
      
    public function eliminarTramite($id_tramite)
    {
        $Tramite = new Tramite(array('id_tramite' => $id_tramite));
        return $Tramite->eliminar();  
    }      
    
    public function agregarTipoTramite($paramsTipoTramite)
    {
        $TipoTramite = new TipoTramite($paramsTipoTramite);
        if($TipoTramite->validar()) 
            return $TipoTramite->add();            
        else 
            return false;             
    }    
    
    public function modificarTipoTramite($unTipoTramite)
    {
        if($unTipoTramite->validar()) 
            return $unTipoTramite->modificar();            
        else 
            return false;                 
    }
     
    public function eliminarTipoGestion($id_tipo_gestion)
    {
        $TipoGestion = new TipoGestion(array('id_tipos_gestion' => $id_tipo_gestion));
        return $TipoGestion->eliminar();  
    }       
    
    public function eliminarTipoTramite($id_tipo_tramite)
    {
        $TipoTramite = new TipoTramite(array('id_tipo_tramite' => $id_tipo_tramite));
        return $TipoTramite->eliminar();  
    }      
            
}


?>