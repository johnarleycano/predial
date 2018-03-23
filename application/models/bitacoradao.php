<?php
/**
 * DAO que se encarga de gestionar la bitacora
 * @author 		Freddy Alexander Vivas Reyes
 * @copyright	&copy; HATOVIAL S.A.S.
 */
class BitacoraDAO extends CI_Model
{
	/**
	 * Retorna los datos que hay en la bitacora asociados a una ficha predial especifica.
	 *
	 * @access	public
	 * @param	string	la ficha predial.
	 * @return	los datos del usuario.
	 * @return	FALSE en caso contrario.
	 */
	function obtener_bitacora($ficha_predial)
	{
		//clausula WHERE del sql
		$this->db->where('ficha_predial', $ficha_predial);
		//retorno los datos de la consulta
		$resultado = $this->db->get('tbl_bitacora')->result();

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Consulta la bitacora correspondiente a la ficha: '.$ficha_predial
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}

	function insertar_anotacion($ficha_predial, $fecha, $titulo, $remitente, $radicado, $observacion, $usuario)
	{
		$this->db->set('ficha_predial', $ficha_predial);
		$this->db->set('titulo', $titulo);
		$this->db->set('remitente', $remitente);
		$this->db->set('radicado', $radicado);
		$this->db->set('fecha', $fecha);
		$this->db->set('observacion', $observacion);
		$this->db->set('usuario', $usuario);
		$resultado = $this->db->insert('tbl_bitacora');

		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Inserta un nuevo registro a la bitacora correspondiente a la ficha: '.$ficha_predial
		);
		$this->db->insert('auditoria', $auditoria);
		#fin accion de auditoria

		return $resultado;
	}

	function eliminar_anotacion($id_bitacora) {
		$this->db->where('id_bitacora', $id_bitacora);
		return $this->db->delete('tbl_bitacora');
	}

	function editar_anotacion($id_bitacora, $data) {
		$this->db->where('id_bitacora', $id_bitacora);
		return $this->db->update('tbl_bitacora', $data);
	}

	function obtener_bitacoras() {
		return $this->db->get('tbl_bitacora')->result();
	}
}
/* End of file bitacoradao.php */
/* Location: ./site_predios/application/models/bitacoradao.php */
