<?php

include('database_connection.php');
session_start();

if(isset($_POST["signup"]))
{
    
    $query="
             SELECT * from login WHERE username=:username
           ";
    $statement=$connect->prepare($query);
    $statement->execute(
                         
        array(
                ':username'=>$_POST["username"]
            
             )
    );
    
    $count=$statement->rowCount();
    if($count>0){
        
        echo '<script> alert("username already taken")</script>';
    }
    
    else
    {
        $hash=password_hash($_POST['password'],PASSWORD_DEFAULT);
        $query="INSERT into login (username,password) VALUES (:username,:hash)";
        $statement=$connect->prepare($query);
        $statement->execute(
        array(
        
        ':username'=>$_POST["username"],
            ':hash'=>$hash
        )
        
        );
        
         echo '<script>alert("Successfully signed up. Login to Chat")</script>';
        

        
    }
   
    
        
    
}


?>


<html>  
    <head>  
        <title>Sign-Up</title>  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="index2.css">
    </head>  
    <body>  
        <div class="container">
   <br />
   
   <h3 align="center" style="color:orange"><b>Sign-Up</b></h3><br />
    <h4 align="right"><button class="btn btn-danger" id="log">Login</button></h3>
   <br />
            <div class="col-sm-4"></div>
   <div class="panel panel-primary col-sm-4">
      <div class="panel-heading">Chat Application SignUp</div>
    <div class="panel-body">
     <form method="post">
      
      <div class="form-group">
       <label> Username</label>
       <input type="text" name="username" class="form-control" required />
      </div>
      <div class="form-group">
       <label> Password</label>
       <input type="password" name="password" class="form-control" required />
      </div>
      <div class="form-group">
       <input type="submit" name="signup" class="btn btn-success" value="signup" />
      </div>
     </form>
    </div>
  </div>
            <div class="col-sm-4"></div>
</div>
</body>
</html>

<script>

$(document).on('click', '#log', function(){
                location.href="index.php";
});
</script>
