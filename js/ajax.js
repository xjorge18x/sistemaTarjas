// function sendToQuickPrinter(){
//     var text = "test printer<br><big>Big title<br><cut>";
//     var textEncoded = encodeURI(text);
//     window.location.href="quickprinter://"+textEncoded;
// }

// //if you are using latest version of chrome browser I recommend to use:
// function sendToQuickPrinterChrome(){
//     var text = "test printer<br><big>Big title<br><cut>";
//     var textEncoded = encodeURI(text);
//     window.location.href="intent://"+textEncoded+"#Intent;scheme=quickprinter;package=pe.diegoveloper.printerserverapp;end;";
    
// }


 // function printExternal(url) { 
 // 	var printWindow = window.open( url, 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0'); 
 // 	printWindow.addEventListener('load', function(){ printWindow.print(); }, true); } 


// Funcion para cargar paginas dinamicas
function nuevoAjax(){
	var xmlhttp=false;
 	try {
 		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
 	} catch (e) {
 		try {
 			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
 		} catch (E) {
 			xmlhttp = false;
 		}
  	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
 		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function cargarArchivo(id,url){
	var contenedor;
	contenedor = document.getElementById(id);
	  $(contenedor).load(url); 
}
// Carga Contenido Pagina Principal
function cargar(){
    cargarArchivo('contenido','principal.php');
}
function lanzadera(){
    cargar();
}

// Llenar Select de Ocupacion

function cargarSelectv1(tipo,dato,divcambio){
	divResultado = document.getElementById(divcambio);
	ajax=nuevoAjax();
	ajax.open("POST", "contenedor/formularios/autollenado.php",true);
	if(dato=='Full'){
		$("#enviar").css("display","none")
		$("#idTipoProceso").prop("disabled", false);
	}
	else{
		$("#enviar").css("display","block")
		$("#idTipoProceso").prop("disabled", true);

	}
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
		
		divResultado.innerHTML = ajax.responseText;
		if (tipo==8 || tipo==6) {
	
			var SwcountPro= document.getElementById("swProCount").innerHTML;
			if (SwcountPro>0) {
				$("#CabProducto").addClass("form-group col-md-3 col-sm-3")
				$("#CabProducto").css("display","block")
				cargarSelectv1(11,dato,'divProducto')
			}else{

				$("#CabProducto").css("display","none")
				$("#CabProducto").removeClass("form-group col-md-3 col-sm-3")
				$("#divProducto").empty();
			}

		}
		
		
		}
		}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("dato="+dato+"&tipo="+tipo)
}

// Llenar Select de Manual

function cargarSelectv1M(tipo,dato,divcambio){
	divResultado = document.getElementById(divcambio);
	ajax=nuevoAjax();
	ajax.open("POST", "contenedor/formularios/autollenado.php",true);
	if(dato=='Full'){
		$("#enviar").css("display","none")
		$("#idTipoProceso").prop("disabled", false);
	}
	else{
		$("#enviar").css("display","block")
		$("#idTipoProceso").prop("disabled", true);

	}


	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			
		divResultado.innerHTML = ajax.responseText;
			if (tipo==8) 
			{
				var tarifa = document.getElementById("tarifa").innerHTML;
				if (tarifa==1) {
					$("#id_cantidad").prop("disabled", true);
				}
				else{
					$("#id_cantidad").prop("disabled", false);
				}
			}

		
		}
		}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("dato="+dato+"&tipo="+tipo)
}

//carga la asistencia segun registro

function cargarAsistencia(divcambio2){
	divResultado2 = document.getElementById(divcambio2);
	idTipoTurno = document.getElementById("idTipoProceso").value;
	dato = document.getElementById("id_Grupo").value;
	ajax=nuevoAjax();
	ajax.open("POST", "contenedor/formularios/tabla_asistenciaDiaria.php",true);
	ajax.onreadystatechange=function() {
		
		if (ajax.readyState==4) {
			
		divResultado2.innerHTML = ajax.responseText;
		$("#codigoBarras").prop("disabled", false);
		if(idTipoTurno==1){
		$("#idaccion").prop("disabled", false);
		document.getElementById('modificar').innerHTML = 'Registrar Ingreso de Personal';
		}
		else{
		document.getElementById("idaccion").value='0';
		document.getElementById('modificar').innerHTML = 'Registrar Salida de Personal';
		$("#idaccion").prop("disabled", true);
		}
		$("#idTipoProceso").prop("disabled", false);
		document.getElementById("codigoBarras").focus();
		}
		}
		
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("dato="+dato+"&idTipoTurno="+idTipoTurno+"&pagina=1")


}

// Paginar Tabla con limite
function cargarAsistenciaConLimitet(NumeroFilas,divcambio2,OrdenarTabla,tipo){
	divResultado2 = document.getElementById(divcambio2);
	idTipoTurno = document.getElementById("idTipoProceso").value;
	dato = document.getElementById("id_Grupo").value;
	ajax=nuevoAjax();

	if (tipo==1) {
		ajax.open("POST", "contenedor/formularios/tabla_asistenciaDiaria.php",true);
	}
	else if (tipo==2) {
		ajax.open("POST", "contenedor/formularios/tabla_horasnolaborables.php",true);
	}
	
	ajax.onreadystatechange=function() {
		
		if (ajax.readyState==4) {
			
		divResultado2.innerHTML = ajax.responseText;
		$("#codigoBarras").prop("disabled", false);
		if(idTipoTurno==1){
		$("#idaccion").prop("disabled", false);
		}
		else{
		document.getElementById("idaccion").value='0';
		$("#idaccion").prop("disabled", true);
		}
		$("#idTipoProceso").prop("disabled", false);
		
		}
		}
		
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("dato="+dato+"&idTipoTurno="+idTipoTurno+"&NumeroFilas="+NumeroFilas+"&pagina=1"+"&OrdenarTabla="+OrdenarTabla)
}

// Ordenar Tabla asc desc
function ordenar(OrdenarTabla,divcambio2,tipo,NumeroFilas){
	divResultado2 = document.getElementById(divcambio2);
	dato = document.getElementById("id_Grupo").value;
	idTipoTurno = document.getElementById("idTipoProceso").value;
	ajax=nuevoAjax();
	if (tipo==1) {
		ajax.open("POST", "contenedor/formularios/tabla_horasnolaborables.php",true);
	}
	else if(tipo==2){
		ajax.open("POST", "contenedor/formularios/tabla_asistenciaDiaria.php",true);
	}
	
	ajax.onreadystatechange=function() {
		
		if (ajax.readyState==4) {
			
		divResultado2.innerHTML = ajax.responseText;
		
		}
		}
		
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("dato="+dato+"&OrdenarTabla="+OrdenarTabla+"&pagina=1"+"&idTipoTurno="+idTipoTurno+"&NumeroFilas="+NumeroFilas)

}


