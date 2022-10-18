<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new Cfunciones;
$CodPalet = $_GET["idPalet"];
$frm = $_GET["frm"];

if (isset($_GET["pagina"])) 
{
  $pagina = $_GET["pagina"];
  $tipoproc = $_GET["TipoProc"];
}
else
{ 
  $pagina=$pagina;
  $tipoproc = $tipoproc;
}

$ejeCodigo = $obj->consultar("Select IdCaja_Project from DetalleProject
where IdPalet_Generado='$CodPalet' and estado='1'");
$filas = sqlsrv_num_rows($ejeCodigo);

if ($frm==1) {
$onclick= "enviar_paginadorE('$pagina','$tipoproc');";
}
else
{
 $onclick= "Buscar(1);";
}

?>
<script type="text/javascript">
    $('#codigoBarras').keypress(function(e) {
    var keycode = (e.keyCode ? e.keyCode : e.which);
    if (keycode == '13') {
        enviar_CajasPaletCB();
        e.preventDefault();
        return false;
    }
});
document.getElementById("codigoBarras").focus();
</script>

 <!-- Modal Header -->
<div class="modal-header">
  <h4 class="modal-title">Registro de Cajas Palet <span style="font-weight: bold;">(<?php echo $CodPalet; ?>)</span></h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="<?php echo $onclick;?>" >
    <span aria-hidden="true" style="font-size: 2.5rem;">&times;</span>
</div>
        
    <!-- Modal body -->
    <div class="modal-body">
     
     <form action="" method="POST" name="registroCajas" id="registroCajas" onsubmit="">

    <div class="form-row">
      <div class="form-group col-7">
              <select id="idaccion" name="idaccion" class="form-control">
              <optgroup label="Acción Cjas">
              <OPTION value="0" >AGREGAR CAJA</OPTION>
               <OPTION value="1" id="eliminar">ELIMINAR CJA</OPTION>
             </optgroup>

             <optgroup label="Acción Palet">
              <OPTION value="7" >AGREGAR CAJAS DE PALET</OPTION>
             </optgroup>

              <?php if($tipoproc<>1){?>
                <optgroup label="Acción Ruma">
              <OPTION value="4" >AGREGAR RUMA</OPTION> 
                <OPTION value="6"  id="eliminarruma">ELIMINAR RUMA</OPTION>
              </optgroup>
              <?php }?>
              
              </select>
      </div>

       <div class="form-group col-5">
        <div id="divbtn">
          <input type="submit" class="form-control btn-dark" name="enviar" id="enviar" value="Cerrar <?php if($tipoproc==0){echo 'Palet';}else{ echo 'Ruma';}?>" 
         onclick="CerrarPalet(<?php echo $frm;?>,<?php echo $tipoproc;?>); return false">

        </div>
              
        </div>
    </div>

     <div class="form-group"> 
            <div class="input-group mb-2">
            <div class="input-group-prepend">
            <div class="input-group-text"><i class="fas fa-scanner-keyboard"></i></div>
            </div>
            <input type="text" class="form-control txtinput" placeholder="Ingresar Codigo de Barras" name="codigoBarras" id="codigoBarras" autocomplete="off">
            </div>
            <div class="alert alert-success" id="Exito" role="alert" style="display:none;text-align: center;" >Caja Registrada</div>
    </div>
     <input type="hidden" name="idPalet" id="idPalet" value="<?php echo $_GET["idPalet"];?>">
      <input id="CodUsuario" name="CodUsuario" type="hidden" value="<?php echo $_SESSION['u_codigo'];?>">
    </form>

    <div  id="resultadoDetCajas">

        <?php 
        if($filas<>0)
        {
    	 	 $idPalet = $_GET["idPalet"];
      	 include_once("../etiquetado/tabla_CajasRegistradas.php");
      	}		
      	?>

    </div>

    </div>

    <div class="modal-footer">

    </div>
