<?php 
include_once("verificar.php");
?>
<script type="text/javascript">
  //DashBoard();
</script>
  <div class="main1">
    <div class="widget">

       <?php if(($_SESSION['u_perfil']==1)){?>
      <div class="title">Registro de Trabajadores Por Linea</div>
            
      <div class="chart">

        <div class="row flex-wrap">

          <div class="container-fluid" id="mycontainer">

              <div class="row">
 
             
                <div class="col-md-12 col-sm-12">
                  <?php include_once("graficos/graficoCircular1.php");?>
                </div>
     <!--            <div class="form-group col-md-6 col-sm-12">
                  <?php include_once("graficos/graficoBarras1.php");?>

                </div> -->
               
              </div>
          </div>
          
        </div>

      </div>
 <?php }else{ ?>
<div class="title">Acceso Rápido</div>
<div class="chart">

<div class="container-fluid" id="mycontainer">

  <div class="row m-2 tabla1">
     <a class="small-box-footer" href="javascript:cargarArchivo('contenido','contenedor/etiquetado/frm_GenerarPalet.php')">
      <div class="text-white cuadro1">
       
        <div class="inner">
                      <!-- <h3>150</h3> -->
                      <p>Registro Cajas</p>
        </div>
          <div class="icon">
          <i class="far fa-pallet-alt"></i>
         </div>
         
      </div>
</a>
  
  </div>

   <!-- <div id="Dashboard"></div> -->
  </div>
</div>
  <?php }?>
    </div>
    </div>