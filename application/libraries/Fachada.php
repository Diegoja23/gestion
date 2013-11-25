<?php
require_once('ServiciosPersona.php');
require_once('ServiciosGestion.php');
/**
 * class Fachada
 * autor: gestion
 * 
 */

class Fachada 
{
    
    private $sp;
    private $sg;    
    
    private static $Instancia = null;
    
    /* Constructor */
    private function __construct()
    {
        $this->sp = new ServiciosPersona();
        $this->sg = new ServiciosGestion();
    }
    
    public static function getInstancia()
    {
        if(is_null(self::$Instancia)){
            self::$Instancia = new Fachada();         
        }
        return self::$Instancia;
    }

    public function agregarCliente($paramsCliente, $paramsAdjuntos=array()) 
    {
        return $this->sp->agregarCliente($paramsCliente,$paramsAdjuntos);    
    }
  
    public function modificarCliente($Cliente) 
    {
        return $this->sp->modificarCliente($Cliente);    
    }
      
    public function getClientes($limit = 0, $offset = -1) 
    {
        return $this->sp->getClientes($limit, $offset);
    }
    
    public function getByCI($ci){
        return $this->sp->getByCI($ci);
    }
    
    public function eliminarByCI($ci){
        return $this->sp->eliminarByCI($ci);
    }
    
    public function getTiposTramite(){
        return $this->sp->getTiposTramite();
    }
}


?>