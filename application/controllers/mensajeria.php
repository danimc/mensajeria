<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mensajeria extends CI_Controller {
	
	 function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('m_seguridad',"",TRUE);
		$this->load->model('m_usuario',"",TRUE);
		$this->load->model('m_mensajeria',"",TRUE);
		$this->load->model('m_correos',"",TRUE);

		$ci = get_instance();	
		$this->ftp_ruta = $ci->config->item("f_ruta");
		$this->dir = $ci->config->item("oficios");
	}

	public function index()
	{
		$this->load->view('_encabezado');

	}

	function nueva_copia()
	{
		$codigo = $this->session->userdata("codigo");	
		$datos['usuario'] = $this->m_usuario->obt_usuario($codigo);
		$datos['reportante'] = $this->m_mensajeria->obt_lista_usuarios();
		$datos['categorias'] = $this->m_mensajeria->obt_categorias();
		$datos['centros'] = $this->m_mensajeria->obt_centros();

		$this->load->view('_encabezado1');
		$this->load->view('_menuLateral1');
		$this->load->view('formularios/v_nuevo_ticket', $datos);
		$this->load->view('_footer1');
	}

		function nueva_mensajeria()
	{

		$ccp = $_POST["ccp"];
		$codigo = $this->session->userdata("codigo");	
		$oficio = $_POST['oficio'];
		$siglas = $this->m_mensajeria->obt_abreviatura($codigo);
		$nPdf = '';
		$dependenciaEnvia = $siglas->id_dependencia;
		if($_FILES['documento']['name'] != "")
		{
			$this->load->library('image_lib');			
			$ext = explode('.',$_FILES['documento']['name']);
			$ext = $ext[count($ext) - 1];
			$numOficio = explode('/', $oficio);
			$pdf = $siglas->abreviatura . $numOficio[count($numOficio) - 2] .'-'. $numOficio[count($numOficio) - 1];			
			move_uploaded_file($_FILES['documento']['tmp_name'], $this->ftp_ruta . 'src/oficios/' . $pdf .'.' . $ext);	
			$config_image['image_library'] = 'gd2';
			$config_image['source_image'] = $this->ftp_ruta . 'src/oficios/doc_'. $pdf .'.'. $ext;
			$config_image['maintain_ratio'] = true;
			$config_image['quality'] = 98;
			$this->image_lib->initialize($config_image);
			$this->image_lib->resize(); 
			return $ext;

			$nPdf = $pdf .'.' . $ext;
		} 
		
	    $this->m_mensajeria->nuevo_incidente($reportante, $usuarioIncidente, $titulo, $descripcion, $categoria, $estatus, $prioridad);
		//$idIncidente = $this->db->insert_id();

		//$this->m_mensajeria->noti_alta($reportante, $usuarioIncidente, $idIncidente, $notificacion);

		//redirect('ticket/correo_ticket_levantado/'. $idIncidente);
	}

	function lista_tickets_cerrados()
	{
		$codigo = $this->session->userdata("codigo");
		$rol = $this->session->userdata("rol");
		$folio = $this->uri->segment(3);
		$datos['usuario'] = $this->m_usuario->obt_usuario($codigo);
		$datos['folio'] = $folio;
		$datos['titulo'] = "CERRADOS";

				$datos['tickets'] = $this->m_mensajeria->lista_tickets_administrador_cerrados();
				$this->load->view('_encabezado1');
				$this->load->view('_menuLateral1');
				$this->load->view('listas/l_tickets_admin', $datos);
				$this->load->view('_footer1');

				
	}

		function lista_tickets_abiertos()
	{
		$codigo = $this->session->userdata("codigo");
		$rol = $this->session->userdata("rol");
		$folio = $this->uri->segment(3);
		$datos['usuario'] = $this->m_usuario->obt_usuario($codigo);
		$datos['folio'] = $folio;
		$datos['titulo'] = "ATENDIENDO";

				$datos['tickets'] = $this->m_mensajeria->lista_tickets_administrador_abiertos();
				$this->load->view('_encabezado1');
				$this->load->view('_menuLateral1');
				$this->load->view('listas/l_tickets_admin', $datos);
				$this->load->view('_footer1');
				
	}

	function lista_tickets()
	{	
		
		$codigo = $this->session->userdata("codigo");
		$rol = $this->session->userdata("rol");
		$folio = $this->uri->segment(3);
		$datos['usuario'] = $this->m_usuario->obt_usuario($codigo);
		$datos['folio'] = $folio;
		$datos['titulo'] = "COMPLETA";

		switch ($rol) {
			case 1:
				
				$datos['tickets'] = $this->m_mensajeria->lista_tickets_administrador();
				$this->load->view('_encabezado1');
				$this->load->view('_menuLateral1');
				$this->load->view('listas/l_tickets_admin', $datos);
				$this->load->view('_footer1');

				break;
			case 2:
				$datos['tickets'] = $this->m_mensajeria->lista_tickets_usuario($codigo);
				$this->load->view('_encabezado1');
				$this->load->view('_menuLateral1');
				$this->load->view('listas/l_tickets_usuarios', $datos);
				$this->load->view('_footer1');
				break;
		}		
	}

	function seguimiento()
	{
		$folio = $this->uri->segment(3);
		$rol = $this->session->userdata("rol");
		$datos['folio'] = $folio;
		$datos['ticket'] = $this->m_mensajeria->seguimiento_ticket($folio);
		$datos['asignados'] = $this->m_mensajeria->obt_asignados();
		$datos['categorias'] = $this->m_mensajeria->obt_categorias();
		$datos['seguimiento'] = $this->m_mensajeria->obt_seguimiento($folio);

		if ($rol == 1) {
			
				$this->load->view('_encabezado');
				$this->load->view('_menuLateral');
				$this->load->view('formularios/v_seguimiento_admin', $datos);
				$this->load->view('_footer');
				}
		else{
				$this->load->view('_encabezado');
				$this->load->view('_menuLateral');
				$this->load->view('formularios/v_seguimiento_usuario', $datos);
				$this->load->view('_footer');
				}
		


	}

	function asignar_usuario()
	{

		if($_POST['antAsignado'] == ''){
			$estatus = 2; 
		}else{
			$estatus = 7;
		}
		  $notificacion = 2;
		  $codigo = $this->session->userdata("codigo");	
		  $ingeniero = $_POST['ingeniero'];
		  $folio = $_POST['folio'];
		  $fecha= $this->m_mensajeria->fecha_actual();
		  $hora= $this->m_mensajeria->hora_actual();
		  $usr = $this->m_usuario->obt_usuario($codigo);

		  $this->m_mensajeria->asignar_usuario($folio, $ingeniero, $fecha, $hora, $estatus);
		  $this->m_mensajeria->h_asignar_usuario($folio, $ingeniero, $fecha, $hora, $estatus);
		

	    $msg = '<div class="alert alert-success"><p><i class="fa fa-check"></i>Se ha Asignado con Exito</p></div>';

 		  echo json_encode($msg);
	}

	function cambiar_categoria()
	{
		$categoria = $_POST['categoria'];
		$folio = $_POST['folio'];
		$antCategoria = $_POST['antCategoria'];
		$fecha= $this->m_mensajeria->fecha_actual();
		$hora= $this->m_mensajeria->hora_actual();

		$msg = new \stdClass();

		if ($categoria != $antCategoria) {
			$this->m_mensajeria->cambiar_categoria($folio, $categoria);
			$this->m_mensajeria->h_cambiar_categoria($folio, $categoria, $fecha, $hora);

			 $msg->id = 1;
			 $msg->mensaje = '<div class="alert alert-success"><p><i class="fa fa-check"></i> Se cambio la categoría</p></div>';
		}else{

			$msg->id = 2;
			$msg->mensaje = '<div class="alert alert-danger"><p><i class="fa fa-close"></i> Seleccionaste la categoría actual</p></div>';
			
		}

		echo json_encode($msg);
	}

	function cambiar_estatus()
	{
		$estatus = $_POST['estado'];
		$folio = $_POST['folio'];
		$antStatus = $_POST['antStatus'];
		$fecha= $this->m_mensajeria->fecha_actual();
		$hora= $this->m_mensajeria->hora_actual();

		$msg = new \stdClass();

		if ($estatus != $antStatus) {
			$this->m_mensajeria->cambiar_estatus($folio, $estatus);
			$this->m_mensajeria->h_cambiar_estatus($folio, $estatus, $fecha, $hora);

			 $msg->id = 1;
			 $msg->mensaje = '<div class="alert alert-success"><p><i class="fa fa-check"></i> Se cambio es estatus</p></div>';
		}else{

			$msg->id = 2;
			$msg->mensaje = '<div class="alert alert-danger"><p><i class="fa fa-close"></i> Ha seleccionado el mismo estado del Ticket</p></div>';
			
		}

		echo json_encode($msg);

	}

	function cerrar_ticket()
	{
		$folio = $_POST['folio'];
		$usr = $this->session->userdata("codigo");
		$fecha = $this->m_mensajeria->fecha_actual();
		$hora = $this->m_mensajeria->hora_actual();			

			$this->m_mensajeria->cerrar_ticket($folio, $fecha, $hora);
			$this->m_mensajeria->h_cerrar_ticket($folio, $usr, $fecha, $hora);			
			$this->m_correos->correo_ticket_cerrado($folio, $fecha, $hora);	

		$msg = new \stdClass();
		$msg->id = 1;
		$msg->mensaje = '<div class="alert alert-success"><p><i class="fa fa-check"></i>Ticket Cerrado Satisfactoriamente :)</p></div>';
 		echo json_encode($msg);

	    

		
	}

	function mensaje()
	{
		$folio = $_POST['folio'];
		$mensaje = $_POST['chat'];
		$fecha= $this->m_mensajeria->fecha_actual();
		$hora= $this->m_mensajeria->hora_actual();

		$this->m_mensajeria->mensaje($folio, $mensaje, $fecha, $hora);

		redirect('ticket/seguimiento/'. $folio .'/#chat');
	}


	function correo_ticket_levantado()
	{
		$incidente = $this->uri->segment(3);
		$infoCorreo = $this->m_mensajeria->seguimiento_ticket($incidente);
		$horario = $this->m_mensajeria->hora_actual();
		$saludo = '';

		if($horario <= '11:59:59'){
			$saludo = 'Buenos días';
		}
		elseif ($horario <= '19:59:59') {
			$saludo = 'Buenas tardes';
		}
		elseif ($horario <= '23:59:59') {
			$saludo = 'Buenas noches';
		}
		
		$datos['ticket'] = $infoCorreo;
		$datos['saludo'] = $saludo;		
	  //  $this->load->view('_head');
		$msg = $this->load->view('correos/c_nuevoTicket', $datos, true);

		$this->load->library('email');
		$this->email->from('incidenciasoag@gmail.com', 'incidenciasOAG');
		$this->email->to($infoCorreo->correo);
		$this->email->cc('incidenciasoag@gmail.com');
		//$this->email->bcc('them@their-example.com');

		$this->email->subject('Registro de Incidente | incidenciasOAG');
		$this->email->message($msg);
		$this->email->set_mailtype('html');
		$this->email->send();

		redirect('ticket/seguimiento/'. $incidente);

	//	echo $this->email->print_debugger();

	}

	
}