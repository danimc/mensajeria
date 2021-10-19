"use strict";
const rutaInventario = window.location.origin + "/helpDesk/inventario/";
let clasificacion = 0;
let marca = 0;
$('.clasificaciones').select2({
    placeholder: "SELECCIONE UNA CLASIFICACION",
    ajax: {
        delay: 250,
        url: `${rutaInventario}obt_clasificaciones`,
        dataType: 'json'
    },
});
$('.marcas').select2({
    placeholder: "SELECCIONE UNA MARCA",
    ajax: {
        delay: 250,
        url: `${rutaInventario}obt_marcas`,
        data: function (params) {
            var query = {
                term: params.term,
                clasificacion,
            };
            return query;
        },
        dataType: 'json'
    },
});
$('.estatus').select2({
    placeholder: "ESTATUS DEL ACTIVO",
    ajax: {
        delay: 250,
        url: `${rutaInventario}obt_status_activos`,
        dataType: 'json'
    },
});
$('.dependencia, #dependenciaM').select2({
    placeholder: "DEPENDENCIA",
    ajax: {
        delay: 250,
        url: `${rutaInventario}obt_dependencias_inv`,
        dataType: 'json'
    },
});
$('.modelos').select2({
    placeholder: "SELECCIONE EL MODELO",
    ajax: {
        url: `${rutaInventario}obt_modelos`,
        data: function (params) {
            var query = {
                term: params.term,
                clasificacion,
                marca,
            };
            return query;
        },
        delay: 250,
    }
});
$('.clasificaciones').on('select2:select', function (e) {
    var data = e.params.data;
    clasificacion = data.id;
});
$('.marcas').on('select2:select', function (e) {
    var data = e.params.data;
    marca = data.id;
});
const tbl_Activos = () => {
    var table = $('#datatable').DataTable({
        ajax: {
            url: `${rutaInventario}tbl_activos`,
            dataSrc: ''
        },
        dom: 'Bfrtip',
        buttons: [{
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 9, 10, 11]
                }
            },
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
            },
            {
                extend: 'print',
            }
        ],
        columns: [{
                data: 'id'
            },
            {
                data: 'clasificacion'
            },
            {
                data: 'marca'
            },
            {
                data: 'modelo'
            },
            {
                data: 'nSerie'
            },
            {
                data: 'pesa'
            },
            {
                data: 'estatus'
            },
            {
                data: 'dependencia'
            },
            {
                data: 'red',
            },
            {
                data: 'ip',
            },
            {
                data: 'mac',
            },
            {
                data: 'host',
            },
            {
                data: 'opciones'
            }
        ],
        "deferRender": true,
        stateSave: false,
        responsive: true,
    });
    for (var i = 9; i < 12; i++) {
        table.column(i).visible(false, false);
    }
    table.columns.adjust().draw(false);
};
(() => {
    tbl_Activos();
})();
