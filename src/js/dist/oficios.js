import { asociar_ticket, tipo_oficios } from "./oficios/catalogo-oficios.js";
const url = window.location.origin + '/bases/oficios/';
const pk = $("#btnEditar").val();
(() => {
    $("#pdf").fileinput({
        showUpload: true,
        mainClass: "input-group-sm",
        maxFileSize: 3000,
    });
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
    /*
        $('#bt-dependencia').editable({
            pk,
            prepend: '<?= $usuario->nom_dependencia ?>',
            source: obt_dependencias(),
            select2: {
                width: 500,
                placeholder: 'Seleccione la dependencia',
                allowClear: true
            },
            url,
        });
    
    
    
        $('#bt-depa').editable({
            pk,
            prepend: '<?= $usuario->puesto ?>',
            select2: {
                width: 500,
                placeholder: 'Seleccione el departamento',
                allowClear: true
            },
            source: obt_departamento(),
            url,
        });
    
        $('#bt-rol').editable({
            pk,
            prepend: '<?= $usuario->rol ?>',
            source: obt_rol(),
            select2: {
                width: 500,
                placeholder: 'Seleccione el rol',
                allowClear: true
            },
            url,
        });
    
     
    
        $('.bt-estatus').editable({
            pk,
            prepend: '<?= $usuario->situacion ?>',
            source: [{
                    value: 1,
                    text: 'ACTIVO'
                },
                {
                    value: 2,
                    text: 'LICENCIA'
                }, {
                    value: 3,
                    text: 'INCAPACIDAD'
                },
                {
                    value: 6,
                    text: 'COMISIÓN'
                },
                {
                    value: 7,
                    text: 'BAJA'
                }
            ],
            url
        });
        */
});
$("#btnAsociaTicket").on("click", () => {
    const ticket = $("#ticketAsc").val();
    const precargar = $("#chkdatos").is(":checked");
    const resp = asociar_ticket(pk, ticket, precargar);
    if (!resp) {
        setTimeout('document.location.reload()', 1000);
    }
});
