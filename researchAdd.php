<?php
include "connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $research_id = intval($_POST['id']);
    $research_cost = intval($_POST['cost']);

    // Fetch current research points from main_base_resources
    $resource_query = mysqli_query($connection, "SELECT research FROM main_base_resources WHERE id = 1");
    $resource_row = mysqli_fetch_array($resource_query);
    $current_research = $resource_row['research'];

    if ($current_research >= $research_cost) {
        // Deduct the cost from current research points
        $new_research = $current_research - $research_cost;
        mysqli_query($connection, "UPDATE main_base_resources SET research = $new_research WHERE id = 1");

        // Mark the research as owned
        mysqli_query($connection, "UPDATE research SET is_owned = 1 WHERE id = $research_id");

        // Redirect back to the research page
        header("Location: company_control.php");  // Adjust the location as necessary
        exit();
    } else {
        echo "Insufficient funds!";
    }
}
?>
