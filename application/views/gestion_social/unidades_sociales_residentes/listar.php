<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<img src="<?= base_url(); ?>img/edit.png" title="Actualizar" >: Actualizar Ficha
<img src="<?= base_url(); ?>img/archivos.png" title="Subir archivos" >: Subir Archivos
<img src="<?= base_url(); ?>img/camara.png" title="Subir fotos" >: Subir Fotos
<img src="<?= base_url(); ?>img/excel.png" title="Generar formato caracterización general" >: Caracterización unidad social residente
<img src="<?= base_url(); ?>img/pdf.png" title="Generar registro fotográfico" >: Registro fotográfico
<img src="<?= base_url(); ?>img/pagos2.png" title="Diagnóstico socioecónomico" >: Diagnóstico socioecónomico
<br><br>
<input type="button" onclick="javascript:crear()" value="Nuevo">
<br>

<table style="width:100%; font-size: 13px">
	<thead>
		<tr>
			<th>Ficha predial</th>
			<th>Relación con inmueble</th>
			<th>Responsable</th>
			<th>Integrantes</th>
			<th>Fotos</th>
			<th>Archivos</th>
			<th width="25%">Opciones</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($unidades_sociales_residentes as $usr): ?>
			<tr>
				<td><?php echo $usr->ficha_predial; ?></td>
				<td><?php echo $usr->relacion_inmueble; ?></td>
				<td><?php echo $usr->responsable; ?></td>
				<td align="right"><?php echo $usr->integrantes; ?></td>
				<td align="right"><?php echo $usr->fotos; ?></td>
				<td align="right"><?php echo $usr->archivos; ?></td>
				<td>
					<a onclick="javascript:editar('<?php echo $usr->id; ?>')" style="cursor: pointer">
						<img src="<?php echo base_url(); ?>img/edit.png" title="Editar información">
					</a>
					<a onclick="javascript:archivos_social('<?= $usr->ficha_predial; ?>', '<?= $usr->id ?>')" style="cursor: pointer">
						<img src="<?= base_url(); ?>img/archivos.png" title="Subir archivos">
					</a>
					<?php echo anchor("archivos_controller/ver_fotos?ficha=".$usr->ficha_predial."&tipo=3&id=".$usr->id, '<img src="'.base_url().'img/camara.png"', 'title="Subir fotos"'); ?>
					<?php echo anchor("informes_controller/ficha_social_usr/". $usr->id, '<img src="'.base_url().'img/excel.png"', 'title="Generar formato de caracterización general unidades residentes"'); ?>
					<?php echo anchor("informes_controller/ficha_social_registro_fotos/".$usr->ficha_predial.'/3/'.$usr->id, '<img src="'.base_url().'img/pdf.png"', 'title="Generar registro fotográfico"'); ?>
					<?php echo anchor("informes_controller/diagnostico_socioeconomico/".$usr->ficha_predial.'/3/'.$usr->id, '<img src="'.base_url().'img/pagos2.png"', 'title="Generar diagnóstico socioeconómico"'); ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#form table').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		});

		//esta sentencia es para darle el estilo a los botones jquery.ui
	    $( "#form input[type=submit], #form input[type=button]").button();
	});
</script>
