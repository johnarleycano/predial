<?php
	// error_reporting(E_ALL);
class Bitacora_controller extends CI_Controller
{
	var $data = array();
	function __construct()
	{
		parent::__construct();
		//si el usuario no esta logueado
		if($this->session->userdata('id_usuario') != TRUE)
		{
			//redirecciono al controlador de sesion
			redirect('sesion_controller');
		}
		$permisos = $this->session->userdata('permisos');
		if ( ! isset($permisos['Bit&aacute;cora']['Consultar']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para consultar la Bit&aacute;cora.');
			redirect('');
		}
		//se establece la vista que tiene el contenido del menu
		$this->data['menu'] = 'bitacora/menu';
	}

	function index()
	{
		$this->load->model('PrediosDAO');
		$this->data['titulo_pagina'] = 'Bit&aacute;cora';
		$this->data['contenido_principal'] = 'bitacora/index_view';
		$this->load->view('includes/template', $this->data);
	}

	function ftp()
	{
		echo "http://orfeoweb.hatovial.com/orfeo384/buscar_radicado_predios.php";
	}

	function lista_fichas() {
		$this->load->model('PrediosDAO');

		$palabra_clave = $this->input->get('palabraClave');
		$max_filas = $this->input->get('maxRows');
		echo json_encode($this->PrediosDAO->listar_fichas($palabra_clave, $max_filas));
	}

	function nueva_entrada()
	{
		$ficha = $this->input->post('ficha');
		$fecha = $this->input->post('fecha');
		$remitente = $this->input->post('remitente');
		$radicado = $this->input->post('radicado');
		$titulo = $this->input->post('titulo');
		$observacion = $this->input->post('observacion');
		$usuario = $this->session->userdata('id_usuario');

		$this->load->model('BitacoraDAO');

		if($this->BitacoraDAO->insertar_anotacion($ficha, $fecha, $titulo, $remitente, $radicado, $observacion, $usuario))
		{
			echo "correcto";
		}
		else {
			echo "Ocurri&oacute; un error al intentar guardar la anotaci&oacute;n, por favor intente nuevamente.";
		}
	}

	function orfeo(){
		error_reporting(E_ALL);
		ini_set('display_errors', 1);

		/*$user = "user_devimed";
		$password = ".fl0r3s.";
		$dbname = "orfeo_db";
		$port = 5432;
		$host = "192.168.0.14";

		$cadenaConexion = "host=$host port=$port dbname=$dbname user=$user password=$password";

		$conexion = pg_connect($cadenaConexion) or die("Error en la Conexión: ".pg_last_error());
		echo "<h3>Conexion Exitosa PHP - PostgreSQL</h3><hr><br>";*/
		$this->db_orfeo = $this->load->database('orfeo', TRUE);
		$resultados = $this->bitacoraDAO->obtener_verificacion("2015");
		print_r($resultados);
		
	}

	function obtener_bitacora()
	{
		//obtengo la ficha predial
		$ficha_predial = $this->uri->segment(3);

		$modo = 'url';

		//si no se paso por la url entonces retorna error
		if( ! $ficha_predial )
		{
			$ficha_predial = $this->input->post('ficha');
			$modo = 'post';
		}

		if( ! $ficha_predial )
		{
			echo "Error al enviar la ficha predial, intente nuevamente.";
		}
		else
		{
			if($modo == 'post')
			{
				$this->load->model('BitacoraDAO');
				echo 'correcto|'.$this->obtener_tabla($this->BitacoraDAO->obtener_bitacora($ficha_predial));
			}
			else
			{
				$this->load->model('PropietariosDAO');
				$ficha_predial = str_replace('%20', ' ', $ficha_predial);

				//si se paso por url entonces se carga el modelo que gestiona la informacion de la bitacora
				// $this->load->model('BitacoraDAO');

				//se pasa la ficha predial
				$this->data['ficha_predial'] = $ficha_predial;

				//se pasa el primer propietario
				$this->data['propietario'] = $this->PropietariosDAO->obtener_primer_propietario($ficha_predial);

				//se pasa toda la bitacora asociada a la ficha predial
				// $this->data['bitacora'] = $this->obtener_tabla($this->BitacoraDAO->obtener_bitacora($ficha_predial));

				//se establece el titulo de la pagina
				$this->data['titulo_pagina'] = 'Bit&aacute;cora de la ficha predial';

				//se carga el template
				$this->load->view('bitacora/bitacora_view', $this->data);
			}
		}
	}

	function obtener_tabla($bitacora)
	{
		$this->load->model('BitacoraDAO');
		
		$permisos = $this->session->userdata('permisos');

		$fila = 0;
		
		$respuesta = "<table width='100%' id='tabla'>";
			$respuesta .= "<thead>";
				$respuesta .= "<th>Fecha</th>";
				$respuesta .= "<th>Remitente</th>";
				$respuesta .= "<th>Título</th>";
				$respuesta .= "<th>Observación</th>";
				$respuesta .= "<th>Radicado</th>";
				$respuesta .= "<th></th>";
			$respuesta .= "</thead>";

			$respuesta .= "<tbody>";
				foreach ($bitacora as $anotacion){
					// $verificacion = ($anotacion->radicado != "") ? $this->BitacoraDAO->obtener_verificacion($anotacion->radicado)->codigo : "" ;
					// $archivo = "http://orfeo.devimed.com.co/orfeo/externalFileController.php?nurad=$anotacion->radicado&radiveri=$verificacion";
					$verificacion = "#";

					$respuesta .= "<tr class='";
					$respuesta .= ($fila % 2 == 0) ? "odd'>" : "even'>" ;
						$respuesta .= "<td class='sorting_1' width='90px'>$anotacion->fecha</td>";
						$respuesta .= "<td>$anotacion->remitente</td>";
						$respuesta .= "<td>$anotacion->titulo</td>";
						$respuesta .= "<td>$anotacion->observacion</td>";
						$respuesta .= "<td><a href='$archivo' target='_blank'>$anotacion->radicado</a></td>";
						$respuesta .= "<td width='90px'>";
							if(isset($permisos['Bit&aacute;cora']['Editar anotaciones'])) {
								$respuesta.= '<a title="Editar" href="'.site_url('bitacora_controller/editar_anotacion').'" rel="Editar" id="'.$anotacion->id_bitacora.'"><img src="'.base_url().'img/edit.png"></a>';
							}
							if(isset($permisos['Bit&aacute;cora']['Eliminar anotaciones'])) {
								$respuesta.= '<a title="Eliminar" href="'.site_url('bitacora_controller/eliminar_anotacion').'" rel="Editar" id="'.$anotacion->id_bitacora.'"><img src="'.base_url().'img/delete.png"></a>';
							}
						$respuesta .= "</td>";
					$respuesta .= "</tr>";

					$fila++;
				}
			$respuesta .= "</tbody>";
		$respuesta .= "</table>";

		return $respuesta;
	}

	function valida_ficha()
	{
		$ficha_predial = $this->input->post('ficha');
		echo $ficha_predial;
		$this->load->model('PrediosDAO');
		if($this->PrediosDAO->existe_ficha($ficha_predial))
		{
			echo 'correcto';
		}
		else
		{
			echo 'La ficha predial ingresada no existe.';
		}
	}

	function eliminar_anotacion() {
		$json['mensaje'] = 'correcto';
		$id_bitacora = $this->input->post('id_bitacora');
		if( ! $id_bitacora ) {
			$json['mensaje'] = 'Error al intentar eliminar la anotaci&oacute;n de la bit&aacute;cora. Refresque la p&aacute;gina e intente nuevamente.';
		}
		else {
			$this->load->model('BitacoraDAO');
			if( ! $this->BitacoraDAO->eliminar_anotacion($id_bitacora) ) {
				$json['mensaje'] = 'Error al intentar eliminar la anotaci&oacute;n de la bit&aacute;cora. Refresque la p&aacute;gina e intente nuevamente.';
			}
		}
		echo json_encode($json);
	}

	function editar_anotacion() {
		$json['mensaje'] = 'correcto';
		$id_bitacora = $this->input->post('id_bitacora');
		if( ! $id_bitacora ) {
			$json['mensaje'] = 'Error al intentar editar la anotaci&oacute;n seleccionada. Refresque la p&aacute;gina e intente nuevamente.';
		}
		else {
			$this->load->model('BitacoraDAO');
			$anotacion['titulo'] = $this->input->post('titulo');
			$anotacion['remitente'] = $this->input->post('remitente');
			$anotacion['radicado'] = $this->input->post('radicado');
			$anotacion['fecha'] = $this->input->post('fecha');
			$anotacion['observacion'] = $this->input->post('observacion');
			if( ! $this->BitacoraDAO->editar_anotacion($id_bitacora, $anotacion) ) {
				$json['mensaje'] = 'Error al intentar editar la anotaci&oacute;n de la bit&aacute;cora. Refresque la p&aacute;gina e intente nuevamente.';
			}
		}
		echo json_encode($json);
	}

	/*
	* Esta funcion corrige problemas de doble codificacion en la base de datos
	*/
	function correccion() {
		$this->load->model('BitacoraDAO');
		$bitacoras = $this->BitacoraDAO->obtener_bitacoras();
		foreach ($bitacoras as $bitacora) {
			$anotacion['observacion'] = utf8_decode($bitacora->observacion);
			$anotacion['titulo'] = utf8_decode($bitacora->titulo);
			$anotacion['remitente'] = utf8_decode($bitacora->remitente);
			$anotacion['usuario'] = utf8_decode($bitacora->usuario);
			$this->BitacoraDAO->editar_anotacion($bitacora->id_bitacora, $anotacion);
		}
	}
}

/* End of file bitacora_controller.php */
/* Location: ./predios1/application/controllers/bitacora_controller.php */
