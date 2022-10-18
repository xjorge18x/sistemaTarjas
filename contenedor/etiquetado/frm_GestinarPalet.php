
<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new Cfunciones;

if (isset($_GET["codigoBarras"])) 
{
  $codigoBarras = $_GET["codigoBarras"]; 
}
else
{
  $codigoBarras='';
}
?>
<script type="text/javascript">
    $('#codigoBarrasP').keypress(function(e) {
    var keycode = (e.keyCode ? e.keyCode : e.which);
    if (keycode == '13') {
        Buscar(1);
        e.preventDefault();
        return false;
    }
});
document.getElementById("codigoBarrasP").focus();
</script>
<div class="main1">
<div class="widget">
      <div class="title">Gestionar Palet/Ruma</div>
<div class="chart">

<div class="container-fluid" id="mycontainer">

	<div class="row justify-content-md-center justify-content-center">

     <div class="form-group col-md-auto">
	      <div class="input-group mb-2">
            <div class="input-group-prepend">
            <div class="input-group-text"><i class="fas fa-scanner-keyboard"></i></div>
            </div>
            <input  type="text" class="form-control txtinput" placeholder="Ingresar Codigo de Barras" name="codigoBarrasP" id="codigoBarrasP" autocomplete="off" value="<?php echo $codigoBarras; ?>" style=" z-index:0;" >
            </div>
	  </div>
   
  </div>

</div>

<div class="container-fluid">

	<div id="divResultadoBusqueda">

    <?php
    if ($codigoBarras<>'') {

    $codigoBarras=$codigoBarras;
    include_once("tabla_PaletGestion.php");
    }

    ?>
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
