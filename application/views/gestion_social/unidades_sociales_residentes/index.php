<?php
$permisos = $this->session->userdata('permisos');
?>

<div id="form">
	<?php echo form_fieldset('<b>Unidades sociales residentes</b>'); ?>
		<div id="tabla">

		</div>
	<?php echo form_fieldset_close(); ?>
</div>


<script type="text/javascript">
	/**
	 * Función de creación del registro
	 * @return void
	 */
	function crear()
	{
    	// Se carga la interfaz
		$("#form").load("<?php echo site_url('gestion_social_controller/ficha_social_residente'); ?>" + "/" + 0);
	} // crear

	/**
	 * Función que se activa al presionar el botón editar del menú
	 * @return void
	 */
	function editar(id)
	{
		// Se carga la interfaz
		$("#form").load("<?php echo site_url('gestion_social_controller/ficha_social_residente'); ?>" + "/" + id);
	} // editar

	/**
	 * Listado de los registros
	 */
	function listar()
	{
		// Carga de interfaz
		$("#tabla").load("<?php echo site_url('gestion_social_controller/cargar_unidades_sociales_residentes'); ?>");
	} // listar

	/**
	 * Archivos unidad social residente
	 */
	function archivos_social(ficha, id) {
		var datos = {ficha: ficha, tipo: 3, aux: true, id:id};
		$.get("<?php echo site_url('archivos_controller/ver_archivos_social'); ?>", datos, function(vista){
			$("#form").html(vista);
		});
	}

	$(document).ready(function(){
		// Por defecto, cargamos la interfaz de la tabla
		listar();
	});
</script>
