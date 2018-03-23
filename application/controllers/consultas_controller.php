<?php
class Consultas_controller extends CI_Controller
{
	var $data = array();

	function __construct()
	{
		parent::__construct();
		//se establece la vista que tiene el contenido del menu
		$this->data['menu'] = 'consultas/menu';
	}

	function propietario() {
		$permisos = $this->session->userdata('permisos');
		if( ! isset($permisos['Fichas']['Consultar']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para consultar el m&oacute;dulo de Gesti&oacute;n de Propietarios.');
			redirect('');
		}
		$id_propietario = $this->uri->segment(3);
		if ( ! $id_propietario) {
			redirect('propietarios_controller');
		}
		else
		{
			$this->load->model('PropietariosDAO');
			$this->data['propietario'] = $this->PropietariosDAO->obtener_propietario($id_propietario);
			$this->data['relaciones'] = $this->PropietariosDAO->obtener_relaciones($id_propietario);
			$this->data['titulo_pagina'] = 'Actualizaci&oacute;n de propietarios';
			$this->data['contenido_principal'] = 'consultas/propietario_view';
			$this->load->view('includes/template', $this->data);
		}
	}

	function guarda_palabra_clave() {
		$palabra_clave = $this->input->post('palabra_clave');
		$this->session->set_userdata('palabra_clave', $palabra_clave);
		echo 'correcto';
	}
}
