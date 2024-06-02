<?php
include "connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = intval($_POST['item_id']);
    $item_count = intval($_POST['item_count']);
    $item_cost_metals = intval($_POST['item_cost_metals']);
    $item_cost_synthetics = intval($_POST['item_cost_synthetics']);
    $total_cost_metals = $item_cost_metals * $item_count;
    $total_cost_synthetics = $item_cost_synthetics * $item_count;

    // Fetch user's resources
    $resources_query = mysqli_query($connection, "SELECT * FROM main_base_resources WHERE id = 1");
    $resources_row = mysqli_fetch_array($resources_query);

    if ($resources_row['metals'] >= $total_cost_metals && $resources_row['synthetics'] >= $total_cost_synthetics) {
        // Deduct resources
        $new_metals = $resources_row['metals'] - $total_cost_metals;
        $new_synthetics = $resources_row['synthetics'] - $total_cost_synthetics;
        mysqli_query($connection, "UPDATE main_base_resources SET metals = $new_metals, synthetics = $new_synthetics WHERE id = 1");

        // Check if the item already exists in the inventory
        $inventory_query = mysqli_query($connection, "SELECT * FROM main_base_inventory WHERE itemID = $item_id");
        
        if (mysqli_num_rows($inventory_query) > 0) {
            // Update existing item quantity
            mysqli_query($connection, "UPDATE main_base_inventory SET quantity = quantity + $item_count WHERE itemID = $item_id");
        } else {
            // Insert new item
            mysqli_query($connection, "INSERT INTO main_base_inventory (itemID, quantity) VALUES ($item_id, $item_count)");
        }

        // Redirect back to workshop
        header("Location: workshop.php");
        exit;
    } else {
        // Redirect back with an error message (implement error handling as needed)
        header("Location: workshop.php?error=insufficient_resources");
        exit;
    }
}
?>
