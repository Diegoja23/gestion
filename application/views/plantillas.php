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
          <li><a href="personas">Personas</a></li>
          <li><a href="gestiones">Gestiones</a></li>
          <li><a href="tramites">Trámites</a></li>
          <li class="current"><a href="plantillas">Plantillas</a></li>
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
          <h3>Girasol</h3>
          <p>Este es un sistema que tiene como finalidad la gestión de documentos notariales. Con Girasol podrá crear plantillas para usar en sus trabajos, 
          llevar un registro detallado de sus clientes, los documentos (editables y escaneados) y mucho más</p>
          
        </div>
        <img class="paperclip" src="<?=APPPATH?>static/images/paperclip.png" alt="paperclip" />
        <div class="sidebar" style="background-image:url('<?=APPPATH?>static/images/gestion-documental.jpg');height:215px;widht:265px">
          
        </div>
      </div>
      <div id="content">
        <!-- insert the page content here -->
        <h1>Tipos de Trámite y Plantillas</h1>
        <button id="btn_agregar_plantilla" class="btn btn-primary">Agregar nuevo <i class="fa fa-plus-circle"></i></button>
        <button id="btn_mostrar_lista_plantillas" type="button" style="display: none;" class="btn btn-primary">Mostrar Lista <i class="fa fa-list"></i></button>
        <div id="retorno_ajax_plantillas"></div>        
        <div id="div_formulario_plantilla">
            <h3>Datos de la plantilla</h3>
            <div class="form-group">
                <label for="lbl_descripcion_plantilla">Nombre del nuevo tipo de trámite</label>
                <input enabled="false" type="text" class="form-control" id="txt_descripcion_plantilla" placeholder="Nombre tipo trámite">                
            </div>            
            <div class="form-group">
                <label for="lbl_tipo_gestion_pl">Tipo de gestion</label>  <br />              
                <select class='form-control' id='combo_tipo_gestion_pl'>
                    <option>No se cargaron las opcione</option>
                </select>
            </div> 
            <div class="button-group" style="margin-top:30px;margin-left:20px;">
                <button id="btn_mostrar_dialog_plantilla_tt" type="button" class="btn btn-primary btn-xs">Plantilla <i class="fa fa-list"></i></button>        
            </div>   

            <div id="dialog_plantilla_tt" title="Llene la plantilla" style="display:none;">
                    <textarea id="editorTT" name="editorTT">Agregue el texto de la plantilla aquí.</textarea><script type="text/javascript">CKEDITOR.replace( "editorTT" );</script>
            </div>
            <br /><br />
            <button type="button" class="btn btn-danger float-right" id="btn_guardar_plantilla">Guardar <i class="fa fa-floppy-o"></i></button><div id="retorno_borrado_plantilla"></div>
        </div>
        <div id="div_listado_plantillas">     - No hay plantillas -       
        </div>
      </div>
    </div>
    <div id="footer">
      <p>Copyright &copy; Girasol | Proyecto Integrador | Fernando Marichal - Yohana Parodi</p>
    </div>
  </div>
    <div id="div_parametros" style="display:none;">
        <span id="span_id_gestion" style="display:none;">
            <?php echo 1//$_POST['id_gestion']; ?>            
        </span>
        <span id="span_id_tipo_gestion" style="display:none;">
            <?php echo 1//$_POST['id_tipos_gestion']; ?>            
        </span
        <span id="span_id_tramite" style="display:none;">
                        
        </span>
    </div>
          <form method="post" action="convertir_pdf" target="_blank" id="form_plantilla">
            <input type="hidden" id="plantilla_value" name="plantilla_value">     
            <input type="hidden" id="plantilla_nombre" name="plantilla_nombre">        
          </form>        
</body>
</html>
