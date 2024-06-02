<?php
include "connect.php";

$randName = rand(1, 100);
$randOcu = rand(1, 3);
$randAge = rand(7, 75);

$selectName = mysqli_fetch_array(mysqli_query($connection, "select name from names where id = $randName"));

$superSelectName = $selectName[0];

mysqli_query($connection, "insert into personnel (name, age, occupation, is_owned) values ('$superSelectName', $randAge, $randOcu, False)");

header("Location: company_control.php");
exit();
?>