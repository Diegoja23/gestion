<?php
require_once('Persona.php');
/**
 * class Usuario
 * autor: gestion
 * 
 */

class Usuario extends Persona
{
    
    protected $contrasenia;
    protected $rol;
    protected $ci;
    
    /* Constructor */
    public function __construct($params = array())
    {
        parent::__construct($params);  
    }
    
    
    /* Getters */
    public function getDireccion(){ return $this->direccion; }
                
    public function getTelefono(){return $this->telefono;}
    
    public function getCI(){return $this->ci;}
    
    public function getRol(){return $this->rol;}
    
    /* Setters */

    
    public function exists()
    {
        //TODO
        return false;
    }            
    
    public static function getAll($limit = 0, $offset = -1)
    {
        $arrayUsuarios = array();
        $paramsUsuario = array();
        $ci =& get_instance();                      
        $data = $ci->usuarios->get_all_usuarios($limit, $offset);
        foreach($data as $u)
        {            
            $paramsUsuario["id_persona"] = $u->id_usuario;   
            $paramsUsuario["nombre"] = $u->nombre;    
            $paramsUsuario["apellido"] = $u->apellido;    
            $paramsUsuario["email"] = $u->email;    
            $paramsUsuario["contrasenia"] = $u->contraseña;    
            $paramsUsuario["rol"] = $u->rol;                  
            
            $Usuario = new Usuario($paramsUsuario);   
            $arrayUsuarios[] = $Usuario;
        }

        return $arrayUsuarios;
    }      
    
 
}


?>