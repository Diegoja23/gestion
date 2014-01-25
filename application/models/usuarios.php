<?php

class Usuarios extends CI_Model 
{
    
    function __construct()
    {
    }
    
    
    public function login($email, $contrasenia)
    {
        $query = $this->db->get_where('usuario', array('email' => $email, 'contraseña' => $contrasenia));
        if ($query->num_rows > 0) return $query->result();
        return false;        
    }
 
            
}

?>