<h4 style="display: inline-block;">
    Construcciones <?php if($subcategoria == 2) {echo "anexas"; } ?> del predio <?= $ficha; ?>
</h4>
<p style="float: right;">
    <input type="button" value="Nuevo" onClick="crear()" class="ui-button ui-widget ui-state-default ui-corner-all">
    <input type="button" value="Volver" onClick="javascript:volver()" class="ui-button ui-widget ui-state-default ui-corner-all">
</p>

<!-- Confirmación de eliminación -->
<div id="dialog-confirm" title="Eliminar cultivo" hidden>
    ¿Esta seguro(a) de realizar esta acción?
</div>

<!-- Contenedor de cultivos -->
<div id="cont_construcciones"></div>
<div id="cont_modal"></div>

<script type="text/javascript">
	/**
	 * Función que crea un registro
	 */
    function crear()
    {
		// Carga de interfaz
		cargar_interfaz("cont_modal", "<?= site_url('actualizar_controller/cargar_interfaz'); ?>", {"tipo": "ficha_construcciones_gestion", "ficha": "<?= $ficha; ?>", "id": 0});
    } // crear

    /**
	 * Función que actualiza un registro
	 */
    function editar(id)
    {
    	// Carga de interfaz
		cargar_interfaz("cont_modal", "<?= site_url('actualizar_controller/cargar_interfaz'); ?>", {"tipo": "ficha_construcciones_gestion", "ficha": "<?= $ficha; ?>", "id": id});
    } // editar

	/**
	 * Eliminación de registros en base de datos
	 */
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
                ajax("<?php echo site_url('actualizar_controller/eliminar'); ?>", {"tipo": "construccion", "datos": datos}, "html");

            	// Se listan los cultivos
            	listar();
	        break; // Confirmación
		} // Suiche
	} // eliminar

	/**
	 * Función que guarda o actualiza el registro del cultivo
	 */
	function guardar()
	{
		// Declaración de variables
		var id = $("#id_cultivo").val();
	    var descripcion = $("textarea[name=descripcion]");
	    var cantidad = $("input[name=cantidad]");
	    var densidad = $("input[name=densidad]");
	    var unidad = $("input[name=unidad]");

	    //Datos a validar
	    datos_obligatorios = new Array(
			descripcion.val(),
			cantidad.val(),
			unidad.val()
	    );
	    // imprimir(datos_obligatorios);

	    //Se ejecuta la validación de los campos obligatorios
	    validacion = validar_campos_vacios(datos_obligatorios);

	    //Si no supera la validacíón
	    if (!validacion) {
	        // Mensaje de advertencia
	        $("#error").html('<div id="alerta" class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0px 0.7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>Llene los campos obligatorios</p></div>');

	        return false;
	    } // if

	    // Arreglo de datos a guardar
	    var datos = {
	        "ficha_predial": "<?= $ficha ?>",
	        "descripcion": descripcion.val(),
            "id_tipo": "<?= $subcategoria ?>",
	        "cantidad": cantidad.val(),
	        "unidad": unidad.val()
	    };
	    // imprimir(datos);

	    // Si es edición
	    if (id) {
    		// Se actualiza el registro
            ajax("<?php echo site_url('actualizar_controller/actualizar'); ?>", {"tipo": "construccion", "datos": datos, "id": id}, "html");
	    } else {
    		// Se crea el registro
            ajax("<?php echo site_url('actualizar_controller/crear'); ?>", {"tipo": "construccion", "datos": datos}, "html");
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
		cargar_interfaz("cont_construcciones", "<?php echo site_url('actualizar_controller/cargar_interfaz'); ?>", {"tipo": "ficha_construcciones_lista", "ficha": "<?= $ficha; ?>", "subcategoria": "<?= $subcategoria ?>"});
	} // listar

	function volver()
	{
		// Se devuelve a la página general de edición del predio
		location.reload();
	} // volver

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Por defecto, cargamos la lista de cultivos
		listar();
	}); // document.ready
</script>
