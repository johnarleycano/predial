<?php
class InformesDAO extends CI_Model
{
	function obtener_informe_actas()
	{
		$query = "SELECT tbl_predio.ficha_predial AS 'PREDIO', tbl_actas.pg_ficha AS 'FICHA APROBADA', tbl_actas.pg_ef AS 'ENTREGA FISICA', tbl_actas.pg_comp AS 'COMPRAVENTA', tbl_actas.pg_reg 'REGISTRO', (SELECT tbl_propietario.nombre FROM tbl_propietario, tbl_relacion WHERE tbl_relacion.id_propietario=tbl_propietario.id_propietario AND tbl_relacion.ficha_predial=PREDIO LIMIT 1) AS 'PROPIETARIO'";
		$query .= "FROM { OJ tbl_predio LEFT OUTER JOIN tbl_actas ON tbl_predio.id_predio=tbl_actas.id_predio } ";
		$query .= "ORDER BY tbl_predio.ficha_predial";
		$resultado = $this->db->query($query);

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Consulta el informe de las actas en las que se paga la gestion predial'
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}

	function obtener_informe_predios() {
		$query = 	"SELECT tbl_predio.ficha_predial AS PREDIO, tbl_identificacion.total_avaluo AS  VALOR_TOTAL, (
								SELECT SUM( tbl_pagos.valor )
								FROM tbl_pagos
								WHERE tbl_pagos.ficha_predial = PREDIO
							) AS  TOTAL_PAGADO
					 FROM tbl_predio, tbl_identificacion
					 WHERE tbl_predio.ficha_predial = tbl_identificacion.ficha_predial";
		$resultado = $this->db->query($query)->result();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Consulta el informe de pagos de los predios'
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}

	function obtener_avaluos($requerido){
		$condicion = "";

		if ($requerido != "") {
			$condicion = "WHERE tbl_predio.requerido = {$requerido}";
		}

		$sql =
		"SELECT
		tbl_predio.ficha_predial AS ficha,
		tbl_identificacion.no_catastral AS numero_catastral,
		tbl_propietario.nombre AS primer_propietario,
		tbl_identificacion.f_envio_av AS envio_avaluador,
		tbl_identificacion.r_envio_av AS radicado_envio,
		tbl_identificacion.f_recibo_av AS fecha_recibo,
		tbl_identificacion.valor_mtr AS valor_metro,
		tbl_descripcion.area_total,
		tbl_identificacion.valor_total_terr AS valor_terreno,
		tbl_identificacion.total_avaluo AS valor_total,
		tbl_identificacion.estado_pro AS estado
		FROM
		tbl_predio
		INNER JOIN tbl_identificacion ON tbl_identificacion.ficha_predial = tbl_predio.ficha_predial
		INNER JOIN tbl_descripcion ON tbl_descripcion.ficha_predial = tbl_predio.ficha_predial
		INNER JOIN tbl_relacion ON tbl_relacion.ficha_predial = tbl_predio.ficha_predial
		INNER JOIN tbl_propietario ON tbl_propietario.id_propietario = tbl_relacion.id_propietario
		{$condicion}
		GROUP BY
		tbl_relacion.ficha_predial";

		return $this->db->query($sql)->result();
	}

	function obtener_avaluos_vencidos() {
		$contratistas = $this->db->get('tbl_contratistas')->result();
		$array_contratistas = array();
		$array_contratistas[0] = '';
		foreach ($contratistas as $contratista):
			$array_contratistas[$contratista->id_cont] = $contratista->nombre;
		endforeach;



		$this->db->from('tbl_predio');
		$this->db->join('tbl_identificacion', 'tbl_identificacion.ficha_predial=tbl_predio.ficha_predial');
		$predios = $this->db->get()->result();
		$resultado = array();
		foreach ($predios as $predio):
			$fecha_recibo = $predio->f_recibo_av;

			$fecha_expiracion = explode("-", $fecha_recibo);
			$fecha_expiracion[0]++;
			$fecha_expiracion = strtotime(implode("-", $fecha_expiracion));

			$array = array();

			$hoy = strtotime(date("Y-m-d", time()));
			$diferencia = (int)(($fecha_expiracion - $hoy) / 86400);
			if($diferencia <= 0) {
				$array['ficha_predial'] = $predio->ficha_predial;
				$array['contratista'] = $array_contratistas[(int)$predio->enc_gestion];
				$propietario = $this->db->query("SELECT * FROM tbl_propietario, tbl_relacion WHERE tbl_relacion.ficha_predial='".$predio->ficha_predial."' AND tbl_relacion.id_propietario=tbl_propietario.id_propietario LIMIT 0,1")->row();
				if(!empty($propietario)) {
					$array['propietario'] = $propietario->nombre;
				}
				else {
					$array['propietario'] = "";
				}
				$array['fecha_avaluo'] = $predio->f_recibo_av;
				$array['fecha_expiracion'] = date("Y-m-d", $fecha_expiracion);
				$array['dias_expirado'] = - $diferencia;
				$array['estado'] = $predio->estado_pro;
				array_push($resultado, $array);
			}
		endforeach;

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Consulta el informe de avaluos vencidos'
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}

	function obtener_avaluos_en_vencimiento() {
		$contratistas = $this->db->get('tbl_contratistas')->result();
		$array_contratistas = array();
		$array_contratistas[0] = '';
		foreach ($contratistas as $contratista):
			$array_contratistas[$contratista->id_cont] = $contratista->nombre;
		endforeach;


		$this->db->from('tbl_predio');
		$this->db->join('tbl_identificacion', 'tbl_identificacion.ficha_predial=tbl_predio.ficha_predial');
		$predios = $this->db->get()->result();
		$resultado = array();
		foreach ($predios as $predio):
			$fecha_recibo = $predio->f_recibo_av;

			$fecha_expiracion = explode("-", $fecha_recibo);
			$fecha_expiracion[0]++;
			$fecha_expiracion = strtotime(implode("-", $fecha_expiracion));

			$array = array();

			$hoy = strtotime(date("Y-m-d", time()));
			$diferencia = (int)(($fecha_expiracion - $hoy) / 86400);
			if($diferencia <= 30 && $diferencia > 0) {
				$array['ficha_predial'] = $predio->ficha_predial;
				$array['contratista'] = $array_contratistas[(int)$predio->enc_gestion];
				$array['fecha_expiracion'] = date("Y-m-d", $fecha_expiracion);
				$array['dias_expirado'] = $diferencia;
				$array['estado'] = $predio->estado_pro;
				array_push($resultado, $array);
			}
		endforeach;

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Consulta el informe de avaluos a punto de expirar'
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}

	function obtener_informes()
	{
		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Consulta los informes que el sistema genera'
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $this->db->get('tbl_informes')->result();
	}

	function obtener_informe_gestion_predial() {
		$query = "select * from informe_gestion_predial";
		return $this->db->query($query)->result();
	}

	function obtener_predios_agrupados($unidad_funcional = NULL){
		($unidad_funcional) ? $unidad = "AND p.ficha_predial LIKE '{$unidad_funcional}%'" : $unidad = "" ;
		$sql =
		"SELECT
			p.ficha_predial
		FROM
			tbl_predio AS p
		WHERE
			p.requerido = '1'
			$unidad
		-- GROUP BY
		-- 	substring(p.ficha_predial, 1, 18) 
		ORDER BY
			p.ficha_predial ASC";

		return $this->db->query($sql)->result();
	}

	function obtener_predios_ficha($predio){
		$sql =
		"SELECT
			p.ficha_predial
		FROM
			tbl_predio AS p
		WHERE
			p.requerido = '1'
			AND  p.ficha_predial LIKE '{$predio}%'
			-- AND p.ficha_predial NOT LIKE '%M%' 
		ORDER BY
			p.ficha_predial ASC";

		return $this->db->query($sql)->result();
	}

	/*Inicio Consulta Original con Unidad funcional al inicio de la ficha se comenta y se crea otra consulta*/

	/*function obtener_informe_gestion_predial_ani($ficha) {
		// Si existe una ficha específica
		if ($ficha != null) {
			$condicion = " AND tbl_predio.ficha_predial = '{$ficha}' ";
			$requerido = " ";
		}else{
			$condicion = "";
			$requerido = "AND tbl_predio.requerido = '1'";
		} // if

		$query =
		"SELECT
			substring(tbl_predio.ficha_predial, 1, 3) unidad_funcional,
			substring(tbl_predio.ficha_predial, 5, 2) predio,
			substring(tbl_predio.ficha_predial, 8, 1) abreviatura,
			CASE substring(tbl_predio.ficha_predial, 8, 1) WHEN 'F' THEN 'Área' WHEN 'M' THEN 'Mejora' END tipo_ficha,
			substring(tbl_predio.ficha_predial, 10, 2) numero_faja,
			tbl_predio.ficha_predial,
			d.numero,
			d.tramo,
			d.abscisa_inicial,
			d.abscisa_final,
			CASE d.requiere_longitud_efectiva WHEN '0' THEN 'No' WHEN '1' THEN 'Si' END requiere_longitud_efectiva,
			d.estado_ambiental,
			d.margen_inicial,
			d.margen_final,
			d.fecha_remision_insumos,
			d.margen,
			d.meta_contractual,
			d.disponibilidad_izquierda,
			d.disponibilidad_derecha,
			i.f_recibo_av,
			i.valor_total_terr,
			i.valor_mtr,
			i.municipio,
			i.barrio,
			(
				SELECT
					COUNT(tbl_relacion.id_relacion)
				FROM
					tbl_relacion
				WHERE
					tbl_relacion.ficha_predial = tbl_predio.ficha_predial
				GROUP BY
					tbl_relacion.ficha_predial
			) AS numero_propietarios,
			(
				SELECT
					tbl_propietario.nombre
				FROM
					tbl_relacion
				INNER JOIN tbl_propietario ON tbl_relacion.id_propietario = tbl_propietario.id_propietario
				WHERE
					tbl_relacion.ficha_predial = tbl_predio.ficha_predial
				GROUP BY
					tbl_relacion.ficha_predial
			) AS nombre_propietario,
			(
				SELECT
					tbl_propietario.email
				FROM
					tbl_relacion
				INNER JOIN tbl_propietario ON tbl_relacion.id_propietario = tbl_propietario.id_propietario
				WHERE
					tbl_relacion.ficha_predial = tbl_predio.ficha_predial
				GROUP BY
					tbl_relacion.ficha_predial
			) AS email_propietario,
			(
				SELECT
					tbl_propietario.documento
				FROM
					tbl_relacion
				INNER JOIN tbl_propietario ON tbl_relacion.id_propietario = tbl_propietario.id_propietario
				WHERE
					tbl_relacion.ficha_predial = tbl_predio.ficha_predial
				GROUP BY
					tbl_relacion.ficha_predial
			) AS documento_propietario,
			(
				SELECT
					tbl_propietario.direccion
				FROM
					tbl_relacion
				INNER JOIN tbl_propietario ON tbl_relacion.id_propietario = tbl_propietario.id_propietario
				WHERE
					tbl_relacion.ficha_predial = tbl_predio.ficha_predial
				GROUP BY
					tbl_relacion.ficha_predial
			) AS direccion_propietario,
			(
				SELECT
					tbl_propietario.telefono
				FROM
					tbl_relacion
				INNER JOIN tbl_propietario ON tbl_relacion.id_propietario = tbl_propietario.id_propietario
				WHERE
					tbl_relacion.ficha_predial = tbl_predio.ficha_predial
				GROUP BY
					tbl_relacion.ficha_predial
			) AS telefono_propietario,
			i.direccion,
			i.fecha_estudio,
			i.matricula_orig AS matricula,
			i.no_catastral,
			i.escritura_orig,
			i.no_notaria,
			i.fecha_escritura,
			i.ciudad,
			d.uso_edificacion,
			d.uso_terreno,
			d.topografia,
			d.observacion,
			pr.norte_long,
			pr.oriente_long,
			pr.sur_long,
			pr.occidente_long,
			pr.nom_norte,
			pr.nom_oriente,
			pr.nom_sur,
			pr.nom_occ,
			pr.c_licencia,
			pr.c_reglamento,
			pr.c_levantamiento,
			pr.c_informe,
			pr.c_adquisicion,
			i.lind_titulo,
			tbl_funcion.nombre AS funcion_predio,
			tbl_estado_via.nombre AS estado_via,
			i.estado_predio,
			i.estado_pro,
			d.area_requerida,
			d.area_cons_requerida,
			d.area_construida,
			d.area_total,
			d.area_total_catastral,
			d.area_residual,
			tbl_estado_via.color_kml AS color_via,
			tbl_estados_proceso.color_kml AS color_proceso
		FROM
			tbl_predio
		INNER JOIN tbl_descripcion AS d ON tbl_predio.ficha_predial = d.ficha_predial
		INNER JOIN tbl_identificacion AS i ON tbl_predio.ficha_predial = i.ficha_predial
		INNER JOIN tbl_predio_req AS pr ON pr.ficha_predial = tbl_predio.ficha_predial
		LEFT JOIN tbl_estados_semaforo AS tbl_funcion ON i.id_funcion_predio = tbl_funcion.id
		LEFT JOIN tbl_estados_semaforo AS tbl_estado_via ON tbl_estado_via.id = i.id_estado_via
		LEFT JOIN tbl_estados_proceso ON tbl_estados_proceso.estado = i.estado_pro
		WHERE
			tbl_predio.ficha_predial <> ''
			{$requerido}
			{$condicion}
		ORDER BY
			tbl_predio.ficha_predial ASC";

		if ($ficha) {
			return $this->db->query($query)->row();
		}else{
			return $this->db->query($query)->result();
		}
	}*/ 

