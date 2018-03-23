<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/cupertino/jquery-ui-1.8.16.custom.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>css/estilo.css" type="text/css" media="screen" />
		<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
	</head>
	<body>
		<input type="button" value="Exportar informe a Excel" id="exportar">
		<div id="form">
			<table style="width:100%">
				<thead>
					<tr>
						<th rowspan="2">Unidad funcional</th>
						<th rowspan="2" width="5%">Ficha</th>
						<th rowspan="2">Abscisa inicial</th>
						<th rowspan="2">Abscisa final</th>
						<th rowspan="2">&Aacute;rea total terreno (m2)</th>
						<th rowspan="2">&Aacute;rea requerida (m2)</th>
						<th rowspan="2">&Aacute;rea remanente</th>
						<th rowspan="2">&Aacute;rea sobrante</th>
						<th rowspan="2">&Aacute;rea total requerida</th>
						<th class="ui-state-default" colspan="2">AVAL&Uacute;O</th>
						<th class="ui-state-default" colspan="4">OFERTA</th>
						<th class="ui-state-default" colspan="3">ACEPTACI&Oacute;N OFERTA</th>
						<th class="ui-state-default" colspan="3">EXPROPIACI&Oacute;N</th>
						<th rowspan="2">VALOR ANTICIPO</th>
						<th rowspan="2">SALDO</th>
						<th rowspan="2">TOTAL PAGADO</th>
						<th rowspan="2">VALOR M&sup2;</th>
						<th rowspan="2">No ESCRITURA FECHA NOTARIA</th>
						<th rowspan="2">ESTADO DEL PROCESO</th>
					</tr>
					<tr>
						<th>FECHA DE ENTREGA DEL AVAL&Uacute;O</th>
						<th>VALOR AVAL&Uacute;O</th>
						<th>FECHA DE OFERTA</th>
						<th>PERSONAL</th>
						<th>EDICTO</th>
						<th>FECHA VENCIMIENTO DE LA OFERTA</th>
						<th>SI</th>
						<th>NO</th>
						<th>FECHA PROBABLE DE ENTREGA VOLUNTARIA DEL INMUEBLE</th>
						<th>RESOLUCI&Oacute;N EXPROPIACI&Oacute;N</th>
						<th>FECHA DE NOTIFICACI&Oacute;N</th>
						<th>FECHA PROBABLE DE ENTREGA DEL INMUEBLE</th>
					</tr>
				</thead>
				<tbody>
					<?php echo count($registros); foreach ($registros as $registro){ ?>
						<tr>
							<td><?php $unidad = explode('-', $registro->ficha_predial); echo $unidad['0']; ?></td>
							<td><?php echo $registro->ficha_predial; ?></td>
							<td><?php echo $registro->abscisa_inicial; ?></td>
							<td><?php echo $registro->abscisa_final; ?></td>
							<?php
							$area_total = $registro->area_total;
							$area_requerida = $registro->area_requerida;
							$area_remanente = $registro->area_residual;
							$area_total_requerida = $area_requerida + $area_remanente;
							$area_sobrante = $area_total - $area_total_requerida;
							?>
							<td align="right"><?php echo number_format($area_total, 0, '', '.'); ?></td>
							<td align="right"><?php echo number_format($area_requerida, 0, '', '.'); ?></td>
							<td align="right"><?php echo number_format($area_remanente, 0, '', '.'); ?></td>
							<td align="right"><?php echo number_format($area_sobrante, 0, '', '.'); ?></td>
							<td align="right"><?php echo number_format($area_total_requerida, 0, '', '.'); ?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</body>
	<script type="text/javascript">
		$('table').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers"
		});

		$('#exportar').click(function(){
			window.location = "<?php echo site_url('informes_controller/gestion_predial_excel/'); ?>";
		});
	</script>
</html>