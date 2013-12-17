<?php

class Adjuntos extends CI_Model 
{
    
    function __construct()
    {       

    }
    
    function add($adjunto, $id_tramite)
    {
        $sql =
            "INSERT INTO adjuntos 
            (archivo, mime, nombre, id_tramite) values
            ('".$adjunto->getArchivo()."', '".$adjunto->getTipo()."','".$adjunto->getNombre()."', '".$id_tramite."')";

        return $this->db->query($sql);               
    }     
       
 /*   function get_adjuntos($id_persona)
    {
        $sql = "SELECT * FROM datos_complementarios as d where d.id_persona=".$id_persona;                
        $query = $this->db->query($sql);                   
        return $query->result();   
    }       
    
    function get_blob($id)
    {
        $sql = "SELECT * FROM datos_complementarios as d where d.id_dato_complementario=".$id;                
        $query = $this->db->query($sql);                   
        return $query->result();   
    }   
        */
}

?>