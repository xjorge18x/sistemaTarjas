

// Carga Modales
function cambiar_estilosV1(pagina){
	 cargarArchivo('contenedor-prow',pagina);
	}

function cambiar_estilosV2(Tipo,codigo){

	 // Codigo = typeof Codigo !== '' ? Codigo : 1;
	 
	 if (Tipo==1) {
	 		let CodGrupo = document.getElementById('id_Grupo').value;
	 		let CodigoRegisto
	 		if (CodGrupo!=0){
	 			CodigoRegisto = document.getElementById('CodRegistro').innerHTML
	 			CodigoGrupo = document.getElementById('id_Grupo').value
	 			CodigoOcupacion = document.getElementById('id_ocupacion').value
	 		}
	 		else{CodigoRegisto = ""}
	 		 cargarArchivo('contenedor-prow','contenedor/formularios/frm_ConsultarRegistrosSubGrupo.php?Codigo='+CodigoRegisto+'&Grupo='+CodigoGrupo+'&Ocupacion='+CodigoOcupacion);
	 }
	 else if (Tipo==2) {
	 		let CodGrupo = document.getElementById('id_Grupo').value;
	 		let CodigoRegisto
	 		if (CodGrupo!=0){
	 			CodigoRegisto = document.getElementById('CodRegistro').innerHTML
	 			CodigoGrupo = document.getElementById('id_Grupo').value
	 			CodigoOcupacion = document.getElementById('id_ocupacion').value
	 		}
	 		else{CodigoRegisto = ""}
	 		cargarArchivo('contenedor-prow','contenedor/formularios/frm_RegistrarSubGrupos2.php?Codigo='+CodigoRegisto+'&Grupo='+CodigoGrupo+'&Ocupacion='+CodigoOcupacion);
	
	 }
	}

function cambiar_estilosV3(pagina){
     document.getElementById("contenedor-prow").style.height = 700;
     document.getElementById("contenedor-prow").style.width = '95%';
     cargarArchivo('contenedor-prow',pagina);
    
}


function buscar_limpiarV2(tipo,cod_registro){
divResultado = document.getElementById('resultadoDetCajas'); 
divResultado.innerHTML = '';
document.getElementById("contenedor-prow").style.height = 0;
document.getElementById("contenedor-prow").style.width = 0;

}

function cambiar_estilos(Dbuscar,tipoBuscar){  
	 document.getElementById("contenedor-prow").style.height = 500;
	 cargarArchivo('contenedor-prow','cont/form_buscar_Campos.php?Dbuscar='+Dbuscar+'&tipoBuscar='+tipoBuscar);
	
}

function salir(){
		swal({
        title: "¿Cerrar Sesión?",
        text: "¡Se desconectara del Sistema!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Estoy Seguro!",
        cancelButtonText: "No, Tendo Dudas!",
        closeOnConfirm: false,
 		closeOnCancel: false,
        showLoaderOnConfirm: true,
        },
        function(isConfirm){
        if (isConfirm) {
        setTimeout(function(){
        	 window.location.assign("secure.php?logout")
        	 }, 100);
		} else {
        	
        swal("Usted Cancelo la operación!", "No se realizó ningún cambio", "error");
       
        }
        });
}
// Animación Menu

$(document).ready(function () {
	$("#sidebar").mCustomScrollbar({
		theme: "minimal"
	});

		$('#dismiss, .overlay').on('click', function () {
		$('#sidebar').removeClass('active');
		$('.overlay').removeClass('active');
	});
		$('#ocultarmenu, .overlay').on('click', function () {
		$('#sidebar').removeClass('active');
		$('.overlay').removeClass('active');
	});

	$('#sidebarCollapse').on('click', function () {
		$('#sidebar').addClass('active');
		$('.overlay').addClass('active');
		$('.collapse.in').toggleClass('in');
		$('a[aria-expanded=true]').attr('aria-expanded', 'false');
	});
});

//Menu User
$(".toggle").click(function () {

	$(this).toggleClass("ripple-out");

	$reveal = $(this).attr('data-reveal');
	$allRevealable = ".grid-items, .user-penal, .user-info";

	if ($($reveal).hasClass("fadeInUp")) {
		$($reveal).removeClass("fadeInUp")
			.fadeOut();

	} else {
		$($reveal).fadeIn().addClass("fadeInUp");

	}

	$($allRevealable)
		.not($reveal).removeClass("fadeInUp ripple-out").fadeOut();

});

$(window).click(function (e) {
	if ($(e.target)
		.closest('.more-trigger, .grid-trigger,  .user-penal, .grid-items, .menu-trigger, .hs-navigation, .hs-user, .user-info')
		.length) {

		return;
	}

	$(".user-penal, .grid-items, .user-info").fadeOut()
		.removeClass("fadeInUp");

});
//fin menu user

$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Actualiza el contenido del modal. Usaremos jQuery aquí, pero en su lugar podría usar una biblioteca de enlace de datos u otros métodos.
  var modal = $(this)
  modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body input').val(recipient)
})


// Funcion que se ejecuta cada vez que se pulsa una tecla en cualquier input
// Tiene que recibir el "event" (evento generado) y el siguiente id donde poner
// el foco. Si ese id es "submit" se envia el formulario
function saltar(e,id)
{
	// Obtenemos la tecla pulsada
	(e.keyCode)?k=e.keyCode:k=e.which;
 
	// Si la tecla pulsada es enter (codigo ascii 13)
	if(k==13)
	{
		// Si la variable id contiene "submit" enviamos el formulario
		if(id=="submit")
		{
			document.forms[0].submit();
		}else{
			// nos posicionamos en el siguiente input
			document.getElementById(id).focus();
		}
	}
}

/* Valida Solo numeros en campo imput */

function isNumberKey(evt)
        {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
 
         return true;
        }
/* Valida Solo numeros y punto  en campo imput  */        
function isNumberKeyPunto(evt)
        {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode < 46)
            return false;
 
         return true;
        }


function image(foto,codigoEmpleado)
{
	divResultado = document.getElementById('resultadoImg');
	var accion = 'ejecutar';
	ajax=nuevoAjax();
	ajax.open("POST", "contenedor/ejecutarForm/ejecutar_horasNolaborables.php",true);
	ajax.onreadystatechange=function() {
		
		if (ajax.readyState==4) {
			
			
			divResultado.innerHTML = ajax.responseText;		

		}
		}

		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("accion="+accion+"&foto="+foto+"&codigoEmpleado="+codigoEmpleado)
}

function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable1");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }

}

