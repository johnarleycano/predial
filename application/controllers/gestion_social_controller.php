<?php
// error_reporting(-1);

/**
 * Clase encargada de controlar las actualizaciones de las fichas prediales
 * @author John Arley Cano Salinas
 * @copyright 2016
 */
class Gestion_social_controller extends CI_Controller {
	/**
	 * Constructor del controlador
	 */
	function __construct() {
		//se hereda el constructor de CI_Controller
		parent::__construct();

		//si el usuario no esta logueado
		if($this->session->userdata('id_usuario') != TRUE) {
			//redirecciono al controlador de sesion
			redirect('sesion_controller');
		}

		// //se obtienen los permisos del usuario
		// $permisos = $this->session->userdata('permisos');
		// if( ! isset($permisos['Fichas']['Consultar']) ) {
		// 	//si no tiene permiso de consultar las fichas
		// 	$this->session->set_flashdata('error', 'Usted no cuenta con permisos para consultar el m&oacute;dulo de Gesti&oacute;n de Fichas Prediales.');
		// 	//se redirige al controlador principal
		// 	redirect('');
		// }
		$this->load->model(array('PrediosDAO', 'Gestion_socialDAO'));

		//se establece la vista que tiene el contenido del menu
		$this->data['menu'] = 'gestion_social/menu';
	}

	/**
	 * Pagina principal del módulo
	 */
	function index() {
		$this->data['titulo_pagina'] = 			'Gestión social';
		$this->data['contenido_principal'] = 	'gestion_social/index';
		//se carga la vista y se envia el array asociativo
		$this->load->view('includes/template', $this->data);
	}

	function actualizar_ficha(){
    	echo $this->Gestion_socialDAO->actualizar_ficha($this->input->post('ficha'), $this->input->post('datos'));
	}

	function actualizar_diagnostico(){
		$datos = $this->input->post('datos');

		if($this->input->post('tipo') == '0'){
			echo $this->Gestion_socialDAO->actualizar_diagnostico($this->input->post('ficha'), $datos);
		} else {
			echo $this->Gestion_socialDAO->actualizar_diagnostico($this->input->post('ficha'), $datos, $this->input->post('tipo'), $this->input->post('id'));
		}
	}

	function actualizar_usp(){
    	echo $this->Gestion_socialDAO->actualizar_usp($this->input->post('id'), $this->input->post('datos'));
	}

	function actualizar_usr(){
    	if($this->Gestion_socialDAO->actualizar_usr($this->input->post('id'), $this->input->post('datos'))){
    		echo $this->input->post('id');
    	}
	}

	function cargar_ficha(){
		echo count($this->Gestion_socialDAO->cargar_ficha($this->input->post('ficha')));
	}

	function cargar_diagnostico(){
		if ($this->input->post('tipo') == "0"){
			print json_encode($this->Gestion_socialDAO->cargar_diagnostico($this->input->post('ficha')));
		} else {
			print json_encode($this->Gestion_socialDAO->cargar_diagnostico($this->input->post('ficha'), $this->input->post('tipo'), $this->input->post('id')));
		}
	}

	function cargar_fichas(){
		$this->data['fichas'] = $this->PrediosDAO->obtener_fichas(1);

        // Se carga la vista
        $this->load->view('gestion_social/listar', $this->data);
	}

	function cargar_fichas_semaforo(){
		print json_encode($this->PrediosDAO->obtener_predios_semaforo($this->input->post("unidad_funcional")));
	}

	function cargar_unidades_sociales_residentes(){
		$this->data['unidades_sociales_residentes'] = $this->Gestion_socialDAO->cargar_unidades_sociales_residentes();

        // Se carga la vista
        $this->load->view('gestion_social/unidades_sociales_residentes/listar', $this->data);
	}

	function cargar_unidad_social_productiva(){
		print json_encode($this->Gestion_socialDAO->cargar_unidad_social_productiva($this->input->post("id")));
	}

	function cargar_unidad_social_residente(){
		print json_encode($this->Gestion_socialDAO->cargar_unidad_social_residente($this->input->post("id")));
	}

	function cargar_unidades_sociales_productivas(){
		$this->data['unidades_sociales_productivas'] = $this->Gestion_socialDAO->cargar_unidades_sociales_productivas();

        // Se carga la vista
        $this->load->view('gestion_social/unidades_sociales_productivas/listar', $this->data);
	}

