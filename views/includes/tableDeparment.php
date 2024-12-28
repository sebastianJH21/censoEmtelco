<?php
if (!class_exists('DateBase')) {
    require '../../models/config/connection.php';
    $admin =  new DateBase();
}
$matriz = $admin->getInformation('location');
?>
<div class="inputs-filter">
    <form id="formSubirArchivos" method="post" enctype="multipart/form-data">
        <button type="button" class="button" onclick="addRow(this)" name="addTemplate">Agregar</button>
        <input required type="file" name="dataFile" id="file-input" class="form-control" accept=".csv">
        <button type="submit" class="button" onclick="subirInformacion()">Subir Archivo</button>
        <button type="button" class="button" onclick="getCity()">Descargar Plantilla</button>
    </form>
</div>
<table class="tableizer-table table table-bordered table-striped table-admin" id="tableCities">
    <thead>
        <tr class="tableizer-firstrow">
            <th hidden>id</th>
            <th>Ciudad</th>
            <th>Departament</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($matriz as $key => $value) { ?>
            <tr>
                <td hidden><?php echo $value["id"] ?></td>
                <td><?php echo $value["nombre_ciudad"] //procedimiento 
                    ?></td>
                <td><?php echo $value["departamento"] //tipificación 
                    ?></td>
                <td>
                    <div class="buttons-admin">
                        <span>
                            <button type="button" class="btn" name="btn-edit" onclick="activeEditRow(this, true)"><i class="bi bi-pencil-fill"></i></button>
                            <button type="button" class="btn" name="btn-delete" onclick="deleteCity(this)"><i class="bi bi-trash-fill"></i></button>
                            <button type="button" class="btn" name="btn-save" onclick="saveCity(this)"><i class="bi bi-floppy-fill"></i></button>
                        </span>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>