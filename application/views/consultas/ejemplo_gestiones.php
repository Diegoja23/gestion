<?php

    $Fachada = Fachada::getInstancia();
    
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