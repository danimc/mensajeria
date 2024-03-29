<?php

class m_oficios extends CI_Model
{
    /**
     * Ingresa un nuevo registro a la base de Libro Oficios
     *
     * @param array $oficio arreglo de datos a dar de alta
     *
     * @return void
     */
    public function capturarOficio($oficio)
    {
        $this->db->insert("Tb_Oficios", $oficio);
    }

    public function obt_datosOficio($idIncidente)
    {
        $this->db->where('id', $idIncidente);
        return $this->db->get('Tb_Oficios')->row();
    }

    /**
     * Regresa el numeral maximio del oficio por año en curso
     *
     * @return int numero de oficio actual
     */
    public function obtMaxConsecutivo()
    {
        $year = date('Y');
        $qry = "";

        $qry = "SELECT max(consecutivo) as cons
        FROM Tb_Oficios
        where oficio like '%/$year'";

        return $this->db->query($qry)->row();
    }

    public function verifica_nuevoOficio($oficio)
    {
        $this->db->where('consecutivo', $oficio);
        $this->db->where('year', date('Y'));

        return $this->db->get('Tb_LibroOficios')->num_rows();
    }

    /**
     * Regresa los oficios pendientes del area
     *
     * @param int $area identificador del area
     *
     * @return array oficios pendientes del area
     */
    public function obtOficiosPendientes($opciones)
    {

        $qry = "";

        $qry = "SELECT Tb_Oficios.id,
                consecutivo,
                oficio,
                folio,
                oficioRecibido,
                destinatario,
                redaccion,
                fecha_realizado,
                servicio,
                Tb_Oficios.estatus,
                d.nombre_dependencia as remitente,
                fecha_entrega,
                t.tipoOficio as tipo,
                nombreDependencia,
                pdf,
                generado,
                exp,
                est.estatus as est,
                est.color,
                est.icon,
                us.usuario as capturista
            FROM Tb_Oficios
                LEFT JOIN Tb_Cat_TipoOficio t ON t.id = Tb_Oficios.tipo
                LEFT JOIN dependencias d ON Tb_Oficios.unidadRemitente = d.id_dependencia
                LEFT JOIN Tb_Cat_EstatusOficios est ON est.id = Tb_Oficios.estatus
                LEFT JOIN usuario us ON capturista = codigo
            WHERE Tb_Oficios.estatus != 8
            AND   Tb_Oficios.estatus != 10
            {$opciones}
            ";

        return $this->db->query($qry)->result();
    }

    /**
     * Obtienen los registros de los oficios
     */
    public function obtLibroOficios()
    {
        $qry = "";

        $qry = "SELECT
                id,
                consecutivo,
                fecha_realizado,
                hora_realizado,
                solicitante,
                dependencia_solicitante,
                dependencia_receptor,
                asunto
                FROM Tb_Oficios";

        return $this->db->query($qry)->result();
    }

    /**
     * Regresa una lista con los años en los hay registros de oficios
     *
     * @return result
     */
    public function obtAniosRegistrados()
    {
        $qry = '';

        $qry = "SELECT year(fecha_inicio) as year
                FROM ticket
                GROUP BY year
                ORDER BY year DESC ";

        return $this->db->query($qry)->result();
    }

    /**
     * Regresa todas las depenedencias externas Registradas en la BD
     */
    public function obtDependenciasExternas()
    {
        return $this->db->get('b_dependencias')->result();
    }

    /**
     * Edita campos individuales del oficio
     *
     * @param int    $id    Identificador del oficio
     * @param string $campo nombre del campo a modificar
     * @param any    $value Nuevo valor a ingresar
     *
     * @return void
     */
    public function editarOficio($id, $campo, $value)
    {
        $this->db->where('id', $id);
        $this->db->set($campo, $value);
        $this->db->update('Tb_Oficios', $this);
    }

