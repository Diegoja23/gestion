<?php

    $archivo = $_FILES["input_file_cedula"]["tmp_name"];    
    $tamanio = $_FILES["input_file_cedula"]["size"];
    $tipo    = $_FILES["input_file_cedula"]["type"];
    $nombre  = $_FILES["input_file_cedula"]["name"]; 
    
    if ( $archivo != "none" )
    {
        $fp = fopen($archivo, "rb");
        $contenido = fread($fp, $tamanio);
        $contenido = addslashes($contenido);
        fclose($fp);   
    }
    else{
        return -1;
    }
         
    $arrayDatosAdjuntos = array(
                                array(  'nombre' => $nombre,
                                        'archivo' => $contenido,                                       
                                        'tipo' => $tipo)
                               );                                          
                                               
    session_start();
    unset($_SESSION['adjunto']);
    $_SESSION['adjunto'] = $arrayDatosAdjuntos;    
    
    //echo $cod = base64_encode($contenido);
    $cod = base64_encode($contenido);
    echo json_encode($cod);
   


