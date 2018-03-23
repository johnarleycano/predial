<?php
/**
 * DAO que se encarga de gestionar la informacion de la ficha social de los predios registrados en el sistema.
 * @author 		John Arley Cano Salinas
 * @copyright	2016
 */
class Gestion_socialDAO extends CI_Model
{
	function actualizar_ficha($ficha, $datos){
		$this->db->where('ficha_predial', $ficha);
		if($this->db->update('tbl_ficha_social', $datos)){
            //Retorna verdadero
            return true;
        }
	}

	function actualizar_diagnostico($ficha, $datos, $tipo=null, $id=null){
		if ($tipo) {
			$this->db->where($tipo, $id);
		}
		$this->db->where('ficha_predial', $ficha);
		if($this->db->update('tbl_diagnostico_social', $datos)){
			//Retorna verdadero
			return true;
		}
	}

	function actualizar_usr($id, $datos){
		$this->db->where('id', $id);
		if($this->db->update('tbl_unidades_sociales_residentes', $datos)){
            //Retorna verdadero
            return true;
        }
	}

	function actualizar_usp($id, $datos){
		$this->db->where('id', $id);
		if($this->db->update('tbl_unidades_sociales_productivas', $datos)){
            //Retorna verdadero
            return true;
        }
	}

	function cargar_ficha($ficha_predial){
		$this->db->select('*');
		$this->db->where('ficha_predial', $ficha_predial);
	 	return $this->db->get('tbl_ficha_social')->row();
	}

	function cargar_diagnostico($ficha_predial, $tipo=null, $id=null){
		$this->db->select('*');
		if ($tipo) {
			$this->db->where($tipo, $id);
		}
		$this->db->where('ficha_predial', $ficha_predial);
		return $this->db->get('tbl_diagnostico_social')->row();
	}

	function cargar_valores_ficha($id_lista){
		$this->db->select('*');
		$this->db->where('id_lista_social', $id_lista);
		$this->db->order_by('nombre');
	 	return $this->db->get('tbl_valores_social')->result();
	}

	function cargar_valor_ficha($id)
	{
		$this->db->select('*');
		$this->db->where('id', $id);
	 	return $this->db->get('tbl_valores_social')->row();
	}

	function cargar_valores_ficha_social($ficha, $id_unidad_social){
		$this->db->select('*');

		if ($id_unidad_social != 0) {
			$this->db->where('id_unidad_social', $id_unidad_social);
		}else{
			$this->db->where('ficha_predial', $ficha);
		}

	 	return $this->db->get('tbl_ficha_valores')->result();
	 	// return $ficha;
	}

	function insertar_ficha($datos){
		if($this->db->insert('tbl_ficha_social', $datos)){
			return true;
		}
	}

	function insertar_diagnostico($datos){
		if($this->db->insert('tbl_diagnostico_social', $datos)){
			return true;
		}
	}

	function insertar_usp($datos){
		if($this->db->insert('tbl_unidades_sociales_productivas', $datos)){
			return true;
		}
	}

	function insertar_usr($datos){
		if($this->db->insert('tbl_unidades_sociales_residentes', $datos)){
			return true;
		}
	}

	function insertar_valor_ficha($datos){
		if($this->db->insert('tbl_ficha_valores', $datos)){
			return true;
		}
	}

	function eliminar_valores_ficha($datos){
		if($this->db->delete('tbl_ficha_valores', $datos)){
			return true;
		}
	}


