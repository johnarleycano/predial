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
		$this->load->model(array('ProcesosDAO', 'TramosDAO', 'ContratistasDAO', 'PrediosDAO', 'PropietariosDAO', 'accionesDAO'));
	}
	/**
	 * Pagina principal del modulo
	 */
	function index() {
		//se carga el modelo que gestiona las consultas del modulo de Predios y del modulo de Contratistas
		$this->load->model(array('PrediosDAO', 'ContratistasDAO', 'AccionesDAO'));
		//se arma el array asociativo que se envia a la vista
		$this->data['fichas'] = 				$this->PrediosDAO->obtener_fichas();
		$this->data['titulo_pagina'] = 			'Actualizar';
		$this->data['contenido_principal'] = 	'actualizar/index_view';
		//se carga la vista y se envia el array asociativo
		$this->load->view('includes/template', $this->data);
	}

	/**
	 * Consulta de registros en base de datos
	 */
	function cargar() {

		//Se valida que la peticion venga mediante ajax y no mediante el navegador
		if ($this->input->is_ajax_request()) {
			// Se reciben los datos por POST
			$datos = $this->input->post('datos');
			$tipo = $this->input->post('tipo');
			$id = $this->input->post('id');
			// Dependiendo del tipo
			switch ($tipo) {
				// Total de participacion de propietarios por predio
				case 'propietario':
					echo $this->PropietariosDAO->existe_propietario($datos['documento'])->documento;
				break; // Total de participacion de propietarios por predio
				// Total de participacion de propietarios por predio
				case 'propietarios_total_participacion':
					$participacion = $this->PropietariosDAO->verificar_participacion($datos);
					echo $participacion->participacion;
				break; // Total de participacion de propietarios por predio
				// participacion de un propietario
				case 'propietario_participacion':
				$participacion = $this->PropietariosDAO->existe_relacion($id, $datos['ficha_predial']);
					echo $participacion->participacion;
				break; // participacion de un propietario

			} // suiche
		} // if
	} // cargar

	/**
     * Actualización de registros en base de datos
     */
    function actualizar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Se reciben los datos por POST
            $datos = $this->input->post('datos');
            $tipo = $this->input->post('tipo');
			$id = $this->input->post('id');

            // Dependiendo del tipo
            switch ($tipo) {
                // Cultivos
                case 'cultivo':
                    //Se ejecuta el modelo que actualiza los datos
                    echo $this->PrediosDAO->editar_cultivo_especies($id, $datos);
                break; // Cultivos
				// Construccion
				case 'construccion':
                    //Se ejecuta el modelo que actualiza los datos
                    echo $this->PrediosDAO->editar_construccion($id, $datos);
                break; // Construccion
				case 'propietario':
					//Se ejecuta el modelo que actualiza los datos
					$datos2 = array('participacion' => $datos['participacion']);
					echo $this->PropietariosDAO->actualizar_relacion_propietario($id, $datos2, $datos['ficha_predial']);
					unset($datos['ficha_predial']);
					unset($datos['participacion']);
					echo $this->PropietariosDAO->actualizar_propietario($id, $datos);
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
				// Propietario relacion
				case 'propietario_relacion':
					// Se crea el registro
					echo $this->PropietariosDAO->insertar_relacion_predio($datos['id_propietario'], $datos['ficha_predial'], $datos['participacion']);
				break; // Propietario relacion
				// propietario
				case 'propietario':
					// Se crea el registro
					//Se ejecuta el modelo que actualiza los datos
					$participacion = $datos['participacion'];
					$ficha_predial = $datos['ficha_predial'];
					unset($datos['ficha_predial']);
					unset($datos['participacion']);
					$this->PropietariosDAO->insertar_propietario($datos);
					$id = mysql_insert_id();
					// se crea la relacion del nuevo propietario
					$this->PropietariosDAO->insertar_relacion_predio($id, $ficha_predial, $participacion);
				break; // Propietario

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
				// Construccion
				case 'propietario_relacion':
					// Se elimina el registro
					echo $this->PropietariosDAO->eliminar_relacion_propietario($datos['ficha_predial'], $datos['id']);
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
				// Propietarios de ficha predial
                case 'propietarios':
                	// Se toman valores que vienen por post
                    $this->data['ficha'] = $this->input->post('ficha');

                    // Se carga la vista
                    $this->load->view('actualizar/propietarios/index', $this->data);
                break; // Propietarios de ficha predial

                // Gestión de propietarios de ficha predial
                case 'propietarios_gestion':
					// Se toman valores que vienen por post
                    $this->data['id'] = $this->input->post('id');
					$this->data['ficha'] = $this->input->post('ficha');
    				// Se carga la vista
                    $this->load->view('actualizar/propietarios/gestion', $this->data);
                break; // Gestión de propietarios de ficha predial

                // Listado de propietarios de ficha predial
                case 'propietarios_lista':
                	// Se toman valores que vienen por post
                    $this->data['ficha'] = $this->input->post('ficha');

                    // Se carga la vista
                    $this->load->view('actualizar/propietarios/listar', $this->data);
                break; // Listado de cultivos de ficha predial
				// regresa un propietario
				// Buscar propietario
				case 'propietario_buscar':
					// Se toman valores que vienen por post
					$this->data['ficha'] = $this->input->post('ficha');
					$this->data['documento'] = $this->input->post('documento');
					// Se carga la vista
					$this->load->view('actualizar/propietarios/buscar', $this->data);
				break; // Buscar propietaro
				// Vertices
				case 'vertices':
					// Se toman valores que vienen por post
					$this->data['ficha'] = $this->input->post('ficha');
					// Se carga la vista
					$this->load->view('actualizar/vertices/index', $this->data);
				break; // Vertices de ficha predial
				// Vertices Listar
				case 'vertices_lista':
					// Se toman valores que vienen por post
					$this->data['ficha'] = $this->input->post('ficha');
					// listado de vertices
					$this->data['vertices'] = $this->accionesDAO->consultar_coordenadas($this->input->post('ficha'));
					// Se carga la vista
					$this->load->view('actualizar/vertices/listar', $this->data);
				break; // Vertices de ficha predial

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
			'barrio' => 			$this->input->post('vereda_barrio'),
			'conc_titu' => 			$this->input->post('concepto'),
			'ciudad' => 			$this->input->post('ciudad_predio_inicial'),
			'ciudad_f' => 			$this->input->post('ciudad_predio_final'),
			'direccion' => 			$this->input->post('direccion_nombre'),
			'doc_estud' => 			$this->input->post('documentos_estudiados'),
			'enc_gestion' => 		$this->input->post('encargado_gestion_predial'),
			'entregado' => 			$this->input->post('entregado'),
			'env_esc_not' => 		$this->input->post('envio_escritura_notaria'),
			'escritura_orig' => 	$this->input->post('numero_escritura'),
			'estado_predio' => 		$this->input->post('estado_predio'),
			'estado_pro' => 		$this->input->post('estado_proceso'),
			'f_apro_def' => 		$this->input->post('aprobacion_definitiva_plano'),
			'f_aprob_soc' => 		$this->input->post('f_aprob_soc'),
			'f_aprob_tit' => 		$this->input->post('f_aprob_tit'),
			'f_aprob_ficha' => 		$this->input->post('f_aprob_ficha'),
			'f_ent_plano_int' => 	$this->input->post('entrega_plano_interventoria'),
			'f_envio_av' => 		$this->input->post('envio_avaluador'),
			'f_envio_ger' => 		$this->input->post('envio_gerencia_firmar'),
			'f_envio_int' => 		$this->input->post('f_envio_int'),
			'f_entregado' => 		$this->input->post('fecha_entregado'),
			'f_inicio_trab' => 		$this->input->post('inicio_trabajo_fisico'),
			'f_notificacion_pro' => $this->input->post('notificacion_propietario'),
			'f_recibo_av' => 		$this->input->post('f_recibo_av'),
			'f_recibo_pro' => 		$this->input->post('recibo_notificacion_propietario'),
			'f_rev_ficha' => 		$this->input->post('f_rev_ficha'),
			'f_oferta_c' => 		$this->input->post('f_oferta_c'),
			'f_oferta_notif' => 	$this->input->post('f_oferta_notif'),
			'f_oferta_ac' => 		$this->input->post('f_oferta_ac'),
			'f_permiso_int' => 		$this->input->post('f_permiso_int'),
			'f_firma_prom' => 		$this->input->post('f_firma_prom'),
			'fecha_esc_f' => 		$this->input->post('fecha_predio_final'),
			'fecha_escritura' => 	$this->input->post('fecha_predio_inicial'),
			'fecha_estudio' => 		$this->input->post('fecha_estudio'),
			'gravamenes' => 		$this->input->post('gravamenes_limitaciones'),
			'id_estado_via' => 		$this->input->post('estado_via'),
			'id_funcion_predio' => 	$this->input->post('funcion_predio'),
			'ing_esc' => 			$this->input->post('ingreso_escritura'),
			'ini_juic' => 			$this->input->post('inicio_juicio'),
			'ini_sent' => 			$this->input->post('inicio_sentencia'),
			'ing_sent' => 			$this->input->post('ingreso_sentencia_registro'),
			'lind_titulo' => 		$this->input->post('linderos_segun_titulo'),
			'matricula_orig' => 	$this->input->post('numero_matricula_predio_inicial'),
			'municipio' => 			$this->input->post('municipio'),
			'no_catastral' => 		$this->input->post('numero_catastral_predio_inicial'),
			'no_notaria' => 		$this->input->post('numero_notaria_predio_inicial'),
			'notif' => 				$this->input->post('notificacion'),
			'num_escritura_f' => 	$this->input->post('escritura_sentencia'),
			'num_catastral_f' => 	$this->input->post('numero_catastral_predio_final'),
			'num_matricula_f' => 	$this->input->post('numero_matricula_predio_final'),
			'num_notaria_f' => 		$this->input->post('numero_notaria_predio_final'),
			'ob_titu' => 			$this->input->post('observaciones_estudio_titulos'),
			'of_registro' => 		$this->input->post('oficina_registro_predio_inicial'),
			'of_registro_f' => 		$this->input->post('oficina_registro_predio_final'),
			'r_envio_av' => 		$this->input->post('radicado_envio_avaluador'),
			'r_oferta_c' => 		$this->input->post('r_oferta_c'),
			'r_rec_av' => 			$this->input->post('r_rec_av'),
			'rad_apro_pla' => 		$this->input->post('radicado_aprobacion_plano'),
			'rad_aprob_ficha' => 	$this->input->post('rad_aprob_ficha'),
			'rad_aprob_soc' => 		$this->input->post('rad_aprob_soc'),
			'rad_aprob_tit' => 		$this->input->post('rad_aprob_tit'),
			'rad_ent' => 			$this->input->post('radicado'),
			'rad_env_ger' => 		$this->input->post('radicado_envio_gerencia'),
			'rad_env_int' => 		$this->input->post('rad_env_int'),
			'rad_int' => 			$this->input->post('radicado_entrega_interventoria'),
			'rad_no_pro' => 		$this->input->post('radicado_notificacion_propietario'),
			'rad_rev_ficha' => 		$this->input->post('rad_rev_ficha'),
			'rec_reg_exp' => 		$this->input->post('recibo_registro_expropiacion'),
			'rad_of_notif' => 		$this->input->post('rad_of_notif'),
			'rad_of_ac' => 			$this->input->post('rad_of_ac'),
			'rad_permiso_int' =>	$this->input->post('rad_permiso_int'),
			'rad_firma_prom' => 	$this->input->post('rad_firma_prom'),
			'rec_reg_vol' => 		$this->input->post('recibo_registro_enajenacion'),
			'titulos_adq' => 		$this->input->post('titulos_adquisicion'),
			'total_avaluo' => 		$this->input->post('total_avaluo'),
			'valor_mtr' => 			$this->input->post('valor_metro_cuadrado'),
			'valor_total_mej' => 	$this->input->post('valor_total_mejoras'),
			'valor_total_terr' => 	$this->input->post('valor_total_terreno'),
			'segreg_titu' => 		$this->input->post('segregaciones'),
			'titulo_adquisicion' => $this->input->post('titulo_adquisicion')
		);

		//se inserta la identificacion del predio
		$this->PrediosDAO->actualizar_identificacion($ficha_predial, $identificacion);

		//se prepara la descripcion
		$descripcion = array(
			'uso_edificacion' => 		$this->input->post('uso_edificacion'),
			'estado_pre' => 			$this->input->post('estado'),
			'uso_terreno' => 			$this->input->post('uso_terreno'),
			'tipo_tenencia' => 			$this->input->post('tipo_tenencia'),
			'topografia' => 			$this->input->post('topografia'),
			'via_acceso' => 			$this->input->post('via_acceso'),
			'serv_publicos' => 			$this->input->post('servicios_publicos'),
			'nacimiento_agua' => 		$this->input->post('nacimiento_agua'),
			'area_total' => 			$this->input->post('area_total'),
			'area_total_catastral' =>	$this->input->post('area_total_catastral'),
			'area_total_registral' =>	$this->input->post('area_total_registral'),
			'area_total_titulos' =>		$this->input->post('area_total_titulos'),
			'area_requerida' => 		$this->input->post('area_requerida'),
			'area_residual' => 			$this->input->post('area_residual'),
			'area_construida' => 		$this->input->post('area_construida'),
			'area_cons_requerida' => 	$this->input->post('area_const_requerida'),
			'abscisa_inicial' => 		$this->input->post('abscisa_inicial'),
			'margen_inicial' => 		$this->input->post('margen_inicial'),
			'abscisa_final' => 			$this->input->post('abscisa_final'),
			'margen_final' => 			$this->input->post('margen_final'),
			'observacion' => 			$this->input->post('observacion'),
			'requiere_longitud_efectiva' => $this->input->post('requiere_longitud_efectiva'),
			'tramo' => 					$this->input->post('tramo'),
			'numero' => 				$this->input->post('numero_ficha'),
			'estado_ambiental' => 		$this->input->post('estado_ambiental'),
			'meta_contractual' => 		$this->input->post('meta_contractual'),
			'disponibilidad_izquierda' => $this->input->post('disponibilidad_izquierda'),
			'disponibilidad_derecha' => $this->input->post('disponibilidad_derecha'),
			'fecha_remision_insumos' => $this->input->post('fecha_remision_insumos')
		);

		//se inserta la descripcion del predio
		$this->PrediosDAO->actualizar_descripcion($ficha_predial, $descripcion);

		//se insertan los linderos del predio
		// $this->PrediosDAO->actualizar_linderos($ficha_predial, ($this->input->post('linderos_predio_requerido')));

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
			'linderos' => $this->input->post('linderos_predio_requerido'),
			'norte_long' => $this->input->post('norte_long'),
			'oriente_long' => $this->input->post('oriente_long'),
			'sur_long' => $this->input->post('sur_long'),
			'occidente_long' => $this->input->post('occidente_long'),
			'nom_norte' => $this->input->post('nom_norte'),
			'nom_oriente' => $this->input->post('nom_oriente'),
			'nom_sur' => $this->input->post('nom_sur'),
			'nom_occ' => $this->input->post('nom_occ'),
			'c_licencia' => $c_licencia,
			'c_reglamento' => $c_reglamento,
			'c_levantamiento' => $c_levantamiento,
			'c_informe' => $c_informe,
			'c_adquisicion' => $c_adquisicion
		);

		// Se actualizan los linderos
		$this->PrediosDAO->actualizar_predio_requerido($ficha_predial, $linderos);
		echo "correcto";
	}

