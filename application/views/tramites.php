  <title>Sistema de Gestión Notarial</title>
  <meta name="description" content="sistema de gestion notarial" />
  <meta name="keywords" content="sistema,gestion,notarial,documentos,juridicos" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine&amp;v1" />
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" />

</head>

<body>
  <div id="main">
    <div id="header">
      <div id="logo">
        <h1>simplestyle<a href="#">_7</a></h1>
        <div class="slogan">Sistema de Gesti&oacute;n Notarial</div>
      </div>
      <div id="menubar">
        <ul id="menu">
          <!-- put class="current" in the li tag for the selected page - to highlight which page you're on -->
          <li><a href="index.php">Inicio</a></li>
          <li><a href="clientes.php">Clientes</a></li>
          <li><a href="gestiones">Gestiones</a></li>
          <li class="current"><a href="tramites">Trámites</a></li>
          <li><a href="another_page_test.php">Another Page</a></li>
          <li><a href="contact_test.php">Contact Us</a></li>
        </ul>
      </div>
    </div>
    <div id="site_content">
      <div id="sidebar_container">
        <img class="paperclip" src="<?=APPPATH?>static/images/paperclip.png" alt="paperclip" />
        <div class="sidebar">
        <!-- insert your sidebar items here -->
        <h3>Latest News</h3>
        <h4>What's the News?</h4>
        <h5>1st July 2011</h5>
        <p>Put your latest news item here, or anything else you would like in the sidebar!<br /><a href="#">Read more</a></p>
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
        <h1>Clientes</h1>
        <button id="btn_agregar_cliente" type="button" class="btn btn-primary">Agregar</button><div id="retorno_borrado_cliente"></div>
        <div id="div_formulario_cliente">
            <h3>Datos del cliente</h3>
            <div class="form-group">
                <label for="txt_nombre_cliente">Nombre</label>
                <input type="text" class="form-control" id="txt_nombre_cliente" placeholder="Ingresar Nombre">                
            </div>
            <div class="form-group">
                <label for="txt_apellido_cliente">Apellido</label>
                <input enabled="false" type="text" class="form-control" id="txt_apellido_cliente" placeholder="Ingresar Apellido">                
            </div>
            <div class="form-group">                
                <label for="txt_ci_cliente">Cédula de Identidad</label><br />
                <input type="text" class="form-control" id="txt_ci_cliente" placeholder="Ingresar Céldula">    
                <button type="button" id="btn_agregar_form_subir_ci" class="btn btn-info">Agregar escaneo</button>                
            </div>  
            <!--div class="form-group" id="div_formulario_subir_ci"-->
            <form enctype="multipart/form-data" class="formulario_archivo" id="div_formulario_subir_ci">
                    <label for="exampleInputFile">Cédula</label>
                    <input type="file" class="archivo" id="input_file_cedula" name="input_file_cedula">
                    <p class="help-block retorno_del_file_agregar_elemento">Agregar cédula de identidad.</p>
                    <button type="button" class="subir_archivo btn btn-info btn-sm">Subir cédula</button> 
            </form>
            <div class="mostrarCI"></div>
            <!--/div-->
            <div class="form-group">
                <label for="txt_email_cliente">Email</label>                
                <input type="email" class="form-control" id="txt_email_cliente" placeholder="E-mail">
            </div>
            
            <div class="form-group">
                <label for="txt_telefono_cliente">Teléfono</label>
                <input type="text" class="form-control" id="txt_telefono_cliente" placeholder="Ingresar Teléfono">                
            </div>
            <div class="form-group">
                <label for="txt_direccion_cliente">Dirección</label>
                <input type="text" class="form-control" id="txt_direccion_cliente" placeholder="Ingresar Dirección">                
            </div>  
            <div class="button-group">
                <button type="button" class="btn btn-success" id="btn_guardar">Guardar <i class="fa fa-floppy-o"></i></button><div id="retorno_ajax"></div>
            </div>  
        </div>
        <div id="div_listado_cliente">            
        </div>
      </div>
    </div>
    <div id="footer">
      <p>Copyright &copy; simplestyle_7 | <a href="http://validator.w3.org/check?uri=referer">HTML5</a> | <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> | <a href="http://www.html5webtemplates.co.uk">design from HTML5webtemplates.co.uk</a></p>
    </div>
  </div>
</body>
</html>