	function cargar_unidad_social_residente($id){
		$sql = "SELECT
			usr.id,
			usr.ficha_predial,
			usr.relacion_inmueble id_relacion_inmueble,
			vrelacion.nombre AS relacion_inmueble,
			usr.responsable,
			usr.identificacion,
			usr.edad,
			usr.ocupacion id_ocupacion,
			vocupacion.nombre AS ocupacion,
			usr.otras_actividades,
			usr.ingresos_mensuales,
			usr.datos_verificacion,
			usr.nombre_integrante1,
			usr.nombre_integrante2,
			usr.nombre_integrante3,
			usr.nombre_integrante4,
			usr.nombre_integrante5,
			usr.relacion_integrante1 AS id_relacion_integrante1,
			vrelacion1.nombre AS relacion_integrante1,
			usr.relacion_integrante2 AS id_relacion_integrante2,
			vrelacion2.nombre AS relacion_integrante2,
			usr.relacion_integrante3 AS id_relacion_integrante3,
			vrelacion3.nombre AS relacion_integrante3,
			usr.relacion_integrante4 AS id_relacion_integrante4,
			vrelacion4.nombre AS relacion_integrante4,
			usr.relacion_integrante5 AS id_relacion_integrante5,
			vrelacion5.nombre AS relacion_integrante5,
			usr.edad_integrante1,
			usr.edad_integrante2,
			usr.edad_integrante3,
			usr.edad_integrante4,
			usr.edad_integrante5,
			usr.ocupacion_integrante1 AS id_ocupacion_integrante1,
			vocupacion1.nombre AS ocupacion_integrante1,
			usr.ocupacion_integrante2 AS id_ocupacion_integrante2,
			vocupacion2.nombre AS ocupacion_integrante2,
			usr.ocupacion_integrante3 AS id_ocupacion_integrante3,
			vocupacion3.nombre AS ocupacion_integrante3,
			usr.ocupacion_integrante4 AS id_ocupacion_integrante4,
			vocupacion4.nombre AS ocupacion_integrante4,
			usr.ocupacion_integrante5 AS id_ocupacion_integrante5,
			vocupacion5.nombre AS ocupacion_integrante5,


			usr.ingresos_integrante1,
			usr.ingresos_integrante2,
			usr.ingresos_integrante3,
			usr.ingresos_integrante4,
			usr.ingresos_integrante5,
			usr.verificacion_integrante1,
			usr.verificacion_integrante2,
			usr.verificacion_integrante3,
			usr.verificacion_integrante4,
			usr.verificacion_integrante5,
			usr.total_ingresos,
			usr.antiguedad,
			usr.canon,
			usr.integrante_posee_inmuebe,
			usr.integrante_inmueble,
			usr.traslado_inmueble,
			usr.traslado_razon,
			usr.servicio_educacion,
			usr.servicio_geriatria,
			usr.servicio_guarderia,
			usr.servicio_ninguno,
			usr.servicio_rehabilitacion,
			usr.servicio_restaurante,
			usr.servicio_transporte,
			usr.desarrollo_actividades_productivas,
			usr.actividades_productivas
		FROM
			tbl_unidades_sociales_residentes AS usr
		LEFT JOIN tbl_valores_social AS vrelacion ON usr.relacion_inmueble = vrelacion.id
		LEFT JOIN tbl_valores_social AS vocupacion ON usr.ocupacion = vocupacion.id
		LEFT JOIN tbl_valores_social AS vrelacion1 ON usr.relacion_integrante1 = vrelacion1.id
		LEFT JOIN tbl_valores_social AS vrelacion2 ON usr.relacion_integrante2 = vrelacion1.id
		LEFT JOIN tbl_valores_social AS vrelacion3 ON usr.relacion_integrante3 = vrelacion1.id
		LEFT JOIN tbl_valores_social AS vrelacion4 ON usr.relacion_integrante4 = vrelacion1.id
		LEFT JOIN tbl_valores_social AS vrelacion5 ON usr.relacion_integrante5 = vrelacion1.id
		LEFT JOIN tbl_valores_social AS vocupacion1 ON usr.ocupacion_integrante1 = vocupacion1.id
		LEFT JOIN tbl_valores_social AS vocupacion2 ON usr.ocupacion_integrante2 = vocupacion2.id
		LEFT JOIN tbl_valores_social AS vocupacion3 ON usr.ocupacion_integrante3 = vocupacion3.id
		LEFT JOIN tbl_valores_social AS vocupacion4 ON usr.ocupacion_integrante4 = vocupacion4.id
		LEFT JOIN tbl_valores_social AS vocupacion5 ON usr.ocupacion_integrante5 = vocupacion5.id
		WHERE
			usr.id = {$id}";
	 	return $this->db->query($sql)->row();
	}

