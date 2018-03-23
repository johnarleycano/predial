<!-- Contenedor de vertices -->
<div id="cont_vertices"></div>
<script type="text/javascript">
function listar()
{
    // Carga de interfaz
    cargar_interfaz("cont_vertices", "<?= site_url('actualizar_controller/cargar_interfaz'); ?>", {"tipo": "vertices_lista", "ficha": "<?= $ficha; ?>"});
} // listar

// Cuando el DOM esté listo
$(document).ready(function(){
    // Por defecto, cargamos la lista de cultivos
    listar();
}); // document.ready
</script>
