<?php
// Si trae un id
if ($id > 0) {
    $propietario = $this->PropietariosDAO->obtener_propietario($id);
    $relacion = $this->PropietariosDAO->existe_relacion($id, $ficha);
    // Input oculto
    echo '<input type="hidden" id="id_propietario" value="'.$id.'" >';
} //
?>

<!-- Modal -->
<div id="dialog-form" title="Gestión de propietarios" hidden>
    <div id="error"></div>
    <table>
        <thead>
            <tr>
                <td><?= form_label('Tipo de documento*', 'tipo_documento') ?></td>
                <td><?= form_label('Documento*', 'documento') ?></td>
                <td><?= form_label('Nombre*', 'nombre') ?></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <?= form_dropdown('tipo_documento', array(' ' => ' ', 'Cedula' => 'CC','Nit' => 'Nit', 'TI' => 'Tarjeta Identidad'), $propietario->tipo_documento, 'style="width:100%;"') ?>
                </td>
                <td>
                    <?php $data = array('name'=>'documento', 'value'=> $propietario->documento) ?>
                    <?= form_input($data) ?>
                </td>
                <td>
                    <?php $data = array('name'=>'nombre', 'value'=> $propietario->nombre) ?>
                    <?= form_input($data) ?>
                </td>
            </tr>
            <tr>
                <td><?= form_label('Telefono', 'telefono')?></td>
                <td><?= form_label('Direccion', 'direccion')?></td>
                <td><?= form_label('Email', 'email')?></td>
            </tr>
            <tr>
                <td>
                    <?php $data = array('name'=>'telefono', 'value'=> $propietario->telefono) ?>
                    <?= form_input($data) ?>
                </td>
                <td>
                    <?php $data = array('name'=>'direccion', 'value'=> $propietario->direccion) ?>
                    <?= form_input($data) ?>
                </td>
                <td>
                    <?php $data = array('name'=>'email', 'value'=> $propietario->email) ?>
                    <?= form_input($data) ?>
                </td>
            </tr>
        <!--muestra la participacion si existe la ficha  -->
        <?php if ($ficha): ?>
            <tr>
                <td><?= form_label('Participación*', 'participacion')?></td>
            </tr>
            <tr>
                <td>
                    <?php $data = array('name'=>'participacion', 'value'=> $relacion->participacion) ?>
                    <?= form_input($data) ?>
                </td>
            </tr>
        <?php endif; ?>
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
            height:420,
            width:760,
        });
    });
</script>
