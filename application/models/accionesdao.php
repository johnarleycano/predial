<?php
class AccionesDAO extends CI_Model {
	function obtener_acciones() {
		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Consulta las acciones del sistema'
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $this->db->get('tbl_acciones')->result();
	}

    function consultar_archivo($ficha, $tipo=null, $categoria=null , $id=null){
        $this->db->select("*");
		if ($id) {
			if ($tipo == 3) {
				$this->db->where('id_usr', $id);
			} else if ($tipo == 4) {
				$this->db->where('id_usp', $id);
			}
		}
		//obtener todas las fotos de una ficha especifica
		$this->db->where('ficha_predial', $ficha);
		$this->db->where('tipo', $tipo);
		$this->db->where('categoria', $categoria);
		$this->db->order_by('orden', 'ASC');
		return $this->db->get('tbl_archivos')->result();
    }

    function eliminar_foto($nombre)
    {
        // Se borran todas las relaciones del predio
        $this->db->where('archivo', $nombre);
        return $this->db->delete('tbl_archivos');
    }

    function guardar_foto($datos)
    {
        // Si se guarda correctamente
        if($this->db->insert('tbl_archivos', $datos)){
            return true;
        }
    }

	function actualizar_foto($nombre, $data){
		$this->db->where('archivo', $nombre);
		$this->db->update('tbl_archivos', $data);
	}

	function guardar_archivo_social($datos)
    {
        // Si se guarda correctamente
        if($this->db->insert('tbl_archivos', $datos)){
            return true;
        }
    }

	function eliminar_archivo_social($nombre)
	{
		// Se borran todas las relaciones del predio
		$this->db->where('archivo', $nombre);
		return $this->db->delete('tbl_archivos');
	}

	/**
     * Script que procesa la foto y la redimensiona, logrando reducir su tamaño
     * hasta en un 98%
     *
     * @param  [string] $ruta [Ruta del archivo temporal que se va a subir]
     */
    function procesar_foto($ruta, $directorio, $nombre){
        //Ruta de la imagen original
        $ruta_imagen = $ruta;

        //Creamos una variable imagen a partir de la imagen original
        $img_original = imagecreatefromjpeg($ruta_imagen);

        //Se define el maximo ancho y alto que tendra la imagen final
        $ancho_maximo = 640;
        $alto_maximo = 480;

        //Ancho y alto de la imagen original
        list($ancho, $alto) = getimagesize($ruta_imagen);

        //Se calcula ancho y alto de la imagen final
        $x_ratio = $ancho_maximo / $ancho;
        $y_ratio = $alto_maximo / $alto;

        /**
         * Si el ancho y el alto de la imagen no superan los maximos,
         * ancho final y alto final son los que tiene actualmente
         */
        if( ($ancho <= $ancho_maximo) && ($alto <= $alto_maximo) ){
            //Si ancho
            $ancho_final = $ancho;
            $alto_final = $alto;
        } elseif (($x_ratio * $alto) < $alto_maximo){
            /*
            * si proporcion horizontal*alto mayor que el alto maximo,
            * alto final es alto por la proporcion horizontal
            * es decir, le quitamos al ancho, la misma proporcion que
            * le quitamos al alto
            *
            */
            $alto_final = ceil($x_ratio * $alto);
            $ancho_final = $ancho_maximo;
        }else{
            /*
            * Igual que antes pero a la inversa
            */
            $ancho_final = ceil($y_ratio * $ancho);
            $alto_final = $alto_maximo;
        }//Fin if

        /**
         * Si el ancho y el alto de la imagen no superan los maximos,
         * ancho final y alto final son los que tiene actualmente
         */
        if( ($ancho <= $ancho_maximo) && ($alto <= $alto_maximo) ){
            //Si ancho
            $ancho_final = $ancho;
            $alto_final = $alto;
        }//Fin if

        /*
        * si proporcion horizontal*alto mayor que el alto maximo,
        * alto final es alto por la proporcion horizontal
        * es decir, le quitamos al ancho, la misma proporcion que
        * le quitamos al alto
        *
        */
        elseif (($x_ratio * $alto) < $alto_maximo){
            $alto_final = ceil($x_ratio * $alto);
            $ancho_final = $ancho_maximo;
        }else{
            /*
            * Igual que antes pero a la inversa
            */
            $ancho_final = ceil($y_ratio * $ancho);
            $alto_final = $alto_maximo;
        }

        //Creamos una imagen en blanco de tamaño $ancho_final  por $alto_final .
        $imagen_temporal = imagecreatetruecolor($ancho_final,$alto_final);

        //Copiamos $img_original sobre la imagen que acabamos de crear en blanco ($imagen_temporal)
        imagecopyresampled($imagen_temporal, $img_original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho, $alto);

        //Se destruye variable $img_original para liberar memoria
        imagedestroy($img_original);

        //Definimos la calidad de la imagen final
        $calidad = 95;

        //Se crea la imagen final en el directorio indicado
        if(imagejpeg($imagen_temporal, $directorio.$nombre, $calidad)){
            return true;
        } else {
            return false;
        }
    }//Fin procesar_foto

	function consultar_coordenada($ficha) {
		$this->db->select("*");
		$this->db->where('ficha_predial', $ficha);
		return $this->db->get('tbl_coordenadas')->row();
	}

	function consultar_coordenadas($ficha) {
		$this->db->select("*");
		$this->db->where('ficha_predial', $ficha);
		$this->db->order_by('id', 'ASC');
		return $this->db->get('tbl_coordenadas')->result();
	}

	function insertar_coordenadas($datos) {
		if($this->db->insert_batch('tbl_coordenadas', $datos)){
			return true;
		}
	}

	function eliminar_coordenadas($ficha){
        // Se borran todas las coordenadas del predio
        $this->db->where('ficha_predial', $ficha);
        return $this->db->delete('tbl_coordenadas');
	}

	function consultar_ficha_por_unidad_funcional($unidad) {
		// retorna todas las fichas por unidad funcional de la tabla tbl_coordenadas
		$this->db->select("tbl_coordenadas.ficha_predial");
		$this->db->from('tbl_coordenadas');
		$this->db->join('tbl_predio', 'tbl_coordenadas.ficha_predial=tbl_predio.ficha_predial');
		$this->db->where('tbl_predio.requerido', 1);
		$this->db->group_by('tbl_coordenadas.ficha_predial');
        // $this->db->like('tbl_coordenadas.ficha_predial', 'UF'.$unidad);
		$this->db->like('tbl_coordenadas.ficha_predial', 'PD'.$unidad);
		return $this->db->get()->result();
	}

}
/* End of file accionesdao.php */
/* Location: ./site_predios/application/models/accionesdao.php */
