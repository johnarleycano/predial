<div>
    <?= form_fieldset('<b>Identificación de impactos y diágnostico socioeconómicos</b>') ?>
        <?= form_label('Identificacion de impactos y diagnostico socioeconómico', 'diagnostico') ?>
        <?php $data = array('name'=>'diagnostico', 'value'=> (isset($diagnostico->observaciones)) ? $diagnostico->observaciones : "", 'rows'=>'10') ?>
        <?= form_textarea($data) ?>
</div>

<div>
    <?= form_label('Factor de apoyo al restablecimiento de vivienda', 'apoyo_restablecimiento') ?>
    <?php $data = array('name'=>'apoyo_restablecimiento', 'value'=> (isset($diagnostico->apoyo_restablecimiento)) ? $diagnostico->apoyo_restablecimiento : "", 'style'=>'width:70%') ?>
    <?= form_input($data) ?>
    <?php $data = array('name'=>'apoyo_restablecimiento_valor', 'value' => (isset($diagnostico->apoyo_restablecimiento_valor)) ? $diagnostico->apoyo_restablecimiento_valor : "", 'placeholder' => 'Subtotal', 'style'=>'float:right') ?>
    <?= form_input($data) ?>
</div>

<div>
    <?= form_label('Factor de apoyo a moradores', 'apoyo_moradores') ?>
    <br>
    <?php $data = array('name'=>'apoyo_moradores', 'value'=> (isset($diagnostico->apoyo_moradores)) ? $diagnostico->apoyo_moradores : "", 'style'=>'width:70%') ?>
    <?= form_input($data) ?>
    <?php $data = array('name'=>'apoyo_moradores_valor', 'value'=> (isset($diagnostico->apoyo_moradores_valor)) ? $diagnostico->apoyo_moradores_valor : "", 'placeholder'=>'Subtotal', 'style'=>'float:right') ?>
    <?= form_input($data) ?>
</div>

<div>
    <?= form_label('Factor de apoyo para tramites', 'apoyo_tramites') ?>
    <br>
    <?php $data = array('name'=>'apoyo_tramites', 'value'=> (isset($diagnostico->apoyo_tramites)) ? $diagnostico->apoyo_tramites : "", 'style'=>'width:70%') ?>
    <?= form_input($data) ?>
    <?php $data = array('name'=>'apoyo_tramites_valor', 'value'=> (isset($diagnostico->apoyo_tramites_valor)) ? $diagnostico->apoyo_tramites_valor : "", 'placeholder'=>'Subtotal', 'style'=>'float:right') ?>
    <?= form_input($data) ?>
</div>

<div>
    <?= form_label('Factor de apoyo por movilización', 'apoyo_movilizacion') ?>
    <br>
    <?php $data = array('name'=>'apoyo_movilizacion', 'value'=> (isset($diagnostico->apoyo_movilizacion)) ? $diagnostico->apoyo_movilizacion : "", 'style'=>'width:70%') ?>
    <?= form_input($data) ?>
    <?php $data = array('name'=>'apoyo_movilizacion_valor', 'value'=> (isset($diagnostico->apoyo_movilizacion_valor)) ? $diagnostico->apoyo_movilizacion_valor : "", 'placeholder'=>'Subtotal', 'style'=>'float:right') ?>
    <?= form_input($data) ?>
</div>

<div>
    <?= form_label('Restablecimiento de Servicios', 'restablecimiento_servicios') ?>
    <br>
    <?php $data = array('name'=>'restablecimiento_servicios', 'value'=> (isset($diagnostico->restablecimiento_servicios)) ? $diagnostico->restablecimiento_servicios : "", 'style'=>'width:70%') ?>
    <?= form_input($data) ?>
    <?php $data = array('name'=>'restablecimiento_servicios_valor', 'value'=> (isset($diagnostico->restablecimiento_servicios_valor)) ? $diagnostico->restablecimiento_servicios_valor : "", 'placeholder'=>'Subtotal', 'style'=>'float:right') ?>
    <?= form_input($data) ?>
</div>

<div>
    <?= form_label('Restablecimientos de medios Economicos', 'restablecimiento_economico') ?>
    <br>
    <?php $data = array('name'=>'restablecimiento_economico', 'value'=> (isset($diagnostico->restablecimiento_economico)) ? $diagnostico->restablecimiento_economico : "", 'style'=>'width:70%') ?>
    <?= form_input($data) ?>
    <?php $data = array('name'=>'restablecimiento_economico_valor', 'value'=> (isset($diagnostico->restablecimiento_economico_valor)) ? $diagnostico->restablecimiento_economico_valor : "", 'placeholder'=>'Subtotal', 'style'=>'float:right') ?>
    <?= form_input($data) ?>
</div>

<div>
    <?= form_label('Apoyo a arrendadores', 'apoyo_arrendadores') ?>
    <br>
    <?php $data = array('name'=>'apoyo_arrendadores', 'value'=> (isset($diagnostico->apoyo_arrendadores)) ? $diagnostico->apoyo_arrendadores : "", 'style'=>'width:70%') ?>
    <?= form_input($data) ?>
    <?php $data = array('name'=>'apoyo_arrendadores_valor', 'value'=> (isset($diagnostico->apoyo_arrendadores_valor)) ? $diagnostico->apoyo_arrendadores_valor : "", 'placeholder'=>'Subtotal', 'style'=>'float:right') ?>
    <?= form_input($data) ?>
