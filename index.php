
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css/estilo-login.css">
	<link rel="icon" href="img/icono-negro.png">
	    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap.min.css">
	<script src="librerias/jquery/jquery-3.3.1.min.js"></script>
    <!-- libreberias para los mensajes -->
    <link rel="stylesheet" type="text/css" href="librerias/sweetalert/sweetalert.css"> 
    <script src="librerias/sweetalert/sweetalert.min.js"></script>
	<title>Sistema Gestion De Tarjas</title>
	<script language="javascript">

$(document).ready(function()
{
	$("#login_form").submit(function()
	{
		
		$("#msgbox").removeClass().addClass('messagebox').text('Validando datos...').fadeIn(1000);
	
		$.post("ajax_login.php",{ user_name:$('#login').val(),password:$('#password').val(),rand:Math.random() } ,function(data)
        {
		  if(data=='yes') 
		  {
		  	$("#msgbox").fadeTo(200,0.1,function()  
			{ 

			  $(this).html('Acceso Correcto...').addClass('messageboxok').fadeTo(900,1,
              function()
			  { 

				 document.location='secure.php';
			  });
			  
			});
		  }
		  else if (data=='no')
		  {
		  	$("#msgbox").fadeTo(200,0.1,function()
			{ 

			  $(this).html('Usuario o clave incorrectos!...').addClass('messageboxerror').fadeTo(900,1);
			});		
          }
          else if (data=='exp')
		  {
		  	$("#msgbox").fadeTo(200,0.1,function()
			{ 

			  $(this).html('Su contraseña expiro / debe cambiarla ...!<br> <div class="link"> <a href="#" data-toggle="modal" data-target="#exampleModal">Click Aqui..</a></div>').addClass('messageboxerror').fadeTo(900,1);
			});		
          }

          else
          {
            $("#msgbox").fadeTo(200,0.1,function()
            { 

              $(this).html('Fallo conexión con la base de datos!...').addClass('messageboxerror').fadeTo(900,1);
            });
          }
				
        });
 		return false; 
	});
	
	$("#password").blur(function()
	{
		$("#login_form").trigger('submit');
	});
});
</script>
</head>
<body>
<div class="wrapper fadeInDown">
  <div id="formContent">
	<section class="login-form">
	<form method="post" action="" id="login_form" name="login_form">
			<div class="box">
				<div class="img">
					<img src="img/logo.png" alt="user">
				</div>
					<div class="heading">
					<h4>Acesso</h4>
					
					</div>
					<div class="form-fields">
					<div class="input-box">
						<input type="text" id="login" name="login" placeholder="Ingrese Usuario" class="form-control" required="true"  autocomplete="off">
						<span><img src="img/usuario.png" alt=""></span>
					</div>
					<div class="input-box">
						<input type="password" id="password" name="password" placeholder="Contraseña" class="form-control" required="true" >
						<span><img src="img/bloquear.png" alt=""></span>
					</div>
					<div class="button-box">
						<button type="submit" type="submit" id="submit">Connectar</button>
						<!-- <a href="">Olvido Contraseña?</a> -->
					</div>
					
				</div>

				<div class="social-links">
					<!-- <p>Cambiar Contraseña</p> -->
					<div class="link-box">
						<span id="msgbox" style="display:none"></span>
					</div>
				</div>
			</div>

		</form>
	</section>
 </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cambiar Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form method="POST" name="EnviarDatos" id="EnviarDatos" onSubmit="Cambiar_Pass(); return false;">
          <div class="form-row">
          	<div class="form-group col-md-6 col-sm-6">
            <label for="login2" class="col-form-label">Usuario</label>
            <input type="text" class="form-control" id="login2" name="login2" value="" required>
        	</div>
        	<div class="form-group col-md-6 col-sm-6">
            <label for="pass_actual" class="col-form-label">Contraseña Actual</label>
            <input type="text" class="form-control" id="pass_actual" name="pass_actual" value="" required>
        	</div>
          </div>
           <div class="form-row">
          	<div class="form-group col-md-6 col-sm-6">
            <label for="pass_new" class="col-form-label">Contraseña Nueva</label>
            <input type="text" class="form-control"  id="pass_new" name="pass_new" value="" required>
        	</div>
        	<div class="form-group col-md-6 col-sm-6">
            <label for="pass_confirmar" class="col-form-label">Confirmar Contraseña</label>
            <input type="text" class="form-control" id="pass_confirmar" name="pass_confirmar" value="" required>
        	</div>
          </div>
       
      </div>
      <div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
 <input type="submit" name="operacion" value="Procesar" class="btn btn-primary" id="Enviar" onclick="" >
</form>
<div id="resultado2"></div>
      </div>
    </div>
  </div>
</div>
<script src="js/ajax.js"></script>
    <!-- Bootstrap JS -->
<script src="librerias/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>