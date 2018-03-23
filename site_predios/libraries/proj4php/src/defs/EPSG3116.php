<?php

return [
    "EPSG:3116" => "+proj=tmerc +lat_0=4.596200416666666 +lon_0=-74.07750791666666 +k=1 +x_0=1000000 +y_0=1000000 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs",
];
// +proj=tmerc +lat_0=4.596200416666666 +lon_0=-74.07750791666666 +k=1 +x_0=1000000 +y_0=1000000 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs
// How about supporting a structure like this too? Just a thought.
return [
    "EPSG:3116" => [
        "+proj"     => "tmerc",
        "+lat_0"    => "4.596200416666666",
        "+lon_0"    => "-74.07750791666666",
        "+k"    => "1",
        "+x_0"      => "1000000",
        "+y_0"      => "1000000",
        "+ellps"    => "GRS80",
        "+towgs84"  => "0,0,0,0,0,0,0",
        "+units"    => "m +no_defs",
    ],
];
