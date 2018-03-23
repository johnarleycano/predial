<script src="<?php echo base_url(); ?>js/ajaxupload.2.0.min.js"></script>
<?php $permisos = $this->session->userdata('permisos'); ?>
<ul id="navigation">
	<?php if(isset($permisos['Bit&aacute;cora']['Consultar'])) { ?><li><a href='#' rel="bitacora" title="Bit&aacute;cora"><img src="<?php echo base_url('img/bitacora.png'); ?>"></a></li><?php } ?>
	<?php if(isset($permisos['Archivos y Fotos']['Consultar'])) { ?><li><a href='#' rel="archivos" title="Ver Archivos"><img src="<?php echo base_url('img/archivos.png'); ?>"></a></li><?php } ?>
	<?php if(isset($permisos['Archivos y Fotos']['Consultar'])) { ?><li><a href='#' rel="fotos" title="Ver Fotos"><img src="<?php echo base_url('img/camara.png'); ?>"></a></li><?php } ?>
	<?php if(isset($permisos['Pagos']['Consultar'])) { ?><li><a href='#' rel="pagos" title="Ver Pagos"><img src="<?php echo base_url('img/pagos2.png'); ?>"></a></li><?php } ?>
</ul>

<div id="form">
	<?php
		echo form_fieldset('<b>Registro</b>');
		echo form_open('actualizar_controller/actualizar_predio');

		echo form_hidden($this->security->get_csrf_token_name(),$this->security->get_csrf_hash());
		echo form_label('Ficha predial:&nbsp;&nbsp;&nbsp;','ficha');

		echo form_input('ficha', $predio->ficha_predial, 'readonly');

		echo form_label('&nbsp;&nbsp;&nbsp;N&uacute;mero:&nbsp;&nbsp;&nbsp;','numero_ficha');
		echo form_input('numero_ficha', $descripcion->numero);

	?>
	<div class="clear">&nbsp;</div>

	<div id="accordion">
		<?php if (false) { ?>

		<!-- seccion 4 -->
		<h3><a href="#seccion4">GESTI&Oacute;N DE PROCESOS</a></h3>
		<div>
			<?php echo form_fieldset('<b>FICHA PREDIAL</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="30%"><?php echo form_label('Env&iacute;o a interventor&iacute;a','f_envio_int'); ?></td>
						<td width="20%"><?php echo form_input('f_envio_int', utf8_decode($identificacion->f_envio_int)); ?></td>
						<td width="30%"><?php echo form_label('Radicado','rad_env_int'); ?></td>
						<td width="20%"><?php echo form_input('rad_env_int', utf8_decode($identificacion->rad_env_int)); ?></td>
					</tr>
					<tr>
						<td width="30%"><?php echo form_label('Aprobaci&oacute;n','f_aprob_ficha'); ?></td>
						<td width="20%"><?php echo form_input('f_aprob_ficha', utf8_decode($identificacion->f_aprob_ficha)); ?></td>
						<td width="30%"><?php echo form_label('Radicado','rad_aprob_ficha'); ?></td>
						<td width="20%"><?php echo form_input('rad_aprob_ficha', utf8_decode($identificacion->rad_aprob_ficha)); ?></td>
					</tr>
					<tr>
						<td width="30%"><?php echo form_label('En corrección','f_rev_ficha'); ?></td>
						<td width="20%"><?php echo form_input('f_rev_ficha', utf8_decode($identificacion->f_rev_ficha)); ?></td>
						<td width="30%"><?php echo form_label('Radicado devolución ficha','rad_rev_ficha'); ?></td>
						<td width="20%"><?php echo form_input('rad_rev_ficha', utf8_decode($identificacion->rad_rev_ficha)); ?></td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>

			<?php echo form_fieldset('<b>FICHA SOCIAL</b>'); ?>
			<table style="text-align:'left'">
				<tr>
					<td width="30%"><?php echo form_label('Aprobación','f_aprob_soc'); ?></td>
					<td width="20%"><?php echo form_input('f_aprob_soc', utf8_decode($identificacion->f_aprob_soc)); ?></td>
					<td width="30%"><?php echo form_label('Radicado','rad_aprob_soc'); ?></td>
					<td width="20%"><?php echo form_input('rad_aprob_soc', utf8_decode($identificacion->rad_aprob_soc)); ?></td>
				</tr>
				<tr>
					<td width="30%"><?php echo form_label('Aprobación estudio de títulos','f_aprob_tit'); ?></td>
					<td width="20%"><?php echo form_input('f_aprob_tit', utf8_decode($identificacion->f_aprob_tit)); ?></td>
					<td width="30%"><?php echo form_label('Radicado','rad_aprob_tit'); ?></td>
					<td width="20%"><?php echo form_input('rad_aprob_tit', utf8_decode($identificacion->rad_aprob_tit)); ?></td>
				</tr>
				<tr>
					<td width="20%"><?php echo form_label('inicio del proceso de avalúo','envio_avaluador'); ?></td>
					<td width="30%"><?php echo form_input('envio_avaluador', utf8_decode($identificacion->f_envio_av)); ?></td>
					<td width="20%"><?php echo form_label('Radicado env&iacute;o avaluador','radicado_envio_avaluador'); ?></td>
					<td width="30%"><?php echo form_input('radicado_envio_avaluador', utf8_decode($identificacion->r_envio_av)); ?></td>
				</tr>
				<tr>
					<td><?php echo form_label('Fecha del aval&uacute;o','f_recibo_av'); ?></td>
					<td><?php echo form_input('f_recibo_av', utf8_decode($identificacion->f_recibo_av)); ?></td>
					<td width="20%"><?php echo form_label('Radicado aprobación','r_rec_av'); ?></td>
					<td width="30%"><?php echo form_input('r_rec_av', utf8_decode($identificacion->r_rec_av)); ?></td>
				</tr>
				<tr>
					<td><?php echo form_label('Fecha de la oferta de compra','f_oferta_c'); ?></td>
					<td><?php echo form_input('f_oferta_c', utf8_decode($identificacion->f_oferta_c)); ?></td>
					<td width="20%"><?php echo form_label('Radicado env&iacute;o avaluador','r_oferta_c'); ?></td>
					<td width="30%"><?php echo form_input('r_oferta_c', utf8_decode($identificacion->r_oferta_c)); ?></td>
				</tr>
				<tr>
					<td width="20%"><?php echo form_label('Oferta de compra notificada','f_oferta_notif'); ?></td>
					<td width="30%"><?php echo form_input('f_oferta_notif', utf8_decode($identificacion->f_oferta_notif)); ?></td>
					<td width="20%"><?php echo form_label('Radicado','rad_of_notif'); ?></td>
					<td width="30%"><?php echo form_input('rad_of_notif', utf8_decode($identificacion->rad_of_notif)); ?></td>
				</tr>
				<tr>
					<td width="20%"><?php echo form_label('Oferta de compra aceptada','f_oferta_ac'); ?></td>
					<td width="30%"><?php echo form_input('f_oferta_ac', utf8_decode($identificacion->f_oferta_ac)); ?></td>
					<td width="20%"><?php echo form_label('Radicado','rad_of_ac'); ?></td>
					<td width="30%"><?php echo form_input('rad_of_ac', utf8_decode($identificacion->rad_of_ac)); ?></td>
				</tr>

				<tr>
					<td width="20%"><?php echo form_label('Permiso de intervención','f_permiso_int'); ?></td>
					<td width="30%"><?php echo form_input('f_permiso_int', utf8_decode($identificacion->f_permiso_int)); ?></td>
					<td width="20%"><?php echo form_label('Radicado','rad_permiso_int'); ?></td>
					<td width="30%"><?php echo form_input('rad_permiso_int', utf8_decode($identificacion->rad_permiso_int)); ?></td>
				</tr>
				<tr>
					<td width="20%"><?php echo form_label('Firma de promesa','f_firma_prom'); ?></td>
					<td width="30%"><?php echo form_input('f_firma_prom', utf8_decode($identificacion->f_firma_prom)); ?></td>
					<td width="20%"><?php echo form_label('Radicado','rad_firma_prom'); ?></td>
					<td width="30%"><?php echo form_input('rad_firma_prom', utf8_decode($identificacion->rad_firma_prom)); ?></td>
				</tr>
			</table>
			<?php echo form_fieldset_close(); ?>

			<?php echo form_fieldset('<b>AVAL&Uacute;O</b>'); ?>
			<table style="text-align:'left'">

			</table>
			<?php echo form_fieldset_close(); ?>

			<?php echo form_fieldset('<b>OFERTA DE COMPRAVENTA</b>'); ?>
			<table style="text-align:'left'">

			</table>
			<?php echo form_fieldset_close(); ?>

			<?php echo form_fieldset('<b>OFERTA ACEPTADA</b>'); ?>
			<table style="text-align:'left'">

			</table>
			<?php echo form_fieldset_close(); ?>

			<?php echo form_fieldset('<b>EXPROPIACI&Oacute;N</b>'); ?>
			<table style="text-align:'left'">

			</table>
			<?php echo form_fieldset_close(); ?>
		</div>
		<?php } ?>

		<!-- seccion 1 -->
		<h3><a href="#seccion1">PREDIO REQUERIDO</a></h3>
		<div>
			<?php echo form_fieldset('<b>&Aacute;REAS TOTALES</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="20%"><?php echo form_label('Plano','area_total'); ?></td>
						<td width="30%"><?php echo form_input('area_total', utf8_decode($descripcion->area_total)); ?>m&sup2;</td>
						<td width="20%"><?php echo form_label('Catastral','area_total_catastral'); ?></td>
						<td width="30%"><?php echo form_input('area_total_catastral', utf8_decode($descripcion->area_total_catastral)); ?>m&sup2;</td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Registral','area_total_registral'); ?></td>
						<td width="30%"><?php echo form_input('area_total_registral', utf8_decode($descripcion->area_total_registral)); ?>m&sup2;</td>
						<td width="20%"><?php echo form_label('Títulos','area_total_titulos'); ?></td>
						<td width="30%"><?php echo form_input('area_total_titulos', utf8_decode($descripcion->area_total_titulos)); ?>m&sup2;</td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>

			<?php echo form_fieldset('<b>&Aacute;REAS PARCIALES</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="20%"><?php echo form_label('Requerida','area_requerida'); ?></td>
						<td width="30%"><?php echo form_input('area_requerida', utf8_decode($descripcion->area_requerida)); ?>m&sup2;</td>
						<td width="20%"><?php echo form_label('Remanente','area_residual'); ?></td>
						<td width="30%"><?php echo form_input('area_residual', utf8_decode($descripcion->area_residual)); ?>m&sup2;</td>
					</tr>

					<tr>
						<td width="20%"><?php echo form_label('construida','area_construida'); ?></td>
						<td width="30%"><?php echo form_input('area_construida', utf8_decode($descripcion->area_construida)); ?>m&sup2;</td>
						<td width="20%"><?php echo form_label('construida anexos','area_const_requerida'); ?></td>
						<td width="30%"><?php echo form_input('area_const_requerida', utf8_decode($descripcion->area_cons_requerida)); ?>m&sup2;</td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>

			<?php echo form_fieldset('<b>DESCRIPCI&Oacute;N</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="20%"><?php echo form_label('Uso Edificaci&oacute;n','uso_edificacion'); ?></td>
						<td width="30%"><?php echo form_input('uso_edificacion', utf8_decode($descripcion->uso_edificacion));?></td>
						<td width="20%"><?php echo form_label('Estado','estado'); ?></td>
						<td width="30%"><?php echo form_input('estado', utf8_decode($descripcion->estado_pre)) ;?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Uso de Terreno','uso_terreno'); ?></td>
						<td width="30%"><?php echo form_input('uso_terreno', utf8_decode($descripcion->uso_terreno));?></td>
						<td width="20%"><?php echo form_label('Tipo de Tenencia','tipo_tenencia'); ?></td>
						<td width="30%"><?php echo form_input('tipo_tenencia', utf8_decode($descripcion->tipo_tenencia)); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Topografia','topografia'); ?></td>
						<td width="30%"><?php echo form_input('topografia', utf8_decode($descripcion->topografia));?></td>
						<td width="20%"><?php echo form_label('Via de Acceso','via_acceso'); ?></td>
						<td width="30%"><?php echo form_input('via_acceso', utf8_decode($descripcion->via_acceso)); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Servicios P&uacute;blicos','servicios_publicos'); ?></td>
						<td width="30%"><?php echo form_dropdown('servicios_publicos', array(' ' => ' ', 'Si' => 'S&iacute;','No' => 'No'), utf8_decode($descripcion->serv_publicos)); ?></td>
						<td width="20%"><?php echo form_label('Nacimiento de Agua','nacimiento_agua'); ?></td>
						<td width="30%"><?php echo form_dropdown('nacimiento_agua', array(' ' => ' ', 'Si' => 'S&iacute;','No' => 'No'), utf8_decode($descripcion->nacimiento_agua)); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Abscisa inicial','abscisa_inicial'); ?></td>
						<td width="30%"><?php echo form_input('abscisa_inicial', utf8_decode($descripcion->abscisa_inicial)); ?></td>
						<td width="20%"><?php echo form_label('Margen','margen_inicial'); ?></td>
						<td width="30%"><?php echo form_dropdown('margen_inicial', array(' ' => ' ', 'DERECHA' => 'DERECHA','IZQUIERDA' => 'IZQUIERDA'), utf8_decode($descripcion->margen_inicial)); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Abscisa Final','abscisa_final'); ?></td>
						<td width="30%"><?php echo form_input('abscisa_final', utf8_decode($descripcion->abscisa_final)); ?></td>
						<td width="20%"><?php echo form_label('Margen','margen_final'); ?></td>
						<td width="30%"><?php echo form_dropdown('margen_final', array(' ' => ' ', 'DERECHA' => 'DERECHA','IZQUIERDA' => 'IZQUIERDA'), utf8_decode($descripcion->margen_final)); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Estado del Proceso','estado_proceso'); ?></td>
						<?php
							$estado_proceso = array(' ' => ' ');
							foreach($estados as $estado):
								$estado_proceso[$estado->estado] = $estado->estado;
							endforeach;
						?>
						<td width="30%"><?php echo form_dropdown('estado_proceso', $estado_proceso, utf8_decode($identificacion->estado_pro)); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Entregado','entregado'); ?></td>
						<td width="30%"><?php echo form_dropdown('entregado', array(' ' => ' ', 'SI' => 'S&iacute;','NO' => 'No'), utf8_decode($identificacion->entregado)); ?></td>
						<td width="20%"><?php echo form_label('Fecha Entregado','fecha_entregado'); ?></td>
						<td width="30%"><?php echo form_input('fecha_entregado', utf8_decode($identificacion->f_entregado)); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Radicado','radicado'); ?></td>
						<td width="30%"><?php echo form_input('radicado', utf8_decode($identificacion->rad_ent)); ?></td>
						<td width="20%"><?php echo form_label('Requerido','requerido'); ?></td>
						<td width="30%"><?php echo form_dropdown('requerido', array(1 => 'S&iacute;', 0 => 'No'), $predio->requerido); ?></td>
					</tr>
				</tbody>
			</table>
			<div align="center">
				<?php echo form_label('Observaci&oacute;n','observacion')?><br>
				<?php echo form_textarea('observacion', utf8_decode($descripcion->observacion));?>
			</div>
			<?php echo form_fieldset_close(); ?>
		</div>


		<!-- seccion 2 -->
		<h3><a href="#seccion2">PREDIO ORIGINAL</a></h3>
		<div>
			<div class="clear">&nbsp;</div>
			<?php echo form_fieldset('<b>Identificaci&oacute;n del predio</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="20%"><?php echo form_label('Municipio','municipio'); ?></td>
						<td width="30%"><?php echo form_input('municipio', utf8_decode($identificacion->municipio)); ?></td>
						<td width="20%"><?php echo form_label('Vereda o Barrio','vereda_barrio'); ?></td>
						<td width="30%"><?php echo form_input('vereda_barrio', utf8_decode($identificacion->barrio)); ?></td>
					</tr>
					<tr>
						<td width="30%"><?php echo form_label('Direcci&oacute;n / Nombre','direccion_nombre'); ?></td>
						<td width="20%"><?php echo form_input('direccion_nombre', utf8_decode($identificacion->direccion)); ?></td>
						<td width="30%"><?php echo form_label('Tramo','tramo'); ?></td>
						<?php
							$_tramos = array(' ' => ' ');
							foreach($tramos as $tramo):
								$_tramos[$tramo->tramo] = $tramo->tramo;
							endforeach;
						?>
						<td width="20%"><?php echo form_dropdown('tramo', $_tramos, utf8_decode($descripcion->tramo)); ?></td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>
			<div class="clear">&nbsp;</div>
			<?php echo form_fieldset('<b>Informaci&oacute;n jur&iacute;dica del predio inicial</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="20%"><?php echo form_label('N&uacute;mero de matr&iacute;cula','numero_matricula_predio_inicial'); ?></td>
						<td width="30%"><?php echo form_input('numero_matricula_predio_inicial', utf8_decode($identificacion->matricula_orig)); ?></td>
						<td width="20%"><?php echo form_label('Fecha','fecha_predio_inicial'); ?></td>
						<td width="30%"><?php echo form_input('fecha_predio_inicial', utf8_decode($identificacion->fecha_escritura)); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Oficina registro','oficina_registro_predio_inicial'); ?></td>
						<td><?php echo form_input('oficina_registro_predio_inicial', utf8_decode($identificacion->of_registro)); ?></td>
						<td><?php echo form_label('N&uacute;mero de la notar&iacute;a','numero_notaria_predio_inicial'); ?></td>
						<td><?php echo form_input('numero_notaria_predio_inicial', utf8_decode($identificacion->no_notaria)); ?></td>
					</tr>
					<tr>
						<td width="30%"><?php echo form_label('N&uacute;mero de escritura','numero_escritura'); ?></td>
						<td width="20%"><?php echo form_input('numero_escritura', utf8_decode($identificacion->escritura_orig)); ?></td>
						<td width="30%"><?php echo form_label('N&uacute;mero catastral','numero_catastral_predio_inicial'); ?></td>
						<td width="20%"><?php echo form_input('numero_catastral_predio_inicial', utf8_decode($identificacion->no_catastral)); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Ciudad','ciudad_predio_inicial'); ?></td>
						<td><?php echo form_input('ciudad_predio_inicial', utf8_decode($identificacion->ciudad)); ?></td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>
		</div>

		<!-- seccion 3 -->
		<h3><a href="#seccion3">PROPIETARIOS</a></h3>
		<div>
			<?php $id = 0;?>
			<?php foreach ($propietarios as $propietario): ?>
				<?php $id++; ?>
				<?php echo form_fieldset("<b>Identificaci&oacute;n del propietario $id</b>", "id='$id'"); ?>
					<table style="text-align:left">
						<tbody>
							<tr>
								<td width="20%"><?php echo form_label('Tipo documento', "tipo_documento$id"); ?></td>
								<td width="30%"><?php echo form_dropdown("tipo_documento$id", array(' ' => ' ', 'Cedula' => 'CC','Nit' => 'Nit'), utf8_decode($propietario->tipo_documento)); ?></td>
								<td width="20%"><?php echo form_label('Propietario', "propietario$id"); ?></td>
								<td width="30%"><?php echo form_input("propietario$id", utf8_decode($propietario->nombre), 'readonly'); ?></td>
							</tr>
							<tr>
								<td width="20%"><?php echo form_label('Documento', "documento_propietario$id"); ?></td>
								<td width="30%"><?php echo form_input("documento_propietario$id", utf8_decode($propietario->documento), 'readonly'); ?></td>
								<td width="20%"><?php echo form_label('Tel&eacute;fono', "telefono$id"); ?></td>
								<td width="30%"><?php echo form_input("telefono$id", utf8_decode($propietario->telefono), 'readonly'); ?></td>
							</tr>
							<tr>
							<tr>
								<td width="20%"><?php echo form_label('Dirección', "direccion_propietario$id"); ?></td>
								<td width="30%"><?php echo form_input("direccion_propietario$id", utf8_decode($propietario->direccion)); ?></td>
								<td width="20%"><?php echo form_label('Correo electrónico', "email_propietario$id"); ?></td>
								<td width="30%"><?php echo form_input("email_propietario$id", utf8_decode($propietario->email)); ?></td>
							</tr>
							<tr>
								<td width="20%"><?php echo form_label('Participaci&oacute;n', "participacion$id"); ?></td>
								<td width="30%"><?php echo form_input("participacion$id", utf8_decode($propietario->participacion)); ?>%</td>
								<td>
									<?php
										$boton_eliminar = array(
											'type' => 'button',
											'name' => "boton_eliminar$id",
											'id' => "boton_eliminar$id",
											'value' => 'Eliminar propietario'
										);
										echo form_input($boton_eliminar);
									?>
								</td>
								<td><?php echo form_hidden("id_propietario$id", $propietario->id_propietario); ?></td>
							</tr>
						</tbody>
					</table>
				<?php echo form_fieldset_close(); ?>
			<?php endforeach;?>
			<input type="hidden" name="propietarios_hidden" id="propietarios_hidden" value="<?php echo $id; ?>" />
			<?php echo form_label('No. de propietarios:', 'agregar')?>
			<?php echo form_input('agregar'); ?>
			<?php
				$boton_agregar = array(
					'type' => 'button',
					'name' => 'boton_agregar',
					'id' => 'boton_agregar',
					'value' => 'Agregar'
				);
				echo form_input($boton_agregar);
			?>
		</div>

		<!-- seccion 5 -->
		<h3><a href="#seccion5">ESTUDIO DE T&Iacute;TULOS</a></h3>
		<div>
			<?php echo form_fieldset('<b>Fecha</b>'); ?>
			<table>
				<?php
				$_titulos_adq = array(' ' => ' ');
				foreach($titulos_adquisicion as $titulo_adq):
					$_titulos_adq[$titulo_adq->id] = $titulo_adq->nombre;
				endforeach;
				?>

				<tr>
					<td width="20%"><?php echo form_label('Fecha del estudio','fecha_estudio'); ?></td>
					<td width="30%"><?php echo form_input('fecha_estudio', utf8_decode($identificacion->fecha_estudio)); ?></td>
					<td width="20%"><?php echo form_label('T&iacute;tulo de adquisici&oacute;n','titulo_adquisicion'); ?></td>
					<td width="30%"><?php echo form_dropdown('titulo_adquisicion', $_titulos_adq, utf8_decode($identificacion->titulo_adquisicion)); ?></td>
				</tr>
			</table>
			<?php echo form_fieldset_close(); ?>
			<?php echo form_fieldset('<b>T&iacute;tulos de adquisici&oacute;n</b>'); ?>
			<div align="center"><?php echo form_textarea('titulos_adquisicion', utf8_decode($identificacion->titulos_adq)); ?></div>
			<?php echo form_fieldset_close(); ?>
			<?php echo form_fieldset('<b>Linderos seg&uacute;n t&iacute;tulo</b>'); ?>
			<div align="center"><?php echo form_textarea('linderos_segun_titulo', utf8_decode($identificacion->lind_titulo)); ?></div>
			<?php echo form_fieldset_close(); ?>
			<?php echo form_fieldset('<b>Linderos predio requerido</b>'); ?>
			<div align="center"><?php echo form_textarea('linderos_predio_requerido', utf8_decode($linderos->linderos)); ?></div>
			<?php echo form_fieldset_close(); ?>
			<?php echo form_fieldset('<b>Grav&aacute;menes - Limitaciones</b>'); ?>
			<div align="center"><?php echo form_textarea('gravamenes_limitaciones', utf8_decode($identificacion->gravamenes)); ?></div>
			<?php echo form_fieldset_close(); ?>
			<?php echo form_fieldset('<b>Documentos estudiados</b>'); ?>
			<div align="center"><?php echo form_textarea('documentos_estudiados', utf8_decode($identificacion->doc_estud)); ?></div>
			<?php echo form_fieldset_close(); ?>
			<?php echo form_fieldset('<b>Observaciones estudio de t&iacute;tulos</b>'); ?>
			<div align="center"><?php echo form_textarea('observaciones_estudio_titulos', utf8_decode($identificacion->ob_titu)); ?></div>
			<?php echo form_fieldset_close(); ?>
			<?php echo form_fieldset('<b>Concepto</b>'); ?>
			<div align="center"><?php echo form_textarea('concepto', utf8_decode($identificacion->conc_titu)); ?></div>
			<?php echo form_fieldset_close(); ?>
			<?php echo form_fieldset('<b>Segregaciones del inmueble</b>'); ?>
			<div align="center"><?php echo form_textarea('segregaciones', utf8_decode($identificacion->segreg_titu)); ?></div>
			<?php echo form_fieldset_close(); ?>
		</div>

		<!-- seccion 6 -->
		<h3><a href="#seccion6">GESTI&Oacute;N PREDIAL</a></h3>
		<div>
			<?php echo form_fieldset('<b>Identificaci&oacute;n</b>')?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="30%"><?php echo form_label('Inicio del trabajo f&iacute;sico','inicio_trabajo_fisico'); ?></td>
						<td width="20%"><?php echo form_input('inicio_trabajo_fisico', utf8_decode($identificacion->f_inicio_trab)); ?></td>
						<?php
							$_contratistas = array(' ' => ' ');
							foreach($contratistas as $contratista):
								$_contratistas[$contratista->id_cont] = $contratista->nombre;
							endforeach;
						?>
						<td width="30%"><?php echo form_label('Encargado gesti&oacute;n predial','encargado_gestion_predial'); ?></td>
						<td width="20%"><?php echo form_dropdown('encargado_gestion_predial',$_contratistas, utf8_decode($identificacion->enc_gestion)); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Entrega del plano a interventor&iacute;a','entrega_plano_interventoria'); ?></td>
						<td><?php echo form_input('entrega_plano_interventoria', utf8_decode($identificacion->f_ent_plano_int)); ?></td>
						<td><?php echo form_label('Radicado entrega interventor&iacute;a','radicado_entrega_interventoria'); ?></td>
						<td><?php echo form_input('radicado_entrega_interventoria', utf8_decode($identificacion->rad_int)); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Aprobaci&oacute;n definitiva del plano','aprobacion_definitiva_plano'); ?></td>
						<td><?php echo form_input('aprobacion_definitiva_plano', utf8_decode($identificacion->f_apro_def)); ?></td>
						<td><?php echo form_label('Radicado aprobaci&oacute;n plano','radicado_aprobacion_plano'); ?></td>
						<td><?php echo form_input('radicado_aprobacion_plano', utf8_decode($identificacion->rad_apro_pla)); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Notificaci&oacute;n propietario','notificacion_propietario'); ?></td>
						<td width="30%"><?php echo form_input('notificacion_propietario', utf8_decode($identificacion->f_notificacion_pro)); ?></td>
						<td width="20%"><?php echo form_label('Radicado notificaci&oacute;n propietario','radicado_notificacion_propietario'); ?></td>
						<td width="30%"><?php echo form_input('radicado_notificacion_propietario', utf8_decode($identificacion->rad_no_pro)); ?></td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>
			<div class="clear">&nbsp;</div>

			<?php echo form_fieldset('<b>Aval&uacute;o</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="30%"><?php echo form_label('Total aval&uacute;o','total_avaluo'); ?></td>
						<td width="20%"><?php echo form_input('total_avaluo', utf8_decode($identificacion->total_avaluo)); ?></td>
						<td width="30%"><?php echo form_label('Valor total de mejoras','valor_total_mejoras'); ?></td>
						<td width="20%"><?php echo form_input('valor_total_mejoras', utf8_decode($identificacion->valor_total_mej)); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Valor metro cuadrado','valor_metro_cuadrado'); ?></td>
						<td><?php echo form_input('valor_metro_cuadrado', utf8_decode($identificacion->valor_mtr)); ?></td>
						<td><?php echo form_label('Valor total del terreno','valor_total_terreno'); ?></td>
						<td><?php echo form_input('valor_total_terreno', utf8_decode($identificacion->valor_total_terr)); ?></td>
					</tr>
					<tr>

					</tr>
				</tbody>
			</table>

			<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<title>Document</title>
			</head>
			<body>

			</body>
			</html>

			<?php echo form_fieldset_close(); ?>
			<div class="clear">&nbsp;</div>
			<?php echo form_fieldset('<b>Jur&iacute;dica</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="20%"><?php echo form_label('Env&iacute;o a la gerencia para firmar','envio_gerencia_firmar'); ?></td>
						<td width="30%"><?php echo form_input('envio_gerencia_firmar', utf8_decode($identificacion->f_envio_ger)); ?></td>
						<td width="20%"><?php echo form_label('Radicado env&iacute;o a gerencia','radicado_envio_gerencia'); ?></td>
						<td width="30%"><?php echo form_input('radicado_envio_gerencia', utf8_decode($identificacion->rad_env_ger)); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Recibo para la notificaci&oacute;n al propietario','recibo_notificacion_propietario'); ?></td>
						<td><?php echo form_input('recibo_notificacion_propietario', utf8_decode($identificacion->f_recibo_pro)); ?></td>
					</tr>
			</table>
			<?php echo form_fieldset_close(); ?>
			<div class="clear">&nbsp;</div>
			<?php echo form_fieldset('<b>Enajenaci&oacute;n voluntaria</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="30%"><?php echo form_label('Env&iacute;o escritura a notar&iacute;a','envio_escritura_notaria'); ?></td>
						<td width="20%"><?php echo form_input('envio_escritura_notaria', utf8_decode($identificacion->env_esc_not)); ?></td>
						<td width="30%"><?php echo form_label('Ingreso escritura','ingreso_escritura'); ?></td>
						<td width="20%"><?php echo form_input('ingreso_escritura', utf8_decode($identificacion->ing_esc)); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Recibo de registro','recibo_registro_enajenacion'); ?></td>
						<td width="30%"><?php echo form_input('recibo_registro_enajenacion', utf8_decode($identificacion->rec_reg_vol)); ?></td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>
			<div class="clear">&nbsp;</div>
			<?php echo form_fieldset('<b>Expropiaci&oacute;n</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="30%"><?php echo form_label('Notificaci&oacute;n','notificacion'); ?></td>
						<td width="20%"><?php echo form_input('notificacion', utf8_decode($identificacion->notif)); ?></td>
						<td width="30%"><?php echo form_label('Inicio juicio','inicio_juicio'); ?></td>
						<td width="20%"><?php echo form_input('inicio_juicio', utf8_decode($identificacion->ini_juic)); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Inicio Sentencia','inicio_sentencia'); ?></td>
						<td width="30%"><?php echo form_input('inicio_sentencia', utf8_decode($identificacion->ini_sent)); ?></td>
						<td width="20%"><?php echo form_label('Ingreso sentencia registro','ingreso_sentencia_registro'); ?></td>
						<td width="30%"><?php echo form_input('ingreso_sentencia_registro', utf8_decode($identificacion->ing_sent)); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Recibo de registro','recibo_registro_expropiacion'); ?></td>
						<td><?php echo form_input('recibo_registro_expropiacion', utf8_decode($identificacion->rec_reg_exp)); ?></td>
					</tr>
			</table>
			<?php echo form_fieldset_close(); ?>
			<div class="clear">&nbsp;</div>
			<?php echo form_fieldset('<b>Informaci&oacute;n jur&iacute;dica del predio final</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="20%"><?php echo form_label('N&uacute;mero de la matr&iacute;cula','numero_matricula_predio_final'); ?></td>
						<td width="30%"><?php echo form_input('numero_matricula_predio_final', utf8_decode($identificacion->num_matricula_f)); ?></td>
						<td width="20%"><?php echo form_label('Fecha','fecha_predio_final'); ?></td>
						<td width="30%"><?php echo form_input('fecha_predio_final', utf8_decode($identificacion->fecha_esc_f)); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Oficina registro','oficina_registro_predio_final'); ?></td>
						<td><?php echo form_input('oficina_registro_predio_final', utf8_decode($identificacion->of_registro_f)); ?></td>
						<td><?php echo form_label('N&uacute;mero de la notar&iacute;a','numero_notaria_predio_final'); ?></td>
						<td><?php echo form_input('numero_notaria_predio_final', utf8_decode($identificacion->num_notaria_f)); ?></td>
					</tr>
					<tr>
						<td width="30%"><?php echo form_label('Escritura o sentencia','escritura_sentencia'); ?></td>
						<td width="20%"><?php echo form_input('escritura_sentencia', utf8_decode($identificacion->num_escritura_f)); ?></td>
						<td width="30%"><?php echo form_label('N&uacute;mero catastral','numero_catastral_predio_final'); ?></td>
						<td width="20%"><?php echo form_input('numero_catastral_predio_final', utf8_decode($identificacion->num_catastral_f)); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Ciudad','ciudad_predio_final'); ?></td>
						<td><?php echo form_input('ciudad_predio_final', utf8_decode($identificacion->ciudad_f)); ?></td>
					</tr>
				</tbody>
			</table>
			<?php echo form_fieldset_close(); ?>
		</div>



		<!-- seccion 7 -->
		<h3><a href="#seccion7">FICHA PREDIAL</a></h3>
		<div>
			<!-- DATOS B&Aacute;SICOS -->
			<?php echo form_fieldset('<b>DATOS B&Aacute;SICOS</b>'); ?>
				<table style="text-align:left" width="100%">
					<tbody>

					</tbody>
				</table>
			<?php echo form_fieldset_close(); ?>

			<!-- LINDEROS -->
			<?php echo form_fieldset('<b>LINDEROS</b>'); ?>
				<table style="text-align:left" width="100%">
					<tbody>
						<tr>
							<td width="15%"><b></b></td>
							<td><b>LONGITUD</b></td>
							<td><b>COLINDANTES</b></td>
						</tr>
						<tr>
							<td><?php echo form_label('NORTE','norte_long'); ?></td>
							<td><?php echo form_input('norte_long', utf8_decode($linderos->norte_long));?></td>
							<td><?php echo form_input('nom_norte', utf8_decode($linderos->nom_norte));?></td>
						</tr>
						<tr>
							<td><?php echo form_label('SUR','sur_long'); ?></td>
							<td><?php echo form_input('sur_long', utf8_decode($linderos->sur_long));?></td>
							<td><?php echo form_input('nom_sur', utf8_decode($linderos->nom_sur));?></td>
						</tr>
						<tr>
							<td><?php echo form_label('ORIENTE','oriente_long'); ?></td>
							<td><?php echo form_input('oriente_long', utf8_decode($linderos->oriente_long));?></td>
							<td><?php echo form_input('nom_oriente', utf8_decode($linderos->nom_oriente));?></td>
						</tr>
						<tr>
							<td><?php echo form_label('OCCIDENTE','occidente_long'); ?></td>
							<td><?php echo form_input('occidente_long', utf8_decode($linderos->occidente_long));?></td>
							<td><?php echo form_input('nom_occ', utf8_decode($linderos->nom_occ));?></td>
						</tr>
					</tbody>
				</table>
			<?php echo form_fieldset_close(); ?>

			<!-- INVENTARIO DE CULTIVOS Y ESPECIES -->
			<?php echo form_fieldset('<b>INVENTARIO DE CULTIVOS Y ESPECIES</b>'); ?>
				<table style="text-align:left" width="100%">
					<tbody>
						<tr>
							<td align="center"><b>DESCRIPCI&Oacute;N</b></td>
							<td align="center"><b>CANT.</b></td>
							<td align="center"><b>DENS.</b></td>
							<td align="center"><b>UN.</b></td>
						</tr>
						<!-- Se lista la información de los cultivos -->
						<?php foreach ($this->PrediosDAO->obtener_cultivos($predio->ficha_predial) as $cultivo) { ?>
							<tr>
								<td><?php echo $cultivo->numero; ?>. <?php echo form_input('cultivo_descr'.$cultivo->numero, utf8_decode($cultivo->descripcion));?></td>
								<td><?php echo form_input('cultivo_cant'.$cultivo->numero, utf8_decode($cultivo->cantidad));?></td>
								<td><?php echo form_input('cultivo_dens'.$cultivo->numero, utf8_decode($cultivo->densidad));?></td>
								<td><?php echo form_input('cultivo_un'.$cultivo->numero, utf8_decode($cultivo->unidad));?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php echo form_fieldset_close(); ?>

			<!-- DESCRIPCIÓN DE LAS CONSTRUCCIONES -->
			<?php echo form_fieldset('<b>DESCRIPCI&OacuteN DE LAS CONSTRUCCIONES</b>'); ?>
				<table style="text-align:left" width="100%">
					<tbody>
						<tr>
							<td align="center"><b>&Iacute;TEM.</b></td>
							<td align="center"><b>DESCRIPCI&Oacute;N</b></td>
							<td align="center"><b>CANT.</b></td>
							<td align="center"><b>UN.</b></td>
						</tr>
						<!-- Se lista la información de las construcciones -->
						<?php foreach ($this->PrediosDAO->obtener_construcciones($predio->ficha_predial, '1') as $construccion) { ?>
							<tr>
								<td><?php echo $construccion->numero; ?>. <?php //echo form_input('const_item'.$construccion->numero, utf8_decode($construccion->item));?></td>
								<td><?php echo form_input('const_desc'.$construccion->numero, utf8_decode($construccion->descripcion));?></td>
								<td><?php echo form_input('const_cant'.$construccion->numero, utf8_decode($construccion->cantidad));?></td>
								<td><?php echo form_input('const_un'.$construccion->numero, utf8_decode($construccion->unidad));?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php echo form_fieldset_close(); ?>

			<!-- DESCRIPCIÓN DE LAS CONSTRUCCIONES ANEXAS -->
			<?php echo form_fieldset('<b>DESCRIPCI&Oacute;N DE LAS CONSTRUCCIONES ANEXAS</b>'); ?>
				<table style="text-align:left" width="100%">
					<tbody>
						<tr>
							<td align="center"><b>&Iacute;TEM.</b></td>
							<td align="center"><b>DESCRIPCI&Oacute;N</b></td>
							<td align="center"><b>CANT.</b></td>
							<td align="center"><b>UN.</b></td>
						</tr>
						<!-- Se lista la información de las construcciones anexas -->
						<?php foreach ($this->PrediosDAO->obtener_construcciones($predio->ficha_predial, '2') as $construccion) { ?>
							<tr>
								<td><?php echo $construccion->numero; ?>. <?php //echo form_input('const_an_item'.$construccion->numero, utf8_decode($construccion->item));?></td>
								<td><?php echo form_input('const_an_desc'.$construccion->numero, utf8_decode($construccion->descripcion));?></td>
								<td><?php echo form_input('const_an_cant'.$construccion->numero, utf8_decode($construccion->cantidad));?></td>
								<td><?php echo form_input('const_an_un'.$construccion->numero, utf8_decode($construccion->unidad));?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>

				<!-- CHECKS -->
				<table style="text-align:left" width="100%">
					<tr>
						<?php if($linderos->c_licencia == '1'){$c_licencia = "checked";}else{$c_licencia = "";} ?>
						<td><input type="checkbox" id="c_licencia" name="c_licencia" value="1" <?php echo $c_licencia; ?>></td>
						<td>Tiene el inmueble licencia urban&iacute;stica, Urbanizaci&oacute;n, parcelaci&oacute;n, subdivisi&oacute;n, construcci&oacute;n, Intervenci&oacute;n, Espacio P&uacute;blico?</td>
					</tr>
					<tr>
						<?php if($linderos->c_reglamento == '1'){$c_reglamento = "checked";}else{$c_reglamento = "";} ?>
						<td><input type="checkbox" id="c_reglamento" name="c_reglamento" value="1" <?php echo $c_reglamento; ?>></td>
						<td>Tiene el inmueble reglamento de Propiedad Horizontal LEY 675 DE 2001?</td>
					</tr>
					<tr>
						<?php if($linderos->c_levantamiento == '1'){$c_levantamiento = "checked";}else{$c_levantamiento = "";} ?>
						<td><input type="checkbox" id="c_levantamiento" name="c_levantamiento" value="1" <?php echo $c_levantamiento; ?>></td>
						<td>Tiene el inmueble aprobado plan parcial en el momento del levantamiento de la Ficha Predial?</td>
					</tr>
					<tr>
						<?php if($linderos->c_informe == '1'){$c_informe = "checked";}else{$c_informe = "";} ?>
						<td><input type="checkbox" id="c_informe" name="c_informe" value="1" <?php echo $c_informe; ?>></td>
						<td>Aplica Informe de an&aacute;lisis de &Aacute;rea Remanente?</td>
					</tr>
					<tr>
						<?php if($linderos->c_adquisicion == '1'){$c_adquisicion = "checked";}else{$c_adquisicion = "";} ?>
						<td><input type="checkbox" id="c_adquisicion" name="c_adquisicion" value="1" <?php echo $c_adquisicion; ?>></td>
						<td>De acuerdo al estudio de t&iacute;tulos, la franja que estipula el decreto 2770 debe adquirirse?</td>
					</tr>
				</table>
			<?php echo form_fieldset_close(); ?>
		</div>

		<!-- seccion 8 -->
		<h3><a href="#seccion8">S&Aacute;BANA</a></h3>
		<div>
			<?php echo form_fieldset('<b>Semáforo</b>'); ?>
			<table style="text-align:'left'">
				<tbody>
					<tr>
						<td width="20%"><?php echo form_label('Función del predio en la obra','funcion_predio', "style='width: 30%;'"); ?></td>
						<?php
							$_funciones = array(' ' => ' ');
							foreach($funciones_predios_obra as $funciones):
								$_funciones[$funciones->id] = $funciones->nombre;
							endforeach;
						?>
						<td width="20%"><?php echo form_dropdown('funcion_predio',$_funciones, $identificacion->id_funcion_predio, "style='width: 100%;'"); ?></td>

						<?php
							$_estados_via = array(' ' => ' ');
							foreach($estados_via as $estado_via):
								$_estados_via[$estado_via->id] = $estado_via->nombre;
							endforeach;
						?>
						<td width="20%"><?php echo form_label('Estado de la vía','estado_via', "style='width: 30%;'"); ?></td>
						<td width="20%"><?php echo form_dropdown('estado_via',$_estados_via, $identificacion->id_estado_via, "style='width: 100%;'"); ?></td>
					</tr>
					<tr>
						<td width="20%"><?php echo form_label('Estado del predio en obra','estado_predio'); ?></td>
						<td width="20%">
							<?php echo form_dropdown('estado_predio', array(' ' => ' ', '1' => 'Disponible','0' => 'No disponible'), utf8_decode($identificacion->estado_predio)); ?>
						</td>
					</tr>
				<tbody>
			</table>
			<?php echo form_fieldset_close(); ?>
			<div class="clear">&nbsp;</div>

			<!-- DATOS GENERALES -->
			<?php echo form_fieldset('<b>Datos generales</b>'); ?>
				<table style="text-align:left">
					<tbody>
						<tr>
							<td width="20%"><?php echo form_label('Estado ambiental','estado_ambiental'); ?></td>
							<td width="30%"><?php echo form_dropdown('estado_ambiental', array('1' => 'Disponible','0' => 'No disponible'), utf8_decode($descripcion->estado_ambiental)); ?></td>
							<td width="20%"><?php echo form_label('Meta contractual (A&ntilde;o YYYY)','meta_contractual'); ?></td>
							<td width="30%"><?php echo form_input('meta_contractual'); ?></td>
						</tr>

						<tr>
							<td width="20%"><?php echo form_label('Disponibilidad izquierda','disponibilidad_izquierda'); ?></td>
							<td width="30%"><?php echo form_dropdown('disponibilidad_izquierda', array('0' => 'No disponible - Negocio', '2' => 'No disponible - Expropiaci&oacute;n', '1' => 'Disponible'), $descripcion->disponibilidad_izquierda); ?></td>
							<td width="20%"><?php echo form_label('Disponibilidad derecha','disponibilidad_derecha'); ?></td>
							<td width="30%"><?php echo form_dropdown('disponibilidad_derecha', array('0' => 'No disponible - Negocio', '2' => 'No disponible - Expropiaci&oacute;n', '1' => 'Disponible'), $descripcion->disponibilidad_derecha); ?></td>
						</tr>
					</tbody>
				</table>
			<?php echo form_fieldset_close(); ?>
			<div class="clear">&nbsp;</div>

			<!--AVALÚO COMERCIAL CORPORATIVO -->
			<?php echo form_fieldset('<b>Aval&uacute;o comercial corporativo</b>'); ?>
				<table style="text-align:left">
					<tbody>
						<tr>
							<td width="20%"><?php echo form_label('Fecha remisi&oacute;n insumos','fecha_remision_insumos'); ?></td>
							<td width="30%"><?php echo form_input('fecha_remision_insumos', utf8_decode($descripcion->fecha_remision_insumos)); ?></td>
							<!-- <td width="20%"><?php // echo form_label('Fecha remisión insumos','fecha_remision_insumo'); ?></td>
							<td width="30%"><?php // echo form_input('fecha_remision_insumo'); ?></td> -->
						</tr>
					</tbody>
				</table>
			<?php echo form_fieldset_close(); ?>
			<div class="clear">&nbsp;</div>
		</div>
		<!-- LISTA DE VÉRTICES  -->
		<h3><a href= "#seccion9">VÉRTICES</a></h3>
		<div>
			<div id="error"></div>
			<label for="btn_subir_csv">Actualizar registros (CSV)</label>
			<input type="file" id="btn_subir_csv">
			<div id="vertices"></div>
			<p style="font-size:0.8em;">
				Src: Magna-Sirgas / Colombia Bogotá Zone
			</p>
		</div>
	</div>

	<br /><input type="hidden" id="errores" />
	<div class="clear">&nbsp;</div>
	<input type="hidden" id="boton_hidden" name="boton_hidden" value="" />
	<?php
		$guardar = array(
			'type' => 'button',
			'name' => 'guardar',
			'id' => 'guardar',
			'value' => 'Guardar y volver'
		);
		echo form_input($guardar);

		$continuar = array(
			'type' => 'button',
			'name' => 'continuar',
			'id' => 'continuar',
			'value' => 'Guardar y continuar'
		);
		echo form_input($continuar);

		$salir = array(
			'type' => 'button',
			'name' => 'salir',
			'id' => 'salir',
			'value' => 'Cancelar y volver'
		);
		echo form_input($salir).'<br>';

		$permisos = $this->session->userdata('permisos');

		if(isset($permisos['Bit&aacute;cora']['Consultar'])) {
			$bitacora = array(
				'type' => 'button',
				'name' => 'bitacora',
				'id' => 'bitacora',
				'value' => 'Ir a la Bitacora'
			);
			echo form_input($bitacora);
		}

		if(isset($permisos['Archivos y Fotos']['Consultar'])) {
			$archivos = array(
				'type' => 'button',
				'name' => 'archivos',
				'id' => 'archivos',
				'value' => 'Ver archivos'
			);
			echo form_input($archivos);

			$fotos = array(
				'type' => 'button',
				'name' => 'fotos',
				'id' => 'fotos',
				'value' => 'Ver fotos'
			);
			echo form_input($fotos);
		}

		if(isset($permisos['Pagos']['Consultar'])) {
			$pagos = array(
				'type' => 'button',
				'name' => 'pagos',
				'id' => 'pagos',
				'value' => 'Ver pagos'
			);
			echo form_input($pagos);
		}

		echo form_close();
		echo form_fieldset_close();
	?>
</div>
<script type="text/javascript">
	var datos = {};
	new AjaxUpload('#btn_subir_csv', {
		action: '<?php echo site_url("archivos_controller/subir_csv"); ?>',
		type: 'POST',
		data: datos,
		onSubmit : function(archivo , ext){
			$("#error").html("");
			if (ext[0] != "csv") {
				$("#error").html('<div id="alerta" class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0px 0.7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>No es un archivo csv</p></div>');
				return false;
			}
			datos['ficha'] = $('#form input[name=ficha]').val();
		}, // onsubmit
		onComplete: function(archivo, respuesta){
			if (respuesta) {
				console.log(respuesta);
				$("#vertices").load("<?php echo site_url('archivos_controller/cargar_vertices'); ?>", {"ficha_predial": $('#form input[name=ficha]').val()});
			}

		} // oncomplete
	}); // AjaxUpload
	//este script se ejecuta una vez se haya cargado el documento completamente (cuando el documento este ready)
	$(document).ready(function()
	{
		$("#vertices").load("<?php echo site_url('archivos_controller/cargar_vertices'); ?>", {"ficha_predial": $('#form input[name=ficha]').val()});
		$('#navigation a').stop().animate({'marginLeft':'85px'},1000);

        $('#navigation > li').hover(
            function () {
                $('a',$(this)).stop().animate({'marginLeft':'2px'},200);
            },
            function () {
                $('a',$(this)).stop().animate({'marginLeft':'85px'},200);
            }
        );

		//esta funcion determina si hay un punto en una tira de caracteres
		function hay_punto(string)
		{
			//si no esta vacio
			if(string.length > 0)
			{
				//se obtiene un array de caracteres
				array = string.split('');
				//se examina cada caracter
				for(var i = 0; i < array.length; i++)
				{
					//si es un punto
					if(array[i] == '.')
					{
						return true;
					}
				}
			}
			return false;
		}

		//esta funcion verifica si todos los documentos de los propietarios estan diligenciados
		function hay_documentos_propietarios_vacios()
		{
			('#form input[name^=documento_propietario]').each(function(){
				if($(this).val() == '')
				{
					return true;
				}
			});
			return false;
		}

		//esta funcion saca la ventana de confirmacion jquery
		function abrir_ventana_dialogo(titulo, mensaje, funcion)
		{
			//en el template hay un div con id="cargando", despues de ese div se agrega otro con id="dialog-confirm"
			$('#cargando').append('<div id="dialog-confirm"></div>');
			//al div que se acaba de crear se le agrega el atributo title="�Desea borrar este propietario?"
			$('#dialog-confirm').attr('title', titulo);
			//tambien se le agrega el siguiente codigo html entre sus tags de inicio y final
			$('#dialog-confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>' + mensaje + '</p>');
			//se le da formato con la libreria de jquery y se muestra con las opciones siguientes
			$( "#dialog-confirm" ).dialog({
				resizable: false,
				height:200,
				width:420,
				modal: true,
				buttons: {
					Si: function() {
						funcion();
						//se destruye el elemento dialog
						$( "#dialog:ui-dialog" ).dialog( "destroy" );
						//se remueve el div con id="dialog-confirm" del documento html
						$('#dialog-confirm').remove();
						//se cierra el elemento flotante
						$( this ).dialog( "close" );
					},
					No: function() {
						//se destruye el elemento dialog
						$( "#dialog:ui-dialog" ).dialog( "destroy" );
						//se remueve el div con id="dialog-confirm" del documento html
						$('#dialog-confirm').remove();
						//se cierra el elemento flotante
						$( this ).dialog( "close" );
					}
				}
			});
		}

		//esta funcion saca la ventana de alerta jquery
		function abrir_ventana_alerta(titulo, mensaje, funcion)
		{
			//en el template hay un div con id="cargando", despues de ese div se agrega otro con id="dialog-confirm"
			$('#cargando').append('<div id="dialog-message"></div>');
			//al div que se acaba de crear se le agrega el atributo title="�Desea borrar este propietario?"
			$('#dialog-message').attr('title', titulo);
			//tambien se le agrega el siguiente codigo html entre sus tags de inicio y final
			$('#dialog-message').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>' + mensaje + '</p>');
			//se le da formato con la libreria de jquery y se muestra con las opciones siguientes
			$( "#dialog-message" ).dialog({
				resizable: false,
				height:200,
				width:420,
				modal: true,
				buttons: {
					Ok: function() {
						//se destruye el elemento dialog
						$( "#dialog:ui-dialog" ).dialog( "destroy" );
						//se remueve el div con id="dialog-confirm" del documento html
						$('#dialog-message').remove();
						//se cierra el elemento flotante
						$( this ).dialog( "close" );
						//se ejecuta la funcion pasada por parametro
						funcion();
					}
				}
			});
		}

		$('#form input[name=bitacora], a[rel=bitacora]').click(function(){
			var ficha_predial = $('#form input[name=ficha]').val();
			window.open("<?php echo site_url("bitacora_controller/obtener_bitacora"); ?>/" + ficha_predial,"bitacora","resizable=no,location=no,menubar=no, scrollbars=yes,status=no,toolbar=no,fullscreen=no, dependent=no,width=1020,height=600,left=100,top=0" );
			return false;
		});

		$('#form input[name=archivos], a[rel=archivos]').click(function(){
			var ficha_predial = $('#form input[name=ficha]').val();
			ficha_predial = ficha_predial.replace(' ', '_');
			ficha_predial = ficha_predial.replace(' ', '_');
			window.open("<?php echo site_url("archivos_controller/obtener_archivos"); ?>/" + ficha_predial,"archivos","resizable=no,location=no,menubar=no, scrollbars=yes,status=no,toolbar=no,fullscreen=no, dependent=no,width=1020,height=600,left=100,top=0" );
		});

		$('#form input[name=fotos], a[rel=fotos]').click(function(){
			var ficha_predial = $('#form input[name=ficha]').val();
			ficha_predial = ficha_predial.replace(' ', '_');
			window.open("<?php echo site_url("archivos_controller/ver_fotos?ficha="); ?>" + ficha_predial + "&tipo=1&aux=true","fotos","resizable=no,location=no,menubar=no, scrollbars=yes,status=no,toolbar=no,fullscreen=no, dependent=no,width=1020,height=600,left=100,top=0" );
		});

		$('#form input[name=pagos], a[rel=pagos]').click(function(){
			var ficha_predial = $('#form input[name=ficha]').val();
			ficha_predial = ficha_predial.replace(' ', '_');
			ficha_predial = ficha_predial.replace(' ', '_');
			console.log(ficha_predial);
			window.open("<?php echo site_url('pagos_controller/vista_actualizar'); ?>/" + ficha_predial,"pagos","resizable=no,location=no,menubar=no, scrollbars=yes,status=no,toolbar=no,fullscreen=no, dependent=no,width=1020,height=600,left=100,top=0" );
		});

		//este script unido con jquery es el encargado de dar el estilo css a las secciones del formulario dinamicamente
		$( "#accordion" ).accordion
		({
			autoHeight: false,
			navigation: true
		});

		//este script se encarga de verificar que estos campos sean de tipo double
		$('#form input[name^=area], #form input[name^=total], #form input[name^=valor]').keypress(function(event){
			//48 es el codigo del caracter 0
			//57 es el codigo del caracter 9
			//46 es el codigo del caracter .
			//8  es el codigo del backspace
			//0  es el codigo de los caracteres no alfanum�ricos y de puntuacion

			//si es un caracter no numerico
			if (event.which != 0 && event.which != 8 && (event.which < 48 || event.which > 57)) {
				//si es un punto
				if(event.which == 46){
					//si hay punto en lo que se ha ingresado hasta ahora
					if (hay_punto($(this).val()))
					{
						//se cancela el evento
						event.preventDefault();
					}
				}
				//si no es un punto se cancela el evento
				else
				{
					event.preventDefault();
				}
			}
		});

		//este script se encarga de desplegar el calendario en cada uno de los elementos especificados
		$('#form input[name^=fecha], #form input[name=inicio_trabajo_fisico], ' +
				'#form input[name=entrega_plano_interventoria], #form input[name=aprobacion_definitiva_plano], ' +
				'#form input[name=notificacion_propietario], #form input[name=envio_avaluador], #form input[name=recibo_avaluo], ' +
				'#form input[name=envio_interventoria], #form input[name=envio_gerencia_firmar], #form input[name=recibo_notificacion_propietario], ' +
				'#form input[name=envio_escritura_notaria], #form input[name=ingreso_escritura], #form input[name^=recibo_registro], ' +
				'#form input[name=notificacion], #form input[name=inicio_juicio], #form input[name=inicio_sentencia], ' +
				'#form input[name=ingreso_sentencia_registro],'+
				'#form input[name=f_envio_int],' +
				'#form input[name=f_aprob_ficha],' +
				'#form input[name=f_rev_ficha],' +
				'#form input[name=f_aprob_tit],' +
				'#form input[name=f_aprob_soc],' +
				'#form input[name=envio_avaluador],' +
				'#form input[name=f_recibo_av],' +
				'#form input[name=f_oferta_c],' +
				'#form input[name=f_oferta_notif],' +
				'#form input[name=f_oferta_ac],' +
				'#form input[name=f_permiso_int],' +
				'#form input[name=f_firma_prom]' +
				'').datepicker();
// f_envio_int
// f_aprob_ficha
// f_rev_ficha
// f_aprob_tit
// f_aprob_soc
// envio_avaluador
// f_recibo_av
// f_oferta_c
// f_oferta_notif
// f_oferta_ac
// f_permiso_int
// f_firma_prom

		//este script se encarga de validar la entrada de un numero entero para la adicion de propietarios
		$('#form input[name=agregar]').keypress(function(event){
			//48 es el codigo del caracter 0
			//57 es el codigo del caracter 9
			//8  es el codigo del backspace
			//0  es el codigo de los caracteres no alfanum�ricos y de puntuacion

			//si es un caracter no numerico
			if (event.which != 0 && event.which != 8 && (event.which < 48 || event.which > 57)) {
				//se cancela el evento
				event.preventDefault();
			}
		});

		//se encarga de adicionar los propietarios
		$('#boton_agregar').click(function(){
			//obtengo la cantidad de propietarios a insertar
			var propietarios_nuevos = parseInt($('#form input[name=agregar]').val());
			//obtengo la cantidad de propietarios que ya se insertaron
			var propietarios_existentes = parseInt($('#form input[name=propietarios_hidden]').val());
			//si no se ingreso nada o se ingreso un 0
			if(propietarios_nuevos == "" || propietarios_nuevos == 0)
			{
				//no haga nada
				return false;
			}
			//esta forma de realizar el ciclo es para garantizar ids independientes para luego poder borrarlas mas facil
			for(var i = propietarios_existentes + 1; i <= propietarios_existentes + propietarios_nuevos; i++)
			{
				//creo la tabla correspondiente a ese propietario
				var propietario = '<fieldset id="' + i + '"><legend><b>Identificaci&oacute;n del propietario ' + i + '</b></legend><table style="text-align:left"><tbody><tr><td width="20%"><label for="tipo_documento' + i + '">Tipo documento</label></td><td width="30%"><select name="tipo_documento' + i + '"><option value=""></option><option value="Cedula">CC</option><option value="Nit">Nit</option></select></td><td width="20%"><label for="propietario' + i + '">Propietario</label></td><td width="30%"><input type="text" value="" name="propietario' + i + '"></td></tr><tr><td width="20%"><label for="documento_propietario' + i + '">Documento</label></td><td width="30%"><input type="text" value="" name="documento_propietario' + i + '"></td><td width="20%"><label for="telefono' + i + '">Tel&eacute;fono</label></td><td width="30%"><input type="text" value="" name="telefono' + i + '"></td></tr><tr><td width="20%"><label for="participacion' + i + '">Participaci&oacute;n</label></td><td width="30%"><input type="text" value="" name="participacion' + i + '">%</td><td><input type="button" name="boton_eliminar' + i + '" value="Eliminar propietario" id="boton_eliminar' + i + '"></td></tr></tbody></table></fieldset>';
				//la inserto antes del input propietarios_hidden
				$('#form input[name=propietarios_hidden]').before(propietario);
				//actualizo el valor de propietarios_hidden
				$('#form input[name=propietarios_hidden]').val(parseInt($('#form input[name=propietarios_hidden]').val()) + 1);
			}
			//le pongo estilo a los botones de eliminacion. name^=boton_eliminar quiere decir: todos los input que su nombre empiece con boton_eliminar
			$('#form input[name^=boton_eliminar]').button();
		});

		//este script se encarga de agregar el evento clic a cada boton creado dinamicamente - en vivo (live)
		$('#form input[name^=boton_eliminar]').live('click', function(event){
			//se obtiene la id del elemento DOM que genera el evento
			var idDOM = event.target.id;
			//se crea un array de palabras usando como token la palabra: boton_eliminar ej: boton_eliminar3--> array[ , 3]
			var arrayLetras = idDOM.split('boton_eliminar');
			//se saca aparte la posicion donde se encuentra la id del fieldset que contiene todos los datos del propietario
			var propietario = arrayLetras[1];
			//se invoca la ventana de dialogo jquery y se le pasa la funcion que debe ejecutar en caso de que el usuario acepte
			abrir_ventana_dialogo(
				'Desea borrar este propietario?',
				'Los datos del propietario ' + propietario + ' ser&aacute;n borrados definitivamente. Desea confirmar esta acci&oacute;n?',
				function(){
					$.post(
						'<?php echo site_url('actualizar_controller/eliminar_propietario'); ?>',
						{ id_propietario:$('#form input[name=id_propietario' + propietario + ']').val(), ficha_predial:"<?php echo $predio->ficha_predial; ?>", <?php echo $this->security->get_csrf_token_name(); ?>:"<?php echo $this->security->get_csrf_hash(); ?>" },
						function(data){
							var mensaje = eval(data);
							if(mensaje.respuesta == "correcto")
							{
								//se borra el fieldset seleccionado dando un efecto animado de desaparicion en medio segundo
								$('#form fieldset[id=' + propietario + ']').delay(500).fadeOut('slow',function(){
									//se remueve el fieldset del formulario con todos sus campos
									$('#form fieldset[id=' + propietario + ']').remove();
								});
							}
						},
						"json"
					);
				}
			);
		});

		//este script se encarga de agregar el evento keypress a cada input creado dinamicamente - en vivo (live)
		$('#form input[name^=documento_propietario]').live('keypress',function(event){
			//48 es el codigo del caracter 0
			//57 es el codigo del caracter 9
			//46 es el codigo del caracter .
			//8  es el codigo del backspace
			//0  es el codigo de los caracteres no alfanum�ricos y de puntuacion

			//si es un caracter no numerico y distinto del punto
			if(event.which != 0 && event.which != 8 && (event.which < 48 || event.which > 57) && event.which != 46)
			{
				event.preventDefault();
			}
		});

		//este script se encarga de verificar que estos campos generados dinamicamente sean de tipo double
		$('#form input[name^=participacion]').live('keypress',function(event){
			//48 es el codigo del caracter 0
			//57 es el codigo del caracter 9
			//46 es el codigo del caracter .
			//8  es el codigo del backspace
			//0  es el codigo de los caracteres no alfanum�ricos y de puntuacion

			//si es un caracter no numerico
			if (event.which != 0 && event.which != 8 && (event.which < 48 || event.which > 57)) {
				//si es un punto
				if(event.which == 46){
					//si hay punto en lo que se ha ingresado hasta ahora
					if (hay_punto($(this).val()))
					{
						//se cancela el evento
						event.preventDefault();
					}
				}
				//si no es un punto se cancela el evento
				else
				{
					event.preventDefault();
				}
			}
		});

		//este script genera el evento clic del boton Guardar y Salir
		$('#form input[name=guardar], #form input[name=continuar]').click(function(){
			$('#form input[name=boton_hidden]').val($(this).attr('id'));
			//se verifica que la ficha se haya ingresado
			if($('#form input[name=ficha]').val() == "")
			{
				abrir_ventana_alerta(
					'Ficha predial',
					'No ha ingresado la ficha predial.',
					function(){
						$('#form input[name=ficha]').scrollTo('slow');
					}
				);
				return false;
			}

			//se verifica que se haya seleccionado un estado del proceso
			if($('#form select[name=estado_proceso]').val() == " ")
			{
				abrir_ventana_alerta(
					'Estado del proceso',
					'Indique el estado actual del proceso.',
					function(){
						$('#form a[href=#seccion1]').click();
						$('#form select[name=estado_proceso]').scrollTo('slow');
					}
				);
				return false;
			}

			//se obtiene la cantidad de propietarios adicionados
			var nro_propietarios = $('#form input[name=propietarios_hidden]').val();
			//se recorren los controles de los propietarios
			for(var i = 1; i <= nro_propietarios; i++)
			{
				//se verifica que el contro asociado existe
				if($('#form input[name=documento_propietario' + i + ']').length > 0)
				{
					//se verifica que se haya ingresado el documento del propietario
					if($('#form input[name=documento_propietario' + i + ']').val() == "")
					{
						abrir_ventana_alerta(
							'Documento del propietario',
							'Ingrese el documento del propietario ' + i + '.',
							function(){
								$('#form a[href=#seccion2]').click();
								$('#form input[name=documento_propietario' + i + ']').scrollTo('slow');
							}
						);
						return false;
					}
				}
			}

			//se envia el formulario, previa pregunta del deseo de hacerlo
			abrir_ventana_dialogo(
					'Confirmar registro',
					'Desea confirmar la actualizaci&oacute;n de este registro?',
					function(){
						$('#form form').submit();
					}
			);

		});

		//si dan clic en el boton salir sin guardar
		$('#form input[name=salir]').click(function(){
			history.back();
		});

		//como los datos a enviar son demasiados, se opta por usar una libreria de jquery que se encarga
		//de serializar todos los campos y los manda por POST via ajax
		var opciones = {
            beforeSubmit: function()
            {
				$('#cargando').html('Actualizando el registro. Por favor espere');
				$('#cargando').removeClass('error');
	            $("div#alerta").remove();
	            $("span.error").remove();
				$('#cargando').show();
            },
            success: function(msg) {
            	console.log(msg);
            	if(msg == "correcto")
				{
                    if($('#form input[name=boton_hidden]').val() != "continuar")
                    {
                    	$('#cargando').html('Los datos se actualizaron correctamente. Redireccionando...');
                        $('#cargando').addClass('correcto');
                    	history.back();
                    }
                    else
                    {
                    	$('#cargando').html('Los datos se actualizaron correctamente.');
                        $('#cargando').addClass('correcto');
                    }
				}
				else
				{
					 $('#cargando').html('<span class="alerta_icono"></span> Se presentaron errores');
                     $('#cargando').addClass('error');
                     $('#errores').after('<div id="alerta" class="ui-state-highlight ui-corner-all" style="display:none; margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' + msg + '</p></div>');
                     $('div#alerta').fadeIn('slow');
				}
				$('#cargando').delay(2000).fadeOut('slow',function(){
					$(this).removeClass('correcto');
					$(this).removeClass('error');
				});
            }
		};

		//aqui se intercepta el evento submit y se ejecutan las funciones pasadas por parametro al ajaxForm
		$('#form form').ajaxForm(opciones);


		$('#form input[name=bitacora]').click(function(){
			var ficha_predial = $('#form input[name=ficha]').val();
			window.open("<?php echo site_url("bitacora_controller/obtener_bitacora"); ?>/" + ficha_predial,"bitacora","resizable=no,location=no,menubar=no, scrollbars=yes,status=no,toolbar=no,fullscreen=no, dependent=no,width=1020,height=600,left=100,top=0" );
		});
	});
</script>
