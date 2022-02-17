<?php

class m_mensajeria extends CI_Model
{

    /**
     * Guarda los registros de cada copia en la Bd
     * @param object $copias registro a almacenar
     *
     * @return void
     */
    public function guardarCopias($copias)
    {
        $this->db->insert("Tb_CopiasConocimiento", $copias);
    }

    public function obt_centros()
    {
        return $this->db->get('b_dependencias')->result();
    }

    public function obt_abreviatura($codigo)
    {
        $qry = '';

        $qry = "SELECT abreviatura,id_dependencia FROM crm.dependencias
                INNER JOIN usuario
                where
                usuario.dependencia = id_dependencia
                and codigo = '$codigo'";

        return $this->db->query($qry)->row();
    }

    /**
     * Regresa los datos de las areas marcadas para copia en el oficio
     *
     * @param int $folio identificador del oficio a revisar
     * @return object
     */
    public function obtCopiasConocimiento($folio)
    {
        $qry = '';

        $qry = "SELECT
                d.nombre
                ,d.correo
                ,fecha_envio
                ,hora_envio
                ,correoEspecial
                FROM crm.Tb_CopiasConocimiento
                LEFT JOIN b_dependencias d ON d.id = receptor
                WHERE oficio = $folio";

        return $this->db->query($qry)->result();
    }

    public function estatus()
    {
        $this->db->where('id !=', 2);
        $this->db->where('id !=', 5);
        $this->db->where('id !=', 7);
        return $this->db->get("situacion_ticket")->result();
    }

    public function copias_enviadas($folio)
    {
        $this->fecha_envio = $this->fecha_actual();
        $this->hora_envio = $this->hora_actual();

        $this->db->where('oficio', $folio);
        $this->db->update('Tb_CopiasConocimiento', $this);
    }

    public function obtPDF($oficio)
    {
        $this->db->select('pdfOriginal as ruta, YEAR(fecha_realizado) as year');
        $this->db->where('id', $oficio);
        return $this->db->get('Tb_Oficios')->row();
    }

    /**
     * Regresa un arreglo de los correos para Copia de conocimiento
     *
     * Genera un Array especial para el envio de correos de copia de conocimeinto
     * separados por coma, para ello se necesita enviar el id del oficio
     *
     * @param int $id identificador del numero de oficio
     *
     * @return array  arreglo con los correos a enviar la copia, separados por coma
     */
    public function correosCopias($id)
    {
        $copias = $this->m_mensajeria->obtCopiasConocimiento($id);

        $correos = "";
        $n = sizeof($copias);
        $i = 0;

        foreach ($copias as $c) {
            $correos .= " {$c->correo}";
            if ($i < 2) {
                $correos .= ",";
            }
            $i++;
        }

        return $correos;
    }

    //***********************TABLAS **********************

    //******************************** FECHAS **********************************************/

    public function fecha_a_sql($date)
    {
        $fecha = explode("/", $date);
        $fecha_sql = $fecha['2'] . "-" . $fecha['0'] . "-" . $fecha['1'];
        return $fecha_sql;
    }

    public function fecha_a_form($date)
    {
        $fecha = explode("-", $date);
        $fecha_sql = $fecha['1'] . "/" . $fecha['2'] . "/" . $fecha['0'];
        return $fecha_sql;
    }

    public function fecha_actual()
    {
        date_default_timezone_set("America/Mexico_City");
        $fecha = date("Y-m-d");
        return $fecha;
    }

    public function hora_actual()
    {
        date_default_timezone_set("America/Mexico_City");
        $hora = date("H:i:s");
        return $hora;
    }
    public function fechahora_actual()
    {
        date_default_timezone_get("America/Mexico_City");
        $fecha = date("Y-m-d h:i:s");
        return $fecha;
    }

    public function fecha_text($datetime)
    {
        if ($datetime == "0000-00-00 00:00:00") {
            return "Fecha indefinida";
        } else {

            $dia = explode(" ", $datetime);
            $fecha = explode("-", $dia[0]);
            if ($fecha[1] == 1) {
                $mes = 'enero';
            } else if ($fecha[1] == 2) {
                $mes = 'febrero';
            } else if ($fecha[1] == 3) {
                $mes = 'marzo';
            } else if ($fecha[1] == 4) {
                $mes = 'abril';
            } else if ($fecha[1] == 5) {
                $mes = 'mayo';
            } else if ($fecha[1] == 6) {
                $mes = 'junio';
            } else if ($fecha[1] == 7) {
                $mes = 'julio';
            } else if ($fecha[1] == 8) {
                $mes = 'agosto';
            } else if ($fecha[1] == 9) {
                $mes = 'septiembre';
            } else if ($fecha[1] == 10) {
                $mes = 'octubre';
            } else if ($fecha[1] == 11) {
                $mes = 'noviembre';
            } else if ($fecha[1] == 12) {
                $mes = 'diciembre';
            }

            $hora = explode(":", $dia[1]);

            $time = $hora[0] . ":" . $hora[1] . " Hrs";

            $fecha2 = $fecha[2] . " " . $mes . " " . $fecha[0];
            return $fecha2 . " a las " . $time;
        }
    }

