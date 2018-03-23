<?php
$propietario = $this->PropietariosDAO->existe_propietario($documento);
$relacion = $this->PropietariosDAO->existe_relacion($propietario->id_propietario, $ficha);
 ?>
<div>
    <?php if (!empty($propietario)): ?>
        <?php if (!empty($relacion)): ?>
            <div id="alerta" class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0px 0.7em;">
                <p>
                    <span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;">
                    </span>
                    El propietario ya se encuentra en esta ficha
                </p>
            </div>
        <?php else: ?>
            <p> <?= $propietario->nombre ?></p>
            <div style="float:left;">
                <?= form_label('Participacion', 'participacion')?>
                <?php $data = array('name'=>'participacion_nuevo', 'value'=> '') ?>
                <?= form_input($data) ?>
            </div>
            <input type="button" name="name" value="Añadir" onClick="agregar(<?= $propietario->id_propietario?>)" class="ui-button ui-widget ui-state-default ui-corner-all">
        <?php endif; ?>
    <?php else: ?>
        <div id="alerta" class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0px 0.7em;">
            <p>
                <span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;">
                </span>
                El propietario no se encuentra registrado
                <input type="button" value="Nuevo" onClick="crear()" class="ui-button ui-widget ui-state-default ui-corner-all">
            </p>
        </div>
    <?php endif; ?>
</div>
