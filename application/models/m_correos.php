<?php

class m_correos extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function correo_enviar_copias($oficio, $pdf)
    {

        $correos = $this->m_mensajeria->correosCopias($oficio);

        $horario = $this->m_mensajeria->hora_actual();
        $saludo = '';

        if ($horario <= '11:59:59') {
            $saludo = 'Buenos días';
        } elseif ($horario <= '19:59:59') {
            $saludo = 'Buenas tardes';
        } elseif ($horario <= '23:59:59') {
            $saludo = 'Buenas noches';
        }

        $datos['oficio'] = $oficio;
        $datos['saludo'] = $saludo;

        //$msg = $this->load->view('correos/c_nuevoTicket', $datos, true);

        $this->load->library('email');
        $this->email->from('mensajeriaoag@redudg.udg.mx', 'Mensajería OAG');

        $this->email->to($correos);
        //$this->email->cc('xochitl.ferrer@redudg.udg.mx');
        //$this->email->bcc('them@their-example.com');

        $this->email->subject('Envio de Copia de Oficio | Mensajería OAG');
        $this->email->message("Envio de Copia de conocimiento");
        $this->email->attach($pdf);
        $this->email->set_mailtype('html');
        $this->email->send();
    }

    public function correo_ticket_cerrado($folio, $fecha, $hora)
    {
        //    $usr = $this->m_ticket->seguimiento_ticket($folio);
        $ticket = $this->m_ticket->seguimiento_ticket($folio);
        $horario = $hora;
        $saludo = '';

        if ($horario <= '11:59:59') {
            $saludo = 'Buenos días';
        } elseif ($horario <= '19:59:59') {
            $saludo = 'Buenas tardes';
        } elseif ($horario <= '23:59:59') {
            $saludo = 'Buenas noches';
        }
        $datos['hora_enviado'] = $hora;
        $datos['ticket'] = $ticket;
        $datos['saludo'] = $saludo;

        //$this->load->view('_head');
        $msg = $this->load->view('correos/c_cerrarTicket', $datos, true);

        $this->load->library('email');
        $this->email->from('incidenciasoag@gmail.com', 'incidenciasOAG');
        $this->email->to($ticket->correo);
        $this->email->cc('incidenciasoag@gmail.com');
        //$this->email->bcc('them@their-example.com');

        $this->email->subject('Incidente Resuleto | incidenciasOAG');
        $this->email->message($msg);
        $this->email->set_mailtype('html');
        $this->email->send();
    }
}
