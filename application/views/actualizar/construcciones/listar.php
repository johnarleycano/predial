<!-- Estilo de tablas -->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />

<!-- Tabla -->
<table id="tabla-cultivos" style="width:100%; font-size: 13px">
    <thead>
        <tr>
            <th>Nro</th>
            <th>Descripcion</th>
            <th>Cantidad</th>
            <th>Unidad</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php $cont = 1 ?>
        <?php foreach ($this->PrediosDAO->obtener_construcciones($ficha, $subcategoria) as $construccion): ?>
            <tr>
                <td align="right"><?= $cont ?></td>
                <td><?= $construccion->descripcion ?></td>
                <td align='right'><?= floatval($construccion->cantidad) ?></td>
                <td><?= $construccion->unidad ?></td>
                <td width="8%">
                    <a onclick="javascript:editar(<?= $construccion->id_construccion; ?>)" style="cursor: pointer">
                        <img src="<?php echo base_url(); ?>img/edit.png" title="Editar construccions">
                    </a>
                    <a onClick="javascript:eliminar('mensaje', '<?= $construccion->id_construccion ?>')" style="cursor: pointer">
                        <img src="<?php echo base_url(); ?>img/delete.png" title="Eliminar construccion">
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
