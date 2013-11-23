<?php

//function cargarAdjunto(){
//$_FILES = $_POST['data'];
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
        
        /*
        //comprobamos si el archivo ha subido
        if ($nombre && move_uploaded_file($_FILES['input_file_cedula']['tmp_name'],"imagenes/".$nombre))
        {
            sleep(3);//retrasamos la petición 3 segundos
            //echo $nombre;//devolvemos el nombre del archivo para pintar la imagen
        }         
         */
        
    }
    else{
        return -1;
    }
         
    $arrayDatosAdjuntos = array(
                                array(  'nombre' => 'cedula',
                                        'archivo' => $contenido,
                                        'tipo' => $tipo)
                               );   
    session_start();
    unset($_SESSION['ci']);
    $_SESSION['ci'] = $arrayDatosAdjuntos;    
    
    header("Content-type: image/jpeg");

    //echo $cod = base64_encode($contenido);
    echo 'data:image/jpeg;base64,' . base64_encode( $contenido );
    //echo json_encode($contenido);
    //echo $nombre;
        //var_dump($archivo); die();
        //echo '<img src="data:image/jpeg;base64,' . base64_encode( $archivo ) . '" />';
//}
?>
