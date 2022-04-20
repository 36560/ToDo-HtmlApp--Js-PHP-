<?php

    $conn = mysqli_connect("localhost","root","","todojs");

    $checked = mysqli_real_escape_string($conn, $_POST['checked']);
    $idTask = mysqli_real_escape_string($conn, $_POST['idTask']);

    $query = "UPDATE tasks SET isChecked='$checked' WHERE id ='$idTask'";

    if (mysqli_query($conn, $query)) 
    {
        echo 1;
    } 
    else 
    {
        echo -1;
    }

    mysqli_close($conn);     
?>