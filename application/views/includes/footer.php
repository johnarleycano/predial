<div align="center">
    <!-- <font size="1.5px">Este sitio se visualiza mejor con Internet Explorer 8, Firefox 3.6, Google Chrome 11 (o superiores). Con una resoluci&oacute;n m&iacute;nima de 1024 x 768 pixeles</font> -->
    <p style="padding-top:5px">&copy; Derechos reservados <?php echo anchor_popup('http://www.devimed.com.co/','<b>DEVIMED S.A. </b>'); ?> | <i>Versión <b><?php echo version(); ?></p>
    <!-- <p>Autopista Norte Copacabana<br />Calle 59 No. 48-35<br />PBX: 401 22 77</p> -->
    <div class="clear"></div>
</div>

<?php
function version()
{
    foreach(array_reverse(glob('.git/refs/tags/*')) as $archivo) {
        $contents = file_get_contents($archivo);

        return basename($archivo);
        exit();
    }
}
?>