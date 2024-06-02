<?php
include "connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $missionName = $_POST['mission-name'];
    $missionGoal = $_POST['mission-goal'];
    $missionDuration = $_POST['mission-duration'];
    $missionCrew = $_POST['mission-crew'];
    $oxygenAllocated = $_POST['oxygen-allocated'];

    // Check if there is enough oxygen in main base resources
    $mainBaseQuery = mysqli_query($connection, "SELECT oxygen FROM main_base_resources WHERE id = 1");
    $mainBaseRow = mysqli_fetch_array($mainBaseQuery);
    $mainBaseOxygen = $mainBaseRow['oxygen'];

    if ($mainBaseOxygen < $oxygenAllocated) {
        // Redirect back with an error message
        header("Location: add_mission_form.php?error=insufficient_oxygen");
        exit();
    }

    // Insert mission into the missions table
    $insertMissionQuery = "INSERT INTO missions (name, duration, current_duration, target) VALUES ('$missionName', '$missionDuration', '$missionDuration', '$missionGoal')";
    mysqli_query($connection, $insertMissionQuery);
    $missionID = mysqli_insert_id($connection); // Get the id of the inserted mission

    // Insert resources for the mission
    $insert_resources_query = "INSERT INTO resources (id) VALUES ($missionID)";
    mysqli_query($connection, $insert_resources_query);

    // Update resource_id for the mission
    $update_resource_id_query = "UPDATE missions SET resource_id = $missionID WHERE id = $missionID";
    mysqli_query($connection, $update_resource_id_query);

    // Update oxygen for the mission in resources table
    $insertResourcesQuery = "UPDATE resources SET oxygen = $oxygenAllocated WHERE id = $missionID";
    mysqli_query($connection, $insertResourcesQuery);

    // Deduct oxygen from main base resources
    $newMainBaseOxygen = $mainBaseOxygen - $oxygenAllocated;
    mysqli_query($connection, "UPDATE main_base_resources SET oxygen = $newMainBaseOxygen WHERE id = 1");

    // Insert each personnel into the missions_personnel table and update their on_mission status
    foreach ($missionCrew as $personnelID) {

        // Insert personnel into missions_personnel table
        $insertMissionsPersonnelQuery = "INSERT INTO missions_personnel (miID, peID) VALUES ($missionID, $personnelID)";
        mysqli_query($connection, $insertMissionsPersonnelQuery);

        // Update personnel's on_mission status
        $updatePersonnelStatusQuery = "UPDATE personnel SET on_mission = 1 WHERE id = $personnelID";
        mysqli_query($connection, $updatePersonnelStatusQuery);
    }

    header("Location: mission_control.php");
    exit();
}
?>
