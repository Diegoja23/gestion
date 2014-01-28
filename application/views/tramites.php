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
        <h1>GIRASOL</h1>
        <div class="slogan">Sistema de Gesti&oacute;n Notarial</div>
      </div>
      <div id="menubar">
        <ul id="menu">
          <!-- put class="current" in the li tag for the selected page - to highlight which page you're on -->
          <li><a href="index">Inicio</a></li>
          <li><a href="personas">Personas</a></li>
          <li><a href="gestiones">Gestiones</a></li>
          <li class="current"><a href="tramites">Trámites</a></li>
          <li><a href="plantillas">Plantillas</a></li>
          <!--li><a href="another_page_test.php">Another Page</a></li-->
          <li><a href="logout">Salir</a></li>
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
          <h3>Newsletter</h3>
          <p>If you would like to receive our newletter, please enter your email address and click 'Subscribe'.</p>
          <form method="post" action="#" id="subscribe">
            <p style="padding: 0 0 9px 0;"><input class="search" type="text" name="email_address" value="your email address" onclick="javascript: document.forms['subscribe'].email_address.value=''" /></p>
            <p><input class="subscribe" name="subscribe" type="submit" value="Subscribe" /></p>
          </form>
        </div>
        <img class="paperclip" src="<?=APPPATH?>static/images/paperclip.png" alt="paperclip" />
        <div class="sidebar">
          <h3>Latest Blog</h3>
          <h4>Website Goes Live</h4>
          <h5>1st July 2011</h5>
          <p>We have just launched our new website. Take a look around, we'd love to know what you think.....<br /><a href="#">read more</a></p>
        </div>
      </div>
      <div id="content">
        <!-- insert the page content here -->
        <h1>Trámites</h1>
        <!-- <button id="btn_agregar_tramite" class="btn btn-primary">Agregar nuevo <i class="fa fa-plus-circle"></i></button> -->
        <button id="btn_mostrar_lista_tramites" type="button" style="display: none;" class="btn btn-primary">Mostrar Lista <i class="fa fa-list"></i></button>        
        <button type="button" class="btn btn-success" id="btn_guardar_tramite">Guardar <i class="fa fa-floppy-o"></i></button><div id="retorno_ajax"></div><div id="retorno_borrado_tramite"></div>
        <div id="div_formulario_tramite">
            <h3>Datos del trámite perteneciente a Gestion <div style="display: inline-block" id="nombre_gestion_trammite"></div></h3>
            <div class="form-group">
                <label for="lbl_descripcion_tramite">Descripción</label>
                <input type="hidden" class="form-control" id="txt_id_tramite">                
                <input enabled="false" type="text" class="form-control" id="txt_descripcion_tramite" placeholder="Ingresar Descripción">                
            </div>            
            <div class="form-group float-left">
                <label for="lbl_tipo_tramite">Tipo de trámite</label>  <br />              
                <select class='form-control' id='combo_tipo_tramite'>
                    <option>No se cargaron las opciones</option>
                </select>
            </div> 
            <div class="button-group float-left" style="margin-top:30px;margin-left:20px;">
                <button id="btn_mostrar_dialog_plantilla" type="button" class="btn btn-primary btn-xs">Plantilla<i class="fa fa-list"></i></button>        
            </div>   
            <br /><br /><br /><br /><br />
            <div class="form-group fecha fecha-inicio">                
                <label for="lbl_fecha_inicio">Fecha de inicio</label><br />
                <input type="text" class="form-control datepicker" id="txt_fecha_inicio" placeholder="Fecha de inicio">    
                            
            </div>  
            <div class="form-group fecha fecha-fin">
                <label for="lbl_fecha_fin">Fecha de finalización</label><br />                
                <input type="text" class="form-control datepicker" id="txt_fecha_fin" placeholder="Fecha de finalizacion">
            </div>
            <br/><br/><br/><br/><br/>
            <div class="form-group" id="div_estado_transaccion">
                <label for="lbl_esado_tramite">Estado</label> <div style="display: inline-block;" id="tramite_estado"><span style='color:green'><strong>En curso</strong></span></div> <br/><br/>
                <button id="btn_finalizar_tramite" type="button" class="btn btn-primary btn-xs" value="1">Finalizar</button>
                </select>                
            </div><br/>
            <div class="button-group">
                <button type="button" class="btn btn-info" id="btn_agregar_adjunto">Agregar adjunto <i class="fa fa-upload"></i></button><div id="retorno_ajax"></div>
            </div>
            <form enctype="multipart/form-data" class="formulario_archivo_tramite" id="div_formulario_subir_tramite">
                    <br />
                    <label>Nombre del adjunto: </label>
                    <input type="text" class="form-control" id="txt_nombre_adjunto" name="txt_nombre_adjunto" placeholder="Nombre del adjunto"><br/><br/>   
                    <label for="input_file_adjunto">Adjunto</label>
                    <input type="file" class="archivo" id="input_file_adjunto" name="input_file_adjunto">
                    <p class="help-block retorno_del_file_agregar_elemento">Agregar adjunto.</p>
                    <button type="button" class="subir_archivo_tramite btn btn-info btn-sm">Subir adjunto <i class="fa fa-cloud-upload"></i></button> 
            </form>
            <div id="dialog_plantilla" title="Llene la plantilla" style="display:none;">
                    <p>This is the default dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.</p>
            </div>
            <div id="dialog_adjunto" title="Archivo adjunto" style="display:none;"></div>
            <br/><br/>
            <div id="div_no_hay_adjuntos_tramite">
                    <h3> - No hay adjuntos - </h3>
                </div>
            <div id="div_archivos_adjuntos">
                <h3>Lista de adjuntos</h3>
                <table class="table table-hover" >
                    <thead><tr><th>#</th><th>Nombre de ajunto</th><th>Acciones</th></tr></thead>
                    <tbody id="div_listado_adjuntos"></tbody>
                </table>
            </div>
        </div>
        
        <div id="div_listado_tramite">     - No hay adjuntos -       
        </div>
      </div>
    </div>
    <div id="footer">
      <p>Copyright &copy; Girasol | <a href="http://validator.w3.org/check?uri=referer">HTML5</a> | <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> | <a href="http://www.html5webtemplates.co.uk">design from HTML5webtemplates.co.uk</a></p>
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
</body>
</html>
