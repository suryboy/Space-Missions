<?php
include "connect.php";

$id = $_GET["employee-list"];

// Fetch current money from main_base_resources
$resource_query = mysqli_query($connection, "SELECT money FROM main_base_resources WHERE id = 1");
$resource_row = mysqli_fetch_array($resource_query);
$current_money = $resource_row['money'];

// Check if there are sufficient funds
if ($current_money >= 100) {
    // Deduct 100 money
    $new_money = $current_money - 100;
    mysqli_query($connection, "UPDATE main_base_resources SET money = $new_money WHERE id = 1");

    // Update the personnel status to 'is_owned'
    mysqli_query($connection, "UPDATE personnel SET is_owned = 1 WHERE id = $id");

    // Redirect back to the company control center
    header("Location: company_control.php");
    exit();
} else {
    // Redirect back with an error message
    header("Location: company_control.php?error=insufficient_funds");
    exit();
}
?>
