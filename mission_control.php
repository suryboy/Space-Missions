<?php
include "connect.php";

function handleEvent($connection, $mission_id) {
    // Pobierz aktualne dane misji
    $mission_query = mysqli_query($connection, "SELECT current_duration, duration, target FROM missions WHERE id = $mission_id AND on_going = TRUE");
    $mission = mysqli_fetch_array($mission_query);

    if ($mission) {
        if ($mission['current_duration'] == $mission['duration']) {
            // Dodaj pierwszy log "Ekipa wylądowała na planecie"
            mysqli_query($connection, "INSERT INTO mission_logs (mission_id, log) VALUES ($mission_id, 'The crew landed on a planet')");
        }

        if ($mission['current_duration'] > 0) {
            // Zmniejsz current_duration
            $current_duration = $mission['current_duration'] - 1;
            mysqli_query($connection, "UPDATE missions SET current_duration = $current_duration WHERE id = $mission_id");

            // Pobierz dane załogi misji
            $personnel_query = mysqli_query($connection, "SELECT p.id, p.name, o.name as occupation, p.health FROM personnel p JOIN missions_personnel mp ON p.id = mp.peID JOIN occupations o ON p.occupation = o.id WHERE mp.miID = $mission_id");

            $personnel_count = mysqli_num_rows($personnel_query);

            // Pobierz dane zasobów misji
            $resources_query = mysqli_query($connection, "SELECT oxygen FROM resources WHERE id = $mission_id");
            $resources = mysqli_fetch_array($resources_query);
            $oxygen = $resources['oxygen'];

            // Zmniejsz ilość tlenu na podstawie liczby osób na misji
            $oxygen_consumption = $personnel_count * 0.5; // Każda osoba zużywa 0.5 jednostki tlenu
            $oxygen -= $oxygen_consumption;

            if ($oxygen < 0) {
                $oxygen = 0;
            }

            // Aktualizuj ilość tlenu w bazie danych
            mysqli_query($connection, "UPDATE resources SET oxygen = $oxygen WHERE id = $mission_id");

            // Jeśli tlen się skończył, zmniejsz zdrowie każdej osoby
            if ($oxygen == 0) {
                while ($personnel = mysqli_fetch_array($personnel_query)) {
                    $person_id = $personnel['id'];
                    $new_health = max($personnel['health'] - 10, 0);
                    mysqli_query($connection, "UPDATE personnel SET health = $new_health WHERE id = $person_id");

                    // If the personnel's health reaches 0, log their death and remove them from the mission
                    if ($new_health == 0) {
                        // Remove the personnel from the missions_personnel table and log their death
                        mysqli_query($connection, "DELETE FROM missions_personnel WHERE peID = $person_id");
                        mysqli_query($connection, "INSERT INTO mission_logs (mission_id, log) VALUES ($mission_id, '{$personnel['name']} has died due to lack of oxygen.')");

                        // Completely remove the personnel from the company
                        mysqli_query($connection, "DELETE FROM personnel WHERE id = $person_id");
                    }
                }
            }

            // Resetowanie wyniku zapytania załogi, aby móc go ponownie użyć
            mysqli_data_seek($personnel_query, 0);

            while ($personnel = mysqli_fetch_array($personnel_query)) {

                    $person_id = $personnel['id'];
                    $person_name = $personnel['name'];
                    $occupation = $personnel['occupation'];

                    // Generuj losowe zdarzenie dla każdej osoby na misji
                    $event_type = rand(0, 5); // 0: metal, 1: research, 2: water, 3: oxygen, 4: synthetics, 5: negative event
                    $resource_amount = 1;

                    switch ($mission['target']) {
                        case 'research':
                        case 'mining':
                            $resource_amount = 2;
                            break;
                        // Dodaj inne przypadki, jeśli są inne cele misji
                    }

                    if ($occupation == 'Researcher' && $event_type == 1) {
                        $resource_amount *= 2;
                    }

                    if ($occupation == 'Miner' && ($event_type == 0 || $event_type == 4)) {
                        $resource_amount *= 2;
                    }

                    switch ($event_type) {
                        case 0:
                            mysqli_query($connection, "UPDATE resources SET metals = metals + $resource_amount WHERE id = $mission_id");
                            $event_message = "$person_name found an ancient crate full of $resource_amount units of metal.";
                            break;
                        case 1:
                            mysqli_query($connection, "UPDATE resources SET research = research + $resource_amount WHERE id = $mission_id");
                            $event_message = "$person_name discovered $resource_amount new research points.";
                            break;
                        case 2:
                            mysqli_query($connection, "UPDATE resources SET water = water + $resource_amount WHERE id = $mission_id");
                            $event_message = "$person_name found a hidden source containing $resource_amount units of water.";
                            break;
                        case 3:
                            mysqli_query($connection, "UPDATE resources SET oxygen = oxygen + $resource_amount WHERE id = $mission_id");
                            $event_message = "$person_name discovered $resource_amount units of oxygen in an underground cavern.";
                            break;
                        case 4:
                            mysqli_query($connection, "UPDATE resources SET synthetics = synthetics + $resource_amount WHERE id = $mission_id");
                            $event_message = "$person_name discovered $resource_amount units of synthetics in a crashed alien ship.";
                            break;
                        case 5:
                            $health_loss = rand(1, 10);
                            $new_health = max($personnel['health'] - $health_loss, 0);
                            mysqli_query($connection, "UPDATE personnel SET health = $new_health WHERE id = $person_id");
                            $event_message = "$person_name encountered a dangerous situation and lost $health_loss% health.";
                        case 6:
                            $resource_amount *= rand(2,6);
                            mysqli_query($connection, "UPDATE resources SET money = money + $resource_amount WHERE id = $mission_id");
                            $event_message = "$person_name found a space wallet which contained $resource_amount";
                        case 7:
                            $event_message = "$person_name was lazy today.";

                            // If the personnel's health reaches 0, log their death and remove them from the mission
                            if ($new_health == 0) {
                                // Remove the personnel from the missions_personnel table and log their death
                                mysqli_query($connection, "DELETE FROM missions_personnel WHERE peID = $person_id");
                                $event_message .= " $person_name has died.";

                                // Completely remove the personnel from the company
                                mysqli_query($connection, "DELETE FROM personnel WHERE id = $person_id");
                            }
                            break;
                    }
                    mysqli_query($connection, "INSERT INTO mission_logs (mission_id, log) VALUES ($mission_id, '$event_message')");
            }
            if ($current_duration == 0) {
                // Misja zakończona
                mysqli_query($connection, "UPDATE missions SET on_going = FALSE WHERE id = $mission_id");
                $event_message = "Mission completed!";
                mysqli_query($connection, "INSERT INTO mission_logs (mission_id, log) VALUES ($mission_id, '$event_message')");
            }
        }
    }
    return null;
}

