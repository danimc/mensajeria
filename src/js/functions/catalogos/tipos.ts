
let ruta = window.location.origin + '/helpDesk/inventario/';

function modalTipo(id) {
    console.log("hola");
    let data = { id };
    $.ajax({
        type: "GET",
        dataType: 'JSON',
        url: ruta + "info_tipo",
        data,
        error: () => {
            sendAlert(true, "Hubo un problema con la comunicacion hacia el servidor.");
        },
        success: (msg) => {
            sendAlert(true, "Hubo un problema con la comunicacion hacia el servidor.");
            console.log("hola");

        }
    });
}
