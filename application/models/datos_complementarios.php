<?php

class Datos_complementarios extends CI_Model 
{
    
    function __construct()
    {       

    }
    
    function add($adjunto, $id_persona)
    {
        $sql =
            "INSERT INTO datos_complementarios 
            (archivo, mime, nombre, id_persona) values
            ('".$adjunto->getArchivo()."', '".$adjunto->getTipo()."','".$adjunto->getNombre()."', '".$id_persona."')";

        return $this->db->query($sql);               
    }     
    
    function get_adjuntos($id_persona)
    {
        $sql = "SELECT * FROM datos_complementarios as d where d.id_persona=".$id_persona;                
        $query = $this->db->query($sql);                   
        return $query->result();   
    }       
}

?>