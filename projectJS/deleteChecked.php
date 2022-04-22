<?php

    $conn = mysqli_connect("localhost","root","","todojs");
    $currentUser = mysqli_real_escape_string($conn, $_POST['currentUser']);
    $todayDate = mysqli_real_escape_string($conn, $_POST['todayDate']);

    $query = "DELETE FROM tasks WHERE id_user = '$currentUser' AND date_task < '$todayDate' AND isChecked='1'";
 
    $result = mysqli_query($conn, $query);

    if($result )
    {
        if($conn->affected_rows > 0)
            echo 1;
        else
            echo 0;            
    } 
    else 
    {
        $err = "Unsuccessful delete :C";
        $error = '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error! </strong>'.$err.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';//"Error: " . $query . "" . mysqli_error($conn);
        echo $error;
    }

    mysqli_close($conn);  

?>