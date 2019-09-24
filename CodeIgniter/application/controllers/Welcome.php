<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public $empresa;
	public $description;
	public $titulo;


	public function __construct()
	{
		parent::__construct();
	}



	/**
	 * Register the filter in the session
	 */
	public function index($page = 1)
	{
		$echoedShout = "";
		// check to see if we should start prg
		if (count($_POST) > 0) {
			TSession::setValue('POST', $_POST);

			header("HTTP/1.1 303 See Other");
			header("Location: " . site_url('Welcome/index/1'));
			die();
		} else
		if (TSession::getValue('POST')) {
			$_POST   = TSession::getValue('POST');

			// clear session filters
			// define the filter field
			$filters = array();
			TSession::setValue('ProyUnsa_filters_data', array());
			TSession::setValue('ProyUnsa_estado', '');
			TSession::setValue('ProyUnsa_principal', '');
			TSession::setValue('ProyUnsa_integrantes', '');
			TSession::setValue('ProyUnsa_id_esquema_finan', array());
			TSession::setValue('ProyUnsa_id_area_prioritaria',  array());
			TSession::setValue('ProyUnsa_id_convocatoria',  array());
			TSession::setValue('ProyUnsa_titulo', '');
			TSession::setValue('ProyUnsa_id_anio', '');
			//TSession::setValue('ProyUnsa_limit', '');
			// check if the user has filled the form

			$anio = (isset($_POST['id_anio'])) ? $_POST['id_anio'] : '';
			if ($anio) {
				TSession::setValue('ProyUnsa_id_anio', $anio);

				if ($anio != "0") {
					// creates a filter using what the user has typed
					$filter = new TFilter('id_anio', '=', $anio);
					$filters[] = $filter;
				}
			}

			$estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';
			if ($estado) {

				TSession::setValue('ProyUnsa_estado', $estado);

				if ($estado != "A") {
					if ($estado == "E") {
						$criteria = new TCriteria;

						// creates a filter using what the user has typed
						$filter   = new TFilter('est_proy', '=', "$estado");
						$criteria->add($filter, TExpression::OR_OPERATOR);

						// creates a filter using what the user has typed
						$filter   = new TFilter('est_proy', '=', "O");
						$criteria->add($filter, TExpression::OR_OPERATOR);

						// creates a filter using what the user has typed
						$filter   = new TFilter('est_proy', '=', "V");
						$criteria->add($filter, TExpression::OR_OPERATOR);

						// creates a filter using what the user has typed
						$filter   = new TFilter('est_proy', '=', "T");
						$criteria->add($filter, TExpression::OR_OPERATOR);

						$filters[] = $criteria;
					} else {
						// creates a filter using what the user has typed
						$filter = new TFilter('est_proy', '=', "$estado");
						// stores the filter in the session
						$filters[] = $filter;
					}
				}
			}



			$titulo = (isset($_POST['titulo'])) ? $_POST['titulo'] : '';

			if ($titulo) {
				// creates a filter using what the user has typed
				$filter = new TFilter('busqueda_integrantes', 'Like', "%" . strtoupper($titulo) . "%");
				// stores the filter in the session

				TSession::setValue('ProyUnsa_integrantes', $titulo);
				$filters[] = $filter;

				// creates a filter using what the user has typed
				$filter = new TFilter('busqueda_principal', 'Like', "%" . strtoupper($titulo) . "%");
				// stores the filter in the session
				TSession::setValue('ProyUnsa_principal', $titulo);
				$filters[] = $filter;

				// creates a filter using what the user has typed
				$filter = new TFilter('busqueda_nomb_proy', 'Like', "%" . strtoupper($titulo) . "%");
				// stores the filter in the session
				TSession::setValue('ProyUnsa_titulo', $titulo);
				$filters[] = $filter;
			}

			$esquemas = (isset($_POST['esquema'])) ? $_POST['esquema'] : '';

			if ($esquemas) {
				$criteria = new TCriteria;

				// stores the filter in the session
				TSession::setValue('ProyUnsa_id_esquema_finan', $esquemas);

				foreach ($esquemas as $item) {
					// creates a filter using what the user has typed
					$filter = new TFilter('id_esquema_finan', '=', "$item");
					$criteria->add($filter, TExpression::OR_OPERATOR);
				}

				$filters[] = $criteria;
			}

			$areas = (isset($_POST['area'])) ? $_POST['area'] : '';
			if ($areas) {
				$criteria = new TCriteria;

				// stores the filter in the session
				TSession::setValue('ProyUnsa_id_area_prioritaria', $areas);

				$empty    = false;
				foreach ($areas as $item) {
					if ($item == "0") {
						$empty = true;
						break;
					}

					// creates a filter using what the user has typed
					$filter = new TFilter('id_area_prioritaria', '=', "$item");
					// stores the filter in the session
					$criteria->add($filter, TExpression::OR_OPERATOR);
				}

				if (!$empty) {
					$filters[] = $criteria;
				}
			}

			$convocatorias = $this->input->post('convocatoria');
			if ($convocatorias) {
				$criteria = new TCriteria;
				// stores the filter in the session
				TSession::setValue('ProyUnsa_id_convocatoria', $convocatorias);

				foreach ($convocatorias as $item) {
					// creates a filter using what the user has typed
					$filter = new TFilter('id_convocatoria', '=', "$item");
					$criteria->add($filter, TExpression::OR_OPERATOR);
				}

				$filters[] = $criteria;
			}

			// fill the form with data again
			TSession::setValue('ProyUnsa_filter_data', $_POST);

			// keep the search data in the session
			TSession::setValue('ProyUnsa_filters_data', $filters);





			$param = array();

			$param['order'] = 'id';
			$param['direction'] = 'desc';

			$order = (isset($_POST['order'])) ? $_POST['order'] : '';
			if ($order) {
				TSession::setValue('ProyUnsa_order', $order);
				$order_allowed = array('principal/asc', 'principal/desc', 'nomb_proy/desc', 'nomb_proy/asc');
				if (in_array($order, $order_allowed)) {
					$order = explode('/', $order);
					$param['order'] = $order[0];
					$param['direction'] = $order[1];
				}
			} elseif (TSession::getValue('ProyUnsa_order')) {
				$order = explode('/', TSession::getValue('ProyUnsa_order'));
				$param['order'] = $order[0];
				$param['direction'] = $order[1];
			}

			$param['limit'] = '25';
			$param['first_page'] = 1;
			$param['page'] = $page;

			$limit = (isset($_POST['limit'])) ? $_POST['limit'] : '';
			if ($limit) {
				TSession::setValue('ProyUnsa_limit', $limit);
				if (is_scalar($limit)) {
					if (in_array($limit, array('25', '100', '50'))) {
						$param['limit'] = $limit;
					} else {
						$param['limit'] = '25';
					}
				}
			} elseif (TSession::getValue('ProyUnsa_limit')) {
				$param['limit'] = TSession::getValue('ProyUnsa_limit');
			}

			$param['offset'] = ($page - 1) * $param['limit'];

			//TSession::setValue('param',$param);

			//$echoedShout = $_SESSION['shout'];

			/*
			Put database-affecting code here.
			*/

			//session_unset();
			//session_destroy();
		}

		$objects       = $this->onReload($param);
		$convocatorias = $this->convocatorias();

		$param['criterios'] = $objects['criterios'];
		$param['rows'] = $objects['count'];
		$data['proyectos'] = $objects['objects'];
		$data['param'] = $param;

		$data['esquemas'] = $convocatorias;
		$data['titulo'] = 'Vicerrectorado de Investigación - Universidad Nacional de San Agustín de Arequipa';

		$this->load->view('buscador', $data);
	}


	/**
	 * Load the datagrid with data
	 */
	public function onReload($param = NULL)
	{
		try {
			// open a transaction with database 'database'
			TTransaction::open('database');

			// creates a repository for BlogCategoria
			$repository = new TRepository('ViewPublication');
			$limit      = $param['limit'];
			// creates a criteria
			$criteria   = new TCriteria;

			// default order
			if (empty($param['order'])) {
				$param['order'] = 'id';
				$param['direction'] = 'desc';
			}
			$criteria->setProperties($param); // order, offset
			$criteria->setProperty('limit', $limit);


			if (TSession::getValue('ProyUnsa_filters_data')) {
				foreach (TSession::getValue('ProyUnsa_filters_data') as $filter) {
					if ($filter instanceof TFilter) {
						//echo $filter->variable;
						// add the filter stored in the session to the criteria
						$criteria->add($filter, TExpression::OR_OPERATOR);
					}

					if ($filter instanceof TCriteria) {
						//echo $filter->variable;
						// add the filter stored in the session to the criteria
						$criteria->add($filter);
					}
				}
			}

			//echo $criteria->dump();

			// load the objects according to criteria
			$objects = $repository->load($criteria, FALSE);

			// reset the criteria for record count
			$criteria->resetProperties();
			$count = $repository->count($criteria);

			//$this->pageNavigation->setCount($count); // count of records
			//$this->pageNavigation->setProperties($param); // order, page
			//$this->pageNavigation->setLimit($limit); // limit

			// close the transaction
			TTransaction::close();

			$array = array();
			$array['criterios'] = $criteria->dump();
			$array['objects'] = $objects;
			$array['count'] = $count;
			$array['order'] = $param['order'];
			$array['direction'] = $param['direction'];
			$array['limit'] = $limit;

			return $array;
		} catch (Exception $e) // in case of exception
		{
			// shows the exception error message
			echo  $e->getMessage();

			// undo all pending operations
			TTransaction::rollback();
		}
	}


	public function view($slug = FALSE)
	{
		if ($slug != FALSE && is_scalar($slug)) {

			try {
				// open a transaction with database 'database'
				TTransaction::open('database');

				// creates a repository for BlogCategoria
				$proyecto = new ViewPublication($slug);
				$data['proyecto'] = $proyecto;
				$data['financiamiento'] = '';

				$repository      = new TRepository('ViewProyectoFinanciamiento');
				$criteria        = new TCriteria;
				$criteria->add(new TFilter('id', '=', $proyecto->id));
				$financiamientos = $repository->load($criteria);

				foreach ($financiamientos as $financiamiento) {
					$data['financiamiento'] = number_format($financiamiento->mont_finan_mone, 2, '.', ' ');
					break;
				}

				$data['integrantes'] = $this->integrantes($slug);


				$this->actualizar_visitas($slug);


				$this->load->view('proyecto', $data);

				// close the transaction
				TTransaction::close();
			} catch (Exception $e) // in case of exception
			{
				// shows the exception error message
				echo  $e->getMessage();
				// undo all pending operations
				TTransaction::rollback();
			}
		}
	}


	private function actualizar_visitas($id)
	{
		try {
			// open a transaction with database 'database'
			TTransaction::open('database');

			$proyecto_contador = new ProyectosContador($id);
			$proyecto_contador->visitas = $proyecto_contador->visitas + 1;
			$proyecto_contador->store();

			// close the transaction
			TTransaction::close();
		} catch (Exception $e) // in case of exception
		{
			$proyecto_contador = new ProyectosContador;
			$proyecto_contador->id = $id;
			$proyecto_contador->visitas = 1;
			$proyecto_contador->store();
			TTransaction::close();
		}
	}




	public function resumen($slug = FALSE)
	{
		header('Content-Type: application/json');

		$json = array();

		if ($slug != FALSE && is_scalar($slug)) {
			try {
				// open a transaction with database 'database'
				TTransaction::open('database');

				// creates a repository for BlogCategoria
				$proyecto = new ViewPublication($slug);

				$json['data'][]['resumen'] = $proyecto->title;
				echo json_encode($json);

				// close the transaction
				TTransaction::close();
			} catch (Exception $e) // in case of exception
			{
				// shows the exception error message
				$json['data'][]['resumen'] = $e->getMessage();
				echo json_encode($json);

				// undo all pending operations
				TTransaction::rollback();
			}
		} else {
			$json['data'][]['resumen'] = "Error desconocido.";
			echo json_encode($json);
		}
	}

	private function integrantes($id)
	{ }

	private function convocatorias()
	{
		try {
			TTransaction::open('database'); // open transaction
			$conn          = TTransaction::get(); // get PDO connection

			// run query
			$result        = $conn->query(' SELECT convocatoria.id_esquema_finan,
    esquema_finan.nomb_esq_finan,
    convocatoria.id_convocatoria,
    convocatoria.nomb_conv
   FROM (bytsscom_bytsig.convocatoria
     JOIN bytsscom_bytsig.esquema_finan ON ((convocatoria.id_esquema_finan = esquema_finan.id_esquema_finan)))
  WHERE ((convocatoria.id_convocatoria <> 115) AND (convocatoria.id_convocatoria <> 126))
  ORDER BY convocatoria.id_esquema_finan, convocatoria.id_convocatoria');

			$convocatorias = array();
			// show results
			foreach ($result as $row) {
				$convocatorias[$row['id_esquema_finan'] . ".." . $row['nomb_esq_finan']][$row['id_convocatoria']] = $row['nomb_conv'];
			}
			TTransaction::close(); // close transaction


			return $convocatorias;
		} catch (Exception $e) {
			TTransaction::close(); // close transaction
			echo  $e->getMessage();
		}
	}



	public function test()
	{
		echo VIEWPATH;
	}



	public function clear()
	{
		$CI         = &get_instance();
		$path       = $CI->config->item('cache_path');

		$cache_path = ($path == '') ? APPPATH . 'cache/' : $path;

		$handle     = opendir($cache_path);
		while (($file = readdir($handle)) !== false) {
			//Leave the directory protection alone
			if ($file != '.htaccess' && $file != 'index.html') {
				@unlink($cache_path . '/' . $file);
			}
		}
		closedir($handle);
	}


	public function error_404()
	{
		$data['titulo'] = $this->titulo;
		$data['description'] = $this->description;
		$data['site_name'] = $this->empresa;
		$data['img'] = $this->img;


		$data['contenido'] = $this->load->view('error_404', $data, true);
		$this->load->view('layout', $data);
	}

	public function cargar_imagenes($slug = FALSE)
	{
		header('Content-Type: application/json');

		$json = array();

		if ($slug != FALSE && is_scalar($slug)) {
			try {
				// open a transaction with database 'database'
				TTransaction::open('database');

				// creates a repository for BlogCategoria

				$proyecto = new ViewMedia($slug);

				$conn          = TTransaction::get(); // get PDO connection

				// run query
				$repository      = new TRepository('ViewMedia');
				$criteria        = new TCriteria;
				$criteria->add(new TFilter('id_publication', '=', $slug));
				$criteria->add(new TFilter('type', '=', 'jpg'));
				$recursos = $repository->load($criteria);
				$i=0;
				foreach ($recursos as $recurso) {
					$json['data'][$i]['resumen'] = $recurso->path;
					$i++;
				}
				//$json['data'][]['resumen'] = $proyecto->path;
				echo json_encode($json);

				// close the transaction
				TTransaction::close();
			} catch (Exception $e) // in case of exception
			{
				// shows the exception error message
				$json['data'][]['resumen'] = $e->getMessage();
				echo json_encode($json);

				// undo all pending operations
				TTransaction::rollback();
			}
		} else {
			$json['data'][]['resumen'] = "Error desconocido.";
			echo json_encode($json);
		}

		exit;
	}
}
