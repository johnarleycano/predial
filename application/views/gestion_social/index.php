<?php
$permisos = $this->session->userdata('permisos');
?>
<div id="form">
	<?php echo form_fieldset('<b>Gestión social</b>'); ?>

		<br><br>
		<div id="tabla">

		</div>
	<?php echo form_fieldset_close(); ?>
</div>

<script type="text/javascript">
	/**
	 * Reporte en Excel del formato de
	 * caracterización general del inmueble
	 * @return void
	 */
	function generar_caracterizacion_general(){
		// $("#form").load("<?php echo site_url(''); ?>" + "/" + "id_predio" + "/" + "ficha");
		location.href= "informes_controller/caracterizacion_general"
	}

	/**
	 * Función que se activa al presionar el botón editar del menú
	 * @return void
	 */
	function editar(id_predio, ficha)
	{
		// Se carga la interfaz
		$("#form").load("<?php echo site_url('gestion_social_controller/ficha'); ?>" + "/" + id_predio + "/" + ficha);
	} // editar

	/**
	 * Listado de los registros
	 */
	function listar()
	{
		// Carga de interfaz
		$("#tabla").load("<?php echo site_url('gestion_social_controller/cargar_fichas'); ?>");
	} // listar


	function archivos_social(ficha) {
		var datos = {ficha: ficha, tipo: 2, aux: true};
		$.get("<?php echo site_url('archivos_controller/ver_archivos_social'); ?>", datos, function(vista){
			$("#form").html(vista);
		});
	}

	$(document).ready(function(){
		// Por defecto, cargamos la interfaz de la tabla
		listar();
	});
</script>
