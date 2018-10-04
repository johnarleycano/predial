<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<img src="<?= base_url(); ?>img/edit.png" title="Actualizar" >: Actualizar Ficha
<img src="<?= base_url(); ?>img/archivos.png" title="Subir archivos" >: Subir Archivos
<img src="<?= base_url(); ?>img/camara.png" title="Subir fotos" >: Subir Fotos
<img src="<?= base_url(); ?>img/excel.png" title="Generar formato caracterización general" >: Caracterización general
<img src="<?= base_url(); ?>img/pdf.png" title="Generar registro fotográfico" >: Registro fotográfico
<img src="<?= base_url(); ?>img/pagos2.png" title="Diagnóstico socioecónomico" >: Diagnóstico socioecónomico
<table style="width:100%; font-size: 13px">
	<thead>
		<tr>
			<th>Ficha predial</th>
			<th>Primer propietario</th>
			<th>Unidades residentes</th>
			<th>Unidades productivas</th>
			<th>Fotos</th>
			<th>Archivos</th>
			<th width="25%">Opciones</th>
		</tr>
		<tbody>
			<?php foreach ($fichas as $ficha): ?>
				<tr>
					<td><?php echo $ficha->ficha_predial; ?></td>
					<td><?php echo $ficha->propietario; ?></td>
					<td><?php echo $ficha->usr; ?></td>
					<td><?php echo $ficha->usp; ?></td>
					<td><?php echo $ficha->fotos; ?></td>
					<td><?php echo $ficha->archivos; ?></td>
					<td>
						<a onclick="javascript:editar('<?php echo $ficha->id_predio; ?>', '<?php echo $ficha->ficha_predial; ?>')" style="cursor: pointer">
							<img src="<?php echo base_url(); ?>img/edit.png" title="Editar información">
						</a>
						<a onclick="javascript:archivos_social('<?php echo $ficha->ficha_predial; ?>')" style="cursor: pointer">
							<img src="<?php echo base_url(); ?>img/archivos.png" title="Subir archivos">
						</a>
						<?php echo anchor("archivos_controller/ver_fotos?ficha=".$ficha->ficha_predial."&tipo=2", '<img src="'.base_url().'img/camara.png"', 'title="Subir fotos"'); ?>
						<?php echo anchor("informes_controller/ficha_social_general/".$ficha->ficha_predial.'/2', '<img src="'.base_url().'img/excel.png"', 'title="Generar formato de caracterización general"'); ?>					
						<?php echo anchor("informes_controller/ficha_social_registro_fotos/".$ficha->ficha_predial.'/2', '<img src="'.base_url().'img/pdf.png"', 'title="Generar registro fotográfico"'); ?>
						<?php echo anchor("informes_controller/diagnostico_socioeconomico/".$ficha->ficha_predial.'/2', '<img src="'.base_url().'img/pagos2.png"', 'title="Generar diagnóstico socioeconómico"'); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</thead>
</table>

<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#form table').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"stateSave": true,
		});
	});
</script>
