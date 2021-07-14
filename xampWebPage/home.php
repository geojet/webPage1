<?php
include "config.php";
// Check user login or not
if(!isset($_SESSION['id'])){
    header('Location: index.php');
}else {
    $sql_query = "select type from user_details where user_id='".$_SESSION['id']."'";
        $result = mysqli_query($con,$sql_query);
        $row = mysqli_fetch_array($result);

        $type = $row['type'];

        if($type == "" || $type != 1){
            header('Location: index.php');
        }
}

// logout
if(isset($_POST['but_logout'])){
    session_destroy();
    header('Location: index.php');
}
if(isset($_POST['book'])){
    $code =  $_POST['code'];
    #$code = mysqli_real_escape_string($con,$_POST['code']);
    if ($code != ""){

        $sql_query = "UPDATE `venue` SET `status`= 'booked' WHERE `code` = '$code'";
        $result = mysqli_query($con,$sql_query);
        if (mysqli_query($con,$sql_query) === TRUE) {
            echo "Venue Booked";
            $sql_query = "select max(bno) as maxId from orders";
            $result = mysqli_query($con,$sql_query);
            $row = mysqli_fetch_array($result);
            $count = $row['maxId']+1;
            $sql_query = "select agent_id from booking_agents where `user_id` = '".$_SESSION['id']."'";
            $result = mysqli_query($con,$sql_query);
            $row = mysqli_fetch_array($result);
            $agentid = $row['agent_id'];
            $bdate=date("Y-m-d");
            $sql_query = "INSERT INTO `orders` (`bno`, `agentid`, `venue`, `bdate`) VALUES ('$count','$agentid','$code','$bdate');";
            if (mysqli_query($con,$sql_query) === TRUE) {
            echo "New record created successfully";
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($con);
            }
        } else {
            echo "Error: " . $sql_query . "<br>" . mysqli_error($con);
        }

    }
    
}
if(isset($_POST['submit'])){
    $type = mysqli_real_escape_string($con,$_POST['type']);
    $address = mysqli_real_escape_string($con,$_POST['address']);
    $price = mysqli_real_escape_string($con,$_POST['price']);
    $time = mysqli_real_escape_string($con,$_POST['time']);
    $availability = mysqli_real_escape_string($con,$_POST['availability']);
    $code = mysqli_real_escape_string($con,$_POST['code']);
    $sql = "SELECT `acronym` FROM `owners` where `user_id` ='".$_SESSION['id']."'";
    $result = mysqli_query($con, $sql);
    $row1 = mysqli_fetch_assoc($result);
    $sql_query = "select max(user_id) as maxId from user_details";
    $result = mysqli_query($con,$sql_query);
    $row = mysqli_fetch_array($result);

    $count = $row['maxId']+1;
    $query = "INSERT INTO venue (type,address, price, status, period,availability,owner,code) VALUES ('$type','$address','$price','available','$time','$availability','".$row1['acronym']."','$code');";
    if (mysqli_query($con,$query) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($con);
    }
    

    
    
}

?>
<!doctype html>
<html>
    <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="style1.css">


    <title>BROSS</title>

</head>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">BROSS </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="login.php">Home <span class="sr-only">(current)</span></a>
                </li>

            </ul>
            
        </div>
    </nav>
    <body>
        <div class="container my-4">

        <form method="post" action="">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Type</th>
                    <th scope="col">Code</th>
                    <th scope="col">Address</th>
                    <th scope="col">Availability</th>
                    <th scope="col">Time</th>
                    
                    <th scope="col">        </th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sql = "SELECT `acronym` FROM `owners` where `user_id` ='".$_SESSION['id']."'";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($result);
          $sql = "SELECT * FROM `venue` where owner = '".$row['acronym']."' ";
          $result = mysqli_query($con, $sql);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $sno = $sno + 1;
            $code = $row['code'];
            echo "<tr>
            <th scope='row'>". $sno . "</th>
            <td>". $row['type'] . "</td>
            <td>". $row['code'] . "</td>
            <td>". $row['address'] . "</td>
            <td>". $row['availability'] . "</td>
            <td>". $row['period'] . "</td>
            <td>". $row['status'] . "</td>

            
          </tr>";
        } 
        ?>
        <label for="VENUE CODE"><b>VENUE CODE</b></label>
        <div class="row">
                
            <div class="col-4"> 
                <input type="text" class="form-control" placeholder="Enter VENUE CODE" name="code" required>
            </div>            
            <br>
            <div class="col-4"> 
                <button name="book" id= "book" class="form_btn btn btn-secondary" type="submit">BOOK</button>
            </div>
    
               
        </div>


            </tbody>

        </table>
        </form>
        <form method='post' action="">
            <div class="col-sm-4">
                <div class="login_form">
                    <h2 class="text-center">Add new venue</h2>
                    <hr>
                    <form  method="post">
                      <div style="background-image: url('background.jpg');">

                          <div class="container">
                            <label for="type"><b>Type</b></label>
                            <input type="text" class="form-control" placeholder="Enter Type" name="type" required>
                            <br>
                            <label for="code"><b>Code</b></label>
                            <input type="code" class="form-control" placeholder="Enter Code" name="code" required>
                            <br>
                            <label for="address"><b>Address</b></label>
                            <input type="text" class="form-control" placeholder="Enter address" name="address" required>
                            <br>
                            <label for="availability"><b>Availability</b></label>
                            <input type="text" class="form-control" placeholder="Enter availability" name="availability" required>
                            <br>
                            <label for="time"><b>Time</b></label>
                            <input type="text" class="form-control" placeholder="Enter time" name="time" required>
                            <br>
                            <label for="price"><b>Price</b></label>
                            <input type="text" class="form-control" placeholder="Enter price" name="price" required>
                            <br>
                            <button name="submit" id= "submit" class="form_btn btn btn-secondary" type="submit">ADD</button>
                            
                          
                      </div>
                    </form>
                </div>
            </div>
            
        </form>

    </div>
    <form  method="post">
        <input type="submit" value="Logout" name="but_logout">
    </form>
    <hr>
    
    
</body>
</html>