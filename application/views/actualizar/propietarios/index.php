<h4 style="display: inline-block;">Propietarios <?php echo $ficha; ?></h4>
<p style="float: right;">
    <input type="button" value="Agregar" onClick="agregar_modal()" class="ui-button ui-widget ui-state-default ui-corner-all">
    <input type="button" value="Nuevo" onClick="crear()" class="ui-button ui-widget ui-state-default ui-corner-all">
    <input type="button" value="Volver" onClick="javascript:volver()" class="ui-button ui-widget ui-state-default ui-corner-all">
</p>

<!-- Confirmación de eliminación -->
<div id="dialog-confirm" title="Eliminar propietario" hidden>
    ¿Esta seguro(a) de desvincular el propietario de este predio?
</div>

<!-- Contenedor de propietarios -->
<div id="cont_propietarios"></div>
<!-- Contenedor de Modal editar y nuevo-->
<div id="cont_modal"></div>
<!-- Contenedor modal agregar -->
<div id="cont_agregar" hidden>
    <div id="error_participacion"></div>
    <?= form_label('Número de documento', 'documento_buscar') ?>
    <?php $data = array('name'=>'documento_buscar') ?>
    <?= form_input($data) ?>
    <input type="button" name="buscar" value="Buscar" onClick="buscar()" class="ui-button ui-widget ui-state-default ui-corner-all">
    <div id="resultado_busqueda"></div>
</div>

