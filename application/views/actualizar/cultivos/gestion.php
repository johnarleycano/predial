<?php 
// Si trae un id
if ($id > 0) {
    $cultivo = $this->PrediosDAO->obtener_cultivo($id);

    // Input oculto
    echo '<input type="hidden" id="id_cultivo" value="'.$id.'" >';
} // 
?>

<!-- Modal -->
<div id="dialog-form" title="Gestión de cultivos" hidden>
    <div id="error"></div>

    <?= form_label('Descripción *', 'descripcion') ?>
    <?php $data = array('name'=>'descripcion', 'value'=> $cultivo->descripcion, 'style'=>'height:35%') ?>
    <?= form_textarea($data);
     ?>
    <table>
        <thead>
            <tr>
                <td><?= form_label('Cantidad *', 'cantidad') ?></td>
                <td><?= form_label('Densidad', 'densidad') ?></td>
                <td><?= form_label('Unidad *', 'unidad') ?></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <?php $data = array('name'=>'cantidad', 'value'=> $cultivo->cantidad) ?>
                    <?= form_input($data) ?>
                </td>
                <td>
                    <?php $data = array('name'=>'densidad', 'value'=> $cultivo->densidad) ?>
                    <?= form_input($data) ?>
                </td>
                <td>
                    <?php $data = array('name'=>'unidad', 'value'=> $cultivo->unidad) ?>
                    <?= form_input($data) ?>
                </td>
            </tr>
        </tbody>
    </table>

    <input type="button" value="Cancelar" onClick="javascript:cerrar_modal()" style="float:right;" class="ui-button ui-widget ui-state-default ui-corner-all">
    <input type="button" value="Guardar" onClick="javascript:guardar()" style="float:right;" class="ui-button ui-widget ui-state-default ui-corner-all">
</div>
<!-- Modal -->

<script type="text/javascript">
    $(document).ready(function(){
        // Se abre el modal
        $( "#dialog-form" ).dialog({
            modal: true,
            height:310,
            width:760,
        });
    });
</script>