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
        <a href="<?php echo base_url("oficios") ?>" class="btn btn-blue "><i class="fa fa-arrow-left"></i> </a>
        <button href="#" id="btnEditar" value="<?php echo $oficio->id ?>" class="btn btn-warning">
            <i class="fa fa-edit"></i>
            Editar Captura
        </button>
        <!-- <a href="#" class="btn btn-info" data-toggle="modal" data-target="#modAsociarTicket"
            title="Asociar a un ticket de Servicio"><i class="fas fa-ticket-alt"></i> Asociar Ticket
        </a>-->

        <a href="#" class="btn btn-primary hidden" id="btnEnviarFirma" title="Subir Acuse y cambiar estatus a 'Entregado'">
            <i class="fa fa-pencil "></i>
            Mandar a Firma
        </a>



        <button class="btn btn-pink dropdown-toggle dropdown-arrow" data-toggle="dropdown" aria-expanded="false" id="btnAcciones">
            <i class="fa fa-gear"></i>
            Cambiar estado del oficio
        </button>
        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 37px, 0px); top: 0px; left: 0px; will-change: transform;">
            <h6 class="dropdown-header">Estatus de oficio</h6>
            <a class="dropdown-item" href="javascript:;" id="btnOficioFirmado">Firmado</a>
            <a class="dropdown-item" href="javascript:;" id="btnAmensajeria">Enviado a mensajería</a>
            <a class="dropdown-item" href="javascript:;" id="btnAcuseRecibido">Acuse Recibido</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="javascript:;" id="btnMarcarPendiete">Marcar como pendiente</a>
        </div>





        <a href="#" data-toggle="modal" data-target="#frmModificarOficio" class="btn btn-danger disabled pull-right">
            <i class="fa fa-times-circle"></i>
            CANCELAR OFICIO
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
                            <div class="col-6"> <b> <?php echo $oficio->oficio ?> </b> </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Fecha de captura</div>
                            <div class="col-6"> <b>
                                    <?php echo $this->m_oficios->fechaText($oficio->fechaOficio)  ?> </b>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Tipo de Oficio:</div>
                            <div class="col-6">
                                <a href="javascript:;" class="bt-tipo" data-name="tipo" data-type="select" data-title="Edite el tipo de oficio"> <?php echo $oficio->tipo ?> </a>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Dependencia:</div>
                            <div class="col-6">
                                <a href="javascript:;" class="bt-dependencia" data-name="nombreDependencia" data-type="select" data-title="Modifique la Dependencia">
                                    <?php echo $oficio->dependencia ?> </a>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Destinatario:</div>
                            <div class="col-6">
                                <a href="javascript:;" class="bt-destinatario" data-name="destinatario" data-type="text" data-title="Edite el Destinatario"> <?php echo $oficio->destinatario ?></a>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Cargo:</div>
                            <div class="col-6">
                                <a href="javascript:;" class="bt-cargo" data-name="cargo" data-type="text" data-title="Edite el cargo del destinatario"> <?php echo $oficio->cargo ?></a>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Oficio Recibido: </div>
                            <div class="col-6">
                                <a href="javascript:;" class="bt-recibido" data-name="oficioRecibido" data-type="text" data-title="Ingrese el oficio Recibido"> <?php echo $oficio->oficioRecibido ?></a>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Folio :</div>
                            <div class="col-6">
                                <a href="javascript:;" class="bt-folio" data-name="folio" data-type="number" data-title="Ingrese el Folio"> <?php echo $oficio->folio ?></a>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Estatus :</div>
                            <div class="col-6">
                                <span id="lblEstatus"></span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">Redacción :</div>
                            <div class="col-6">
                                <a href="javascript:;" class="bt-redaccion" data-name="redaccion" data-type="wysihtml5" data-title="Edite la redaccion del oficio"> <?php echo $oficio->redaccion ?></a>
                            </div>
                        </div>

                    </div>
                </div>

                <? if ($copias) { ?>
                    <div class="ibox">
                        <div class="ibox-head bg-primary-100 ">
                            <div class="ibox-title">COPIAS DE CONOCIMIENTO:</div>
                        </div>
                        <div class="ibox-body">
                            <? foreach ($copias as $copia) { ?>
                                <div class="row mb-2">
                                    <div class="col-9"> <b> <?= $copia->nombre ?> </b> </div>
                                    <? if (isset($copia->fecha_envio)) {
                                        $fecha = $this->m_mensajeria->fecha_text_f($copia->fecha_envio) ?>
                                        <div class="col-3 text-muted" data-toggle="tooltip" title="Fecha de Envio: <?= $fecha ?>">
                                            Enviado</div>
                                    <? } ?>
                                </div>
                                <hr>
                            <? } ?>

                        </div>
                    </div>
                <? } ?>

                <div class="ibox">
                    <div class="ibox-head bg-pink-100">
                        <div class="ibox-title">Seguimiento</div>

                    </div>
                    <div class="ibox-body">
                        <? foreach ($historial as $h) {
                            $fecha = $this->m_mensajeria->fecha_text_f($h->fecha); ?>
                            <div class="row mb-2">
                                <div class="col-9"> <b> <?= $h->usuario ?></b> <?= $h->label ?> </div>


                                <div class="col-3 text-muted" data-toggle="tooltip" title="Fecha de movimiento">
                                    <?= $h->fecha ?>
                                </div>

                            </div>
                            <hr>
                        <? } ?>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">
                            <a href="#" class="btn btn-success hidden " data-toggle="modal" data-target="#modificarOficio" title="Subir Acuse y cambiar estatus a 'Entregado'" id="btnSubirAcuse">
                                <i class="fa fa-upload"></i> Subir Acuse
                            </a>
                        </div>

                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="ti-angle-down"></i></a>
                            <a class="fullscreen-link"><i class="ti-fullscreen"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <?php if (isset($pdf[1])) { ?>

                            <div class="text-center centered" style="max-width:600px;">
                                <div class="btn-group">
                                    <a class="btn btn-secondary" target="_blank" href="<?php echo base_url() ?>src/librooficios/2021/<?php echo $oficio->consecutivo ?>.pdf">
                                        <span class="d-none d-md-inline">Descargar</span>
                                    </a>
                                    <button class="btn btn-secondary" id="prev"><i class="fa fa-long-arrow-left"></i>
                                        <span class="d-none d-md-inline">Anterior</span>
                                    </button>
                                    <button class="btn btn-secondary" id="next">
                                        <span class="d-none d-md-inline">Siguiente</span> <i class="fa fa-long-arrow-right"></i></button>

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
                                if (isset($pdf[1]) && $pdf[1] == "pdf") { ?>
                                    <canvas class="pdfcanvas" id="the-canvas"></canvas>
                                <?php } else { ?>
                                    <img src="<?php echo base_url() ?>src/librooficios/2021/<?php echo $oficio->consecutivo ?>.pdf" alt="Oficio">
                                <?php }
                                ?>
                            </div>

                        <?php } else { ?>
                            <a href="#" data-toggle="modal" data-target="#modificarOficio" title="Subir Oficio">
                                <h1 class="text-secondary text-center"><i class="fa fa-upload fa-3x"></i></h1>
                            </a>
                            <br>
                            <h2 class="text-secondary text-center">Aún no se ha subido el acuse de este oficio</h2>


                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>

        <script>
            $(function() {
                let pdf = window.location.origin +
                    '/bases/documents/acuses/2021/<?php echo $oficio->consecutivo ?>.pdf';
                console.log(pdf);
                ver_pdf(pdf);
            })
        </script>




        <script src="<?php echo base_url() ?>src/js/dist/oficios.js" type="module"></script>