/*Fin consulta original */


function obtener_informe_gestion_predial_ani($ficha) {
		// Si existe una ficha específica
		if ($ficha != null) {
			$condicion = " AND tbl_predio.ficha_predial = '{$ficha}' ";
			$requerido = " ";
		}else{
			$condicion = "";
			$requerido = "AND tbl_predio.requerido = '1'";
		} // if

		$query =
		"SELECT
			substring(tbl_predio.ficha_predial, 1, 4) proyecto,		
			substring(tbl_predio.ficha_predial, 10, 4) unidad_funcional,
			substring(tbl_predio.ficha_predial, 15, 4) predio,
			substring(tbl_predio.ficha_predial, 19, 1) abreviatura,			
			CASE substring(tbl_predio.ficha_predial, 8, 1) WHEN 'F' THEN 'Área' WHEN 'M' THEN 'Mejora' END tipo_ficha,
			substring(tbl_predio.ficha_predial, 21, 1) numero_faja,			
			tbl_predio.ficha_predial,
			d.numero,
			d.tramo,
			d.abscisa_inicial,
			d.abscisa_final,
			CASE d.requiere_longitud_efectiva WHEN '0' THEN 'No' WHEN '1' THEN 'Si' END requiere_longitud_efectiva,
			d.estado_ambiental,
			d.margen_inicial,
			d.margen_final,
			d.fecha_remision_insumos,
			d.margen,
			d.meta_contractual,
			d.disponibilidad_izquierda,
			d.disponibilidad_derecha,
			i.f_recibo_av,
			i.valor_total_terr,
			i.valor_mtr,
			i.municipio,
			i.barrio,
			(
				SELECT
					COUNT(tbl_relacion.id_relacion)
				FROM
					tbl_relacion
				WHERE
					tbl_relacion.ficha_predial = tbl_predio.ficha_predial
				GROUP BY
					tbl_relacion.ficha_predial
			) AS numero_propietarios,
			(
				SELECT
					tbl_propietario.nombre
				FROM
					tbl_relacion
				INNER JOIN tbl_propietario ON tbl_relacion.id_propietario = tbl_propietario.id_propietario
				WHERE
					tbl_relacion.ficha_predial = tbl_predio.ficha_predial
				GROUP BY
					tbl_relacion.ficha_predial
			) AS nombre_propietario,
			(
				SELECT
					tbl_propietario.email
				FROM
					tbl_relacion
				INNER JOIN tbl_propietario ON tbl_relacion.id_propietario = tbl_propietario.id_propietario
				WHERE
					tbl_relacion.ficha_predial = tbl_predio.ficha_predial
				GROUP BY
					tbl_relacion.ficha_predial
			) AS email_propietario,
			(
				SELECT
					tbl_propietario.documento
				FROM
					tbl_relacion
				INNER JOIN tbl_propietario ON tbl_relacion.id_propietario = tbl_propietario.id_propietario
				WHERE
					tbl_relacion.ficha_predial = tbl_predio.ficha_predial
				GROUP BY
					tbl_relacion.ficha_predial
			) AS documento_propietario,
			(
				SELECT
					tbl_propietario.direccion
				FROM
					tbl_relacion
				INNER JOIN tbl_propietario ON tbl_relacion.id_propietario = tbl_propietario.id_propietario
				WHERE
					tbl_relacion.ficha_predial = tbl_predio.ficha_predial
				GROUP BY
					tbl_relacion.ficha_predial
			) AS direccion_propietario,
			(
				SELECT
					tbl_propietario.telefono
				FROM
					tbl_relacion
				INNER JOIN tbl_propietario ON tbl_relacion.id_propietario = tbl_propietario.id_propietario
				WHERE
					tbl_relacion.ficha_predial = tbl_predio.ficha_predial
				GROUP BY
					tbl_relacion.ficha_predial
			) AS telefono_propietario,
			i.direccion,
			i.fecha_estudio,
			i.matricula_orig AS matricula,
			i.no_catastral,
			i.escritura_orig,
			i.no_notaria,
			i.fecha_escritura,
			i.ciudad,
			d.uso_edificacion,
			d.uso_terreno,
			d.topografia,
			d.observacion,
			pr.norte_long,
			pr.oriente_long,
			pr.sur_long,
			pr.occidente_long,
			pr.nom_norte,
			pr.nom_oriente,
			pr.nom_sur,
			pr.nom_occ,
			pr.c_licencia,
			pr.c_reglamento,
			pr.c_levantamiento,
			pr.c_informe,
			pr.c_adquisicion,
			i.lind_titulo,
			tbl_funcion.nombre AS funcion_predio,
			tbl_estado_via.nombre AS estado_via,
			i.estado_predio,
			i.estado_pro,
			d.area_requerida,
			d.area_cons_requerida,
			d.area_construida,
			d.area_total,
			d.area_total_catastral,
			d.area_residual,
			tbl_estado_via.color_kml AS color_via,
			tbl_estados_proceso.color_kml AS color_proceso
		FROM
			tbl_predio
		INNER JOIN tbl_descripcion AS d ON tbl_predio.ficha_predial = d.ficha_predial
		INNER JOIN tbl_identificacion AS i ON tbl_predio.ficha_predial = i.ficha_predial
		INNER JOIN tbl_predio_req AS pr ON pr.ficha_predial = tbl_predio.ficha_predial
		LEFT JOIN tbl_estados_semaforo AS tbl_funcion ON i.id_funcion_predio = tbl_funcion.id
		LEFT JOIN tbl_estados_semaforo AS tbl_estado_via ON tbl_estado_via.id = i.id_estado_via
		LEFT JOIN tbl_estados_proceso ON tbl_estados_proceso.estado = i.estado_pro
		WHERE
			tbl_predio.ficha_predial <> ''
			{$requerido}
			{$condicion}
		ORDER BY
			tbl_predio.ficha_predial ASC";

		if ($ficha) {
			return $this->db->query($query)->row();
		}else{
			return $this->db->query($query)->result();
		}
	}



	function formatear_fecha($fecha){
        //Si No hay fecha, devuelva vac&iacute;o en vez de 0000-00-00
        if($fecha == '0000-00-00' || $fecha == '1969-12-31 19:00:00' || !$fecha){
            return false;
        }

        $dia_num = date("j", strtotime($fecha));
        $dia = date("N", strtotime($fecha));
        $mes = date("m", strtotime($fecha));
        $anio_es = date("Y", strtotime($fecha));

        //Nombres de los d&iacute;as
        if($dia == "1"){ $dia_es = "Lunes"; }
        if($dia == "2"){ $dia_es = "Martes"; }
        if($dia == "3"){ $dia_es = "Miercoles"; }
        if($dia == "4"){ $dia_es = "Jueves"; }
        if($dia == "5"){ $dia_es = "Viernes"; }
        if($dia == "6"){ $dia_es = "Sabado"; }
        if($dia == "7"){ $dia_es = "Domingo"; }

        //Nombres de los meses
        if($mes == "1"){ $mes_es = "enero"; }
        if($mes == "2"){ $mes_es = "febrero"; }
        if($mes == "3"){ $mes_es = "marzo"; }
        if($mes == "4"){ $mes_es = "abril"; }
        if($mes == "5"){ $mes_es = "mayo"; }
        if($mes == "6"){ $mes_es = "junio"; }
        if($mes == "7"){ $mes_es = "julio"; }
        if($mes == "8"){ $mes_es = "agosto"; }
        if($mes == "9"){ $mes_es = "septiembre"; }
        if($mes == "10"){ $mes_es = "octubre"; }
        if($mes == "11"){ $mes_es = "noviembre"; }
        if($mes == "12"){ $mes_es = "diciembre"; }

        //a&ntilde;o
        //$anio_es = $anio_es;

        //Se foramtea la fecha
        $fecha = /*$dia_es." ".*/$dia_num." de ".$mes_es." de ".$anio_es;

        return $fecha;
    }//Fin formato_fecha()
}
/* End of file informesdao.php */
/* Location: ./site_predios/application/models/informesdao.php */
