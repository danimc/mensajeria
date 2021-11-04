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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="page-heading">
        <h1 class="page-title">Control de Oficios:</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index-2.html"><i class="la la-home font-20"></i></a>
            </li>
            <li class="breadcrumb-item">Ctrl Oficios</li>
        </ol>
        <br>
    </div>

    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="page-content fade-in-up">
        <!-- BOTONES DE ACCION GENERAL -->
        <div class="row">
            <div class="col-lg-4 col-md-4 mb-4">
                <a href="<?php echo base_url() ?>oficios/nueva_captura">
                    <div class="card bg-info">
                        <div class="card-body">
                            <h2 class="text-white">Capturar Oficio <i class="ti-list float-right"></i></h2>
                            <div class="text-white mt-1"><i class="ti-stats-up mr-1"></i><small> Capture Nuevo
                                    Oficio</small></div>
                        </div>
                        <div class="progress mb-2 widget-dark-progress">
                            <div class="progress-bar" role="progressbar" style="width:100%; height:5px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Oficios Capturados durante el año <span id="etiquetaAnual"><?php echo date('Y') ?></span></div>
                    </div>
                    <div class="ibox-body">
                        <div class="flexbox mb-4">
                            <div class="form-group">
                                <label class="col-form-label "><b>Año:</b></label>
                                <select class="form-control" name="year" id="year">

                                    <?php foreach ($years as $y) { ?>
                                        <option> <?php echo $y->year ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                       
                        </div>
                        <div class="table-responsive row">
                            <div id="datatable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">

                                <div id="tablaOficios">

                                    <table class="table table-bordered table-hover dataTable no-footer dtr-inline" id="datatable" role="grid" aria-describedby="datatable_info">
                                        <thead class="thead-default thead-lg">
                                            <tr role="row">
                                                <th>CONS.</th>
                                                <th>SOLICITA</th>
                                                <th>OFICIO</th>
                                                <th>DESTINATARIO</th>
                                                <th>DEPENDENCIA</th>
                                                <th>FECHA CAPTURA</th>
                                                <th>ASUNTO</th>
                                                <th>EXP</th>
                                                <th>ESTATUS</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>



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

        function obt_oficios(year) {

            $('#datatable').DataTable({
                dom: 'Bfrtip',
                buttons: [
					{
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
                ajax: {
                    url: '<?php echo base_url() ?>oficios/obt_oficios?anio=' + year,
                    dataSrc: ''
                },              
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
                        data: 'asunto'
                    },
                    {
                        data: 'exp'
                    },
                    {
                        data: 'estatus'
                    },
                    {
                        data: 'acciones'
                    }
                ],
                "deferRender": true,
                "language": idioma,
                stateSave: true,
            });

        }
    </script>

    <script>
        $(function() {
            $("#year").val(<?php echo date('Y') ?>);
            obt_oficios(<?php echo date('Y') ?>);


        });

        $("#year").change(function() {
            anio = $("#year").val();
            $("#datatable").dataTable().fnDestroy();
            obt_oficios(anio);
            $("#etiquetaAnual").html(anio);

        });

        /*
        function formatoTabla() {
            $('#datatable').DataTable({
                pageLength: 10,
                fixedHeader: true,
                responsive: true,
                "sDom": 'rtip',
                columnDefs: [{
                    targets: 'no-sort',
                    orderable: false
                }],
            });
            var table = $('#datatable').DataTable();
            $('#key-search').on('keyup', function() {
                table.search(this.value).draw();
            });
            $('#type-filter').on('change', function() {
                table.column(2).search($(this).val()).draw();
            });
        }
        */
    </script>