/* Esta funcion corrige problemas de codificacion en la base de datos
	function correccion() {
		$predios = $this->PrediosDAO->obtener_fichas();
		$i = 1;
		foreach ($predios as $predio) {
			$this->data['predio'] = $this->PrediosDAO->obtener_predio($predio->id_predio);
			$this->data['identificacion'] =	$this->PrediosDAO->obtener_identificacion($this->data['predio']->ficha_predial);
			$this->data['descripcion'] = $this->PrediosDAO->obtener_descripcion($this->data['predio']->ficha_predial);
			$this->data['linderos'] = $this->PrediosDAO->obtener_linderos($this->data['predio']->ficha_predial);
			$ficha_predial = $this->data['predio']->ficha_predial;
			//se carga el modelo PrediosDAO
			$this->load->model('PrediosDAO');
			// se prepara la identificacion del predio
			$identificacion = array(
				'barrio' => 			utf8_decode($this->data['identificacion']->barrio),
				'conc_titu' => 			utf8_decode($this->data['identificacion']->conc_titu),
				'ciudad' => 			utf8_decode($this->data['identificacion']->ciudad),
				'ciudad_f' => 			utf8_decode($this->data['identificacion']->ciudad_f),
				'direccion' => 			utf8_decode($this->data['identificacion']->direccion),
				'doc_estud' => 			utf8_decode($this->data['identificacion']->doc_estud),
				'enc_gestion' => 		utf8_decode($this->data['identificacion']->enc_gestion),
				'entregado' => 			utf8_decode($this->data['identificacion']->entregado),
				'env_esc_not' => 		utf8_decode($this->data['identificacion']->env_esc_not),
				'escritura_orig' => 	utf8_decode($this->data['identificacion']->escritura_orig),
				'estado_predio' => 		utf8_decode($this->data['identificacion']->estado_predio),
				'estado_pro' => 		utf8_decode($this->data['identificacion']->estado_pro),
				'f_apro_def' => 		utf8_decode($this->data['identificacion']->f_apro_def),
				'f_aprob_soc' => 		utf8_decode($this->data['identificacion']->f_aprob_soc),
				'f_aprob_tit' => 		utf8_decode($this->data['identificacion']->f_aprob_tit),
				'f_aprob_ficha' => 		utf8_decode($this->data['identificacion']->f_aprob_ficha),
				'f_ent_plano_int' => 	utf8_decode($this->data['identificacion']->f_ent_plano_int),
				'f_envio_av' => 		utf8_decode($this->data['identificacion']->f_envio_av),
				'f_envio_ger' => 		utf8_decode($this->data['identificacion']->f_envio_ger),
				'f_envio_int' => 		utf8_decode($this->data['identificacion']->f_envio_int),
				'f_entregado' => 		utf8_decode($this->data['identificacion']->f_entregado),
				'f_inicio_trab' => 		utf8_decode($this->data['identificacion']->f_inicio_trab),
				'f_notificacion_pro' => utf8_decode($this->data['identificacion']->f_notificacion_pro),
				'f_recibo_av' => 		utf8_decode($this->data['identificacion']->f_recibo_av),
				'f_recibo_pro' => 		utf8_decode($this->data['identificacion']->f_recibo_pro),
				'f_rev_ficha' => 		utf8_decode($this->data['identificacion']->f_rev_ficha),
				'f_oferta_c' => 		utf8_decode($this->data['identificacion']->f_oferta_c),
				'f_oferta_notif' => 	utf8_decode($this->data['identificacion']->f_oferta_notif),
				'f_oferta_ac' => 		utf8_decode($this->data['identificacion']->f_oferta_ac),
				'f_permiso_int' => 		utf8_decode($this->data['identificacion']->f_permiso_int),
				'f_firma_prom' => 		utf8_decode($this->data['identificacion']->f_firma_prom),
				'fecha_esc_f' => 		utf8_decode($this->data['identificacion']->fecha_esc_f),
				'fecha_escritura' => 	utf8_decode($this->data['identificacion']->fecha_escritura),
				'fecha_estudio' => 		utf8_decode($this->data['identificacion']->fecha_estudio),
				'gravamenes' => 		utf8_decode($this->data['identificacion']->gravamenes),
				'id_estado_via' => 		utf8_decode($this->data['identificacion']->id_estado_via),
				'id_funcion_predio' => 	utf8_decode($this->data['identificacion']->id_funcion_predio),
				'ing_esc' => 			utf8_decode($this->data['identificacion']->ing_esc),
				'ini_juic' => 			utf8_decode($this->data['identificacion']->ini_juic),
				'ini_sent' => 			utf8_decode($this->data['identificacion']->ini_sent),
				'ing_sent' => 			utf8_decode($this->data['identificacion']->ing_sent),
				'lind_titulo' => 		utf8_decode($this->data['identificacion']->lind_titulo),
				'matricula_orig' => 	utf8_decode($this->data['identificacion']->matricula_orig),
				'municipio' => 			utf8_decode($this->data['identificacion']->municipio),
				'no_catastral' => 		utf8_decode($this->data['identificacion']->no_catastral),
				'no_notaria' => 		utf8_decode($this->data['identificacion']->no_notaria),
				'notif' => 				utf8_decode($this->data['identificacion']->notif),
				'num_escritura_f' => 	utf8_decode($this->data['identificacion']->num_escritura_f),
				'num_catastral_f' => 	utf8_decode($this->data['identificacion']->num_catastral_f),
				'num_matricula_f' => 	utf8_decode($this->data['identificacion']->num_matricula_f),
				'num_notaria_f' => 		utf8_decode($this->data['identificacion']->num_notaria_f),
				'ob_titu' => 			utf8_decode($this->data['identificacion']->ob_titu),
				'of_registro' => 		utf8_decode($this->data['identificacion']->of_registro),
				'of_registro_f' => 		utf8_decode($this->data['identificacion']->of_registro_f),
				'r_envio_av' => 		utf8_decode($this->data['identificacion']->r_envio_av),
				'r_oferta_c' => 		utf8_decode($this->data['identificacion']->r_oferta_c),
				'r_rec_av' => 			utf8_decode($this->data['identificacion']->r_rec_av),
				'rad_apro_pla' => 		utf8_decode($this->data['identificacion']->rad_apro_pla),
				'rad_aprob_ficha' => 	utf8_decode($this->data['identificacion']->rad_aprob_ficha),
				'rad_aprob_soc' => 		utf8_decode($this->data['identificacion']->rad_aprob_soc),
				'rad_aprob_tit' => 		utf8_decode($this->data['identificacion']->rad_aprob_tit),
				'rad_ent' => 			utf8_decode($this->data['identificacion']->rad_ent),
				'rad_env_ger' => 		utf8_decode($this->data['identificacion']->rad_env_ger),
				'rad_env_int' => 		utf8_decode($this->data['identificacion']->rad_env_int),
				'rad_int' => 			utf8_decode($this->data['identificacion']->rad_int),
				'rad_no_pro' => 		utf8_decode($this->data['identificacion']->rad_no_pro),
				'rad_rev_ficha' => 		utf8_decode($this->data['identificacion']->rad_rev_ficha),
				'rec_reg_exp' => 		utf8_decode($this->data['identificacion']->rec_reg_exp),
				'rad_of_notif' => 		utf8_decode($this->data['identificacion']->rad_of_notif),
				'rad_of_ac' => 			utf8_decode($this->data['identificacion']->rad_of_ac),
				'rad_permiso_int' =>	utf8_decode($this->data['identificacion']->rad_permiso_int),
				'rad_firma_prom' => 	utf8_decode($this->data['identificacion']->rad_firma_prom),
				'rec_reg_vol' => 		utf8_decode($this->data['identificacion']->rec_reg_vol),
				'titulos_adq' => 		utf8_decode($this->data['identificacion']->titulos_adq),
				'total_avaluo' => 		utf8_decode($this->data['identificacion']->total_avaluo),
				'valor_mtr' => 			utf8_decode($this->data['identificacion']->valor_mtr),
				'valor_total_mej' => 	utf8_decode($this->data['identificacion']->valor_total_mej),
				'valor_total_terr' => 	utf8_decode($this->data['identificacion']->valor_total_terr),
				'segreg_titu' => 		utf8_decode($this->data['identificacion']->segreg_titu),
				'titulo_adquisicion' => utf8_decode($this->data['identificacion']->titulo_adquisicion)
			);



			//se inserta la identificacion del predio
			$this->PrediosDAO->actualizar_identificacion($ficha_predial, $identificacion);

			//se prepara la descripcion
			$descripcion = array(

				// 'uso_edificacion' => 		($this->data['identificacion']->('uso_edificacion')),
				'estado_pre' => 			utf8_decode($this->data['descripcion']->estado_pre),
				'uso_terreno' => 			utf8_decode($this->data['descripcion']->uso_terreno),
				'tipo_tenencia' => 			utf8_decode($this->data['descripcion']->tipo_tenencia),
				'topografia' => 			utf8_decode($this->data['descripcion']->topografia),
				'via_acceso' => 			utf8_decode($this->data['descripcion']->via_acceso),
				'serv_publicos' => 			utf8_decode($this->data['descripcion']->serv_publicos),
				'nacimiento_agua' => 		utf8_decode($this->data['descripcion']->nacimiento_agua),
				'area_total' => 			utf8_decode($this->data['descripcion']->area_total),
				'area_total_catastral' =>	utf8_decode($this->data['descripcion']->area_total_catastral),
				'area_total_registral' =>	utf8_decode($this->data['descripcion']->area_total_registral),
				'area_total_titulos' =>		utf8_decode($this->data['descripcion']->area_total_titulos),
				'area_requerida' => 		utf8_decode($this->data['descripcion']->area_requerida),
				'area_residual' => 			utf8_decode($this->data['descripcion']->area_residual),
				'area_construida' => 		utf8_decode($this->data['descripcion']->area_construida),
				'area_cons_requerida' => 	utf8_decode($this->data['descripcion']->area_const_requerida),
				'abscisa_inicial' => 		utf8_decode($this->data['descripcion']->abscisa_inicial),
				'margen_inicial' => 		utf8_decode($this->data['descripcion']->margen_inicial),
				'abscisa_final' => 			utf8_decode($this->data['descripcion']->abscisa_final),
				'margen_final' => 			utf8_decode($this->data['descripcion']->margen_final),
				'observacion' => 			utf8_decode($this->data['descripcion']->observacion),
				'tramo' => 					utf8_decode($this->data['descripcion']->tramo),
				'numero' => 				utf8_decode($this->data['descripcion']->numero),
				'estado_ambiental' => 		utf8_decode($this->data['descripcion']->estado_ambiental),
				'meta_contractual' => 		utf8_decode($this->data['descripcion']->meta_contractual),
				'disponibilidad_izquierda' => utf8_decode($this->data['descripcion']->disponibilidad_izquierda),
				'disponibilidad_derecha' => utf8_decode($this->data['descripcion']->disponibilidad_derecha)
			);

			//se inserta la descripcion del predio
			$this->PrediosDAO->actualizar_descripcion($ficha_predial, $descripcion);

			// Información de los linderos
			$linderos = array(
				'ficha_predial' => $ficha_predial,
				'linderos' => utf8_decode($this->data['linderos']->linderos),
				'norte_long' => utf8_decode($this->data['linderos']->norte_long),
				'oriente_long' => utf8_decode($this->data['linderos']->oriente_long),
				'sur_long' => utf8_decode($this->data['linderos']->sur_long),
				'occidente_long' => utf8_decode($this->data['linderos']->occidente_long),
				'nom_norte' => utf8_decode($this->data['linderos']->nom_norte),
				'nom_oriente' => utf8_decode($this->data['linderos']->nom_oriente),
				'nom_sur' => utf8_decode($this->data['linderos']->nom_sur),
				'nom_occ' => utf8_decode($this->data['linderos']->nom_occ),
				'c_licencia' => utf8_decode($this->data['linderos']->c_licencia),
				'c_reglamento' => utf8_decode($this->data['linderos']->c_reglamento),
				'c_levantamiento' => utf8_decode($this->data['linderos']->c_levantamiento),
				'c_informe' => utf8_decode($this->data['linderos']->c_informe),
				'c_adquisicion' => utf8_decode($this->data['linderos']->c_adquisicion)
			);

			// Se actualizan los linderos
			$this->PrediosDAO->actualizar_predio_requerido($ficha_predial, $linderos);
			echo $i.')  '.$predio->id_predio.'<br>';
		}
	}
*/
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
