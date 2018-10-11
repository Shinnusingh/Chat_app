<?php

//action.php

include('database_connection.php');

session_start();

$query = "
     
       Select * FROM login
       WHERE user_id != '".$_SESSION['user_id']."'  
";
//where username is not equal to session username

$statement = $connect->prepare($query);

$statement->execute();
$result=$statement->fetchAll();

$output = '
<table class="table table-bordered table-striped">
 <tr>
  <td>Username</td>
  <td>Status</td>
  <td>Action</td>
 </tr>
';
    
 foreach($result as $row)
{
     
   $status = '';
   $current_timestamp = strtotime(date('Y-m-d H:i:s').'-5 second');
     
   $current_timestamp = date('Y-m-d H:i:s',$current_timestamp);
     
   $user_last_activity = fetch_user_last_activity($row['user_id'],$connect);  
     
     if($user_last_activity > $current_timestamp)
     {
         $status ='<span class="label label-success">Online</span>';
     }
     else
     {
         $status ='<span class="label label-danger">Offline</span>';
     }
     
 $output .= '
 <tr>
  <td>'.$row['username'].'</td>
  <td>'.$status.'</td>
  <td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'">Chat</button></td>
 </tr>
 ';
  // for every fetched row we assign custom data attribute (touserid=user_id of fetched user and //tousername=username of fetched user) . This attributes are for recognising with whom we r abt to //chat   
}

 $output .= '</table>';
echo $output;

?>