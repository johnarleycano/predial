<div id="vista-archivos">
<script src="<?php echo base_url(); ?>js/ajaxupload.2.0.min.js"></script>
<div id="form">
	<?php
	// Permisos
	$permisos = $this->session->userdata('permisos');

	echo form_fieldset('<b>Gestor de archivos</b>');
	?>
	<div style="display:inline-block;" width="10%"><?php echo form_label('Fecha','fecha'); ?></div>
	<div style="display:inline-block;" width="20%"><?php echo form_input('fecha'); ?></div>
	<div style="display:inline-block;" width="10%"><?php echo form_label('Descripción','descripcion'); ?></div>
	<div style="display:inline-block;" width="20%"><?php echo form_input('descripcion'); ?></div>
	<?php
		if(isset($permisos['Archivos y Fotos']['Subir'])) {
			echo '<p><input type="file" id="btn_subir_certificado" class="btn_archivos"></p>';
		}
	?>
	<div id="error"></div>
</div>

<table id="tabla" style='width:100%'>
    <thead>
        <tr>
            <th>Nombre de archivo</th>
			<th>Fecha</th>
			<th width="20%">Formato</th>
            <th width="10%">Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($archivos as $archivo): ?>
            <tr>
                <td><?= $archivo->descripcion ?></td>
				<td><?= $archivo->fecha ?></td>
				<td><?= substr($archivo->archivo, -3) ?></td>
                <td align="right">
					<?php echo anchor_popup(base_url().$directorio."/".$archivo->archivo, '<img border="0" title="Ver" src="'.base_url().'img/search.png">', "'DESCRIPCION','resizable=no,location=no,menubar=no, scrollbars=yes,status=no,toolbar=no,fullscreen=no,d ependent=no,width=800,height=564,left=100,top=100' ))");?>
					<!-- Eliminar -->
					<?php if (isset($permisos['Archivos y Fotos']['Eliminar'])): ?>
						<a href="#">
							<img onCLick="javascript:eliminar_archivo('<?= $directorio.$archivo->archivo; ?>', '<?= $archivo->archivo; ?>')" alt="Eliminar foto" title="Eliminar foto" src="<?php echo base_url(); ?>img/delete.png" width="32px" align="right"><br>
						</a>
					<?php endif; ?>
				</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<div id="form">
	<?php
		if(isset($permisos['Archivos y Fotos']['Subir'])) {

			$volver = array(
				'type' => 'button',
				'name' => 'volver',
				'id' => 'volver',
				'value' => 'Volver'
			);
			echo "<br>".form_input($volver);

			$subir = array(
				'type' => 'submit',
				'name' => 'subir',
				'id' => 'subir',
				'value' => 'Subir'
			);
			// echo form_input($subir);

			echo form_close();
		}
	?>
</div>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript">

	function eliminar_archivo(url, nombre){
		//Variable de exito
	    var exito;

	    // Esta es la petición ajax que llevará
	    // a la interfaz los datos pedidos
	    $.ajax({
	        url: "<?php echo site_url('archivos_controller/eliminar_archivo_social'); ?>",
	        data: {"archivo": url, "nombre": nombre},
	        type: "POST",
	        dataType: "HTML",
	        async: false,
	        success: function(respuesta){
	            //Si la respuesta no es error
	            if(respuesta){
	                //Se almacena la respuesta como variable de éxito
	                exito = respuesta;
					var datos = {ficha:"<?= $ficha ?>", tipo: "<?= $tipo ?>", aux: true, id: "<?= $id ?>"};
					$.get("<?= site_url('archivos_controller/ver_archivos_social'); ?>", datos, function(vista){
						$("#vista-archivos").html(vista);
					});
	            } else {
	                //La variable de éxito será un mensaje de error
	                exito = "error";
	            } //If
	        },//Success
	        error: function(respuesta){
	            //Variable de exito será mensaje de error de ajax
	            exito = respuesta;
	        }//Error
	    });//Ajax
	}

	$('#form input[name=volver]').click(function(){
		window.location.href = window.location.href;
	});

	$(document).ready(function(){
		$('#tabla').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		});

		$('#form input[name^=fecha]').datepicker();

		// Declaración del arreglo
        var datos = {};

        //Se prepara la subida del archivo
        new AjaxUpload('#btn_subir_certificado', {
            action: '<?php echo site_url("archivos_controller/subir_archivos_social"); ?>',
            type: 'POST',
            data: datos,
            onSubmit : function(archivo , ext){
                // Se valida que tenga fecha y descripcion
                if ($("input[name=fecha]").val() == "" || $("input[name=descripcion]").val() == "") {
                	// Mensaje de advertencia
					$("#error").html('<div id="alerta" class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0px 0.7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>Tiene que especificar una fecha y una descripción</p></div>');
					return false;
                } // if

				if (!(ext && /^(pdf|PDF|jpg|JPG|jpeg|JPEG)$/.test(ext))){
                    //Se muestra el mensaje de error
					$("#error").html('<div id="alerta" class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0px 0.7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>Archivo no permitido</p></div>');
                    return false;
                } // if

                // Se arregan al arreglo JSON los datos a enviar
                datos['fecha'] = $("input[name=fecha]").val();
                datos['descripcion'] = $("input[name=descripcion]").val();
                datos['ficha'] = "<?= $ficha; ?>";
				datos['tipo'] = "<?= $tipo; ?>";
				datos['id'] = "<?= $id; ?>";
				console.log(datos);
				setTimeout(function () {
					var datos = {ficha:"<?php echo $ficha ?>", tipo: "<?php echo $tipo ?>", aux: true, id: "<?php echo $id ?>"};
					$.get("<?php echo site_url('archivos_controller/ver_archivos_social'); ?>", datos, function(vista){
						$("#vista-archivos").html(vista);
					});
				}, 1000);
            }, // onsubmit
            onComplete: function(archivo, respuesta) {
                if(respuesta == "existe") {
                    // Se muestra el mensaje de error
					$("#error").html('<div id="alerta" class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0px 0.7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>No se puede subir el certificado, Ya existe</p></div>');
					return false;
                } // if
                // Si la respuesta es un error
                if(respuesta == "error") {
					$("#error").html('<div id="alerta" class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0px 0.7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>No se pudo subir el certificado.</p></div>');
                } // if
            } // oncomplete
        }); // AjaxUpload
	});
</script>
</div>
