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
    
    public function validar()
    {
        //TODO -- aqui hay que validar los datos del participante, asi como asegurarnos de que no exista previamente
        return ($this->nombre!='' && $this->apellido!='' && $this->email!='' && $this->contrasenia!='');      
    }
        
    public function add()
    {
        $object_vars=get_object_vars($this);        
        $fieldsUsuario = array();
        foreach($object_vars as $key => $value)        
            if($this->attNotDistinctToTable($key))
                if($key=='contrasenia')  $fieldsUsuario[$key] = md5($value); 
                $fieldsUsuario[$key] = $value;             
        return $this->myci->personas->insert_usuario($fieldsUsuario);             
    }    

    public function attNotDistinctToTable($att)
    {
        return ($att != 'myci');
    }  
    
 
}


?>