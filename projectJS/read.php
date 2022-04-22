<?php

    $conn = mysqli_connect("localhost","root","","todojs");
    
    $option = mysqli_real_escape_string($conn, $_POST['option']);
    $currentUser = mysqli_real_escape_string($conn, $_POST['currentUser']);
    $todayDate = mysqli_real_escape_string($conn, $_POST['todayDate']);
    $key = mysqli_real_escape_string($conn, $_POST["searchKey"]);   
    
    echo '<table id="taskTable" class="table text-light fw-bold"> 
            <thead>
            <tr class="text-center table-dark">                   
                <th onclick="sortTable(0)">Title<i class="fa fa-filter" id="sortName"></i></th>
                <th onclick="sortTable(1)">Deadline<i class="fa fa-filter" id="sortDate"></i></th>
                <th>Description</th>                        
                <th onclick="sortTable(3)">Category<i class="fa fa-filter" id="sortCat"></i></th>                        
                <th></th>
                <th></th>
                <th></th>
            </tr>  
            </thead>   
        <tbody>';

    
    if(isset($_POST["searchKey"]) && !empty($_POST["searchKey"]))
    {                      
        $query = "SELECT * FROM tasks WHERE id_user ='$currentUser' AND name LIKE '%$key%'";                                                                                                         
    }    
    else if($option == '1') //TODAY
    {
        $query = "SELECT * FROM tasks WHERE id_user = '$currentUser' AND date_task = '$todayDate'";
    }
    else if($option == '2') //FUTURE
    {
        $query = "SELECT * FROM tasks WHERE id_user = '$currentUser' AND date_task > '$todayDate'";
    }
    else if($option == '3') //PAST
    {
        $query = "SELECT * FROM tasks WHERE id_user = '$currentUser' AND date_task < '$todayDate'";        
    }    
    else //ALL
    {
       $query = "SELECT * FROM tasks WHERE id_user = '$currentUser'";
    } 

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_array($result))
        {
            $name = $row['name'];
            $date = $row['date_task'];
            $desc = $row['description'];
            $cat = $row['category_name'];
            $isChecked = $row['isChecked'];
            $id = $row['id'];

            $td = '<td class="text-center rowCh" onclick="clickedRow('.$id.')">';
            $trChecked = '<tr class="row'.$id.' checked">';
            $trUnChecked = '<tr class="row'.$id.' unchecked">';


                $queryCat = "SELECT * FROM category WHERE name = '$cat'";
                $resultCat = mysqli_query($conn, $queryCat);

                if(mysqli_num_rows($resultCat) > 0)
                {
                    while($row = mysqli_fetch_array($resultCat))
                    {
                        $img = '<img src="'.$row['image'].'" class="imgCat" alt="alternatetext"><br>';
                    }
                }
                                    
                $endTd = '</td>';    
                $editBtn = '<td><button type="button" class="btn btn-success" onclick="openEditForm('.$id.","."'".$name."'".","."'".$desc."'".","."'".$cat."'".","."'".$date."'";  
                $editEndBtn = ')"><i class="fas fa-pencil-alt"></i></button>'.$endTd;                                   
                $deleteBtn ='<td><button type="button" onclick="deleteTask('.$id.')" class="btn btn-success"><i class="fa fa-recycle"></i></button>'.$endTd;
                                
                $tdCheck = '<td class="rowCh"><i class="fa fa-check fa-lg checking"></i></td>';
                $tdUnCheck = '<td class="rowCh"></td>';

                if($isChecked==1)
                {                                    
                    echo $trChecked.$td.$name.'</td>'.$td.$date.'</td>'.$td.$desc.'</td>'.$td.$img.'</td>'.$deleteBtn.$editBtn.$editEndBtn.$tdCheck.'</tr>';                                                                           
                }         
                else
                {
                    echo $trUnChecked.$td.$name.'</td>'.$td.$date.'</td>'.$td.$desc.'</td>'.$td.$img.'</td>'.$deleteBtn.$editBtn.$editEndBtn.$tdUnCheck.'</tr>';                   
                }                               
            }    
        }                        
    else
    {
         echo '<tr class="noTask"><th class="display-6 text-center text-dark" colspan="7">No tasks<i class="far fa-calendar"></i></th></tr> ';                            
    }   
    
    echo '</tbody> </table>';

    mysqli_close($conn);  
?>


