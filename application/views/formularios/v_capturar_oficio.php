


 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
 <div class="page-heading">
                <h1 class="page-title">Registrar Nuevo Envio de Copias:</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index-2.html"><i class="la la-home font-20"></i></a>
                    </li>
                    <li class="breadcrumb-item">Mensajeria</li>
                    <li class="breadcrumb-item">Nueva Copia</li>
                </ol>
                <br>
    </div>

        <form enctype="multipart/form-data" role="form" action="<?base_url()?>index.php?/oficios/verifica_registroOficio" method="post" id="form_newsletter">
    <!-- Main content -->
 <section class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-10">
                <div class="ibox ibox-fullheight">
                    <div class="ibox-head">
                        <div class="ibox-title">Datos del Oficio</div>
                    </div>
                    <div class="ibox-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="col-form-label">Numero de Oficio:</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon">A.G./</span> 
                                    <input class="form-control form-control-solid" min="<?=$consecutivo?>" max="9999"  id="oficio" value="<?=$consecutivo?>" name="oficio" type="number" placeholder="">
                                    <span class="input-group-addon">/<?=date('Y')?></span> 
                                </div>
                            </div>

                            <div class="form-group col-sm-7 mb-4 row">
<!--                                 <label class="col-sm-12 col-form-label">Subir Archivo:</label>
                                <div class="col-sm-12">
                                <input type="file" class="form-control form-control-solid" name="documento" />
                                </div> -->
                            </div>
                            <div class="col-sm-12">
                                <label class="col-form-label">Dependencia:</label>
                                <div class="input-group mb-3">
                                    <select name="dependencia" id="dependencia" class="form-control select2_demo_1">
                                        <option value="0">Seleccione para que dependencia</option>
                                        <? foreach ($centros as $centro) {?>
                                        <option value="<?=$centro->id?>"><?=$centro->nombre?></option>
                                        <? }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 form-group">
                                <label class=" col-form-label col-sm-2">Enviado a:</label>
                                <input type="text" class="form-control-sm col col-sm-7 form-control-solid " name="responsable" id="responsable">
                            </div>
                            <div class="col-sm-12 form-group">
                                <label class=" col-form-label col-sm-2">Puesto:</label>
                                <input type="text" class="form-control-sm col col-sm-7 form-control-solid " name="puesto" id="puesto">
                            </div>
                            <div class="col-sm-12 form-group">
                                <label class=" col-form-label col-sm-2">Asunto:</label>
                                <textarea class="form-control-sm form-control-solid col-sm-9" name="asunto" id="asunto"></textarea>
                            </div>
                            <div class="col-sm-12 form-group">
                                <label class=" col-form-label col-sm-2">Exp.:</label>
                                <input type="text" class="form-control-sm col col-sm-7 form-control-solid " name="exp" id="exp">
                            </div>
                        </div>
                    </div>
                    <div class="ibox-footer">
                        <button  id="btn" data-toggle="modal" data-target="#cerrar"  type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Guardar </button>
                        </form>
                        <a class="btn btn-danger" href="/mensajeria">Cancelar</a>
                    </div>
                </div>
            </div>
</section>


<!-- /.content -->
 <script src="<?=base_url()?>src/assets/js/scripts/form-plugins.js"></script>
<!-- /.content-wrapper -->
    <script>
        $(function() {
            $('#summernote').summernote({
                 height: 100
            });
        });
    </script>
 

