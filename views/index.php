<?php
include '../models/config/connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './includes/head.php' ?>
</head>

<body>
    <nav class="navbar navbar-lg navbar-light">
        <form class="form-inline needs-validation" novalidate>
            <select name="filter" id="filter" required>
                <option value="dni">Dni</option>
                <option value="name">Nombre</option>
            </select>
            <input style="width: 12rem;" type="search" name="search" id="input-search" placeholder="Search" aria-label="Search" required>
            <button class="btn-search" id="search"><i class="bi bi-search"></i></button>
            <button class="btn-clean" type="reset" id="close-search"><i class="bi bi-x-lg"></i></button>
        </form>
        <div class="d-flex" style="gap: 2rem;">

            <a href="./admin.php">Vista Admin</a>
            <!-- <a class="navbar-brand" href="#">AppCenso</a> -->
            <button class="btnSchedule btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseWidthExample"
            aria-expanded="false" aria-controls="collapseWidthExample">
            <span><i class="bi bi-calendar3"></i></span>
        </button>
    </div>
    </nav>
    <main class="main">
        <form class="formCenso needs-validation" novalidate>
            <div class="formRow">
                <label for="dni">Documento de Identidad</label>
                <input type="text" name="dni" id="dni" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    This field cannot be empty.
                </div>
            </div>
            <div class="formRow">
                <label for="name">Nombre Completo</label>
                <input type="text" name="name" id="name" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    This field cannot be empty.
                </div>
            </div>
            <div class="formRow">
                <label for="dateBirth">Fecha de Nacimiento</label>
                <input type="date" name="dateBirth" id="dateBirth" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    This field cannot be empty.
                </div>
            </div>
            <div class="formRow">
                <label for="address">Dirección</label>
                <input type="text" name="address" id="address" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    This field cannot be empty.
                </div>
            </div>
            <div class="formRow">
                <label for="deparment">Departamento</label>
                <select name="deparment" id="deparment" onchange="getCities(this)">
                    <option value="">Seleccionar</option>
                    <?php
                    $user = new DateBase();
                    $departments = $user->getDeparments();
                    foreach ($departments as $key => $value) {
                    ?>
                        <option value="<?php echo $value["departamento"] ?>"><?php echo $value["departamento"] ?></option>
                    <?php } ?>
                </select>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    This field cannot be empty.
                </div>
            </div>
            <div class="formRow">
                <label for="city">Ciudad</label>
                <select name="city" id="city" required>

                </select>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    This field cannot be empty.
                </div>
            </div>
            <div class="formRow">
                <label for="phone">Telefono</label>
                <input type="number" name="phone" id="phone" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    This field cannot be empty.
                </div>
            </div>
            <div class="formButtons">
                <!-- Delete -->
                <button class="button btn-primary disable" id="delete"><i class="bi bi-trash3-fill"></i></button>
                <!-- Edit  -->
                <button class="button btn-primary disable" id="edit"><i class="bi bi-pencil-fill"></i></button>
                <!-- Search -->
                <!-- <button class="button btn-primary" id="search"><i class="bi bi-search"></i></button> -->
                <!-- Save -->
                <button class="button btn-primary" id="save"><i class="bi bi-floppy-fill"></i></button>
            </div>
            <div class="alterMsg"></div>
        </form>
        <div class="d-flex justify-content-end" style="min-height: 120px;">
            <div class="collapse width" id="collapseWidthExample">
                <div class="calendar-container">
                    <form class="content-appo">
                        <input type="date" name="dateAppo" id="dateAppo" required>
                        <input type="time" name="timeAppo" id="timeAppo" required>
                        <div class="hours"></div>
                        <button type="submit" value="" id="submitAppo" hidden></button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Button trigger modal -->
    <button type="button" class="btn-modal btn btn-primary" data-toggle="modal" data-target="#exampleModal" hidden></button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Personas Censadas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Dni</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Fecha Nacimiento</th>
                                <th scope="col">Dirección</th>
                                <th scope="col">Ciudad</th>
                                <th scope="col">Departamento</th>
                                <th scope="col">Telefono</th>
                                <th scope="col">Dia Cita</th>
                                <th scope="col">Hora Cita</th>
                            </tr>
                        </thead>
                        <tbody class="tableBody"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="close-modal btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>
    <?php include './includes/scripts.php' ?>
    <script src="../controllers/template.js"></script>
    <script src="../controllers/controllerUser.js"></script>
</body>

</html>