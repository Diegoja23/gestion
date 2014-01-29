<?php
$consulta = $_POST['consulta'];
    
switch($consulta){
    case "traer_todos":
        $listaUsuarios = traerTodos(); 
        echo crearListaParaPersonas($listaUsuarios);
        break;
    
    case "agregar_usuario": 
        $un_usuario_array = cargarValores();
        //var_dump($un_usuario_array);die();
        echo Fachada::getInstancia()->agregarUsuario($un_usuario_array);        
        break;
    
    case "modificar_usuario": 
        $un_usuario_array = cargarValores();
        $un_usuario = traerPorId($un_usuario_array['id_persona']);
        if($un_usuario_array['contraseña'] != '' && md5($un_usuario_array['contraseña'])!=$un_usuario->getPass()){
            $un_usuario_array['contraseña'] = md5($un_usuario_array['contraseña']);
        }
        else {
            $un_usuario_array['contraseña'] = $un_usuario->getPass();
        }
        $otro_usuario = new Usuario($un_usuario_array);
        echo Fachada::getInstancia()->modificarUsuario($otro_usuario);        
        break;
            
    case "traer_por_id":
        $id_usuario = cargarUnValor('id_usuario'); 
        $un_usuario = traerPorId($id_usuario);
        $array = $un_usuario->convertirArray();
        echo json_encode($array);
        break;    
   
   case "eliminar_por_id":
        $id_persona = cargarUnValor('id_persona');
        $borrado = Fachada::getInstancia()->eliminarUsuario($id_persona);
        if($borrado){
            echo "<strong style='color:green;'>El usuario ".$id_persona." fue exitosamente borrado!";
        }
        else{
            echo "<strong style='color:red;'>El usuario ".$id_persona." no se pudo borrar";
        }
        break;
    
    default:        
        break;
}


function cargarValores(){ 
    $paramsUsuario=array();
    if(isset($_POST['id_persona'])){
        $paramsUsuario['id_persona']=$_POST['id_persona']; 
    }
    $paramsUsuario['nombre']=$_POST['nombre'];
    $paramsUsuario['apellido']=$_POST['apellido'];
    $paramsUsuario['email']=$_POST['email'];
    $paramsUsuario['contraseña']=$_POST['pass'];
    return $paramsUsuario;
}

function cargarUnValor($variable){
    return $_POST[$variable];
}

function traerTodos(){
    return Fachada::getInstancia()->getUsuarios();
}

function crearListaParaPersonas($lista){
    $retorno = '<table class="table table-hover"><thead><tr><th>#</th><th>Nombre</th><th>E-mail</th><th>Acciones</th></tr></thead><tbody>';
    $numero = 0;    
    foreach ($lista as $c) 
    {        
        $retorno .= '<tr><td class="dato_mostrado_usuario">'.$c->getId().'</td><td class="dato_mostrado_usuario">'.$c->getNombre()." ".$c->getApellido().'</td><td class="dato_mostrado_usuario">'.$c->getMail().'</td><td><p><i class="btn_ver_usuario fa fa-pencil-square-o fa-2x"></i>&nbsp;<i class="btn_eliminar_usuario fa fa-ban fa-2x"></i></p></td></tr>';
    }
    return $retorno;
}

function traerPorId($id_usuario){
    $lista = traerTodos();
    foreach($lista as $un_usuario){
        if($un_usuario->getId()==$id_usuario){
            return $un_usuario;
        }
    }
    return null;
}

?>
