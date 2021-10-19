


export class Toner {

	constructor(

		public modelo: string,
		public marca: number,
		public concepto: string
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


export function tbl_toners() {
	let table1 = $("#tb_catToners").DataTable({
		ajax: {
			url: `${ruta}tbl_Toners`,
			dataSrc: "",
		},
		pageLength: 10,
		fixedHeader: true,
		responsive: true,
		columns: [
			{
				data: "modelo",
			},
			{
				data: "marca",
			},
            {
                data: "tipo",
            },
			{
				data: "color",
			},
            {
                data: "compatibles",
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