	function cargar_unidades_sociales_productivas($ficha_predial=null){
	 	$sql =
	 	"SELECT
			usp.id,
			usp.ficha_predial,
			v.nombre AS relacion_inmueble,
			usp.titular,
			(IF(usp.nombre_arrendatario1 <> '', 1, 0)) +
			(IF(usp.nombre_arrendatario2 <> '', 1, 0)) +
			(IF(usp.nombre_arrendatario3 <> '', 1, 0)) +
			(IF(usp.nombre_arrendatario4 <> '', 1, 0)) +
			(IF(usp.nombre_arrendatario5 <> '', 1, 0)) arrendatarios,
			(
				SELECT
					COUNT(a.id)
				FROM
					tbl_archivos AS a
				WHERE
					a.ficha_predial = usp.ficha_predial AND a.tipo=4 AND a.categoria=2 AND a.id_usp = usp.id
			) AS fotos,
			(
				SELECT
					COUNT(a.id)
				FROM
					tbl_archivos AS a
				WHERE
					a.ficha_predial = usp.ficha_predial AND a.tipo=4 AND a.categoria=1 AND a.id_usp = usp.id
			) AS archivos
		FROM
			tbl_unidades_sociales_productivas AS usp
		LEFT JOIN tbl_valores_social AS v ON usp.relacion_inmueble = v.id";
		if ($ficha_predial) {
			$sql .= " WHERE usp.ficha_predial = '{$ficha_predial}'";
		}
	 	return $this->db->query($sql)->result();
	}

	function cargar_unidades_sociales_residentes($ficha_predial=null){
		$sql =
		"SELECT
			usr.id,
			usr.ficha_predial,
			v.nombre AS relacion_inmueble,
			usr.responsable,
			(IF(usr.nombre_integrante1 <> '', 1, 0)) +
			(IF(usr.nombre_integrante2 <> '', 1, 0)) +
			(IF(usr.nombre_integrante3 <> '', 1, 0)) +
			(IF(usr.nombre_integrante4 <> '', 1, 0)) +
			(IF(usr.nombre_integrante5 <> '', 1, 0)) +
			(IF(usr.nombre_integrante6 <> '', 1, 0)) +
			(IF(usr.nombre_integrante7 <> '', 1, 0)) +
			(IF(usr.nombre_integrante8 <> '', 1, 0)) +
			(IF(usr.nombre_integrante9 <> '', 1, 0)) +
			(IF(usr.nombre_integrante10 <> '', 1, 0)) +
			(IF(usr.nombre_integrante11 <> '', 1, 0)) +
			(IF(usr.nombre_integrante12 <> '', 1, 0)) integrantes,
			(
				SELECT
					COUNT(a.id)
				FROM
					tbl_archivos AS a
				WHERE
					a.ficha_predial = usr.ficha_predial AND a.tipo=3 AND a.categoria=2 AND a.id_usr = usr.id
			) AS fotos,
			(
				SELECT
					COUNT(a.id)
				FROM
					tbl_archivos AS a
				WHERE
					a.ficha_predial = usr.ficha_predial AND a.tipo=3 AND a.categoria=1 AND a.id_usr = usr.id
			) AS archivos
		FROM
			tbl_unidades_sociales_residentes AS usr
		LEFT JOIN tbl_valores_social AS v ON usr.relacion_inmueble = v.id";

		if ($ficha_predial) {
			$sql .= " WHERE usr.ficha_predial = '{$ficha_predial}'";
		}

		$sql .= " ORDER BY usr.ficha_predial ASC";

	 	return $this->db->query($sql)->result();
	}


	function cargar_unidad_social_productiva($id){
		$this->db->select('*');
		$this->db->where('id', $id);
	 	return $this->db->get('tbl_unidades_sociales_productivas')->row();
	}





}
/* End of file gestion_socialDAO.php */
/* Location: ./site_predios/application/models/gestion_socialDAO.php */
