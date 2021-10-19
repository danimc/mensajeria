import { sendAlert } from './alertas.js';
export class Tipo {
    constructor(id, nombre, red, img) {
        this.id = id;
        this.nombre = nombre;
        this.red = red;
        this.img = img;
        this.rutaEliminar = ruta + "eliminar_catActivos";
        this.nuevaCategoria = () => {
            let tipo = {
                icono: `<i class="${this.img}"</i>`,
                clasificacion: this.nombre,
                red: () => {
                    if (this.red == 1) {
                        return '<i class="fas fa-check text-success"></i>';
                    }
                    else {
                        return '<i class="fas fa-times text-danger "></i>';
                    }
                },
                eliminar: `<a onclick='eliminar( ${this.id},tabla=1);'> <button class='btn btn-sm btn-default'><i class='fa fa-trash' style='color: red;' ></button></a>`,
            };
            var t = $("#tb_catActivos").DataTable();
            t.row.add(tipo).draw(false);
            console.log("nueva categoria añadida");
        };
        this.editarTipo = () => { };
        this.eliminarTipo = (fila) => {
            let data = { id: this.id };
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: this.rutaEliminar,
                data,
                error: () => {
                    sendAlert(true, "error comunicandose con el servidor");
                },
                success: (msg) => {
                    sendAlert(msg.error, msg.mensaje);
                    fila.remove();
                    fila.draw(false);
                }
            });
        };
    }
}
export function tbl_catActivos() {
    let table1 = $('#tb_catActivos').DataTable({
        ajax: {
            url: `${ruta}tbl_catActivos`,
            dataSrc: ''
        },
        pageLength: 10,
        fixedHeader: true,
        responsive: true,
        columns: [{
                data: 'icono'
            },
            {
                data: 'clasificacion'
            },
            {
                data: 'red'
            },
            {
                data: 'null',
                "defaultContent": "<button class='btn btn-sm btn-default'><i class='fa fa-trash' style='color: red;' ></button>"
            }
        ],
        "sDom": 'rtip',
        columnDefs: [{
                targets: 'no-sort',
                orderable: false
            }]
    });
    $('#key').on('keyup', function () {
        table1.search(this.value).draw();
    });
}
export const data_icon = [
    {
        id: 'fas fa-microchip',
        text: '<i class="fas fa-microchip"></i> Microchip',
    },
    {
        id: 'fas fa-hdd',
        text: '<i class="fas fa-hdd"></i> disco duro',
    },
    {
        id: 'fas fa-laptop-code',
        text: '<i class="fas fa-laptop-code"></i> laptop code',
    },
    {
        id: 'fas fa-server',
        text: '<i class="fas fa-server"></i> servidor',
    },
    {
        id: 'fas fa-tty',
        text: '<i class="fas fa-tty"></i> tty',
    },
    {
        id: 'fas fa-satellite-dish',
        text: '<i class="fas fa-satellite-dish"></i> satelite',
    },
];
