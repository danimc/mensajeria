<?
    $fechayHora = $oficio->fecha_alta . ' '. $oficio->hora_alta;
    $fecha = $this->m_mensajeria->fecha_text($fechayHora);
    $estatus = $this->m_mensajeria->etiqueta($oficio->estatus);
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
 <div class="page-heading">
                <h1 class="page-title"></h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index-2.html"><i class="la la-home font-20"></i></a>
                    </li>
                    <li class="breadcrumb-item">Mensajeria</li>
                    <li class="breadcrumb-item">Seguimiento de Mensajeria</li>
                </ol>
                <br>
    <a href="<?=base_url()?>index.php/mensajeria/lista_mensajes" class="btn btn-blue "><i class="fa fa-arrow-left"></i> </a>
    <a href="<?=base_url()?>index.php/mensajeria/validar_original/<?=$folio?>" class="btn btn-success"><i class="fa fa-file-text"></i> Validar Original</a>
    <a href="<?=base_url()?>index.php/mensajeria/enviar_original/<?=$folio?>" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Enviar Original</a>
    <a href="<?=base_url()?>index.php/mensajeria/recibido/<?=$folio?>" data-toggle="modal" data-target="#cerrar" class="btn btn-danger"><i class="fa  fa-mail-forward"></i> Validar de Recibido</a>
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
                                    <div class="col-6"><b>AG/<?=$oficio->oficio?></b></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6 text-muted">Remitente:</div>
                                    <div class="col-6"><?=$oficio->nombre_dependencia?></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6 text-muted">Capturado por:</div>
                                    <div class="col-6"><?=$oficio->nombre_completo?></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6 text-muted">Receptor:</div>
                                    <div class="col-6"><?=$oficio->receptor?></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6 text-muted">Fecha de Registro:</div>
                                    <div class="col-6"><?=$fecha?></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6 text-muted">Estatus:</div>
                                    <div class="col-6"><?=$estatus?></div>
                                </div>
                                
                            </div>
                        </div>

                        <div class="ibox">
                            <div class="ibox-head bg-pink-100">
                                <div class="ibox-title">Dependencias Con Copia de Oficio</div>

                            </div>
                            <div class="ibox-body">
                            <? foreach ($ccp as $copia) {?>
                                <div class="row mb-2">
                                    <div class="col-9"><b><?=$copia->nombre?></b></div>
                                    <? if (isset($copia->fecha_envio)) {
                                        $fecha = $this->m_mensajeria->fecha_text_f($copia->fecha_envio)?>
                                        <div class="col-3 text-muted" data-toggle="tooltip" title="Fecha de Envio: <?=$fecha?>">Enviado</div> 
                                   <? }?>                                                                   
                                </div>
                                   <hr>                                
                            <?}?>    

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
                        <div class="text-center centered" style="max-width:600px;">
                            <div class="btn-group">
                                <button class="btn btn-secondary" id="prev"><i class="fa fa-long-arrow-left"></i>
                                    <span class="d-none d-md-inline">Previous</span>
                                </button>
                                <button class="btn btn-secondary" id="next">
                                    <span class="d-none d-md-inline">Next</span> <i class="fa fa-long-arrow-right"></i></button>
                                <button class="btn btn-secondary" id="zoomin"><i class="fa fa-search-minus"></i>
                                    <span class="d-none d-md-inline">Zoom In</span>
                                </button>
                                <button class="btn btn-secondary" id="zoomout"><i class="fa fa-search-plus"></i>
                                    <span class="d-none d-md-inline">Zoom Out</span>
                                </button>
                                <button class="btn btn-secondary" id="zoomfit"> 100%</button>
                                <span class="btn-label-out">Page:</span>
                                <div class="input-group" style="width:auto;">
                                    <input class="form-control" id="page_num" style="max-width:50px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-outline-default" id="page_count">/ 22</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <canvas class="pdfcanvas" id="the-canvas"></canvas>
                        </div>
                    </div>
                        </div>
                    </div>

                </div>
    </section>


    <form id="frmCerrar">
      <div class="modal fade" id="cerrar" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-danger">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title " align="left">Validar Original Recibido</h4>
            </div>
            <div class="modal-body">
              <div class="icon" align="center">
                <img src="<?=base_url()?>src/img/advertencia.png">
              </div>
              <h3 align="center">ATENCIÓN</h3>
              <h4 align="center">Esta a punto de Validar un Oficio Recibido</h4>
                <br> <small>Esta acción indica que el oficio origial ya fue recibido por la dependencia correspondiente y mandara las copias
                    a las instituciones indicadas. ¿Esta seguro de 
                querer continuar?  </small>
        
                <input type="hidden" name="folio" value="<?=$folio?>">
                </div>
              <div class="modal-footer">
                <button type="button" id="btnCerrar" class="btn btn-success pull-left" data-dismiss="modal">Cerrar Ticket <i class="fa fa-check"></i></button>
                <button type="button" id="btn2" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fa fa-close"></i></button>
                  </div>
          </div>
        </div>
      </div>
