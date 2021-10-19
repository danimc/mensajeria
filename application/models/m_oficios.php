<?php 

class m_oficios extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    /**
     * Ingresa un nuevo registro a la base de Libro Oficios
     * 
     * @param array $oficio arreglo de datos a dar de alta
     * 
     * @return void
     */
    function capturarOficio($oficio)
    {
        $this->db->insert("Tb_Oficios", $oficio);
    }

    function obt_datosOficio($idIncidente)
    {
        $this->db->where('id', $idIncidente);
        return $this->db->get('Tb_Oficios')->row();
    }

    /**
     * Regresa el numeral maximio del oficio por año en curso
     * 
     * @return int numero de oficio actual
     */
    function obtMaxConsecutivo()
    {
        $year = date('Y');
        $qry = "";

        $qry = "SELECT max(consecutivo) as cons
        FROM Tb_Oficios
        where oficio like '%/$year'"
        ;

        return $this->db->query($qry)->row();
    }

    function verifica_nuevoOficio($oficio)
    {
        $this->db->where('consecutivo', $oficio);
        $this->db->where('year', date('Y'));

        return $this->db->get('Tb_LibroOficios')->num_rows();
    }

    /**
     * Obtienen los registros de los oficios
     */
    function obtLibroOficios()
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
    function obtAniosRegistrados()
    {
        $qry = '';

        $qry = "SELECT year(fecha_inicio) as year
                FROM ticket
                GROUP BY year
                ORDER BY year DESC ";

        return $this->db->query($qry)->result();;
    }


    function obt_oficios($year)
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
                estatus,
                fecha_entrega,
                t.tipoOficio as tipo,
                nombreDependencia,
                pdf,
                generado,
                exp
            FROM Tb_Oficios
                LEFT JOIN Tb_Cat_TipoOficio t ON t.id = Tb_Oficios.tipo
            WHERE oficio like '%/$year' ";

        return $this->db->query($qry)->result();
    }

    function obt_oficio($oficio)
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
                pdf
                FROM Tb_Oficios
                LEFT JOIN Tb_Cat_TipoOficio t ON t.id = Tb_Oficios.tipo
              
                WHERE Tb_Oficios.id = {$oficio}";

        return $this->db->query($qry)->row();
    }

    function capturar_consecutivo()
    {        
        $this->db->insert('Tb_Oficios', $this);
    }
    /**
     * Regresa responsable y cargo de la dependencia enviada como parametro
     * 
     * @param int $id id de la dependencia
     * 
     * @return row datos de la dependencia
     */
    function obtDatosDependencia($id)
    {
        $this->db->where('id', $id);
        return  $this->db->get('b_dependencias')->row();
    }

    function obt_tipoOficios()
    {
        return $this->db->get('Tb_Cat_TipoOficio')->result();
    }

    function estatus($estatus)
    {
        if($estatus == 1) {
            $esta = ' <span data-toggle="modal" data-target="#modalStatus" class="btn badge btn-info badge-pill mb-2"><i class="fa fa-file"></i> Capturado</span>';
            return $esta;
        }
        if($estatus == 2) {
            $esta = ' <span data-toggle="modal" data-target="#modalStatus" class="btn badge btn-pink badge-pill mb-2"><i class="fa fa-paper-plane"></i> Enviado</span>';
            return $esta;
        }
        if($estatus == 3) {
            $esta = ' <span data-toggle="modal" data-target="#modalStatus" class="btn badge btn-success badge-pill mb-2"><i class="fa fa-check"></i> Entregado</span>';
            return $esta;
        }
    }

    function correo_ticket_cerrado($folio, $fecha, $hora)
    {
    
    }
}
