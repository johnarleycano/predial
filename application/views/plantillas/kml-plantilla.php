<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2" xmlns:kml="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom">
<Document>
<Style id="sn_ylw-pushpin">
<IconStyle>
    <scale>1.1</scale>
        <Icon>
            <href>http://maps.google.com/mapfiles/kml/pushpin/ylw-pushpin.png</href>
        </Icon>
        <hotSpot x="20" y="2" xunits="pixels" yunits="pixels"/>
    </IconStyle>
    <LineStyle>
        <color>ff7fff55</color>
        <width>2</width>
    </LineStyle>
    <PolyStyle>
        <color>7f0000ff</color>
    </PolyStyle>
</Style>
<Style id="sh_placemark_circle_highlight">
    <IconStyle>
        <scale>0.5</scale>
        <Icon>
            <href>http://maps.google.com/mapfiles/kml/shapes/placemark_circle_highlight.png</href>
        </Icon>
    </IconStyle>
</Style>
<StyleMap id="msn_ylw-pushpin">
    <Pair>
        <key>normal</key>
        <styleUrl>#sn_ylw-pushpin0</styleUrl>
    </Pair>
    <Pair>
        <key>highlight</key>
        <styleUrl>#sh_ylw-pushpin</styleUrl>
    </Pair>
</StyleMap>
<Style id="sh_ylw-pushpin">
    <IconStyle>
        <scale>1.3</scale>
        <Icon>
            <href>http://maps.google.com/mapfiles/kml/pushpin/ylw-pushpin.png</href>
        </Icon>
        <hotSpot x="20" y="2" xunits="pixels" yunits="pixels"/>
    </IconStyle>
    <LineStyle>
        <color>ff7fff55</color>
        <width>2</width>
    </LineStyle>
    <PolyStyle>
        <color>ff0000ff</color>
        <outline>0</outline>
    </PolyStyle>
</Style>
<Style id="sh_placemark_circle_highlight0">
    <IconStyle>
        <scale>0.5</scale>
        <Icon>
            <href>http://maps.google.com/mapfiles/kml/shapes/placemark_circle_highlight.png</href>
        </Icon>
    </IconStyle>
</Style>
<StyleMap id="msn_placemark_circle">
    <Pair>
        <key>normal</key>
        <styleUrl>#sn_placemark_circle</styleUrl>
    </Pair>
    <Pair>
        <key>highlight</key>
        <styleUrl>#sh_placemark_circle_highlight0</styleUrl>
    </Pair>
</StyleMap>
<Style id="sh_ylw-pushpin0">
    <IconStyle>
        <scale>1.3</scale>
        <Icon>
            <href>http://maps.google.com/mapfiles/kml/pushpin/ylw-pushpin.png</href>
        </Icon>
        <hotSpot x="20" y="2" xunits="pixels" yunits="pixels"/>
    </IconStyle>
    <LineStyle>
        <color>ff7fff55</color>
        <width>2</width>
    </LineStyle>
    <PolyStyle>
        <color>7f0000ff</color>
    </PolyStyle>
</Style>
<StyleMap id="msn_placemark_circle0">
    <Pair>
        <key>normal</key>
        <styleUrl>#sn_placemark_circle0</styleUrl>
    </Pair>
    <Pair>
        <key>highlight</key>
        <styleUrl>#sh_placemark_circle_highlight</styleUrl>
    </Pair>
</StyleMap>
<StyleMap id="msn_ylw-pushpin0">
    <Pair>
        <key>normal</key>
        <styleUrl>#sn_ylw-pushpin</styleUrl>
    </Pair>
    <Pair>
        <key>highlight</key>
        <styleUrl>#sh_ylw-pushpin0</styleUrl>
    </Pair>
</StyleMap>
<Style id="sn_ylw-pushpin0">
    <IconStyle>
        <scale>1.1</scale>
        <Icon>
            <href>http://maps.google.com/mapfiles/kml/pushpin/ylw-pushpin.png</href>
        </Icon>
        <hotSpot x="20" y="2" xunits="pixels" yunits="pixels"/>
    </IconStyle>
    <LineStyle>
        <color>ff7fff55</color>
        <width>2</width>
    </LineStyle>
    <PolyStyle>
        <color>ff0000ff</color>
        <outline>0</outline>
    </PolyStyle>
</Style>
<Style id="sn_placemark_circle">
    <IconStyle>
        <scale>0.5</scale>
        <Icon>
            <href>http://maps.google.com/mapfiles/kml/shapes/placemark_circle.png</href>
        </Icon>
    </IconStyle>
