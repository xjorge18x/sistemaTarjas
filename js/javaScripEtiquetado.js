
//  function DashBoard(){

// 	var trigger =setInterval(function(){ 
// 	divResultado = document.getElementById('TablaTimer01');
// 	if (divResultado != null) {
// 	accion = "Dash"
// 	ajax=nuevoAjax();
// 	ajax.open("POST", "contenedor/ejecutarForm/Ejecutar_Procesos02.php",true)
// 	ajax.onreadystatechange=function() {
		
// 		if (ajax.readyState==4) {

// 			divResultado.innerHTML = ajax.responseText;	
			
// 		}

// 	}
// 	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
// 	ajax.send("accion="+accion);
	
// 	}else {
//     clearInterval(trigger);
//   }

// 	 }, 10000);

// }

// async function verco(){
// 	let ver = await DashBoard();
// }

// Ocultar Botton
function cargarSelectv2(tipo,dato,divcambio){
	divResultado = document.getElementById(divcambio);
	divResultado.innerHTML = '';
	if((dato=='1') || (dato=='5')){
		$("#enviar").css("display","none")
	}
	else{
		$("#enviar").css("display","block")

	}

}


function buscar_limpiarV3(tipo,codigoBarra){
		codigoBarra = typeof codigoBarra !== 'undefined' ?  codigoBarra : 1;	

		$('#myModal').modal('hide');

		 if (tipo==1){
		 	cargarArchivo('contenido','contenedor/etiquetado/frm_GenerarPalet.php')
		 }
		 else if(tipo==2){
		 	cargarArchivo('contenido','contenedor/etiquetado/frm_GestinarPalet.php?codigoBarra='+codigoBarra)
		 }
}

