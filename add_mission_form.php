<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Missions</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="./img/Icon.png">
</head>
<body>
    <div id="mission-add-form">
        <form method="post" action="./insertToMission.php">
            <h1>ADD MISSION</h1>

            <label>Mission Name</label> <br />
            <input required type="text" name="mission-name"> <br />

            <label>Mission Goal</label> <br /> <br />
            <select name="mission-goal">
                <option value="research">Research</option>
                <option value="mining">Mining</option>
                <option value="expedition">Expedition</option>
            </select> <br /><br />

            <label>Mission Duration</label> <br />
            <div>
                <input required type="number" name="mission-duration" style="width: 20%;" min="1" max="31"> 
                <p>Days</p>
            </div>

            <label>Mission Crew</label> <br />
            <select required class="checkbox" id="test" name="mission-crew[]" multiple>
            <?php
                include "connect.php";
                $query = mysqli_query($connection, "SELECT id, name FROM personnel WHERE on_mission = 0 AND is_owned = 1");
                
                while($row = mysqli_fetch_array($query)){
                    echo "<option value='{$row['id']}'> {$row['name']} </option>";
                }; 
            ?>
            </select>
            <p style="font-size: 20px; text-align: center;">Click with 'ctrl' to select multiple</p> <br />
            
            <label>Allocate x days of oxygen (1 unit = 1day)</label> <br />
            <div>
                <input required type="number" name="oxygen-allocated" style="width: 20%;" min="0" max="31"> 
                <p>Days</p>
                <?php
                if(ISSET($_GET['error'])){
                    echo "<p class='error-message' style='color: red; text-align: center;'>You don't have enough oxygen</p>";
                }
                ?>
            </div>

            <button type="submit">NEXT</button>
        </form>
        <a href="mission_control.php"><button>BACK</button></a>
    </div>

    <script src="./script.js"></script>
</body>
</html>