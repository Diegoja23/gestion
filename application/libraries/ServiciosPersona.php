<?php
require_once('Cliente.php');
require_once('Adjunto.php');
/**
 * class ServiciosPersona
 * autor: gestion
 * 
 */

class ServiciosPersona 
{
    

    /* Constructor */
    public function __construct()
    {

    }
    
    public function agregarCliente($paramsCliente, $paramsAdjuntos = array()) 
    {
        $paramsCliente['adjuntos'] = array();
        foreach ($paramsAdjuntos as $p) 
        {
            $attsAdjuntos = array('nombre' => $p['nombre'], 'archivo' => $p['archivo'], 'tipo' => $p['tipo'], 'from' => 'adjuntos');
            $Adjunto = new Adjunto($attsAdjuntos);
            array_push($paramsCliente['adjuntos'], $Adjunto);  
           
        }
        //var_dump($paramsCliente);die();
        $Cliente = new Cliente($paramsCliente);
        //var_dump($Cliente);die();
        if($Cliente->validar()) 
            return $Cliente->add();            
        else 
            return false;        
    }
    
    public function modificarCliente(Cliente $Cliente)
    {
        return $Cliente->update(); 
    } 
    
    public function getByCI($ci){
        $un_cliente = new Cliente(array('ci'=>$ci)); 
        $un_cliente->getByCI();
        return $un_cliente;
    }
    
    public function getById($id_persona){
        $un_cliente = new Cliente(array('id_persona'=>$id_persona)); 
        $un_cliente->fillById();
        return $un_cliente;
    }
        
    public function eliminarByCI($ci){        
        $un_cliente = new Cliente(array('ci'=>$ci));        
        return $un_cliente->eliminarByCI();        
    }    
    
    public function getClientes($limit = 0, $offset = -1) 
    {
        return Cliente::getAll($limit, $offset);

    }   
    
    public function getParticipantes($limit = 0, $offset = -1) 
    {
        return Participante::getAll($limit, $offset);
    }       


    public function getBlob($id)
    {
        $ci =& get_instance();
        $data = $ci->datos_complementarios->get_blob($id);
        return ($data[0]->archivo);      
    }
    
    public function eliminarAdjuntoCliente($id)
    {
        $Adjunto = new Adjunto(array('id' => $id, 'from' => 'datos_complementarios'));
        return $Adjunto->Eliminar();     
    }      
    
    public function agregarAdjuntoAlCliente($id_cliente,$el_adjunto)
    {
        $Cliente = new Cliente(array('id_persona' => $id_cliente));        
        $attsAdjuntos = array('nombre' => $el_adjunto['nombre'], 'archivo' => $el_adjunto['archivo'], 'tipo' => $el_adjunto['tipo']);
        $Adjunto = new Adjunto($attsAdjuntos);
        return $Cliente->addAdjunto($Adjunto);        
    }  
 
}


?>