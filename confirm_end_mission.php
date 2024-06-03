<?php
include "connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mission_id = intval($_POST['mission_id']);

    // Retrieve resources from the mission
    $resources_query = "SELECT water, oxygen, research, money, metals, synthetics FROM resources WHERE id = $mission_id";
    $resources_result = mysqli_query($connection, $resources_query);
    $resources = mysqli_fetch_assoc($resources_result);

    // Update main base resources
    $update_base_resources_query = "
        UPDATE main_base_resources
        SET 
            water = water + {$resources['water']},
            oxygen = oxygen + {$resources['oxygen']},
            research = research + {$resources['research']},
            money = money + {$resources['money']},
            metals = metals + {$resources['metals']},
            synthetics = synthetics + {$resources['synthetics']}
        WHERE id = 1"; // Assuming 1 is the main base resources ID
    mysqli_query($connection, $update_base_resources_query);

    // Clear resources from the mission
    $clear_mission_resources_query = "
        UPDATE resources
        SET 
            water = 0,
            oxygen = 0,
            research = 0,
            money = 0,
            metals = 0,
            synthetics = 0
        WHERE id = $mission_id";
    mysqli_query($connection, $clear_mission_resources_query);

    // Update personnel to indicate they are no longer on a mission
    $update_personnel_query = "UPDATE personnel SET on_mission = FALSE WHERE id IN (SELECT peID FROM missions_personnel WHERE miID = $mission_id)";
    mysqli_query($connection, $update_personnel_query);

    // Delete existing personnel associations for this mission
    $delete_existing_personnel_query = "DELETE FROM missions_personnel WHERE miID = $mission_id";
    mysqli_query($connection, $delete_existing_personnel_query);

    // Mark the mission as no longer ongoing
    $delete_mission_query = "UPDATE missions SET on_going = FALSE WHERE id = $mission_id";
    mysqli_query($connection, $delete_mission_query);

    $update_mission_query = "UPDATE missions SET confirmed = TRUE WHERE id = $mission_id";
    mysqli_query($connection, $update_mission_query);

    // Redirect to mission control page
    header('Location: mission_control.php');
    exit();
}
?>
