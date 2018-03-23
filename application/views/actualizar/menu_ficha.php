<?php $permisos = $this->session->userdata('permisos'); ?>

<ul>
	<li id="menu_general" class="current"><a href="">GENERAL</a></li>
	<li id="menu_cultivos" style="cursor:pointer"><a onClick="javascript:cargar('cultivos')">CULTIVOS Y ESPECIES</a></li>
	<li id="menu_construcciones" style="cursor:pointer"><a onClick="javascript:cargar('construcciones', 1)">CONSTRUCCIONES</a></li>
	<li id="menu_construcciones_anexas" style="cursor:pointer"><a onClick="javascript:cargar('construcciones', 2)">CONSTRUCCIONES ANEXAS</a></li>
	<li id="menu_propietarios" style="cursor:pointer"><a onClick="javascript:cargar('propietarios')">PROPIETARIOS</a></li>
	<li id="menu_vertices" style="cursor:pointer"><a onClick="javascript:cargar('vertices')">VERTICES</a></li>
</ul>


<!-- Changes del menú lateral -->
<script type="text/javascript">

</script>
