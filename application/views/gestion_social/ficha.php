<ul id="navigation">
	<?php // if(isset($permisos['Bit&aacute;cora']['Consultar'])) { ?><li><a onclick="javascript:generar_caracterizacion_general()" style="cursor: pointer;" title="Formato 12"><img src="<?php echo base_url('img/excel.png'); ?>"></a></li><?php // } ?>
</ul>

<div>
	<?php
	echo form_label('Ficha predial:&nbsp;&nbsp;&nbsp;','ficha');
	echo form_input('ficha', $predio->ficha_predial, 'readonly');

	// Arreglo
	$valores_f = array();

	// se recorren los valores de checks
	foreach ($valores_fichas as $valor_ficha) {
		array_push($valores_f, $valor_ficha->id_valor_social);
	}
	?>

	<div class="clear">&nbsp;</div>
	<div id="accordion">
		<!-- seccion 1 -->
		<h3><a href="#seccion1">CARACTERIZACI&Oacute;N GENERAL DEL INMUEBLE</a></h3>
		<div>
			<!-- Características del inmueble -->
			<?php echo form_fieldset('<b>Caracter&iacute;sticas del inmueble</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="40%"><?php echo form_label('Fecha levantamiento','fecha_levantamiento'); ?></td>
						<td width="10%"><?php echo form_input('fecha_levantamiento', (isset($ficha_social->fecha_levantamiento)) ? $ficha_social->fecha_levantamiento : ""); ?></td>
						<td width="40%"><?php echo form_label('Requerimiento del terreno','requerimiento_terreno'); ?></td>
						<td width="10%"><?php echo form_dropdown('requerimiento_terreno', array('' => '', '1' => 'Parcial', '2' => 'Total'), (isset($ficha_social->requerimiento_terreno)) ? $ficha_social->requerimiento_terreno : ""); ?></td>
					</tr>
					<tr>
						<td width="40%"><?php echo form_label('¿Se requieren edificaciones?','requerimiento_edificaciones'); ?></td>
						<td width="10%"><?php echo form_dropdown('requerimiento_edificaciones', array('' => ' ', '1' => 'Si', '0' => 'No'), (isset($ficha_social->requerimiento_edificaciones)) ? $ficha_social->requerimiento_edificaciones : ""); ?></td>
						<td width="40%"><?php echo form_label('¿El valor a adquirir es inferior a 3 SLMMV?','area_adquirir'); ?></td>
						<td width="10%"><?php echo form_dropdown('area_adquirir', array('' => ' ', '1' => 'Si', '0' => 'No'), (isset($ficha_social->area_adquirir)) ? $ficha_social->area_adquirir : ""); ?></td>
					</tr>
				</tbody>
			</table>
			<br>

			<b>Usos actuales del inmueble</b>
			<table style="text-align:'left'" width="100%">
				<tbody>
					<tr>
						<?php foreach ($this->Gestion_socialDAO->cargar_valores_ficha(1) as $valor1) { ?>
							<?php if(in_array($valor1->id, $valores_f)) {$check = "checked";} else {$check = "";} ?>
							<td><input type="checkbox" value="<?php echo $valor1->id; ?>" id="<?php echo $valor1->id; ?>" name="valor[]" <?php echo $check; ?> /><label for="<?php echo $valor1->id; ?>"><?php echo $valor1->nombre; ?></label></td>
						<?php } ?>

						<td><input type="text" name="otros_usos" placeholder="Otros" value="<?php (isset($ficha_social->otros_usos)) ? $ficha_social->otros_usos : ""; ?>" /></td>
					</tr>
				</tbody>
			</table>
			<br>

			<table style="text-align:'left'" width="100%">
				<tbody>
					<tr>
						<td width="50%"><?php echo form_label('¿Se puede restablecer uso actual en &aacute;rea no requerida?','restablecer_uso_area_no_requerida'); ?></td>
						<td width="10%"><?php echo form_dropdown('restablecer_uso_area_no_requerida', array('' => ' ', '1' => 'Si', '0' => 'No'), (isset($ficha_social->restablecer_uso_area_no_requerida)) ? $ficha_social->restablecer_uso_area_no_requerida : ""); ?></td>
						<td width="30%"><?php echo form_label('¿Existe vivienda?','existe_vivienda'); ?></td>
						<td width="10%"><?php echo form_dropdown('existe_vivienda', array('' => ' ', '1' => 'Si', '0' => 'No'), (isset($ficha_social->existe_vivienda)) ? $ficha_social->existe_vivienda : ""); ?></td>
					</tr>
					<tr>
						<td width="50%"><?php echo form_label('¿La vivienda se encuentra habitada?','vivienda_habitada'); ?></td>
						<td width="10%"><?php echo form_dropdown('vivienda_habitada', array(' ' => ' ', '1' => 'Si', '0' => 'No'), 
						(isset($ficha_social->vivienda_habitada)) ? $ficha_social->vivienda_habitada : ""); ?></td>
						<td width="30%"><?php echo form_label('Se requiere para el proyecto?','requerida_proyecto'); ?></td>
						<td width="10%"><?php echo form_dropdown('requerida_proyecto', array(' ' => ' ','0' => 'No',  '1' => 'Si', '2' => 'Parcial'), (isset($ficha_social->requerida_proyecto)) ? $ficha_social->requerida_proyecto : ""); ?></td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>

			<!-- Usos actuales del inmueble -->
			<?php echo form_fieldset('<b>Condiciones actuales</b>'); ?>
			<table style="text-align:'left'" width="100%">
				<tbody>
					<tr>
						<td><label class="form-label" for="distribucion_alcobas" style="width: 10%;">Alcobas</label></td>
						<td><input type="text" class="form-control" id="distribucion_alcobas" value="<?php if(isset($ficha_social->distribucion_alcobas)){echo $ficha_social->distribucion_alcobas;} ?>" style="width: 15%;"></td>

						<td><label class="form-label" for="distribucion_bano" style="width: 10%;">Baños</label></td>
						<td><input type="text" class="form-control" id="distribucion_bano" value="<?php if(isset($ficha_social->distribucion_bano)){echo $ficha_social->distribucion_bano;} ?>" style="width: 15%;"></td>

						<td><label class="form-label" for="distribucion_cocinas" style="width: 10%;">Cocinas</label></td>
						<td><input type="text" class="form-control" id="distribucion_cocinas" style="width: 15%;" value="<?php if(isset($ficha_social->distribucion_cocinas)){echo $ficha_social->distribucion_cocinas;} ?>" style="width: 25%;"></td>

						<td><label class="form-label" for="distribucion_comedor" style="width: 10%;">Comedor</label></td>
						<td><input type="text" class="form-control" id="distribucion_comedor" value="<?php if(isset($ficha_social->distribucion_comedor)){echo $ficha_social->distribucion_comedor;} ?>" style="width: 15%;"></td>

						<td width="15%"><label class="form-label" for="distribucion_sala" style="width: 10%;">Salas</label></td>
                        <td width="10%"><input type="text" class="form-control" id="distribucion_sala" value="<?php if(isset($ficha_social->distribucion_sala)){echo $ficha_social->distribucion_sala;} ?>" style="width: 15%;"></td>
					</tr>
				</tbody>
			</table>

			<table style="text-align:'left'" width="100%">
				<tbody>
					<tr>
						<td width="25%">
							<strong>Servicios b&aacute;sicos</strong><br>
							<?php foreach ($this->Gestion_socialDAO->cargar_valores_ficha(2) as $valor2) { ?>
								<?php if(in_array($valor2->id, $valores_f)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" value="<?php echo $valor2->id; ?>" id="<?php echo $valor2->id; ?>" name="valor[]" <?php echo $check; ?> /><label for="<?php echo $valor2->id; ?>"><?php echo $valor2->nombre; ?></label><br>
							<?php } ?>
						</td>
						<td width="25%">
							<strong>Paredes</strong><br>
							<?php foreach ($this->Gestion_socialDAO->cargar_valores_ficha(4) as $valor4) { ?>
								<?php if(in_array($valor4->id, $valores_f)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" value="<?php echo $valor4->id; ?>" id="<?php echo $valor4->id; ?>" name="valor[]" <?php echo $check; ?> /><label for="<?php echo $valor4->id; ?>"><?php echo $valor4->nombre; ?></label><br>
							<?php } ?>
						</td>
						<td width="25%">
							<strong>Pisos</strong><br>
							<?php foreach ($this->Gestion_socialDAO->cargar_valores_ficha(5) as $valor5) { ?>
								<?php if(in_array($valor5->id, $valores_f)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" value="<?php echo $valor5->id; ?>" id="<?php echo $valor5->id; ?>" name="valor[]" <?php echo $check; ?> /><label for="<?php echo $valor5->id; ?>"><?php echo $valor5->nombre; ?></label><br>
							<?php } ?>
						</td>
						<td width="25%">
							<strong>Techo</strong><br>
							<?php foreach ($this->Gestion_socialDAO->cargar_valores_ficha(6) as $valor6) { ?>
								<?php if(in_array($valor6->id, $valores_f)) {$check = "checked";} else {$check = "";} ?>
								<input type="checkbox" value="<?php echo $valor6->id; ?>" id="<?php echo $valor6->id; ?>" name="valor[]" <?php echo $check; ?> /><label for="<?php echo $valor6->id; ?>"><?php echo $valor6->nombre; ?></label><br>
							<?php } ?>
						</td>
					</tr>
				</tbody>
			</table>

			<table style="text-align:'left'" width="100%">
				<tbody>
					<tr>
						<td width="50%"><?php echo form_label('¿Existen edificaciones con infraesructura para actiidades productivas?','edificaciones_unidades_productivas'); ?></td>
						<td width="10%"><?php echo form_dropdown('edificaciones_unidades_productivas', array('' => ' ', '1' => 'Si', '0' => 'No'), (isset($ficha_social->edificaciones_unidades_productivas)) ? $ficha_social->edificaciones_unidades_productivas : ""); ?></td>
						<td width="10%"><?php echo form_label('¿Cuáles?','edificaciones_unidades_productivas_descripcion'); ?></td>
						<td width="20%"><?php echo form_input('edificaciones_unidades_productivas_descripcion', (isset($ficha_social->edificaciones_unidades_productivas_descripcion)) ? $ficha_social->edificaciones_unidades_productivas_descripcion : ""); ?></td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>

			<!-- Observaciones -->
			<?php echo form_fieldset('<b>Observaciones</b>'); ?>
			<div align="center">
				<?php echo form_label('Observaciones','observaciones')?><br>
				<?php echo form_textarea('observaciones', (isset($ficha_social->observaciones)) ? $ficha_social->observaciones : "");?>
			</div>
			<?php echo form_fieldset_close(); ?>
		</div>

		<!-- seccion 2 -->
		<h3><a href="#seccion2">DIAGN&Oacute;STICO SOCIOECON&Oacute;MICO</a></h3>
		<div id="diagnostico">

		</div>

		<!-- seccion 3 -->
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

		// $continuar = array(
		// 	'type' => 'button',
		// 	'name' => 'continuar',
		// 	'id' => 'continuar',
		// 	'value' => 'Guardar y continuar'
		// );
		// echo form_input($continuar);

		$salir = array(
			'type' => 'button',
			'name' => 'salir',
			'id' => 'salir',
			'value' => 'Cancelar y volver'
		);
		echo form_input($salir).'<br>';
?>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		// llamado a la vista diagnostico socioeconomico
		var ficha = $("input[name=ficha]");
		var datos = {
			ficha: ficha.val()
		};

		// $.get("<?php // echo site_url('gestion_social_controller/diagnostico_social'); ?>", datos, function(vista){
		// 	$("#diagnostico").html(vista);
		// });
		$("#diagnostico").load("<?php echo site_url('gestion_social_controller/diagnostico_social'); ?>", datos)

		//este script unido con jquery es el encargado de dar el estilo css a las secciones del formulario dinamicamente
		$( "#accordion" ).accordion
		({
			autoHeight: false,
			navigation: true
		});

		$('#navigation a').stop().animate({'marginLeft':'85px'},1000);

        $('#navigation > li').hover(
            function () {
                $('a',$(this)).stop().animate({'marginLeft':'2px'},200);
            },
            function () {
                $('a',$(this)).stop().animate({'marginLeft':'85px'},200);
            }
        );

		$('#form input[name^=fecha]').datepicker();

		//esta sentencia es para darle el estilo a los botones jquery.ui
	    $( "#form input[type=submit], #form input[type=button]").button();

	    //este script genera el evento clic del boton Guardar y Salir
		$('#form input[name=guardar], #form input[name=continuar]').click(function(){
			$('#form input[name=boton_hidden]').val($(this).attr('id'));

			// Recolección de datos
        	var fecha_levantamiento = $("input[name=fecha_levantamiento]");
        	var requerimiento_terreno = $("select[name=requerimiento_terreno]");
        	var requerimiento_edificaciones = $("select[name=requerimiento_edificaciones]");
        	var area_adquirir = $("select[name=area_adquirir]");
        	var restablecer_uso_area_no_requerida = $("select[name=restablecer_uso_area_no_requerida]");
        	var existe_vivienda = $("select[name=existe_vivienda]");
        	var vivienda_habitada = $("select[name=vivienda_habitada]");
        	var otros_usos = $("input[name=otros_usos]");
        	var requerida_proyecto = $("select[name=requerida_proyecto]");
        	var distribucion_alcobas = $("input[id=distribucion_alcobas]");
        	var distribucion_cocinas = $("input[id=distribucion_cocinas]");
        	var distribucion_bano = $("input[id=distribucion_bano]");
        	var distribucion_comedor = $("input[id=distribucion_comedor]");
        	var distribucion_sala = $("input[id=distribucion_sala]");
        	var edificaciones_unidades_productivas = $("select[name=edificaciones_unidades_productivas]");
        	var edificaciones_unidades_productivas_descripcion = $("input[name=edificaciones_unidades_productivas_descripcion]");
        	var observaciones = $("textarea[name=observaciones]");

        	// Arreglo con los datos a enviar
        	var datos = {
        		"fecha_levantamiento": fecha_levantamiento.val(),
        		"ficha_predial": ficha.val(),
        		"requerimiento_terreno": requerimiento_terreno.val(),
        		"requerimiento_edificaciones": requerimiento_edificaciones.val(),
        		"area_adquirir": area_adquirir.val(),
        		"restablecer_uso_area_no_requerida": restablecer_uso_area_no_requerida.val(),
        		"existe_vivienda": existe_vivienda.val(),
        		"vivienda_habitada": vivienda_habitada.val(),
        		"requerida_proyecto": requerida_proyecto.val(),
        		"distribucion_alcobas": distribucion_alcobas.val(),
        		"distribucion_cocinas": distribucion_cocinas.val(),
        		"distribucion_bano": distribucion_bano.val(),
        		"distribucion_comedor": distribucion_comedor.val(),
        		"distribucion_sala": distribucion_sala.val(),
        		"edificaciones_unidades_productivas": edificaciones_unidades_productivas.val(),
        		"edificaciones_unidades_productivas_descripcion": edificaciones_unidades_productivas_descripcion.val(),
        		"otros_usos": otros_usos.val(),
        		"observaciones": observaciones.val()
        	};
        	// console.log(ficha.val());
        	// imprimir(datos, "tabla");

        	// Se consulta la ficha social
        	$.ajax({
		        url: "<?php echo site_url('gestion_social_controller/cargar_ficha'); ?>",
		        data: {"ficha": ficha.val()},
		        type: "POST",
		        dataType: "html",
		        async: false,
		        success: function(respuesta){
		            //Si la respuesta no es error
		            if(respuesta){
		                //Se almacena la respuesta como variable de éxito
		                return existe = respuesta;
		            }
		        },//Success
		        error: function(respuesta){
		            //Variable de exito será mensaje de error de ajax
		            existe = respuesta;
		        }//Error
		    });//Ajax

    		// Si existe
    		if (existe == "1") {
    			// url para modificar
    			url = "<?php echo site_url('gestion_social_controller/actualizar_ficha'); ?>";
    		} else {
    			// url para crear
    			url = "<?php echo site_url('gestion_social_controller/insertar_ficha'); ?>";
    		}

        	// Se guardan los cambios en la ficha social
        	$.ajax({
		        url: url,
		        data: {"ficha": ficha.val(), "datos": datos},
		        type: "POST",
		        dataType: "html",
		        async: false,
		        success: function(respuesta){
		            //Si la respuesta no es error
		            if(respuesta){
		                //Se almacena la respuesta como variable de éxito
		                // exito = respuesta;
		                console.log(respuesta)
		            } else {
		                //La variable de éxito será un mensaje de error
		                // exito = 'error';
		                console.log(respuesta)
		            } //If
		        },//Success
		        error: function(respuesta){
		            //Variable de exito será mensaje de error de ajax
		            // exito = respuesta;
	                console.log(respuesta)
		        }//Error
		    });//Ajax

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
		        data: {"ficha": ficha.val(), "datos": valores, "id_unidad_social": 0},
		        type: "POST",
		        dataType: "html",
		        async: false,
		        success: function(respuesta){
		            //Si la respuesta no es error
		            if(respuesta){
		                //Se almacena la respuesta como variable de éxito
		                // exito = respuesta;
		                console.log(respuesta)
		            } else {
		                //La variable de éxito será un mensaje de error
		                // exito = 'error';
		                console.log(respuesta)
		            } //If
		        }
		    });//Ajax

        	location.href= "gestion_social_controller";
		}); // Click
	});
	$('#form input[name=salir]').click(function(){
		window.location.href = window.location.href;
	});
</script>