function enviar_paginadorE(pagina,TipoProc){//Paginador Asistencia Horas No Laborables
	divResultado = document.getElementById('resultadoDet');
	ajax=nuevoAjax();
	ajax.open("POST","contenedor/etiquetado/tabla_PaletGenerados.php",true);
	ajax.onreadystatechange=function() {
		
		if (ajax.readyState==4) {
			divResultado.innerHTML = ajax.responseText;	
			
		}

	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("pagina="+pagina+"&TipoProc="+TipoProc);

}


function cargarTablaPR(divcambio2){
	divResultado2 = document.getElementById(divcambio2);
	TipoProc = document.getElementById("TipoProc").value;
	ajax=nuevoAjax();
	ajax.open("POST","contenedor/etiquetado/tabla_PaletGenerados.php",true);	ajax.onreadystatechange=function() {
		
		if (ajax.readyState==4) {
			divResultado2.innerHTML = ajax.responseText;
			if (TipoProc==0) {
			document.getElementById('registro').innerHTML = 'Registro de Palet';

			}
			else{
			document.getElementById('registro').innerHTML = 'Registro de Ruma';

			}
		}
	}

	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("TipoProc="+TipoProc+"&pagina=1")


}

/*=============================================
REGISTRO DE PALET
=============================================*/

function RegistrarPalets(tipo,idPalet){
	divResultado = document.getElementById('resultadoDet');
	CantidadPalet = document.R_Palets.CapacidadPaletMax.value;
	NomPalet = document.R_Palets.NomPalet.value;
	CodUsuario = document.R_Palets.CodUsuario.value;
	NumeroPaginaId = document.getElementById("NumeroPaginaId").innerHTML;
	TipoProc = document.getElementById("TipoProc").value;
	accion = "EnviarPalet"
	if ((tipo==0) && (TipoProc==0)){
	var Message2 = 'Se Registro el Palet.';
	}
	else if ((tipo==0) && (TipoProc==1)){
	var Message2 = 'Ruma Registrada.';
	}
	else if ((tipo==1) && (TipoProc==1)){
	var Message2 = 'Ruma Eliminada.';	
	}
	else{
		var Message2 = 'Palet eliminado!';
	}

	ajax = nuevoAjax(); 
	ajax.open("POST", "contenedor/ejecutarForm/ejecutar_RegistroPalet.php",true);
	ajax.onreadystatechange=function() {

		if (ajax.readyState==4) {
		divResultado.innerHTML = ajax.responseText;
		var sw = document.getElementById("sw").innerHTML;
		if(sw==1){
		swal("! Exito !", Message2 , "success");
		document.R_Palets.NomPalet.value = "";
		}
		else if (sw==2){
		swal("Ocurrió un error en el registro!", "Llamar al área de sistemas!", "error");	
		}

		}

	}

	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("accion="+accion+"&CantidadPalet="+CantidadPalet+"&CodUsuario="+CodUsuario+"&pagina="+NumeroPaginaId+"&tipo="+tipo+"&idPalet="+idPalet+"&TipoProc="+TipoProc+"&NomPalet="+NomPalet);


}

//Registro de cajas a Palet

function enviar_CajasPaletCB(){
	divResultado = document.getElementById('resultadoDetCajas');
    codigoBarra = document.getElementById("codigoBarras").value;
    idPalet = document.getElementById("idPalet").value;
    idaccion = document.getElementById("idaccion").value;
    CodUsuario = document.getElementById("CodUsuario").value;
    if ((idaccion==0) || (idaccion==1)){
    	accion = "EnviarCaja"
    }
    else if (idaccion==7) 
    {
    	accion = "EnviarCajasPalet"
    }
    else
    {
    	accion = "EnviarRuma"
    }
	ajax = nuevoAjax(); 
	ajax.open("POST", "contenedor/ejecutarForm/ejecutar_RegistroPalet.php",true);
	ajax.onreadystatechange=function() {

		if (ajax.readyState==4) {
		divResultado.innerHTML = ajax.responseText;
		var sw = document.getElementById("sw2").innerHTML;

		if (idaccion!= 7) {
		var CodCaja = document.getElementById("CodCaja").innerHTML;
		var CodDetalle = document.getElementById("CodDetalle").innerHTML;
		}
		if (idaccion==0) {
		var Message2 = 'Caja Registrada.'; 
		var tip = 0 ;
		}
		else if (idaccion==4) {
		var Message2 = 'Ruma Registrada.'; 
		var tip = 4 ;
		}
		else if (idaccion==6) {
		var Message2 = 'Ruma Eliminada'; 	
		}
		else if (idaccion==7) {
		var Message2 = 'Cajas Trasladadas'; 
		var tip = 7 ;	
		}
		else{
		var Message2 = 'Caja Eliminada del palet'; 
		}

		if(sw==1){

			if (tip==0) {
			document.getElementById('Exito').innerHTML = 'Caja Registrada';
			$("#Exito").fadeTo(2000, 500).slideUp(500, function(){
	       	$("#Exito").slideUp(500);});
			}
			else if (tip==4) {
			document.getElementById('Exito').innerHTML = 'Ruma Registrada';
			$("#Exito").fadeTo(2000, 500).slideUp(500, function(){
	       	$("#Exito").slideUp(500);});
			}
			else if (tip==7) {
			document.getElementById('Exito').innerHTML = 'Cajas Trasladadas';
			$("#Exito").fadeTo(2000, 500).slideUp(500, function(){
	       	$("#Exito").slideUp(500);});
			}
			else{
				swal("! Exito !",Message2, "success");
			}

		$("#enviar").css("display","block")
		$("#eliminar").css("display","block")
		}
		else if (sw==2){
		swal("Ocurrió un error en el registro!", "Llamar al área de sistemas!", "error");	
		}
		else if (sw==3){
		swal("! Verificar !", "¡Error! no existe Caja Proyectada", "error");		
		}
		else if (sw==4){
		swal("! Verificar !", '¡Error! Caja ya esta registrada en el palet' , "error");		
		}
		else if ((sw==5) || (sw==9)){
		// swal("! Verificar !", '¡Error! Caja registrada en palet '+ CodPalet , "error");	

		accionTraspasoCaja(idaccion,CodCaja,idPalet,CodUsuario,CodDetalle)

		}
		else if (sw==6){
		swal("! Verificar !", '¡Error! No existe caja a eliminar' , "error");		
		}
		else if (sw==7){
		swal("! Verificar !", '¡Error! el Palet esta Completo' , "error");		
		}
		else if (sw==8){
		swal("! Verificar !", '¡Error! no existe Ruma' , "error");		
		}
		else if (sw==10){
		swal("! Verificar !", '¡Error! Ruma ya esta registrada en el palet ', "error");		
		}
		else if (sw==11){
		swal("! Verificar !", '¡Error! No hay cajas en la ruma ', "error");		
		}
		else if (sw==12){
		swal("! Verificar !", '¡Error! No existe ruma a eliminar ', "error");		
		}
		else if (sw==13){
		swal("! Verificar !", '¡Error! La caja se encuentra en un palet cerrado ', "error");		
		}
		else if (sw==14){
		swal("! Verificar !", '¡Error! No puede Trasladar el mismo Palet', "error");		
		}
		else if (sw==15){
		swal("! Verificar !", '¡Error! Palet no existe', "error");		
		}
		else if (sw==16){
		swal("! Verificar !", '¡Error! Palet Vació', "error");		
		}

		}
		document.getElementById("codigoBarras").value = '';

	}

	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("accion="+accion+"&codigoBarra="+codigoBarra+"&idPalet="+idPalet+"&idaccion="+idaccion+"&CodUsuario="+CodUsuario);
}

function accionTraspasoCaja(idaccion,CodCaja,idPalet,CodUsuario,CodDetalle){
			if(idaccion==0){
	title_r= "Traslado !";
    text_r= "Desea realizar el traslado de la Caja " + CodCaja;	
	}
	else if (idaccion==4) {
	title_r= "Traslado !";
    text_r= "Desea realizar el traslado de la Ruma " + CodCaja;	
	}

		swal({
				title: title_r,
				text: text_r,
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
				divResultado = document.getElementById('resultadoDetCajas'); 
				var accion = "traslado";
				ajax = nuevoAjax();
				ajax.open("POST", "contenedor/ejecutarForm/ejecutar_RegistroPalet.php",true);
				ajax.onreadystatechange=function() {
				if (ajax.readyState==4) {
					// cuando se termina de cargar
				divResultado.innerHTML = ajax.responseText;
				var sw = document.getElementById("sw").innerHTML;
				if(sw==1){
				swal("! Exito !",'Se traslado caja', "success");
				}
				else if (sw==2){
				swal("! Error !",'Llamar al área de sistemas!', "fail");	
				}

			
				}
				}
				ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
				ajax.send("accion="+accion+"&CodCaja="+CodCaja+"&idPalet="+idPalet+"&CodUsuario="+CodUsuario+"&CodDetalle="+CodDetalle)
				
				
				}, 100);
				document.getElementById("codigoBarras").focus();
				} else {

				swal("Usted Cancelo la operación!", "No se realizó ningún cambio", "error");

				}
				});
}


