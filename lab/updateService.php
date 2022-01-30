<?php

session_start();

include("includes/connection.php");

$id = $_GET['updateid'];

if(isset($_POST['update'])){
    $service = $_POST['service'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $sql="UPDATE services SET service='$service', price=$price, category='$category' WHERE id=$id";

    $result=mysqli_query($connect, $sql);
    if($result) {
        header('location: showServices.php');
        return;
    } else {
        die(mysqli_error($connect));
    }

}

    $sql="SELECT * FROM services WHERE id=$id";
    $result=mysqli_query($connect, $sql);
    $row=mysqli_fetch_assoc($result);

    $id = $row['id'];
    $service = $row['service'];
    $price = $row['price'];
    $category = $row['category'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Update Employee</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <?php include("includes/header_links.php"); ?>
</head>
  <body>
    <?php include("includes/header_navigation.php"); ?>
<div class="container">
    <div class="col-md-12">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 shadow-sm" style="margin-top:100px;">
                <form method="post">    
                <div class="container my-5">
                <p style = "line-height:1.4">
                        <button class="btn btn-dark"><a href="showServices.php" class="text-light">Go back</a></button>
                </p>
                    
                        <div class="form-group">
                            <label for="service">Service</label>
                            <input type="text" class="form-control" id="service" name="service" autocomplete="off" 
                                   placeholder="Enter new service name..." value=<?php echo $service;?>>
                        </div>

                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" class="form-control" id="price" name="price" autocomplete="off" 
                                   placeholder="Enter new price..." value=<?php echo $price;?>>
                        </div>
                 
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" id="category" name="category">
                                <option <?php echo ($row['category'] == 'hematology')? 'selected':''; ?>>hematology</option>
                                <option <?php echo ($row['category'] == 'coagulation')? 'selected':''; ?>>coagulation</option>
                            </select>
                        </div>

                       <button type="submit" class="btn btn-primary" name="update">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    </body>
</html>