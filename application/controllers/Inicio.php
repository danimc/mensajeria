<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('m_seguridad', "", true);
        $this->load->model('m_usuario', "", true);
        $this->load->model('m_inicio', "", true);
        $this->load->model('m_oficios', "", true);
    }

    /**
     * Vista incial de dasboard
     * 
     * @return view
     */
    public function index()
    {
        $codigo = $this->session->userdata("codigo");
        $usuario = $this->m_usuario->obt_usuario($codigo);    
        $datos['usuario'] = $usuario;
        $datos['total'] = $this->m_inicio->obt_contador_total();
        $datos['cerrados'] = $this->m_inicio->obt_contador_cerrados();
        $datos['abiertos'] = $this->m_inicio->obt_contador_abiertos(); 
        //  $datos['tGeneral'] = $this->m_inicio->tickets_pendientes_general();


        $this->load->view('_encabezado1');
        $this->load->view('_menuLateral1');
        $this->load->view('v_inicio', $datos);
        $this->load->view('_footer1');
    
    }

    function descargar_formatos()
    {
        $codigo = $this->session->userdata("codigo");    
        $this->load->view('_encabezado');
        $this->load->view('_menuLateral');
        $this->load->view('v_descargaFormatos');
        $this->load->view('_footer');    
    }

    /**
     * Retorna un array con los oficios que aun estan pendeintes de atencion.
     * 
     * @return Json
     */
    public function obtOficiosPendientes()
    {
        header('Content-Type: application/json');
        $area = $this->input->get("dep");

        $oficios = $this->m_oficios->obtOficiosPendientes($area);

        echo json_encode(
            [
            "area" => $area,
            "error" => false, 
            "result" => $oficios]
        );
        
    }


    public function noaccess()
    {
        $this->load->view('_head');
        $this->load->view('errors/_noaccess');
    }

}
