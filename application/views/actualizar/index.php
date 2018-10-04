<!-- Contenedor general -->
<div id="cont_general"></div>

<script type="text/javascript">
	/**
     * Carga por Ajax la interfaz seleccionada
     */
    function cargar(tipo, subcategoria){
        // Dependiendo del tipo
        switch(tipo) {
            // Cultivos y especies
            case "cultivos":
            	// Se pone activo en el menú la opción de cultivos
            	$("ul>li").removeClass('current');
            	$("#menu_cultivos").addClass('current');

            	// Se carga la interfaz
				cargar_interfaz("cont_general", "<?= site_url('actualizar_controller/cargar_interfaz'); ?>", {"tipo": "ficha_cultivos", "ficha": "<?= $predio->ficha_predial; ?>"});
            break; // Cultivos y especies
			// Construcciones
			case "construcciones":
				// Se pone activo en el menú la opción de construcciones deendiendo de la subcategoria
				$("ul>li").removeClass('current');
				if (subcategoria === 1) {
					$("#menu_construcciones").addClass('current');
				} else {
					$("#menu_construcciones_anexas").addClass('current');
				}
				// Se carga la interfaz
				cargar_interfaz("cont_general", "<?= site_url('actualizar_controller/cargar_interfaz'); ?>", {"tipo": "ficha_construcciones", "subcategoria": subcategoria, "ficha": "<?= $predio->ficha_predial; ?>"});
			break; // Construcciones
			// Propietarios
			case "propietarios":
				// Se pone activo en el menú la opción de cultivos
				$("ul>li").removeClass('current');
				$("#menu_propietarios").addClass('current');
				// Se carga la interfaz
					cargar_interfaz("cont_general", "<?= site_url('actualizar_controller/cargar_interfaz'); ?>", {"tipo": "propietarios", "ficha": "<?= $predio->ficha_predial; ?>"});
			break; // Propietarios
			// Vertices
			case "vertices":
				// Se pone activo en el menú la opción de cultivos
				$("ul>li").removeClass('current');
				$("#menu_vertices").addClass('current');
				// Se carga la interfaz
					cargar_interfaz("cont_general", "<?= site_url('actualizar_controller/cargar_interfaz'); ?>", {"tipo": "vertices", "ficha": "<?= $predio->ficha_predial; ?>"});
			break; // Propietarios
        } // suiche
    } // cargar

	/**
	 * Función de gestión del formulario
	 * @return void
	 */
	function gestionar()
	{
		// Se carga la interfaz
		cargar_interfaz("cont_general", "<?php echo site_url('actualizar_controller/cargar_interfaz'); ?>", {"tipo": "ficha_gestion", "id": "<?= $id_predio; ?>"});
	} // gestionar

	/**
	 * Eliminación de registros en base de datos
	 * @param  {string} tipo tipo a eliminar
	 * @return {boolean}      true: exitoso
	 */
	function eliminar(tipo, id)
	{

	} // eliminar

	/**
	 * Listado de los registros
	 */
	function listar()
	{
		
	} // listar

	/**
	 * Vuelve al anterior formulario
	 */
	function volver()
	{
		// Carga de interfaz inicial
		// cargar('configuracion');
	} // volver

	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Por defecto, cargamos la gestión del formulario de la ficha
		gestionar();
	}); // document.ready
</script>
