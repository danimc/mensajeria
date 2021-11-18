import { asociar_ticket, lblEstatus, nombre_dependencias, tipo_oficios, } from "./oficios/catalogo-oficios.js";
const url = window.location.origin + "/bases/oficios/";
const pk = $("#btnEditar").val();
const urlEditar = `${url}editar_oficio`;
$("#btnEditar").on("click", () => {
    $(".bt-destinatario, .bt-cargo, .bt-folio, .bt-recibido, .bt-redaccion").editable({
        pk,
        url: urlEditar,
    });
    $(".bt-tipo").editable({
        pk,
        url: urlEditar,
        source: tipo_oficios(),
        select: {
            width: 500,
            placeholder: "",
            allowClear: true,
        },
    });
    $(".bt-dependencia").editable({
        pk,
        url: urlEditar,
        source: nombre_dependencias(),
        select2: {
            width: 500,
            placeholder: "Seleccione la dependencia",
            allowClear: true,
        },
    });
});
$("#btnEnviarFirma").on("click", () => {
    let campo = "estatus";
    let valor = 2;
    console.log(campo);
    actualizaOficio(pk, campo, valor);
});
$("#btnOficioFirmado").on("click", () => {
    let campo = "estatus";
    let valor = 3;
    console.log(campo);
    actualizaOficio(pk, campo, valor);
});
$("#btnAmensajeria").on("click", () => {
    let campo = "estatus";
    let valor = 4;
    console.log(campo);
    actualizaOficio(pk, campo, valor);
});
$("#btnAcuseRecibido").on("click", () => {
    let campo = "estatus";
    let valor = 7;
    console.log(campo);
    actualizaOficio(pk, campo, valor);
});
$("#btnMarcarPendiete").on("click", () => {
    let campo = "estatus";
    let valor = 9;
    console.log(campo);
    actualizaOficio(pk, campo, valor);
});
$("#btnAsociaTicket").on("click", () => {
    const ticket = $("#ticketAsc").val();
    const precargar = $("#chkdatos").is(":checked");
    const resp = asociar_ticket(pk, ticket, precargar);
    if (!resp) {
        setTimeout("document.location.reload()", 1000);
    }
});
const obtEstatusOficio = () => {
    const data = { pk };
    $.ajax({
        type: "GET",
        dataType: "JSON",
        url: `${url}estatusOficio`,
        data,
        beforeSend: () => { },
        success: (resp) => {
            botonera(resp.estatus);
            lblEstatus(resp.color, resp.icon, resp.est);
        },
    });
};
/**
 *
 * @param estatus Actualiza los botones que aparecen en la interfaz
 */
const botonera = (estatus) => {
    if (estatus < 2) {
        $("#btnEnviarFirma").removeClass("hidden");
    }
    if (estatus > 2) {
        //	$("#btnSubirAcuse").removeClass("hidden");
        $("#btnEnviarFirma").addClass("hidden");
    }
};
const actualizaOficio = (pk, campo, valor) => {
    const data = {
        pk,
        name: campo,
        value: valor,
    };
    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: urlEditar,
        data,
        beforeSend: () => { },
        success: (resp) => {
            console.log(resp);
            obtEstatusOficio();
        },
    });
};
(() => {
    obtEstatusOficio();
    /*
    $("#pdf").fileinput({
        showUpload: true,
        mainClass: "input-group-sm",
        maxFileSize: 3000,
    });
   */
})();
