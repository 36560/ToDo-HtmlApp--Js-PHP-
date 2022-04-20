<?php

    $conn = mysqli_connect("localhost","root","","todojs");
    $taskID = mysqli_real_escape_string($conn,$_POST["idTask"]);
    $query = "DELETE FROM tasks WHERE id ='$taskID'";
 
    if (mysqli_query($conn, $query)) 
    {
        echo 1;
    } 
    else 
    {
        $err = "Unsuccessful delete :C";
        $error = '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error! </strong>'.$err.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';//"Error: " . $query . "" . mysqli_error($conn);
        echo $error;
    }
        
    mysqli_close($conn);
?>


