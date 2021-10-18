<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="page-heading">
        <h1 class="page-title">Capturar Oficio:</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index-2.html"><i class="la la-home font-20"></i></a>
            </li>
            <li class="breadcrumb-item">Bases</li>
            <li class="breadcrumb-item">Libro Oficios</li>
        </ol>
        <br>
    </div>

    <form enctype="multipart/form-data" role="form" action="capturarOficio" method="POST" id="form_newsletter">
        <!-- Main content -->
        <section class="page-content fade-in-up">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-7">
                    <div class="ibox ibox-fullheight">
                        <div class="ibox-head">
                            <div class="ibox-title">Datos del Oficio</div>
                        </div>
                        <div class="ibox-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <label class="col-form-label">Numero de Oficio:</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-addon">A.G./</span>
                                        <input class="form-control form-control-solid disabled"
                                            min="<?php echo $consecutivo?>" max="9999" id="oficio"
                                            value="<?php echo $consecutivo?>" name="oficio" type="number"
                                            placeholder="">
                                        <span class="input-group-addon">/<?php echo date('Y')?></span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label class="col-form-label">Dependencia:</label>
                                    <div class="input-group mb-3">
                                        <select required name="dependencia" id="dependencia"
                                            class="form-control select2_demo_1" onchange="obt_responsable(this.value)">
                                            <option value="0">Seleccione para que dependencia</option>
                                            <?php foreach ($centros as $centro) {?>
                                            <option value="<?php echo $centro->id?>"><?php echo $centro->nombre?>
                                            </option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label class=" col-form-label col-sm-2">Enviado a:</label>
                                    <input required type="text" class="form-control-sm col col-sm-7 form-control-solid "
                                        name="destinatario" id="destinatario">
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label class=" col-form-label col-sm-2">Cargo:</label>
                                    <input required type="text" class="form-control-sm col col-sm-7 form-control-solid "
                                        name="cargo" id="cargo">
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label class=" col-form-label col-sm-2">Asunto:</label>
                                    <textarea required class="form-control-sm form-control-solid col-sm-9" name="asunto"
                                        id="asunto"></textarea>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label class=" col-form-label col-sm-2">Exp.:</label>
                                    <input type="text" class="form-control-sm col col-sm-7 form-control-solid "
                                        name="exp" id="exp">
                                </div>
                            </div>
                        </div>
                        <div class="ibox-footer">
                            <button id="btn" data-toggle="modal" data-target="#cerrar" type="submit"
                                class="btn btn-success">
                                <i class="fa fa-save"></i> Guardar </button>
    </form>
    <a class="btn btn-danger" href="/mensajeria">Cancelar</a>
</div>
</div>
</div>
</section>




<script>
$(function() {
    setInterval('actualizarCons()', 5000);

    $('#summernote').summernote({
        height: 100
    });
});
</script>

<script>
function actualizarCons() {
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: '<?php echo base_url() ?>oficios/obtConsecutivo',
    }).done(function(respuesta) {
        valor = $("#oficio").val();
        if (valor != respuesta) {
            alertify.error('¡EL CONSECUTIVO ACABA DE ACTUALIZARSE AL ' + respuesta + '!');
            $("#oficio").val(respuesta);
        }

    })
}

function obt_responsable(id) {
    data = {
        id
    };
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: '<?php echo base_url() ?>oficios/obtDatosDependencia',
        data,
        beforeSend: () => {},
        success: (resp) => {
            $("#destinatario").val(resp.responsable);
            $("#cargo").val(resp.cargo);
        }
    });
}
</script>

<script src="<?php echo base_url()?>src/assets/js/scripts/form-plugins.js"></script>