</Style>
<Style id="sn_placemark_circle0">
    <IconStyle>
        <scale>0.5</scale>
        <Icon>
            <href>http://maps.google.com/mapfiles/kml/shapes/placemark_circle.png</href>
        </Icon>
    </IconStyle>
</Style>

<Folder>
    <name>Convención</name>
    <ScreenOverlay>
        <name>Convenciones</name>
        <Icon>
            <href><?php echo base_url()."img/convenciones.png"; ?></href>
        </Icon>
        <overlayXY x="0" y="0" xunits="fraction" yunits="fraction"/>
        <screenXY x="0" y="0" xunits="fraction" yunits="fraction"/>
        <rotationXY x="0" y="0" xunits="fraction" yunits="fraction"/>
        <size x="0" y="0" xunits="fraction" yunits="fraction"/>
    </ScreenOverlay>
 </Folder>
<!--Unidad funcional  -->

<?php foreach ($unidades_funcionales as $unidad): 
// print_r($unidad);
?>

    <Folder>
        <name><?= substr($unidad[0][0]->ficha_predial, 0, 4)?></name>
    <!--Predio  -->
    <?php foreach ($unidad as $predioArray): 
print_r($unidad[0][0]); 
    ?>
        <Folder>
            <name><?= $predioArray[0]->ficha_predial; ?></name>
        <!--Info del predio  -->
            <Placemark>
                <name><?php echo $predioArray[0]->ficha_predial; ?></name>
                <Style>
                    <!-- Color de la linea  -->
                    <LineStyle>
                        <color><?php echo ($predioArray[0]->color_via) ? "ff".$predioArray[0]->color_via: "ffffffff" ; ?></color>
                        <width>3</width>
                    </LineStyle>
                    <!-- Color interior del poligono  -->
                    <PolyStyle>
                        <color><?php  echo($predioArray[0]->color_proceso) ? "7f".$predioArray[0]->color_proceso: "ffffffff" ; ?></color>
                        <fill>1</fill>
                    </PolyStyle>
                </Style>
                <!-- Tabla de datos  -->
                <ExtendedData>
                    <SchemaData schemaUrl="">
                        <SimpleData name="Predio"><?php echo $predioArray[0]->predio; ?></SimpleData>
                        <SimpleData name="Tramo"><?php echo $predioArray[0]->tramo; ?></SimpleData>
                        <SimpleData name="Municipio"><?php echo $predioArray[0]->municipio; ?></SimpleData>
                        <SimpleData name="Abscisa inicial"><?php echo $predioArray[0]->abscisa_inicial; ?></SimpleData>
                        <SimpleData name="Abscisa final"><?php echo $predioArray[0]->abscisa_final; ?></SimpleData>
                        <SimpleData name="Propietario"><?php echo $predioArray[0]->nombre_propietario; ?></SimpleData>
                        <SimpleData name="Area requerida"><?php echo $predioArray[0]->area_requerida; ?></SimpleData>
                        <SimpleData name="Cédula catastral"><?php echo $predioArray[0]->no_catastral; ?></SimpleData>
                        <SimpleData name="Estado de la vía"><?php echo $predioArray[0]->estado_via; ?></SimpleData>
                        <SimpleData name="Estado del proceso"><?php echo $predioArray[0]->estado_pro; ?></SimpleData>
                    </SchemaData>
                </ExtendedData>
                <!-- visibilidad de la tabla de datos al iniciar el google earth 1:visible kml- 0: no visible  -->
                <gx:balloonVisibility>0</gx:balloonVisibility>

                <Polygon>
                    <outerBoundaryIs>
                        <LinearRing>
                            <coordinates>
                                <?php
                                $cont = 1;
                                $max = count($predioArray[1]);
                                foreach ($predioArray[1] as $punto){
                                    echo $punto["x"].",".$punto["y"].",0 ";
                                    if($cont == $max) {echo $predioArray[1][0]['x'].",".$predioArray[1][0]['y'].",0 ";}
                                    $cont++;
                                }?>
                            </coordinates>
                        </LinearRing>
                    </outerBoundaryIs>
                </Polygon>
            </Placemark>
        </Folder> <!-- Fin carpeta predio -->
        <?php endforeach; ?>
    </Folder> <!-- Fin carpata Unidad funcional  -->
<?php endforeach; ?>

</Document>
</kml>

<?php
header('Cache-Control: max-age=0');
// header('Content-Type: text/xml');
header('Content-Type: text/kml');
header("Content-Disposition: attachment; filename=".$nombre_archivo.".kml");
  ?>
