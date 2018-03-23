<link rel="stylesheet" href="<?php echo base_url(); ?>css/demo_table_jui.css" type="text/css" />
<table id="tabla-vertices" style="width:100%; font-size: 13px">
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
                <td><?php echo $vertice->punto ?></td>
                <td><?php echo $vertice->x ?></td>
                <td><?php echo $vertice->y ?></td>
                <td><?php echo $vertice->distancia ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<style media="screen">
    #tabla-vertices {
        text-align: center;
    }
    #tabla-vertices th, #tabla-vertices td {
        font-size: 1.3em;
    }
</style>

<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$('#tabla-vertices').dataTable({
    "bJQueryUI": true,
    "bSort": false,
    "sPaginationType": "full_numbers"/*,
    "order": [[ 2, "asc" ]]*/
});
$(document).ready(function(){
    $( "tr" ).click(() => {
        console.log( this );
    });
});
</script>
