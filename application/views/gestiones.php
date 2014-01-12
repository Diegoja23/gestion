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
        <h1>GIRASOL</h1>
        <div class="slogan">Sistema de Gesti&oacute;n Notarial</div>
      </div>
      <div id="menubar">
        <ul id="menu">
          <!-- put class="current" in the li tag for the selected page - to highlight which page you're on -->
          <li><a href="index">Inicio</a></li>
          <li><a href="clientes">Clientes</a></li>
          <li class="current"><a href="gestiones">Gestiones</a></li>
          <li><a href="tramites">Trámites</a></li>
          <li><a href="plantillas">Plantillas</a></li>
          <!--li><a href="another_page_test.php">Another Page</a></li-->
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
        <h1>Gestiones</h1>
        <button id="btn_agregar_cliente" type="button" class="btn btn-primary">Agregar</button>
        <div id="div_formulario_cliente">
            <h3>Datos de gestión</h3>
            <div class="form-group">
                <label for="txt_nombre_cliente">Descripción</label>
                <input type="text" class="form-control" id="txt_nombre_cliente" placeholder="Ingresar Nombre">                
            </div>
            <div class="form-group">
                <label for="txt_apellido_cliente">Tipo de Gestión</label>
                <input enabled="false" type="text" class="form-control" id="txt_apellido_cliente" placeholder="Ingresar Apellido">                
            </div>
            <div class="form-group fecha">                
                <label for="lbl_fecha_inicio">Fecha de inicio</label><br />
                <input type="text" class="form-control datepicker" id="txt_fecha_inicio" placeholder="Fecha de inicio">    
                            
            </div>  
            <div class="form-group fecha">
                <label for="lbl_fecha_fin">Fecha de finalización</label><br/>            
                <input type="text" class="form-control datepicker" id="txt_fecha_fin" placeholder="Fecha de finalizacion">
            </div>
            <br/><br/><br/><br/>
            <div class="form-group">
                <label for="txt_telefono_cliente">Estado</label>
                <input type="text" class="form-control" id="txt_telefono_cliente" placeholder="Ingresar Teléfono">                
            </div>
            <div class="form-group">
                <label for="txt_direccion_cliente">Clientes</label>
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
      <p>Copyright &copy; Girasol | <a href="http://validator.w3.org/check?uri=referer">HTML5</a> | <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> | <a href="http://www.html5webtemplates.co.uk">design from HTML5webtemplates.co.uk</a></p>
    </div>
  </div>
</body>
</html>
