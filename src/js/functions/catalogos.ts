import { sendAlert } from "./clases/alertas.js";
import { Modelo, nuevaMarca, tbl_modelos } from "./catalogos/catalogo-modelos.js";
import { Tipo, data_icon, tbl_catActivos } from "./clases/catalogo-tipos.js";
import { tbl_consumibles } from "./catalogos/catalogo-cosumibles.js";
import { tbl_toners } from "./catalogos/catalogo-toners.js";

const ruta = window.location.origin + "/helpDesk/inventario/";
let tbTipo: DataTables.Api;
let tbModelos: DataTables.Api;
let tbConsumibles: DataTables.Api;
let tbToners: DataTables.Api;

(() => {
	tbl_catActivos();
	tbTipo = $("#tb_catActivos").DataTable();

	$("#select").select2({
		data: data_icon,
		escapeMarkup: (markup) => markup,
	});

	$("#icon").html(`<i class="${$("#select").val()} fa-2x"></i>`);

})();

// Pestaña Tipos
$("#select").change(function () {
	var icono = $(this).val();
	$("#icon").html('<i class="' + icono + ' fa-2x"></i>');
});

//Pestaña Modelos y Marcas
$("#btnCatModelos").on("click", () => {
	// revisa que la tabla no este inicializada
	if (!tbModelos) {
		tbl_modelos();
		tbModelos = $("#tb_catModelos").DataTable();
	}
});

$("#btnCatConsumibles").on("click", () => {
	// revisa que la tabla no este inicializada
	if (!tbConsumibles) {
		tbl_consumibles();
		tbConsumibles = $("#tb_CatCons").DataTable();
	}
});

// Boton para pestaña de toners
$("#btnCatToners").on("click", () => {
	// revisa que la tabla no este inicializada
	if (!tbToners) {
		tbl_toners();
		tbToners = $("#tb_catToners").DataTable();
	}
});


$("#btnMarcaModelo").on("click", () => {
	$("#tipo1").select2({
		placeholder: "SELECCIONE UNA CLASIFICACION",
		ajax: {
			url: ruta + "obt_clasificaciones",
			dataType: "json",
		},
	});

	$("#marca1").select2({
		placeholder: "SELECCIONE UNA MARCA",
		ajax: {
			url: ruta + "obt_marcas",
			dataType: "json",
		},
	});
});

/**
 * Funcion para dar de alta una nueva marca
 */
$("#agregarMarca").on("click", () => {

	const marca: string | any = $("#nMarca").val();
	const respuesta = nuevaMarca(marca);

	if (respuesta) {
		$("#nMarca").val("");
	}
});

/**
 * Funcion para dar de alta una nueva marca
 */
$("#agregarModelo").on("click", () => {

	$("#modelo").prop('required', true);

	const marca: number | any = $("#marca1").val();
	const tipo: number | any = $("#tipo1").val();
	const modelo: string | any = $("#modelo").val();

	if (marca === null || tipo === null || modelo.length <= 3) {
		console.log("Ingrese todos los datos");
		return 0;
	}

	const nuevoModelo = new Modelo(tipo, marca, modelo);
	const result = nuevoModelo.agregar();

	if (result.ok) {
		nuevoModelo.actualiza_tabla(result.id, result.tipo, result.marca, result.modelo);
	}
});

/*
 * funcion para agregar nueva categoria de tipos
 */
$("#agregarCatActivo").click(() => {
	let categoria: string;
	categoria = $("#catActivo").val();
	if (categoria.length > 3) {
		$("#agregarCatActivo").attr("disabled");
		let data = {
			clasificacion: categoria,
			red: $("#hRed").prop("checked"),
			icon: $("#select").val(),
		};
		$.ajax({
			type: "POST",
			dataType: "JSON",
			url: ruta + "nuevo_tipo",
			data,
			error: () => {
				sendAlert(
					true,
					"Hubo un problema con la comunicacion hacia el servidor."
				);
			},
			success: (msg) => {
				sendAlert(msg.error, msg.mensaje);
				if (!msg.error) {
					$("#agregarCatActivo").removeAttr("disabled");
					$("#NcategoriaActivo").modal("toggle");
					$("#frmNuevaCategoria")[0].reset();
					const tipo: Tipo = new Tipo(
						msg.data.id_clasificacion,
						msg.data.clasificacion,
						msg.data.red,
						msg.data.img
					);
					tipo.nuevaCategoria();
				}
			},
		});
	} else {
		var button = "<i class='fa fa-close'></i> FAVOR DE LLENAR TODOS LOS CAMPOS";
		$("#agregarCatActivo").attr("disabled");
		$("#agregarCatActivo").html(button);
		setTimeout(
			'document.getElementById("agregarCatActivo").disabled=false',
			1000
		);
	}
});

$("#tb_catActivos tbody").on("click", "button", function () {
	let data: any = tbTipo.row($(this).parents("tr")).data();
	const tipo = new Tipo(data.id, data.clasificacion, data.idRed, data.icon);
	const fila = tbTipo.row($(this).parents("tr"));
	eliminar(tipo, 1, fila);
	/*tbTipo.row($(this).parents('tr')).remove();
	tbTipo.draw(false);*/
});

function eliminar(tipo: Tipo, tabla: number, fila: any) {
	let url: string = ruta;
	alertify.confirm(
		"¿Esta Seguro que desea eliminar el Item del catálogo?",
		() => {
			if (tabla == 1) {
				if (tipo.id > 21) {
					tipo.eliminarTipo(fila);
				} else {
					alertify.alert(
						"<h2><i class='fa fa-close' style='color: red;' ></i> ¡ERROR!</h2> <br>NO SE PUEDE ELIMINAR DEL CATÁLOGO REGISTROS GENERADOS POR EL SISTEMA",
						function () {
							alertify.error("Acción Cancelada");
						}
					);
				}
			}
			if (tabla == 2) {
				pedidos = revisar_pedidos(id);
				if (pedidos == 0) {
					url = url + "eliminar_consumible";
					tbl_catConsumibles();
				} else {
					alertify.alert(
						"<h2><i class='fa fa-close' style='color: red;' ></i> ¡ERROR!</h2> <br>NO SE PUEDE ELIMINAR DEL CATÁLOGO CONSUMIBLES QUE SE ENCUENTREN EN VALES ACTIVOS",
						function () {
							alertify.error("Acción Cancelada");
						}
					);
				}
			}
		}
	);
}