    /**
     * Retorna los oficios de las areas y el año seleccionado
     *
     * @param int $year
     * @param string $condiciones
     * @return object
     */
    public function obtOficios($year, $condiciones)
    {
        $qry = "";

        $qry = "SELECT Tb_Oficios.id,
                consecutivo,
                oficio,
                folio,
                u.usuario,
                oficioRecibido,
                destinatario,
                redaccion,
                fecha_realizado,
                servicio,
                Tb_Oficios.estatus,
                d.nombre_dependencia as remitente,
                fecha_entrega,
                t.tipoOficio as tipo,
                nombreDependencia,
                pdf,
                generado,
                exp,
                est.estatus as est,
                est.color,
                est.icon
            FROM Tb_Oficios
                LEFT JOIN Tb_Cat_TipoOficio t ON t.id = Tb_Oficios.tipo
                LEFT JOIN dependencias d ON  Tb_Oficios.unidadRemitente = d.id_dependencia
                LEFT JOIN Tb_Cat_EstatusOficios est ON est.id = Tb_Oficios.estatus
                LEFT JOIN usuario u ON Tb_Oficios.capturista = u.codigo
            WHERE oficio like '%/{$year}'
            {$condiciones}
            ORDER BY consecutivo ASC";

        return $this->db->query($qry)->result();
    }

    /**
     * Regresa los oficios para la lista de firmados
     *
     * @return array
     */
    public function obtOficiosFirma()
    {

        $qry = "";

        $qry = "SELECT Tb_Oficios.id,
                consecutivo,
                oficio,
                folio,
                oficioRecibido,
                u.usuario,
                destinatario,
                redaccion,
                fecha_realizado,
                servicio,
                Tb_Oficios.estatus,
                d.nombre_dependencia as remitente,
                fecha_entrega,
                t.tipoOficio as tipo,
                nombreDependencia,
                pdf,
                generado,
                exp,
                est.estatus as est,
                est.color,
                est.icon
            FROM Tb_Oficios
                LEFT JOIN Tb_Cat_TipoOficio t ON t.id = Tb_Oficios.tipo
                LEFT JOIN dependencias d ON  Tb_Oficios.unidadRemitente = d.id_dependencia
                LEFT JOIN Tb_Cat_EstatusOficios est ON est.id = Tb_Oficios.estatus
                LEFT JOIN usuario u ON Tb_Oficios.capturista = u.codigo
            WHERE Tb_Oficios.estatus = 2";

        return $this->db->query($qry)->result();
    }

    /**
     * Regresa los oficios para la lista de Mensajeria
     *
     * @return array
     */
    public function obtOficiosMensajeria()
    {

        $qry = "";

        $qry = "SELECT Tb_Oficios.id,
                consecutivo,
                oficio,
                folio,
                oficioRecibido,
                destinatario,
                u.usuario,
                redaccion,
                fecha_realizado,
                servicio,
                Tb_Oficios.estatus,
                d.nombre_dependencia as remitente,
                fecha_entrega,
                t.tipoOficio as tipo,
                nombreDependencia,
                pdf,
                generado,
                exp,
                est.estatus as est,
                est.color,
                est.icon
            FROM Tb_Oficios
                LEFT JOIN Tb_Cat_TipoOficio t ON t.id = Tb_Oficios.tipo
                LEFT JOIN dependencias d ON  Tb_Oficios.unidadRemitente = d.id_dependencia
                LEFT JOIN Tb_Cat_EstatusOficios est ON est.id = Tb_Oficios.estatus
                LEFT JOIN usuario u ON Tb_Oficios.capturista = u.codigo
            WHERE Tb_Oficios.estatus > 3
            AND Tb_Oficios.estatus < 7";

        return $this->db->query($qry)->result();
    }

