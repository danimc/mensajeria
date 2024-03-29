


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

        <form enctype="multipart/form-data" role="form" action="<?base_url()?>index.php?/mensajeria/verifica_registroOficio" method="post" id="form_newsletter">
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
                                <label class="col-sm-12 col-form-label">Numero de Oficio:</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon">A.G./</span>
                                    <input class="form-control form-control-solid" name="oficio" type="text" placeholder="1801/2019">
                                </div>
                            </div>

                            <div class="form-group col-sm-7 mb-4 row">
                                <label class="col-sm-12 col-form-label">Subir Archivo:</label>
                                <div class="col-sm-12">
                                <input type="file" class="form-control form-control-solid" name="documento" />
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label class="col-sm-12 col-form-label">Dirigido a:</label>
                                <div class="input-group mb-3">
                                    <select name="receptor" id="receptor" class="form-control select2_demo_1">
                                        <option value="0">Seleccione para que dependencia va el original </option>
                                        <? foreach ($centros as $centro) {?>
                                        <option value="<?=$centro->id?>"><?=$centro->nombre?></option>
                                        <? }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label class="col-sm-12 col-form-label">Con Copia para:</label>
                                <div class="input-group mb-3">
                                     <select name="ccp[]" id="ccp" class="form-control select2_demo_1" multiple="true">
                                        <option value="0">Seleccione los Destinatarios de las copias </option>
                                        <? foreach ($centros as $centro) {?>
                                        <option value="<?=$centro->id?>"><?=$centro->nombre?></option>
                                        <? }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-10">
                <div class="ibox ibox-fullheight">
<!--                     <div class="ibox-body">
                        <div class="row">
                            <div class="form-group mb-4 col-sm-5">
                                <label class="col-sm-12 col-form-label">Descripcion del Incidente: </label>
                                <div class="col-sm-12">
                                    <input class="form-control" name="incidente" type="text" placeholder="Ej. Problema con Word ">
                                </div>
                            </div>
                            <div class="form-group mb-4 col-sm-4 ">
                                <label class="col-sm-12 col-form-label">Categoria: </label>
                                <div class="col-sm-12">
                                    <select name="categoria" id="categoria" class="form-control selectpicker" data-live-search="true">
                        <option >Seleccione una categoria</option>
                        <? foreach ($categorias as $cat) {?>
                                                    <option value="<?=$cat->id_cat?>"><?=$cat->categoria?></option>
                                              <?  }?>
                                        </select>
                            
                                </div>
                            </div>
                            <div class="form-group mb-4 col-sm-2 ">
                                <label class="col-sm-12 col-form-label">Prioridad: </label>
                                <div class="col-sm-12">
                                    <label class="radio radio-success">
                                        <input type="radio" value="1" name="prioridad">
                                        <span class="input-span"></span>Baja
                                    </label>
                                </div>
                                <div class="col-sm-12">
                                    <label class="radio radio-info">
                                        <input type="radio" value="2" name="prioridad" checked>
                                        <span class="input-span"></span>Normal
                                    </label>
                                </div>
                                <div class="col-sm-12">
                                    <label class="radio radio-warning">
                                        <input type="radio" value="3" name="prioridad">
                                        <span class="input-span"></span>Alta
                                    </label>
                                </div>
                                <div class="col-sm-12">
                                    <label class="radio radio-danger">
                                        <input type="radio" value="4" name="prioridad">
                                        <span class="input-span"></span>Urgente!
                                    </label>
                                </div>
                            </div>

                            <div class="form-group mb-4 col-sm-12 ">
                                <label class="col-sm-12 col-form-label">Detalles del Incidente: </label>
                                <div class="col-sm-12">
                                    <textarea id="summernote" placeholder="Escriba aquí todos los detalles del incidente" name="descripcion" data-plugin="summernote" data-air-mode="true">
                        </textarea>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="ibox-footer">
                        <button  id="btn" data-toggle="modal" data-target="#cerrar"  type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Generar Ticket de Servicio
                        </button>
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
 

