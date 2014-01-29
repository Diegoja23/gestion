<?php

class Usuarios extends CI_Model 
{
    
    function __construct()
    {
    }
    
    
    public function login($email, $contraseña)
    {
        $query = $this->db->get_where('usuario', array('email' => $email, 'contraseña' => $contraseña));
        if ($query->num_rows > 0) return $query->result();
        return false;        
    }
    
    public function get_all_usuarios($limit = 0, $offset = -1)
    {
        $sql = "SELECT * FROM usuario";                
        
        if ($limit > 0) $sql .= " LIMIT ".$offset;
        //$this->db->limit($limit);
        if ($offset >= 0) $sql .= ",".$limit;
        //die($sql);
        $query = $this->db->query($sql);                   
        return $query->result();              
    }
    
    function insert_usuario($usuarioParams)
    {
        $id_usuario = 0;
        $this->db->insert('usuario', $usuarioParams);   
        $id_usuario = $this->db->insert_id();
        return $id_usuario;   
    }    
 
}

?>