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
        <h1>Company Control Center</h1>
        <div id="header-buttons">
            <a href="./company_control.php"><button>COMPANY CONTROL CENTER</button></a>
            <a href="./workshop.php"><button>WORKSHOP & SELL</button></a>
            <a href="./mission_control.php"><button>MISSION CONTROL CENTER</button></a>
        </div>
    </div>
</header>
<main>
<section class="dashboard">
    <h2>Dashboard</h2>
    <?php
    include "connect.php";
    $resources_query = mysqli_query($connection, "SELECT * FROM main_base_resources WHERE id = 1");
    $resources_row = mysqli_fetch_array($resources_query);

    echo "<div class='resource'>
            <span><img src='./img/Water.png' style='width: 25px;'> " . $resources_row['water'] . "</span>
            <span class='separator'>|</span>
            <span><img src='./img/Oxygen.png' style='width: 25px;'> " . $resources_row['oxygen'] . "</span>
            <span class='separator'>|</span>
            <span><img src='./img/Research.png' style='width: 25px;'> " . $resources_row['research'] . "</span>
            <span class='separator'>|</span>
            <span><img src='./img/Money.png' style='width: 25px;'> " . $resources_row['money'] . "</span>
            <span class='separator'>|</span>
            <span><img src='./img/Mineral.png' style='width: 25px;'> " . $resources_row['metals'] . "</span>
            <span class='separator'>|</span>
            <span><img src='./img/Synthetics.png' style='width: 25px;'> " . $resources_row['synthetics'] . "</span>
        </div>";
    ?>
</section>

<section class="manage-employees">
    <h2>Manage Employees</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Qualification</th>
                    <th>Age</th>
                    <th>Health</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
        <div class="table-body-container">
            <table>
                <tbody>
                    <?php
                    include "connect.php";
                    $managequery = mysqli_query($connection, "SELECT personnel.id, personnel.name, personnel.age, personnel.health, occupations.name AS occupation FROM personnel INNER JOIN occupations ON personnel.occupation = occupations.id WHERE is_owned = 1");
                    while ($row = mysqli_fetch_array($managequery)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['occupation']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['health']) . "%</td>";
                        echo "<td>";
                        echo "<a href='heal_personnel.php?id=" . htmlspecialchars($row['id']) . "'><img src='./img/Health.png' width='25px' alt='Heal' title='Heal'></a> ";
                        echo "<a href='edit_personnel_form.php?id=" . htmlspecialchars($row['id']) . "'><img src='./img/Edit.png' width='25px' alt='Edit' title='Edit'></a> ";
                        echo "<a href='delete_personnel.php?id=" . htmlspecialchars($row['id']) . "'><img src='./img/Delete.png' width='25px' alt='Delete' title='Delete' onclick='return confirm(\"Are you sure you want to delete this personnel?\");'></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php
        if(ISSET($_GET['nowater'])){
            echo 'Nie masz wystarczająco wody aby wykonać tą operację';
        };
        ?>
        </div>
    </div>
</section>

<section class="hire-employees">
    <h2>Hire Employees</h2>
    <table>
        <tr>
            <td>
            <form id="hire-form" method="GET" action="hired.php">
                <label for="employee-list">Choose Employee:</label>
                <select id="employee-list" name="employee-list" size="6" required>
                <?php
                include "connect.php";
                $query = mysqli_query($connection, "SELECT personnel.id, personnel.name, personnel.age, occupations.name AS occupation FROM personnel INNER JOIN occupations ON personnel.occupation = occupations.id WHERE is_owned = 0;");

                while($row = mysqli_fetch_array($query)){
                    echo "<option value='{$row['id']}' data-position='{$row['occupation']}' data-age='{$row['age']}'>";
                    echo "{$row['name']}";
                    echo "</option>";
                };
                ?>
                </select>
                <button type="submit">Hire For 100<img id="hirecost" src="./img/Money.png" style="width: 25px; -webkit-filter: invert(100%);"></button>
            </form>
            <a href="create_new_employee.php"><button style="margin-top: 10px; width: 80%;">Call For People</button></a>
            </td>
            <td>
                <div id="employee-stats" class="employee-stats">
                    <h3>Employee Stats</h3>
                    <p id="employee-stats-info">Click on a employee to see stats</p>
                    <p id="employee-position"></p>
                    <p id="employee-age"></p>
                </div>
            </td>
        </tr>
    </table>
</section>

<section class="research">
    <h2>Research</h2>
    <?php
    include "connect.php";

    $resource_query = mysqli_query($connection, "SELECT research FROM main_base_resources WHERE id = 1");
    $resource_row = mysqli_fetch_array($resource_query);
    $current_research = $resource_row['research'];

    echo "<h3>Research Points: $current_research<img src='./img/Research.png' style='width: 25px;' id='researchImg'></h3>";

    $query = mysqli_query($connection, "SELECT * FROM research");
    while ($row = mysqli_fetch_array($query)) {
        $research_id = $row['id'];
        $research_name = $row['name'];
        $research_description = $row['description'];
        $is_owned = $row['is_owned'];
        $research_cost = $row['cost'];

        echo "<div class='researchThing'>
                <img src='./img/ResearchPlaceholder.png' style='width: 250px;'>
                <div>
                <p id='nazwa'>$research_name</p>
                <p id='koszt'>$research_cost<img src='./img/Research.png' style='width: 20px;' id='researchCost'></p>
                </div>
                <p id='opis'>$research_description</p>";

        if ($is_owned == 0) {
            if ($current_research >= $research_cost) {
                echo "<form method='post' action='researchAdd.php'>
                        <input type='hidden' name='id' value='$research_id'>
                        <input type='hidden' name='cost' value='$research_cost'>
                        <button type='submit'>Wybadaj</button>
                      </form>";
            } else {
                echo "<button disabled>Insufficient funds</button>";
            }
        } else {
            echo "<p id='Wybadane'>Wybadane</p>";
        }

        echo "</div>";
    }
    ?>
</section>
</main>
<script src="./script.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function(event) { 
        var scrollpos = localStorage.getItem('scrollpos');
        if (scrollpos) window.scrollTo(0, scrollpos);
    });

    window.onbeforeunload = function(e) {
        localStorage.setItem('scrollpos', window.scrollY);
    };
</script>
</body>
</html>
