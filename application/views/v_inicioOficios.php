<?php if (isset($_GET['nOficio'])) { ?>

<script>
$(function() {
    alertify
        .alert("Numero de Oficio Guardado",
            `<p align="center"><h3> <b>
                <i class='fa fa-check' style='color: green;' ></i>
                 <?php echo $_GET['nOficio'] ?>
                 </b> Guardado con exito</h3> <p/>           
                 
                 <button class="btn btn-primary" id="btnFirma" onclick="marcaAfirma(<?=$_GET['id']?>)">Mandar a Firma</button>`,
            function() {

            });
})
</script>
<?php } ?>


<div class="content-wrapper">

    <div class="page-content fade-in-up">
        <div class="flexbox-b mb-5">
            <span class="mr-4 static-badge badge-danger"><i class="ti-files"></i></span>
            <div>
                <h5 class="font-strong">Libro Oficios</h5>
                <div class="text-light">Lista de todos los oficios expedidos</div>
            </div>
        </div>


        <!-- Main content -->

        <!-- BOTONES DE ACCION GENERAL -->
        <div class="row">
            <div class="col-lg-4 col-md-4 mb-4">
                <a href="<?php echo base_url() ?>oficios/nuevaCaptura">
                    <div class="card bg-info">
                        <div class="card-body">
                            <h2 class="text-white">Capturar Oficio <i class="ti-list float-right"></i></h2>
                            <div class="text-white mt-1"><i class="ti-stats-up mr-1"></i><small> Capture Nuevo
                                    Oficio</small></div>
                        </div>
                        <div class="progress mb-2 widget-dark-progress">
                            <div class="progress-bar" role="progressbar" style="width:100%; height:5px;"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Oficios Capturados durante el año
                        <span id="etiquetaAnual"><?php echo date('Y') ?></span>
                    </div>
                </div>


                <div class="ibox-body">
                    <div class="table-responsive row ">
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

                        <div id="datatable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">

                            <table class="table table-bordered table-striped table-hover dataTable no-footer dtr-inline"
                                id="datatable" role="grid" aria-describedby="datatable_info">

                                <thead class="thead-default thead-lg">
                                    <tr role="row">
                                        <th>CONS.</th>
                                        <th>SOLICITA</th>
                                        <th>OFICIO</th>
                                        <th>DESTINATARIO</th>
                                        <th>DEPENDENCIA</th>
                                        <th>FECHA CAPTURA</th>
                                        <th>ASUNTO</th>
                                        <th>ESTATUS</th>
                                        <th></th>
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

    function obt_oficios(year) {

        $('#datatable').DataTable({
            ajax: {
                url: '<?php echo base_url() ?>oficios/obt_oficios?anio=' + year,
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
                    data: 'asunto'
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
            responsive: true
        });

    }
    </script>

    <script>
    $(function() {
        $("#year").val(<?php echo date('Y') ?>);
        obt_oficios(<?php echo date('Y') ?>);


    });

    $("#year").change(function() {
       let anio = $("#year").val();
        $("#datatable").dataTable().fnDestroy();
        obt_oficios(anio);
        $("#etiquetaAnual").html(anio);

    });


    const marcaAfirma = (id) => {
       let anio = $("#year").val();
       let btn = $("#btnFirma");
        console.log(id);

        data = {
            pk: id,
            name: 'estatus',
            value: 2
        };

        $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: '<?php echo base_url() ?>oficios/editarOficio',
            data,
            beforeSend: () => {},
            success: (resp) => {
                $("#datatable").dataTable().fnDestroy();
                obt_oficios(anio);

                btn.addClass('btn-success disabled');
                btn.html(`<i class="fa fa-check-circle"></i> HECHO`);
                btn.attr('disabled');


            }
        });

    }

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