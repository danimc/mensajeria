class Alertas {
    constructor() {
        alertify.set('notifier', 'position', 'top-right');
    }
}
export const sendAlert = (error, mensaje) => {
    new Alertas();
    if (!error) {
        alertify.success('<i class="fa fa-check"></i> ' + mensaje);
    }
    else {
        alertify.error('<i class="fas fa-exclamation-triangle"></i> ' + mensaje);
    }
};