</div>
<script type="text/javascript">

$('#form input[name=guardar], #form input[name=continuar]').click(function(){
    $('#form input[name=boton_hidden]').val($(this).attr('id'));
    var ficha = $("input[name=ficha]");
    //datos diagnostico socioeconomico
    var diagnostico = $("textarea[name=diagnostico]");
    var apoyo_restablecimiento = $("input[name=apoyo_restablecimiento]");
    var apoyo_restablecimiento_valor = $("input[name=apoyo_restablecimiento_valor]");
    var apoyo_moradores = $("input[name=apoyo_moradores]");
    var apoyo_moradores_valor = $("input[name=apoyo_moradores_valor]");
    var apoyo_tramites = $("input[name=apoyo_tramites]");
    var apoyo_tramites_valor = $("input[name=apoyo_tramites_valor]");
    var apoyo_movilizacion = $("input[name=apoyo_movilizacion]");
    var apoyo_movilizacion_valor = $("input[name=apoyo_movilizacion_valor]");
    var restablecimiento_servicios = $("input[name=restablecimiento_servicios]");
    var restablecimiento_servicios_valor = $("input[name=restablecimiento_servicios_valor]");
    var restablecimiento_economico = $("input[name=restablecimiento_economico]");
    var restablecimiento_economico_valor = $("input[name=restablecimiento_economico_valor]");
    var apoyo_arrendadores = $("input[name=apoyo_arrendadores]");
    var apoyo_arrendadores_valor = $("input[name=apoyo_arrendadores_valor]");

	var datos_diagnostico = {
		"ficha_predial": ficha.val(),
		'observaciones': diagnostico.val(),
		'apoyo_restablecimiento': apoyo_restablecimiento.val(),
		'apoyo_restablecimiento_valor': apoyo_restablecimiento_valor.val(),
		'apoyo_moradores':apoyo_moradores.val(),
		'apoyo_moradores_valor':apoyo_moradores_valor.val(),
		'apoyo_tramites':apoyo_tramites.val(),
		'apoyo_tramites_valor':apoyo_tramites_valor.val(),
		'apoyo_movilizacion':apoyo_movilizacion.val(),
		'apoyo_movilizacion_valor':apoyo_movilizacion_valor.val(),
		'restablecimiento_servicios':restablecimiento_servicios.val(),
		'restablecimiento_servicios_valor':restablecimiento_servicios_valor.val(),
		'restablecimiento_economico':restablecimiento_economico.val(),
		'restablecimiento_economico_valor': restablecimiento_economico_valor.val(),
		'apoyo_arrendadores':apoyo_arrendadores.val(),
		'apoyo_arrendadores_valor':apoyo_arrendadores_valor.val()
	};
    // si no hay tipo se elimina el campo
    datos_diagnostico["<?= ($tipo) ? $tipo : 'no'; ?>"] = "<?= (isset($id)) ? $id : null; ?>";
    // si no tiene tipo se elimina el id de la ficha del objeto con los datos del diagnostico
    delete datos_diagnostico.no;
    // se carga el diagnostico socioeconomico
    $.ajax({
        url: "<?php echo site_url('gestion_social_controller/cargar_diagnostico'); ?>",
        data: {"ficha": ficha.val(), "tipo": "<?= $tipo ?>", "id": "<?= $id ?>"},
        type: "POST",
        dataType: "html",
        async: false,
        success: function(respuesta){
            //Si la respuesta no es error
            if(respuesta){
                //Se almacena la respuesta como variable de éxito
                return existe = respuesta;
            }
        },//Success
        error: function(respuesta){
            //Variable de exito será mensaje de error de ajax
            existe = respuesta;
        }//Error
    });//Ajax

    if (existe == "1") {
        // url para modificar
        url = "<?php echo site_url('gestion_social_controller/actualizar_diagnostico'); ?>";
    } else {
        // url para crear
        url = "<?php echo site_url('gestion_social_controller/insertar_diagnostico'); ?>";
    }

    // se guarda el diagnostico socioeconomico
    $.ajax({
        url: url,
        data: {"ficha": ficha.val(), "datos": datos_diagnostico, "tipo": "<?= $tipo ?>", "id": "<?= $id ?>"},
        type: "POST",
        dataType: "html",
        async: false,
        success: function(respuesta){
            //Si la respuesta no es error
            if(respuesta){
                //Se almacena la respuesta como variable de éxito
                // exito = respuesta;
                console.log(respuesta)
            } else {
                //La variable de éxito será un mensaje de error
                // exito = 'error';
                console.log(respuesta)
            } //If
        },//Success
        error: function(respuesta){
            //Variable de exito será mensaje de error de ajax
            // exito = respuesta;
            console.log(respuesta)
        }//Error
    });//Ajax
});
</script>
