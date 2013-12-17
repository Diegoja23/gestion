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
            $attsAdjuntos = array('nombre' => $p['nombre'], 'archivo' => $p['archivo'], 'tipo' => $p['tipo']);
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
    
    
            
}


?>