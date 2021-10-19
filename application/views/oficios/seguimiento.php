<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="page-heading">
        <h1 class="page-title">Edición y Seguimiento:</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index-2.html"><i class="la la-home font-20"></i></a>
            </li>
            <li class="breadcrumb-item">Ctrl Oficios</li>
            <li class="breadcrumb-item">Edición y Seguimiento de Oficio</li>
        </ol>
        <br>
        <a href="<?php echo base_url() ?>oficios" class="btn btn-blue "><i class="fa fa-arrow-left"></i> </a>
        <button href="#" id="btnEditar" value="<?php echo $oficio->id ?>" class="btn btn-warning"><i
                class="fas fa-edit"></i>
            Editar Captura
        </button>
        <a href="#" class="btn btn-info" data-toggle="modal" data-target="#modAsociarTicket"
            title="Asociar a un ticket de Servicio"><i class="fas fa-ticket-alt"></i> Asociar Ticket
        </a>
        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modificarOficio"
            title="Subir Acuse y cambiar estatus a 'Entregado'"><i class="fas fa-upload"></i> Subir Acuse
        </a>
        <a href="#" data-toggle="modal" data-target="#frmModificarOficio" class="btn btn-danger disabled pull-right"><i
                class="fas fa-times-circle"></i> CANCELAR OFICIO
        </a>

    </div>

    <section class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-5">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Datos del Oficio</div>
                    </div>
                    <div class="ibox-body">
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Numero de Oficio:</div>
                            <div class="col-6"><b><?php echo $oficio->oficio ?></b></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Fecha de captura</div>
                            <div class="col-6"><b>
                                    <?php echo $this->m_ticket->fecha_text($oficio->fechaOficio)  ?></b>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Tipo de Oficio:</div>
                            <div class="col-6">
                                <a href="javascript:;" class="bt-tipo" data-name="tipo" data-type="select"
                                    data-title="Edite el tipo de oficio"> <?php echo $oficio->tipo ?> ---</a>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Dependencia:</div>
                            <div class="col-6">
                                <a href="javascript:;" class="bt-tipo" data-name="tipo" data-type="select"
                                    data-title="Edite el tipo de oficio"> <?php echo $oficio->dependencia ?> </a>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Destinatario:</div>
                            <div class="col-6">
                                <a href="javascript:;" class="bt-destinatario" data-name="destinatario" data-type="text"
                                    data-title="Edite el Destinatario"> <?php echo $oficio->destinatario ?></a>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Cargo:</div>
                            <div class="col-6">
                                <a href="javascript:;" class="bt-cargo" data-name="cargo" data-type="text"
                                    data-title="Edite el cargo del destinatario"> <?php echo $oficio->cargo ?></a>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Oficio Recibido: </div>
                            <div class="col-6">
                                <a href="javascript:;" class="bt-recibido" data-name="oficioRecibido" data-type="text"
                                    data-title="Ingrese el oficio Recibido"> <?php echo $oficio->oficioRecibido ?></a>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Folio :</div>
                            <div class="col-6">
                                <a href="javascript:;" class="bt-folio" data-name="folio" data-type="number"
                                    data-title="Ingrese el Folio"> <?php echo $oficio->folio ?></a>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Estatus :</div>
                            <div class="col-6">
                                <?php echo $this->m_oficios->estatus($oficio->estatus, $oficio->fecha_entrega) ?></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Redacción :</div>
                            <div class="col-6">
                                <a href="javascript:;" class="bt-redaccion" data-name="redaccion" data-type="wysihtml5"
                                    data-title="Edite la redaccion del oficio"> <?php echo $oficio->redaccion ?></a>
                            </div>
                        </div>

                    </div>
                </div>



                <div class="ibox">
                    <div class="ibox-head bg-primary-100 ">
                        <div class="ibox-title">Información del ticket asociado</div>
                    </div>
                    <div class="ibox-body">
                        <div class="row mb-2">
                            <div class="col-6 text-muted"># Servicio:</div>
                            <div class="col-6"><b>---</b></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Título:</div>
                            <div class="col-6">
                                <a data-toggle="tooltip" title="">
                                    <i class="fas fa-info-circle text-secondary pull-right"></i>
                                </a>
                                <b>---</b>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Fecha de Captura:</div>
                            <div class="col-6">---</div>
                        </div>

                    </div>
                </div>


                <div class="ibox">
                    <div class="ibox-head bg-pink-100">
                        <div class="ibox-title">Seguimiento</div>

                    </div>
                    <div class="ibox-body">

                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Vista Previa Oficio</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="ti-angle-down"></i></a>
                            <a class="fullscreen-link"><i class="ti-fullscreen"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <?php if(isset($pdf[1])) {?>

                        <div class="text-center centered" style="max-width:600px;">
                            <div class="btn-group">
                                <a class="btn btn-secondary" target="_blank"
                                    href="<?php echo base_url() ?>src/oficios/oficios/<?php echo $oficio->pdf ?>">
                                    <span class="d-none d-md-inline">Descargar</span>
                                </a>
                                <button class="btn btn-secondary" id="prev"><i class="fa fa-long-arrow-left"></i>
                                    <span class="d-none d-md-inline">Anterior</span>
                                </button>
                                <button class="btn btn-secondary" id="next">
                                    <span class="d-none d-md-inline">Siguiente</span> <i
                                        class="fa fa-long-arrow-right"></i></button>

                                <span class="btn-label-out">Página:</span>
                                <div class="input-group" style="width:auto;">
                                    <input class="form-control" id="page_num" style="max-width:50px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-outline-default" id="page_count">/ 1</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <?php 
                            if(isset($pdf[1]) && $pdf[1] == "pdf") {?>
                            <canvas class="pdfcanvas" id="the-canvas"></canvas>
                            <?php }
                            else {?>
                            <img src="<?php echo base_url() ?>src/oficios/oficios/<?php echo $oficio->pdf ?>"
                                alt="Oficio">
                            <?php }
                            ?>
                        </div>

                        <?php }else{?>
                        <a href="#" data-toggle="modal" data-target="#modificarOficio" title="Subir Oficio">
                            <h1 class="text-secondary text-center"><i class="fa fa-upload fa-3x"></i></h1>
                        </a>
                        <br>
                        <h2 class="text-secondary text-center">Aún no se ha subido el acuse de este oficio</h2>


                        <?php }?>
                    </div>
                </div>
            </div>

        </div>

        <script>
        $(function() {
            let pdf = window.location.origin + '/bases/src/oficios/oficios/<?php echo $oficio->pdf ?>';
            console.log(pdf);
            ver_pdf(pdf);
        })
        </script>




        <script src="<?php echo base_url() ?>src/js/dist/oficios.js" type="module"></script>
