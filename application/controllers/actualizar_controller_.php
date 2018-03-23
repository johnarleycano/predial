<?php
// error_reporting(-1);
/**
 * Clase encargada de controlar las actualizaciones de las fichas prediales
 * @author Freddy Alexander Vivas Reyes
 * @copyright 2012
 */
class Actualizar_controller extends CI_Controller {
	/**
	 * Array que se encarga de enviar las variables a las vistas
	 * @var Array asociativo
	 */
	var $data = array();
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
		//se obtienen los permisos del usuario
		$permisos = $this->session->userdata('permisos');
		if( ! isset($permisos['Fichas']['Consultar']) ) {
			//si no tiene permiso de consultar las fichas
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para consultar el m&oacute;dulo de Gesti&oacute;n de Fichas Prediales.');
			//se redirige al controlador principal
			redirect('');
		}

		//se establece la vista que tiene el contenido del menu
		$this->data['menu'] = 'actualizar/menu';

		// Carga de modelos
		$this->load->model(array('ProcesosDAO', 'TramosDAO', 'ContratistasDAO', 'PrediosDAO', 'PropietariosDAO'));
	}
	/**
	 * Pagina principal del modulo
	 */
	function index() {
		//se carga el modelo que gestiona las consultas del modulo de Predios y del modulo de Contratistas
		$this->load->model(array('PrediosDAO', 'ContratistasDAO', 'AccionesDAO'));
		//se arma el array asociativo que se envia a la vista
		$this->data['fichas'] = 				$this->PrediosDAO->obtener_fichas();
		$this->data['contratistas'] =			$this->ContratistasDAO->obtener_contratistas();
		$this->data['titulo_pagina'] = 			'Actualizar';
		$this->data['contenido_principal'] = 	'actualizar/index_view';
		//se carga la vista y se envia el array asociativo
		$this->load->view('includes/template', $this->data);
	}

	/**
     * Actualización de registros en base de datos
     */
    function actualizar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Se reciben los datos por POST
            $datos = $this->input->post('datos');
            $tipo = $this->input->post('tipo');

            // Dependiendo del tipo
            switch ($tipo) {
                // Cultivos
                case 'cultivo':
                    //Se ejecuta el modelo que actualiza los datos
                    echo $this->PrediosDAO->editar_cultivo_especies($this->input->post('id'), $datos);
                break; // Cultivos
				// Construccion
				case 'construccion':
                    //Se ejecuta el modelo que actualiza los datos
                    echo $this->PrediosDAO->editar_construccion($this->input->post('id'), $datos);
                break; // Construccion
            } // switch
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // actualizar

    /**
     * Creación de registros en base de datos
     */
    function crear(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Se reciben los datos por POST
            $datos = $this->input->post('datos');
            $tipo = $this->input->post('tipo');

            // Dependiendo del tipo
            switch ($tipo) {
                // Cultivo
                case 'cultivo':
                    // Se crea el registro
                    echo $this->PrediosDAO->insertar_cultivo_especie($datos);
                break; // Cultivo
				// Construccion
                case 'construccion':
                    // Se crea el registro
                    echo $this->PrediosDAO->insertar_construccion($datos);
                break; // Construccion
            } // Switch tipo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } // if
    } // crear

	/**
	 * Eliminación de registros en base de datos
	 */
	function eliminar(){
		//Se valida que la peticion venga mediante ajax y no mediante el navegador
		if($this->input->is_ajax_request()){
			// Se reciben los datos por POST
			$datos = $this->input->post('datos');
			$tipo = $this->input->post('tipo');

			// Dependiendo del tipo
			switch ($tipo) {
				// Cultivo
				case 'cultivo':
					// Se elimina el registro
					echo $this->PrediosDAO->eliminar_cultivos_especies($datos);
				break; // Cultivo
				// Construccion
				case 'construccion':
					// Se elimina el registro
					echo $this->PrediosDAO->eliminar_construccion($datos);
				break; // Construccion

			} // Switch tipo
		}else{
			//Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
			redirect('');
		} // if
	} // eliminar

	function cultivos(){
		//se carga el modelo que gestiona las consultas del modulo de Predios y del modulo de Contratistas
		// $this->load->model(array('PrediosDAO', 'ContratistasDAO', 'AccionesDAO'));

		$this->data['titulo_pagina'] = 			'Cultivos de ficha ';
		$this->data['contenido_principal'] = 	'actualizar/cultivos/index_view';
		$this->data['menu'] = 'actualizar/menu_ficha';
		//se carga la vista y se envia el array asociativo
		$this->load->view('includes/template', $this->data);

	}

	/**
	 * Muestra la informaci�n de la ficha seleccionada
	 */
	function ficha()
	{
		//se cargan los permisos
		$permisos = $this->session->userdata('permisos');
		if( ! isset($permisos['Fichas']['Actualizar']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para actualizar el m&oacute;dulo de Gesti&oacute;n de Fichas Prediales.');
			redirect('');
		}
		//se obtiene el segmento de la uri correspondiente a la id del predio
		$id_predio = $this->uri->segment(3);
		if( $id_predio )
		{
			//se carga el modelo ProcesosDAO
			$this->load->model(array('ProcesosDAO', 'TramosDAO', 'ContratistasDAO', 'PrediosDAO', 'PropietariosDAO'));
			//se asignan los valores que se van a enviar a la vista
			//se establece la vista que tiene el contenido del menu
			$this->data['id_predio'] = $id_predio;
			$this->data['predio'] =	$this->PrediosDAO->obtener_predio($id_predio);
			$this->data['titulo_pagina'] = 			'Actualizar ficha '.$this->data['predio']->ficha_predial;
			$this->data['menu'] = 'actualizar/menu_ficha';
			$this->data['contenido_principal'] = 	'actualizar/index';
			//se carga la vista y se envian los datos
			$this->load->view('includes/template', $this->data);
		}
		else
		{
			//si no se selecciono una ficha predial se retorna al index
			redirect('actualizar_controller');
		}
	}

	function ficha_(){
		//se cargan los permisos
		$permisos = $this->session->userdata('permisos');
		if( ! isset($permisos['Fichas']['Actualizar']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para actualizar el m&oacute;dulo de Gesti&oacute;n de Fichas Prediales.');
			redirect('');
		}

		//se obtiene el segmento de la uri correspondiente a la id del predio
		$id_predio = $this->uri->segment(3);
		if( $id_predio )
		{
			//se carga el modelo ProcesosDAO
			$this->data['predio'] = $this->PrediosDAO->obtener_predio($id_predio);
			$this->data['menu'] = 'actualizar/menu_ficha';
			$this->data['contenido_principal'] = 	'actualizar/index';
			//se carga la vista y se envian los datos
			$this->load->view('includes/template', $this->data);
		}
		else
		{
			//si no se selecciono una ficha predial se retorna al index
			redirect('actualizar_controller');
		}
	}

	function cargar_interfaz(){
		//Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Dependiendo del tipo
            switch ($this->input->post('tipo')) {
                // Gestión de ficha predial
                case 'ficha_gestion':
					//se obtiene el segmento de la uri correspondiente a la id del predio
					$id_predio = $this->input->post('id');

					if( $id_predio )
					{
						//se asignan los valores que se van a enviar a la vista
						$this->data['funciones_predios_obra'] =	$this->PrediosDAO->obtener_funciones_predios_obra();
						$this->data['estados_via'] =			$this->PrediosDAO->obtener_estados_via();
						$this->data['estados'] = 				$this->ProcesosDAO->obtener_estados_proceso();
						$this->data['tramos'] = 				$this->TramosDAO->obtener_tramos();
						$this->data['contratistas'] = 			$this->ContratistasDAO->obtener_contratistas();
						$this->data['predio'] = 				$this->PrediosDAO->obtener_predio($id_predio);
						$this->data['identificacion'] = 		$this->PrediosDAO->obtener_identificacion($this->data['predio']->ficha_predial);
						$this->data['descripcion'] = 			$this->PrediosDAO->obtener_descripcion($this->data['predio']->ficha_predial);
						$this->data['linderos'] = 				$this->PrediosDAO->obtener_linderos($this->data['predio']->ficha_predial);
						$this->data['propietarios'] = 			$this->PropietariosDAO->obtener_propietarios($this->data['predio']->ficha_predial);
						$this->data['titulos_adquisicion'] = 	$this->PrediosDAO->obtener_titulos_adquisicion();
						$this->data['titulo_pagina'] = 			'Actualizar ficha '.$this->data['predio']->ficha_predial;
					} else
					{
						//si no se selecciono una ficha predial se retorna al index
						redirect('actualizar_controller');
					}

                    // Se carga la vista
					$this->load->view('actualizar/actualizar_view', $this->data);
                break; // Gestión de ficha predial

                // Cultivos de ficha predial
                case 'ficha_cultivos':
                	// Se toman valores que vienen por post
                    $this->data['ficha'] = $this->input->post('ficha');

                    // Se carga la vista
                    $this->load->view('actualizar/cultivos/index', $this->data);
                break; // Cultivos de ficha predial

                // Gestión de cultivos de ficha predial
                case 'ficha_cultivos_gestion':
					// Se toman valores que vienen por post
                    $this->data['id'] = $this->input->post('id');

     //            	// Se toman valores que vienen por post
     //                $this->data['ficha'] = $this->input->post('ficha');

     //                // Se carga la vista
                    $this->load->view('actualizar/cultivos/gestion', $this->data);
                break; // Gestión de cultivos de ficha predial

                // Listado de cultivos de ficha predial
                case 'ficha_cultivos_lista':
					//se carga el modelo ProcesosDAO
					// $this->data['predio'] = $this->PrediosDAO->obtener_predio($id_predio);

                	// Se toman valores que vienen por post
                    $this->data['ficha'] = $this->input->post('ficha');

                    // Se carga la vista
                    $this->load->view('actualizar/cultivos/listar', $this->data);
                break; // Listado de cultivos de ficha predial

				// Gestión de construcciones de ficha predial
				case 'ficha_construcciones_gestion':
					// Se toman valores que vienen por post
					$this->data['subcategoria'] = $this->input->post('subcategoria');
					$this->data['id'] = $this->input->post('id');
					// Se carga la vista
					$this->load->view('actualizar/construcciones/gestion', $this->data);
				break; // Gestión de cultivos de ficha predial

				// Construcciones de ficha predial
				case 'ficha_construcciones':
					// Se toman valores que vienen por post
					$this->data['ficha'] = $this->input->post('ficha');
					$this->data['subcategoria'] = $this->input->post('subcategoria');
					// Se carga la vista
					$this->load->view('actualizar/construcciones/index', $this->data);
				break; // Construcciones de ficha predial
				// Listado de construcciones de ficha predial
				case 'ficha_construcciones_lista':
					// Se toman valores que vienen por post
					$this->data['ficha'] = $this->input->post('ficha');
					$this->data['subcategoria'] = $this->input->post('subcategoria');
					// Se carga la vista
					$this->load->view('actualizar/construcciones/listar', $this->data);
				break; // Listado de construcciones de ficha predial
            } // suiche
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    } // cargar_interfaz

	/**
	 * Esta funcion retorna las fichas asociadas a un contratista via JSON
	 */
	function fichas_contratista() {
		//se carga el modelo asociado a los predios
		$this->load->model('PrediosDAO');
		//se obtiene el contratista enviado via POST
		$contratista = $this->input->post('contratista');
		//se obtienen las fichas asociadas al contratista
		$fichas = $this->PrediosDAO->obtener_predios_contratista($contratista);
		//se crea un array
		$resultado = array();
		//se llena el array
		foreach ($fichas as $ficha):
			$array = array();
			$array['predio'] = $ficha->id_predio;
			$array['fecha'] = $ficha->fecha_hora;
			$array['ficha'] = $ficha->ficha_predial;
			$array['propietario'] = $ficha->propietario;
			$array['usuario'] = $ficha->us_nombre.' '.$ficha->us_apellido;
			array_push($resultado, $array);
		endforeach;
		//se envia el resultado via JSON
		echo json_encode($resultado);
	}
	/**
	 * Esta funcion se encarga de guardar la informaci�n de una ficha predial luego de que esta haya sido modificada desde la vista
	 */
	function actualizar_predio()
	{
		//se cargan los permisos del usuario
		$permisos = $this->session->userdata('permisos');
		if( ! isset($permisos['Fichas']['Actualizar']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para actualizar el m&oacute;dulo de Gesti&oacute;n de Fichas Prediales.');
			redirect('');
		}

		//se lee la ficha predial
		$ficha_predial = $this->input->post('ficha');

		//se carga el modelo PrediosDAO
		$this->load->model('PrediosDAO');

		//se actualiza el predio si está o no requerido
		$this->PrediosDAO->actualizar_predio($ficha_predial, $this->input->post('requerido'));

		//se prepara la identificacion del predio
		$identificacion = array(
			'barrio' => 			utf8_encode($this->input->post('vereda_barrio')),
			'conc_titu' => 			utf8_encode($this->input->post('concepto')),
			'ciudad' => 			utf8_encode($this->input->post('ciudad_predio_inicial')),
			'ciudad_f' => 			utf8_encode($this->input->post('ciudad_predio_final')),
			'direccion' => 			utf8_encode($this->input->post('direccion_nombre')),
			'doc_estud' => 			utf8_encode($this->input->post('documentos_estudiados')),
			'enc_gestion' => 		utf8_encode($this->input->post('encargado_gestion_predial')),
			'entregado' => 			utf8_encode($this->input->post('entregado')),
			'env_esc_not' => 		utf8_encode($this->input->post('envio_escritura_notaria')),
			'escritura_orig' => 	utf8_encode($this->input->post('numero_escritura')),
			'estado_predio' => 		utf8_encode($this->input->post('estado_predio')),
			'estado_pro' => 		utf8_encode($this->input->post('estado_proceso')),
			'f_apro_def' => 		utf8_encode($this->input->post('aprobacion_definitiva_plano')),
			'f_aprob_soc' => 		utf8_encode($this->input->post('f_aprob_soc')),
			'f_aprob_tit' => 		utf8_encode($this->input->post('f_aprob_tit')),
			'f_aprob_ficha' => 		utf8_encode($this->input->post('f_aprob_ficha')),
			'f_ent_plano_int' => 	utf8_encode($this->input->post('entrega_plano_interventoria')),
			'f_envio_av' => 		utf8_encode($this->input->post('envio_avaluador')),
			'f_envio_ger' => 		utf8_encode($this->input->post('envio_gerencia_firmar')),
			'f_envio_int' => 		utf8_encode($this->input->post('f_envio_int')),
			'f_entregado' => 		utf8_encode($this->input->post('fecha_entregado')),
			'f_inicio_trab' => 		utf8_encode($this->input->post('inicio_trabajo_fisico')),
			'f_notificacion_pro' => utf8_encode($this->input->post('notificacion_propietario')),
			'f_recibo_av' => 		utf8_encode($this->input->post('f_recibo_av')),
			'f_recibo_pro' => 		utf8_encode($this->input->post('recibo_notificacion_propietario')),
			'f_rev_ficha' => 		utf8_encode($this->input->post('f_rev_ficha')),
			'f_oferta_c' => 		utf8_encode($this->input->post('f_oferta_c')),
			'f_oferta_notif' => 		utf8_encode($this->input->post('f_oferta_notif')),
			'f_oferta_ac' => 		utf8_encode($this->input->post('f_oferta_ac')),
			'f_permiso_int' => 		utf8_encode($this->input->post('f_permiso_int')),
			'f_firma_prom' => 		utf8_encode($this->input->post('f_firma_prom')),
			'fecha_esc_f' => 		utf8_encode($this->input->post('fecha_predio_final')),
			'fecha_escritura' => 	utf8_encode($this->input->post('fecha_predio_inicial')),
			'fecha_estudio' => 		utf8_encode($this->input->post('fecha_estudio')),
			'gravamenes' => 		utf8_encode($this->input->post('gravamenes_limitaciones')),
			'id_estado_via' => 		utf8_encode($this->input->post('estado_via')),
			'id_funcion_predio' => 	utf8_encode($this->input->post('funcion_predio')),
			'ing_esc' => 			utf8_encode($this->input->post('ingreso_escritura')),
			'ini_juic' => 			utf8_encode($this->input->post('inicio_juicio')),
			'ini_sent' => 			utf8_encode($this->input->post('inicio_sentencia')),
			'ing_sent' => 			utf8_encode($this->input->post('ingreso_sentencia_registro')),
			'lind_titulo' => 		utf8_encode($this->input->post('linderos_segun_titulo')),
			'matricula_orig' => 	utf8_encode($this->input->post('numero_matricula_predio_inicial')),
			'municipio' => 			utf8_encode($this->input->post('municipio')),
			'no_catastral' => 		utf8_encode($this->input->post('numero_catastral_predio_inicial')),
			'no_notaria' => 		utf8_encode($this->input->post('numero_notaria_predio_inicial')),
			'notif' => 				utf8_encode($this->input->post('notificacion')),
			'num_escritura_f' => 	utf8_encode($this->input->post('escritura_sentencia')),
			'num_catastral_f' => 	utf8_encode($this->input->post('numero_catastral_predio_final')),
			'num_matricula_f' => 	utf8_encode($this->input->post('numero_matricula_predio_final')),
			'num_notaria_f' => 		utf8_encode($this->input->post('numero_notaria_predio_final')),
			'ob_titu' => 			utf8_encode($this->input->post('observaciones_estudio_titulos')),
			'of_registro' => 		utf8_encode($this->input->post('oficina_registro_predio_inicial')),
			'of_registro_f' => 		utf8_encode($this->input->post('oficina_registro_predio_final')),
			'r_envio_av' => 		utf8_encode($this->input->post('radicado_envio_avaluador')),
			'r_oferta_c' => 		utf8_encode($this->input->post('r_oferta_c')),
			'r_rec_av' => 			utf8_encode($this->input->post('r_rec_av')),
			'rad_apro_pla' => 		utf8_encode($this->input->post('radicado_aprobacion_plano')),
			'rad_aprob_ficha' => 	utf8_encode($this->input->post('rad_aprob_ficha')),
			'rad_aprob_soc' => 		utf8_encode($this->input->post('rad_aprob_soc')),
			'rad_aprob_tit' => 		utf8_encode($this->input->post('rad_aprob_tit')),
			'rad_ent' => 			utf8_encode($this->input->post('radicado')),
			'rad_env_ger' => 		utf8_encode($this->input->post('radicado_envio_gerencia')),
			'rad_env_int' => 		utf8_encode($this->input->post('rad_env_int')),
			'rad_int' => 			utf8_encode($this->input->post('radicado_entrega_interventoria')),
			'rad_no_pro' => 		utf8_encode($this->input->post('radicado_notificacion_propietario')),
			'rad_rev_ficha' => 		utf8_encode($this->input->post('rad_rev_ficha')),
			'rec_reg_exp' => 		utf8_encode($this->input->post('recibo_registro_expropiacion')),
			'rad_of_notif' => 		utf8_encode($this->input->post('rad_of_notif')),
			'rad_of_ac' => 			utf8_encode($this->input->post('rad_of_ac')),
			'rad_permiso_int' =>	utf8_encode($this->input->post('rad_permiso_int')),
			'rad_firma_prom' => 	utf8_encode($this->input->post('rad_firma_prom')),
			'rec_reg_vol' => 		utf8_encode($this->input->post('recibo_registro_enajenacion')),
			'titulos_adq' => 		utf8_encode($this->input->post('titulos_adquisicion')),
			'total_avaluo' => 		utf8_encode($this->input->post('total_avaluo')),
			'valor_mtr' => 			utf8_encode($this->input->post('valor_metro_cuadrado')),
			'valor_total_mej' => 	utf8_encode($this->input->post('valor_total_mejoras')),
			'valor_total_terr' => 	utf8_encode($this->input->post('valor_total_terreno')),
			'segreg_titu' => 		utf8_encode($this->input->post('segregaciones')),
			'titulo_adquisicion' => utf8_encode($this->input->post('titulo_adquisicion'))
		);

		//se inserta la identificacion del predio
		$this->PrediosDAO->actualizar_identificacion($ficha_predial, $identificacion);

		//se prepara la descripcion
		$descripcion = array(
			'uso_edificacion' => 		utf8_encode($this->input->post('uso_edificacion')),
			'estado_pre' => 			utf8_encode($this->input->post('estado')),
			'uso_terreno' => 			utf8_encode($this->input->post('uso_terreno')),
			'tipo_tenencia' => 			utf8_encode($this->input->post('tipo_tenencia')),
			'topografia' => 			utf8_encode($this->input->post('topografia')),
			'via_acceso' => 			utf8_encode($this->input->post('via_acceso')),
			'serv_publicos' => 			utf8_encode($this->input->post('servicios_publicos')),
			'nacimiento_agua' => 		utf8_encode($this->input->post('nacimiento_agua')),
			'area_total' => 			utf8_encode($this->input->post('area_total')),
			'area_total_catastral' =>	utf8_encode($this->input->post('area_total_catastral')),
			'area_total_registral' =>	utf8_encode($this->input->post('area_total_registral')),
			'area_total_titulos' =>		utf8_encode($this->input->post('area_total_titulos')),
			'area_requerida' => 		utf8_encode($this->input->post('area_requerida')),
			'area_residual' => 			utf8_encode($this->input->post('area_residual')),
			'area_construida' => 		utf8_encode($this->input->post('area_construida')),
			'area_cons_requerida' => 	utf8_encode($this->input->post('area_const_requerida')),
			'abscisa_inicial' => 		utf8_encode($this->input->post('abscisa_inicial')),
			'margen_inicial' => 		utf8_encode($this->input->post('margen_inicial')),
			'abscisa_final' => 			utf8_encode($this->input->post('abscisa_final')),
			'margen_final' => 			utf8_encode($this->input->post('margen_final')),
			'observacion' => 			utf8_encode($this->input->post('observacion')),
			'tramo' => 					utf8_encode($this->input->post('tramo')),
			'numero' => 				utf8_encode($this->input->post('numero_ficha')),
			'estado_ambiental' => 				utf8_encode($this->input->post('estado_ambiental')),
			'meta_contractual' => 				utf8_encode($this->input->post('meta_contractual')),
			'disponibilidad_izquierda' => utf8_encode($this->input->post('disponibilidad_izquierda')),
			'disponibilidad_derecha' => utf8_encode($this->input->post('disponibilidad_derecha'))
		);

		//se inserta la descripcion del predio
		$this->PrediosDAO->actualizar_descripcion($ficha_predial, $descripcion);

		//se insertan los linderos del predio
		// $this->PrediosDAO->actualizar_linderos($ficha_predial, utf8_encode($this->input->post('linderos_predio_requerido')));

		/********************
		**** Formato ANI ****
		*********************/
		// Se recogen los checks
		if($this->input->post('c_licencia') != '1'){$c_licencia = '0';}else{$c_licencia = '1';}
		if($this->input->post('c_reglamento') != '1'){$c_reglamento = '0';}else{$c_reglamento = '1';}
		if($this->input->post('c_levantamiento') != '1'){$c_levantamiento = '0';}else{$c_levantamiento = '1';}
		if($this->input->post('c_informe') != '1'){$c_informe = '0';}else{$c_informe = '1';}
		if($this->input->post('c_adquisicion') != '1'){$c_adquisicion = '0';}else{$c_adquisicion = '1';}

		// Información de los linderos
		$linderos = array(
			'ficha_predial' => $ficha_predial,
			'linderos' => utf8_encode($this->input->post('linderos_predio_requerido')),
			'norte_long' => utf8_encode($this->input->post('norte_long')),
			'oriente_long' => utf8_encode($this->input->post('oriente_long')),
			'sur_long' => utf8_encode($this->input->post('sur_long')),
			'occidente_long' => utf8_encode($this->input->post('occidente_long')),
			'nom_norte' => utf8_encode($this->input->post('nom_norte')),
			'nom_oriente' => utf8_encode($this->input->post('nom_oriente')),
			'nom_sur' => utf8_encode($this->input->post('nom_sur')),
			'nom_occ' => utf8_encode($this->input->post('nom_occ')),
			'c_licencia' => $c_licencia,
			'c_reglamento' => $c_reglamento,
			'c_levantamiento' => $c_levantamiento,
			'c_informe' => $c_informe,
			'c_adquisicion' => $c_adquisicion
		);

		// Se actualizan los linderos
		$this->PrediosDAO->actualizar_predio_requerido($ficha_predial, $linderos);

		//se procede a insertar los propietarios
		//se obtiene el numero de propietarios que se han agregado en el formulario
		$numero_propietarios = utf8_encode($this->input->post('propietarios_hidden'));

		//pueden haber propietarios que hayan sido eliminados del formulario
		//se va revisar uno por uno todos los que hayan sido agregados
		//teniendo como criterio de insercion que el documento del propietario no este vacio
		//se deja la validacion de este campo del lado cliente

		//se carga el modelo que gestiona la informacion de todos los propietarios
		$this->load->model('PropietariosDAO');

		// Se elimina	las relaciones a ese predio, para volverlas a configurar
		$this->PropietariosDAO->eliminar_relaciones_predio($ficha_predial);

		// Se recorren los propietarios
		for ($i = 1; $i <= $numero_propietarios; $i++)
		{
			//variable del formulario que me indica si el propietario ya hab�a sido agregado anteriormente
			$id_propietario = utf8_encode($this->input->post("id_propietario$i"));

			if($id_propietario){
				// echo "El propietario {$i} ({$this->input->post("documento_propietario$i")}) ya está asociado al predio. \n";

				//se verifica que el documento haya sido ingresado
				$documento_propietario = utf8_encode($this->input->post("documento_propietario$i"));

				//se eliminan puntos, comas y espacios en blanco
				$documento_propietario = str_replace('.', '', $documento_propietario);
				$documento_propietario = str_replace(',', '', $documento_propietario);
				$documento_propietario = str_replace(' ', '', $documento_propietario);

				//se prepara el array que contiene la informacion del propietario
				$info_propietario = array(
					'tipo_documento' => utf8_encode($this->input->post("tipo_documento$i")),
					'direccion' => 		$this->input->post("direccion_propietario$i"),
					'email' => 		$this->input->post("email_propietario$i"),
					'nombre' => 		utf8_encode($this->input->post("propietario$i")),
					'documento' => 		$documento_propietario,
					'telefono' => 		$this->input->post("telefono$i")
				);

				// //se actualiza el propietario
				$this->PropietariosDAO->actualizar_propietario($id_propietario, $info_propietario);
			//si no se habia agregado anteriormente, se agrega
			} else {
				// echo "El propietario {$i} ({$this->input->post("documento_propietario$i")}) se va a asociar al predio. \n";

				//se verifica que el documento haya sido ingresado
				$documento_propietario = utf8_encode($this->input->post("documento_propietario$i"));
				if($documento_propietario){
					// echo "verificando cédula... \n";

					//se eliminan puntos, comas y espacios en blanco
					$documento_propietario = str_replace('.', '', $documento_propietario);
					$documento_propietario = str_replace(',', '', $documento_propietario);
					$documento_propietario = str_replace(' ', '', $documento_propietario);

					//se busca si el propietario ya existe en la base de datos
					//si no existe se inserta
					$propietario = $this->PropietariosDAO->existe_propietario($documento_propietario);

					if(!$propietario){
						// echo "El propietario no existe en la base de datos. Creando... \n";

						$info_propietario = array(
							'tipo_documento' => utf8_encode($this->input->post("tipo_documento$i")),
							'direccion' => 		$this->input->post("direccion_propietario$i"),
							'email' => 		$this->input->post("email_propietario$i"),
							'nombre' => 		utf8_encode($this->input->post("propietario$i")),
							'documento' => 		$documento_propietario,
							'telefono' => 		$this->input->post("telefono$i")
						);

						//se inserta el propietario
						$this->PropietariosDAO->insertar_propietario($info_propietario);

						//se recupera para insertar la relacion con el predio
						$propietario = $this->PropietariosDAO->existe_propietario($documento_propietario);
					} // if propietario

					// Se asigna el id del propietario
					$id_propietario = $propietario->id_propietario;
				} // if documento propietario
			} // if id_propietario

			// echo "Propietario {$id_propietario}\n";

			//se inserta la relacion del propietario con el predio
			$this->PropietariosDAO->insertar_relacion_predio($id_propietario, $ficha_predial, $this->input->post("participacion$i"));
		} // for numero_propietarios









		/*for ($i = 1; $i <= $numero_propietarios; $i++)
		{
			//variable del formulario que me indica si el propietario ya hab�a sido agregado anteriormente
			$id_propietario = utf8_encode($this->input->post("id_propietario$i"));
			if($id_propietario)
			{
				//se obtiene el documento del propietario
				$documento_propietario = utf8_encode($this->input->post("documento_propietario$i"));

				//se eliminan puntos, comas y espacios en blanco
				$documento_propietario = str_replace('.', '', $documento_propietario);
				$documento_propietario = str_replace(',', '', $documento_propietario);
				$documento_propietario = str_replace(' ', '', $documento_propietario);

				//se prepara el array que contiene la informacion del propietario
				$info_propietario = array(
					'tipo_documento' => utf8_encode($this->input->post("tipo_documento$i")),
					'nombre' => 		utf8_encode($this->input->post("propietario$i")),
					'documento' => 		$documento_propietario,
					'telefono' => 		$this->input->post("telefono$i")
				);

				//se actualiza el propietario
				$this->PropietariosDAO->actualizar_propietario($id_propietario, $info_propietario);
				$this->PropietariosDAO->insertar_relacion_predio($id_propietario, $ficha_predial, utf8_encode($this->input->post("participacion$i")));
			}
			//si no se habia agregado anteriormente, se agrega
			else
			{
				//se verifica que el documento haya sido ingresado
				$documento_propietario = utf8_encode($this->input->post("documento_propietario$i"));
				if($documento_propietario)
				{
					//se eliminan puntos, comas y espacios en blanco
					$documento_propietario = str_replace('.', '', $documento_propietario);
					$documento_propietario = str_replace(',', '', $documento_propietario);
					$documento_propietario = str_replace(' ', '', $documento_propietario);

					//se busca si el propietario ya existe en la base de datos
					//si no existe se inserta
					$propietario = $this->PropietariosDAO->existe_propietario($documento_propietario);
					if($propietario == FALSE)
					{
						//se prepara la informacion que se va a guardar del propietario
						if(trim($this->input->post("telefono$i")) != '')
						{
							$info_propietario = array(
								'tipo_documento' => utf8_encode($this->input->post("tipo_documento$i")),
								'nombre' => 		utf8_encode($this->input->post("propietario$i")),
								'documento' => 		$documento_propietario,
								'telefono' => 		number_format(utf8_encode($this->input->post("telefono$i")), 0, "", "-")//esta tambien se hace por compatibilidad
							);
						}
						else {
							$info_propietario = array(
								'tipo_documento' => utf8_encode($this->input->post("tipo_documento$i")),
								'nombre' => 		utf8_encode($this->input->post("propietario$i")),
								'documento' => 		$documento_propietario
							);
						}
						//se inserta el propietario
						$this->PropietariosDAO->insertar_propietario($info_propietario);
						//se recupera para insertar la relacion con el predio
						$propietario = $this->PropietariosDAO->existe_propietario(number_format($documento_propietario, 0));
					}

					//se inserta la relacion del propietario con el predio
					$this->PropietariosDAO->insertar_relacion_predio($propietario->id_propietario, $ficha_predial, utf8_encode($this->input->post("participacion$i")));				}
			}
		}
		echo "correcto";*/
		echo "correcto";
	}

	/**
	 * Esta funcion elimina a un propietario
	 */
	function eliminar_propietario()
	{
		//se cargan los permisos
		$permisos = $this->session->userdata('permisos');
		if( ! isset($permisos['Fichas']['Actualizar']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para actualizar el m&oacute;dulo de Gesti&oacute;n de Fichas Prediales.');
			redirect('');
		}
		//se obtiene la id del propietario
		$id_propietario = utf8_encode($this->input->post('id_propietario'));
		//se obtiene la ficha predial
		$ficha_predial = utf8_encode($this->input->post('ficha_predial'));
		//si se envio la id del propietario
		if($id_propietario){
			//se carga el modelo del propietario
			$this->load->model('PropietariosDAO');
			//si se logra eliminar la relacion entre el predio y el propietario
			if($this->PropietariosDAO->eliminar_relacion_propietario($ficha_predial, $id_propietario))
			{
				//se envia la respuesta via JSON
				$respuesta = array('respuesta' => 'correcto');
				echo json_encode($respuesta);
			}
			else
			{
				//se envia la respuesta via JSON
				$respuesta = array('respuesta' => 'No se pudo borrar al propietario');
				echo json_encode($respuesta);
			}
		}
		else
		{
			//se envia la respuesta via JSON
			$respuesta = array('respuesta' => 'correcto');
			echo json_encode($respuesta);
		}
	}
	/**
	 * Carga la pagina de administracion de propietarios
	 */
	function propietario()
	{
		//se verifican los permisos
		$permisos = $this->session->userdata('permisos');
		if( ! isset($permisos['Fichas']['Actualizar']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para actualizar el m&oacute;dulo de Gesti&oacute;n de Propietarios.');
			redirect('');
		}
		//se obtiene la id del propietario
		$id_propietario = $this->uri->segment(3);
		//si no vino la id
		if ( ! $id_propietario) {
			redirect('propietarios_controller');
		}
		else
		{
			//se carga el modelo de los propietarios
			$this->load->model('PropietariosDAO');
			//se establecen las variables que se envian a las vistas
			$this->data['propietario'] = $this->PropietariosDAO->obtener_propietario($id_propietario);
			$this->data['relaciones'] = $this->PropietariosDAO->obtener_relaciones($id_propietario);
			$this->data['titulo_pagina'] = 'Actualizaci&oacute;n de propietarios';
			$this->data['contenido_principal'] = 'actualizar/propietario_view';
			//se carga la vista
			$this->load->view('includes/template', $this->data);
		}
	}
	/**
	 * Actualiza los datos de un propietario
	 */
	function actualizar_propietario()
	{
		//se cargan los permisos
		$permisos = $this->session->userdata('permisos');
		if( ! isset($permisos['Fichas']['Actualizar']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para actualizar el m&oacute;dulo de Gesti&oacute;n de Propietarios.');
			redirect('');
		}
		//se obtiene el id del propietario
		$id_propietario = $this->input->post('id');
		//se obtiene el tipo de documento
		$tipo_documento = $this->input->post('tipo_documento');
		//se obtiene el nombre del propietario
		$nombre = $this->input->post('nombre');
		//se obtiene el documento del propietario
		$documento = $this->input->post('documento');
		//se obtiene el telefono del propietario
		$telefono = $this->input->post('telefono');
		//se arma el array de datos a actualizar en la base de datos
		$datos_propietario = array(
			'tipo_documento' => $tipo_documento,
			'nombre' => utf8_encode($nombre),
			'documento' => $documento,
			'telefono' => $telefono
		);
		//se carga el modelo de los propietarios
		$this->load->model('PropietariosDAO');
		//si se logra actualizar al propietario
		if($this->PropietariosDAO->actualizar_propietario($id_propietario, $datos_propietario))
		{
			//se envia la respueta via JSON
			echo json_encode(array('respuesta' => 'correcto'));
		}
		else
		{
			//se envia la respuesta viaJSON
			echo json_encode(array('respuesta' => 'error', 'mensaje' => 'Ocurri&oacute; un error al actualizar la informaci&oacute;n del propietario.'));
		}
	}

	function insertar_cultivo() {
		 $this->PrediosDAO->insertar_cultivos_especies($this->input->post('ficha'), $this->input->post('datos'));
	}

	function eliminar_cultivo() {
		 $this->PrediosDAO->eliminar_cultivos_especies($this->input->post('id'));
	}

	function editar_cultivo() {
		$this->PrediosDAO->editar_cultivo_especies($this->input->post('id'), $this->input->post('datos'));
	}
}
/* End of file actualizar_controller.php */
/* Location: ./site_predios/application/controllers/actualizar_controller.php */
