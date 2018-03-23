<!-- Contenedor general -->
<div id="cont_general"></div>

<script type="text/javascript">
	/**
     * Carga por Ajax la interfaz seleccionada
     */
    function cargar(tipo){
        // Dependiendo del tipo
        switch(tipo) {
            // Cultivos y especies
            case "cultivos":
            	// Se carga la interfaz
				cargar_interfaz("cont_general", "<?php echo site_url('actualizar_controller/cargar_interfaz'); ?>", {"tipo": "ficha_cultivos", "ficha": "<?php echo $predio->ficha_predial; ?>"});
            break; // Cultivos y especies
        } // suiche
    } // cargar
	
	/**
	 * Función de gestión del formulario
	 * @return void 
	 */
	function gestionar()
	{
		// Se carga la interfaz
		cargar_interfaz("cont_general", "<?php echo site_url('actualizar_controller/cargar_interfaz'); ?>", {"tipo": "ficha_gestion", "ficha": "<?php echo $predio->ficha_predial; ?>"});
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
		// Carga de interfaz
		// cargar_interfaz("cont_marcas", "<?php echo site_url('configuracion/cargar_interfaz'); ?>", {"tipo": "marcas_lista"});
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