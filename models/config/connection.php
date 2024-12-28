<?php
set_time_limit(300);
class DateBase
{
    private $server = 'localhost';
    private $user = 'root';
    private $password = '';
    private $nameDB = 'censo';

    protected $connect;

    public function __construct()
    {
        $this->connection();
    }

    private function connection()
    {
        try {
            $this->connect = new PDO("mysql:host=$this->server;dbname=$this->nameDB;charset=utf8", $this->user, $this->password);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exc) {
            echo "Error en la conexión: " . $exc->getMessage();
        }
    }
    public function save($table, $arrayColumns, $arrayValues)
    {   
        $columns = implode(',', array_map(fn($item) => "`$item`", $arrayColumns));
        $values = implode(',', array_map(fn($item) => "'$item'", $arrayValues));
        $sql = "INSERT INTO `$table` ($columns) VALUES ($values);";
        // Ejecutar la consulta directamente
        try {
            $this->connect->query($sql);
            return true;
        } catch (\Throwable $th) {
            var_dump($th);
            return false;
        }
    }
    public function edit($table, $arraySet, $id,)
    {
        $set = implode(',', array_map(fn($key, $value) => "`$key`='$value'", array_keys($arraySet), $arraySet));
        $sql = "UPDATE `$table` SET $set WHERE id = '$id';";
        // Ejecutar la consulta directamente
        try {
            $this->connect->query($sql);
            return true;
        } catch (\Throwable $th) {
            var_dump($th);
            return false;
        }
    }
    public function delete($table, $id)
    {
        $sql = "DELETE FROM `$table` WHERE id = $id;";
        // Ejecutar la consulta directamente
        try {
            $this->connect->query($sql);
            return true;
        } catch (\Throwable $th) {
            var_dump($th);
            return false;
        }
    }
    public function truncate($table,)
    {
        $sql = "TRUNCATE TABLE `$table`;";
                try {
                    $this->connect->query($sql);
                } catch (\Throwable $th) {
                    var_dump($th);
                    return false;
                }
    }
    public function getInformationById($table, $id){
        $sql = "SELECT * FROM  `$table` WHERE id = $id";
        try {
            $statement = $this->connect->query($sql);
            $response = array();
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $response[] = $row;
            }
            return $response;
        } catch (\Throwable $th) {
            var_dump($th);
            return false;
        }
    }
    public function getInformation($table){
        $sql = "SELECT * FROM $table;";
        try {
            $statement = $this->connect->query($sql);
            $response = array();
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $response[] = $row;
            }
            return $response;
        } catch (\Throwable $th) {
            var_dump($th);
            return false;
        }
    }
    public function getFormatJson($array){
        echo json_encode($array);
    }
    public function export($header, $array)
    {
        array_splice($array, 0, 0, $header);
        $filename = "filename_" . date('Ymd') . ".csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        $output = fopen('php://output', 'w');
        foreach ($array as $row) {
            // fputcsv escribe una línea en el archivo CSV
            fputcsv($output, $row, ';');
        }
        // Cerrar el flujo
        fclose($output);
        exit;
    }
    public function getDeparments(){
        $sql = "SELECT DISTINCT(departamento) FROM `location`;";
        try {
            $statement = $this->connect->query($sql);
            $response = array();
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $response[] = $row;
            }
            return $response;
        } catch (\Throwable $th) {
            var_dump($th);
            return false;
        }
    }
}

