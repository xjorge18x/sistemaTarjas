<?php 
include_once("verificar.php");
include("funciones.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href='img/icono.png' rel='icon' type='image/x-icon'/>
    <title>Sistema de Gestion De Tarjas</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="librerias/bootstrap-4.5.3/css/bootstrap.min.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="librerias/Scrollbar/jquery.mCustomScrollbar.min.css">
    <!-- Font Awesome JS -->
    <link rel="stylesheet" href="librerias/fontawesome/css/all.css">
    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="librerias/datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="librerias/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
    <!-- Alertify CSS -->
    <link rel="stylesheet" href="librerias/alertify/css/alertify.css">  
    <!-- toastrCSS -->
    <link rel="stylesheet" href="librerias/toastr/build/toastr.css">  
    <!-- Alertify theme default -->  
    <link rel="stylesheet" href="librerias/alertify/css/themes/default.min.css"/>  
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/style3.css">

    <script type="text/javascript" src="./charts/loader.js"></script>
    <!-- libreberias para los mensajes -->
    <link rel="stylesheet" type="text/css" href="librerias/sweetalert/sweetalert.css"> 
    <script src="librerias/sweetalert/sweetalert.min.js"></script>

    <!-- script -->
    <script src="js/javaScrip1.js"></script>
    <!-- jQuery  -->
    <script src="librerias/jquery/jquery-3.3.1.min.js"></script>
    <!-- Toastr  -->
    <script src="librerias/toastr/toastr.js"></script>
    <!-- Popper.JS -->
    <script src="librerias/popper/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="librerias/bootstrap-4.5.3/js/bootstrap.min.js"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="librerias/Scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- Plugins Alertify -->  
    <script src="librerias/alertify/alertify.js"></script>   

    <script src="librerias/code/highcharts.js"></script>
    <script src="librerias/code/modules/exporting.js"></script>
    <script src="librerias/code/modules/export-data.js"></script>
    <!-- Zebra Impresiones -->
    <script src="librerias/BrowserPrint/BrowserPrint-3.0.216.min.js"></script>

    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
/*=============================================
CONFIGURACIONES IMPRESORA ZEBRA
=============================================*/

var selected_device;
var devices = [];
function setup()
{
    //Get the default device from the application as a first step. Discovery takes longer to complete.
    BrowserPrint.getDefaultDevice("printer", function(device)
            {
                //Add device to list of devices and to html select element
                selected_device = device;
                devices.push(device);
                var html_select = document.getElementById("selected_device").value=device.name;
                
                //Discover any other devices available to the application
                // BrowserPrint.getLocalDevices(function(device_list){
                //     for(var i = 0; i < device_list.length; i++)
                //     {
                //         // //Add device to list of devices and to html select element
                //         // var device = device_list[i];
                //         // if(!selected_device || device.uid != selected_device.uid)
                //         // {
                //         //     devices.push(device);
                //         //     var option = document.createElement("option");
                //         //     option.text = device.name;
                //         //     option.value = device.uid;
                //         //     // html_select.add(option);
                //         // }
                //     }
                    
                // }, function(){alert("Error de conexión con impresora")},"printer");
                
            }, function(error){
                alert(error);
            })
}
function writeToSelectedPrinter(dataToWrite)
{
    selected_device.send(dataToWrite, undefined, errorCallback);

}
var errorCallback = function(errorMessage){
    alert("Error: " + errorMessage);    
}
window.onload = function(){
    lanzadera();
}

</script>
</head>

<body>
    
    <div class="wrapper">
        <!-- MENU  -->
        <?php include_once("menu.php");?>

        <div id="content">
        
        <!-- CABEZOTE  -->
        <?php include_once("cabezote.php");?>
       
        <!-- CONTENIDO  -->
        <div class="main-content">
        <input type="hidden" id="selected_device">
        <div id="contenido">
         
        </div><!-- aqui se cargan las paginas en forma dinamica-->
        </div>

        </div>


    </div>
     <div class="overlay"></div>

   

    <script src="js/javaScrip.js"></script>
    <script src="js/ajax.js"></script>
    <script type="text/javascript" src="js/javaScripEtiquetado.js"></script>
</body>

</html>
