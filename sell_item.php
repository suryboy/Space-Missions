<?php
include "connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = intval($_POST['item_id']);
    $item_count = intval($_POST['item_count']);
    $item_cost = intval($_POST['item_cost']);
    $total_earnings = $item_cost * $item_count;

    // Fetch user's inventory
    $inventory_query = mysqli_query($connection, "SELECT * FROM main_base_inventory WHERE itemID = $item_id");
    $inventory_row = mysqli_fetch_array($inventory_query);

    if ($inventory_row['quantity'] >= $item_count) {
        // Deduct items from inventory
        $new_quantity = $inventory_row['quantity'] - $item_count;
        mysqli_query($connection, "UPDATE main_base_inventory SET quantity = $new_quantity WHERE itemID = $item_id");

        // Add earnings to user's resources
        $resources_query = mysqli_query($connection, "SELECT * FROM main_base_resources WHERE id = 1");
        $resources_row = mysqli_fetch_array($resources_query);
        $new_money = $resources_row['money'] + $total_earnings;
        mysqli_query($connection, "UPDATE main_base_resources SET money = $new_money WHERE id = 1");

        // Redirect back to workshop
        header("Location: workshop.php");
        exit;
    } else {
        // Redirect back with an error message (implement error handling as needed)
        header("Location: workshop.php?error=insufficient_items");
        exit;
    }
}
?>
