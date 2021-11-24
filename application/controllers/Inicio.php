<?php
defined('BASEPATH') or exit('No direct script access allowed');

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

    function descargarFormatos()
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
        $opciones = "";

        if ($area != 19 && $area != 20 && $area != 2) {
            $opciones =  "AND unidadRemitente = {$area} ";
        }

        // AREA 2 = Direccion
        if ($area == 2) {
            $opciones .= "AND Tb_Oficios.estatus = 2";
        }


        // area 20 = Mensajeria
        if ($area == 20) {
            $opciones .= "AND Tb_Oficios.estatus > 3 AND Tb_Oficios.estatus < 7 ";
        }

        $oficios = $this->m_oficios->obtOficiosPendientes($opciones);

        echo json_encode(
            [
                "area" => $area,
                "error" => false,
                "result" => $oficios
            ]
        );
    }

    /**
     * Vista para el area de direccion 
     * 
     * Permite firmar cambiar el estatus de los oficios a firmado
     * 
     * @return view
     */
    function paraFirma()
    {
        $codigo = $this->session->userdata("codigo");
        $usuario = $this->m_usuario->obt_usuario($codigo);
        $datos['years'] = $this->m_oficios->obtAniosRegistrados();
        $datos['usuario'] = $usuario;
        $head['title'] = "Para Firma";

        $this->load->view('_encabezado1', $head);
        $this->load->view('_menuLateral1');
        $this->load->view('acciones/firmados', $datos);
        $this->load->view('_footer1');
    }

    /**
     * Vista para el area de direccion 
     * 
     * Permite cambiar de estatus de mensajeria los oficios a firmado
     * 
     * @return view
     */
    function mensajeria()
    {
        $codigo = $this->session->userdata("codigo");
        $usuario = $this->m_usuario->obt_usuario($codigo);
        $datos['years'] = $this->m_oficios->obtAniosRegistrados();
        $datos['usuario'] = $usuario;
        $head['title'] = "Para Firma";

        $this->load->view('_encabezado1', $head);
        $this->load->view('_menuLateral1');
        $this->load->view('acciones/mensajeria', $datos);
        $this->load->view('_footer1');
    }


      /**
     * Vista para el area de direccion 
     * 
     * Permite cambiar de estatus de mensajeria los oficios a firmado
     * 
     * @return view
     */
    function reportes()
    {
        $codigo = $this->session->userdata("codigo");
        $usuario = $this->m_usuario->obt_usuario($codigo);
        $datos['years'] = $this->m_oficios->obtAniosRegistrados();
        $datos['usuario'] = $usuario;
        $head['title'] = "Para Firma";

        $this->load->view('_encabezado1', $head);
        $this->load->view('_menuLateral1');
        $this->load->view('acciones/pendientes-total', $datos);
        $this->load->view('_footer1');
    }



    /**
     * Regresa la tabla de oficios por año de filtro
     * 
     * @return Json Tabla de datos 
     */
    function obtOficiosFirma()
    {
        header('Content-Type: application/json');
        $oficios =  $this->m_oficios->obtOficiosFirma();
        $respuesta = array();
        $i = 0;



        foreach ($oficios as $t) {
            $fecha = $this->m_oficios->soloFechaText($t->fecha_realizado);
            $estatus = $this->m_oficios->estatus($t->color, $t->icon, $t->est);
            // $redaccion = $this->m_oficios->limitar_cadena($t->redaccion, 15);

            $tabla = "<button class='btn btn-success' onclick='marcaFirmado({$t->id})'> Marcar firmado </button>";

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


    /**
     * Regresa la tabla de oficios por año de filtro
     * 
     * @return Json Tabla de datos 
     */
    function obtOficiosMensajeria()
    {
        header('Content-Type: application/json');
        $oficios =  $this->m_oficios->obtOficiosMensajeria();
        $respuesta = array();
        $i = 0;



        foreach ($oficios as $t) {
            $acciones = '';
            $fecha = $this->m_oficios->soloFechaText($t->fecha_realizado);
            $estatus = $this->m_oficios->estatus($t->color, $t->icon, $t->est);
            // $redaccion = $this->m_oficios->limitar_cadena($t->redaccion, 15);

            $ruta = "<button class='btn btn-sm btn-pink' onclick='cambiarEstatus({$t->id},5)'> <i class='fa fa-car'></i> </button>";

            if ($t->estatus <= 5) {
                $acciones = "<button class='btn btn-sm btn-success' onclick='cambiarEstatus({$t->id}, 6)'> <i class='fa fa-check'></i> Marca Recibido</button>";
            } else {
                $ruta = "<button class='btn btn-sm btn-pink disabled'> <i class='fa fa-car'></i> </button>";
                $acciones = "<button class='btn btn-sm btn-warning' onclick='cambiarEstatus({$t->id},7)'> <i class='fa fa-hand-holding'></i> Entregado a Solicitante</button>";
            }

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
                'ruta'           => $ruta,
                'acciones'       => $acciones

            );
            $i++;
        }

        echo json_encode($respuesta);
    }

    
    /**
     * Regresa la tabla de oficios por año de filtro
     * 
     * @return Json Tabla de datos 
     */
    function obtOficiosOficialia()
    {
        header('Content-Type: application/json');
        $year = $this->input->get('anio');
        $validador = "OR Tb_Oficios.estatus != 8 OR Tb_Oficios.estatus != 10";
        $oficios =  $this->m_oficios->obt_oficios($year, $validador);
        $respuesta = array();
        $i = 0;



        foreach ($oficios as $t) {
            $fecha = $this->m_oficios->soloFechaText($t->fecha_realizado);
            $estatus = $this->m_oficios->estatus($t->color, $t->icon, $t->est);
            // $redaccion = $this->m_oficios->limitar_cadena($t->redaccion, 15);

            $tabla = "<a class='fa fa-eye fa-2x text-warning' href='".base_url()."oficios/seguimiento/{$t->id}'></a>";

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


    /**
     * Envia a vista de seguridad de no acceso
     * 
     * @return view
     */
    public function noaccess()
    {
        $this->load->view('_head');
        $this->load->view('errors/_noaccess');
    }
}
