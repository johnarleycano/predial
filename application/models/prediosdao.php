<?php
/**
 * DAO que se encarga de gestionar la informacion de los predios registrados en el sistema.
 * @author 		Freddy Alexander Vivas Reyes
 * @copyright	&copy; HATOVIAL S.A.S.
 */
class PrediosDAO extends CI_Model
{
	/**
	 * Determina si una ficha predial ya existe.
	 *
	 * @access	public
	 * @param	string	la ficha predial.
	 * @return	TRUE 	si ya existe.
	 * @return	FALSE 	en caso contrario.
	 */
	function existe_ficha($ficha_predial)
	{
		//clausula WHERE del sql.
		$this->db->where('ficha_predial', $ficha_predial);
		//si hay algun resultado
		if($this->db->get('tbl_predio')->num_rows() > 0)
		{
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Inserta una nueva construccion.
	 *
	 * @access	public
	 * @param	array	datos de la construccion.
	 */
	function insertar_construccion($datos)
	{
		//se inserta en la tabla
		if($this->db->insert('tbl_construcciones', $datos)) {
			#accion de auditoria
			$auditoria = array(
				'fecha_hora' => date('Y-m-d H:i:s', time()),
				'id_usuario' => $this->session->userdata('id_usuario'),
				'descripcion' => 'Se insertan nueva construccion en la ficha '.$datos["ficha_predial"]
			);
			$this->db->insert('auditoria', $auditoria);
			#fin accion de auditoria
			return true;
		} else {
			return false;
		}
	} // fin insertar construccion

	/**
	 * Edita una construccion de un predio
	 *
	 * @access	public
	 * @param	string	id de la construccion.
	 * @param	array 	informacion de la construccion.
	 */
	function editar_construccion($id, $datos) {
		$this->db->where('id_construccion', $id);
		if($this->db->update('tbl_construcciones', $datos)) {
			$auditoria = array(
				'fecha_hora' => date('Y-m-d H:i:s', time()),
				'id_usuario' => $this->session->userdata('id_usuario'),
				'descripcion' => 'Se actualiza construccion del predio '.$datos["ficha_predial"]
			);
			$this->db->insert('auditoria', $auditoria);
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Elimina una construccion de un predio
	 *
	 * @access	public
	 * @param	array	id y ficha_predial de la construccion.
	 */
	function eliminar_construccion($datos)
	{
		//se elimina el cultivo
		if($this->db->delete('tbl_construcciones', array('id_construccion' => $datos["id"]))) {
			#accion de auditoria
			$auditoria = array(
				'fecha_hora' => date('Y-m-d H:i:s', time()),
				'id_usuario' => $this->session->userdata('id_usuario'),
				'descripcion' => 'Se elimina construccion del predio '.$datos["ficha_predial"]
			);
			$this->db->insert('auditoria', $auditoria);
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Crea un cultivo en determinado predio
	 *
	 * @access	public
	 * @param	array	datos del cultivo
	 */
	function insertar_cultivo_especie($datos)
	{
		//se inserta en la tabla

		if($this->db->insert('tbl_cultivos_especies', $datos)) {
			#accion de auditoria
			$auditoria = array(
				'fecha_hora' => date('Y-m-d H:i:s', time()),
				'id_usuario' => $this->session->userdata('id_usuario'),
				'descripcion' => 'Se crea un nuevo cultivo en el predio '.$datos["ficha_predial"]
			);
			$this->db->insert('auditoria', $auditoria);
			return true;
		} else {
			return false;
		}
	}
	/**
	 * Elimina un cultivo de un predio.
	 *
	 * @access	public
	 * @param	string	id del cultivo.
	 */
	function eliminar_cultivos_especies($datos)
	{
		//se elimina el cultivo
		if($this->db->delete('tbl_cultivos_especies', array('id_cultivo_especie' => $datos["id"]))) {
			#accion de auditoria
			$auditoria = array(
				'fecha_hora' => date('Y-m-d H:i:s', time()),
				'id_usuario' => $this->session->userdata('id_usuario'),
				'descripcion' => 'Se elimina cultivo u especie del predio '.$datos["ficha_predial"]
			);
			$this->db->insert('auditoria', $auditoria);
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Actualizar un cultivo de un predio.
	 *
	 * @access	public
	 * @param	string	id del cultivo.
	 */
	function editar_cultivo_especies($id, $datos)
	{
		//se edita el cultivo
		$this->db->set($datos);
		$this->db->where('id_cultivo_especie', $id);

		// Si actualiza
		if ($this->db->update('tbl_cultivos_especies')) {
			#accion de auditoria
			$auditoria = array(
				'fecha_hora' => date('Y-m-d H:i:s', time()),
				'id_usuario' => $this->session->userdata('id_usuario'),
				'descripcion' => 'Se actualiza cultivo u especie del predio '.$datos["ficha_predial"]
			);
			$this->db->insert('auditoria', $auditoria);
		 	return true;
		}else{
			return false;
		} // if
	}


	/**
	 * Inserta la identificaci&oacute;n de un predio bas&aacute;ndose en un array.
	 *
	 * @access	public
	 * @param	array	la identificaci&oacute;n del predio.
	 */
	function insertar_identificacion($identificacion)
	{
		//el array asociativo pasado por parametro debe tener sus indices nombrados
		//de la misma forma en que aparecen las columnas de la tabla
		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se inserta la identificacion del predio '.$identificacion['ficha_predial']
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		$this->db->insert('tbl_identificacion', $identificacion);
	}

	/**
	 * Inserta la descripci&oacute;n de un predio bas&aacute;ndose en un array.
	 *
	 * @access	public
	 * @param	array	la descripci&oacute;n del predio.
	 */
	function insertar_descripcion($descripcion)
	{
		//el array asociativo pasado por parametro debe tener sus indices nombrados
		//de la misma forma en que aparecen las columnas de la tabla
		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se inserta la descripcion del predio '.$descripcion['ficha_predial']
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		$this->db->insert('tbl_descripcion', $descripcion);
	}

	/**
	 * Inserta los linderos de un predio.
	 *
	 * @access	public
	 * @param	string	la ficha predial.
	 * @param	string	la descripci&oacute;n de los linderos del predio.
	 */
	function insertar_linderos($ficha_predial, $datos)
	{
		//se inserta en la tabla
		$this->db->insert('tbl_predio_req', $datos);

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se insertan los linderos del predio '.$ficha_predial
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria
	}

	/**
	 * Inserta los datos de un predio.
	 *
	 * @access	public
	 * @param	string	la ficha_predial.
	 * @param	date	fecha y hora en que se realiza el registro.
	 * @param	string	la id del usuario que realiza el registro.
	 */
	function insertar_predio($ficha_predial, $fecha_hora, $usuario)
	{
		//se obtienen las id necesarias
		$identificacion = $this->obtener_id_identificacion($ficha_predial);
		$descripcion = $this->obtener_id_descripcion($ficha_predial);
		$linderos = $this->obtener_id_linderos($ficha_predial);
		//se asignan los valores correspondientes
		$this->db->set('ficha_predial', $ficha_predial);
		$this->db->set('fecha_hora', $fecha_hora);
		$this->db->set('usuario', $usuario);

		//se inserta en la tabla
		$this->db->insert('tbl_predio');

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se insertan los datos del predio '.$ficha_predial
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria
	}

	/**
	 * Obtiene la id de la identificaci&oacute;n del predio.
	 *
	 * @access	private
	 * @param	string	la ficha_predial.
	 * @return	string	la id de la identificaci&oacute;n del predio.
	 */
	private function obtener_id_identificacion($ficha_predial)
	{
		//se selecciona la columna id_identificacion
		$this->db->select('id_identificacion');
		//clausula WHERE del sql
		$this->db->where('ficha_predial', $ficha_predial);
		//se obtienen los resultados
		$resultado = $this->db->get('tbl_identificacion')->row();

		return $resultados;
	}

	/**
	 * Obtiene la id de la descripci&oacute;n del predio.
	 *
	 * @access	private
	 * @param	string	la ficha_predial.
	 * @return	string	la id de la descripcion del predio.
	 */
	private function obtener_id_descripcion($ficha_predial)
	{
		//se selecciona la columna id_descripcion
		$this->db->select('id_descripcion');
		//clausula WHERE del sql
		$this->db->where('ficha_predial', $ficha_predial);
		//se obtienen los resultados
		return $this->db->get('tbl_descripcion')->row();
	}

	/**
	 * Obtiene la id de la descripci&oacute;n de los linderos del predio.
	 *
	 * @access	private
	 * @param	string	la ficha_predial.
	 * @return	string	la id de la descripci&oacute;n de los linderos del predio.
	 */
	private function obtener_id_linderos($ficha_predial)
	{
		//se selecciona la columna id_predio_req
		$this->db->select('id_predio_req');
		//clausula WHERE del sql
		$this->db->where('ficha_predial', $ficha_predial);
		//se obtienen los resultados
		return $this->db->get('tbl_predio_req')->row();
	}

	function obtener_fichas($requerido=null)
	{
		$requeridos = ($requerido) ? "WHERE p.requerido = 1" : "";

		$sql =
		"SELECT
			(
				SELECT
					tbl_propietario.nombre
				FROM
					tbl_relacion
				INNER JOIN tbl_propietario ON tbl_relacion.id_propietario = tbl_propietario.id_propietario
				WHERE
					tbl_relacion.ficha_predial = p.ficha_predial
				GROUP BY
					tbl_relacion.ficha_predial
			) AS propietario,
			p.id_predio,
			p.fecha_hora,
			p.ficha_predial,
			u.us_apellido,
			(
				SELECT
					COUNT(usr.id)
				FROM
					tbl_unidades_sociales_residentes AS usr
				WHERE
					usr.ficha_predial = p.ficha_predial
			) AS usr,
			(
				SELECT
					COUNT(usp.id)
				FROM
					tbl_unidades_sociales_productivas AS usp
				WHERE
					usp.ficha_predial = p.ficha_predial
			) AS usp,
			(
				SELECT
					COUNT(a.id)
				FROM
					tbl_archivos AS a
				WHERE
					a.ficha_predial = p.ficha_predial AND a.tipo=2 AND a.categoria=2
			) AS fotos,
			(
				SELECT
					COUNT(a.id)
				FROM
					tbl_archivos AS a
				WHERE
					a.ficha_predial = p.ficha_predial AND a.tipo=2 AND a.categoria=1
			) AS archivos,
			CASE p.requerido
		WHEN '1' THEN
			'Si'
		ELSE
			'No'
		END requerido
		FROM
			tbl_predio AS p
		INNER JOIN tbl_usuarios AS u ON u.id_usuario = p.usuario
		{$requeridos}
		ORDER BY
			p.ficha_predial ASC";


		return $this->db->query($sql)->result();
	}

	function listar_fichas($palabra_clave, $max_filas) {
		$this->db->select('ficha_predial');
		$this->db->like('ficha_predial', $palabra_clave);
		$this->db->order_by('ficha_predial');
		$resultado = $this->db->get('tbl_predio', $max_filas)->result();

		return $resultado;
	}

	function obtener_predios_contratista($contratista)
	{
		/*$this->db->select('id_predio');
		$this->db->select('tbl_predio.fecha_hora');
		$this->db->select('tbl_predio.ficha_predial');
		$this->db->select('us_nombre');
		$this->db->select('us_apellido');
		$this->db->where('enc_gestion', $contratista);
		$this->db->from('tbl_predio, tbl_usuarios, tbl_identificacion');
		$this->db->where('tbl_usuarios.id_usuario', 'tbl_predio.usuario');
		$this->db->where('tbl_identificacion.ficha_predial', 'tbl_predio.ficha_predial');
		return $this->db->get()->result();*/

		$query = "	SELECT
			tbl_predio.id_predio,
			tbl_predio.fecha_hora,
			tbl_predio.ficha_predial,
			tbl_usuarios.us_nombre,
			tbl_usuarios.us_apellido,
			tbl_propietario.nombre AS propietario
			FROM
			tbl_predio ,
			tbl_usuarios ,
			tbl_identificacion ,
			tbl_propietario
			WHERE tbl_identificacion.enc_gestion LIKE  '$contratista'
					AND tbl_usuarios.id_usuario = tbl_predio.usuario
					AND tbl_identificacion.ficha_predial = tbl_predio.ficha_predial";
		$resultado = $this->db->query($query)->result();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se filtran los predios del contratista: '.$contratista
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}

	function obtener_unidades_funcionales()
	{
		$sql =
		"SELECT
			SUBSTRING_INDEX(p.ficha_predial, '-', 1) Nombre,
			(
				SELECT
					t.tramo
				FROM
					tbl_tramos AS t
				WHERE
					RIGHT (Nombre, 1) = t.id
			) Codigo,
			(
				SELECT
					count(
						SUBSTRING_INDEX(pr.ficha_predial, '-', 1)
					)
				FROM
					tbl_predio pr
				WHERE
					pr.requerido = 1
				AND SUBSTRING_INDEX(pr.ficha_predial, '-', 1) = SUBSTRING_INDEX(p.ficha_predial, '-', 1)
			) Requeridos,
			(
				SELECT
					count(
						SUBSTRING_INDEX(pr.ficha_predial, '-', 1)
					)
				FROM
					tbl_predio pr
				WHERE
					pr.requerido = 0
				AND SUBSTRING_INDEX(pr.ficha_predial, '-', 1) = SUBSTRING_INDEX(p.ficha_predial, '-', 1)
			) No_Requeridos,
			(
				SELECT
					COUNT(i.rad_env_int)
				FROM
					tbl_identificacion AS i
				WHERE
					SUBSTRING_INDEX(i.ficha_predial, '-', 1) = SUBSTRING_INDEX(p.ficha_predial, '-', 1)
				AND i.rad_env_int <> ''
			) Ficha_Enviada
		FROM
			tbl_predio AS p
		GROUP BY
			Nombre
		ORDER BY
			Nombre ASC";

		return $this->db->query($sql)->result();
	}

	function obtener_predios_semaforo($tramo)
	{
		if($ficha){
			$condicion = "WHERE p.ficha_predial = '{$ficha}'";
		}else{
			$condicion = "";
		}

		$sql_ =
		"SELECT
			p.ficha_predial,
			i.id_funcion_predio,
			s_f.color AS color_funcion,
			i.id_estado_via,
			s_e.color AS color_estado,
			i.estado_predio,
			d.abscisa_inicial,
			d.abscisa_final,
			d.margen
		FROM
			tbl_predio AS p
		LEFT JOIN tbl_identificacion AS i ON p.ficha_predial = i.ficha_predial
		LEFT JOIN tbl_estados_semaforo AS s_f ON i.id_funcion_predio = s_f.id
		LEFT JOIN tbl_estados_semaforo AS s_e ON i.id_estado_via = s_e.id
		LEFT JOIN tbl_descripcion AS d ON d.ficha_predial = p.ficha_predial
		$condicion";

		$sql=
		"SELECT
			-- SUBSTRING_INDEX(p.ficha_predial, '-', - 1) AS Numero,
			SUBSTRING(p.ficha_predial, 7, 15) Numero,
			p.ficha_predial,
			i.id_funcion_predio,
			s_f.color AS color_funcion,
			i.id_estado_via,
			s_e.color AS color_estado,
			i.estado_predio,
			d.abscisa_inicial,
			d.abscisa_final,
			d.margen
		FROM
			tbl_predio AS p
		LEFT JOIN tbl_identificacion AS i ON p.ficha_predial = i.ficha_predial
		LEFT JOIN tbl_estados_semaforo AS s_f ON i.id_funcion_predio = s_f.id
		LEFT JOIN tbl_estados_semaforo AS s_e ON i.id_estado_via = s_e.id
		LEFT JOIN tbl_descripcion AS d ON d.ficha_predial = p.ficha_predial
		WHERE
			SUBSTRING_INDEX(p.ficha_predial, '-', 1) = '{$tramo}'
		ORDER BY
			Numero";


		return $this->db->query($sql)->result();
	} // obtener_predio_semaforo

	function obtener_cultivos($ficha_predial)
	{
		$this->db->where('ficha_predial', $ficha_predial);
		$this->db->order_by('cantidad', 'desc');
		$resultado = $this->db->get('tbl_cultivos_especies')->result();

		return $resultado;
	}

	function obtener_cultivo($id)
	{
		$this->db->where('id_cultivo_especie', $id);
		return $this->db->get('tbl_cultivos_especies')->row();

	}

	function obtener_construccion($id) {
		$this->db->where('id_construccion', $id);
		return $this->db->get('tbl_construcciones')->row();

	}

	function obtener_construcciones($ficha_predial, $tipo)
	{
		$this->db->where('ficha_predial', $ficha_predial);
		$this->db->where('id_tipo', $tipo);
		$this->db->order_by('cantidad', 'desc');
		return $this->db->get('tbl_construcciones')->result();
	}


	function obtener_estados_via()
	{
		$this->db->where('funcion_predio_obra', '0');
		$this->db->order_by('orden');
		return $this->db->get('tbl_estados_semaforo')->result();
	} // obtener_estados_via

	function obtener_funciones_predios_obra()
	{
		$this->db->where('funcion_predio_obra', '1');
		$this->db->order_by('orden');
		return $this->db->get('tbl_estados_semaforo')->result();
	} // obtener_funciones_predios_obra

	function obtener_procesos_actuales() {
		$this->db->select('*');
		$this->db->from('tbl_identificacion');
		$this->db->join('tbl_estados_proceso', 'tbl_identificacion.estado_pro = tbl_estados_proceso.estado');
		$this->db->order_by('id');
		$this->db->group_by('estado_pro');
		return $this->db->get()->result();
	} // obtener_procesos_actuales

	function obtener_estados_via_actuales()
	{
		$this->db->select('*');
		$this->db->from('tbl_identificacion');
		$this->db->where('funcion_predio_obra', '0');
		$this->db->join('tbl_estados_semaforo', 'tbl_identificacion.id_estado_via = tbl_estados_semaforo.id');
		$this->db->order_by('orden');
		$this->db->group_by('nombre');
		return $this->db->get()->result();
	} // obtener_estados_via_actuales

	function obtener_predio($id_predio)
	{
		$this->db->where('id_predio', $id_predio);
		$resultado = $this->db->get('tbl_predio')->row();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consultan los datos del predio con id: '.$id_predio
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}

	function obtener_predio_mapas($ficha)
	{
		$this->db->where('ficha_predial', $ficha);
		$resultado = $this->db->get('tbl_predio')->row();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consultan los datos del predio con id: '.$id_predio
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}

	function obtener_descripcion($ficha_predial)
	{
		$this->db->where('ficha_predial', $ficha_predial);
		$resultado = $this->db->get('tbl_descripcion')->row();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consulta la descripcion del predio: '.$ficha_predial
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}

	function obtener_identificacion($ficha_predial)
	{
		// $this->db->where('ficha_predial', $ficha_predial);
		// $resultado = $this->db->get('tbl_identificacion')->row();
		$sql =
		"SELECT
			*, ta.nombre AS nombre_titulo_adquisicion
		FROM
			tbl_identificacion AS i
		LEFT JOIN tbl_titulos_adquisicion AS ta ON i.titulo_adquisicion = ta.id
		WHERE
			i.ficha_predial = '{$ficha_predial}'";

		$resultado = $this->db->query($sql)->row();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consulta la identificacion del predio: '.$ficha_predial
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}

	function obtener_linderos($ficha_predial)
	{
		$this->db->where('ficha_predial', $ficha_predial);
		$resultado =  $this->db->get('tbl_predio_req')->row();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consultan los linderos del predio: '.$ficha_predial
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}

	function obtener_titulos_adquisicion()
	{
		$this->db->order_by('nombre');
		return $this->db->get('tbl_titulos_adquisicion')->result();
	}

	function actualizar_identificacion($ficha_predial, $identificacion)
	{
		$this->db->where('ficha_predial', $ficha_predial);
		//el array asociativo pasado por parametro debe tener sus indices nombrados
		//de la misma forma en que aparecen las columnas de la tabla
		$this->db->update('tbl_identificacion', $identificacion);

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se actualiza la identificacion del predio: '.$ficha_predial
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria
	}

	function actualizar_descripcion($ficha_predial, $descripcion)
	{
		$this->db->where('ficha_predial', $ficha_predial);
		//el array asociativo pasado por parametro debe tener sus indices nombrados
		//de la misma forma en que aparecen las columnas de la tabla
		$this->db->update('tbl_descripcion', $descripcion);

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se actualiza la descripcion del predio: '.$ficha_predial
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria
	}

	function actualizar_linderos($ficha_predial, $linderos)
	{
		$datos = array(
			'linderos' => $linderos
		);
		$this->db->where('ficha_predial', $ficha_predial);
		//el array asociativo pasado por parametro debe tener sus indices nombrados
		//de la misma forma en que aparecen las columnas de la tabla
		$this->db->update('tbl_predio_req', $datos);

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se actualizan los linderos del predio: '.$ficha_predial
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria
	}

	function obtener_predios_menu()
	{
		$this->db->order_by("id_predio", "desc");
		$this->db->select('ficha_predial, id_predio');
		$resultado = $this->db->get('tbl_predio', 10, 0)->result();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se consultan los predios que se muestran en el menu de la izquierda'
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}

	function actualizar_predio($ficha_predial, $estado) {
		$this->db->where('ficha_predial', $ficha_predial);
		$this->db->update('tbl_predio', array("requerido" => $estado));
	}

	function actualizar_predio_requerido($ficha_predial, $datos) {
		$this->db->where('ficha_predial', $ficha_predial);
		$this->db->update('tbl_predio_req', $datos);
	}

	function obtener_predio_siguiente($ficha_predial, $palabra_clave) {
		$query = "
			SELECT
				tbl_predio.id_predio, tbl_predio.ficha_predial
			FROM
				tbl_predio,
				tbl_usuarios
			WHERE
				tbl_predio.usuario=tbl_usuarios.id_usuario AND
				(
					tbl_predio.fecha_hora like '%$palabra_clave%' OR
					tbl_predio.ficha_predial like'%$palabra_clave%' OR
					tbl_usuarios.us_nombre like '%$palabra_clave%' OR
					tbl_usuarios.us_apellido like '%$palabra_clave%'
				) AND
				tbl_predio.ficha_predial > '$ficha_predial'
			ORDER BY
				tbl_predio.ficha_predial asc
			LIMIT 1
			OFFSET 0
		";
		return $this->db->query($query)->row();
	}

	function obtener_predio_anterior($ficha_predial, $palabra_clave) {
		$query = "
			SELECT
				tbl_predio.id_predio, tbl_predio.ficha_predial
			FROM
				tbl_predio,
				tbl_usuarios
			WHERE
				tbl_predio.usuario=tbl_usuarios.id_usuario AND
				(
					tbl_predio.fecha_hora like '%$palabra_clave%' OR
					tbl_predio.ficha_predial like'%$palabra_clave%' OR
					tbl_usuarios.us_nombre like '%$palabra_clave%' OR
					tbl_usuarios.us_apellido like '%$palabra_clave%'
				) AND
				tbl_predio.ficha_predial < '$ficha_predial'
			ORDER BY
				tbl_predio.ficha_predial desc
			LIMIT 1
			OFFSET 0
		";
		return $this->db->query($query)->row();
	}



	// recibe la ficha y devuelve un entero con la cantidad de fotos del predio
	function fotos_cantidad($ficha) {
		$this->db->select('COUNT(id) AS fotos_cantidad');
		$this->db->where('ficha_predial', $ficha);
		$this->db->where('tipo', 1);
		$this->db->where('categoria', 2);
	 	return $this->db->get('tbl_archivos')->row();
	}

	// recibe la ficha y devuelve un entero con la cantidad de archivos del predio
	function archivos_cantidad($ficha) {
		$ruta_archivos = "files/";
		//se inicializa la cantidad de archivos
		$archivos = 0;

		if( ! is_dir($ruta_archivos.$ficha) )
		{
			@mkdir($ruta_archivos.$ficha, 0777);
		}

		//se abre el directorio
		if($directorio = opendir($ruta_archivos.$ficha))
		{

			while(($file = readdir($directorio)) !== FALSE)
			{
				if($file != '.' && $file != '..' && $file != 'fotos' && strpos($file, 'SUPERADO') == FALSE)
				{
					$archivos += 1;
				}
			}
		}
		return $archivos;
	}
}
/* End of file prediosdao.php */
/* Location: ./site_predios/application/models/prediosdao.php */
