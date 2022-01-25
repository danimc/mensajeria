<?php

class m_seguridad extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    //////////////////////////////////////////////////////// VALIDAR ACCESOS

    public function acceso_sistema()
    {
        $usuario = $this->session->userdata("codigo");

        $this->db->where("usuario", $usuario);
        $this->db->where("sistema", 2);
        return $this->db->get("accesos_sistemas")->num_rows();
    }

    public function acceso_modulo($modulo)
    {
        $usuario = $this->session->userdata("codigo");

        $this->db->where("usuario", $usuario);
        $this->db->where("modulo", $modulo);
        $this->db->where("sistema", 2);
        return $this->db->get("accesos_modulos")->num_rows();
    }

    /////////////////////////////////////////////////////// CONTROL DE ACCESOS A SISTEMAS

    public function limpiar_accesos_sistema($usuario)
    {
        $this->db->where("codigo", $usuario);
        $this->db->delete('accesos_sistemas', $this);
    }

    public function limpiar_accesos_modulos($usuario)
    {
        $this->db->where("codigo", $usuario);
        $this->db->delete('accesos_modulos', $this);
    }

    public function dar_acceso_sistema($usuario, $sistema)
    {
        $this->sistema = $sistema;
        $this->usuario = $usuario;
        $this->db->insert("accesos_sistemas", $this);
    }

    public function dar_acceso_modulo($usuario, $sistema, $modulo)
    {
        $this->sistema = $sistema;
        $this->usuario = $usuario;
        $this->modulo = $modulo;
        $this->db->insert("accesos_modulos", $this);
    }

    /////////////////////////////////////////////////// LOG GENERAL

    public function log_general($controlador, $funcion, $objeto)
    {

        $this->sistema = 2; //sistema 2 = Control de Oficios
        $this->controlador = $controlador;
        $this->funcion = $funcion;
        $this->objeto = $objeto;
        $this->fecha = date("Y-m-d");
        $this->hora = date("H:i:s");
        $this->usuario = $this->session->userdata("codigo");
        $this->ip = $this->session->userdata("ip_address");

        $this->db->insert("log_general", $this);

    }
}
