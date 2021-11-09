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
                            <input type="number" name="ticketAsc" id="ticketAsc" required="" class="form-control"
                                placeholder="Numero de Ticket de servicio">
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
                        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i
                                class="fa fa-close"></i> Cancelar </button>
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


<form id="frmModificarOficio" enctype="multipart/form-data" method="POST"
    action="<?= base_url() ?>oficios/subirAcuse">
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
                    <input type="file" name="pdf" id="pdf" data-browse-on-zone-click="true"
                        data-allowed-file-extensions='["pdf", "jpg", "jpeg"]' required="true">
                    <input type="hidden" name="actualizaId" value="<?= $oficio->id ?>">
                    <input type="hidden" name="consecutivo" value="<?= $oficio->consecutivo ?>">
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