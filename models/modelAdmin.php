<?php
include './config/connection.php';
class Admin extends DateBase
{
    public function __construct()
    {
        parent::__construct();
    }
    public function upFile($archivotmp, $table, $columns)
    {
        // Abre el archivo en modo lectura
        if (($handle = fopen($archivotmp, "r")) !== false) {
            $i = 0;

            // Procesa el archivo línea por línea
            while (($data = fgetcsv($handle, 0, ";")) !== false) {
                if ($i != 0) { // Ignora la primera línea (encabezado)
                    // Depuración: Verifica el contenido de la línea
                    // Verifica que el número de columnas coincida
                    if (count($data) !== count($columns)) {
                        error_log("Número de columnas no coincide: " . print_r($data, true));
                        continue; // Salta esta línea si hay un problema
                    }
                    // Limpia las columnas y elimina caracteres no deseados
                    $data = array_map('trim', $data);
                    // Inserta los datos en la base de datos
                    if (!parent::save($table, $columns, $data)) {
                        fclose($handle); // Cierra el archivo
                        return false;
                    }
                }
                $i++;
            }
            fclose($handle); // Cierra el archivo al terminar
        } else {
            error_log("No se pudo abrir el archivo.");
            return false;
        }
        return true;
    }
}
$admin = new Admin();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    switch ($_POST["function"]) {
        case 'saveCity':
            $city = $_POST["city"];
            $deparment = $_POST["deparment"];
            $columns = ['nombre_ciudad', 'departamento'];
            $values = [$city, $deparment];
            echo $admin->save('location', $columns, $values);
            break;
        case 'editCity':
            $id = $_POST["id"];
            $city = $_POST["city"];
            $deparment = $_POST["deparment"];
            $set = [
                'nombre_ciudad' => $city,
                'departamento' => $deparment,
            ];
            echo $admin->edit('location', $set, $id);
            break;
        case 'deleteCity':
            $id = $_POST["id"];
            echo $admin->delete('location', $id);
            break;
        case 'subirArchivo':
            $archivotmp = $_FILES['dataFile']['tmp_name'];
            // $lineas = file($archivotmp);
            $table = 'location';
            $columns = ['nombre_ciudad', 'departamento'];
            // $admin->truncate($table);
            echo $admin->upFile($archivotmp, $table, $columns);
            break;
    }
}
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    switch ($_GET["function"]) {
        case 'exportPlantilla':
            $header[] = ['Ciudad', 'Departamento'];
            $array = array();
            $admin->export($header, $array);
            break;
    }
}
