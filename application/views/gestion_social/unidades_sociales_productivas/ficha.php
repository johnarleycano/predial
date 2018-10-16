<input type="hidden" id="id_registro">
<input type="hidden" id="ficha_registro">

<ul id="navigation">
	<?php
	// if(isset($permisos['Bit&aacute;cora']['Consultar'])) { ?><li><a onclick="javascript:generar_unidad_social_productiva()" style="cursor: pointer;" title="Formato 13"><img src="<?php echo base_url('img/excel.png'); ?>"></a></li><?php // } ?>
</ul>

<div>
	<?php
	// Arreglo
	$valores_f = array();

	// se recorren los valores de checks
	foreach ($valores_fichas as $valor_ficha) {
		array_push($valores_f, $valor_ficha->id_valor_social);
	}

	// Si trae id
	if ($id != "0") {
		echo form_label('Ficha predial:&nbsp;&nbsp;&nbsp;','ficha');
		echo form_input('ficha', $usp->ficha_predial, 'readonly');
	} else {
		?>
		<!-- Unidad funcional -->
		<label for="unidad_funcional">Unidad funcional</label>
		<select id="unidad_funcional" class="form-control">
            <option value="0"></option>

            <!-- Se recorren las unidades funcionales -->
            <?php foreach ($this->PrediosDAO->obtener_unidades_funcionales() as $unidad) { ?>
                <option value="<?php echo $unidad->Nombre; ?>"><?php echo $unidad->Nombre; ?></option>
            <?php } ?>
        </select>

		<!-- Número de ficha -->
		<label for="unidad_funcional">Ficha</label>
		<select id="numero_ficha">
			<option value="0">Seleccione una unidad funcional</option>
		</select>
	<?php } ?>

	<div class="clear">&nbsp;</div>
	<div id="accordion">
		<!-- seccion 1 -->
		<h3><a href="#seccion1">UNIDAD SOCIAL PRODUCTIVA - IDENTIFICACIÓN</a></h3>
		<div>
			<!-- Datos generales -->
			<?php echo form_fieldset('<b>Datos generales</b>'); ?>
			<table style="text-align:'left'" width="100%">
				<?php
				$_relacion = array(' ' => ' ');
				foreach($this->Gestion_socialDAO->cargar_valores_ficha(7) as $relacion):
					$_relacion[$relacion->id] = $relacion->nombre;
				endforeach;

				$_ocupacion = array(' ' => ' ');
				foreach($this->Gestion_socialDAO->cargar_valores_ficha(9) as $ocupacion):
					$_ocupacion[$ocupacion->id] = $ocupacion->nombre;
				endforeach;
				?>

				<tbody>
					<tr>
						<td width="30%"><?php echo form_label('Relaci&oacute;n con el inmueble','relacion_inmueble'); ?></td>
						<td width="20%"><?php echo form_dropdown('relacion_inmueble', $_relacion, (isset($usp->relacion_inmueble)) ? utf8_decode($usp->relacion_inmueble) : ""); ?></td>
						<td width="30%"><?php echo form_label('Titular','titular'); ?></td>
						<td width="20%"><?php echo form_input('titular', (isset($usp->titular)) ? utf8_decode($usp->titular) : ""); ?></td>
					</tr>
					<tr>
						<td width="30%"><?php echo form_label('Identificaci&oacute;n','identificacion'); ?></td>
						<td width="10%"><?php echo form_input('identificacion', (isset($usp->identificacion)) ? utf8_decode($usp->identificacion) : ""); ?></td>
						<td width="30%"><?php echo form_label('Datos de verificaci&oacute;n','datos_verificacion'); ?></td>
						<td width="10%"><?php echo form_input('datos_verificacion', (isset($usp->datos_verificacion)) ? utf8_decode($usp->datos_verificacion) : ""); ?></td>
					</tr>
					<tr>
						<td width="30%"><?php echo form_label('Nombre o razón social','razon_social'); ?></td>
						<td width="10%"><?php echo form_input('razon_social', (isset($usp->razon_social)) ? utf8_decode($usp->razon_social) : ""); ?></td>
						<td width="30%"><?php echo form_label('NIT','nit'); ?></td>
						<td width="10%"><?php echo form_input('nit', (isset($usp->nit)) ? utf8_decode($usp->nit) : ""); ?></td>
					</tr>
					<tr>
						<td width="30%"><?php echo form_label('Descripción actividad','descripcion_actividad'); ?></td>
						<td width="10%"><?php echo form_input('descripcion_actividad', (isset($usp->descripcion_actividad)) ? utf8_decode($usp->descripcion_actividad) : ""); ?></td>
						<td width="30%"><?php echo form_label('Tiempo de desarrollo actividad (años)','antiguedad'); ?></td>
						<td width="10%"><?php echo form_input('antiguedad', (isset($usp->antiguedad)) ? utf8_decode($usp->antiguedad) : ""); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Canon arrendamiento','canon'); ?></td>
						<td width="30%"><?php echo form_input('canon', (isset($usp->canon)) ? utf8_decode($usp->canon) : ""); ?></td>
						<td width="40%"><?php echo form_label('Vencimiento contrato','fecha_vencimiento_contrato'); ?></td>
						<td width="10%"><?php echo form_input('fecha_vencimiento_contrato', (isset($usp->fecha_vencimiento_contrato)) ? utf8_decode($usp->fecha_vencimiento_contrato) : ""); ?></td>
					</tr>
					<tr>
						<td width="40%"><?php echo form_label('¿Lleva contabilidad?','lleva_contabilidad'); ?></td>
						<td width="10%"><?php echo form_dropdown('lleva_contabilidad', array('' => ' ', '1' => 'Si', '0' => 'No'), (isset($usp->lleva_contabilidad)) ? utf8_decode($usp->lleva_contabilidad) : ""); ?></td>
						<td width="20%"><?php echo form_label('¿Cuál?','contabilidad'); ?></td>
						<td width="30%"><?php echo form_input('contabilidad', (isset($usp->contabilidad)) ? utf8_decode($usp->contabilidad) : ""); ?></td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>

			<!-- Documentos para el desarrollo de la actividad -->
			<?php echo form_fieldset('<b>Documentos para el desarrollo de la actividad</b>'); ?>
			<table style="text-align:'left'" width="100%">
				<tbody>
					<tr>
						<?php
						// Contador
						$cont = 1;

						// Recorrido de los valores
						foreach ($this->Gestion_socialDAO->cargar_valores_ficha(10) as $valor10) {
							?>
							<?php if(in_array($valor10->id, $valores_f)) {$check = "checked";} else {$check = "";} ?>
							<td><input type="checkbox" value="<?php echo $valor10->id; ?>" id="<?php echo $valor10->id; ?>" name="valor[]" <?php echo $check; ?> /><label for="<?php echo $valor10->id; ?>"><?php echo $valor10->nombre; ?></label></td>

							<?php
							// Si ajusta las tres celdas
							if ($cont%3 == 0) {
								// Se cierra una fila y se abre otra
								echo "</tr><tr>";
							} // if

							// Aumento de contador
							$cont++;
						} // foreach
					?>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>

			<table style="text-align:'left'" width="100%">
				<tbody>
					<tr>
						<td width="20%"><?php echo form_label('Utilidades netas mensuales','utilidades_netas'); ?></td>
						<td width="30%"><?php echo form_input('utilidades_netas', (isset($usp->utilidades_netas)) ? utf8_decode($usp->utilidades_netas) : ""); ?></td>
					</tr>
					<tr>
						<td width="40%"><?php echo form_label('¿Continúaría actividad?','continua_actividad'); ?></td>
						<td width="10%"><?php echo form_dropdown('continua_actividad', array('' => ' ', '1' => 'Si', '0' => 'No'), (isset($usp->continua_actividad)) ? utf8_decode($usp->continua_actividad) : ""); ?></td>
						<td width="20%"><?php echo form_label('¿Por qué?','continua_actividad_razon'); ?></td>
						<td width="30%"><?php echo form_input('continua_actividad_razon', (isset($usp->continua_actividad_razon)) ? utf8_decode($usp->continua_actividad_razon) : ""); ?></td>
					</tr>
				</tbody>
			</table>
		</div>

		<!-- seccion 2 -->
		<h3><a href="#seccion2">ARRENDADORES</a></h3>
		<div>
			<!-- Datos generales -->
			<?php echo form_fieldset('<b>Datos generales</b>'); ?>
			<table style="text-align:'left'" width="100%">
				<tbody>
					<tr>
						<td width="20%"><?php echo form_label('Arrendador','nombre_arrendador'); ?></td>
						<td width="30%"><?php echo form_input('nombre_arrendador', (isset($usp->nombre_arrendador)) ? utf8_decode($usp->nombre_arrendador) : ""); ?></td>
						<td width="20%"><?php echo form_label('Identificación','identificacion_arrendador'); ?></td>
						<td width="30%"><?php echo form_input('identificacion_arrendador', (isset($usp->identificacion_arrendador)) ? utf8_decode($usp->identificacion_arrendador) : ""); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Datos de contacto','datos_contacto'); ?></td>
						<td width="30%"><?php echo form_input('datos_contacto', (isset($usp->datos_contacto)) ? utf8_decode($usp->datos_contacto) : ""); ?></td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>

			<?php
			// Se recorre para generar los campos de integrantes
			for ($i=1; $i <= 5; $i++) {
				// Contratos de arrendamiento y ejecución
				echo form_fieldset("<b>Arrendatario $i</b>");
				$cont = 1;
			?>
				<table style="text-align:'left'" width="100%">
					<tbody>
						<tr>
							<td width="10%"><?php echo form_label('Nombre','nombre_arrendatario'.$i); ?></td>
							<td width="20%"><?php echo form_input('nombre_arrendatario'.$i); ?></td>
							<td width="10%"><?php echo form_label('Objeto del contrato','objeto_contrato'.$i); ?></td>
							<td width="20%"><?php echo form_input('objeto_contrato'.$i); ?></td>
							<td width="10%"><?php echo form_label('Suscripción','fecha_suscripcion'.$i); ?></td>
							<td width="20%"><?php echo form_input('fecha_suscripcion'.$i); ?></td>
						</tr>
						<tr>
							<td width="10%"><?php echo form_label('Terminación','fecha_terminacion'.$i); ?></td>
							<td width="20%"><?php echo form_input('fecha_terminacion'.$i); ?></td>
							<td width="10%"><?php echo form_label('Valor canon mensual','valor_canon_mensual'.$i); ?></td>
							<td width="20%"><?php echo form_input('valor_canon_mensual'.$i); ?></td>
							<td width="10%"><?php echo form_label('Valor terminación anticipada','valor_terminacion_anticipada'.$i); ?></td>
							<td width="20%"><?php echo form_input('valor_terminacion_anticipada'.$i); ?></td>
						</tr>
					</tbody>
				</table>
			<?php
				echo form_fieldset_close();
			} // for
			?>
		</div>

		<!-- seccion 3 -->
		<h3><a href="#seccion3">DIAGNÓSTICO SOCIOECONÓMICO</a></h3>
		<div id="diagnostico">

		</div>
	</div>

	<br /><input type="hidden" id="errores" />
	<div class="clear">&nbsp;</div>
	<input type="hidden" id="boton_hidden" name="boton_hidden" value="" />

	<?php
		$guardar = array(
			'type' => 'button',
			'name' => 'guardar',
			'id' => 'guardar',
			'value' => 'Guardar y volver'
		);
		echo form_input($guardar);
	?>
