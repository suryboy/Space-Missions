<?php
    include "connect.php";
    
    $id_personnel = $_GET['id'];
    mysqli_query($connection, "UPDATE personnel SET is_owned = 0 WHERE id = $id_personnel");

    header("Location: company_control.php");
    exit()
?>