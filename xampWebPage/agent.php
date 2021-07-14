<?php
include "config.php";


if(isset($_POST['submit'])){

    $uname = mysqli_real_escape_string($con,$_POST['uname']);
    $password = mysqli_real_escape_string($con,$_POST['password']);
    $address = mysqli_real_escape_string($con,$_POST['address']);
    $organisation = mysqli_real_escape_string($con,$_POST['organisation']);
    $agentid = mysqli_real_escape_string($con,$_POST['agentid']);

    if ($uname != "" && $password != ""){
        $sql_query = "select max(user_id) as maxId from user_details";
        $result = mysqli_query($con,$sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['maxId']+1;
        $query = "INSERT INTO user_details (user_id,type, address, name, password) VALUES ('$count',1,'$address','$uname','$password');";
        if (mysqli_query($con,$query) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($con);
        }
        $query = "INSERT INTO `booking_agents`(`user_id`, `organisation`, `agent_id`) VALUES ('$count','$organisation','$agentid')";
                #INSERT INTO owners (user_id) VALUES (1013);";
        if (mysqli_query($con,$query) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($con);
        }
        $result = mysqli_query($con,$sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['maxId']+1;
        echo $count;

    }

}

?>

<!doctype html>
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
                    <h2 class="text-center">Register Form</h2>
                    <hr>
                    <form  method="post">
					  <div style="background-image: url('background.jpg');">

						  <div class="container">
						    <label for="uname"><b>User Name</b></label>
						    <input type="text" class="form-control" placeholder="Enter Username" name="uname" required>
						    <br>
						    <label for="Password"><b>Password</b></label>
						    <input type="password" class="form-control" placeholder="Enter Password" name="password" required>
						    <br>
						    <label for="address"><b>Address</b></label>
						    <input type="text" class="form-control" placeholder="Enter address" name="address" required>
						    <br>
						    <label for="Organisation"><b>Organisation</b></label>
						    <input type="text" class="form-control" placeholder="Enter Organisation" name="organisation" required>
						    <br>
						    <label for="Agent id"><b>Agent id</b></label>
						    <input type="number" class="form-control" placeholder="Enter Agent id" name="agentid" required>
						    <br>
						    <button class="form_btn btn btn-secondary" name="submit" type="submit">Register</button>
						    
						  
					  </div>
					</form>
				</div>
            </div>
            <div class="col-sm-4">
            
            </div>
        
        </div>

       </div>
    
  </body>