</div>

<!-- Si hay ficha predial -->
<?php if (isset($usp->ficha_predial)) {
?>
	<script type="text/javascript">
		$(document).ready(function(){
			// Se guardan los cambios en la ficha social
        	$.ajax({
		        url: "<?php echo site_url('gestion_social_controller/cargar_unidad_social_productiva'); ?>",
		        data: {"id": "<?php echo $id; ?>"},
		        type: "POST",
		        dataType: "JSON",
		        async: false,
		        success: function(respuesta){
		           return datos = respuesta;
		        }//Success
		    });//Ajax
        	// console.log(datos);

        	// Se alimentan los campos si tienen información
			for (i = 1; i <= 5; i++) {
        		$("input[name='nombre_arrendatario" + i + "']").val(datos["nombre_arrendatario" + i]);
        		$("input[name='objeto_contrato" + i + "']").val(datos["objeto_contrato" + i]);
        		$("input[name='fecha_suscripcion" + i + "']").val(datos["fecha_suscripcion" + i]);
        		$("input[name='fecha_terminacion" + i + "']").val(datos["fecha_terminacion" + i]);
        		$("input[name='valor_canon_mensual" + i + "']").val(datos["valor_canon_mensual" + i]);
        		$("input[name='valor_terminacion_anticipada" + i + "']").val(datos["valor_terminacion_anticipada" + i]);
			} // for
		});
	</script>
<?php
} // if
?>

