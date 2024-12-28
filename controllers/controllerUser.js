function validatedForm() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    let validateForm = true;
    var forms = document.getElementsByClassName('formCenso');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
                var msg = "Llena todos los campos."
                alertSuccessfull(false, msg)
                validateForm = false
            }
            
            form.classList.add('was-validated');
        }, false);
        validateForm = form.checkValidity()
    });
    return validateForm
};
document.querySelector('.formCenso').addEventListener('submit', function (event) {
    event.preventDefault();
})
document.querySelector('.content-appo').addEventListener('submit', function (event) {
    event.preventDefault();
})

document.querySelector('.form-inline').addEventListener('submit', function (event) {
    event.preventDefault();
})
document.querySelectorAll('button').forEach(function (btn) {
    btn.addEventListener('click', function () {
        switch (btn.id) {
            case "save":
                if (validatedForm()) {   
                    saveEditInformaction("save"); // Function 1
                    templateHourJob();
                }
                break;
            case "edit":
                if (validatedForm()) {
                    saveEditInformaction("edit"); // Function 2
                    templateHourJob();
                }
                break
            case "delete":
                if (validatedForm()) {
                    deleteInformation(); // Function 3
                    templateHourJob();
                }
                break;
            case "search":
                searchInformaction(); // Function 4
                break;
            case "close-search":
                document.querySelector('#save').classList.remove('disable')
                document.querySelector('#edit').classList.add('disable')
                document.querySelector('#delete').classList.add('disable')
                document.querySelector('#filter').value = "";
                document.querySelector('#input-search').value = "";
                cleanAllFields();
                break;
        }
    })
})
function saveEditInformaction(action) {
    let dni = document.querySelector('#dni').value;
    let name = document.querySelector('#name').value;
    let dateBirth = document.querySelector('#dateBirth').value;
    let address = document.querySelector('#address').value;
    let city = document.querySelector('#city').value;
    let phone = document.querySelector('#phone').value;
    let dateAppo = document.querySelector('#dateAppo').value;
    let timeAppo = document.querySelector('#timeAppo').value;

    let date = new Date(dateAppo + 'UTC-05:00');
    let today = new Date();
    today.setHours(0, 0, 0, 0);
    date.setHours(0, 0, 0, 0);
    if (dni != "" && name != "" && dateBirth != "" && address != "" && phone != "" && dateAppo != "" && timeAppo != "") {
        if (date >= today) {
            $.ajax({
                url: '../models/modelUser.php',
                type: 'POST',
                data: {
                    "function": action,
                    "dni": dni,
                    "name": name,
                    "dateBirth": dateBirth,
                    "address": address,
                    "city": city,
                    "phone": phone,
                    "date": dateAppo,
                    "time": timeAppo
                },
                success: function (response) {
                    let answer = JSON.parse(response)
                    if (answer) {
                        var msg = "Información guardada."
                        alertSuccessfull(true, msg)
                        cleanAllFields();
                    } else {
                        var msg = "Error al guardar la información."
                        alertSuccessfull(true, msg)
                    }
                }
            })
        } else {
            var  msg = "La fecha no puede ser menor a hoy."
            alertSuccessfull(false, msg)
            return;
        }
    } else {
        if (!document.querySelector('#collapseWidthExample').classList.contains('show')) {
            document.querySelector('.btnSchedule').click();
        }
        setTimeout(() => {
            document.querySelector('#submitAppo').click()
        }, 300);
        return;
    }
}
function deleteInformation() {
    let dni = document.querySelector('#dni').value;
    if (dni != "") {
        $.ajax({
            url: '../models/modelUser.php',
            type: 'POST',
            data: {
                function: "delete",
                dni: dni,
            },
            success: function (response) {
                let answer = JSON.parse(response)
                if(answer){
                    var msg = "Información eliminada."
                    alertSuccessfull(true, msg)
                    cleanAllFields()
                    document.querySelector('#save').classList.remove('disable')
                    document.querySelector('#edit').classList.add('disable')
                    document.querySelector('#delete').classList.add('disable')
                }else{
                    var msg = "Error al eliminar la información."
                    alertSuccessfull(false, msg)
                }
            }
        })
    } else {
        return;
    }
}
function searchInformaction() {
    let filter = document.querySelector('#filter').value;
    let search = document.querySelector('#input-search').value;
    if (filter != "" && search != "") {
        $.ajax({
            url: '../models/modelUser.php',
            type: 'GET',
            data: {
                function: "search",
                filter: filter,
                textFilter: search,
            },
            success: function (response) {
                let answer = JSON.parse(response)
                console.log(answer)
                if (answer != "") {
                    $('.tableBody').empty()
                    let templateSearch = "";
                    answer.forEach(function (element) {
                        templateSearch += `
                            <tr>
                              <th scope="row">${element["dni"]}</th>
                              <td>${element["name"]}</td>
                              <td>${element["dateBirth"]}</td>
                              <td>${element["address"]}</td>
                              <td>${element["nombre_ciudad"]}</td>
                              <td>${element["departamento"]}</td>
                              <td>${element["phone"]}</td>
                              <td>${element["dateAppo"]}</td>
                              <td>${element["timeAppo"]}</td>
                            </tr>
                        `
                    })
                    $('.tableBody').html(templateSearch)
                    $('.btn-modal').click();
                } else {
                    var msg = "No se encontro información."
                    alertSuccessfull(false, msg)
                }
            },
            error: function (xhr, status, error) {
                var msg = "Error con esta función."
                alertSuccessfull(true, msg)
                console.log("Error en la solicitud:");
                console.log("Estado:", status);
                console.log("Error:", error);
                console.log("Detalles:", xhr.responseText);
            }
        });
    } else {
        return
    }
}
function getCities(select) {
    $.ajax({
        url: '../models/modelUser.php',
        type: 'GET',
        data: {
            function: 'getCities',
            departamento: select.value
        },
        success: function (response) {
            let cities = JSON.parse(response)
            document.querySelector('#city').innerHTML = ""
            let select = document.createElement('option')
            select.value = ""
            select.textContent = "Seleccionar"
            document.querySelector('#city').appendChild(select)

            cities.forEach(element => {
                let option = document.createElement('option')
                option.value = element.nombre_ciudad
                option.textContent = element.nombre_ciudad
                document.querySelector('#city').appendChild(option)
            });
        }
    })
}