//carga la asistencia personal no laborable
function cargarHorasnolaborables(divcambio2){
	divResultado2 =document.getElementById(divcambio2);
	dato = document.getElementById("id_Grupo").value;
	TipoSalida = document.getElementById("idTipoSalida").value;
	ajax = nuevoAjax();
	ajax.open("POST","contenedor/formularios/tabla_horasnolaborables.php",true);
	ajax.onreadystatechange = function ()
	{
		if (ajax.readyState==4)
		{
			divResultado2.innerHTML = ajax.responseText;
			$("#codigoBarras").prop("disabled", false);
			$("#idTipoSalida").prop("disabled", false);
			$("#enviar").prop("disabled", false);
			$("#idTipoProceso").prop("disabled", false);
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("dato="+dato+"&TipoSalida="+TipoSalida+"&pagina=1")


}

function enviar_asistencia(codigo, tipoturno, codGrupo, asistencia,pagina,NumeroFilas ) {
    divResultado = document.getElementById('resultadoDet');
	var accion = 'ejecutar_asistencia';
	hora = document.getElementById("horaid").value;
	ajax=nuevoAjax();
	ajax.open("POST", "contenedor/ejecutarForm/ejecutar_tareas.php",true);
	ajax.onreadystatechange=function() {
		
		if (ajax.readyState==4) {
			
			
			divResultado.innerHTML = ajax.responseText;		
			var sw = document.getElementById("sw").innerHTML;
			if(sw==3){
			swal("! Verificar !", "Debe definir hora de marcación", "error");	
			}
			else if (sw==2){
			swal("Ocurrió un error en el registro!", "Llamar al área de sistemas!", "error");
			}
			else if(sw==4){
			swal("! Verificar !", "No se Definio Salida", "error");	
			}
			else if(sw==5){
			swal("! Verificar !", "Debe Cerrar Hora no Laborable", "error");	
			}
			else if(sw==6){
			swal("! Verificar !", "La Hora debe Ser mayor a Hora de Asistencia", "error");	
			}
			else if(sw==7){
			swal("! Verificar !", "No Puede Realizar Esta Operación", "error");	
			}
					
				
		}
		}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("codigo="+codigo+"&hora="+hora+"&tipoturno="+tipoturno+"&codGrupo="+codGrupo+"&accion="+accion+"&asistencia="+asistencia+"&pagina="+pagina+"&NumeroFilas="+NumeroFilas)
	

}  

function enviar_asitenciasCB(){ // esta funcion enviara la asistencias, pero utilizando el lector de barras
    divResultado = document.getElementById('resultadoDet');
    codigoBarra = document.getElementById("codigoBarras").value;
    codGrupo = document.getElementById("id_Grupo").value;
    hora = document.getElementById("horaid").value;
    idTipoTurno = document.getElementById("idTipoProceso").value;
    idaccion = document.getElementById("idaccion").value;
    idOcupacion = document.getElementById("id_ocupacion").value;
  	NumeroPaginaId = document.getElementById("NumeroPaginaId").innerHTML;
  	NumeroFilas = document.getElementById("NumeroFilas").innerHTML;

    if (idaccion==0){ // sin accion adicional
    var accion = 'ejecutar_asistenciaCB'; // solo registra la asistencia, no importa otra accion.

    }
    else{

    var accion = 'ejecutar_agregarpersonaAsistencia'; // pueden existir dos acciones, agregar persona o agregar persona y hora.

    }
    

    ajax=nuevoAjax();
    ajax.open("POST", "contenedor/ejecutarForm/ejecutar_tareas.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			
			divResultado.innerHTML = ajax.responseText;
			var sw = document.getElementById("sw").innerHTML;
			if(sw==3){
			swal("! Verificar ¡", "Debe definir hora de marcación", "error");	
			}
			else if(sw==4){
			swal("! Verificar ¡", "Error al registrar la asistencia del personal", "error");	
			}
			else if(sw==5){
			swal("! Verificar ¡", "Error no se encuentra registro de la persona en la base de datos", "error");	
			}
			else if(sw==6){
				if (idaccion==0) {
			swal("! Verificar ¡", "La hora debe Ser mayor a Hora de Asistencia", "error");	

				}
				else{
			swal("! Verificar ¡", "Error el personal ya se encuentra en el grupo trabajo", "error");
				}
			}
			else if(sw==7){
			swal("Exito ¡", "Se agrego personal al grupo trabajo ", "success");
			}
			else if(sw==8){
			swal("! Verificar ¡", "Error debe terminar turno para ser asignado a otro grupo de trabajo", "error");	
			}
			else if(sw==9){
			swal("! Verificar ¡", "Error ", "error");	
			}
			else if(sw==10){
			swal("! Verificar ¡", "Error código de barras vacío", "error");	
			}
			else if(sw==11){
			swal("! Verificar ¡", "Error usuario no existe en la base de datos...!", "error");	
			}
			else if(sw==12){
			swal("! Verificar ¡", "El personal ya registra hora de inicio", "info");	
			}
			else if(sw==13){
			swal("! Verificar !", "El personal ya registra hora de fin", "info");	
			}
			else if(sw==14){
			swal("! Verificar ¡", "El personal no pertenece al grupo", "info");	
			}
			else if(sw==15){
			swal("! Verificar ¡", "La hora ingresada debe ser mayor", "warning");	
			}
			else if(sw==16){
			swal("! Verificar ¡", "El personal esta en otro grupo de trabajo", "warning");	
			}
			else if(sw==17){
			swal("! Verificar ¡", "La hora de salida debe ser mayor a la hora inicial", "warning");	
			}
			else if (sw==2){
			swal("Ocurrió un error en el registro!", "Llamar al área de sistemas!", "error");
			}
			else if(sw==1){
				if(idTipoTurno==1){
					idTipoTurno = 'Ingreso';
				}
				else{
					idTipoTurno = 'Salida';
				}
			// swal("Exito !", "Se Registro "+idTipoTurno+" de Personal","success");
			toastr.success('Exito ! Se Registro ' +idTipoTurno+ ' de Personal');
			}
			document.getElementById("codigoBarras").value = '';	
			document.getElementById("codigoBarras").focus();		
				
		}
		}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("codigoBarra="+codigoBarra+"&hora="+hora+"&tipoturno="+idTipoTurno+"&codGrupo="+codGrupo+"&accion="+accion+"&idaccion="+idaccion+"&idOcupacion="+idOcupacion+"&pagina="+NumeroPaginaId+"&NumeroFilas="+NumeroFilas)
}
// Agrega un Nuvo tipo de Salida
function tipoSalida(tipo){
	divResultado = document.getElementById('resultado');
	NombreTipo = document.ResitrarNuevoTipo.NombreTipo.value;
	ajax = nuevoAjax(); 
	ajax.open("POST", "contenedor/formularios/autollenado.php",true);
	ajax.onreadystatechange=function() {

		if (ajax.readyState==4) {
		divResultado.innerHTML = ajax.responseText;
		var sw = document.getElementById("sw").innerHTML;
		var codActual = document.getElementById("codActualSa").innerHTML;
		if(sw==1){
		swal("! Exito !", "Se agrego Nuevo tipo ", "success");
		document.getElementById("idTipoSalida").value = codActual;
		setInterval(function(){ $("#closemodal").click();}, 1000);

		}
		else if (sw==2){
		swal("Ocurrió un error en el registro!", "Llamar al área de sistemas!", "error");
		}

		else if (sw==3){
		swal("Ocurrió un error en el registro!", "¡ No debe de tener datos vacíos!", "error");
		}

		document.getElementById("NombreTipo").value = '';
		}

	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("dato="+NombreTipo+"&tipo="+tipo)
}


function RegHorasNoLab(){
	divResultado = document.getElementById('resultadoPrincipal');
	//RegistroHorasNoLab
	idTipoSalida = document.getElementById("idTipoSalida").value;
	id_ocupacion = document.getElementById("id_ocupacion").value;
	id_Grupo = document.getElementById("id_Grupo").value;
	idTipoProceso = document.getElementById("idTipoProceso").value;
	codigoBarra = document.getElementById("codigoBarras").value;
	hora = document.getElementById("horaid").value;
	NumeroPaginaId = document.getElementById("NumeroPaginaId").innerHTML;
	accion = "registroNoLab"
	ajax = nuevoAjax(); 
	ajax.open("POST", "contenedor/ejecutarForm/ejecutar_horasNolaborables.php",true);
	ajax.onreadystatechange=function() {
	if (ajax.readyState==4) {
	divResultado.innerHTML = ajax.responseText;
	var sw = document.getElementById("sw").innerHTML;
		if(sw==1){
		swal("! Exito !", "Se Registro hora no Laborable ", "success");
		document.getElementById("idTipoSalida").value = idTipoSalida;//AQUI
		}
		else if (sw==2){
		swal("Ocurrió un error en el registro!", "Llamar al área de sistemas!", "error");	
		}
		else if (sw==3){
		swal("! Verificar !", "¡Error! Debe definir Tipo de Salida", "error");	
		}
		else if (sw==4){
		swal("¡ Verificar !", "¡Error! personal no se encuentra en el grupo trabajo !", "error");
		}
		else if (sw==5){
		swal("! Verificar !", "¡Error! Debe definir hora de marcación", "error");		
		}
		else if (sw==6){
		swal("! Verificar !", "¡Error! Ya tiene una hora de apertura", "error");		
		}
		else if (sw==7){
		swal("! Verificar !", "¡Error! no existe hora de apertura", "error");		
		}
		else if (sw==8){
		swal("! Verificar !", "¡Error! hora de fin incorrecto", "error");		
		}
		else if (sw==9){
		swal("! Verificar !", "¡Error! el personal no a registrado asistencia", "error");		
		}
		else if (sw==10){
		swal("! Verificar !", "¡Error! la Hora de asistencia es inferior", "error");		
		}
		else if (sw==11){
		swal("! Verificar !", "¡Error! La hora debe Ser mayor a hora de asistencia", "error");		
		}
		

	}
	document.getElementById("codigoBarras").value = '';	
	document.getElementById("codigoBarras").focus();
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("idTipoSalida="+idTipoSalida+"&id_ocupacion="+id_ocupacion+"&id_Grupo="+id_Grupo+
			  "&idTipoProceso="+idTipoProceso+"&hora="+hora+"&codigoBarra="+codigoBarra+"&accion="+accion+"&pagina="+NumeroPaginaId)
}

function registrarGrupoHoraNoLaborable(){
	divmensaje =   document.getElementById('mensaje');
	divmensaje.innerHTML= '<img src="img/cargando2.gif">';
	divResultado = document.getElementById('resultadoPrincipal');
	divResultado.innerHTML = ' ';
	id_Grupo = document.getElementById("id_Grupo").value;
	idTipoSalida = document.getElementById("idTipoSalida").value;
	idTipoProceso = document.getElementById("idTipoProceso").value;
	hora = document.getElementById("horaid").value;
	accion = "enviardatosgrupo"
	ajax = nuevoAjax(); 
	ajax.open("POST", "contenedor/ejecutarForm/ejecutar_horasNolaborables.php",true);
	ajax.onreadystatechange=function() {
	if (ajax.readyState==4) {
		divResultado.innerHTML = ajax.responseText;
		divmensaje.innerHTML = ' ';
		var sw = document.getElementById("sw").innerHTML;
		if(sw==1){
		swal("! Exito !", "Se Registro hora no Laborable ", "success");
		}
		else if (sw==2){
		swal("Ocurrió un error en el registro!", "Llamar al área de sistemas!", "error");	
		}
		else if (sw==3){
		swal("! Verificar !", "¡Error! Debe definir hora de marcación", "error");		
		}
		else if (sw==4){
		swal("! Verificar !", "¡Error! Debe definir Tipo de Salida", "error");			
		}
		else if (sw==6){
		swal("! Verificar !", "¡Error! el grupo no a registrado asistencia ", "error");			
		}
		else if (sw==7){
		swal("! Verificar !", "¡Error! El grupo tiene una hora de apertura ", "error");			
		}
		else if (sw==8){
		swal("! Verificar !", "¡Error! La hora de fin incorrecto", "error");		
		}
		else if (sw==9){
		swal("! Verificar !", "¡Error! la Hora de asistencia es inferior", "error");		
		}
		else if (sw==10){
		swal("! Verificar !", "¡Error! no existe hora de apertura del grupo", "error");		
		}
		else if (sw==11){
		swal("! Verificar !", "¡Error! Tipo es salida no es la Correcta", "error");		
		}

	}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("id_Grupo="+id_Grupo+"&idTipoSalida="+idTipoSalida+"&idTipoProceso="+idTipoProceso+"&hora="+hora+"&accion="+accion+"&pagina=1")

}






function cambiarPass(){// Cambiar Password
	swal({
        title: "¿Está seguro de realizar la Operación?",
        text: "¡Se cambiara la contraseña de acceso al sistema!",
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
	divResultado = document.getElementById('resultado');
	cod_usuario = document.EnviarDatos.cod_usuario.value;
	pass_actual = document.EnviarDatos.pass_actual.value;
	pass_new = document.EnviarDatos.pass_new.value;
	pass_confirmar = document.EnviarDatos.pass_confirmar.value;
	var accion = "canbiarpass";
	ajax=nuevoAjax();
	ajax.open("POST","ejecutar_cambiarpass.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
		divResultado.innerHTML = ajax.responseText
		var sw = document.getElementById("sw").innerHTML;
		if (sw==1){
		swal("Se cambio la contraseña!", "Debe de colocar la nueva contraseña la próxima vez que inicie sección ", "success");
		}
		else if (sw==2){
		 swal("Ocurrió un error en el registro!", "Llamar al área de sistemas!", "error");	
		}
		else if (sw==3){
		 swal("Error!!", "La nueva contraseña debe de tener mínimo cinco caracteres", "error");	
		}
		else if (sw==4){
		 swal("Error!!", "Error en la confirmación de la nueva contraseña ", "error");	
		}
		else if (sw==5){
		 swal("Error!!", "LA contraseña actual es incorrecta", "error");	
		}
		}
		document.getElementById("pass_actual").value = '';
		document.getElementById("pass_new").value = '';
		document.getElementById("pass_confirmar").value = '';	
		}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("cod_usuario="+cod_usuario+"&pass_actual="+pass_actual+"&pass_new="+pass_new+"&pass_confirmar="+pass_confirmar+"&accion="+accion)
		 }, 100);
		} else {
        	
        swal("Usted Cancelo la operación!", "No se realizó ningún cambio", "error");
       
        }
        });
}

