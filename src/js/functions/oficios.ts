import { sendAlert } from "./clases/alertas.js";
import {
	asociar_ticket,
	lblEstatus,
	nombre_dependencias,
	tipo_oficios,
} from "./oficios/catalogo-oficios.js";

const url = window.location.origin + "/bases/oficios/";
const pk: number | any = $("#btnEditar").val();
const urlEditar = `${url}editarOficio`;

let estatusGlobal: number;

$("#btnEditar").on("click", () => {
	$(
		".bt-destinatario, .bt-cargo, .bt-folio, .bt-recibido, .bt-redaccion"
	).editable({
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
  
	actualizaOficio(pk, campo, valor);
});

$("#btnOficioFirmado").on("click", () => {
	let campo = "estatus";
	let valor = 3;
  
	actualizaOficio(pk, campo, valor);
});

$("#btnAmensajeria").on("click", () => {
	let campo = "estatus";
	let valor = 4;
 

	actualizaOficio(pk, campo, valor);
});

$("#btnAcuseRecibido").on("click", () => {
	let campo = "estatus";
	let valor = 7;
  

	actualizaOficio(pk, campo, valor);
});

$("#btnMarcarPendiete").on("click", () => {
	let campo = "estatus";
	let valor = 9;
 
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
		beforeSend: () => {},
		success: (resp) => {
			botonera(resp.estatus);
            lblEstatus(resp.color, resp.icon, resp.est);
			obtHistorial();

			estatusGlobal = resp.estatus;
		},
	});
};


/**
 * 
 * @param estatus Actualiza los botones que aparecen en la interfaz
 */
const botonera = (estatus: number) => {
	if (estatus == 1) {
		$("#btnEnviarFirma").removeClass("hidden");
	}

	if (estatus >= 2 && estatus != 8) {
		$("#btnAcciones").removeClass("hidden");
        $("#btnEnviarFirma").addClass('hidden');
		
	}

	if(estatus == 8){
		$("#btnAcciones").addClass("hidden");
	}

};

const actualizaOficio = (pk: number, campo: string, valor: any) => {

	if(campo === "estatus" && valor == estatusGlobal){
		sendAlert(true, 'Selecciono el estatus actual del Oficio');
		return 0;
	}

	if()

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
		beforeSend: () => {},
		success: (resp) => {
			obtEstatusOficio();
		},
	});
};

const obtHistorial = () => {

	const data = {id : pk};

	$.ajax({
		type: "GET",
		dataType: "HTML",
		url: `${url}obtHistorialOficio`,
		data,
		beforeSend: () => {},
		success: (resp) => {
			$("#historial").html(resp);

		},
	});	
}



(() => {
	obtEstatusOficio();
//	obtHistorial();



	/*
    $("#pdf").fileinput({
        showUpload: true,
        mainClass: "input-group-sm",
        maxFileSize: 3000,
    });
   */
})();