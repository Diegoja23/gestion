<?php

    $archivo = $_FILES["input_file_adjunto"]["tmp_name"];    
    $tamanio = $_FILES["input_file_adjunto"]["size"];
    $tipo    = $_FILES["input_file_adjunto"]["type"];
    //$nombre  = $_FILES["input_file_adjunto"]["name"];     
    $nombre_adjunto = $_POST['txt_nombre_adjunto'];
    $nombre  = $nombre_adjunto; 
    
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
    array_push($arrayDatosAdjuntos, $nombre_adjunto);                                           
    session_start();
    unset($_SESSION['adjunto']);
    $_SESSION['adjunto'] = $arrayDatosAdjuntos;    
    
    //echo $cod = base64_encode($contenido);
    /*$cod = base64_encode($contenido);
    echo json_encode($cod);*/
    echo $nombre_adjunto;
   


