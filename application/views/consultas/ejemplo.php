<?php

    $Fachada = Fachada::getInstancia();
    
    $paramsCliente=array();
    $paramsCliente['nombre']='Alberto';
    $paramsCliente['apellido']='Peterson';
    $paramsCliente['ci']='2.933.982-9';
    $paramsCliente['email']='c.peterson@gmail.com';
    $paramsCliente['telefono']='099227340';
    $paramsCliente['direccion']='Charrúa 3344';       
    
    $arrayDatosAdjuntos = array();
    
    if(isset($_POST['huboPost']))
    {
         $archivo = $_FILES["archivito"]["tmp_name"];    
         $tamanio = $_FILES["archivito"]["size"];
         $tipo    = $_FILES["archivito"]["type"];
         $nombre  = $_FILES["archivito"]["name"];    
         
         if ( $archivo != "none" )
         {
            $fp = fopen($archivo, "rb");
            $contenido = fread($fp, $tamanio);
            $contenido = addslashes($contenido);
            fclose($fp);     
         }
         
        $arrayDatosAdjuntos = array(
                                    array('nombre' => 'cedula',
                                           'archivo' => $contenido,
                                           'tipo' => $tipo)
                                    );         
    }
   
        
?>                                
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="huboPost">
        <input type="file" name="archivito">
        <input type="submit" value="Aceptar">
    </form>                                

<?php
    if($Fachada->agregarCliente($paramsCliente, $arrayDatosAdjuntos))
        echo "El cliente ". $paramsCliente['nombre']." se ingresó con éxito<br>";
    else
        echo "El cliente ". $paramsCliente['nombre']." no pudo ser ingresado. Verifique los datos<br>";   
    
    // get clientes
    echo "Clientes sin limite (todos)<br>";
    $clientes = $Fachada->getClientes();
        
    foreach ($clientes as $c) 
    {        
        echo $c->getNombre()."<br>";
        $arrayAdjuntos = $c->getAdjuntos();
        
        foreach($arrayAdjuntos as $a)
        {
            //$a->getNombre();
            //$mime = $a->getTipo();
            //$imagen = $a->getArchivo();
           // include('mostrar_archivo.php');
            //echo '<img src="http://localhost/gestion/consultas/mostrar_archivo.php?mime='.$a->getTipo().'&archivo=archivoo'.$a->getArchivo().'">';            
            
        }
    }         

    echo "Clientes, los primeros dos<br>";
    
    $clientes = $Fachada->getClientes(2,0);
    
    $clienteModificar = null;
    foreach ($clientes as $c) 
    {
        echo $c->getNombre()."<br>";
        $clienteModificar = $c;
    }       
         
    $clienteModificar->setNombre('Pablo');
    $Fachada->modificarCliente($clienteModificar);
    
   /* echo "<hr>Tipos de Gestion <br>";
    $tipos = $Fachada->getTiposGestion();
        
    foreach ($tipos as $t) 
    {        
        echo $t->getDescripcion()."<br>";
    }    
    */
    echo "<hr>Tipos de Gestion <br><br>";
    $tipos = $Fachada->getTiposGestion();
        
    foreach ($tipos as $t) 
    {        
        echo $t->getDescripcion()."<br>";                
        echo "Tipos de Tramite para gestion ".$t->getDescripcion().": <br>";
        $tipos = $Fachada->getTiposTramiteByGestion($t->getIdTiposGestion());
        foreach($tipos as $t)        
        {
            echo $t->getDescripcion();
        }
        echo "<br><br>";
        //getTiposTramiteByGestion
    }      
    
    //fecha_inicio    fecha_fin   estado  id_tipo_gestion     id_grupo    id_usuario 
        
    $paramsGestion=array();
    $paramsGestion['nombre']='Alberto';
    $paramsGestion['apellido']='Peterson';
    $paramsGestion['ci']='2.933.982-9';
    $paramsGestion['email']='c.peterson@gmail.com';
    $paramsGestion['telefono']='099227340';
    $paramsGestion['direccion']='Charrúa 3344';       
    
    
    /*if($Fachada->agregarGestion($paramsCliente, $arrayDatosAdjuntos))
        echo "El cliente ". $paramsCliente['nombre']." se ingresó con éxito<br>";
    else
        echo "El cliente ". $paramsCliente['nombre']." no pudo ser ingresado. Verifique los datos<br>";       
    */
    
    
    
?>