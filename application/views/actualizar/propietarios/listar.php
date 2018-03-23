<!-- Estilo de tablas -->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />

<!-- Tabla -->
<table id="tabla-cultivos" style="width:100%; font-size: 13px">
    <thead>
        <tr>
            <th>Nro</th>
            <th>Tipo de documento</th>
            <th>Documento</th>
            <th>Nombre</th>
            <th>Telefono</th>
            <th>Direccion</th>
            <th>Email</th>
            <th>Participación</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php $cont = 1 ?>
        <?php foreach ($this->PropietariosDAO->obtener_propietarios($ficha) as $propietario): ?>
            <tr>
                <td align="right"><?= $cont ?></td>
                <td><?= $propietario->tipo_documento ?></td>
                <td align='right'><?= $propietario->documento ?></td>
                <td><?= $propietario->nombre ?></td>
                <td><?= $propietario->telefono ?></td>
                <td><?= $propietario->direccion ?></td>
                <td><?= $propietario->email ?></td>
                <td align='right'><?= $propietario->participacion ?>%</td>
                <td width="8%">
                    <a onclick="javascript:editar(<?= $propietario->id_propietario; ?>)" style="cursor: pointer">
                        <img src="<?= base_url(); ?>img/edit.png" title="Editar propietarios">
                    </a>
                    <a onClick="javascript:eliminar('mensaje', '<?= $propietario->id_propietario; ?>')" style="cursor: pointer">
                        <img src="<?= base_url(); ?>img/delete.png" title="Eliminar propietario">
                    </a>
                </td>
                <?php $cont++; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<!-- Tabla -->

<!-- Librería de tablas -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        // Inicio de la tabla
        $('#tabla-cultivos').dataTable({
            "bJQueryUI": true,
            "bSort": true,
            "sPaginationType": "full_numbers"
        });
    });
</script>
