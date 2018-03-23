<ul id="navigation">
	<?php // if(isset($permisos['Bit&aacute;cora']['Consultar'])) { ?><li><a onclick="javascript:generar_unidad_social_residente()" style="cursor: pointer;" title="Formato 13"><img src="<?php echo base_url('img/excel.png'); ?>"></a></li><?php // } ?>
</ul>

<div>
	<?php
	// Si trae id
	if ($id != "0") {
		echo form_label('Ficha predial:&nbsp;&nbsp;&nbsp;','ficha');
		echo form_input('ficha', $usr->ficha_predial, 'readonly');
	} else {
		?>
		<!-- Unidad funcional -->
		<label for="unidad_funcional">Unidad funcional</label>
		<select id="unidad_funcional" class="form-control">
            <option value="0"></option>

            <!-- Se recorren las marcas -->
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
		<h3><a href="#seccion1">UNIDAD SOCIAL RESIDENTE - DESCRIPCIÓN</a></h3>
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

						<td width="50%"><?php echo form_label('Relaci&oacute;n con el inmueble','relacion_inmueble'); ?></td>
						<td width="10%"><?php echo form_dropdown('relacion_inmueble', $_relacion, utf8_decode($usr->id_relacion_inmueble)); ?></td>
						<td width="30%"><?php echo form_label('Responsable','responsable'); ?></td>
						<td width="10%"><?php echo form_input('responsable', utf8_decode($usr->responsable)); ?></td>
					</tr>
					<tr>
						<td width="30%"><?php echo form_label('Identificaci&oacute;n','identificacion'); ?></td>
						<td width="10%"><?php echo form_input('identificacion', utf8_decode($usr->identificacion)); ?></td>
						<td width="30%"><?php echo form_label('Edad','edad'); ?></td>
						<td width="10%"><?php echo form_input('edad', utf8_decode($usr->edad)); ?></td>
					</tr>
					<tr>
						<td width="30%"><?php echo form_label('Ocupaci&oacute;n','ocupacion'); ?></td>
						<td width="20%"><?php echo form_dropdown('ocupacion', $_ocupacion, utf8_decode($usr->id_ocupacion)); ?></td>
						<td width="30%"><?php echo form_label('Otras actividades','otras_actividades'); ?></td>
						<td width="10%"><?php echo form_input('otras_actividades', utf8_decode($usr->otras_actividades)); ?></td>
					</tr>
					<tr>
						<td width="30%"><?php echo form_label('Valor ingresos mensuales','ingresos_mensuales'); ?></td>
						<td width="10%"><?php echo form_input('ingresos_mensuales', utf8_decode($usr->ingresos_mensuales)); ?></td>
						<td width="30%"><?php echo form_label('Datos de verificaci&oacute;n','datos_verificacion'); ?></td>
						<td width="10%"><?php echo form_input('datos_verificacion', utf8_decode($usr->datos_verificacion)); ?></td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>
		</div>

		<!-- seccion 2 -->
		<h3><a href="#seccion2">IDENTIFICACI&Oacute;N DE LOS INTEGRANTES</a></h3>
		<div>
			<!-- Integrantes -->
			<?php
			$_relacion_integrante = array(' ' => ' ');
			foreach($this->Gestion_socialDAO->cargar_valores_ficha(8) as $relacion_integrante):
				$_relacion_integrante[$relacion_integrante->id] = $relacion_integrante->nombre;
			endforeach;

			$_ocupacion_integrante = array(' ' => ' ');
			foreach($this->Gestion_socialDAO->cargar_valores_ficha(9) as $ocupacion_integrante):
				$_ocupacion_integrante[$ocupacion_integrante->id] = $ocupacion_integrante->nombre;
			endforeach;
			?>

			<?php
			// Se recorre para generar los campos de integrantes
			for ($i=1; $i <= 12; $i++) {
				echo form_fieldset("<b>Integrante {$i}</b>");
				$cont = 1;
			?>
				<table style="text-align:'left'" width="100%">
					<tbody>
						<tr>
							<td width="10%"><?php echo form_label('Nombre','nombre_integrante'.$i); ?></td>
							<td width="20%"><?php echo form_input('nombre_integrante'.$i); ?></td>
							<td width="10%"><?php echo form_label('Relación','relacion_integrante'.$i); ?></td>
							<td width="20%"><?php echo form_dropdown('relacion_integrante'.$i, $_relacion_integrante); ?></td>
							<td width="10%"><?php echo form_label('Edad','edad_integrante'.$i); ?></td>
							<td width="20%"><?php echo form_input('edad_integrante'.$i); ?></td>
						</tr>
						<tr>
							<td width="10%"><?php echo form_label('Ocupación','ocupacion_integrante'.$i); ?></td>
							<td width="20%"><?php echo form_dropdown('ocupacion_integrante'.$i, $_ocupacion_integrante); ?></td>
							<td width="10%"><?php echo form_label('Ingresos mensuales','ingresos_integrante'.$i); ?></td>
							<td width="20%"><?php echo form_input('ingresos_integrante'.$i); ?></td>
							<td width="10%"><?php echo form_label('Verificaci&oacute;n','verificacion_integrante'.$i); ?></td>
							<td width="20%"><?php echo form_input('verificacion_integrante'.$i); ?></td>
						</tr>
					</tbody>
				</table>
			<?php
				echo form_fieldset_close();
			} // for
			?>
		</div>

		<!-- seccion 3 -->
		<h3><a href="#seccion3">UNIDAD SOCIAL RESIDENTE - DESCRIPCIÓN</a></h3>
		<div>
			<!-- Datos adicionales -->
			<?php echo form_fieldset('<b>Datos adicionales</b>'); ?>
			<table style="text-align:'left'" width="100%">
				<tbody>
					<tr>
						<td width="20%"><?php echo form_label('Total ingresos','total_ingresos'); ?></td>
						<td width="30%"><?php echo form_input('total_ingresos', utf8_decode($usr->total_ingresos)); ?></td>
						<td width="30%"><?php echo form_label('Antigüedad (años)','antiguedad'); ?></td>
						<td width="20%"><?php echo form_input('antiguedad', utf8_decode($usr->antiguedad)); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Canon arrendamiento','canon'); ?></td>
						<td width="30%"><?php echo form_input('canon', utf8_decode($usr->canon)); ?></td>
					</tr>
					<tr>
						<td width="40%"><?php echo form_label('¿Algún integrante posee otro inmueble?','integrante_posee_inmuebe'); ?></td>
						<td width="10%"><?php echo form_dropdown('integrante_posee_inmuebe', array('' => ' ', '1' => 'Si', '0' => 'No'), utf8_decode($usr->integrante_posee_inmuebe)); ?></td>
						<td width="30%"><?php echo form_label('¿Cuál?','integrante_inmueble'); ?></td>
						<td width="20%"><?php echo form_input('integrante_inmueble', utf8_decode($usr->integrante_inmueble)); ?></td>
					</tr>
					<tr>
						<td width="40%"><?php echo form_label('En caso de traslado, ¿Pueden hacerlo a este?','traslado_inmueble'); ?></td>
						<td width="10%"><?php echo form_dropdown('traslado_inmueble', array('' => ' ', '1' => 'Si', '0' => 'No'), utf8_decode($usr->traslado_inmueble)); ?></td>
						<td width="30%"><?php echo form_label('Por qué?','traslado_razon'); ?></td>
						<td width="20%"><?php echo form_input('traslado_razon', utf8_decode($usr->traslado_razon)); ?></td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>

			<!-- Integrantes que gozan con estos servicios contratados -->
			<?php echo form_fieldset('<b>Integrantes que gozan con estos servicios contratados</b>'); ?>
			<table style="text-align:'left'" width="100%">
				<tbody>
					<tr>
						<td width="20%"><?php echo form_label('Guardería infantil','servicio_guarderia'); ?></td>
						<td width="30%"><?php echo form_input('servicio_guarderia', utf8_decode($usr->servicio_guarderia)); ?></td>
						<td width="30%"><?php echo form_label('Restaurante escolar','servicio_restaurante'); ?></td>
						<td width="20%"><?php echo form_input('servicio_restaurante', utf8_decode($usr->servicio_restaurante)); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Transporte escolar','servicio_transporte'); ?></td>
						<td width="30%"><?php echo form_input('servicio_transporte', utf8_decode($usr->servicio_transporte)); ?></td>
						<td width="30%"><?php echo form_label('Educación básica','servicio_educacion'); ?></td>
						<td width="20%"><?php echo form_input('servicio_educacion', utf8_decode($usr->servicio_educacion)); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Rehabilitación','servicio_rehabilitacion'); ?></td>
						<td width="30%"><?php echo form_input('servicio_rehabilitacion', utf8_decode($usr->servicio_rehabilitacion)); ?></td>
						<td width="30%"><?php echo form_label('Apoyo geriátrico','servicio_geriatria'); ?></td>
						<td width="20%"><?php echo form_input('servicio_geriatria', utf8_decode($usr->servicio_geriatria)); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Ninguno','servicio_ninguno'); ?></td>
						<td width="30%"><?php echo form_input('servicio_ninguno', utf8_decode($usr->servicio_ninguno)); ?></td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>

			<table style="text-align:'left'" width="100%">
				<tbody>
					<tr>
						<td width="40%"><?php echo form_label('Además de residir, ¿actividades productivas?','desarrollo_actividades_productivas'); ?></td>
						<td width="10%"><?php echo form_dropdown('desarrollo_actividades_productivas', array('' => ' ', '1' => 'Si', '0' => 'No'), utf8_decode($usr->desarrollo_actividades_productivas)); ?></td>
						<td width="30%"><?php echo form_label('¿Cuáles?','actividades_productivas'); ?></td>
						<td width="20%"><?php echo form_input('actividades_productivas', utf8_decode($usr->actividades_productivas)); ?></td>
					</tr>
				</tbody>
			</table>
		</div>

		<h3><a href="#seccion4">DIAGNÓSTICO SOCIOECONÓMICO</a></h3>
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
<?php if (isset($usr->ficha_predial)) {
?>
	<script type="text/javascript">
		$(document).ready(function(){
			// Se guardan los cambios en la ficha social
        	$.ajax({
		        url: "<?php echo site_url('gestion_social_controller/cargar_unidad_social_residente'); ?>",
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
			for (i = 1; i <= 12; i++) {
        		$("input[name='nombre_integrante" + i + "']").val(datos["nombre_integrante" + i]);
        		$("select[name='relacion_integrante" + i + "']").val(datos["id_relacion_integrante" + i]);
        		$("input[name='edad_integrante" + i + "']").val(datos["edad_integrante" + i]);
        		$("select[name='ocupacion_integrante" + i + "']").val(datos["id_ocupacion_integrante" + i]);
        		$("input[name='ingresos_integrante" + i + "']").val(datos["ingresos_integrante" + i]);
        		$("input[name='verificacion_integrante" + i + "']").val(datos["verificacion_integrante" + i]);
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
		var datos = {ficha: ficha.val(), tipo: 'id_usr', id:id};
		$.get("<?php echo site_url('gestion_social_controller/diagnostico_social'); ?>", datos, function(vista){
			$("#diagnostico").html(vista);
		});
		$( "#accordion" ).accordion
		({
			autoHeight: false,
			navigation: true
		});

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
        	var responsable = $("input[name=responsable]");
        	var identificacion = $("input[name=identificacion]");
        	var edad = $("input[name=edad]");
        	var ocupacion = $("select[name=ocupacion]");
        	var otras_actividades = $("input[name=otras_actividades]");
        	var ingresos_mensuales = $("input[name=ingresos_mensuales]");
        	var datos_verificacion = $("input[name=datos_verificacion]");
        	var antiguedad = $("input[name=antiguedad]");
        	var total_ingresos = $("input[name=total_ingresos]");
        	var canon = $("input[name=canon]");
        	var integrante_posee_inmuebe = $("select[name=integrante_posee_inmuebe]");
        	var integrante_inmueble = $("input[name=integrante_inmueble]");
        	var traslado_inmueble = $("select[name=traslado_inmueble]");
        	var traslado_razon = $("input[name=traslado_razon]");
        	var servicio_guarderia = $("input[name=servicio_guarderia]");
        	var servicio_restaurante = $("input[name=servicio_restaurante]");
        	var servicio_transporte = $("input[name=servicio_transporte]");
        	var servicio_educacion = $("input[name=servicio_educacion]");
        	var servicio_rehabilitacion = $("input[name=servicio_rehabilitacion]");
        	var servicio_geriatria = $("input[name=servicio_geriatria]");
        	var servicio_ninguno = $("input[name=servicio_ninguno]");
        	var desarrollo_actividades_productivas = $("select[name=desarrollo_actividades_productivas]");
        	var actividades_productivas = $("input[name=actividades_productivas]");

        	// Arreglo con los datos a enviar
        	var datos = {
        		"relacion_inmueble": relacion_inmueble.val(),
        		"responsable": responsable.val(),
        		"identificacion": identificacion.val(),
        		"edad": edad.val(),
        		"ocupacion": ocupacion.val(),
        		"otras_actividades": otras_actividades.val(),
        		"ingresos_mensuales": ingresos_mensuales.val(),
        		"datos_verificacion": datos_verificacion.val(),
        		"antiguedad": antiguedad.val(),
        		"total_ingresos": total_ingresos.val(),
        		"canon": canon.val(),
        		"integrante_posee_inmuebe": integrante_posee_inmuebe.val(),
        		"integrante_inmueble": integrante_inmueble.val(),
        		"traslado_inmueble": traslado_inmueble.val(),
        		"traslado_razon": traslado_razon.val(),
        		"servicio_guarderia": servicio_guarderia.val(),
        		"servicio_restaurante": servicio_restaurante.val(),
        		"servicio_transporte": servicio_transporte.val(),
        		"servicio_educacion": servicio_educacion.val(),
        		"servicio_rehabilitacion": servicio_rehabilitacion.val(),
        		"servicio_geriatria": servicio_geriatria.val(),
        		"servicio_ninguno": servicio_ninguno.val(),
        		"desarrollo_actividades_productivas": desarrollo_actividades_productivas.val(),
        		"actividades_productivas": actividades_productivas.val(),
        	}

        	// Recorrido de los integrantes
        	for (i = 1; i <= 12; i++) {
        		datos['nombre_integrante' + i]  = $("input[name=nombre_integrante" + i + "]").val();
        		datos['relacion_integrante' + i]  = $("select[name=relacion_integrante" + i + "]").val();
        		datos['edad_integrante' + i]  = $("input[name=edad_integrante" + i + "]").val();
        		datos['ocupacion_integrante' + i]  = $("select[name=ocupacion_integrante" + i + "]").val();
        		datos['ingresos_integrante' + i]  = $("input[name=ingresos_integrante" + i + "]").val();
        		datos['verificacion_integrante' + i]  = $("input[name=verificacion_integrante" + i + "]").val();
			}

        	// Si es una Unidad Social existente
    		if (id > 0) {
    			// Agregar datos
    			datos["ficha_predial"] = ficha.val();

    			// url para modificar
    			url = "<?php echo site_url('gestion_social_controller/actualizar_usr'); ?>";
    		} else {
    			// Si no tiene seleccionada una ficha
    			if ($("#numero_ficha").val() == "0") {
    				alert("Seleccione primero una ficha predial");

    				return false;
    			}
    			datos["ficha_predial"] = $("#numero_ficha").val();

    			// url para crear
    			url = "<?php echo site_url('gestion_social_controller/insertar_usr'); ?>";
    		}

    		// Se guardan los cambios en la ficha social
        	$.ajax({
		        url: url,
		        data: {"id": id, "datos": datos},
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

        	location.href= "<?php echo site_url('gestion_social_controller/unidades_sociales_residentes'); ?>";
		}); // click
	});
</script>
