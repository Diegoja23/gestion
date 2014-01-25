
  <title>Sistema de Gestión Notarial</title>
  <meta name="description" content="sistema de gestion notarial" />
  <meta name="keywords" content="sistema,gestion,notarial,documentos,juridicos" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine&amp;v1" />
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" />  

<?php  
            
            $failLogin = false;
            
            if(isset($_POST['email']) && isset($_POST['contrasenia']))
            {  
                $Usuario = Fachada::getInstancia()->login($_POST['email'], $_POST['contrasenia']);
                
                if($Usuario)
                {    
                    $usrdata = array(
                                       'id_usuario' => $Usuario->getId(),
                                       'nombre'     => $Usuario->getNombre(),
                                       'apellido'   => $Usuario->getApellido(),
                                       'email'      => $Usuario->getMail(),
                                       'rol'        => $Usuario->getRol(),
                                       'login' => TRUE
                                   );
                    
                    $this->session->set_userdata($usrdata);   
                    
                    redirect('index', 'refresh');               
                }
                else
                    $failLogin = true;    
                             
            }
                      
?>  

<body>
  <div id="main">
    <div id="header">
      <div id="logo">
        <h1>GIRASOL</h1>
        <div class="slogan">Sistema de Gesti&oacute;n Notarial</div>
      </div>
    </div>
    <div id="site_content_login">
        
      <div id="sidebar_container_login">
          <h2 style="color:#555;letter-spacing:1px"><strong>Ingresar al sistema</strong></h2><br>
          <?php if($failLogin) echo "<p style='color:red'>email o contraseña inválidos</p>" ?>
        <form action="/gestion/login" method="post">
            Email: <input name ="email" class="form-control"><br>
            Contraseña: <input name ="contrasenia" type="password" class="form-control"><br><br>
            <input type="submit" value="Ingresar" class="btn btn-info">
        </form>
      </div>        

    </div>
    <div id="footer">
      <p>Copyright &copy; Girasol | <a href="http://validator.w3.org/check?uri=referer">HTML5</a> | <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> | <a href="http://www.html5webtemplates.co.uk">design from HTML5webtemplates.co.uk</a></p>
    </div>
  </div>
</body>
</html>
