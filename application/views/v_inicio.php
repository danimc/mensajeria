<div class="content-wrapper">
   <!-- Content Header (Page header) -->

          <!-- Main content -->
    <section class="page-content fade-in-up">  

<!-- BOTONES DE ACCION -->
    <div class="row"> 
        <div class="col-lg-4 col-md-4 mb-4">
            <a href="<?php echo base_url()?>oficios">
             <div class="card btn-danger">
                <div class="card-body">
                    <h2 class="text-white">Libro Oficios<i class=" ti-archive float-right"></i></h2>
                    <div class="text-white mt-1"><i class="ti-stats-up mr-1"></i><small>Consulte los oficios emitidos</small></div>
                </div>
                <div class="progress mb-2 widget-dark-progress">
                    <div class="progress-bar" role="progressbar" style="width:100%; height:5px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
                </a>                 
        </div>       
        <div class="col-lg-4 col-md-4 mb-4">
            <a href="<?php echo base_url()?>index.php?/mensajeria/nueva_copia">
            <div class="card btn-primary">
                <div class="card-body">
                    <h2 class="text-white">Alta Mensajeria <i class="ti-file float-right"></i></h2>
                    <div class="text-white mt-1"><i class="ti-stats-up mr-1"></i><small>Registre un Oficio a mandar</small></div>
                </div>
                <div class="progress mb-2 widget-dark-progress">
                    <div class="progress-bar" role="progressbar" style="width:100%; height:5px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
                </a>
        </div>

        <div class="col-lg-4 col-md-4 mb-4">
            <a href="<?php echo base_url()?>index.php?/mensajeria/lista_mensajes">
             <div class="card btn-info">
                <div class="card-body">
                    <h2 class="text-white">Mensajeria estatus<i class=" ti-folder float-right"></i></h2>
                    <div class="text-white mt-1"><i class="ti-stats-up mr-1"></i><small>ver los oficios mandados</small></div>
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
        <div class="col-xl-7">
            <div class="ibox ibox-fullheight">
                <div class="ibox-head">
                    <div class="ibox-title">TICKETS ASIGNADOS</div>
                    <div class="ibox-tools">
                        <a class="dropdown-toggle font-18" data-toggle="dropdown"><i class="ti-ticket"></i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                        </div>
                    </div>
                </div>
                <div class="ibox-body">
                    <ul class="media-list media-list-divider scroller mr-2" data-height="470px">
     <?php
        foreach ($tPendientes as $pendiente) {
            $estatus = $this->m_inicio->etiqueta($pendiente->estatus);
            $datetime = $pendiente->fecha_inicio . ' ' . $pendiente->hora_inicio;
            $hora = $this->m_ticket->fecha_text($datetime);
            $badge = '';

            if ($pendiente->prioridad == 4) {
                        $badge = '<small><span style="color: red"><i class="fa fa-exclamation-circle" ></i> Urgente!</span></small>';
            } 
            if ($pendiente->prioridad == 3) {
                $badge = '<small><span style="color:orange"><i class="fa fa-warning" ></i> Alta!</span></small>';
            } ?>
                        
                        <li class="media">
                            <div class="media-body d-flex">
                                <div class="flex-1">
                                    <h5 class="media-heading">
                                        <a href="<?php echo base_url()?>ticket/seguimiento/<?php echo $pendiente->folio?>">
                                            #<?php echo $pendiente->folio?>: <?php echo $pendiente->titulo?></a> 
                                <?php echo $badge?>
                                    </h5>
                                    <p class="font-13 text-light mb-1"><?php echo strip_tags($pendiente->descripcion);?></p>
                                    <div class="d-flex align-items-center font-13">
                                        <img class="img-circle mr-2" src="<?php echo base_url()?>src/img/usr/<?php echo $pendiente->img?>" alt="image" width="22" />
                                        <a class="mr-2 text-success" data-toggle="tooltip" title="Usuario Asignado" href="javascript:;"><?php echo $pendiente->usr_asignado?></a>
                                        <span class="text-muted"><?php echo $hora?></span>
                                    </div>
                                </div>
                                <div class="text-right" style="width:100px;">
                                    <a href="<?php echo base_url()?>ticket/seguimiento/<?php echo $pendiente->folio?>"> 
                            <?php echo $estatus?>
                                    </a> 
                                </div>
                            </div>
                        </li> <?php
        } ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="ibox ibox-fullheight">
                <div class="ibox-head">
                    <div class="ibox-title">TICKETS ABIERTOS </div>
                </div>
                <div class="ibox-body">
                    <ul class="timeline scroller" data-height="470px">        <?php 
                    
                    foreach ($tGeneral as $pendiente) {
                        $estatus = $this->m_inicio->etiqueta($pendiente->estatus); 
                        $badge1 = "";
                        if ($pendiente->prioridad == 4) {
                            $badge1 = '<small><span style="color: red"><i class="fa fa-exclamation-circle" ></i> Urgente!</span></small>';
                        }
                        if ($pendiente->prioridad == 3) {
                            $badge1 = '<small><span style="color:orange"><i class="fa fa-warning" ></i> Alta!</span></small>';
                        } ?>
                        
                        <li class="timeline-item" data-toggle="tooltip" title="CANAL DE ATENCIÓN: <?php echo $pendiente->canal?>">
                            <span class="timeline-point"></span>
                            <a href="<?php echo base_url()?>ticket/seguimiento/<?php echo $pendiente->folio?>">
                                #<?php echo $pendiente->folio?>: <?php echo $pendiente->titulo?><?php echo $badge1?></a> 
                            <small class="float-right text-muted ml-2 nowrap">
                                <a href="<?php echo base_url()?>ticket/seguimiento/<?php echo $pendiente->folio?>">
                                    <?php echo $estatus?>
                                </a>
                            </small> 
                        </li> <?php
                    } ?>
                    
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row"> 
    </div>
   
            

<!-- TABLAS --->
                  
              </section>
