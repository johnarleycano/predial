<?php $permisos = $this->session->userdata('permisos'); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<div id="form">
	<?php echo form_fieldset('<b>Actualizar</b>'); ?>
		<img src="<?php echo base_url(); ?>img/edit.png" title="Actualizar" >: Actualizar Ficha
		<?php if (isset($permisos['Bit&aacute;cora']['Consultar'])) { ?><img alt="Ver Bit&aacute;cora" title="Ver Bit&aacute;cora" src="<?php echo base_url(); ?>img/bitacora.png">: Bit&aacute;cora,<?php } ?>
		<?php if (isset($permisos['Archivos y Fotos']['Consultar'])) {?>
			<img src="<?php echo base_url(); ?>img/archivos.png" title="Subir archivos" >: Subir Archivos
			<img src="<?php echo base_url(); ?>img/camara.png" title="Subir fotos" >: Subir Fotos
		<?php } ?>
		<?php if (isset($permisos['Fichas']['Imprimir estudio de t&iacute;tulos'])) { ?><img src="<?php echo base_url(); ?>img/doc.png" title="Estudio de T&iacute;tulos" >: Descargar el Estudio de T&iacute;tulos<?php } ?>

		<br><br>
		<?php echo form_hidden('posicion_tabla'); ?>
		<div id="tabla">
			<table style="width:100%; font-size: 13px">
				<thead>
					<tr>
						<!-- <th>Fecha de creaci&oacute;n</th> -->
						<th>Ficha predial</th>
						<th>Primer propietario</th>
						<th>¿Requerido?</th>
						<th>Fotos</th>
						<th>Archivos</th>
						<th>Opciones</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($fichas as $ficha): ?>
						<tr>
							<td><?php echo $ficha->ficha_predial; ?></td>
							<td><?php echo $ficha->propietario; ?></td>
							<td><?php echo $ficha->requerido; ?></td>
							<td><?= $this->PrediosDAO->fotos_cantidad($ficha->ficha_predial)->fotos_cantidad; ?></td>
							<td><?= $this->PrediosDAO->archivos_cantidad($ficha->ficha_predial); ?></td>
							<td width="550px">
								<?= anchor("actualizar_controller/ficha/$ficha->id_predio", '<img src="'.base_url().'img/edit.png"', 'title="Actualizar"'); ?>
								<?php if (isset($permisos['Bit&aacute;cora']['Consultar'])) { ?><a href="javascript:void(window.open('<?php echo site_url("bitacora_controller/obtener_bitacora/$ficha->ficha_predial"); ?>','bitacora','resizable=no,location=no,menubar=no, scrollbars=yes,status=no,toolbar=no,fullscreen=no, dependent=no,width=1020,height=600,left=100,top=0' ))"><img border="0" alt="Ver Bit&aacute;cora" title="Ver Bit&aacute;cora" src="<?php echo base_url(); ?>img/bitacora.png"></a><?php } ?>
								<?php
									if (isset($permisos['Archivos y Fotos']['Consultar'])) {
										echo anchor("archivos_controller/ver_archivos/".str_replace(' ', '_', $ficha->ficha_predial), '<img src="'.base_url().'img/archivos.png"', 'title="Subir archivos"');
										echo anchor("archivos_controller/ver_fotos?ficha=".$ficha->ficha_predial."&tipo=1", '<img src="'.base_url().'img/camara.png"', 'title="Subir fotos"');
									}
								?>
								<?php if (isset($permisos['Fichas']['Imprimir estudio de t&iacute;tulos'])) { ?><?php echo anchor("informes_controller/estudio_titulos/".$ficha->id_predio, '<img src="'.base_url().'img/doc.png"', 'title="Estudio de T&iacute;tulos"'); ?><?php } ?>

								<?php echo anchor("informes_controller/gestion_predial_ani/".str_replace(' ', '_', $ficha->ficha_predial), '<img src="'.base_url().'img/excel.png"', 'title="Generar formato de la ANI"'); ?>

								<?php echo anchor("informes_controller/gestion_predial_fotos/".str_replace(' ', '_', $ficha->ficha_predial), '<img src="'.base_url().'img/pdf.png"', 'title="Generar registro fotográfico"'); ?>

								<?php
									if ($this->AccionesDAO->consultar_coordenada($ficha->ficha_predial) != null) {
										echo anchor("archivos_controller/generar_kml/".str_replace(' ', '_', $ficha->ficha_predial), '<img src="'.base_url().'img/kml.png"', 'title="Generar KML"');
									}
								?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	<?php echo form_fieldset_close(); ?>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#form table').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
		});

		$('#form a[href^="<?php echo site_url('consultas_controller') ?>"]').live('click', function(){
			var palabra_clave = $('div.dataTables_filter input[type=text]').val();
			var url = $(this).attr('href');
			$.post(
				'<?php echo site_url('consultas_controller/guarda_palabra_clave') ?>',
				{
					"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",
					"palabra_clave":palabra_clave
				},
				function (msg) {
					if(msg == 'correcto') {
						location.href = url;
					}
					else {
						return false;
					}
				}
			);
			return false;
		});
	});
</script>
