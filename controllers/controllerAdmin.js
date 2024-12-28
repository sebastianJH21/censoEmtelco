function refreshTable(idTable, url) {
    $.ajax({
      url: url,
      type: "GET",
      success: function (repsonde) {
        let tabParentTable = document.getElementById(idTable).parentElement;
        tabParentTable.innerHTML = repsonde;
      },
    });
  }
function activeEditRow(button, active) {
    let row = button.parentElement.parentElement.parentElement.parentElement;
    if (active) {
        row.style.border = "2px dashed black";
        for (let i = 0; i < row.children.length - 1; i++) {
            row.children[i].setAttribute("contenteditable", "true");
        }
        row.children[3].setAttribute("contenteditable", "false");
    } else {
        row.setAttribute("contenteditable", "false");
        row.style.border = "";
    }
}
function saveCity(button) {
    let row = button.parentElement.parentElement.parentElement.parentElement;
    let id = row.children[0];
    let city = row.children[1];
    let deparment = row.children[2];
    if (
        city.textContent != "" ||
        deparment.textContent != "" 
    ) {
        if (id.textContent == "") {
            Swal.fire({
                title: "¿Estás Seguro?",
                text: "Guardarás un nuevo registro.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#198754",
                cancelButtonColor: "#d33",
                confirmButtonText: "Estoy Seguro",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "../models/modelAdmin.php",
                        type: "POST",
                        data: {
                            function: "saveCity",
                            city: city.textContent,
                            deparment: deparment.textContent
                        },
                        beforeSend: function () {
                            alertLoading();
                        },
                        success: function (response) {
                            if (response == true) {
                                var msg = "Plantilla Guardado Exitosamente";
                                alertSuccessfull(true, msg);
                                refreshTable("tableCities", "./includes/tableDeparment.php");
                            } else {
                                var msg = "Error al Guardar la Plantilla";
                                alertSuccessfull(false, msg);
                            }
                        },
                    });
                }
            });
        } else {
            editCity(button);
        }
    } else {
        var msg = "Llena por lo menos 1 campo";
        alertSuccessfull(false, msg);
    }
}
function editCity(button) {
    let row = button.parentElement.parentElement.parentElement.parentElement;
    let id = row.children[0];
    let city = row.children[1];
    let deparment = row.children[2];

    Swal.fire({
        title: "¿Estás Seguro?",
        text: "Cambiarás la información.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#198754",
        cancelButtonColor: "#d33",
        confirmButtonText: "Estoy Seguro",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../models/modelAdmin.php",
                type: "POST",
                data: {
                    function: "editCity",
                    id: id.textContent,
                    city: city.textContent,
                    deparment: deparment.textContent
                },
                beforeSend: function () {
                    alertLoading();
                },
                success: function (response) {
                    if (response == true) {
                        var msg = "Cambios Guardados Exitosamente";
                        alertSuccessfull(true, msg);
                        refreshTable("tableCities", "./includes/tableDeparment.php");
                    } else {
                        var msg = "Error al Guardar los Cambios";
                        alertSuccessfull(false, msg);
                    }
                },
            });
        }
    });
}
function deleteCity(button) {
    let row = button.parentElement.parentElement.parentElement.parentElement;
    let id = row.children[0];
    if (id.textContent != "") {
        Swal.fire({
            title: "¿Estás Seguro?",
            text: "No podrás revertir esta acción.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#198754",
            cancelButtonColor: "#d33",
            confirmButtonText: "Estoy Seguro",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../models/modelAdmin.php",
                    type: "POST",
                    data: {
                        function: "deleteCity",
                        id: id.textContent,
                    },
                    beforeSend: function () {
                        alertLoading();
                    },
                    success: function (response) {
                        let result = JSON.parse(response);
                        if (result == true) {
                            var msg = "Se Elimino Exitosamente";
                            alertSuccessfull(true, msg);
                            refreshTable("tableCities", "./includes/tableDeparment.php");
                        } else {
                            var msg = "Error al Eliminar la Plantilla";
                            alertSuccessfull(false, msg);
                        }
                    },
                });
            }
        });
    } else {
        var msg = "Aún no Existe este Producto";
        alertSuccessfull(false, msg);
    }
}
function addRow(button) {
    let parent = button.parentElement.parentElement.parentElement;
    let table = parent.querySelector("table");
    let tableBody = table.querySelector("tbody");
    let tr = document.createElement("tr");
    tr.style.border = "2px dashed black";
    let tdId = document.createElement("td");
    tdId.hidden = true;

    let tdCity = document.createElement("td");
    tdCity.setAttribute("contenteditable", "true");

    let tdDeparment = document.createElement("td");
    tdDeparment.setAttribute("contenteditable", "true");

    let tdAction = document.createElement("td");

    let divButtons = document.createElement("div");
    divButtons.classList.add("buttons-admin");

    let btnEdit = document.createElement("button");
    btnEdit.type = "button";
    btnEdit.classList.add("btn");
    btnEdit.name = "btn-edit";
    btnEdit.setAttribute("onclick", "activeEditRow(this, true)");
    let iEdit = document.createElement("i");
    iEdit.classList.add("bi", "bi-pencil-fill");

    let btnDelete = document.createElement("button");
    btnDelete.type = "button";
    btnDelete.classList.add("btn");
    btnDelete.name = "btn-delete";
    btnDelete.setAttribute("onclick", "deleteCity(this)");
    let iDelete = document.createElement("i");
    iDelete.classList.add("bi", "bi-trash-fill");

    let btnSave = document.createElement("button");
    btnSave.type = "button";
    btnSave.classList.add("btn");
    btnSave.name = "btn-save";
    btnSave.setAttribute("onclick", "saveCity(this)");
    let iSave = document.createElement("i");
    iSave.classList.add("bi", "bi-floppy-fill");

    let span = document.createElement("span");
    //Agregar los elementos
    btnDelete.append(iDelete);
    btnEdit.append(iEdit);
    btnSave.append(iSave);
    span.append(btnEdit, btnDelete, btnSave);
    divButtons.append(span);
    tdAction.append(divButtons);
    tr.append(
        tdId,
        tdCity,
        tdDeparment,
        tdAction
    );
    tableBody.prepend(tr);
    tdCity.focus();
}
function subirInformacion() {
    $("#formSubirArchivos").one("submit", function (event) {
        event.preventDefault(); // Evita que el formulario se envíe de manera tradicional
        // Crear una nueva instancia de FormData
        Swal.fire({
            title: "¿Estás Seguro?",
            text: "Reemplazarás la información existente.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#198754",
            cancelButtonColor: "#d33",
            confirmButtonText: "Estoy Seguro",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData(this); // Esto captura todo el formulario, incluyendo archivos
                formData.append("function", "subirArchivo");
                // Enviar el archivo mediante AJAX
                $.ajax({
                    url: "../models/modelAdmin.php", // Archivo PHP donde se procesa la subida
                    type: "POST",
                    data: formData,
                    contentType: false, // Necesario para enviar archivos
                    processData: false, // Impide que jQuery transforme el FormData en una cadena
                    success: function (response) {
                        // Manejar la respuesta del servidor
                        let result = JSON.parse(response);
                        console.log(result);
                        if (result == true) {
                            var msg = "Plantilla Guardada Exitosamente.";
                            alertSuccessfull(true, msg);
                            refreshTable("tableCities", "./includes/tableDeparment.php");
                        } else {
                            var msg = "No se Guardo la Información.";
                            alertSuccessfull(false, msg);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown, status) {
                        console.log(error, status);
                        var msg = "Proceso Fallido.";
                        alertSuccessfull(false, msg);
                    },
                });
            }
        });
    });
}
function getCity() {
    $.ajax({
        url: "../models/modelAdmin.php", // Archivo PHP donde se procesa la subida
        type: "GET",
        data: {
            function: "exportPlantilla",
        },
        success: function (response) {
            let blob = new Blob([response], { type: "text/csv;charset=utf-8" });
            // Crear una URL para el Blob y forzar la descarga
            let url = window.URL.createObjectURL(blob);
            let a = document.createElement("a");
            a.href = url;
            a.download = `matriz_documentacion.csv`; // Nombre del archivo a descargar
            document.body.appendChild(a);
            a.click(); // Simular el click para iniciar la descarga
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url); // Liberar la URL del Blob
        },
    });
}