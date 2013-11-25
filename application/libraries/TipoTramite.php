<?php

/**
 * class TipoGestion
 * autor: gestion
 * 
 */

abstract class TipoTramite
{
    private $id_tipo_tramite;
    private $descripcion;
    private $plantilla;
    
    // Instancia codeIgniters
    private $myci;
    /* Constructor */
    public function __construct($params = array())
    {
        foreach ($params as $att => $key)
            $this->$att = $key;   

        $this->myci =& get_instance();
        $this->loadDataModel();
        //TODO
    }
    
    
    /* Getters */
    public function getIdTiposTramite(){ return $this->id_tipo_tramite; }
                
    public function getDescripcion(){return $this->descripcion;}
    
    public function getPlantilla(){return $this->plantilla;}
      
    /* Setters */
    
    public function setIdTiposGestion($vid_tipo_tramite) { $this->id_tipo_tramite = $vid_tipo_tramite; }
    
    public function setDescripcion($vdescripcion) { $this->descripcion = $vdescripcion; }    

    public function setPlantilla($vplantilla) { $this->plantilla = $vplantilla; }  
    
    
    /* Database */
    private function loadDataModel()
    {
        $this->myci =& get_instance();
        $this->loadDatabase();
        $this->setModel();  
    }    
    
    private function loadDatabase()
    {
        if (!is_null($this->myci))      
            $this->myci->load->database('tipos_tramite', false, true);                                
    }
    
    private function setModel()
    {
        if (!is_null($this->myci))      
            $this->myci->load->model('tipos_tramite', 'tt');                                        
    }           
    
    /*metodos*/
    public static function getAll()
    {
        $arrayTiposTramite = array();
        $paramsTiposTramite = array();
        $ci =& get_instance();
        $data = $ci->personas->get_all_personas(true, $limit, $offset);
        foreach($data as $p)
        {
            $paramsCliente["id_persona"] = $p->id_persona;   
            $paramsCliente["nombre"] = $p->nombre;    
            $paramsCliente["apellido"] = $p->apellido;    
            $paramsCliente["email"] = $p->email;    
            $paramsCliente["direccion"] = $p->direccion;    
            $paramsCliente["telefono"] = $p->telefono;    
            $paramsCliente["ci"] = $p->ci;    
            $paramsCliente["adjuntos"] = array();    
            
            $adjuntos = $ci->datos_complementarios->get_adjuntos($p->id_persona);    
            foreach ($adjuntos as $a) 
            {
                $attsAdjuntos = array('nombre' => $a->nombre, 'archivo' => $a->archivo, 'tipo' => $a->mime);
                $Adjunto = new Adjunto($attsAdjuntos);
                array_push($paramsCliente["adjuntos"],$Adjunto);
            }  
            
            $Cliente = new Cliente($paramsCliente);   
            $arrayClientes[] = $Cliente;
        }

        return $arrayClientes;
    }
  
}


?>