</div>
<script type="text/javascript">
    function verificar_participacion(participacion, participacionForm) {
        if (parseFloat(participacion) + parseFloat(participacionForm) > 100) {
            return false;
        }
        return true;
    }
    /**
     * Función que abre el modal para agregar un propietario nuevo
     */
    function agregar_modal()
    {
        $('#error_participacion').html('');
        $( "#cont_agregar" ).dialog({
            modal: true,
            height:310,
            width:760,
        });
    }

    /**
     * Función que agrega un registro existente
     */
    function agregar(id) {
        var participacion = $("input[name=participacion_nuevo]");
        var datos = {
            'id_propietario':id,
            'ficha_predial':"<?= $ficha?>",
            'participacion':participacion.val()
        };

        // suma la participacion de cada propietario en el predio actual
        var participacionDB = ajax("<?= site_url('actualizar_controller/cargar'); ?>", {"tipo": "propietarios_total_participacion", "datos": datos}, "html");
        // verifica que la nueva participacion no supere el 100%
        var verificacion = verificar_participacion(participacionDB, datos.participacion);

        if (verificacion) {
            ajax("<?= site_url('actualizar_controller/crear'); ?>", {"tipo": "propietario_relacion", "datos": datos}, "html");
            listar();
            cerrar_modal();
        } else {
            $("#error_participacion").html('<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0px 0.7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>La participación de los propietarios supera el porcentaje total. El porcentaje no debe ser mayor a 100%</p></div>');
        }
    }

    function buscar()
    {
        $("#error_participacion").html('');
        var documento = $("input[name=documento_buscar]");
        documento = documento.val();
        var datos_numericos = new Array(documento);

        var validacion_numerico = validar_campos_numericos(datos_numericos);

        if (!validacion_numerico) {
            $("#error_participacion").html('<div id="alerta" class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0px 0.7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>El número de documento no puede llevar letras o caracteres especiales</p></div>');
            return false;
        }

        cargar_interfaz("resultado_busqueda", "<?= site_url('actualizar_controller/cargar_interfaz'); ?>", {"tipo": "propietario_buscar", "ficha": "<?= $ficha; ?>", "documento": documento});
    }

    /**
	 * Función que crea un registro
	 */
    function crear()
    {
        cerrar_modal();
		// Carga de interfaz
		cargar_interfaz("cont_modal", "<?= site_url('actualizar_controller/cargar_interfaz'); ?>", {"tipo": "propietarios_gestion", "ficha": "<?= $ficha; ?>", "id": 0});
    } // crear

    /**
	 * Función que actualiza un registro
	 */
    function editar(id)
    {
    	// Carga de interfaz
		cargar_interfaz("cont_modal", "<?= site_url('actualizar_controller/cargar_interfaz'); ?>", {"tipo": "propietarios_gestion", "ficha": "<?= $ficha; ?>", "id": id});
    } // editar

	/**
	 * Función que guarda o actualiza el registro del propietarios
	 */
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
        var participacion = $("input[name=participacion]");

	    //Datos a validar
	    var datos_obligatorios = new Array(
			tipo_documento.val(),
			documento.val(),
			nombre.val(),
            participacion.val()
	    );

        var datos_numericos = new Array(
            participacion.val(),
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

        // Verifica que la participacion a ingresar sea mayor a 0 y menor o igual a 100
        if (!(participacion.val() > 0 && participacion.val() <= 100) ) {
            // Mensaje de advertencia
            $("#error").html('<div id="alerta" class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0px 0.7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>la participación debe ser mayor a 0% y menor o igual a 100%</p></div>');
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
            'participacion': participacion.val()
	    };
        // suma la participacion de cada propietario en el predio actual
        var participacionDB = ajax("<?= site_url('actualizar_controller/cargar'); ?>", {"tipo": "propietarios_total_participacion", "datos": datos}, "html");
        var verificacion;
        // Si es edición
	    if (id) {
            // se obtiene la participacion actual
            var participacion_actual = ajax("<?= site_url('actualizar_controller/cargar'); ?>", {"tipo": "propietario_participacion", "datos": datos, "id": id}, "html");
            // verifica que la nueva participacion no supere el 100%
            verificacion = verificar_participacion(participacionDB, datos.participacion - participacion_actual);

            if (!verificacion) {
                $("#error").html('<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0px 0.7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>La participación de los propietarios supera el porcentaje total. El porcentaje no debe ser mayor a 100%</p></div>');
                return false;
            }
    		// Se actualiza el registro
            ajax("<?= site_url('actualizar_controller/actualizar'); ?>", {"tipo": "propietario", "datos": datos, "id": id}, "html");

	    } else {
            // verifica que el propietario no exista
            var existe_propietario = ajax("<?= site_url('actualizar_controller/cargar'); ?>", {"tipo": "propietario", "datos": datos}, "html");
            if (existe_propietario) {
                $("#error").html('<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0px 0.7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>Este propietario ya existe en la base de datos</p></div>');
                return false;
            }

            verificacion = verificar_participacion(participacionDB, datos.participacion);
            if (!verificacion) {
                $("#error").html('<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0px 0.7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>La participación de los propietarios supera el porcentaje total. El porcentaje no debe ser mayor a 100%</p></div>');
                return false;
            }
    		// Se crea el registro
            ajax("<?php echo site_url('actualizar_controller/crear'); ?>", {"tipo": "propietario", "datos": datos}, "html");
	    } // if

	    // Se listan los cultivos
	    listar();

	    // Se cierra el modal
	    cerrar_modal();
	} // guardar

	/**
	 * Listado de los registros
	 */
	function listar()
	{
		// Carga de interfaz
		cargar_interfaz("cont_propietarios", "<?= site_url('actualizar_controller/cargar_interfaz'); ?>", {"tipo": "propietarios_lista", "ficha": "<?= $ficha; ?>"});
	} // listar

	function volver()
	{
		// Se devuelve a la página general de edición del predio
		location.reload();
	} // volver

    function eliminar(tipo, id)
	{
	  	// Suiche
    	switch(tipo) {
    		// Mensaje
		    case "mensaje":
		    	// Modal
		        $( "#dialog-confirm" ).dialog({
			        resizable: false,
			        height:200,
			        width:420,
			        modal: true,
			        buttons: {
			            Si: function() {
			                // Se elimina
			                eliminar("confirmacion", id);

			                //se destruye el elemento dialog
			                // $( "#dialog:ui-dialog" ).dialog( "destroy" );

			                //se cierra el elemento flotante
			                cerrar_modal();
			            },
			            No: function() {
			                //se cierra el elemento flotante
			                cerrar_modal();
			            } // if
			        } // buttons
		    	}); // Dialog
	        break; // Mensaje

	        // Confirmación
		    case "confirmacion":
                var datos = {
                    "ficha_predial": "<?= $ficha ?>",
                    "id": id
                };
		        // Se elimina el registro
                ajax("<?php echo site_url('actualizar_controller/eliminar'); ?>", {"tipo": "propietario_relacion", "datos": datos}, "html");

            	// Se listan los cultivos
            	listar();
	        break; // Confirmación
		} // Suiche
	} // eliminar

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Por defecto, cargamos la lista de cultivos
		listar();
	}); // document.ready
</script>
