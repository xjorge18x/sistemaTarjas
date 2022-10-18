<?php
require_once("../../cont/CFunciones.php");
include_once("../../verificar.php");
$obj = new Cfunciones;
?>


<div class="main1">
<div class="widget">
      <div class="title" id="registro" >Registro de Palet</div>
<div class="chart">

<div class="container-fluid" id="mycontainer">

	<form action="" method="POST" id="R_Palets" class="form"  name="R_Palets" onSubmit="RegistrarPalets(0,0); return false;" >
	  <div class="form-row">

		  <div class="form-group col-7">
	              <select id="TipoProc" name="TipoProc" class="form-control" onchange="cargarTablaPR('divResultado');" >
	              <OPTION value="0" >AGREGAR PALET</OPTION>
	              <OPTION value="1" >AGREGAR RUMA</OPTION>
	              </select>
	      </div>

	    <div class="form-group col-5">
	      <input type="text" class="form-control" id="CapacidadPaletMax" name="NomPalet" placeholder="Nombre Palet">
	    </div>
	  <input id="CapacidadPaletMax" name="CapacidadPaletMax" type="hidden" value="250">
	  	<!-- <div class="form-group col-4">
	      <input type="number" class="form-control" id="CapacidadPaletMax" name="CapacidadPaletMax" min="10">
	    </div> -->
	</div>	
	<div class="form-row">	
		<div class="form-group col-12">
	      <input type="submit" class="form-control btn btn-secondary" id="BtnEnviar" value="Enviar">
	 </div>

	 </div>
	  <input id="CodUsuario" name="CodUsuario" type="hidden" value="<?php echo $_SESSION['u_codigo'];?>">


	</form>
</div>


<div class="container-fluid">
          
        <div id="divResultado">
        <?php 
				$pagina=1;
				$tipoproc =	0;
      	 		include_once("../etiquetado/tabla_PaletGenerados.php");
      	 ?>
        </div>

</div>  <!-- cierre div container tabla-->  

</div>  <!-- cierre div chaaart -->                                     
</div>  <!-- cierre div widget -->      
</div>  <!-- cierre div main --> 


<!-- cierre div Modal --> 
  <div class="modal" id="myModal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
      <div class="modal-content" id="contenedor-prow">
      
       
        
      </div>
    </div>
  </div>


