<?php
include './config/connection.php';
class User extends DateBase
{
    public function __construct()
    {
        parent::__construct();
    }
    public function saveInformation($table, $columns, $values)
    {
        try {
            $sql = "INSERT INTO $table ($columns) VALUES ($values);";
            $this->connect->query($sql);
            return true;
        } catch (\Throwable $th) {
            echo "<pre>";
            var_dump($th);
            echo "</pre>";
        }
    }
    public function editInformation($table, $colmValues, $dni)
    {
        try {
            $sql = "UPDATE $table SET $colmValues WHERE dni = $dni;";
            $this->connect->query($sql);
            return true;
        } catch (\Throwable $th) {
            echo "<pre>";
            var_dump($th);
            echo "</pre>";
        }
    }
    public function deleteInformation($table, $dni)
    {
        try {
            $sql = "DELETE FROM $table WHERE dni = '$dni'";
            $this->connect->query($sql);
            return true;
        } catch (\Throwable $th) {
            echo "<pre>";
            var_dump($th);
            echo "</pre>";
        }
    }
    public function getPerson($dni){
        try {
            $sql = "SELECT * FROM `people` WHERE dni = '$dni';";
            $statement = $this->connect->query($sql);
            $response = array();
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $response[] = $row;
            }
            return $response;
        } catch (\Throwable $th) {
            echo "<pre>";
            var_dump($th);
            echo "</pre>";
        }
    }
    public function searchInformation($filter, $textFilter)
    {
        try {
            $sql = "SELECT * FROM appointments AS a
                INNER JOIN people AS p ON a.dni = p.dni
                INNER JOIN location AS l ON p.location = l.id
                WHERE p.$filter LIKE '%$textFilter%';";
            $statement = $this->connect->query($sql);
            $response = array();
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $response[] = $row;
            }
            return $response;
        } catch (\Throwable $th) {
            echo "<pre>";
            var_dump($th);
            echo "</pre>";
        }
    }
    public function findHours($date, $hour)
    {
        try {
            $sql = "SELECT timeAppo FROM appointments WHERE dateAppo = '$date' AND timeAppo = '$hour';";
            $statement = $this->connect->query($sql);
            $response = array();
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $response[] = $row;
            }
            return $response;
        } catch (\Throwable $th) {
            echo "<pre>";
            var_dump($th);
            echo "</pre>";
        }
    }
    public function getCities($departament){
        try {
            $sql = "SELECT nombre_ciudad FROM `location` WHERE departamento = '$departament';";
            $statement = $this->connect->query($sql);
            $response = array();
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $response[] = $row;
            }
            return $response;
        } catch (\Throwable $th) {
            echo "<pre>";
            var_dump($th);
            echo "</pre>";
        }
    }
    public function getIdLocation($city){
        try {
            $sql = "SELECT id FROM `location` WHERE nombre_ciudad = '$city';";
            $statement = $this->connect->query($sql);
            $response = array();
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $response[] = $row;
            }
            return $response;
        } catch (\Throwable $th) {
            echo "<pre>";
            var_dump($th);
            echo "</pre>";
        }
    }
}
$user = new User();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    switch ($_POST['function']) {
        case "save":
            $dni = $_POST['dni'];
            $name = $_POST['name'];
            $dateBirth = $_POST['dateBirth'];
            $address = $_POST['address'];
            $location = $user->getIdLocation($_POST['city'])[0]["id"];
            $phone = $_POST['phone'];
            $date = $_POST['date'];
            $time = $_POST['time'];
            
            $columnsPeople = 'dni,name,dateBirth,address,phone,location';
            $valuesPeople = "'$dni','$name','$dateBirth','$address','$phone', '$location'";
            $columnsAppo = 'dateAppo,timeAppo,dni';
            $valuesAppo = "'$date','$time','$dni'";
            if($user->getPerson($dni) != ""){
                $savePeople = $user->saveInformation("people", $columnsPeople, $valuesPeople);
                $saveAppo = $user->saveInformation("appointments", $columnsAppo, $valuesAppo);
                $answer = $saveAppo && $savePeople ? true : false;
            }else{
                $answer = false;
            }
            $user->getFormatJson($answer);
            break;
        case "edit":
            $dni = $_POST['dni'];
            $name = $_POST['name'];
            $dateBirth = $_POST['dateBirth'];
            $address = $_POST['address'];
            $location = $user->getIdLocation($_POST['city'])[0]["id"];
            $phone = $_POST['phone'];
            $date = $_POST['date'];
            $time = $_POST['time'];
            $columValuesPeople = "dni='$dni',name='$name',dateBirth='$dateBirth',address='$address',phone='$phone',location=$location";
            $columValuesAppo = "dateAppo='$date',timeAppo='$time',dni='$dni'";
            $savePeople = $user->editInformation("people", $columValuesPeople, $dni);
            $saveAppo = $user->editInformation("appointments", $columValuesAppo, $dni);
            $answer = $saveAppo && $savePeople ? true : false;
            $user->getFormatJson($answer);
            break;
        case "delete":
            $dni = $_POST['dni'];
            $deleteAppo = $user->deleteInformation("appointments", $dni);
            $deletePeople = $user->deleteInformation("people", $dni);
            $answer = $deletePeople && $deleteAppo ? true : false;
            $user->getFormatJson($answer);
            break;
    }
}
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    switch ($_GET["function"]) {
        case 'getHours':
            $date = $_GET['date'];
            $time = $_GET['time'];
            $find = $user->findHours($date, $time);
            $user->getFormatJson($find);
            break;
        case "search":
            $filter = $_GET["filter"];
            $textFilter = $_GET["textFilter"];
            $search = $user->searchInformation($filter, $textFilter);
            $user->getFormatJson($search);
            break;
        case "getCities":
            $departament = $_GET["departamento"];
            $cities = $user->getCities($departament);
            $user->getFormatJson($cities);
            break;
    }
}
