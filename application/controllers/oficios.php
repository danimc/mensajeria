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
        $datos['usuario'] = $usuario;
        $datos['oficios'] = $this->m_oficios->obt_LibroOficios();

        $this->load->view('_encabezado1');
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
        $consecutivo = $max->cons + 1;
        $nOficio = 'OAG/' . $consecutivo . '/' . date('Y');

        $oficio = array(
        'consecutivo'       => $consecutivo,
        'oficio'            => $nOficio,
        'folio'             => $this->input->post('folio'),
        'servicio'          => $_POST['ticket'],
        'oficioRecibido'    => $_POST['oficioRecibido'],
        'destinatario'      => $_POST['destinatario'],
        'cargo'             => $_POST['cargo'],
        'ccp'               => $_POST['ccp'],
        'redaccion'         => $_POST['redaccion'],
        'fecha_realizado'   => $this->m_ticket->fecha_actual(),
        'hora_realizado'    => $this->m_ticket->hora_actual(),
        'estatus'           => 1,
        'tipo'              => $_POST['tipoOficio'],
        'capturista'        => $this->session->userdata("codigo")
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

    function guardar_captura()
    {
        $oficio = array(
                        'consecutivo'             => $this->input->post('oficio'),
                        'year'                    => date('Y'),
                        'fecha_captura'           => $this->m_ticket->fecha_actual(),
                        'hora_captura'            => $this->m_ticket->hora_actual(),
                        'solicitante'             => $this->session->userdata('codigo'),
                        'dependencia_solicitante' => $this->session->userdata('dependencia'),
                        'receptor'                => $this->input->post('responsable'),
                        'dependencia_receptor'    => $this->input->post('dependencia'),
                        'asunto'                  => $this->input->post('asunto'),
                        'estatus'                 => 1,
                        'exp'                     => $this->input->post('exp')
                );
        
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


    




}
