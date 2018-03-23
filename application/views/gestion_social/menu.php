<?php $permisos = $this->session->userdata('permisos'); ?>
<ul>
	<li class="current"><a href="<?php echo site_url('gestion_social_controller'); ?>">CARACTERIZACIÓN</a></li>
	<li><a href="<?php echo site_url('gestion_social_controller/unidades_sociales_residentes'); ?>">UNIDADES  RESIDENTES</a></li>
	<li><a href="<?php echo site_url('gestion_social_controller/unidades_sociales_productivas'); ?>">UNIDADES  PRODUCTIVAS</a></li>
</ul>