function Cambiar_Pass(){
	divResultado = document.getElementById('resultado2');
	login2 = document.EnviarDatos.login2.value;
	pass_actual = document.EnviarDatos.pass_actual.value;
	pass_new = document.EnviarDatos.pass_new.value;
	pass_confirmar = document.EnviarDatos.pass_confirmar.value;
	var accion = "canbiarpassexp";
	ajax=nuevoAjax();
	ajax.open("POST","cambiarpass.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) 
		{
			
			divResultado.innerHTML = ajax.responseText;
			var sw = document.getElementById("sw").innerHTML;
			if (sw==1){
			swal("Se cambio la contraseña!", "Debe de colocar la nueva contraseña la próxima vez que inicie sección ", "success");
			$('#exampleModal').modal('hide');
			document.getElementById("login").value = '';
			document.getElementById("password").value = '';
			document.getElementById("login2").value = '';
			document.getElementById("pass_actual").value = '';
			document.getElementById("pass_new").value = '';
			document.getElementById("pass_confirmar").value = '';
			document.getElementById("msgbox").style.display='none';
			}
			else if (sw==2){
			 swal("Ocurrió un error en el registro!", "Llamar al área de sistemas!", "error");	
			}
			else if (sw==3){
			 swal("Error!!", "Usuario no Existe!", "error");	
			}
			else if (sw==4){
			 swal("Error!!", "LA contraseña actual es incorrecta", "error");	
			}
			else if (sw==5){
			 swal("Error!!", "Error en la confirmación de la nueva contraseña", "error");	
			}
			else if (sw==6){
			 swal("Error!!", "La nueva contraseña debe de tener mínimo seis caracteres", "error");	
			}
			else if (sw==7){
			 swal("Error!!", "La nueva contraseña debe ser diferente a la actual", "error");	
			}



		}
	}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("accion="+accion+"&login2="+login2+"&pass_actual="+pass_actual+"&pass_new="+pass_new+"&pass_confirmar="+pass_confirmar)

}

