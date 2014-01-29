<?php
require_once('Usuario.php');
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
        $Cliente = new Cliente($paramsCliente);
        if($Cliente->validar()) 
            return $Cliente->add();            
        else 
            return false;        
    }
    
    public function modificarCliente(Cliente $Cliente)
    {
        return $Cliente->update(); 
    } 
    
    public function modificarParticipante(Participante $Participante)
    {
        return $Participante->update(); 
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
    
    public function eliminarPersonaById($id_persona){        
        $un_participante = new Participante(array('id'=>$id_persona));        
        return $un_participante->eliminarByCI();        
    }      
    
    public function getClientes($limit = 0, $offset = -1) 
    {
        return Cliente::getAll($limit, $offset);
    }   
    
    public function getParticipantes($limit = 0, $offset = -1) 
    {
        return Participante::getAll($limit, $offset);
    }           

    public function agregarParticipante($paramsParticipante)
    {
        $Participante = new Participante($paramsParticipante);
        if($Participante->validar()) 
            return $Participante->add();            
        else 
            return false;          
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
    
    public function agregarAdjuntoAlParticipante($id_persona,$el_adjunto)
    {
        $Participante = new Participante(array('id_persona' => $id_persona));        
        $attsAdjuntos = array('nombre' => $el_adjunto['nombre'], 'archivo' => $el_adjunto['archivo'], 'tipo' => $el_adjunto['tipo']);
        $Adjunto = new Adjunto($attsAdjuntos);
        return $Participante->addAdjunto($Adjunto);        
    }     
 
 
    /* USUARIOS */
    
    /* El login retorna un objeto usuario, si es vacio pues, el login es incorrecto */
    public function login($email, $contraseña)
    {
        $paramsUsuario=array();
        $ci =& get_instance();                      
        $data = $ci->usuarios->login($email,$contraseña);
        if($data)
        {
            foreach($data as $u)
            {
                $paramsUsuario["id_persona"] = $u->id_usuario;   
                $paramsUsuario["nombre"] = $u->nombre;    
                $paramsUsuario["apellido"] = $u->apellido;    
                $paramsUsuario["email"] = $u->email;  
                $paramsUsuario["rol"] = $u->rol;  
            }            
            $Usuario = new Usuario($paramsUsuario);
            return $Usuario;
        }
        return false;
    }
    
    public function getUsuarios($limit = 0, $offset = -1)
    {
        return Usuario::getAll($limit, $offset);
    }
        
    public function agregarUsuario($paramsUsuario)
    {
        $Usuario = new Usuario($paramsUsuario);
        if($Usuario->validar()) 
            return $Usuario->add();            
        else 
            return false;         
    }    
        
    public function modificarUsuario(Usuario $Usuario, $changePass=false)
    {
        return $Usuario->update(); 
    }         
        
    public function eliminarUsuario($id_usuario)        
    {
        $Usuario = new Usuario(array('id_persona' => $id_usuario));
        return $Usuario->Eliminar();         
    }
    
}


?>