function CerrarPalet(tipo,tipoproc){
	if (tipo==1) {
	divResultado = document.getElementById('divResultado');
	}
	else if (tipo==2) {
	divResultado = document.getElementById('divResultadoBusqueda');
	}
	
	idPalet = document.getElementById("idPalet").value;
	CodUsuario = document.getElementById("CodUsuario").value;
	accion = "CerrarPalet"
	ajax = nuevoAjax(); 
	ajax.open("POST", "contenedor/ejecutarForm/ejecutar_RegistroPalet.php",true);
	ajax.onreadystatechange=function() {

		if (ajax.readyState==4) {
		divResultado.innerHTML = ajax.responseText;
		var sw = document.getElementById("sw").innerHTML;
		if(sw==1){
		swal("! Exito !", "Se Cerro el Palet ", "success");
		$('#myModal').modal('hide');
		}
		else if (sw==2){
		swal("Ocurrió un error en el registro!", "Llamar al área de sistemas!", "error");	
		}

		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("accion="+accion+"&idPalet="+idPalet+"&CodUsuario="+CodUsuario+"&tipo="+tipo+"&tipoproc="+tipoproc);


}

function Buscar(tipo){
	divResultado = document.getElementById('divResultadoBusqueda');
	if (tipo == 1) {codigoBarras = document.getElementById("codigoBarrasP").value;}
    else{ codigoBarras = document.getElementById("codigoBarrasC").value;}
    accion = "Buscar"
	ajax = nuevoAjax(); 
	ajax.open("POST", "contenedor/ejecutarForm/ejecutar_RegistroPalet.php",true);
	ajax.onreadystatechange=function() {

		if (ajax.readyState==4) {
		divResultado.innerHTML = ajax.responseText;


	    $('#Exito').fadeIn(1000);setTimeout(function() { 
        $('#Exito').fadeOut(1000);}, 3000);

		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("accion="+accion+"&codigoBarras="+codigoBarras+"&tipo="+tipo);

}

function Trazabilidad(){
	divResultado = document.getElementById('divResultadoBusqueda');
	codigoBarras = document.getElementById("codigoBarrasC").value;
    accion = "Trazabilidad"
	ajax = nuevoAjax(); 
	ajax.open("POST", "contenedor/ejecutarForm/ejecutar_RegistroPalet.php",true);
	ajax.onreadystatechange=function() {

		if (ajax.readyState==4) {
		divResultado.innerHTML = ajax.responseText;


	    $('#Exito').fadeIn(1000);setTimeout(function() { 
        $('#Exito').fadeOut(1000);}, 3000);

		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("accion="+accion+"&codigoBarras="+codigoBarras);

}

function MostrarDetalle(Palet,numcjas){
	divResultado = document.getElementById('ResDetalle');
	accion = "VerDetallePalet"
	ajax = nuevoAjax(); 
	ajax.open("POST", "contenedor/ejecutarForm/ejecutar_RegistroPalet.php",true);
	ajax.onreadystatechange=function() {

		if (ajax.readyState==4) {
		divResultado.innerHTML = ajax.responseText;


		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("accion="+accion+"&Palet="+Palet+"&numcjas="+numcjas);

}