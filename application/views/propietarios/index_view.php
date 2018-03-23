<?php $permisos = $this->session->userdata('permisos'); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<!-- Contenedor de Modal editar-->
<div id="cont_modal"></div>
<div id="form">
	<?php echo form_fieldset("<b>Propietarios</b>"); ?>
		<table id="tabla" style='width:100%'>
			<thead>
				<tr>
					<th>Tipo Documento</th>
					<th>Número de Documento</th>
					<th>Nombre</th>
					<th>Teléfono</th>
					<th>Predios</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($propietarios as $propietario): ?>
					<tr>
						<td><?= $propietario->tipo_documento; ?></td>
						<td><?= $propietario->documento; ?></td>
						<td><?= $propietario->nombre; ?></td>
						<td><?= $propietario->telefono; ?></td>
						<td><?= $propietario->predios; ?></td>
						<td width="70px">
							<?php if (isset($permisos['Fichas']['Actualizar'])): ?>
								<img onclick="editar(<?= $propietario->id_propietario ?>)" style="cursor:pointer;" title="Actualizar" src="<?= base_url().'img/edit.png' ?>">
							<?php endif; ?>
							<img onclick="detalle(<?= $propietario->id_propietario ?>)" style="cursor:pointer;" title="Ver detalle" src="<?= base_url().'img/search.png' ?>">
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php echo form_fieldset_close(); ?>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#tabla').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"aaSorting": [[ 2, "asc" ]]
		});
	});

	function editar(id)
	{
		// Carga de interfaz
		cargar_interfaz("cont_modal", "<?= site_url('actualizar_controller/cargar_interfaz'); ?>", {"tipo": "propietarios_gestion", "id": id});
	} // editar

	function detalle(id)
	{
		// Carga de interfaz
		cargar_interfaz("principal", "<?= site_url('propietarios_controller/propietario'); ?>", {"tipo": "propietarios_gestion", "id": id});
	} // editar

	function guardar()
	{
		// Declaración de variables
		var id = $("#id_propietario").val();
	    var tipo_documento = $("select[name=tipo_documento]");
	    var documento = $("input[name=documento]");
	    var nombre = $("input[name=nombre]");
	    var telefono = $("input[name=telefono]");
        var direccion = $("input[name=direccion]");
        var email = $("input[name=email]");

	    //Datos a validar
	    var datos_obligatorios = new Array(
			tipo_documento.val(),
			documento.val(),
			nombre.val()
	    );

        var datos_numericos = new Array(
            documento.val()
        );
        //Se ejecuta la validación de los campos obligatorios
        var validacion = validar_campos_vacios(datos_obligatorios);

        var validacion_numerico = validar_campos_numericos(datos_numericos);

        //Si no supera la validacíón
        if (!validacion) {
            // Mensaje de advertencia
            $("#error").html('<div id="alerta" class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0px 0.7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>Llene los campos obligatorios</p></div>');
            return false;
        } // if

        //Si no supera la validacíón
        if (!validacion_numerico) {
            // Mensaje de advertencia
            $("#error").html('<div id="alerta" class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0px 0.7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>El número de documento y la participación no pueden llevar letras o caracteres especiales</p></div>');
            return false;
        } // if

	    // Arreglo de datos a guardar
	    var datos = {
            'ficha_predial': "<?= $ficha ?>",
	        'tipo_documento': tipo_documento.val(),
	        'documento': documento.val(),
	        'nombre': nombre.val(),
	        'telefono': telefono.val(),
	        'direccion': direccion.val(),
            'email': email.val(),
	    };

        ajax("<?= site_url('actualizar_controller/actualizar'); ?>", {"tipo": "propietario", "datos": datos, "id": id}, "html");

	    // Se cierra el modal
	    cerrar_modal();
		cargar_interfaz("principal", "<?= site_url('propietarios_controller/index'); ?>", {"tipo": "propietarios_gestion", "id": id});
	} // guardar

</script>
