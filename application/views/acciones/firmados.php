<?php if (isset($_GET['nOficio'])) { ?>

    <script>
        $(function() {
            alertify
                .alert(
                    "<h3><B><i class='fa fa-check' style='color: green;' ></i> <?php echo $_GET['nOficio'] ?></B></h3> Guardado con exito ",
                    function() {

                    });
        })
    </script>
<?php } ?>


<div class="content-wrapper">

    <div class="page-content fade-in-up">
        <div class="flexbox-b mb-5">
            <span class="mr-4 static-badge badge-primary"><i class=" ti-pencil "></i></span>
            <div>
                <h5 class="font-strong">Pendientes de Firma</h5>
                <div class="text-light">Lista de los oficios pendientes de firma</div>
            </div>
        </div>


        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">
                    </div>
                </div>


                <div class="ibox-body">
                    <div class="table-responsive row ">
                        <div class="flexbox mb-4">


                        </div>

                        <div id="datatable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">

                            <table class="table table-bordered table-striped table-hover dataTable no-footer dtr-inline" id="datatable" role="grid" aria-describedby="datatable_info">

                                <thead class="thead-default thead-lg">
                                    <tr role="row">
                                        <th>CONS.</th>
                                        <th>SOLICITA</th>
                                        <th>OFICIO</th>
                                        <th>DESTINATARIO</th>
                                        <th>DEPENDENCIA</th>
                                        <th>FECHA CAPTURA</th>

                                        <th>FIRMADOS</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>


                            <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>







    <script>
        const idioma = {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando _START_ al _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando _START_ al _END_ de _TOTAL_ registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Filtrar por:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            buttons: {
                copyTitle: 'Los datos fueron copiados',
                copyInfo: {
                    _: 'Copiados %d filas al portapapeles',
                    1: 'Copiado 1 fila al portapapeles',
                }
            }
        };

        function obtOficios() {

            $('#datatable').DataTable({
                ajax: {
                    url: '<?php echo base_url() ?>Inicio/obtOficiosFirma?anio=',
                    dataSrc: ''
                },
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excelHtml5',

                    },
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                    },
                    {
                        extend: 'print',

                    }

                ],

                columns: [{
                        data: 'consecutivo'
                    },
                    {
                        data: 'dRemitente'
                    },
                    {
                        data: 'oficio'
                    },
                    {
                        data: 'destinatario'
                    },
                    {
                        data: 'dependencia'
                    },
                    {
                        data: 'fecha_cap'
                    },

                    {
                        data: 'acciones'
                    }
                ],
                "deferRender": true,
                "language": idioma,
                stateSave: true,
                responsive: true
            });

        }
    </script>

    <script>
        $(function() {
            $("#year").val(<?php echo date('Y') ?>);
            obtOficios(<?php echo date('Y') ?>);


        });

        $("#year").change(function() {
            anio = $("#year").val();
            $("#datatable").dataTable().fnDestroy();
            obtOficios(anio);
            $("#etiquetaAnual").html(anio);

        });

        const marcaFirmado = (id) => {

            data = {
                pk: id,
                name: 'estatus',
                value: 3
            };

            $.ajax({
                type: "POST",
                dataType: 'JSON',
                url: '<?php echo base_url() ?>oficios/editarOficio',
                data,
                beforeSend: () => {},
                success: (resp) => {
                    $("#datatable").dataTable().fnDestroy();
                    obtOficios();
                }
            });

        }
    </script>