if (isset($_GET['id'])) {
    $mission_id = intval($_GET['id']);
    $event_message = handleEvent($connection, $mission_id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Missions</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="icon" href="./img/Icon.png">
</head>
<body>
    <header>
        <div id="header-items">
            <h1>Mission Control Center</h1>
            <div id="header-buttons">
                <a href="./company_control.php"><button>COMPANY CONTROL CENTER</button></a>
                <a href="./workshop.php"><button>WORKSHOP & SELL</button></a>
                <a href="./mission_control.php"><button>MISSION CONTROL CENTER</button></a>
            </div>
        </div>
    </header>
    <main>
        <section class="mission-list">
            <h2>Mission List</h2>
            <ul>
                <?php
                include "connect.php";

                // Pobierz wszystkie misje, zarówno trwające, jak i zakończone
                $query = mysqli_query($connection, "SELECT id, name, on_going, confirmed FROM missions");

                while ($row = mysqli_fetch_array($query)){
                    if (isset($_GET['id']) AND $row['on_going']) {
                        echo "<meta http-equiv='refresh' content='5'> <!-- Odśwież stronę co 5 sekund -->";
                    }
                    $danes = sprintf("mission_control.php?id=%d", $row[0]);
                    $status = $row['on_going'] ? "" : " (completed)";
                    if (!$row['confirmed']) {
                        echo "<li><a href='$danes'><button>$row[name]$status</button></a></li>";
                    }
                };
                ?>
            </ul>
            <h2 id="separator">- - -</h2>
            <a href="add_mission_form.php"><button>ADD NEW</button></a>
        </section>
        <section class="log-panel">
            <h2>LOGI</h2>
            <div>
                <?php
                if (isset($_GET['id'])) {
                    $mission_id = $_GET['id'];

                    $log_query = mysqli_query($connection, "SELECT log FROM mission_logs WHERE mission_id = $mission_id ORDER BY id DESC");
                    if (mysqli_num_rows($log_query) == 0) {
                        echo "<p><img src='./img/Log.png' style='width: 25px;'> <span>Nothing New!</span></p>";
                    } else {
                        while ($log = mysqli_fetch_array($log_query)) {
                            echo "<p><img src='./img/Log.png' style='width: 25px;'> <span>{$log['log']}</span></p>";
                        }
                    }
                }
                ?>
            </div>
        </section>

        <section class="mission-info-panel">
            <?php
            if (isset($_GET["id"])) {
                $mission_id = intval($_GET["id"]);

                // Sprawdź, czy misja jest zakończona
                $mission_query = mysqli_query($connection, "SELECT on_going FROM missions WHERE id = $mission_id");
                $mission = mysqli_fetch_array($mission_query);

                if ($mission['on_going'] == FALSE) {
                    echo "<h2>Mission Raport</h2>";
                    echo "<div class='mission-details'>";

                    // Wyświetl załogę i ich straty HP
                    echo "<h3>- - - WORKERS - - -</h3>";
                    $query = mysqli_query($connection, "SELECT p.name, o.name, p.health FROM missions m JOIN missions_personnel mp ON m.id = mp.miID JOIN personnel p ON mp.peID = p.id JOIN occupations o ON p.occupation = o.id WHERE m.id = $mission_id");

                    while ($row = mysqli_fetch_array($query)){
                        echo "<p><img src='./img/People.png' width='25px'>$row[0] <span id='details-health'><img src='./img/Health.png' width='25px'> $row[2]%</span></p>";
                    };

                    // Wyświetl zdobyte zasoby
                    echo "<h3>- - - GAINED - - -</h3>";
                    $query = mysqli_query($connection, "SELECT water, oxygen, research, money, metals, synthetics FROM resources WHERE id = $mission_id");

                    while ($row = mysqli_fetch_array($query)){
                        echo "
                        <p><img src='./img/Money.png' width='25px'>MONEY: $row[3]$ </p>
                        <p><img src='./img/Research.png' width='25px'>RESEARCH: $row[2] Points </p> <br>
                        <p><img src='./img/Water.png' width='25px'>WATER: $row[0]L </p>
                        <p><img src='./img/Oxygen.png' width='25px'>OXYGEN: $row[1]L </p> 
                        <p><img src='./img/Mineral.png' width='25px'>METALS: $row[4] Units </p> 
                        <p><img src='./img/Synthetics.png' width='25px'>SYNTHETICS: $row[5] Units </p>";
                    }

                    echo "<form method='post' action='confirm_end_mission.php'>
                            <input type='hidden' name='mission_id' value='$mission_id'>
                            <button type='submit' style='background-color: lime;'>Confirm To End The Mission</button>
                          </form>";

                    echo "</div>";
                } else {
                    echo "<h2>Mission Details</h2>";
                    echo "<div class='mission-details'>";

                    echo "<h3>- - - WORKERS - - -</h3>";
                    $query = mysqli_query($connection, "SELECT p.name, o.name, p.health FROM missions m JOIN missions_personnel mp ON m.id = mp.miID JOIN personnel p ON mp.peID = p.id JOIN occupations o ON p.occupation = o.id WHERE m.id = $mission_id");

                    while ($row = mysqli_fetch_array($query)){
                        echo "<p><img src='./img/People.png' width='25px'>$row[0] <span id='details-health'><img src='./img/Health.png' width='25px'> $row[2]%</span></p>";
                    };

                    echo "<h3>- - - RESOURCES - - -</h3>";
                    $query = mysqli_query($connection, "SELECT water, oxygen, research, money, metals, synthetics FROM resources WHERE id = $mission_id");

                    while ($row = mysqli_fetch_array($query)){
                        echo "
                        <p><img src='./img/Money.png' width='25px'>MONEY: $row[3]$ </p>
                        <p><img src='./img/Research.png' width='25px'>RESEARCH: $row[2] Points </p> <br>
                        <p><img src='./img/Water.png' width='25px'>WATER: $row[0]L </p>
                        <p><img src='./img/Oxygen.png' width='25px'>OXYGEN: $row[1]L </p> 
                        <p><img src='./img/Mineral.png' width='25px'>METALS: $row[4] Units </p> 
                        <p><img src='./img/Synthetics.png' width='25px'>SYNTHETICS: $row[5] Units </p>";
                    }

                    echo "<a href='manage_mission.php?id=$mission_id'><button>Manage Mission</button></a>";
                    echo "</div>";
                }
            } else {
                echo "<p style='text-align: center;'>Please pick a mission to see the details.</p>";
            }
            ?>
        </section>
        <script src="script.js"></script>
        <script>
        document.addEventListener("DOMContentLoaded", function(event) { 
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };
        </script>
    </main>
</body>
</html>
