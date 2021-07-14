<?php
include "config.php";


if(isset($_POST['submit'])){

    $id = mysqli_real_escape_string($con,$_POST['id']);
    $password = mysqli_real_escape_string($con,$_POST['password']);


    if ($id != "" && $password != ""){

        $sql_query = "select type from user_details where user_id='".$id."' and password='".$password."'";
        $result = mysqli_query($con,$sql_query);
        $row = mysqli_fetch_array($result);

        $type = $row['type'];

        if($type != ""){
        	if($type == 1){

	            $_SESSION['id'] = $id;
	            header('Location: home.php');
	        }
	        else if($type == 0){

	            $_SESSION['id'] = $id;
	            header('Location: sysadmin.php');
	        }
	        else{
	        	$_SESSION['id'] = $id;
	            header('Location: book.php');
	        }

        }else{
            echo "Invalid username and password";
        }

    }

}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">

    <title>BROSS</title>
  </head>
  <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">BROSS</a>

       
        </nav>

       <div class="container">
         <div class="row">
             
            
            <div class="col-sm-4">
                <div class="login_form">
                    <h2 class="text-center">Login Form</h2>
                    <hr>
                    <form method="post" action="">
                        
                        <div class="form-group">
                            <label >User ID</label>
                            <input type="id" class="form-control" required="required" name="id" id="id" aria-describedby="id" placeholder="Enter User ID">
                            
                        </div>
                        <div class="form-group">
                            <label >Password</label>
                            <input type="password" required="required" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
                        </div>
                        
                        <button type="submit" name="submit" id= "submit" class="form_btn btn btn-secondary">Login</button><br>
                        <p>Do not have an account? 
                          <br> 
                          <a href="owner.php">Sign up as Owner</a>
                          <br>
                          <a href="agent.php">Sign up as Agent</a></p>
                    </form>
                </div>
            </div>
            <div class="col-sm-4">
            
            </div>
        
        </div>

       </div>
    
  </body>
</html>