<?php
include '../models/config/connection.php';
$admin =  new DateBase();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './includes/head.php' ?>
</head>

<body>
    <nav class="navbar navbar-lg navbar-light">
        <a href="./index.php">Vista Citas</a>
    </nav>
    <main class="main-deparment">
        <?php include './includes/tableDeparment.php' ?>
    </main>

    <?php include './includes/scripts.php' ?>
    <script src="../controllers/controllerAdmin.js"></script>
</body>

</html>