<form id="frmAsociaTicket">
    <div class="modal fade" id="modAsociarTicket" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title " align="center">Asociar ticket de servicio</h4>
                </div>
                <div class="modal-body">
                    <p>Asocie el oficio a un ticket de servicio</p>
                    <div class="row form-group">
                        <div class="col-sm-6">
                            <input type="number" name="ticketAsc" id="ticketAsc" required="" class="form-control" placeholder="Numero de Ticket de servicio">
                        </div>
                        <div class="col-5">
                            <label class="checkbox checkbox-grey checkbox-info">
                                <input type="checkbox" id="chkdatos" name="chkdatos" checked="">
                                <span class="input-span"></span>Pracargar datos</label>
                        </div>
                    </div>
                    <div class="form-group row">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col">
                        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar </button>
                    </div>
                    <div class="col">
                        <button type="button" id="btnAsociaTicket" class="btn btn-success pull-left btn-block"> Asociar
                            ticket</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- SUBE ACUSE DEL OFICIO -->
<form id="frmModificarOficio" enctype="multipart/form-data" method="POST" action="<?= base_url() ?>oficios/subirOficios">
    <div class="modal fade" id="modificarOficio" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Subir Acuse</h4>
                </div>
                <div class="modal-body">
                    <h3 align="center" class="title">Cargue el Acuse de este Oficio</h3>
                    <div id="mensaje"></div>
                    <br>
                    <input type="file" name="pdf" id="pdf" data-browse-on-zone-click="true" data-allowed-file-extensions='["pdf", "jpg", "jpeg"]' required="true">
                    <input type="hidden" name="actualizaId" value="<?= $oficio->id ?>">
                    <input type="hidden" name="consecutivo" value="<?= $oficio->consecutivo ?>">
                    <input type="hidden" name="tipo" value="1">
                </div>
                <div class="modal-footer">
                    <div class="col">
                        <button type="button" class="btn btn-danger btn-block " data-dismiss="modal">
                            <i class="fa fa-close"></i> Cancelar
                        </button>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="ti-save"></i> Guardar
                        </button>
                    </div>


                </div>
            </div>
        </div>
    </div>
</form>


<!-- SUBE ARCHIVO ORIGINAL PARA COPIA DE CONOCIMEINTO -->
<form id="frmSubirOriginal" enctype="multipart/form-data" method="POST" action="<?= base_url() ?>oficios/subirOficios">
    <div class="modal fade" id="subirOriginal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Subir Oficio Original</h4>
                </div>
                <div class="modal-body">
                    <h4 align="" class="title">Cargue el oficio firmado para envío de copias de conocimiento</h4>
                    <br>
                    <p align="center" class="text-danger">Este documento es obligatorio para poder ser recibido por parte de mensajería</p>
                    <div id="mensaje"></div>
                    <br>
                    <input type="file" name="pdf" id="pdf" accept=".pdf" required="true">
                    <input type="hidden" name="actualizaId" value="<?= $oficio->id ?>">
                    <input type="hidden" name="consecutivo" value="<?= $oficio->consecutivo ?>">
                    <input type="hidden" name="tipo" value="2">
                </div>
                <div class="modal-footer">
                    <div class="col">
                        <button type="button" class="btn btn-danger btn-block " data-dismiss="modal">
                            <i class="fa fa-close"></i> Cancelar
                        </button>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-success btn-block">
                            <i class=" ti-upload"></i> Subir
                        </button>
                    </div>


                </div>
            </div>
        </div>
    </div>
</form>

<form id="frmCambiarEstatus" enctype="multipart/form-data" method="POST" action="<?= base_url() ?>oficios/cambiarEstatus">
    <div class="modal fade" id="cambiarEstatus" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Cambiar Estatus</h4>
                </div>
                <div class="modal-body">
                    <h4 align="center" class="title">Cambie el Estatus del Oficio</h4>
                    <div id="mensaje"></div>
                    <br>

                    <select required class=" form-control  " name="estatus">
                        <option value="">
                            Estatus
                        </option>
                        <? foreach ($estatus as $e) { ?>
                            <option value="<?= $e->id ?>"> <?= $e->estatus ?> </option>
                        <? } ?>

                    </select>

                    <input type="hidden" name="id" value="<?= $oficio->id ?>">

                </div>
                <div class="modal-footer">
                    <div class="col">
                        <button type="button" class="btn btn-danger btn-block " data-dismiss="modal">
                            <i class="fa fa-close"></i> Cancelar
                        </button>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="ti-save"></i> Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>