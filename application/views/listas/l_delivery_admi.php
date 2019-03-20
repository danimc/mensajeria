 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
 <div class="page-heading">
                <h1 class="page-title"></h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index-2.html"><i class="la la-home font-20"></i></a>
                    </li>
                    <li class="breadcrumb-item">Tickets</li>
                    <li class="breadcrumb-item">Lista de Tickets</li>
                </ol>
                <br>
    <a href="/oagmvc" class="btn btn-blue btn-icon-only btn-lg"><i class="fa fa-arrow-left"></i></a>
    <a href="<?=base_url()?>index.php?/ticket/nuevo_ticket" class="btn btn-warning btn-icon-only btn-lg "><span class="fa fa-plus"></span></a>
    </div>
  <!-- Main content -->
  <section class="page-content fade-in-up">

    <div class="ibox">
                    <div class="ibox-body">
                        <h5 class="font-strong mb-4">MENSAJES</h5>
                        <div class="flexbox mb-4">
                            <div class="flexbox">
                                <label class="mb-0 mr-2">Filtrar por:</label>
                                <div class="btn-group bootstrap-select show-tick form-control" style="width: 150px;">

                                  <select class="selectpicker show-tick form-control" id="type-filter" title="Please select" data-style="btn-solid" data-width="150px" tabindex="-98">
                                    <option class="bs-title-option" value="">Seleccione una opción</option>
                                    <option value="">Todos</option>
                                    <option>Abierto</option>
                                    <option>En Proceso</option>
                                    <option>Resuelto</option>
                                    <option>Cerrado</option>
                                </select></div>
                            </div>
                            <div class="input-group-icon input-group-icon-left mr-3">
                                <span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span>
                                <input class="form-control form-control-rounded form-control-solid" id="key-search" type="text" placeholder="Buscar ...">
                            </div>
                        </div>
                        <div class="table-responsive row">
                            <div id="datatable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                              <table class="table table-bordered table-hover dataTable no-footer dtr-inline" id="datatable" role="grid" aria-describedby="datatable_info" style="width: 1042px;">
                                <thead class="thead-default thead-lg">
                                    <tr role="row">
                                      <th class="sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 36.3167px;" aria-sort="ascending" aria-label="# Folio: activate to sort column descending">
                                        #
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 103.017px;" aria-label="Order ID: activate to sort column ascending">
                                       Fecha Registro
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 134px;" aria-label="Estatus: activate to sort column ascending">
                                      Estatus
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 125.783px;" aria-label=" Usuario: activate to sort column ascending">
                                       Usuario
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 99.15px;" aria-label="Incidente: activate to sort column ascending">
                                      Dependencia</th>
                                      <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" style="width: 113.117px;" aria-label="Categoria: activate to sort column ascending">
                                        Remitente
                                      </th>

                                      <th class="no-sort sorting_disabled" rowspan="1" colspan="1" style="width: 33.8667px;" aria-label="">
                                        
                                      </th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                  <? foreach ($mensajes as $ticket) 
                                   {
                                    $fecha = $this->m_mensajeria->fecha_text_f($ticket->fecha_alta);
                                    $estatus = $this->m_mensajeria->etiqueta($ticket->estatus);
                                    ?>
                                    <tr class="">
                                      <td ><?=$ticket->folio?></td>
                                      <td  data-toggle = "tooltip" title="Hora de Registro: <?=$ticket->hora_alta?>"><?=$fecha?></td>
                                      <td data-toggle="tooltip"><?=$estatus?></td>
                                      <td ><?=$ticket->usuario?></td>
                                      <td ><?=$ticket->nombre_dependencia?></td>
                                      <td ><?=$ticket->receptor?></td>
                                      <td align="center">
                                        <a class="btn btn-sm btn-danger" href="<?=base_url()?>src/oficios/<?=$ticket->pdf?>" data-toggle = "tooltip"  title="Ver Oficio"><i class="fa  fa-file-pdf-o"></i> </a>

                                        <a class="btn btn-sm btn-info " href="<?=base_url()?>index.php?/mensajeria/seguimiento/<?=$ticket->folio?>" data-toggle = "tooltip"  title="Seguimiento"><i class="fa fa-info"></i> </a>
                                      </td>
                                    </tr>
                                  <?
                                    }
                                  ?>
                                    </tbody>
                            </table>
                            <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
                       </div></div>
                        </div>
                    </div>
                </div>

  </section>


 <script>
        $(function() {
            $('#datatable').DataTable({
                pageLength: 10,
                fixedHeader: true,
                responsive: true,
                "sDom": 'rtip',
                columnDefs: [{
                    targets: 'no-sort',
                    orderable: false
                }]
            });

            var table = $('#datatable').DataTable();
            $('#key-search').on('keyup', function() {
                table.search(this.value).draw();
            });
            $('#type-filter').on('change', function() {
                table.column(2).search($(this).val()).draw();
            });
        });
    </script>

