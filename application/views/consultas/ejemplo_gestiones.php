<?php

    $Fachada = Fachada::getInstancia();
    
    //echo "Eliminar ".$Fachada->eliminarAdjuntoCliente(11);
    
    echo "<hr><b>Tipos de Gestion</b> <br><br>";
    $tipos = $Fachada->getTiposGestion();
        
    foreach ($tipos as $t) 
    {        
        echo $t->getIdTiposGestion()." - ".$t->getDescripcion()."<br>";                
        echo "<br><b>Tipos de Tramite para gestion ".$t->getDescripcion().":</b> <br>";
        $tipos = $Fachada->getTiposTramiteByGestion($t->getIdTiposGestion());
        foreach($tipos as $t)        
        {
            echo $t->getIdTiposTramite()." - ".$t->getDescripcion()."<br>";              
        }
        echo "<br><br>";
        //getTiposTramiteByGestion
    }      
    // clientes
    $clientes = $Fachada->getClientes();
    
    $select_multiple_clientes = 'Clientes: <select multiple name="clientes">';
    
    foreach ($clientes as $c) 
    {
        $select_multiple_clientes .= '<option value="'.$c->getId().'">'.$c->getNombre().'</option>';
    }      
        
    $select_multiple_clientes .= '</select><br>';
            
    echo $select_multiple_clientes;
    
    //participantes
    $participantes = $Fachada->getParticipantes();

    $select_multiple_participantes = 'Participantes: <select multiple name="participantes">';
    
    foreach ($participantes as $p) 
    {
        $select_multiple_participantes .= '<option value="'.$p->getId().'">'.$p->getNombre().'</option>';
    }      
        
    $select_multiple_participantes .= '</select><br>';
            
    echo $select_multiple_participantes;    
    
    
    $tramites = $Fachada->getTramites();
    
    foreach($tramites as $tramite)
    {
        echo "<hr><b>Descri tramite:</b> ".$tramite->getDescripcion();
        echo "<br><b>Descri tipo tramite:</b> ".$tramite->getTipoTramite()->getDescripcion(); 
    }

    // Logica para modificar un trámite mediante el propio objeto tramite
    //Las propiedades del tramite q van a ser modificadas son las que se cambien con los setters
    // como en el ejemplo
    $tramite->setDescripcion("Esta es la nueva descripcion para el trámite modificado");
    $tramite->setDocumento("<p>Esta es la nueva PLANTILLA para este tramite que hasido modificado </p>");
    $Fachada->modificarTramite($tramite);
    
    // Eliminar tramite
    echo "Eliminar tramite ".$Fachada->eliminarTramite(2);
    
    //Agregar Tipo Tramite (Plantilla) - se necesita un id tipo de gestion
    $paramsTipoTramite = array();
        
    $paramsTipoTramite['descripcion'] = 'Compra-venta cacharro';
    $paramsTipoTramite['plantilla'] = '<h2>Compra-venta cacharro</h2><p>Este es un docu..';
    $paramsTipoTramite['id_tipos_gestion'] = 1;
    echo "Tipo tramite agregado ".$Fachada->agregarTipoTramite($paramsTipoTramite);
    
    //Modificar tipo tramite
    $TipoTramite = new TipoTramite(array(
                                         'id_tipo_tramite' => 3,
                                         'descripcion' => 'descripcion de tramite modificado',
                                         'plantilla' => '<h2>Pkantilla tramite modificado</h2>',
                                         'id_tipos_gestion' => 1));
   
    //Modificar 
    $Fachada->modificarTipoTramite($TipoTramite);
    
    
    
    
    
    
    
    
