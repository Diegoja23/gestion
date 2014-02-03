  <title>Sistema de Gestión Notarial</title>
  <meta name="description" content="sistema de gestion notarial" />
  <meta name="keywords" content="sistema,gestion,notarial,documentos,juridicos" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine&amp;v1" />
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" />

</head>
<?php
     $el_usuario = $this->session->all_userdata();
?>
<body>
  <div id="main">
    <div id="header">
      <div id="logo">
          <img  src="<?=APPPATH?>static/images/encabezado-girasoles.gif" alt="cabezal" />
        <!--h1>GIRASOL</h1>
        <div class="slogan">Sistema de Gesti&oacute;n Notarial</div-->
      </div>
      <div id="menubar">
        <ul id="menu">
          <!-- put class="current" in the li tag for the selected page - to highlight which page you're on -->
          <li><a href="index">Inicio</a></li>
          <li ><a href="personas">Personas</a></li>
          <li><a href="gestiones">Gestiones</a></li>
          <li><a href="tramites">Trámites</a></li>
          <li><a href="plantillas">Plantillas</a></li>
          <!--li><a href="another_page_test.php">Another Page</a></li-->
          <li class="current"><a href="usuarios">Usuarios</a></li>
        </ul>
      </div>
    </div>
    <div id="site_content">
      <div id="sidebar_container">
        <img class="paperclip" src="<?=APPPATH?>static/images/paperclip.png" alt="paperclip" />
        <div class="sidebar">
            <!-- insert your sidebar items here -->
            <img style="margin-top: 10px;" class="float-right" src="<?=APPPATH?>static/images/admin.jpg" alt="admin picture" />
            <h3>Hola <?php echo $el_usuario['nombre'];?></h3> 
            <br/>
            <p style="padding-bottom: 0px;">
                Usuario: <em><?php echo $el_usuario['nombre'].' '.$el_usuario['apellido'];?></em>
            <br/>
                E-mail: <em><?php echo $el_usuario['email'];?></em>
            <br/>
                Rol: <em><?php if($el_usuario['rol']==1){echo 'Administrador';} else{if($el_usuario['rol']==2){echo 'Editor';}};?></em>
            </p>
            <a href="logout" class="btn btn-warning btn-xs float-right">Salir</a>
        </div>
        <img class="paperclip" src="<?=APPPATH?>static/images/paperclip.png" alt="paperclip" />
        <div class="sidebar">
          <img src="<?=APPPATH?>static/images/logo-girasol.gif" alt="girasol logo" /> 
          <!--h3>Girasol</h3-->
          <p>Este es un sistema que tiene como finalidad la gestión de documentos notariales. Con Girasol podrá crear plantillas para usar en sus trabajos, 
          llevar un registro detallado de sus clientes, los documentos (editables y escaneados) y mucho más</p>
          
        </div>
        <img class="paperclip" src="<?=APPPATH?>static/images/paperclip.png" alt="paperclip" />
        <div class="sidebar" style="background-image:url('<?=APPPATH?>static/images/gestion-documental.jpg');height:215px;widht:265px">
          
        </div>
      </div>
      <div id="content">
        <!-- insert the page content here -->
        <h1>Usuarios administradores</h1>
        <button id="btn_agregar_usuario" type="button" class="btn btn-primary">Agregar usuario <i class="fa fa-plus-circle"></i></button>
        <button id="btn_mostrar_lista_usuarios" type="button" style="display: none;" class="btn btn-primary">Mostrar Lista <i class="fa fa-list"></i></button>        
        <div id="retorno_borrado_usuario"></div>       

        
        <div id="div_formulario_usuario">
            <h3>Datos del usuario</h3>           
            <div class="form-group">
                <label for="txt_nombre_usuario">Nombre</label>
                <input type="text" class="form-control" id="txt_nombre_usuario" placeholder="Ingresar Nombre">                
            </div>
            <div class="form-group">
                <label for="txt_apellido_usuario">Apellido</label>
                <input enabled="false" type="text" class="form-control" id="txt_apellido_usuario" placeholder="Ingresar Apellido">                
            </div>
             <div class="form-group">
                <label for="txt_email_usuario">Email</label>                
                <input type="email" class="form-control" id="txt_email_usuario" placeholder="E-mail">
            </div>
            
            <div class="form-group">
                <label for="txt_pass_usuario">Password</label>                
                <input type="password" class="form-control" id="txt_pass_usuario" placeholder="●●●●●●●●●●">
            </div>  
            <div class="form-group">
                <label for="txt_pass_usuario">Reperir Password</label>                
                <input type="password" class="form-control" id="txt_pass_usuario_2" placeholder="●●●●●●●●●●">
            </div>              
            <br/>
            <div class="button-group">
                <button type="button" class="btn btn-danger" id="btn_guardar_usuario">Guardar <i class="fa fa-floppy-o"></i></button>
            </div> 
        </div>
        <br/>
        
        <div id="div_listado_usuarios">            
        </div>
      </div>
    </div>
    <div id="footer">
      <p>Copyright &copy; Girasol | Proyecto Integrador | Fernando Marichal - Yohana Parodi</p>
    </div>
  </div>
</body>
</html>
