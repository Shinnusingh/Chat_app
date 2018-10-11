<!--
//login.php
!-->

<?php

include('database_connection.php');

session_start();

$message = '';

//if already loggined user tries to go back to the page "login.php"

if(isset($_SESSION['user_id']))
{
 header('location:index.php');
}

if(isset($_POST["login"]))
{
 $query = "
   SELECT * FROM login 
    WHERE username = :username
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
    array(
      ':username' => $_POST["username"]
     )
  );
  $count = $statement->rowCount();
  if($count > 0)
 {
  $result = $statement->fetchAll();
    foreach($result as $row)
    {
      if(password_verify($_POST["password"], $row["password"]))
      {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $sub_query = "
        INSERT INTO login_details 
        (user_id) 
        VALUES ('".$row['user_id']."')
        ";
        $statement = $connect->prepare($sub_query);
        $statement->execute();
        $_SESSION['login_details_id'] = $connect->lastInsertId();
        header("location:index.php");
      }
      else
      {
       $message = "<label>Wrong Password</label>";
      }
    }
 }
 else
 {
  $message = "<label>Wrong Username</label>";
 }
}

?>



<html>  
    <head>  
        <title>Chat App</title>  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="index.css">
    </head>  
    <body>  
        <div class="container">
   <br />
   
   <h3 align="center">Login</h3><br />
          <h3 align="right">  <button class="btn btn-danger" id="signup">+ Sign Up</button></h3>
   <br />
            <div class="col-sm-4"></div>
<div class="panel panel-primary col-sm-4">
      <div class="panel-heading">Chat Application Login</div>
    <div class="panel-body">
<!--      <form  action="login.php"> ...same page-->
     <form method="post"> 
      <p class="text-danger"><?php echo $message; ?></p>
      <div class="form-group">
       <label>Enter Username</label>
       <input type="text" name="username" class="form-control" required />
      </div>
      <div class="form-group">
       <label>Enter Password</label>
       <input type="password" name="password" class="form-control" required />
      </div>
      <div class="form-group">
       <input type="submit" name="login" class="btn btn-success" value="Login" />
      </div>
     </form>
    </div>
  </div>
            <div class="col-sm-4"></div>
</div>
</body>
</html>

<script>
    $(document).ready(function(){

        $(document).on('click', '#signup', function(){
                location.href="add_me.php";
        })
});  
    
    </script>

