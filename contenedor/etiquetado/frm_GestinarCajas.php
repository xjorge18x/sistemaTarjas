
<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new Cfunciones;
?>
<script type="text/javascript">
    $('#codigoBarrasC').keypress(function(e) {
    var keycode = (e.keyCode ? e.keyCode : e.which);
    if (keycode == '13') {
        Buscar(2);
        e.preventDefault();
        return false;
    }
});
document.getElementById("codigoBarrasC").focus();
</script>
<div class="main1">
<div class="widget">
      <div class="title">Gestionar Cajas</div>
<div class="chart">

<div class="container-fluid" id="mycontainer">

	<div class="row justify-content-md-center justify-content-center">

     <div class="form-group col-md-auto">
	      <div class="input-group mb-2">
            <div class="input-group-prepend">
            <div class="input-group-text"><i class="fas fa-scanner-keyboard"></i></div>
            </div>
            <input type="number" class="form-control txtinput" placeholder="Ingresar Codigo de Barras" name="codigoBarrasC" id="codigoBarrasC" autocomplete="off" style=" z-index:0;">
            </div>
	  </div>
   
  </div>

</div>

<div class="container-fluid">

	<div id="divResultadoBusqueda">
	</div>

</div>

</div>
</div>
</div>


<!-- cierre div Modal --> 
  <div class="modal" id="myModal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
      <div class="modal-content" id="contenedor-prow">
      
       
        
      </div>
    </div>
  </div>
