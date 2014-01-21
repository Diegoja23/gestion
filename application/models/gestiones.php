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
                
    function insert_gestion($gestionParams)
    {
         
    }   
    
                 
}

?>