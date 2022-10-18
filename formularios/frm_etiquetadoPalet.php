<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new Cfunciones;
$query="Select CONVERT (char(5), Fecha, 108) as HoraReg,Estado,Capacidad_Max from Pallet_Generado
where CONVERT (char(10), fecha, 120) >=(select CONVERT (char(10), SYSDATEtime(), 120))
";
$smtv=$obj->consultar($query);
$numeroFilas = sqlsrv_num_rows($smtv);
?>


<div class="main1">
<div class="widget">
      <div class="title">Registro de Palet</div>
<div class="chart">

<div class="container-fluid" id="mycontainer">

	<form action="" method="POST" id="R_Palets" class="form"  name="R_Palets" onSubmit="RegistrarPalets(); return false;" >
	  <div class="form-row">
	  	<div class="form-group col-6">
	      <label for="CapacidadPaletMax">Nº Max Cajas</label>
	      <input type="number" class="form-control" id="CapacidadPaletMax" name="CapacidadPaletMax" min="10" max="50">
	    </div>
		 <div class="form-group col-6">
	      <label for="BtnEnviar">&nbsp;</label>
	      <input type="submit" class="form-control btn btn-secondary" id="BtnEnviar" value="Enviar">

	    </div>

	  </div>
	  <input id="CodUsuario" name="CodUsuario" type="hidden" value="<?php echo $_SESSION['u_codigo'];?>">
	</form>
</div>


<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-12 col-sm-12 movil">              
        <div id="divResultado">
        <?php 
			if ($numeroFilas<>0)
				{
      	 		include_once("../formularios/tabla_PaletGenerados.php");
      	 		}
      	 ?>
        <!-- Carga lista empleados Turno -->
        </div>
        </div>  
    </div>
</div>  <!-- cierre div container tabla-->  

</div>  <!-- cierre div chaaart -->                                     
</div>  <!-- cierre div widget -->      
</div>  <!-- cierre div main --> 

  <div class="modal" id="myModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content" id="contenedor-prow">
      
       
        
      </div>
    </div>
  </div>

