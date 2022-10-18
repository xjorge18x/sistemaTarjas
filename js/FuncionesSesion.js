

function GetDetalleBatch() {
	let count =0
	let timer = setInterval(()=>{ 
	divResultado = document.getElementById('Tabla1');
	if (document.querySelector('#Tabla1')){
	accion = "Dash"
	ajax=nuevoAjax();
	ajax.open("POST", "contenedor/ejecutarForm/Ejecutar_Procesos02.php",true)
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			divResultado.innerHTML = ajax.responseText;	
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("accion="+accion);
	count = count +1
	// console.log(count)
	}else {
    clearInterval(timer);
  	}
	}, 5000);

}
async function GetDetalleBatchOn(){
	await GetDetalleBatch()
}

if (document.querySelector('#divResultadoRegistros')) { GetDetalleBatchOn();}