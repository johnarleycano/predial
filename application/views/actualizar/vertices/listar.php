<link rel="stylesheet" href="<?= base_url(); ?>css/demo_table_jui.css" type="text/css" />
<style media="screen">
    #tabla-vertices {
        text-align: center;
    }
</style>

<div id="error"></div>
<h4>Vértices del predio <?=$ficha ?></h4>
<label for="btn_subir_csv">Actualizar registros (CSV)</label>
<input type="file" id="btn_subir_csv">
<table id="tabla-vertices" style="width:100%;">
    <thead>
        <tr>
            <th>Punto</th>
            <th>Este (x)</th>
            <th>Norte (y)</th>
            <th>Distancia (m)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($vertices as $vertice): ?>
            <tr>
                <td><?= $vertice->punto ?></td>
                <td><?= $vertice->x ?></td>
                <td><?= $vertice->y ?></td>
                <td><?= $vertice->distancia ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p style="font-size:0.8em;">
    Src: Magna-Sirgas / Colombia Bogotá Zone
</p>

<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
var datos = {};
new AjaxUpload('#btn_subir_csv', {
    action: '<?php echo site_url("archivos_controller/subir_csv"); ?>',
    type: 'POST',
    data: datos,
    onSubmit : function(archivo , ext){
        $("#error").html("");
        if (ext[0] !== "csv") {
            $("#error").html('<div id="alerta" class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0px 0.7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>No es un archivo csv</p></div>');
            return false;
        }
        datos.ficha = "<?= $ficha ?>";
    }, // onsubmit
    onComplete: function(archivo, respuesta){
        listar();
    } // oncomplete
}); // AjaxUpload

$('#tabla-vertices').dataTable({
    "bJQueryUI": true,
    "bSort": false,
    "sPaginationType": "full_numbers"/*,
    "order": [[ 2, "asc" ]]*/
});
</script>