    public function fecha_text_f($datetime)
    {
        if ($datetime == "0000-00-00") {
            return "Fecha indefinida";
        } else {

            $fecha = explode("-", $datetime);
            if ($fecha[1] == 1) {
                $mes = 'enero';
            } else if ($fecha[1] == 2) {
                $mes = 'febrero';
            } else if ($fecha[1] == 3) {
                $mes = 'marzo';
            } else if ($fecha[1] == 4) {
                $mes = 'abril';
            } else if ($fecha[1] == 5) {
                $mes = 'mayo';
            } else if ($fecha[1] == 6) {
                $mes = 'junio';
            } else if ($fecha[1] == 7) {
                $mes = 'julio';
            } else if ($fecha[1] == 8) {
                $mes = 'agosto';
            } else if ($fecha[1] == 9) {
                $mes = 'septiembre';
            } else if ($fecha[1] == 10) {
                $mes = 'octubre';
            } else if ($fecha[1] == 11) {
                $mes = 'noviembre';
            } else if ($fecha[1] == 12) {
                $mes = 'diciembre';
            }

            $fecha2 = $fecha[2] . " " . $mes . " " . $fecha[0];
            return $fecha2;
        }
    }

    public function hora_fecha_text($dia)
    {
        $dia2 = explode(" ", $dia);

        if ($dia2[0] == "0000-00-00") {
            $fecha2 = "Termino indefinido";
        } else {
            $fecha = explode("-", $dia2[0]);
            if ($fecha[1] == 1) {
                $mes = 'enero';
            } else if ($fecha[1] == 2) {
                $mes = 'febrero';
            } else if ($fecha[1] == 3) {
                $mes = 'marzo';
            } else if ($fecha[1] == 4) {
                $mes = 'abril';
            } else if ($fecha[1] == 5) {
                $mes = 'mayo';
            } else if ($fecha[1] == 6) {
                $mes = 'junio';
            } else if ($fecha[1] == 7) {
                $mes = 'julio';
            } else if ($fecha[1] == 8) {
                $mes = 'agosto';
            } else if ($fecha[1] == 9) {
                $mes = 'septiembre';
            } else if ($fecha[1] == 10) {
                $mes = 'octubre';
            } else if ($fecha[1] == 11) {
                $mes = 'noviembre';
            } else if ($fecha[1] == 12) {
                $mes = 'diciembre';
            }

            $fecha2 = $fecha[2] . " de " . $mes . " del " . $fecha[0];
        }
        return $fecha2;
    }

    public function etiqueta($estatus)
    {
        if ($estatus == 1) {
            $esta = ' <span data-toggle="modal" data-target="#modalStatus" class="btn badge btn-primary badge-pill mb-2"><i class="fa fa-ticket"></i> Registrado </span>';
            return $esta;
        }
        if ($estatus == 2) {
            $esta = ' <span data-toggle="modal" data-target="#modalStatus" class="btn badge btn-pink badge-pill mb-2"><i class="fa fa-user-plus"></i> Validado</span>';
            return $esta;
        }
        if ($estatus == 3) {
            $esta = ' <span data-toggle="modal" data-target="#modalStatus" class="btn badge btn-info badge-pill mb-2"><i class="fa fa-spinner"></i> enviado</span>';
            return $esta;
        }
        if ($estatus == 4) {
            $esta = ' <span data-toggle="modal" data-target="#modalStatus" class="btn badge btn-success badge-pill mb-2"><i class="fa fa-check-circle"></i> Recibido </span>';
            return $esta;
        }
        if ($estatus == 5) {
            $esta = ' <span data-toggle="modal" data-target="#modalStatus" class="btn badge btn-danger badge-pill mb-2"><i class="fa fa-lock"></i> Cerrado</span>';
            return $esta;
        }
        if ($estatus == 6) {
            $esta = ' <span data-toggle="modal" data-target="#modalStatus" class="btn badge btn-secondary badge-pill mb-2"><i class="fa  fa-hourglass-2" ></i> Pendiente</span>';
            return $esta;
        }
        if ($estatus == 7) {
            $esta = ' <span data-toggle="modal" data-target="#modalStatus" class="btn badge btn-warning badge-pill mb-2"><i class="fa  fa-random"></i> Reasignado</span>';
            return $esta;
        }
    }

}
