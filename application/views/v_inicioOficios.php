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
            <a href="<?=base_url()?>index.php?/oficios/nueva_captura">
            <div class="card btn-info">
                <div class="card-body">
                    <h2 class="text-white">Capturar Oficio <i class=" ti-agenda  float-right"></i></h2>
                    <div class="text-white mt-1"><i class="ti-stats-up mr-1"></i><small> Capture Nuevo Oficio</small></div>
                </div>
                <div class="progress mb-2 widget-dark-progress">
                    <div class="progress-bar" role="progressbar" style="width:100%; height:5px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 mb-4">
            <a href="<?=base_url()?>index.php?/oficios/nuevo_oficio">
            <div class="card btn-warning">
                <div class="card-body">
                    <h2 class="text-white">Generador de Oficios <i class=" ti-wand float-right"></i></h2>
                    <div class="text-white mt-1"><i class="ti-stats-up mr-1"></i><small> Capture Nuevo Oficio</small></div>
                </div>
                <div class="progress mb-2 widget-dark-progress">
                    <div class="progress-bar" role="progressbar" style="width:100%; height:5px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            </a>
        </div>       

    </div>
        

<!-- TABLAS --->
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Oficios Generados</div>
                </div>
            <div class="ibox-body">
                <div class="flexbox mb-4">
                    <div class="flexbox"></div>
                    <div class="input-group-icon input-group-icon-left mr-3">
                        <span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span>
                        <input class="form-control form-control-rounded form-control-solid" id="key-search" type="text" placeholder="Buscar ...">
                    </div>
                </div>
                <div class="table-responsive row">
                    <div id="datatable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                        <table class="table table-bordered table-hover dataTable no-footer dtr-inline" id="datatable" role="grid" aria-describedby="datatable_info" >
                            <thead class="thead-default thead-lg">
                                <tr role="row">
                                    <th>
                                        OFICIO
                                    </th>
                                    <th>
                                      DESTINATARIO
                                    </th>
                                    <th>
                                      CARGO
                                    </th>                                    
                                    <th>
                                     TIPO
                                    </th>
                                    <th>
                                     FECHA CAPTURA   
                                    </th>
                                    <th>
                                     ESTATUS
                                    </th>
                                    <th>
                                        
                                    </th>                        
                                  </tr>
                                </thead>
                                <tbody>
                                  <? foreach ($oficios as $o) 
                                   {
                                    $fecha = $this->m_ticket->fecha_text($o->fecha_captura . " " . $o->hora_captura);
                                    $estatus = $this->m_oficios->estatus($o->estatus);
                                    ?>                                    
                                    <tr class="">
                                      <td ><?=$o->consecutivo?></td>
                                      <td><?=strtoupper($o->dependencia_solicitante)?></td>
                                      <td><?=strtoupper($o->dependencia_receptor)?></td>
                                      <td><?=$o->asunto?></td> 
                                      <td><?=$fecha?></td>
                                      <td align="center"><?=$estatus?></td>
                                      <td width="120px">
                                        <a href="<?=base_url()?>index.php/oficios/genera_PDF/<?=$o->id?>" target="_blank" class="btn btn-sm" data-toggle="tooltip" title="Imprimir Oficio"><i class="fa fa-print"></i></a>
                                        <a class="btn btn-sm " data-toggle="tooltip" title="Editar y Seguimiento"><i style="color: brown;" class="fa fa-pencil"></i></a>
                                        <a class="btn btn-sm " data-toggle="tooltip" title="Acuse"><i style="color: red" class="fa fa-file-pdf-o"></i></a>            
                                      
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
            </div>

    </div>

    </section>

            

 <script src="<?=base_url()?>src/js/reportes.js"></script>
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

