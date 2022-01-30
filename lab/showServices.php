<?php 

session_start();

include("includes/connection.php");

?>

<!DOCTYPE html>
<html>
<head>
	<title>Employees administration</title>
    <?php include("includes/header_links.php"); ?>
</head>
<body>

    <?php include("includes/header_navigation.php"); ?>

	<div class="container" style="text-align:center">
        <button class="btn btn-dark my-5" style="float:left;">
            <a href="admin.php" class="text-light" >
                Go back
            </a>
        </button>


        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Services</th>
                    <th scope="col">Price</th>
                    <th scope="col">Categoty</th>
                </tr>
            </thead>
            <tbody>

                <?php

                    $sql="SELECT * FROM services";
                    $result=mysqli_query($connect, $sql);
                    if($result) {
                        $i = 1;
                        while($row=mysqli_fetch_assoc($result)) {
                            $id=$row['id'];
                            $service = $row['service'];
                            $price=$row['price'];
                            $category=$row['category'];
                        
                            
                            echo '
                                <tr>
                                    <th scope="row">' . $i . '</th>
                                    <td>'.$service.'</td>
                                    <td>'.$price.'</td>
                                    <td>'.$category.'</td>
                                    <td>
                                    <p style = "line-height:1.4">
                                        <button class="btn btn-success"><a href="updateService.php?updateid='.$id.'" class="text-light">Edit</a></button>
                                        <button class="btn btn-danger"><a href="deleteService.php?deleteid='.$id.'" class="text-light">Delete</a></button>
                                    </p>
                                    </td>
                                </tr>
                            ';
                            $i++;
                        }
                    }
    
                ?>
            </tbody>
        </table>

    </div>
</body>
</html>