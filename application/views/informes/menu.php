<ul>
	<?php $permisos = $this->session->userdata('permisos'); ?>
	<!-- <li class="current"><a href="<?php // echo site_url('informes_controller'); ?>" >Actas</a></li> -->
	<!-- <li><a href="<?php // echo site_url('informes_controller/avaluos'); ?>">Aval&uacute;os</a></li> -->
	<!-- <li><a href="<?php // echo site_url('informes_controller/avaluos_vencidos'); ?>">Aval&uacute;os vencidos</a></li> -->
	<!-- <li><a href="<?php // echo site_url('informes_controller/avaluos_en_vencimiento'); ?>">Aval&uacute;os por vencerse</a></li> -->
	<!-- <li><a href="<?php // echo site_url('informes_controller/bitacora'); ?>">Bitácora</a></li> -->
	<?php if (isset($permisos['Informes']['Gestión predial'])): ?>
		<li><a href="<?php echo site_url('informes_controller/gestion_predial_excel/'); ?>">Gestión Predial</a></li>
	<?php endif; ?>
	<?php // if (isset($permisos['Informes']['Semáforo'])): ?>
		<!-- <li><a href="<?php // echo site_url('informes_controller/semaforo_excel/'); ?>">Semáforo</a></li> -->
	<?php // endif; ?>
	<?php if (isset($permisos['Informes']['Sábana predial'])): ?>
		<li><a href="<?php echo site_url('informes_controller/sabana_excel/'); ?>">Sábana predial</a></li>
	<?php endif; ?>

	<?php // if (isset($permisos['Informes']['Gestión de procesos'])): ?>
		<!-- <li><a href="<?php //echo site_url('informes_controller/gestion_procesos_excel/'); ?>">Gesti&oacute;n de procesos</a></li> -->
	<?php // endif; ?>
	<?php if (isset($permisos['Informes']['Mapas'])): ?>
		<li><a href="<?php echo site_url('informes_controller/mapas/'); ?>">Mapas</a></li>
	<?php endif; ?>
	<!-- <li><a href="<?php // echo site_url('informes_controller/pagos'); ?>">Pagos</a></li> -->
</ul>
