import { asociar_ticket, tipo_oficios } from "./oficios/catalogo-oficios.js";
const url = window.location.origin + '/bases/oficios/';
const pk = $("#btnEditar").val();
(() => {
    /*
    $("#pdf").fileinput({
        showUpload: true,
        mainClass: "input-group-sm",
        maxFileSize: 3000,
    });
    */
})();
$("#btnEditar").on("click", () => {
    const urlEditar = `${url}editar_oficio`;
    $('.bt-destinatario, .bt-cargo, .bt-folio, .bt-recibido, .bt-redaccion').editable({
        pk,
        url: urlEditar
    });
    $('.bt-tipo').editable({
        pk,
        url: urlEditar,
        source: tipo_oficios(),
        select: {
            width: 500,
            placeholder: '',
            allowClear: true
        },
    });
});
$("#btnAsociaTicket").on("click", () => {
    const ticket = $("#ticketAsc").val();
    const precargar = $("#chkdatos").is(":checked");
    const resp = asociar_ticket(pk, ticket, precargar);
    if (!resp) {
        setTimeout('document.location.reload()', 1000);
    }
});
