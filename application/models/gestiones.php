<?php

class Gestiones extends CI_Model 
{
    
    function __construct()
    {
    }
    
            
            
    function get_tipos_gestion()
    {
        $sql = "SELECT * FROM  tipos_gestion";                
        //die($sql);
        $query = $this->db->query($sql);                   
        return $query->result();        
    }  
    
    function get_gestiones()
    {
        $sql = "SELECT * FROM gestiones";                
        //die($sql);
        $query = $this->db->query($sql);                   
        return $query->result();          
    }
    
    function getTipoById($id_tipo_gestion)
    {
        $query = $this->db->get_where('tipos_gestion', array('id_tipos_gestion' => $id_tipo_gestion));
        if ($query->num_rows > 0) return $query->result();
        return false;            
    }
                
    function insert_gestion($gestionParams)
    {
         
    }   
    
                 
}

?>