<?php
error_reporting(-1);

require('site_predios/libraries/proj4php/vendor/autoload.php');

use proj4php\Proj4php;
use proj4php\Proj;
use proj4php\Point;

ini_set('post_max_size','100M');
ini_set('upload_max_filesize','100M');
ini_set('max_execution_time','1000');
ini_set('max_input_time','1000');
error_reporting(-1);
/**
 * Clase encargada de controlar las operaciones que se realizan sobre los archivos
 * @author Freddy Alexander Vivas Reyes
 * @copyright 2012
 */
class Archivos_controller extends CI_Controller
{
	/**
	 * Variable encargada de almacenar las variables que van a las vistas
	 * @var Array asociativo
	 */
	var $data = array();
	/**
	 * Ruta raiz de los archivos
	 * @var String
	 */
	var $ruta_archivos = "files/";
	/**
	 * Ruta de las fotos
	 * @var String
	 */
	var $nombre_carpeta_fotos = "fotos/";
	/**
	 * Variable que indica si hubo o no error
	 * @var Boolean
	 */
	var $error = FALSE;
	/**
	 * Metodo constructor del controlador
	 */
	 var $nombre_carpeta_archivos_social = "archivos_social/";
	function __construct()
	{
		//se hereda el constructor del controlador padre
		parent::__construct();
		//si el usuario no esta logueado
		if($this->session->userdata('id_usuario') != TRUE)
		{
			//redirecciono al controlador de sesion
			redirect('sesion_controller');
		}
		//se verifican los permisos del usuario
		$permisos = $this->session->userdata('permisos');
		//se verifica que tenga permiso de consultar los archivos y fotos del sistema
		if ( ! isset($permisos['Archivos y Fotos']['Consultar']) ) {
			//se verifica si la funcion encargada de procesar la accion no es vista_archivos_actas
			//la cual es una funcion que se ofrece para que se puedan consultar los archivos desde
			//el controlador de actas
			if($this->uri->segment(2) != strtolower('vista_archivos_actas')) {
				//si no se tienen permisos se indica que hay un error
				$this->session->set_flashdata('error', 'Usted no cuenta con permisos para visualizar los archivos y fotos.');
				//se redirije al controlador principal
				redirect('');
			}
			else {
				//variable de control
				$this->error = TRUE;
			}
		}
		//se establece la vista que tiene el contenido del menu
		$this->data['menu'] = 'archivos/menu';
	}
	/**
	 * Metodo para ver los archivos del sistema
	 */
	function ver_archivos()
	{
		//se obtiene la ficha predial por url
		$ficha = $this->uri->segment(3);
		//si no llega la ficha
		if( ! $ficha)
		{
			//se redirecciona hacia el controlador de actualizaciones
			redirect('actualizar_controller');
		}
		else
		{
			//sino entonces se verifica que exista la ruta de donde se van a leer los archivos
			if( ! is_dir($this->ruta_archivos.$ficha) )
			{
				//sino entonces se crea la ruta con todos los permisos
				@mkdir($this->ruta_archivos.$ficha, 0777);
			}

			//se abre el directorio
			if($directorio = opendir($this->ruta_archivos.$ficha))
			{
				//se arma un array de nombres de archivo
				$nombres = array();
				//se lee archivo por archivo
				while(($file = readdir($directorio)) !== FALSE)
				{
					if(strpos($file, '.') !== false && $file != '.' && $file != '..')
					{
						//se guardan los nombres en el array
						array_push($nombres, $file);
					}
				}

				//se cierra el directorio
				closedir();
				//se carga la libreria que permite establecer el browser con el que se abrio la pagina
				$this->load->library('user_agent');
				//se establecen las variables que van a la vista
				$this->data['ficha'] = $ficha;
				$this->data['es_ie'] = $this->agent->is_browser('Internet Explorer');
				$this->data['archivos'] = $nombres;
				$this->data['directorio'] = $this->ruta_archivos.$ficha;
				$this->data['script'] = "/site_predios/archivos_controller/subir_archivos/$ficha";
				$this->data['titulo_pagina'] = "Archivos - ficha predial $ficha";
				$this->data['contenido_principal'] = 'archivos/archivos_view';
				//se carga la vista
				$this->load->view('includes/template',$this->data);
			}
		}
	}

