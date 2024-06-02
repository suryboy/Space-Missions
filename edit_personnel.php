<?php
include "connect.php";

if (isset($_GET['id']) && isset($_GET['name']) && isset($_GET['job']) && isset($_GET['desc'])) {
    $personnel_ID = $_GET['id'];
    $name = mysqli_real_escape_string($connection, $_GET['name']);
    $job = intval($_GET['job']);
    $desc = mysqli_real_escape_string($connection, $_GET['desc']);

    $query = mysqli_query($connection, "UPDATE personnel SET name='$name', occupation='$job', description='$desc' WHERE id=$personnel_ID");
}
//     if (mysqli_query($connection, $query)) {
//         echo "Record updated successfully";
//     } else {
//         echo "Error updating record: " . mysqli_error($connection);
//     }
// } else {
//     echo "Missing parameters!";
// }
header("Location: company_control.php");
mysqli_close($connection);
?>