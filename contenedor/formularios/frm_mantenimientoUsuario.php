<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new Cfunciones;
$codigo_usuario=$_SESSION['u_codigo'];
$query="select n.nombrePerfil,c.NombreCargo,u.login_user, concat(p.APEPATempleado,' ',p.APEMATempleado,' ',p.NombresEmpleado)as name_user 
from usuario_sistema u 
inner join persona p on (u.id_persona=p.codigoEmpleado)
inner join cargo c on (c.codigoCargo=p.codigoCargo)
inner join PerfilUsuario n on(n.codigoPerfil=u.cargo_perfil)
where u.id_usuario='$codigo_usuario'";
$ejecutar=$obj->consultar($query);
$row1 = sqlsrv_fetch_array($ejecutar,SQLSRV_FETCH_ASSOC);
?>
<div class="title">
Usuario
</div>
<div class="main1">
<div class="widget">
<div class="title">Mantenimiento de Usuario</div>

<div class="chart">
<div class="container-fluid" id="mycontainer">
      
        <form action="" id="EnviarDatos" name="EnviarDatos" method="POST" onSubmit="cambiarPass(); return false;" enctype="multipart/form-data">
        <div class="form-row justify-content-center">
          <div class="col-md-12 col-sm-12 avatar1">
            
            <img src=" <?php echo trim($_SESSION['u_foto']);?>" alt=""><br><br>
            <h2><?php echo trim($_SESSION['u_nombre']);?></h2>
            <h3>
            <small class="text-muted"><?php echo $row1['NombreCargo']; ?></small>
            </h3>
            <h5>
            <small class="text-muted">(<?php echo $row1['nombrePerfil']; ?>)</small>
            </h5>
    
          </div>
        </div>

        <div class="form-row">
        
        </div>
        <div class="form-row">
        <div class="form-group col-md-3 col-sm-4">
        <label for="pass_actual">Contraseña Actual</label>
        <input type="hidden" name="cod_usuario" id="cod_usuario" value="<?php echo $codigo_usuario; ?>">
        <input type="text" class="form-control" id="pass_actual" name="pass_actual" value="" required>
        </div>
         <div class="form-group col-md-3 col-sm-4">
        <label for="pass_new">Contraseña Nueva</label>
        <input type="text" class="form-control" id="pass_new" name="pass_new" value="" required>
        </div>
         <div class="form-group col-md-3 col-sm-4">
        <label for="pass_confirmar">Confirmar Contraseña</label>
        <input type="text" class="form-control" id="pass_confirmar" name="pass_confirmar" value="" required>
        </div>
         <div class="form-group col-md-3 ">
          <label for="pass_confirmar"> &nbsp;</label>
                <input type="submit" name="operacion" value="Procesar" class="form-control btn btn-primary" id="Enviar" onclick="" >
          </div>
        </div>
          
          
      
        </form>
        


            <div id="resultado">
        </div>  		
</div> 
</div>
</div>
</div>




<!-- Modal -->

<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="contenedor-prow">
     
    </div>
  </div>
</div>

<!--       <div class="row">
      
        
      <div class="form-group mb-2">
      <label for="staticEmail2" class="sr-only">Buscar Usuario</label>
      <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="Buscar Usuario">
      </div>
      <div class="form-group mx-sm-3 mb-2">
      <input type="text" class="form-control" id="Buscar">
      </div>
      <button type="submit" class="btn btn-primary mb-2" onclick="cambiar_estilosV1('contenedor/formularios/frm_nuevoUsuario.php')" data-toggle="modal" data-target="#Modal">Buscar</button>

      </div>
 -->