<script type="text/javascript">
	$(document).ready(function(){
		// llamado a la vista diagnostico socioeconomico
		var id = "<?php echo $id; ?>";
		var ficha = $("input[name=ficha]");
		var datos = {ficha: ficha.val(), tipo: 'id_usp', id:id};

		// $.get("<?php // echo site_url('gestion_social_controller/diagnostico_social'); ?>", datos, function(vista){
		// 	$("#diagnostico").html(vista);
		// });
		$("#diagnostico").load("<?php echo site_url('gestion_social_controller/diagnostico_social'); ?>", datos)

		$( "#accordion" ).accordion
		({
			autoHeight: false,
			navigation: true
		});

		$('#form input[name^=fecha]').datepicker();

		$('#navigation > li').hover(
            function () {
                $('a',$(this)).stop().animate({'marginLeft':'2px'},200);
            },
            function () {
                $('a',$(this)).stop().animate({'marginLeft':'85px'},200);
            }
        );

        //esta sentencia es para darle el estilo a los botones jquery.ui
	    $( "#form input[type=submit], #form input[type=button]").button();

	    // Cuando se elija una unidad funcional
	    $("#unidad_funcional").on("change", function(){
	    	// Si se elige una unidad funcional
	    	if ($(this).val() != "0") {
    			// Se carga los predios de esa unidad funcional
		    	$.ajax({
			        url: "<?php echo site_url('gestion_social_controller/cargar_fichas_semaforo'); ?>",
			        data: {"unidad_funcional": $(this).val()},
			        type: "POST",
			        dataType: "JSON",
			        async: false,
			        success: function(respuesta){
			            return fichas = respuesta;
			            // console.log(respuesta)
			        }//Success
			    });//Ajax

			    // Se resetea el select
			    $("#numero_ficha").html("");

			    // Se recorren las fichas
			    $.each(fichas, function(key, val){
	                //Se agrega cada entidad al select
	                $("#numero_ficha").append("<option value='" + val.ficha_predial + "'>" + val.Numero + "</option>");
	            })//Fin each
	    	} else {
	    		// Se resetea el select
	    		$("#numero_ficha").html("").append("<option value='0'>Seleccione una unidad funcional</option>");
	    	}
	    });

	    //este script genera el evento clic del boton Guardar y Salir
		$('#form input[name=guardar], #form input[name=continuar]').click(function(){
			// Recolección de datos
        	var relacion_inmueble = $("select[name=relacion_inmueble]");
        	var titular = $("input[name=titular]");
        	var identificacion = $("input[name=identificacion]");
        	var datos_verificacion = $("input[name=datos_verificacion]");
        	var razon_social = $("input[name=razon_social]");
        	var nit = $("input[name=nit]");
        	var descripcion_actividad = $("input[name=descripcion_actividad]");
        	var antiguedad = $("input[name=antiguedad]");
        	var canon = $("input[name=canon]");
        	var fecha_vencimiento_contrato = $("input[name=fecha_vencimiento_contrato]");
        	var lleva_contabilidad = $("select[name=lleva_contabilidad]");
        	var contabilidad = $("input[name=contabilidad]");
        	var utilidades_netas = $("input[name=utilidades_netas]");
        	var continua_actividad = $("select[name=continua_actividad]");
        	var continua_actividad_razon = $("input[name=continua_actividad_razon]");
        	var nombre_arrendador = $("input[name=nombre_arrendador]");
        	var identificacion_arrendador = $("input[name=identificacion_arrendador]");
        	var datos_contacto = $("input[name=datos_contacto]");

        	// Arreglo con los datos a enviar
        	var datos = {
        		"relacion_inmueble": relacion_inmueble.val(),
        		"titular": titular.val(),
        		"identificacion": identificacion.val(),
        		"datos_verificacion": datos_verificacion.val(),
        		"razon_social": razon_social.val(),
        		"nit": nit.val(),
        		"descripcion_actividad": descripcion_actividad.val(),
        		"antiguedad": antiguedad.val(),
        		"canon": canon.val(),
        		"fecha_vencimiento_contrato": fecha_vencimiento_contrato.val(),
        		"lleva_contabilidad": lleva_contabilidad.val(),
        		"contabilidad": contabilidad.val(),
        		"utilidades_netas": utilidades_netas.val(),
        		"continua_actividad": continua_actividad.val(),
        		"continua_actividad_razon": continua_actividad_razon.val(),
        		"nombre_arrendador": nombre_arrendador.val(),
        		"identificacion_arrendador": identificacion_arrendador.val(),
        		"datos_contacto": datos_contacto.val(),
        	}
        	// console.log(datos);

        	// Recorrido de los arrendatarios
        	for (i = 1; i <= 5; i++) {
        		// Se agregan al arreglo
        		datos['nombre_arrendatario' + i]  = $("input[name=nombre_arrendatario" + i + "]").val();
        		datos['objeto_contrato' + i]  = $("input[name=objeto_contrato" + i + "]").val();
        		datos['fecha_suscripcion' + i]  = $("input[name=fecha_suscripcion" + i + "]").val();
        		datos['fecha_terminacion' + i]  = $("input[name=fecha_terminacion" + i + "]").val();
        		datos['valor_canon_mensual' + i]  = $("input[name=valor_canon_mensual" + i + "]").val();
        		datos['valor_terminacion_anticipada' + i]  = $("input[name=valor_terminacion_anticipada" + i + "]").val();
			}

			// Si es una Unidad Social existente
    		if (id > 0) {
    			// Agregar datos
    			datos["ficha_predial"] = ficha.val();

    			// url para modificar
    			url = "<?php echo site_url('gestion_social_controller/actualizar_usp'); ?>";
    		} else {
    			// Si no tiene seleccionada una ficha
    			if ($("#numero_ficha").val() == "0") {
    				alert("Seleccione primero una ficha predial");

    				return false;
    			}
    			datos["ficha_predial"] = $("#numero_ficha").val();

    			// // url para crear
    			url = "<?php echo site_url('gestion_social_controller/insertar_usp'); ?>";
    		}

    		var id_registro = ajax(url, {"id": id, "datos": datos}, "HTML")
    		
    		$("#id_registro").val(id_registro)
    		$("#ficha_registro").val(datos.ficha_predial)
    		
        	// Arreglo vacío
            var valores = new Array();

            // Se recorren los checks
        	$("input[name='valor[]']").each(function(){
        		// Si está chequeado
                if ($(this).is(':checked')) {
	        		// Se agrega el check al arreglo
	                valores.push($(this).val());
                };
        	});
        	// console.log(valores)

        	// Se guardan los valores para la ficha
        	$.ajax({
		        url: "<?php echo site_url('gestion_social_controller/insertar_valores_ficha'); ?>",
		        data: {"ficha": datos.ficha_predial, "datos": valores, "id_unidad_social": id},
		        type: "POST",
		        dataType: "html",
		        async: false,
		        success: function(respuesta){
		            //Si la respuesta no es error
		            if(respuesta){
		                //Se almacena la respuesta como variable de éxito
		                // exito = respuesta;
		                console.log(respuesta);
		            } else {
		                //La variable de éxito será un mensaje de error
		                // exito = 'error';
		                console.log(respuesta);
		            } //If
		        }
		    });//Ajax

        	location.href= "<?php echo site_url('gestion_social_controller/unidades_sociales_productivas'); ?>";
		})
	})
</script>
