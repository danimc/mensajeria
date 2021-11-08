<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Oficios extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('m_seguridad', "", true);
        $this->load->model('m_usuario', "", true);
        $this->load->model('m_mensajeria', "", true);
        $this->load->model('m_oficios', "", true);
        $this->load->model('m_ticket', "", true);


    }

    public function index()
    {
        $codigo = $this->session->userdata("codigo");
        $usuario = $this->m_usuario->obt_usuario($codigo);
        $datos['years'] = $this->m_oficios->obtAniosRegistrados();
        $datos['usuario'] = $usuario;
        $head['title'] = "Control de Oficios";

        $this->load->view('_encabezado1', $head);
        $this->load->view('_menuLateral1');
        $this->load->view('v_inicioOficios', $datos);
        $this->load->view('_footer1');
    }

    function nuevo_oficio()
    {
        $codigo = $this->session->userdata("codigo"); 
        $datos['usuario'] = $this->m_usuario->obt_usuario($codigo);
        $datos['dependencias'] = $this->m_ticket->obt_dependencias();
        $datos['tipos'] = $this->m_oficios->obt_tipoOficios();
        $consecutivo = $this->m_oficios->obtMaxConsecutivo();
        $datos['consecutivo'] = $consecutivo->cons + 1;

        $this->load->view('_encabezado1');
        $this->load->view('_menuLateral1');
        $this->load->view('formularios/v_nuevo_oficio', $datos);
        $this->load->view('_footer1');  
    }

    function nueva_captura()
    {
        $consecutivo = $this->m_oficios->obtMaxConsecutivo();
        $codigo = $this->session->userdata("codigo"); 
        $datos['usuario'] = $this->m_usuario->obt_usuario($codigo);
        //$datos['dependencias'] = $this->m_ticket->obt_dependencias();
        $datos['tipos'] = $this->m_oficios->obt_tipoOficios();       
        $datos['centros'] = $this->m_mensajeria->obt_centros();
        $datos['consecutivo'] = $consecutivo->cons + 1;

        $this->load->view('_encabezado1');
        $this->load->view('_menuLateral1');
        $this->load->view('formularios/v_capturar_oficio', $datos);
        $this->load->view('_footer1');  
    }


    /**
     * Funcion para capturar un oficio nuevo en la base de datos
     * 
     * @return void
     */
    function capturarOficio()
    {

        $max = $this->m_oficios->obtMaxConsecutivo();
        $datosDependencia = $this->m_oficios->obtDatosDependencia($this->input->post('dependencia'));
        $consecutivo = $max->cons + 1;
        $nOficio = 'AG/' . $consecutivo . '/' . date('Y');

        $oficio = array(
        'consecutivo'       => $consecutivo,
        'oficio'            => $nOficio,     
        'destinatario'      => $_POST['destinatario'],
        'dependencia'       => $_POST['dependencia'],
        'nombreDependencia' => $datosDependencia->nombre,
        'cargo'             => $_POST['cargo'],       
        'redaccion'         => $_POST['asunto'],
        'fecha_realizado'   => $this->m_ticket->fecha_actual(),
        'hora_realizado'    => $this->m_ticket->hora_actual(),
        'estatus'           => 1,
        'exp'               => $_POST['exp'],
        'capturista'        => $this->session->userdata("codigo"),
        'unidadRemitente'   => $this->session->userdata("dependencia")
        );

        $oficio = array_filter($oficio);

        $verificador = $this->m_oficios->verifica_nuevoOficio($nOficio);
        if ($verificador == 0) {
            $this->m_oficios->capturarOficio($oficio);
            $idIncidente = $this->db->insert_id();
            if ($idIncidente != '') {
                // $this->subir_oficio($nOficio, $idIncidente, $consecutivo);
                redirect(base_url() . 'oficios?nOficio=' . $nOficio);
            }
        } else {
            $mensaje = 0;
            echo $mensaje;
        }
    }

    /**
     * Regresa el maximo consecutivo a la vista
     * 
     * @return json 
     */
    function obtConsecutivo()
    {
        $consecutivo = $this->m_oficios->obtMaxConsecutivo();
        $max = $consecutivo->cons + 1;

        echo json_encode($max);
    }

    /**
     * Regresa Json con la informacion de la Dependencia Externa
     * 
     * @return Json
     */
    function obtDatosDependencia()
    {
        $id = $this->input->get('id');

        echo json_encode($this->m_oficios->obtDatosDependencia($id));
    }


    
    function verifica_registroOficio()
    {
        $oficio = $_POST['oficio'];
        $verificador = $this->m_oficios->verifica_nuevoOficio($oficio);
        echo $oficio . 'esta ' . $verificador . ' veces... ';

        if ($verificador == 0 ) {
            echo "registrando";
            $this->guardar_captura();
        }
        else{
            echo " No se puede registrar el mismo numero de Oficio";
        }
    }

    /**
     * Vista de seguimiento del oficio 
     * 
     * @return view
     */
    function seguimiento()
    {
        $oficio = $this->uri->segment(3);

        $datos['id']        = $oficio;
        $datos['oficio']    = $this->m_oficios->obt_oficio($oficio);
        $datos['pdf']        = explode(".", $datos['oficio']->pdf);
        //    $datos['tipos']     = $this->m_oficios->obt_tipoOficios();
        $head['title']      = "Seguimiento del oficio ";

        $this->load->view('_encabezado1', $head);
        $this->load->view('_menuLateral1');
        $this->load->view('oficios/seguimiento', $datos);
        //$this->load->view('fragmentos/modales/oficios/mod_asociarTicket', $datos);
        //$this->load->view('oficios/v_edita_oficio', $datos);
        $this->load->view('_footer1');
    }

    function genera_PDF()
    {
        $this->load->library('mydompdf');
        $idOficio = $this->uri->segment(3);
        $data['oficio'] = $this->m_oficios->obt_datosOficio($idOficio);

        $html = $this->load->view('pdf/v_oficioPDF', $data, true);

        /*
         * load_html carga en dompdf la vista
         * render genera el pdf
         * stream ("nombreDelDocumento.pdf", Attachment: true | false)
         * true = forza a descargar el pdf
         * false = genera el pdf dentro del navegador
         */
         $this->mydompdf->load_html($html);
         $this->mydompdf->setPaper("Letter", "potrait");
         $this->mydompdf->render();
         $this->mydompdf->stream("ficha", array("Attachment" => false));
    }


    /**
     * Regresa la tabla de oficios por año de filtro
     * 
     * @return Json Tabla de datos 
     */
    function obt_oficios()
    {
        header('Content-Type: application/json');
        $year = $this->input->get('anio');
        $oficios =  $this->m_oficios->obt_oficios($year);
        $respuesta = array();
        $i = 0;

        
        
        foreach ($oficios as $t) {
            $fecha = $this->m_ticket->fecha_text_f($t->fecha_realizado);
            $estatus = $this->m_oficios->estatus($t->estatus);
           // $redaccion = $this->m_oficios->limitar_cadena($t->redaccion, 15);
                      
            $tabla = "<a class='fa fa-eye fa-2x text-warning' href='oficios/seguimiento/{$t->id}'></a>";
           
            $respuesta[$i] = array(
            'consecutivo'    => $t->consecutivo,
            'oficio'         => $t->oficio,
            'destinatario'   => $t->destinatario,
            'dependencia'    => $t->nombreDependencia,
            'fecha_cap'      => $fecha,
            'asunto'         => $t->redaccion,
            'exp'            => $t->exp,
            'dRemitente'     => $t->remitente,
            'estatus'        => $estatus,
            'acciones'        => $tabla
            );
            $i++;
        }

        echo json_encode($respuesta);
    }

    
    function editar_oficio()
    {
        $id        = $_POST['pk'];
        $campo     = $_POST['name'];
        $value     = $_POST['value'];

        $this->m_oficios->editarOficio($id, $campo, $value);
        
      //  $this->seguridad($id);
      
        echo json_encode($id);
    }

    




}
