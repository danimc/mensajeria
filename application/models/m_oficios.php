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
     * Regresa los oficios pendientes del area
     * 
     * @param int $area identificador del area
     * 
     * @return array oficios pendientes del area
     */
    function obtOficiosPendientes($opciones)
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

    /**
     * Regresa todas las depenedencias externas Registradas en la BD
     */
    function obtDependenciasExternas()
    {
        return $this->db->get('b_dependencias')->result();
    }

    /**
     * Edita campos individuales del oficio
     * 
     * @param int $id Identificador del oficio
     * @param string $campo nombre del campo a modificar
     * @param any $value Nuevo valor a ingresar 
     * 
     * @return void
     */
    function editarOficio($id, $campo, $value)
    {
        $this->db->where('id', $id);
        $this->db->set($campo, $value);
        $this->db->update('Tb_Oficios', $this);
    }



    function obt_oficios($year)
    {
        // $year = date('Y');
        $qry = "";

        $qry = "SELECT DISTINCT Tb_Oficios.id,
                consecutivo,
                oficio,
                folio,
                oficioRecibido,
                destinatario,
                redaccion,
                fecha_realizado,
                servicio,
                estatus,
                d.nombre_dependencia as remitente,
                fecha_entrega,
                t.tipoOficio as tipo,
                nombreDependencia,
                pdf,
                generado,
                exp
            FROM Tb_Oficios
                LEFT JOIN Tb_Cat_TipoOficio t ON t.id = Tb_Oficios.tipo
                LEFT JOIN dependencias d ON  Tb_Oficios.unidadRemitente = d.id_dependencia
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

      /**
       * Regresa desde la Bd los tipos de oficio
       * 
       * @return array
       */
    function obtTipoOficios()
    {
        return $this->db->get('Tb_Cat_TipoOficio')->result();
    }

    /**
     * Guarda en la Bd que se cargo el Acuse
     * 
     * @param object $oficio objeto de campos a actualizar
     * @param int $id identificador del oficio
     * 
     * @return void
     */
    function subir_oficio($oficio, $id)
    {
        $this->db->where('id', $id);
        $this->db->set($oficio);
        $this->db->update('Tb_Oficios');
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

    /**
     * acorta la cadena de un texto
     * 
     * @param string $cadena cadena a acortar
     * @param int    $limite cantidad de caracteres
     * 
     * @return string
     */
    function limitar_cadena($cadena, $limite)
    {
        // Si la longitud es mayor que el límite...
        if(strlen($cadena) > $limite) {
            // Entonces corta la cadena y ponle el sufijo
            return substr($cadena, 0, $limite);
        }
        
        // Si no, entonces devuelve la cadena normal
        return $cadena;
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
        if($estatus == 4) {
            $esta = ' <span data-toggle="modal" data-target="#modalStatus" class="btn badge btn-danger badge-pill mb-2"><i class="fa fa-close "></i> Cancelado</span>';
            return $esta;
        }
    }

    function correo_ticket_cerrado($folio, $fecha, $hora)
    {
    
    }
}