    public function obtOficiosOficialia()
    {
        // $year = date('Y');
        $qry = "";

        $qry = "SELECT Tb_Oficios.id,
                consecutivo,
                oficio,
                folio,
                oficioRecibido,
                destinatario,
                redaccion,
                fecha_realizado,
                servicio,
                Tb_Oficios.estatus,
                d.nombre_dependencia as remitente,
                fecha_entrega,
                t.tipoOficio as tipo,
                nombreDependencia,
                pdf,
                generado,
                exp,
                est.estatus as est,
                est.color,
                est.icon
            FROM Tb_Oficios
                LEFT JOIN Tb_Cat_TipoOficio t ON t.id = Tb_Oficios.tipo
                LEFT JOIN dependencias d ON  Tb_Oficios.unidadRemitente = d.id_dependencia
                LEFT JOIN Tb_Cat_EstatusOficios est ON est.id = Tb_Oficios.estatus
            WHERE Tb_Oficios.estatus != 8
            AND Tb_Oficios.estatus != 10";

        return $this->db->query($qry)->result();
    }

    public function obt_oficio($oficio)
    {
        $qry = "";
        $qry = "SELECT
                Tb_Oficios.id,
                consecutivo,
                Tb_Oficios.oficio,
                if(Tb_Oficios.folio != '', Tb_Oficios.folio, '---') as folio,
                concat(fecha_realizado, ' ', hora_realizado ) as fechaOficio,
                destinatario,
                nombreDependencia as dependencia,
                redaccion,
                if(oficioRecibido != '', oficioRecibido, '---') as oficioRecibido,
                cargo,
                fecha_realizado,
                Tb_Oficios.estatus,
                fecha_entrega,
                Tb_Oficios.tipo as idTipo,
                t.tipoOficio as tipo,
                pdf,
                est.estatus as est,
                est.color,
                est.icon,
                YEAR(fecha_realizado) as year,
                pdfOriginal as original,
                exp
                FROM Tb_Oficios
                LEFT JOIN Tb_Cat_TipoOficio t ON t.id = Tb_Oficios.tipo
                LEFT JOIN dependencias d ON  Tb_Oficios.unidadRemitente = d.id_dependencia
                LEFT JOIN Tb_Cat_EstatusOficios est ON est.id = Tb_Oficios.estatus

                WHERE Tb_Oficios.id = {$oficio}";

        return $this->db->query($qry)->row();
    }

    /**
     * Regresa el año en que fue capturado un Oficio
     *
     * @param int $id Identificador del oficio a revisar
     *
     * @return row año de captura
     */
    public function obtYear($id)
    {
        $this->db->where("id", $id);

        $this->db->select('Year(fecha_realizado) as year');

        return $this->db->get("Tb_Oficios")->row();
    }

    /**
     * Regresa desde la Bd los tipos de oficio
     *
     * @return array
     */
    public function obtTipoOficios()
    {
        return $this->db->get('Tb_Cat_TipoOficio')->result();
    }

    /**
     * Regresa la lista de estatus de los oficios
     *
     * @return array estatus
     */
    public function obtEstatusOficio()
    {
        return $this->db->get('Tb_Cat_EstatusOficios')->result();
    }

    /**
     * Guarda en la Bd que se cargo el Acuse
     *
     * @param object $oficio objeto de campos a actualizar
     * @param int    $id     identificador del oficio
     *
     * @return void
     */
    public function subir_oficio($oficio, $id)
    {
        $this->db->where('id', $id);
        $this->db->set($oficio);
        $this->db->update('Tb_Oficios');
    }

    /**
     * Verifica si las copias ya fueron enviadas
     *
     * @param int $id identificador del oficio
     *
     * @return boolean
     */
    public function verificaEnvioCopias($id)
    {
        $copias = $this->m_mensajeria->obtCopiasConocimiento($id);

        if (sizeof($copias) == 0) {
            return 0;
        }

        //si hay fecha de envio marcada, regresa falso
        if ($copias[0]->fecha_envio) {
            return false;
        }

        return true;
    }

    public function capturar_consecutivo()
    {
        $this->db->insert('Tb_Oficios', $this);
    }

