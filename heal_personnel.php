<?php
include "Connect.php";

$personnelID = $_GET['id'];

$waterQuery = mysqli_fetch_array(mysqli_query($connection, "select water from main_base_resources"));
$healthQuery = mysqli_fetch_array(mysqli_query($connection, "select health from personnel where id = $personnelID"));

$water = $waterQuery[0];
$health = $healthQuery[0];

if ($water >= 1) {
    mysqli_query($connection, "UPDATE personnel set health = 100 where id = $personnelID");
    $newWater = $water - 1;
    mysqli_query($connection, "UPDATE main_base_resources set water = $newWater");
} else {
    header("Location: company_control.php?nowater=1");
    exit(); // Zatrzymaj dalsze wykonywanie skryptu
}

header("Location: company_control.php");
exit();
?>