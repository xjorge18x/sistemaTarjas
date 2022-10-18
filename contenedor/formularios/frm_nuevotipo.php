
<!-- MODAL PARA NUEVO TIPO DE SALIDA -->
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Nuevo tipo de Salida</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true" style="font-size: 2.5rem;">&times;</span>
</button>
</div>
    <div class="modal-body">

    <form method="POST" name="ResitrarNuevoTipo" id="ResitrarNuevoTipo" onchange="tipoSalida(2); return false">
    <div class="form-group">
    <label for="recipient-name" class="col-form-label">Nombre:</label>
    <input type="text" class="form-control" id="NombreTipo" name="NombreTipo"  required="">
    </div>
    </form> 

    </div>
<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="">Guardar</button>
</div>
