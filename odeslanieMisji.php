<?php
include "connect.php";
$mission_ID = $_GET['id'];

mysqli_query($connection, "UPDATE missions set on_going = false where id = $mission_ID");

$supaHot = mysqli_query($connection, "SELECT peID from missions_personnel where miID = $mission_ID");

while($row = mysqli_fetch_array($supaHot)) {
mysqli_query($connection, "UPDATE personnel set on_mission = 0 where id = $row[0]");
mysqli_query($connection, "DELETE from missions_personnel where peID = $row[0]");
};


header("Location: mission_control.php");
exit();
?>