    public function actualizaDestinatario($dependencia, $datos)
    {
        $this->db->where('id', $dependencia);
        $this->db->update('b_dependencias', $datos);
    }

    /**
     * Regresa responsable y cargo de la dependencia enviada como parametro
     *
     * @param int $id id de la dependencia
     *
     * @return row datos de la dependencia
     */
    public function obtDatosDependencia($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('b_dependencias')->row();
    }

    public function obt_tipoOficios()
    {
        return $this->db->get('Tb_Cat_TipoOficio')->result();
    }

    /**
     * Regresa todos los movimeintos de un Oficio
     *
     * @param int $id Identificador del Oficios
     *
     * @return array arreglo de objetos de movimientos
     */
    public function obtHistorialOficios($id)
    {
        $qry = "";

        $qry = "SELECT m.id,
                        m.fecha,
                        m.mensaje,
                        u.usuario,
                        h.nombre,
                        m.estatus,
                        if (
                            m.movimiento = 2,
                            concat(label, ' ', s.estatus),
                            h.`label`
                        ) as LABEL
                    FROM h_Oficios m
                        LEFT JOIN usuario u ON m.usr = u.codigo
                        LEFT JOIN Tb_Cat_MovimientoOficios h ON m.movimiento = h.id
                        LEFT JOIN Tb_Cat_EstatusOficios s ON m.estatus = s.id
                    WHERE m.oficio = {$id}";

        return $this->db->query($qry)->result();
    }

    /**
     * Agrega a la BD un nuevo movimiento en un oficio
     *
     * @param object $movimiento array con los datos del movimiento
     *
     * @return void
     */
    public function agregaHistorial($movimiento)
    {
        $this->db->insert("h_Oficios", $movimiento);
    }

    /**
     * acorta la cadena de un texto
     *
     * @param string $cadena cadena a acortar
     * @param int    $limite cantidad de caracteres
     *
     * @return string
     */
    public function limitar_cadena($cadena, $limite)
    {
        // Si la longitud es mayor que el límite...
        if (strlen($cadena) > $limite) {
            // Entonces corta la cadena y ponle el sufijo
            return substr($cadena, 0, $limite);
        }

        // Si no, entonces devuelve la cadena normal
        return $cadena;
    }

    /**
     * Genera el Html del estatus
     *
     * @param $estatus datos del estatus
     *
     * @return html
     */
    public function estatus($color, $icono, $label, $id)
    {
        $URL = base_url();

        $esta = "
        <a href='{$URL}oficios/seguimiento/{$id}'
            class='btn badge btn-{$color} badge-pill mb-2'>
                <i class='{$icono}'></i> {$label}
        </a>";

        return $esta;

    }

    //FECHAS

    /**
     * Regresa la fecha actual del servidor MX
     *
     * @return date fecha actual
     */
    public function fechaActual()
    {
        date_default_timezone_set("America/Mexico_City");
        $fecha = date("Y-m-d");
        return $fecha;
    }

    /**
     * Regresa la hora actual del servidor MX
     *
     * @return time Hora actual
     */
    public function horaActual()
    {
        date_default_timezone_set("America/Mexico_City");
        $hora = date("H:i:s");
        return $hora;
    }

    /**
     * Regresa la fecha y hora actual del servidor
     *
     * @return datetime
     */
    public function fechahoraActual()
    {
        date_default_timezone_set("America/Mexico_City");
        $fecha = date("Y-m-d h:i:s");
        return $fecha;
    }

    /**
     * Regresa la fecha Formateada
     *
     * @param date $datetime fecha en formato unix
     *
     * @return string Fecha en formato largo
     */
    public function fechaText($datetime)
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

    /**
     * Regresa solo la fecha formateada
     *
     * @param date|string $date fecha a formatear
     *
     * @return string
     */
    public function soloFechaText($date)
    {
        if ($date == "0000-00-00") {
            return "Fecha indefinida";
        } else {

            $fecha = explode("-", $date);
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
}
