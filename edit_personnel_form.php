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
    <div id="personnel-edit-form">
        <form method="get" action="edit_personnel.php">
            <h1>EDIT EMPLOYEE</h1>

            <label>Employee Name</label> <br />
            <?php
            include "connect.php";
            $personnel_ID = $_GET['id'];
            $query = mysqli_query($connection, "SELECT name from personnel where id = $personnel_ID");
            $row = mysqli_fetch_array($query);
            echo "<input required type='text' name='name' value='" . htmlspecialchars($row['name']) . "'> <br />";
            ?>

            <label>Employee Occupation</label> <br /> <br />
            <select name="job">
                <option value="2">Researcher</option>
                <option value="1">Miner</option>
                <option value="3">Soldier</option>
            </select> <br /><br />

            <label>Employee Description</label> <br />
            <?php
            $query = mysqli_query($connection, "SELECT description from personnel where id = $personnel_ID");
            $row = mysqli_fetch_array($query);
            echo "<textarea rows='6' required name='desc'>" . htmlspecialchars($row['description']) . "</textarea> <br />";
            ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($personnel_ID); ?>" />
            <button type="submit">EDIT</button>
        </form>
        <a href="company_control.php"><button>BACK</button></a>
    </div>

    <script src="./script.js"></script>
</body>
</html>