</form>

<script>
    $(function(){
    

          pdf = 'src/oficios/' + '<?=$pdf?>';
    
        
        console.log(pdf);

        ver_pdf(pdf);
    })
</script>


<script>
      $("#btnCerrar").click(function(){
    var formulario = $("#frmCerrar").serializeArray();
    var button = "<i class='fa fa-spinner fa-pulse fa-fw'></i> Enviando Copias!";
     // enlace.disabled='disabled';
      document.getElementById('btnCerrar').disabled=true;
      document.getElementById('btnCerrar').innerHTML = button;
      //enlace.innerHTML = button;
    $.ajax({
      type: "POST",
      dataType: 'json',
      url: "<?=base_url()?>index.php?/mensajeria/validar_recibido",
      data: formulario,
    }).done(function(respuesta){      
 /*      if (respuesta.id == 1) {
         var buttonClosed = "<i class='fa fa-check '></i> Exito :)";
         document.getElementById('btnCerrar').innerHTML = buttonClosed;        
       } */    
    });
    // setTimeout('document.location.reload()',1000); 
   });
</script>

<script type="text/javascript">
  $(document).ready(function(){
  $("#asignarUsr").click(function(){
    var formulario = $("#frmAsignarUsr").serializeArray();
    $.ajax({
      type: "POST",
      dataType: 'json',
      url: "<?=base_url()?>index.php?/ticket/asignar_usuario",
      data: formulario,
    }).done(function(respuesta){
       $("#mensaje").html(respuesta);
        setTimeout('document.location.reload()',1000);
     
    });
   }); 
     $("#cambiarCat").click(function(){
    var formulario = $("#frmCategoria").serializeArray();
    $.ajax({
      type: "POST",
      dataType: 'json',
      url: "<?=base_url()?>index.php?/ticket/cambiar_categoria",
      data: formulario,
    }).done(function(respuesta){
       $("#mensaje").html(respuesta.mensaje);
       if (respuesta.id == 1) {
        setTimeout('document.location.reload()',1000);
       }     
    });
   });

    $("#cambiarStatus").click(function(){
    var formulario = $("#frmStatus").serializeArray();
    $.ajax({
      type: "POST",
      dataType: 'json',
      url: "<?=base_url()?>index.php?/ticket/cambiar_estatus",
      data: formulario,
    }).done(function(respuesta){
       $("#mensaje").html(respuesta.mensaje);
       if (respuesta.id == 1) {
        setTimeout('document.location.reload()',1000);
       }     
    });
   });
  });
 
</script>
<script>
     function desactiva_enlace(enlace)
  {
      var button = "<i class='fa fa-spinner fa-pulse fa-fw'></i> Cerrando...";
      enlace.disabled='disabled';
      document.getElementById('btn2').disabled=true;
      enlace.innerHTML = button;
  }
</script>
