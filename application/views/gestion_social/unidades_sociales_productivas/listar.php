<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<img src="<?= base_url(); ?>img/edit.png" title="Actualizar" >: Actualizar Ficha
<img src="<?= base_url(); ?>img/archivos.png" title="Subir archivos" >: Subir Archivos
<img src="<?= base_url(); ?>img/camara.png" title="Subir fotos" >: Subir Fotos
<img src="<?= base_url(); ?>img/excel.png" title="Generar formato caracterización general" >: Caracterización unidad social productiva
<img src="<?= base_url(); ?>img/pdf.png" title="Generar registro fotográfico" >: Registro fotográfico
<img src="<?= base_url(); ?>img/pagos2.png" title="Diagnóstico socioecónomico" >: Diagnóstico socioecónomico
<br><br>
<input type="button" onclick="javascript:crear()" value="Nueva">
<br>

<table style="width:100%; font-size: 13px">
	<thead>
		<tr>
			<th>Ficha predial</th>
			<th>Relación con inmueble</th>
			<th>Titular</th>
			<th>Arrendatarios</th>
			<th>Fotos</th>
			<th>Archivos</th>
			<th width="25%">Opciones</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($unidades_sociales_productivas as $usp): ?>
			<tr>
				<td><?= $usp->ficha_predial; ?></td>
				<td><?= $usp->relacion_inmueble; ?></td>
				<td><?= $usp->titular; ?></td>
				<td align="right"><?= $usp->arrendatarios; ?></td>
				<td align="right"><?= $usp->fotos; ?></td>
				<td align="right"><?= $usp->archivos; ?></td>
				<td>
					<a onclick="javascript:editar('<?= $usp->id; ?>', '<?= $usp->ficha_predial; ?>')" style="cursor: pointer">
						<img src="<?= base_url(); ?>img/edit.png" title="Editar unidad social productiva">
					</a>
					<a onclick="javascript:archivos_social('<?= $usp->ficha_predial; ?>', '<?= $usp->id ?>')" style="cursor: pointer">
						<img src="<?= base_url(); ?>img/archivos.png" title="Subir archivos">
					</a>
					<?php echo anchor("archivos_controller/ver_fotos?ficha=".$usp->ficha_predial."&tipo=4&id=".$usp->id, '<img src="'.base_url().'img/camara.png"', 'title="Subir fotos"'); ?>
					<?php echo anchor("informes_controller/ficha_social_usp/".str_replace(' ', '_', $usp->id), '<img src="'.base_url().'img/excel.png"', 'title="Generar formato de caracterización unidad social productiva"'); ?>
					<?php echo anchor("informes_controller/ficha_social_registro_fotos/".$usp->ficha_predial.'/4/'.$usp->id, '<img src="'.base_url().'img/pdf.png"', 'title="Generar registro fotográfico"'); ?>
					<?php echo anchor("informes_controller/diagnostico_socioeconomico/".$usp->ficha_predial.'/4/'.$usp->id, '<img src="'.base_url().'img/pagos2.png"', 'title="Generar diagnóstico socioeconómico"'); ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<script type="text/javascript">
	$(document).ready(function(){
		$('#form table').dataTable({
			"scrollY": "400px",
            "scrollCollapse": true,
            "stateSave": true,
            "bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"stateSave": true,
		});

		//esta sentencia es para darle el estilo a los botones jquery.ui
	    $( "#form input[type=submit], #form input[type=button]").button();
	});
</script>
