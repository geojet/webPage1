<?php
include "config.php";
// Check user login or not
if(!isset($_SESSION['id'])){
    header('Location: index.php');
}

// logout
if(isset($_POST['but_logout'])){
    session_destroy();
    header('Location: index.php');
}
if(isset($_POST['book'])){
    $code =  $_POST['code'];
    #$code = mysqli_real_escape_string($con,$_POST['code']);
    echo $code;
    if ($code != ""){

        $sql_query = "UPDATE `venue` SET `status`= 'booked' WHERE `code` = '$code'";
        echo $sql_query;
        $result = mysqli_query($con,$sql_query);
        if (mysqli_query($con,$sql_query) === TRUE) {
            echo "Venue Booked";
            #header('Location: home.php');
        } else {
            echo "Error: " . $sql_query . "<br>" . mysqli_error($con);
        }

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
                    <th scope="col">Owner</th>
                    <th scope="col">Code</th>
                    <th scope="col">Address</th>
                    <th scope="col">Availability</th>
                    <th scope="col">Time</th>
                    <th scope="col">Price</th>
                    <th scope="col">        </th>
                </tr>
            </thead>
            <tbody>
                <?php 
          $sql = "SELECT * FROM `venue`";
          $result = mysqli_query($con, $sql);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $sno = $sno + 1;
            $code = $row['code'];
            echo "<tr>
            <th scope='row'>". $sno . "</th>
            <td>". $row['type'] . "</td>
            <td>". $row['owner'] . "</td>
            <td>". $row['code'] . "</td>
            <td>". $row['address'] . "</td>
            <td>". $row['availability'] . "</td>
            <td>". $row['period'] . "</td>
            <td>". $row['price'] . "</td>
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
            <input type="submit" value="Logout" name="but_logout">
        </form>
    </div>
    <hr>
    
    
</body>
</html>