
  <title>Sistema de Gestión Notarial</title>
  <meta name="description" content="sistema de gestion notarial" />
  <meta name="keywords" content="sistema,gestion,notarial,documentos,juridicos" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine&amp;v1" />
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" />  

</head>
<?php
     //var_dump($this->session->userdata("id_usuario"));  
     //var_dump($this->session->all_userdata());   
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
          <li class="current" ><a href="index">Inicio</a></li>
          <li><a href="personas">Personas</a></li>
          <li><a href="gestiones">Gestiones</a></li>
          <li><a href="tramites">Trámites</a></li>
          <li><a href="plantillas">Plantillas</a></li>
          <!--li><a href="another_page_test.php">Another Page</a></li-->
          <li><a href="usuarios">Usuarios</a></li>
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
        <div id="cabecera">  
            <div class="form-group float-left">
                <label for="lbl_seleccionar_elemento_busqueda">Buscar por:</label>  <br />              
                <select class='form-control' id='combo_elemento_busqueda'>
                    <option value="1">Personas</option>
                    <option value="2">Gestiones</option>
                    <option value="3">Trámites</option>
                </select>
            </div>
            <div class="form-group float-left">                
                <input enabled="false" type="text" class="form-control" id="txt_campo_busqueda" placeholder="Ingresar su búsqueda">                
            </div>
            <div class="button-group float-left">
                <button type="button" class="btn btn-primary" id="btn_buscar_inicio">Buscar <i class="fa fa-search"></i></button>
            </div> 
        </div>
        <div id="resultado_busqueda"></div>       
        
      </div>
    </div>
    <div id="footer">
      <p>Copyright &copy; Girasol | Proyecto Integrador | Fernando Marichal - Yohana Parodi</p>
    </div>
  </div>
</body>
</html>
