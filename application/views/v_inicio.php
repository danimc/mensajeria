<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="page-content fade-in-up">

        <!-- BOTONES DE ACCION -->




        <div class="row">
            <div class="col mb-4">
                <a href="<?= base_url("oficios/nuevaCaptura") ?>">
                    <div class="card btn-success">
                        <div class="card-body">
                            <h2 class="text-white">Nuevo Oficio<i class=" ti-files float-right"></i></h2>
                            <div class="text-white mt-1"><i class="ti-stats-up mr-1"></i><small>Registre un nuevo Oficio</small></div>
                        </div>
                        <div class="progress mb-2 widget-dark-progress">
                            <div class="progress-bar" role="progressbar" style="width:100%; height:5px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col mb-4">
                <a href="<?= base_url() ?>oficios">
                    <div class="card btn-danger">
                        <div class="card-body">
                            <h2 class="text-white">Libro Oficios<i class=" ti-files float-right"></i></h2>
                            <div class="text-white mt-1"><i class="ti-stats-up mr-1"></i><small>Consulte los oficios
                                    emitidos</small></div>
                        </div>
                        <div class="progress mb-2 widget-dark-progress">
                            <div class="progress-bar" role="progressbar" style="width:100%; height:5px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col mb-4">
                <a href="<?= base_url() ?>oficios">
                    <div class="card btn-primary">
                        <div class="card-body">
                            <h2 class="text-white">Notificar Firmados<i class=" ti-check float-right"></i></h2>
                            <div class="text-white mt-1"><i class=" ti-check  mr-1"></i><small>Consulte los oficios
                                    emitidos</small></div>
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
                        <div class="ibox-title">OFICIOS PENDIENTES DE ACUSE</div>
                        <div class="ibox-tools">
                            <span class="badge btn-warning" style="font-size: 28px;" id="contadorPendientes"></span>

                        </div>
                    </div>
                    <div class="ibox-body">
                        <ul class="media-list media-list-divider scroller mr-2" id="capa" data-height="470px">
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="ibox ibox-fullheight">
                    <div class="ibox-head">
                        <div class="ibox-title">Ultimas Noticias </div>
                    </div>
                    <div class="ibox-body">
                        <ul class="timeline scroller" data-height="470px">

                            <li class="timeline-item" id="elemento" data-toggle="tooltip" title="CANAL DE ATENCIÓN: ">
                                <span class="timeline-point"></span>
                                <a href="#">

                                </a>
                                <small class="float-right text-muted ml-2 nowrap">
                                    <a href="#">

                                    </a>
                                </small>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
        </div>



        <!-- TABLAS --->

    </section>



    <script>
        const url = `${window.location.origin}/bases/inicio/`;
        const dependencia = <?php echo $usuario->depId ?>;
        let capa = document.getElementById("capa");



        (() => {
            obt_pendientes()
            setInterval('obt_pendientes()', 50000);

        })();


        function obt_pendientes() {
            const data = {
                dep: dependencia
            }

            $.ajax({
                type: "GET",
                dataType: 'JSON',
                url: `${url}obtOficiosPendientes`,
                data,
                success: (resp) => {
                    if (resp.error) {
                        alert("algo salio mal");
                        return 0;
                    }
                    actualiza_tabla_pendientes(resp.result);

                }
            });
        }

        function actualiza_tabla_pendientes(datos) {
            capa.innerHTML = ''; //limpia la lista

            document.getElementById("contadorPendientes").innerHTML = `${datos.length}`;

            datos.forEach((val, idx, ) => {
                let li = document.createElement("li");
                li.classList.add("media");
                li.innerHTML = tarjetaPendiente(val);
                capa.appendChild(li);

            });


        }

        const tarjetaPendiente = (datos) => {

            const urlSeguimiento = `${window.location.origin}/bases/oficios/seguimiento/${datos.id}`;

            let tarjeta = ` <div class="media-body d-flex">
                        <div class="flex-1">
                            <h5 class="media-heading">
                                <a href="${urlSeguimiento}">
                                    ${datos.oficio}
                                </a>
                                <span id="badge"></span>
                            </h5>
                            <p class="font-13 text-light mb-1">
                                Para: 
                                <b>${datos.destinatario} </b><br>
                                Dependencia: <b>${datos.nombreDependencia} </b><br>

                                Asunto: <b>${datos.redaccion}</b>
                            </p>
                            <div class="d-flex align-items-center font-13">
                                Remitente: &nbsp; 
                                <a class="mr-2 text-success" data-toggle="tooltip" title="Usuario Asignado"
                                    href="javascript:;">
                                     ${datos.capturista} - ${datos.remitente}
                                </a>
                                <span class="text-muted">
                                </span>
                            </div>
                        </div>

                        <div class="text-right" style="width:100px;">
                            <a href="${urlSeguimiento}">
                                <span class="btn badge btn-${datos.color} badge-pill mb-2">                                    
                                    <i class="${datos.icon}"></i> ${datos.est}
                                </span>
                            </a>
                        </div>
                    </div>`;

            return tarjeta;
        }
    </script>