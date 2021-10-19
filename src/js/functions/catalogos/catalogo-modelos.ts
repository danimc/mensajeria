import { sendAlert } from "../clases/alertas.js";

export class Modelo {

	constructor(

		public tipo: number,
		public marca: number,
		public modelo: string
	) { }

	agregar = () => {

		let respuesta = {
			ok: false,
			id: 0,
			tipo: '',
			marca: '',
			modelo: ''
		};

		let data = {
			tipo: this.tipo,
			marca: this.marca,
			modelo: this.modelo,
		};

		$.ajax({
			type: "POST",
			dataType: "json",
			url: ruta + "nuevo_modelo",
			async: false,
			data,
			error: () => {
				sendAlert(true, "error comunicandose con el servidor");
			},
			success: (msg) => {
				sendAlert(msg.error, msg.mensaje);
				if (!msg.error) {
					respuesta.ok = true;
					respuesta.id = msg.data.id;
					respuesta.tipo = msg.data.tipo;
					respuesta.marca = msg.data.marca;
					respuesta.modelo = msg.data.modelo;
				}
			},
		});

		return respuesta;
	}

	actualiza_tabla = (id: number, tipo: string, marca: string, modelo: string) => {

		const modeloRow = {
			clasificacion: tipo,
			marca: marca,
			modelo: modelo
		};

		console.log(modeloRow);

		var t = $("#tb_catModelos").DataTable();
		t.row.add(modeloRow).draw(false);
	}
}

export const nuevaMarca = (marca: string) => {
	let data = { marca };
	let respuesta: boolean = false;

	$.ajax({
		type: "POST",
		dataType: "json",
		url: ruta + "nueva_marca",
		async: false,
		data,
		error: () => {
			sendAlert(true, "error comunicandose con el servidor");
		},
		success: (msg) => {
			sendAlert(msg.error, msg.mensaje);
			if (!msg.error) {
				respuesta = true;
			}
		},
	});

	return respuesta;
};

export function tbl_modelos() {
	let table1 = $("#tb_catModelos").DataTable({
		ajax: {
			url: `${ruta}tbl_catModelos`,
			dataSrc: "",
		},
		pageLength: 10,
		fixedHeader: true,
		responsive: true,
		columns: [
			{
				data: "clasificacion",
			},
			{
				data: "marca",
			},
			{
				data: "modelo",
			},
			{
				data: "null",
				defaultContent:
					"<button class='btn btn-sm btn-default'><i class='fa fa-trash' style='color: red;' ></button>",
			},
		],
		sDom: "rtip",
		columnDefs: [
			{
				targets: "no-sort",
				orderable: false,
			},
		],
	});

	$("#keyMod").on("keyup", function () {
		table1.search(this.value).draw();
	});
}
