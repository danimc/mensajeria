import { sendAlert } from "../clases/alertas.js";
const url = `${window.location.origin}/bases/oficios/`;
export const tipo_oficios = () => {
    let valores;
    $.ajax({
        type: "GET",
        dataType: "JSON",
        url: `${url}obtTipoOficios`,
        async: false,
        error: () => {
            console.log("error de conexion al servidor");
            return [
                { error: "Error al cargar los tipos de oficios desde el servidor" },
            ];
        },
        success: (data) => {
            valores = data;
        },
    });
    return valores;
};
export const nombre_dependencias = () => {
    let valores;
    $.ajax({
        type: "GET",
        dataType: "JSON",
        url: `${url}obtNombreDependencias`,
        async: false,
        error: () => {
            console.log("error de conexion al servidor");
            return [
                { error: "Error al cargar los tipos de oficios desde el servidor" },
            ];
        },
        success: (data) => {
            valores = data;
        },
    });
    return valores;
};
export const asociar_ticket = (pk, ticket, prellenado) => {
    let respuesta = false;
    const data = {
        pk,
        ticket,
        prellenado,
    };
    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: `${url}asociar_ticket`,
        async: false,
        data,
        error: () => {
            console.log("error de conexion al servidor");
            sendAlert(true, "error de conexion al servidor");
            respuesta = true;
        },
        success: (resp) => {
            sendAlert(resp.error, resp.mensaje);
            respuesta = resp.error;
        },
    });
    return respuesta;
};
export const lblEstatus = (color, icon, estatus) => {
    let html = ` 
	<span class="btn badge btn-${color} badge-pill mb-2">                                    
		<i class="${icon}"></i> ${estatus}
	</span>`;
    $("#lblEstatus").html(html);
};
