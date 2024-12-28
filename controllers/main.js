function alertSuccessfull(type, msg) {
    if (type) {
        Swal.fire({
            title: "¡Exitoso!",
            text: msg,
            icon: "success", // Puedes usar: success, error, warning, info, question
            showConfirmButton: false,
            timer: 2000,
        });
    } else {
        Swal.fire({
            title: "¡Fallido!",
            text: msg,
            icon: "error", // Puedes usar: success, error, warning, info, question
            showConfirmButton: false,
            timer: 2000,
        });
    }
}
function alertLoading(){
    Swal.fire({
        title: "Procesando...",
        text: "Por favor, espera mientras procesamos tu solicitud.",
        icon: "info",
        allowOutsideClick: false, // Evita que se cierre al hacer clic afuera
        showConfirmButton: false, // Oculta el botón de confirmación
        didOpen: () => {
            Swal.showLoading(); // Muestra un indicador de carga
        },
    });
}
function cleanAllFields() {
    document.querySelector('#dni').value = "";
    document.querySelector('#name').value = "";
    document.querySelector('#dateBirth').value = "";
    document.querySelector('#address').value = "";
    document.querySelector('#city').value = "";
    document.querySelector('#deparment').value = "";
    document.querySelector('#phone').value = "";
    document.querySelector('#dateAppo').value = "";
    document.querySelector('#timeAppo').value = "";
}