<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
        $this->load->model('m_correos', "", true);


        $ci = get_instance();
        $this->ftp_ruta = $ci->config->item("f_ruta");
        $this->dir = $ci->config->item("oficios");
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

    /**
     * Vista para registrar un nuevo oficio de salida
     * 
     * @return view
     */
    function nuevaCaptura()
    {
        $consecutivo = $this->m_oficios->obtMaxConsecutivo();
        $codigo = $this->session->userdata("codigo");
        $datos['usuario'] = $this->m_usuario->obt_usuario($codigo);
        $datos['tipos'] = $this->m_oficios->obt_tipoOficios();
        $datos['centros'] = $this->m_mensajeria->obt_centros();
        $datos['consecutivo'] = $consecutivo->cons + 1;

        $this->load->view('_encabezado1');
        $this->load->view('_menuLateral1');
        $this->load->view('oficios/capturar-nuevo-oficio', $datos);
        $this->load->view('_footer1');
    }

    /**
     * Genera y retorna los tipos de oficios
     * 
     * @return Json
     */
    function obtTipoOficios()
    {
        header('Content-Type: application/json');
        $oficios = $this->m_oficios->obtTipoOficios();
        $i = 0;
        $data = array();
        foreach ($oficios as $o) {
            $data[$i] = array(
                'value' => $o->id,
                'text'  => $o->tipoOficio
            );

            $i++;
        }

        echo json_encode($data);
    }

    /**
     * Retorna el nombre de las dependencias
     * 
     * @return Json
     */
    function obtNombreDependencias()
    {
        header('Content-Type: application/json');
        $oficios = $this->m_oficios->obtDependenciasExternas();
        $i = 0;
        $data = array();
        foreach ($oficios as $o) {
            $data[$i] = array(
                'value' => $o->nombre,
                'text'    => $o->nombre
            );

            $i++;
        }

        echo json_encode($data);
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
            'fecha_realizado'   => $this->m_oficios->fechaActual(),
            'hora_realizado'    => $this->m_oficios->horaActual(),
            'estatus'           => 1,
            'exp'               => $_POST['exp'],
            'capturista'        => $this->session->userdata("codigo"),
            'unidadRemitente'   => $this->session->userdata("dependencia"),
            'tipo'              => $this->input->post('tipo')
        );

        $oficio = array_filter($oficio);

        $verificador = $this->m_oficios->verifica_nuevoOficio($nOficio);
        if ($verificador == 0) {
            $this->m_oficios->capturarOficio($oficio);
            $idOficio = $this->db->insert_id();
            if ($idOficio != '') {
                $this->_revisaCopias($idOficio);
                $this->_agregaHistorial($idOficio, 1);
                redirect(base_url() . 'oficios?nOficio=' . $nOficio);
            }
        } else {
            $mensaje = 0;
            echo $mensaje;
        }
    }

    /**
     * Valida si el oficio lleva copia de conocimiento
     * 
     * @param int $id Identificador del oficio Original
     * 
     * @return void
     */
    private function _revisaCopias($id)
    {

        $ccp = $this->input->post('ccp');

        for ($i = 0; $i < count($ccp); $i++) {
            $copias = array(
                'oficio'         => $id,
                'receptor'        => $ccp[$i]
            );

            $this->m_mensajeria->guardarCopias($copias);
        }

        return true;
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

    /**
     * Añade al historial del oficio un movimiento
     * 
     * @param int $id         Identificador del oficio
     * @param int $movimiento tipo de movimiento realizado
     * 
     * @return void
     */
    private function _agregaHistorial($id, $movimiento)
    {
        $movimiento = array(
            'oficio'    => $id,
            'fecha'     => $this->m_oficios->fechahoraActual(),
            'movimiento' => $movimiento,
            'usr'       => $this->session->userdata('codigo')
        );

        $this->m_oficios->agregaHistorial($movimiento);
    }

    function test()
    {
       $this->m_correos->correo_enviar_copias(9494,'originals/2021/6313.pdf');
       
    }

    /**
     * Actualiza el archivo PDF de un oficio y actualiza su direccion en la BD
     * 
     * @var int $id Identificador del oficio
     * @var int $consecutivo numeración del oficio para su nombre
     * 
     * @return redirection 
     */
    function subirOficios()
    {
        $id             = $this->input->post('actualizaId');
        $consecutivo    = $this->input->post('consecutivo');
        $tipo           = $this->input->post('tipo');

        $data = $this->m_oficios->obtYear($id);

        if ($tipo == 1) {
            $this->subir_oficio($id, $consecutivo, $data->year);
        }

        if ($tipo == 2) {
            $this->subeOriginal($id, $consecutivo, $data->year);
        }

        header("Location:" . $_SERVER['HTTP_REFERER']);
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
        $datos['pdf']       = explode(".", $datos['oficio']->pdf);
        $datos['copias']    = $this->m_mensajeria->obtCopiasConocimiento($oficio);
        $datos['historial'] = $this->m_oficios->obtHistorialOficios($oficio);
        // datos para los modales
        $datos['estatus']   = $this->m_oficios->obtEstatusOficio();
        $head['title']      = "Seguimiento del oficio ";

        $this->load->view('_encabezado1', $head);
        $this->load->view('_menuLateral1');
        $this->load->view('oficios/seguimiento', $datos);
        $this->load->view('oficios/mod-asociarTicket', $datos);
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
            $fecha = $this->m_oficios->soloFechaText($t->fecha_realizado);
            $estatus = $this->m_oficios->estatus($t->color, $t->icon, $t->est);
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

    /**
     * PRUEBA PARA VALIDAR SI EXISTE EL PDF GUARDADO
     */
    function prueba()
    {
        $carpeta = $this->ftp_ruta . 'documents/acuses/2021/';

        $qry = "AND consecutivo < 11";

        $oficios = $this->m_oficios->obtOficiosPendientes($qry);

        foreach ($oficios as $oficio) {
            $ruta = "{$carpeta}{$oficio->consecutivo}.pdf";
            if (file_exists($ruta)) {

                echo "El fichero $ruta existe <br>";

                $pdf = "{$oficio->consecutivo}.pdf";
                $data = array(
                    'pdf'       => $pdf,
                    'estatus'   => 8
                );

                $this->m_oficios->subir_oficio($data, $oficio->id);
            } else {
                echo "El fichero $ruta no existe <br>";
            }
        }
    }


    /**
     * Edita campos individualmente de un oficio
     * 
     * Requiere que se envie 3 datos para editar el campo seleccioando de un oficio
     * 
     * @var int $id primary key del oficio
     * @var string $campo nombre de la columna a editar
     * @var mixed $value valor nuevo a actualizar
     * 
     * @return Json
     */
    function editarOficio()
    {
        $id        = $_POST['pk'];
        $campo     = $_POST['name'];
        $value     = $_POST['value'];
        $movimiento = 4;

        if ($campo === 'estatus') {
            $movimiento = 2;
        }
        if ($campo === 'estatus' && $value == 6) {
            $this->verificaMensajeria($id);
        }

        $this->m_oficios->editarOficio($id, $campo, $value);     

        $seguimiento = array(
            'oficio'    => $id,
            'fecha'     => $this->m_oficios->fechahoraActual(),
            'movimiento' => $movimiento,
            'usr'       => $this->session->userdata('codigo')            
        );

        if($movimiento === 2){
            $seguimiento['estatus'] = $value;
        }


        $this->m_oficios->agregaHistorial($seguimiento);

        echo json_encode($id);
    }


    function verificaMensajeria($id)
    {


        //verifica que este cargado el original
        $oficio = $this->m_mensajeria->obtPDF($id);

        if ($oficio->ruta) {
            $rutaPdf = "documents/originals/{$oficio->year}/{$oficio->ruta}";

            //Envia los correos
            @$this->m_correos->correo_enviar_copias($id, $rutaPdf);
            //Actualiza en la BD el envio 
            $this->m_mensajeria->copias_enviadas($id);
        }
    }




    /**
     * Sube el Oficio a la Carpeta correspondiente
     * 
     * @param int $id          Identificador del oficio
     * @param int $consecutivo Numero consecutivo que sera el nombre del oficio
     * @param int $year        año de captura del oficio
     * 
     * @return void
     */
    function subir_oficio($id, $consecutivo, $year)
    {

        // SCRIPT PARA SUBIR LOS PDF ###########################
        if ($_FILES['pdf']['name'] != "") {
            $ext = explode('.', $_FILES['pdf']['name']);
            $ext = $ext[count($ext) - 1];
            $pdf = "{$consecutivo}.{$ext}";
            move_uploaded_file(
                $_FILES['pdf']['tmp_name'],
                "{$this->ftp_ruta}documents/acuses/{$year}/{$pdf}"
            );
            // FIN DEL SCRIPT#####################################   

            $nuevoPdf = array(
                'pdf'      => $pdf,
                'estatus'  => 8,
                'fecha_entrega' => $this->m_oficios->fechaActual(),
                'hora_entrega'  => $this->m_oficios->horaActual()
            );
            $this->m_oficios->subir_oficio($nuevoPdf, $id);

            $seguimiento = array(
                'oficio'    => $id,
                'fecha'     => $this->m_oficios->fechahoraActual(),
                'movimiento' => 2,
                'usr'       => $this->session->userdata('codigo'),
                'estatus'   => 8
            );

            $this->m_oficios->agregaHistorial($seguimiento);
        }
    }

    /**
     * Funcion temporal para subir los oficios de Copia conocimiento
     * 
     * @param int $id          Identificador del oficio
     * @param int $consecutivo Numero consecutivo que sera el nombre del oficio
     * @param int $year        año de captura del oficio
     * 
     * @return void
     */
    function subeOriginal($id, $consecutivo, $year)
    {
        // SCRIPT PARA SUBIR LOS PDF ###########################
        if ($_FILES['pdf']['name'] != "") {
            $ext = explode('.', $_FILES['pdf']['name']);
            $ext = $ext[count($ext) - 1];
            $pdf = "{$consecutivo}.{$ext}";
            move_uploaded_file(
                $_FILES['pdf']['tmp_name'],
                "{$this->ftp_ruta}documents/originals/{$year}/{$pdf}"
            );
            // FIN DEL SCRIPT#####################################   

            $nuevoPdf = array(
                'pdfOriginal'      => $pdf
            );
            $this->m_oficios->subir_oficio($nuevoPdf, $id);

            $seguimiento = array(
                'oficio'    => $id,
                'fecha'     => $this->m_oficios->fechahoraActual(),
                'movimiento' => 3,
                'usr'       => $this->session->userdata('codigo')
            );

            $this->m_oficios->agregaHistorial($seguimiento);
        }
    }

    /**
     * Devuelve el estatus actual de un oficio
     * 
     * @var int $id identificador unico del oficion enviado por Get
     * 
     * @return json
     */
    function estatusOficio()
    {
        header('Content-Type: application/json');

        $id  = $this->input->get('pk');

        $datos = $this->m_oficios->obt_oficio($id);

        echo json_encode($datos);
    }

    /**
     * Regresa el historial de un oficio solicitado por Get
     * 
     * @var int $id Identificador unico del oficio
     * 
     * @return $html historial del oficio
     */
    function obtHistorialOficio()
    {
        $id = $this->input->get('id');
        $historial =  $this->m_oficios->obtHistorialOficios($id);

        $html = "";

        foreach ($historial as $h) {
            $fecha = $this->m_mensajeria->fecha_text($h->fecha);

            $html .= " 
            <div class='row mb-2'>           
                <div class='col-9'> <b> {$h->usuario}</b> {$h->LABEL}</div>
                <div 
                    class='col-3 text-muted' 
                    data-toggle='tooltip' 
                    title='Fecha de movimiento'>
                    
                        {$fecha}
                
                </div>

            </div>
            <hr>";
        }

        echo $html;
    }
}