	function diagnostico_social()
	{
		$ficha = $this->input->post('ficha');
		$tipo = $this->input->post('tipo');
		$id = $this->input->post('id');

		$this->data['ficha'] = $ficha;
		$this->data['tipo'] = ($tipo) ? $tipo : 0;
		$this->data['id'] = ($id) ? $id : 0;
		
		$this->data['diagnostico'] = $this->Gestion_socialDAO->cargar_diagnostico($ficha, $tipo, $id);
		$this->load->view('gestion_social/diagnostico_socioeconomico_view', $this->data);
	}

	function ficha(){
		// // Se recibe por post la variable que define si es un registro nuevo o editado
    	$this->data["ficha"] = $this->uri->segment(4);
		$this->data['predio'] = $this->PrediosDAO->obtener_predio($this->uri->segment(3));
		$this->data['ficha_social'] = $this->Gestion_socialDAO->cargar_ficha($this->uri->segment(4));
		$this->data['valores_fichas'] = $this->Gestion_socialDAO->cargar_valores_ficha_social($this->uri->segment(4), 0);
		// $this->data['fichas'] = $this->PrediosDAO->obtener_fichas();

        // Se carga la vista
        $this->load->view('gestion_social/ficha', $this->data);
	}

	function ficha_social_residente(){
		$this->data['id'] = $this->uri->segment(3);
		if ($this->uri->segment(3) > 0) {
			$this->data['usr'] = $this->Gestion_socialDAO->cargar_unidad_social_residente($this->uri->segment(3));
		} else {
			$this->data['usr'] = null;
		}

        // Se carga la vista
        $this->load->view('gestion_social/unidades_sociales_residentes/ficha', $this->data);
	}

	function ficha_social_productiva(){
		$this->data['id'] = $this->uri->segment(3);
		$this->data['valores_fichas'] = $this->Gestion_socialDAO->cargar_valores_ficha_social($this->uri->segment(4), $this->uri->segment(3));


		if ($this->uri->segment(3) != "0") {
			$this->data['usp'] = $this->Gestion_socialDAO->cargar_unidad_social_productiva($this->uri->segment(3));
		} else {
			$this->data['usp'] = null;
		}

        // Se carga la vista
        $this->load->view('gestion_social/unidades_sociales_productivas/ficha', $this->data);
	}

	function insertar_ficha(){
		echo $this->Gestion_socialDAO->insertar_ficha($this->input->post('datos'));
	}

	function insertar_diagnostico(){
		echo $this->Gestion_socialDAO->insertar_diagnostico($this->input->post('datos'));
	}

	function insertar_usp(){
		echo $this->Gestion_socialDAO->insertar_usp($this->input->post('datos'));
	}

	function insertar_usr(){
		echo $this->Gestion_socialDAO->insertar_usr($this->input->post('datos'));
	}

	function insertar_valores_ficha(){
		// Si trae id de ficha social
		if ($this->input->post('id_unidad_social') > 0) {
			$datos = array("id_unidad_social" => $this->input->post('id_unidad_social'));
			$ficha = 0;
			// echo "borrará fichas sociales";
		} else {
			$datos = array("ficha_predial" => $this->input->post('ficha'));
			$ficha = $this->input->post('ficha');
			// echo "borrará predios";
		} // if

		// Primero, se borran los valores para esa ficha
		echo $this->Gestion_socialDAO->eliminar_valores_ficha($datos);

		// Si hay valores seleccionados
		if ($this->input->post("datos")) {
			// Se recorren
			foreach ($this->input->post("datos") as $dato) {
				// Arreglo que irá a base de datos
                $arreglo = array(
                    "ficha_predial" => $ficha,
                    "id_valor_social" => $dato,
                    "id_unidad_social" => $this->input->post('id_unidad_social')
                );

                //Se ejecuta el modelo que crea el permiso
               	$this->Gestion_socialDAO->insertar_valor_ficha($arreglo);
			}
		}
	}

	function unidades_sociales_residentes(){
		$this->data['menu'] = 'gestion_social/unidades_sociales_residentes/menu';
		$this->data['titulo_pagina'] = 'Unidades sociales residentes';
		$this->data['contenido_principal'] = 	'gestion_social/unidades_sociales_residentes/index';
		//se carga la vista y se envia el array asociativo
		$this->load->view('includes/template', $this->data);
	}

	function unidades_sociales_productivas(){
		$this->data['menu'] = 'gestion_social/unidades_sociales_productivas/menu';
		$this->data['titulo_pagina'] = 'Unidades sociales productivas';
		$this->data['contenido_principal'] = 	'gestion_social/unidades_sociales_productivas/index';
		//se carga la vista y se envia el array asociativo
		$this->load->view('includes/template', $this->data);
	}
}
/* End of file gestion_social_controller.php */
/* Location: ./site_predios/application/controllers/gestion_social_controller.php */
