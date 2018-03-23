<link rel="stylesheet" href="<?= base_url(); ?>css/demo_table_jui.css" type="text/css" />
<h4>Predios de <?= $propietario->nombre?></h4>
    <table id="tabla" style='width:100%'>
        <thead>
            <tr>
                <th>Predio</th>
                <th>Participación</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($relaciones as $relacion): ?>
                <tr>
                    <td align="center"><?= $relacion->ficha_predial; ?></td>
                    <td align="right"><?= $relacion->participacion; ?>%</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<script type="text/javascript" src="<?= base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#tabla').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
            "aaSorting": [[ 1, "asc" ]]
		});
	});
</script>
