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
    <div class="manage-mission">
        <h1>MANAGE MISSION</h1>
        <p>Yes</p>
        <?php
        $mission_ID = $_GET["id"];
        $superZmienna = sprintf("href='odeslanieMisji.php?id=%d'", $mission_ID);
        echo "<a $superZmienna><button id='callearly'>CALL EARLY</button></a>";
        ?>
        <a href="mission_control.php"><button>BACK</button></a> <!-- tu najlepiej jakby wracało w linku do misji z której się przyszło -->
    </div>

    <script src="./script.js"></script>
</body>
</html>
