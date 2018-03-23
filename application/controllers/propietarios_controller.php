<?php
class Propietarios_controller extends CI_Controller
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
		if( ! isset($permisos['Fichas']['Consultar']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para actualizar el m&oacute;dulo de Gesti&oacute;n de Propietarios.');
			redirect('');
		}
		//se establece la vista que tiene el contenido del menu
		$this->data['menu'] = 'propietarios/menu';
		$this->load->model('PropietariosDAO');
	}

	function index()
	{
		$this->data['propietarios'] = $this->PropietariosDAO->obtener_todos_los_propietarios();
		$this->data['titulo_pagina'] = 'Gesti&oacute;n de propietarios';
		$this->data['contenido_principal'] = 'propietarios/index_view';
		$this->load->view('includes/template',$this->data);
	}

	function propietario()
	{
		$this->data['propietario'] = $this->PropietariosDAO->obtener_propietario($this->input->post('id'));
		$this->data['relaciones'] = $this->PropietariosDAO->obtener_relaciones($this->input->post('id'));
		$this->data['titulo_pagina'] = 'Gesti&oacute;n de propietarios';
		$this->data['contenido_principal'] = 'propietarios/detalle';
		$this->load->view('includes/template',$this->data);
	}
}