	function eliminar_archivo() {
		unlink($this->input->post('directorio').'/'.$this->input->post('archivo'));
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Se Elimina el archivo '.$this->input->post('archivo').' de la ficha '.$this->input->post('ficha')
		);
		$this->db->insert('auditoria', $auditoria);
	}

	function superar_archivo() {
		$archivo = $this->input->post('archivo');
		$directorio = $this->input->post('directorio');
		$archivo_viejo = $directorio.'/'.$archivo;
		$extension = substr($archivo, (strlen($archivo) - strrpos($archivo, '.', -1)) * - 1);
		$archivo = substr($archivo, 0, strpos($archivo, $extension));

		// si el archivo contiene la palabra superado
		if (strpos($archivo_viejo, 'SUPERADO') !== false) {
			$archivo_nuevo = $directorio.'/'.substr($archivo, 0,  strpos($archivo, 'SUPERADO') -2).$extension;
		} else {
			$archivo_nuevo = $directorio.'/'.$archivo.' (SUPERADO '.date("d-m-y").')'.$extension;
		}
		rename($archivo_viejo, $archivo_nuevo);
	}
	/**
	 * Metodo encargado de ofrecer una vista desde los controladores de actualizaciones de fichas prediales y actas
	 */
	function obtener_archivos() {
		//se obtiene la ficha predial pasada por url
		$ficha = $this->uri->segment(3);
		//se obtiene el array de permisos del usuario
		$permisos = $this->session->userdata('permisos');
		//si no tiene permiso de consultar el modulo de actas
		if( ! isset($permisos['Actas']['Consultar']) ) {
			$this->data['titulo_pagina'] = "Archivos - ficha predial $ficha";
		}

		if( ! is_dir($this->ruta_archivos.$ficha) )
		{
			@mkdir($this->ruta_archivos.$ficha, 0777);
		}

		//se abre el directorio
		if($directorio = opendir($this->ruta_archivos.$ficha))
		{
			//se arma un array de nombres de archivo
			$nombres = array();

			while(($file = readdir($directorio)) !== FALSE)
			{
				if($file != '.' && $file != '..' && $file != 'fotos')
				{
					array_push($nombres, $file);
				}
			}

			//se cierra el directorio
			closedir();

			$this->load->library('user_agent');
			$this->data['es_ie'] = $this->agent->is_browser('Internet Explorer');
			$this->data['archivos'] = $nombres;
			$this->data['directorio'] = $this->ruta_archivos.$ficha;
			$this->data['script'] = "/site_predios/archivos_controller/subir_archivos/$ficha";
			$this->data['titulo_pagina'] = "Archivos - ficha predial $ficha";
			$this->data['contenido_principal'] = 'archivos/archivos_view';
			$this->load->view('archivos/vista_auxiliar',$this->data);
		}
	}

	function ver_fotos()
	{
		$this->load->model("accionesDAO");
		$ficha = $this->input->get('ficha');
		$tipo = $this->input->get('tipo');
		$id = $this->input->get('id');
		$this->data['id'] = $id;
		$this->data['ficha'] = $ficha;
		$this->data['tipo'] = $tipo;
		$aux = $this->input->get('aux');

		//si la ficha no existe
		if( ! $ficha)
		{
			redirect('actualizar_controller');
		}
		else
		{
			// si la carpeta con el nombre de la ficha no existe se crea
			if( ! is_dir($this->ruta_archivos.$ficha) )
			{
				@mkdir($this->ruta_archivos.$ficha, 0777);
			}

			// si la carpeta fotos no existe se crea
			if( ! is_dir($this->ruta_archivos.$ficha.'/'.$this->nombre_carpeta_fotos) )
			{
				@mkdir($this->ruta_archivos.$ficha.'/'.$this->nombre_carpeta_fotos, 0777);
			}
		}
		switch ($tipo) {
			// caracterizacion general
			case '2':
				$this->data['menu'] = 'gestion_social/menu';
				break;
			// unidades sociales residentes
			case '3':
				$this->data['menu'] = 'gestion_social/unidades_sociales_residentes/menu';
				break;
			// unidades sociales productivas
			case '4':
				$this->data['menu'] = 'gestion_social/unidades_sociales_productivas/menu';
				break;
		}
		$this->data['tipo'] = $tipo;
		$this->data['fotos'] = $this->accionesDAO->consultar_archivo($ficha, $tipo, 2, $id);
		$this->load->library('user_agent');
		$this->data['es_ie'] = $this->agent->is_browser('Internet Explorer');
		$this->data['directorio'] = $this->ruta_archivos.$ficha.'/'.$this->nombre_carpeta_fotos;
		$this->data['script'] = "/site_predios/archivos_controller/subir_archivos/$ficha";
		$this->data['titulo_pagina'] = "Archivos - ficha predial $ficha";
		$this->data['contenido_principal'] = 'archivos/fotos_view';

		if ($aux) {
			$this->load->view('archivos/vista_auxiliar',$this->data);
		} else {
			$this->load->view('includes/template', $this->data);
		}
	}

	function subir_archivos()
	{
		$permisos = $this->session->userdata('permisos');
		if ( ! isset($permisos['Archivos y Fotos']['Subir']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para subir archivos.');
			redirect('');
		}
		$carpeta = $this->ruta_archivos.str_replace(' ','_', $this->uri->segment(3));
		$resultado = "correcto";

		if(isset($_FILES['archivos'])) {
			foreach ($_FILES['archivos']['error'] as $key => $error) {
				if ($error == UPLOAD_ERR_OK) {
					$tmp_name = $_FILES['archivos']['tmp_name'][$key];
					$name = $_FILES['archivos']['name'][$key];

					if( ! move_uploaded_file($tmp_name, $carpeta.'/'.$name))
					{
						$resultado = "Ocurri&oacute; un error al subir los ficheros, verifique por favor.";
					}
				}
			}

			echo $resultado;
		}
		else {
			echo "Debe seleccionar al menos un archivo";
		}
	}

	function subir_fotos()
	{
		$this->load->model("accionesDAO");

		$permisos = $this->session->userdata('permisos');
		if ( ! isset($permisos['Archivos y Fotos']['Subir']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para subir fotos.');
			redirect('');
		} // if

		//Se almacena la fecha
        $fecha = date("Ymd-His");

		$directorio = $this->ruta_archivos.str_replace(' ','_', $this->input->post("ficha")).'/'.$this->nombre_carpeta_fotos;

		$nombre = $fecha.'.'.$extension = end(explode(".", $_FILES['userfile']['name']));
		// Si el fichero existe
    if (file_exists($directorio.$nombre)) {
        echo "existe";
    // Si se sube corectamente
	} elseif($this->accionesDAO->procesar_foto($_FILES['userfile']['tmp_name'], $directorio, $nombre)) {
    	// Se prepara el arreglo con el que se guarda los datos de la foto
		// si el tipo es 3 se registra en el campo unidad social residente sino en la unidad social productiva
		$id = ($this->input->post("tipo") == 3) ? "id_usr" : "id_usp";
		$id_valor = ($this->input->post("id") == 0) ? NULL : $this->input->post("id");

    	$datos = array(
			"archivo" => $nombre,
			"categoria" => 2,
    		"descripcion" => $this->input->post("descripcion"),
			"fecha" => $this->input->post("fecha"),
    		"ficha_predial" => $this->input->post("ficha"),
			"orden" => $this->input->post("orden"),
			"tipo" => $this->input->post("tipo"),
			$id => $id_valor
		);

		// Si se guarda el registro en base de datos correctamente
		if ($this->accionesDAO->guardar_foto($datos)) {
			echo true;
		} // if
    } // subir_fotos





		// $resultado = "correcto";

		// if(isset($_FILES['fotos'])) {
		// 	foreach ($_FILES['fotos']['error'] as $key => $error) {
		// 		if ($error == UPLOAD_ERR_OK) {
		// 			$tmp_name = $_FILES['fotos']['tmp_name'][$key];
		// 			$name = $_FILES['fotos']['name'][$key];

		// 			if( ! move_uploaded_file($tmp_name, $carpeta.'/'.$name))
		// 			{
		// 				$resultado = "Ocurri&oacute; un error al subir las fotos, verifique por favor.";
		// 			}
		// 		}
		// 	}

		// 	echo $resultado;
		// }
		// else {
		// 	echo "Debe seleccionar al menos una foto";
		// }
	}

	function actualizar_foto() {
		$this->load->model("accionesDAO");
		$arreglo = array("orden" => $this->input->post('orden'));
		$this->accionesDAO->actualizar_foto($this->input->post('nombre'), $arreglo);
	}

	function eliminar_foto(){
		$this->load->model("accionesDAO");

		// Se borra el archivo del servidor
        if(unlink($this->input->post('archivo'))){
        	// Se elimina el registro de la base de datos
        	echo $this->accionesDAO->eliminar_foto($this->input->post('nombre'));

			// Se retorna verdadero
			// echo true;
        } // if
	}

	function subir_csv () {
		$this->load->model("accionesDAO");

		$csv = $_FILES['userfile']['tmp_name'];
		$filas = count(file($csv));
		$fichero = fopen($csv, "r");
		$cont = 0;
		$this->accionesDAO->eliminar_coordenadas($this->input->post('ficha'));
		$contenido = array();
		// estado de la inserción de datos
		$estado = true;
		while(($datos = fgetcsv($fichero, 100)) !== FALSE)
		{
			// condicion para omitir la primera y ultima fila
			if ($cont > 0 && $cont < $filas - 1) {
				if ($cont % 2 != 0) {
					$arreglo = array(
						'ficha_predial' => $this->input->post('ficha'),
						'punto' => $datos[0],
						'x' => $datos[1],
						'y' => $datos[2],
						'distancia' => NULL
					);
				} else {
					$arreglo = array(
						'ficha_predial' => $this->input->post('ficha'),
						'punto' => $datos[0],
						'x' => NULL,
						'y' => NULL,
						'distancia' => $datos[3]
					);
				}
				array_push($contenido, $arreglo);
			}
			$cont++;
		}
		// si no se inserto correctamente la coordenada devuelve false
		if (!$this->accionesDAO->insertar_coordenadas($contenido)) { $estado = false; }
		echo $estado;
	}

	// genera un kml con 1 o mas unidades funcionales y por predio
	
function generar_kml()
	{
		#accion de auditoria
		$auditoria = array(
			'fecha_hora' => date('Y-m-d H:i:s', time()),
			'id_usuario' => $this->session->userdata('id_usuario'),
			'descripcion' => 'Genera archivo kml'
		);

		$this->db->insert('auditoria', $auditoria);

		$this->load->model(array("accionesDAO", "InformesDAO"));
		$this->convencion_predio();
		$unidades_funcionales = $this->uri->segment(3);
		$unidades_list = array();

		if (strpos($unidades_funcionales, 'F') == true) {
			$ficha = $unidades_funcionales;
			$this->data['nombre_archivo'] = $ficha;
			$unidad_list = array();
			$predio_list = array();
			$corGeo = array();
			$corMagna = $this->accionesDAO->consultar_coordenadas($ficha);
			$predio_info = $this->InformesDAO->obtener_informe_gestion_predial_ani($ficha);
			$proj4 = new Proj4php();
			$projMagna = new Proj('EPSG:3116', $proj4);
			$projWGS84 = new Proj('EPSG:4326', $proj4);
			$xSum = 0;
			$ySum = 0;
			// predio
			foreach ($corMagna as $coordenada) {
				if ($coordenada->x != NULL) {
					$pointSrc = new Point($coordenada->x, $coordenada->y, $projMagna);
					$pointDest = $proj4->transform($projWGS84, $pointSrc);
					$corXY = explode(" ", $pointDest->toShortString());
					$corXY = array("punto"=>$coordenada->punto, "x"=> $corXY[0], "y"=>$corXY[1]);
					array_push($corGeo, $corXY);
					$xSum += (float)$coordenada->x;
					$ySum += (float)$coordenada->y;
				}
			}
			$puntos = (float)explode(" ", $coordenada->punto)[0];
			$pointSrc = new Point($xSum/$puntos, $ySum/$puntos, $projMagna);
			$pointDest = $proj4->transform($projWGS84, $pointSrc);
			$corXY = explode(" ", $pointDest->toShortString());

			$area = array(
				'x' => $corXY[0],
				'y' => $corXY[1],
			);
			array_push($predio_list, $predio_info);
			array_push($predio_list, $corGeo);
			array_push($predio_list, $area);

			array_push($unidad_list, $predio_list);

			array_push($unidades_list, $unidad_list);
			$this->data["unidades_funcionales"] = $unidades_list;
			$this->load->view('plantillas/kml-plantilla', $this->data);
			return 1;
		}
		// esta linea separa los numeros de las unidades funcionales
		$unidades_funcionales = preg_split("/[\s.]+/", $unidades_funcionales);
		$this->data['nombre_archivo'] = 'Mapa';
		// unidades funcionales
		foreach ($unidades_funcionales as $unidad) {

			$this->data['nombre_archivo'] .= ''.$unidad.'-';
			$unidad_funcional = $this->accionesDAO->consultar_ficha_por_unidad_funcional($unidad);
			$unidad_list = array();
			//unidad funcional
			foreach ($unidad_funcional as $predio) {
				$predio_list = array();
				$corMagna = $this->accionesDAO->consultar_coordenadas($predio->ficha_predial);
				$predio_info = $this->InformesDAO->obtener_informe_gestion_predial_ani($predio->ficha_predial);
				$corGeo = array();
				$proj4 = new Proj4php();
				$projMagna = new Proj('EPSG:3116', $proj4);
				$projWGS84 = new Proj('EPSG:4326', $proj4);
				$xSum = 0;
				$ySum = 0;
				// predio
				foreach ($corMagna as $coordenada) {
					if ($coordenada->x != NULL) {
						$pointSrc = new Point($coordenada->x, $coordenada->y, $projMagna);
						$pointDest = $proj4->transform($projWGS84, $pointSrc);
						$corXY = explode(" ", $pointDest->toShortString());
						$corXY = array("punto"=>$coordenada->punto, "x"=> $corXY[0], "y"=>$corXY[1]);
						array_push($corGeo, $corXY);
						$xSum += (float)$coordenada->x;
						$ySum += (float)$coordenada->y;
					}
				}
				//se calcula el punto medio del predio
				$puntos = (float)explode(" ", $coordenada->punto)[0];
				$pointSrc = new Point($xSum/$puntos, $ySum/$puntos, $projMagna);
				$pointDest = $proj4->transform($projWGS84, $pointSrc);
				$corXY = explode(" ", $pointDest->toShortString());

				$area = array(
					'x' => $corXY[0],
					'y' => $corXY[1],
				);
				array_push($predio_list, $predio_info);
				array_push($predio_list, $corGeo);
				array_push($predio_list, $area);
				array_push($unidad_list, $predio_list);
			}
			if (!empty($unidad_list)) {
				array_push($unidades_list, $unidad_list);
			}
		}
		$this->data["unidades_funcionales"] = $unidades_list;
		$this->load->view('plantillas/kml-plantilla', $this->data);
	}

	

	function convencion_predio() {
		$this->load->model(array("PrediosDAO"));
		$vias = $this->PrediosDAO->obtener_estados_via_actuales();
		$procesos = $this->PrediosDAO->obtener_procesos_actuales();

		$width = 215;
		$height = 400;

		// Se crea la imagen
		$im = imagecreatetruecolor($width, $height);
		// colores
		$black = imagecolorallocate($im, 0, 0, 0);
		$white = imagecolorallocate($im, 255, 255, 255);

		// fondo de la imagen
		imagefill($im, 0, 0, $white);
		// Titulo
		$titulo = 'Convenciones';
		// Fuente
		$font = 'site_predios/fonts/arial.ttf';
		$bold = 'site_predios/fonts/arial_bold.ttf';

		// Titulo
		$posX = $width - $width * 0.77;
		$posY = 20;
		// Escribe titulo
		imagettftext($im, 13, 0, $posX, $posY, $black, $bold, $titulo);
		// linea separadora
		imagefilledrectangle($im, 0, $posY + 10, $width, $posY + 10, $black);

		// Estado de las vias
		$posX = $width - $width * 0.73;
		$posY = $height - $height * 0.87;
		imagettftext($im, 9, 0, $posX , $posY, $black, $bold, 'Estado de las vias');
		$posX = $width - $width * 0.8;
		$posY = $height - $height * 0.8;

		// Estado de las vias sin estado
		imagefilledrectangle($im, $posX - 50, $posY - 6, $posX - 19, $posY - 2, $black);
		imagefilledrectangle($im, $posX - 50, $posY - 5, $posX - 20, $posY - 3, $white);
		imagettftext($im, 7, 0, $posX , $posY, $black, $font, 'Sin estado');
		$posY += 15;
		// lista estado de las vias
		foreach ($vias as $via) {
			$color = imagecolorallocate($im, hexdec(substr($via->color, 0, 2)), hexdec(substr($via->color, 2, 2)), hexdec(substr($via->color, 4, 2)));
			imagefilledrectangle($im, $posX - 50, $posY - 5, $posX - 20, $posY - 3, $color);
			imagettftext($im, 7, 0, $posX , $posY, $black, $font, $via->nombre);
			$posY += 15;
		}
		// Linea separadora
		imagefilledrectangle($im, 0, $posY, $width, $posY, $black);

		// Estado del proceso
		$posX = $width - $width * 0.78;
		$posY = $posY + 20;
		imagettftext($im, 9, 0, $posX - 10 , $posY, $black, $bold, 'Estado de los procesos');
		$posX = $width - $width * 0.8;
		$posY = $posY + 30;

		// Estado del proceso sin estado
		imagefilledrectangle($im, $posX - 50, $posY - 10, $posX - 20, $posY, $black);
		imagefilledrectangle($im, $posX - 50, $posY - 9, $posX - 21, $posY - 1, $white);
		imagettftext($im, 7, 0, $posX - 10 , $posY, $black, $font, 'Sin estado');
		$posY += 17;
		// lista de estados proceso
		foreach ($procesos as $proceso) {
			$color = imagecolorallocate($im, hexdec(substr($proceso->color, 0, 2)), hexdec(substr($proceso->color, 2, 2)), hexdec(substr($proceso->color, 4, 2)));
			imagefilledrectangle($im, $posX - 50, $posY - 10, $posX - 20, $posY, $color);
			imagettftext($im, 7, 0, $posX - 10 , $posY, $black, $font, $proceso->estado);
			$posY += 15;
		}

		// Se guarda la imagen
		imagepng($im, 'img/convenciones.png');
		// se elimina el buffer
		imagedestroy($im);
	}

	// ver archivos del area social
	function ver_archivos_social() {
		$this->load->model("accionesDAO");
		$id = $this->input->get('id');
		$ficha = $this->input->get('ficha');
		$tipo = $this->input->get('tipo');
		$aux = $this->input->get('aux');

		$this->data['id'] = $id;
		$this->data['ficha'] = $ficha;
		$this->data['tipo'] = $tipo;
		$this->data['archivos'] = $this->accionesDAO->consultar_archivo($ficha, $tipo, 1, $id);
		$this->data['directorio'] = $this->ruta_archivos.$ficha.'/'.$this->nombre_carpeta_archivos_social;
		$this->data['titulo_pagina'] = "Archivos - ficha predial $ficha";
		$this->data['contenido_principal'] = 'archivos/archivos_social_view';
		$this->load->view('archivos/vista_auxiliar', $this->data);
	}

	function subir_archivos_social() {
		$this->load->model("accionesDAO");
		$ficha = $this->input->post("ficha");

		$permisos = $this->session->userdata('permisos');
		if ( ! isset($permisos['Archivos y Fotos']['Subir']) ) {
			$this->session->set_flashdata('error', 'Usted no cuenta con permisos para subir fotos.');
			redirect('');
		} // if

		//si la ficha no existe
		if(!$ficha)
		{
			redirect('actualizar_controller');
		}
		else
		{
			// si la carpeta con el nombre de la ficha no existe se crea
			if( ! is_dir($this->ruta_archivos.$ficha) )
			{
				@mkdir($this->ruta_archivos.$ficha, 0777);
			}

			// si la carpeta archivos_social no existe se crea
			if( ! is_dir($this->ruta_archivos.$ficha.'/'.$this->nombre_carpeta_archivos_social) )
			{
				@mkdir($this->ruta_archivos.$ficha.'/'.$this->nombre_carpeta_archivos_social, 0777);
			}
		}

		//Se almacena la fecha
        $fecha = date("Ymd-His");
		$directorio = $this->ruta_archivos.str_replace(' ','_', $ficha).'/'.$this->nombre_carpeta_archivos_social;
		$archivo = $_FILES['userfile']['tmp_name'];
		$nombre = $fecha.'.'.$extension = end(explode(".", $_FILES['userfile']['name']));
		// Si el fichero existe
	    if (file_exists($directorio.$nombre)) {
	        echo "existe";
	    // Si se sube corectamente
		} else if(move_uploaded_file($archivo, $directorio.'/'.$nombre)) {
	    	// Se prepara el arreglo con el que se guarda los datos de la foto
			// si el tipo es 3 se registra en el campo unidad social residente sino en la unidad social productiva
			$id = ($this->input->post("tipo") == 3) ? "id_usr" : "id_usp";
			$id_valor = ($this->input->post("id") == 0) ? NULL : $this->input->post("id");

	    	$datos = array(
				"archivo" => $nombre,
				"categoria" => 1,
	    		"descripcion" => $this->input->post("descripcion"),
				"fecha" => $this->input->post("fecha"),
	    		"ficha_predial" => $this->input->post("ficha"),
				"tipo" => $this->input->post("tipo"),
				$id => $id_valor
			);

			// Si se guarda el registro en base de datos correctamente
			if ($this->accionesDAO->guardar_archivo_social($datos)) {
				echo true;
			}
		}
	}
	// eliminar archivo area social
	function eliminar_archivo_social(){
		$this->load->model("accionesDAO");

		// Se borra el archivo del servidor
        if(unlink($this->input->post('archivo'))){
        	// Se elimina el registro de la base de datos
        	echo $this->accionesDAO->eliminar_foto($this->input->post('nombre'));

			// Se retorna verdadero
			// echo true;
        } // if
	}
}
/* End of file archivos_controller.php */
/* Location: ./site_predios/application/controllers/archivos_controller.php */