/*=============================================
PAGINADORES 
=============================================*/

function enviar_paginador(pagina,grupo,tipo, por_pagina,OrdenarTabla){//paginador asistencia Personal
	divResultado = document.getElementById('resultadoDet');
	
	ajax=nuevoAjax();
	ajax.open("POST", "contenedor/formularios/tabla_asistenciaDiaria.php",true);
		ajax.onreadystatechange=function() {
		
		if (ajax.readyState==4) {
			divResultado.innerHTML = ajax.responseText;	
		}

	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//ajax.send("pagina="+pagina+"&grupo="+grupo+"&tipo="+tipo+"&NumeroFilas="+por_pagina)
	ajax.send("pagina="+pagina+"&dato="+grupo+"&idTipoTurno="+tipo+"&NumeroFilas="+por_pagina+"&OrdenarTabla="+OrdenarTabla);
}

function enviar_paginador2(pagina,grupo,por_pagina,OrdenarTabla){//Paginador Asistencia Horas No Laborables
	divmensaje =   document.getElementById('mensaje');
	divmensaje.innerHTML= '<img src="img/cargando2.gif">';
	divResultado = document.getElementById('resultadoPrincipal');
	divResultado.innerHTML = ' ';
	ajax=nuevoAjax();
	ajax.open("POST","contenedor/formularios/tabla_horasnolaborables.php",true);
	ajax.onreadystatechange=function() {
		
		if (ajax.readyState==4) {
			divResultado.innerHTML = ajax.responseText;	
			divmensaje.innerHTML = ' ';
		}

	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//ajax.send("pagina="+pagina+"&grupo="+grupo+"&tipo="+tipo+"&NumeroFilas="+por_pagina)
	ajax.send("pagina="+pagina+"&dato="+grupo+"&NumeroFilas="+por_pagina+"&OrdenarTabla="+OrdenarTabla);

}

function enviar_paginador3(pagina,grupo,por_pagina){//Paginador Procesos Diario
	divResultado = document.getElementById('divResultadoProcesos');
	
	ajax=nuevoAjax();
	ajax.open("POST", "contenedor/formularios/tabla_ProcesosUnidades.php",true);
		ajax.onreadystatechange=function() {
		
		if (ajax.readyState==4) {
			divResultado.innerHTML = ajax.responseText;	
		}

	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("pagina="+pagina+"&dato="+grupo+"&NumeroFilas="+por_pagina);

}

function enviar_paginador4(pagina,grupo,por_pagina){
	divResultado = document.getElementById('divResultadoRegistros');
	
	ajax=nuevoAjax();
	ajax.open("POST", "contenedor/formularios/tabla_Registroprocesos.php",true);
		ajax.onreadystatechange=function() {
		
		if (ajax.readyState==4) {
			divResultado.innerHTML = ajax.responseText;	
		}

	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("pagina="+pagina+"&dato="+grupo+"&NumeroFilas="+por_pagina);

}

// FIN PAGINADORES

/*=============================================
REGISTRO DE PROCESO FILETEROS DINO
=============================================*/

function EnviarProceso(){
	divResultado = document.getElementById('divResultadoProcesos');
	id_ocupacion = document.getElementById('id_ocupacion').value;        	
	id_Grupo = document.getElementById('id_Grupo').value;        	
	id_cantidad = document.getElementById('id_cantidad').value;
	accion= "EjecutarProcesoFiletero";
	ajax=nuevoAjax();
	ajax.open("POST", "contenedor/ejecutarForm/Ejecutar_Procesos.php",true);
		ajax.onreadystatechange=function() {
		
		if (ajax.readyState==4) {
			divResultado.innerHTML = ajax.responseText;
			var sw = document.getElementById("sw").innerHTML;

			if(sw==1){
			swal("! Exito !", "Se Envio Procesos ", "success");
			}
			else if (sw==2){
			swal("Ocurrió un error en el registro!", "Llamar al área de sistemas!", "error");	
			}
			else if (sw==3){
			swal("! Verificar !", "¡Error! Debe definir Cantidad", "error");			
			}

		}

	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("accion="+accion+"&id_ocupacion="+id_ocupacion+"&id_Grupo="+id_Grupo+"&id_cantidad="+id_cantidad+"&pagina=1");
}

//FIN REGISTRO PROCESO POR UND

/*=============================================
REGISTRO DE MATERIA PRIMA
=============================================*/

function registrarcantidadMP(){
	divResultado = document.getElementById('divResultadoRecepcion');
	horaid = document.getElementById('horaid').value;
	id_cantidad = document.getElementById('id_cantidad').value;  
	turno = document.getElementById('turno').value;  
	id_Especie = document.getElementById('id_Especie').value; 
	id_tiporecep = document.getElementById('id_tiporecep').value;
	id_embarcacion = document.getElementById('id_embarcacion').value;

	Obs = document.getElementById('Obs').value;
	accion= "RegistraringresoMP";
	ajax = nuevoAjax();
	ajax.open("POST","contenedor/ejecutarForm/ejecutar_horasNolaborables.php",true);
		ajax.onreadystatechange=function(){
			if(ajax.readyState==4){
				divResultado.innerHTML = ajax.responseText;
				var sw = document.getElementById("sw").innerHTML;
				if (sw==1) {
				swal("! Exito !", "Se Registro Ingreso de Materia Prima ", "success");
				document.getElementById("horaid").value = '';
				document.getElementById("id_cantidad").value = '';
				document.getElementById("id_embarcacion").value = '';


				}
				else if (sw==2) {
				swal("Ocurrió un error en el registro!", "Llamar al área de sistemas!", "error");		
				}
				else if (sw==3) {
				swal("! Verificar !", "¡Error! Debe definir Cantidad de Materia Prima", "error");		
				}
				else if (sw==4) {
				swal("! Verificar !", "¡Error! Debe definir Tipo de Especie", "error");		
				}
				else if (sw==5) {
				swal("! Verificar !", "¡Error! Debe definir Tipo de Recepción", "error");		
				}
				else if (sw==6) {
				swal("! Verificar !", "¡Error!  Debe definir hora de Recepción M.P", "error");		
				}



			}


		}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("accion="+accion+"&horaid="+horaid+"&id_cantidad="+id_cantidad+"&turno="+turno+"&id_Especie="+id_Especie+"&id_tiporecep="+id_tiporecep+"&Obs="+Obs+"&id_embarcacion="+id_embarcacion);


}

//FIN REGISTRO MATERIA PRIMA

/*=============================================
BUSCADOR DE EMBARCACIONES
=============================================*/

function buscadorEmbarcaciones() {
	divResultado = document.getElementById('demo');
	var dato = document.getElementById("buscarEmbar").value;
	ajax = nuevoAjax();
	accion = "buscarEmbarcacion";
	ajax.open("POST","contenedor/ejecutarForm/ejecutar_horasNolaborables.php",true);
			
			ajax.onreadystatechange=function(){
				if(ajax.readyState==4){
					divResultado.innerHTML = ajax.responseText;
				}   
				$('#demo').show();
			}
		

		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("accion="+accion+"&dato="+dato);

}

function mostrarDatos(id,dato){

	// Cambiar el valor del formulario input
	$('#buscarEmbar').val(dato);
	$('#id_embarcacion').val(id);
	// limpia li
	$('#demo').hide();

}

// FIN BUSCARDOR

function eliminarRegistroAsistencia(codigo,idTipoTurno,pagina,por_pagina,codigogrupo,OrdenarTabla){
	swal({
        title: "¿Está seguro de realizar la Operación?",
        text: "¡Se eliminara registro de Personal!",
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
	divResultado = document.getElementById('resultadoDet');
	var accion = 'eliminarA';
	ajax=nuevoAjax();
	ajax.open("POST", "contenedor/ejecutarForm/ejecutar_horasNolaborables.php",true);
	ajax.onreadystatechange=function() {
		
		if (ajax.readyState==4) {
			
			
			divResultado.innerHTML = ajax.responseText;		
			var sw = document.getElementById("sw").innerHTML;
			if(sw==1){
			swal("! Exito !", "Se Elimino Registro ", "success");
			}
			else if (sw==2) {
			swal("Ocurrió un error en el registro!", "Llamar al área de sistemas!", "error");		
			}
					
				
		}
		}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("accion="+accion+"&codigo="+codigo+"&idTipoTurno="+idTipoTurno+"&pagina="+pagina+"&por_pagina="+por_pagina+"&codigogrupo="+codigogrupo+"&OrdenarTabla="+OrdenarTabla)
		}, 100);
		} else {
        	
        swal("Usted Cancelo la operación!", "No se realizó ningún cambio", "error");
       
        }
        });
	

}

function eliminarHoranoLaboral(codigodetalle,pagina,por_pagina,codigogrupo,id,nolaboral,OrdenarTabla,NumeroFilas){
divResultado = document.getElementById('resultadoPrincipal');
var accion = 'eliminarhoranolaboral';
	ajax=nuevoAjax();
	ajax.open("POST", "contenedor/ejecutarForm/ejecutar_horasNolaborables.php",true);
	ajax.onreadystatechange=function() {
		
		if (ajax.readyState==4) {
			
			
			divResultado.innerHTML = ajax.responseText;		
			var sw = document.getElementById("sw").innerHTML;
			if(sw==1){
			swal("! Exito !", "Se Elimino Registro ", "success");
			}
			else if (sw==2) {
			swal("Ocurrió un error en el registro!", "Llamar al área de sistemas!", "error");		
			}
					
				
		}
		}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("accion="+accion+"&codigodetalle="+codigodetalle+"&pagina="+pagina+"&por_pagina="+por_pagina+"&codigogrupo="+codigogrupo+"&id="+id+"&nolaboral="+nolaboral+"&OrdenarTabla="+OrdenarTabla+"&NumeroFilas="+NumeroFilas)



}

function mostrarPersonal(divPersonal){
	divResultado = document.getElementById('divPersonal');
	dato = document.getElementById("id_linea").value;
	ajax=nuevoAjax();
	ajax.open("POST", "contenedor/formularios/tabla_listaPersonal.php",true);
	ajax.onreadystatechange=function() {
		
		if (ajax.readyState==4) {
			
		divResultado.innerHTML = ajax.responseText;
		
		}
		}
		
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("dato="+dato)

}

/*=============================================
 REGISTRO PROCESO POR KG
=============================================*/


function cargarRegistroProcesos(ope,dato,divtabprocesos){
	divResultado2 = document.getElementById(divtabprocesos);
	dato = document.getElementById("id_Grupo").value;
	dato2 = document.getElementById("id_ocupacion").value;
	ajax=nuevoAjax();
	if (ope==1){
	ajax.open("POST", "contenedor/formularios/tabla_Registroprocesos.php",true);//GRUPO
	}
	else if (ope==2) {
	ajax.open("POST", "contenedor/formularios/tabla_Registroprocesos.php",true);//POR PERSONA
	}
	else if (ope==3) {
	ajax.open("POST", "contenedor/formularios/tabla_procesoAvancePrecocido.php",true);//GRUPO PRECOCIDO
	}
	else if (ope==4) {
	ajax.open("POST", "contenedor/formularios/tabla_ProcesosUnidades.php",true);//GRUPO PRECOCIDO
	}
	else if (ope==5) {
	ajax.open("POST", "contenedor/formularios/tabla_RegistroprocesosGM.php",true);//PERSONA MANUAL
	}
	else if (ope==6) {
	ajax.open("POST", "contenedor/formularios/tabla_SubGrupos.php",true);//PERSONA SUBGRUPOS
	}
	ajax.onreadystatechange=function() {
		
		if (ajax.readyState==4) {
			
		divResultado2.innerHTML = ajax.responseText;
		if(ope==6){
			$("#BtnGuardar").prop("disabled", false);
			$("#BtnVer").prop("disabled", false);
		}
		$("#id_Unidad").prop("disabled", false);
		// $("#id_cantidad").prop("disabled", false);////aqui se desavilito por ingreso manual 16/08/2022
		$("#guardar").prop("disabled", false);
		$("#codigoBarras").prop("disabled", false);

			if (ope==5) {
				document.getElementById("id_cantidad").value = ''; }
			}
		}
		
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("dato="+dato+"&pagina=1"+"&ope="+ope+"&dato2="+dato2)
}


function EnviarProcesoKG(){
	divResultado = document.getElementById('divResultadoRegistros');
	id_ocupacion = document.getElementById('id_ocupacion').value;        	
	id_Grupo = document.getElementById('id_Grupo').value;        	
	id_cantidad = document.getElementById('id_cantidad').value;
	codigoBarras = document.getElementById('codigoBarras').value;
	accion = document.getElementById('accion').value;
	var CodProducto=null;
	if (document.getElementById('id_Producto') != null) {
    CodProducto = document.getElementById("id_Producto").value;}

	if (accion==1) 
	{
	accion= "EjecutarProcesoG";//GRUPO
	}
	else if(accion==2)
	{
	accion= "EjecutarProcesoP";//POR PERSONA
	}

	ajax=nuevoAjax();
	ajax.open("POST", "contenedor/ejecutarForm/Ejecutar_Procesos.php",true);
		ajax.onreadystatechange=function() {
		
		if (ajax.readyState==4) {
			divResultado.innerHTML = ajax.responseText;
			var sw = document.getElementById("sw").innerHTML;

			if(sw==1){
			swal("! Exito !", "Se Envio Procesos ", "success");
			}
			else if (sw==2){
			swal("Ocurrió un error en el registro!", "Llamar al área de sistemas!", "error");	
			}
			else if (sw==5){
			swal("! Verificar !", "¡Error! Debe definir Tipo de Unidad", "error");		
			}
			else if (sw==4){
			swal("! Verificar !", "¡Error! Debe definir Cantidad", "error");			
			}
			else if (sw==3){
			swal("! Verificar !", "¡Error! el grupo no a registrado asistencia", "error");			
			}
			else if (sw==6){
			swal("! Verificar !", "¡Error! El grupo debe culminar la hora no laborable ", "error");			
			}
			else if (sw==7){
			swal("! Verificar !", "¡Error! el grupo Termino turno", "error");			
			}
			else if (sw==8){
			swal("! Verificar !", "¡Error! Revisar Codigo de Barras ", "error");			
			}
			else if (sw==9){
			swal("! Verificar !", "¡Error! El Personal debe culminar la hora no laborable ", "error");			
			}
			else if (sw==10){
			swal("! Verificar !", "¡Error! El Personal cerro assitencia ", "error");			
			}

		}

	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("accion="+accion+"&id_ocupacion="+id_ocupacion+"&id_Grupo="+id_Grupo+"&id_cantidad="+id_cantidad+"&codigoBarras="+codigoBarras+"&pagina=1"+"&CodProducto="+CodProducto);
}


//FIN REGISTRO PROCESO POR TONELADAS

/*=============================================
REGISTRO DE PROCESO PRECOCIDO
=============================================*/

function EnviarProcesoPrecocido() {
	divResultado = document.getElementById('divResultadoRegistros');
	id_ocupacion =  document.getElementById('id_ocupacion').value;
	id_Grupo =  document.getElementById('id_Grupo').value;
	id_cantidad = document.getElementById('id_cantidad').value;

	accion = "RegistrarProcesoPrecocido";
	ajax = nuevoAjax();
	ajax.open("POST","contenedor/ejecutarForm/Ejecutar_Procesos.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			divResultado.innerHTML = ajax.responseText;
			var sw = document.getElementById("sw").innerHTML;
			if(sw==1){
			swal("! Exito !", "Se Envio Procesos ", "success");
			}
			else if (sw==2){
			swal("Ocurrió un error en el registro!", "Llamar al área de sistemas!", "error");	
			}
			else if (sw==3){
			swal("! Verificar !", "¡Error! Debe definir Cantidad", "error");	
			}

		}

	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("accion="+accion+"&id_ocupacion="+id_ocupacion+"&id_Grupo="+id_Grupo+"&id_cantidad="+id_cantidad+"&pagina=1");
}

function registrarTodoHoraNoLaborable(){

	divmensaje =   document.getElementById('mensaje');
	divmensaje.innerHTML= '<img src="img/cargando2.gif">';
	divResultado = document.getElementById('resultadoPrincipal');
	divResultado.innerHTML = ' ';
	idTipoSalida = document.getElementById("idTipoSalida").value;
	idTipoProceso = document.getElementById("idTipoProceso").value;
	hora = document.getElementById("horaid").value;
	accion = "enviardatostodo"
	ajax = nuevoAjax(); 
	ajax.open("POST", "contenedor/ejecutarForm/ejecutar_horasNolaborables.php",true);
	ajax.onreadystatechange=function() {
	if (ajax.readyState==4) {
		divResultado.innerHTML = ajax.responseText;
		divmensaje.innerHTML = ' ';
		var sw = document.getElementById("sw").innerHTML;
		if(sw==1){
		swal("! Exito !", "Se Registro hora no Laborable ", "success");
		}
		else if (sw==2){
		swal("Ocurrió un error en el registro!", "Llamar al área de sistemas!", "error");	
		}
		else if (sw==3){
		swal("! Verificar !", "¡Error! Debe definir hora de marcación", "error");		
		}
		else if (sw==4){
		swal("! Verificar !", "¡Error! Debe definir Tipo de Salida", "error");			
		}
		else if (sw==6){
		swal("! Verificar !", "¡Error! el grupo no a registrado asistencia ", "error");			
		}
		else if (sw==7){
		swal("! Verificar !", "¡Error! Se Registro hora de apertura a todo el Personal", "error");			
		}
		else if (sw==8){
		swal("! Verificar !", "¡Error! La hora de fin incorrecto", "error");		
		}
		else if (sw==9){
		swal("! Verificar !", "¡Error! la Hora de asistencia es inferior", "error");		
		}
		else if (sw==10){
		swal("! Verificar !", "¡Error! no existe hora de apertura del grupo", "error");		
		}
		else if (sw==11){
		swal("! Verificar !", "¡Error! Tipo es salida no es la Correcta", "error");		
		}

	}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("&idTipoSalida="+idTipoSalida+"&idTipoProceso="+idTipoProceso+"&hora="+hora+"&accion="+accion+"&pagina=1")

}


/*=============================================
REGISTRO DE PROCESO PRECOCIDO CHECK
=============================================*/

function enviar_kg_Persona(codDetalle,codGrupo,pagina,tipo) {

	divResultado = document.getElementById('divResultadoRegistros');
	id_cantidad = document.getElementById('id_cantidad').value;
	id_ocupacion = document.getElementById('id_ocupacion').value;        	
	id_Grupo = document.getElementById('id_Grupo').value;  

	accion = "enviarKGporcheck"

	if (tipo==1)
	{
		var msj = "Se agrego ";
	}
	else
	{
		var msj = "Se resto ";	
	}

	ajax=nuevoAjax();
	ajax.open("POST", "contenedor/ejecutarForm/Ejecutar_Procesos.php",true);
		ajax.onreadystatechange=function() {
		
		if (ajax.readyState==4) {
			divResultado.innerHTML = ajax.responseText;
			var sw = document.getElementById("sw").innerHTML;

			if(sw==1){
			// alertify.set('notifier','position', 'top-right');
 		// 	alertify.success('Exito : ' + 'Se registo '+ id_cantidad + 'Kg');
 			toastr.success('EXITO...!  '+ msj + id_cantidad + ' Kg');
			}
			else if (sw==2) {
			toastr.error('ERROR...! Verificar Kg Ingresados'); 
			}
			else if (sw==3) {
			toastr.error('ERROR...! Verificar Kg Ingresados'); 
			}
			else if (sw==4) {
			toastr.error('ERROR...! Verificar Cantidad a Disminuir'); 
			}
			else{
			toastr.error('ERROR...! Llamar al área de sistemas'); 		
			}

		}

	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("accion="+accion+"&codDetalle="+codDetalle+"&id_cantidad="+id_cantidad+"&codGrupo="+codGrupo+"&tipo="+tipo+"&pagina="+pagina);
}

/*=============================================
 REGISTRO PROCESO POR KG MANUAL
=============================================*/

function EnviarProcesoKGmanual(){
	divResultado = document.getElementById("divResultadoRegistros");
	id_ocupacion = document.getElementById('id_ocupacion').value;        	
	id_Grupo = document.getElementById('id_Grupo').value;        	
	id_cantidad = document.getElementById('id_cantidad').value;
	Hora_inicio = document.getElementById('horaInicio').value;        	
	Hora_Fin = document.getElementById('horaFin').value;
	dniPersonal = document.getElementById("dniPersonal").value;
	idaccion = document.getElementById("idaccion").value;
	if (idaccion==0) { accion = "EnvioManualGkg"}else if (idaccion==1){ accion = "AgregarPersonaManual"}
	else if (idaccion==3){ accion = "EnvioManualPkg"}
	ajax=nuevoAjax();
	ajax.open("POST", "contenedor/ejecutarForm/Ejecutar_Procesos.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			divResultado.innerHTML = ajax.responseText;
			var sw = document.getElementById("sw").innerHTML;
			var tarifa = document.getElementById("tarifa").innerHTML;
			if (sw==1){
				if (idaccion==0) {
					toastr.success('EXITO...!  Se agrego ' + id_cantidad);
					// document.getElementById("accion").value = 0;
				}
				else if (idaccion==1) {
					toastr.success('EXITO...!  Se agrego Personal al Grupo');
					// document.getElementById("accion").value=0;
					if (tarifa==1) {
							$("#id_cantidad").prop("disabled", true);
						}
					else{
						 $("#id_cantidad").prop("disabled", false);
					}
					$("#DatoDni").fadeOut();
					// document.getElementById("accion").value = 0;
				}
				else if (idaccion==3) {
				toastr.success('EXITO...!  Se Registro Cantidad ');
				}
				
			}
			else if (sw==3) {
				toastr.error('ERROR...! Debe Ingresar la Cantidad');
			}
			else if (sw==4) {
				toastr.error('ERROR...! Debe Ingresar el DNI');
			}
			else if (sw==5) {
				toastr.error('ERROR...! Persona no se encuentra registrada en el grupo de trabajo');
			}
			else if (sw==6) {
				toastr.error('ERROR...! No se registro Hora');
			}
			else if (sw==7) {
				toastr.error('ERROR...! No existe Persona');
			}
			else if (sw==8) {
				toastr.error('ERROR...! Persona se encuentra registrada en el grupo');
			}
			else if (sw==9) {
				toastr.error('ERROR...! Selecionar fecha de inicio y fin de labores');
			}
			else if (sw==10) {
				toastr.error('ERROR...! La Fecha de inicio es diferente al turno generado');
			}

			else{
				toastr.error('ERROR...! Llamar al área de sistemas');
			}

		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("accion="+accion+"&id_ocupacion="+id_ocupacion+"&id_Grupo="+id_Grupo+"&id_cantidad="+id_cantidad+"&Hora_inicio="+Hora_inicio+"&Hora_Fin="+Hora_Fin+"&dniPersonal="+dniPersonal+"&idaccion="+idaccion);

}


/*=============================================
 REGISTRO PROCESO POR KG MANUAL v2 check
=============================================*/

function EnviarProcesoKGmanualCheck(idcodigo){
	divResultado = document.getElementById("divResultadoRegistros");
	id_ocupacion = document.getElementById('id_ocupacion').value;        	
	id_Grupo = document.getElementById('id_Grupo').value;        	
	id_cantidad = document.getElementById('id_cantidad').value;
	Hora_inicio = document.getElementById('horaInicio').value;        	
	Hora_Fin = document.getElementById('horaFin').value;
	idaccion = document.getElementById("idaccion").value;
	accion = "EnvioManualGkgCheck";
	ajax=nuevoAjax();
	ajax.open("POST", "contenedor/ejecutarForm/Ejecutar_Procesos.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			divResultado.innerHTML = ajax.responseText;
			var sw = document.getElementById("sw").innerHTML;
			var tarifa = document.getElementById("tarifa").innerHTML;
			if (sw==1){

					if (tarifa==1) {
							$("#id_cantidad").prop("disabled", true);
						}
					else{
						 $("#id_cantidad").prop("disabled", false);
					}
			}
			else if (sw==2) {
				toastr.error('ERROR...! Debe Ingresar Cantidad');
			}
			else if (sw==3) {
				toastr.error('ERROR...! Debe Ingresar la Hora de labores');
			}
			else if (sw==4) {
				toastr.error('ERROR...! Selecionar la opción SIN ACCIÓN');
			}
			else if (sw==5) {
				toastr.error('ERROR...! La Fecha de Fin Debe ser menor');
			}
			else if (sw==6) {
				toastr.error('ERROR...! La Fecha de inicio es diferente al turno generado');
			}
			else{
				toastr.error('ERROR...! Llamar al área de sistemas');
			}

		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("accion="+accion+"&id_ocupacion="+id_ocupacion+"&id_Grupo="+id_Grupo+"&id_cantidad="+id_cantidad+"&Hora_inicio="+Hora_inicio+"&Hora_Fin="+Hora_Fin+"&idcodigo="+idcodigo+"&idaccion="+idaccion);

}

/*=============================================
 REGISTRO PERSONA MANUAL
=============================================*/

function Onclick(){
	
	let accion = document.getElementById("accion").value;
	if (accion==0) {
		document.getElementById("dniPersonal").focus();
		document.getElementById("accion").value=1;
		document.getElementById("id_cantidad").value='';
		$("#id_cantidad").prop("disabled", true);
		document.getElementById("dniPersonal").value='';
		$("#DatoDni").fadeIn();}
	if(accion==1){
		$("#DatoDni").fadeOut();
		$("#id_cantidad").prop("disabled", false);
		document.getElementById("accion").value=0;
	}

}

function RegistrarAsistencia(){ 
    divResultado = document.getElementById('divResultadoRegistros');
    dniPersonal = document.getElementById("dniPersonal").value;
    codGrupo = document.getElementById("id_Grupo").value;
    idOcupacion = document.getElementById("id_ocupacion").value;
   	Hora_inicio = document.getElementById('horaInicio').value;        	
	Hora_Fin = document.getElementById('horaFin').value;
    var accion = 'RegistroManualPersona';
    ajax=nuevoAjax();
    ajax.open("POST", "contenedor/ejecutarForm/Ejecutar_Procesos.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			
			divResultado.innerHTML = ajax.responseText;
			// var sw = document.getElementById("sw").innerHTML;	
				
			}
		}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("dniPersonal="+dniPersonal+"&codGrupo="+codGrupo+"&accion="+accion+"&idaccion="+idaccion+"&idOcupacion="+idOcupacion+"&Hora_inicio="+Hora_inicio+"&Hora_Fin="+Hora_Fin)
}

function RegistrarAcionesManuales(IdMov){
	divResultado = document.getElementById('divResultadoRegistrosTab');
	idDetalle = document.getElementById("CodDetalleUPDATE").value;
	idGrupo = document.getElementById("idGrupoUPDATE").value;
	idOcupacion = document.getElementById("idOcupacionUPDATE").value;
	Hora_inicio = document.getElementById('horaInicioEdit').value;        	
	Hora_Fin = document.getElementById('horaFinEdit').value;
	var accion = 'RegistroAcionesManuales'
	ajax = nuevoAjax(); 
	ajax.open("POST", "contenedor/ejecutarForm/Ejecutar_Procesos.php",true);
	ajax.onreadystatechange=function() {

		if (ajax.readyState==4) {
		divResultado.innerHTML = ajax.responseText;
		var sw = document.getElementById("sw").innerHTML;
		if(sw==1){
			toastr.success('EXITO...!  Se Edito ');
			$('#Modal').modal('hide');
			$('body').removeClass('modal-open');
			$('.modal-backdrop').remove();
		}
		else if (sw==3){
			toastr.error('ERROR...! La Cantidad de KG debe ser menor a 0');
			$('#Modal').modal('hide');
			$('body').removeClass('modal-open');
			$('.modal-backdrop').remove();
		}
		else if (sw==4){
			toastr.error('ERROR...! La Fecha de inicio es diferente al turno generado');
			$('#Modal').modal('hide');
			$('body').removeClass('modal-open');
			$('.modal-backdrop').remove();
		}
		else{
		swal("Ocurrió un error en el registro!", "Llamar al área de sistemas!", "error");
			}
		}


	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("accion="+accion+"&Hora_inicio="+Hora_inicio+"&Hora_Fin="+Hora_Fin+"&idDetalle="+idDetalle+"&idGrupo="+idGrupo+"&IdMov="+IdMov+"&idOcupacion="+idOcupacion)
}

function EditarCantidadManual(codDetalle,codGrupo,pagina,tipo,Frm) {

	divResultado = document.getElementById('divResultadoRegistrosTab');
	id_cantidad = document.getElementById('id_cantidad').value;
	var CodProducto=null;
	if (document.getElementById('id_Producto') != null) {
    CodProducto = document.getElementById("id_Producto").value;}
	accion = "enviarKGporcheckManual"

	if (tipo==1)
	{
		var msj = "Se agrego ";
	}
	else
	{
		var msj = "Se resto ";	
	}

	ajax=nuevoAjax();
	ajax.open("POST", "contenedor/ejecutarForm/Ejecutar_Procesos.php",true);
		ajax.onreadystatechange=function() {
		
		if (ajax.readyState==4) {
			divResultado.innerHTML = ajax.responseText;
			var sw = document.getElementById("sw").innerHTML;

			if(sw==1){
			// alertify.set('notifier','position', 'top-right');
 		// 	alertify.success('Exito : ' + 'Se registo '+ id_cantidad + 'Kg');
 			toastr.success('EXITO...!  '+ msj + id_cantidad + ' Kg');
			}
			else if (sw==2) {
			toastr.error('ERROR...! Verificar Kg Ingresados'); 
			}
			else if (sw==3) {
			toastr.error('ERROR...! Verificar Kg Ingresados'); 
			}
			else if (sw==4) {
			toastr.error('ERROR...! Verificar Cantidad a Disminuir'); 
			}
			else if (sw==5) {
			toastr.error('ERROR...! No Registra marcación'); 
			}
			else{
			toastr.error('ERROR...! Llamar al área de sistemas'); 		
			}

		}divResultadoRegistros

	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("accion="+accion+"&codDetalle="+codDetalle+"&id_cantidad="+id_cantidad+"&codGrupo="+codGrupo+"&tipo="+tipo+"&Frm="+Frm+"&pagina="+pagina+"&CodProducto="+CodProducto);
}


/*=============================================
Registro de distribución por sesión
=============================================*/

function RegistrarDistribucionS(datoSelec,idDetalle) {
	divResultado = document.getElementById('divResultadoRegistros')
	accion = "RegistroDistribucion"
	ajax=nuevoAjax()
	ajax.open("POST", "contenedor/ejecutarForm/Ejecutar_Procesos02.php",true)
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		
		}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
	ajax.send("accion="+accion+"&idDetalle="+idDetalle+"&datoSelec="+datoSelec)
}

/*=============================================
Registro de SubGrupos
=============================================*/

function RegistrarSubGrupo(Tipo){
	divResultado = document.getElementById("divResultadoRegistros")
	idGrupo = document.getElementById("id_Grupo").value;
	idOcupacion = document.getElementById("id_ocupacion").value;
	NomSubGrupo = document.getElementById("NomSubGrupo").value;
	IdSubGrupo = $('input[name="Grupos"]:checked').val();
	var selected = []
    $(":checkbox[name=CodDetalleEmpleado]").each(function() {
      if (this.checked && !this.disabled) {
      		selected.push($(this).val());
      }
    })
    string = selected.toString();//envio en cadena los check

	if (NomSubGrupo=='' && Tipo==2){
		toastr.error('ERROR...! Debe registrar un nombre!');
		return
	}
	if (string=='' && Tipo==1){
		toastr.error('ERROR...! Debe selecionar un registro!');
		return
	}
	if (IdSubGrupo==undefined && Tipo==1){
		toastr.error('ERROR...! Debe selecionar un SubGrupo!');
		return
	}
	accion = "RegistrarSubGrupo"
	ajax = nuevoAjax()
	ajax.open("POST","contenedor/ejecutarForm/Ejecutar_Procesos02.php",true)
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
				var sw = document.getElementById("sw").innerHTML;
				if(sw==1){
					toastr.success('EXITO...!  Se Registro Grupo ');
					$('#ModalSubGrupo').modal('hide');
					$('body').removeClass('modal-open');
					$('.modal-backdrop').remove();
				}
				else if (sw==2){
					toastr.error('ERROR...! Llamar al área de sistemas!');
					$('#ModalSubGrupo').modal('hide');
					$('body').removeClass('modal-open');
					$('.modal-backdrop').remove();
				}
				else if (sw==3){
					toastr.error('ERROR...! Debe selecionar un registro!');
				}
				else if (sw==4){
					toastr.error('ERROR...! Debe registrar un nombre!');
				}
				else if (sw==5){
					toastr.error('ERROR...! Debe selecionar un SubGrupo!');
				}
				document.getElementById("NomSubGrupo").value = ""
			}
		}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
	ajax.send("accion="+accion+"&idGrupo="+idGrupo+"&idOcupacion="+idOcupacion+"&ArrayDatos="+string+"&NomSubGrupo="+NomSubGrupo+"&IdSubGrupo="+IdSubGrupo+"&Tipo="+Tipo)	
}

function EjecutarProcesoSubGrupo(CodigoReg,CodGrupo,CodEmpleado){
	divResultado = document.getElementById("DivResultadoSubGrupo")
	accion = "AccionSubGrupo"
	ajax  = nuevoAjax()
	ajax.open("POST","contenedor/ejecutarForm/Ejecutar_Procesos02.php",true)
				ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
				divResultado.innerHTML =  ajax.responseText
				var sw = document.getElementById("sw").innerHTML
				if (sw==1) {
					toastr.success('EXITO...!  Se Elimino Registro');
				}
				else{
					toastr.error('ERROR...! Llamar al área de sistemas!');
				}
			}
		}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
	ajax.send("accion="+accion+"&CodigoReg="+CodigoReg+"&CodEmpleado="+CodEmpleado+"&CodGrupo="+CodGrupo)

}