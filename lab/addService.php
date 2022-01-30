<?php 
	session_start(); 

	include("includes/connection.php");

	if(isset($_POST['add'])){
    $service = $_POST['service'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    
    $sql = "INSERT INTO services (service, price, category)
            VALUES ('$service', $price, '$category')";
    
    $result=mysqli_query($connect, $sql);
    if($result) {
        header('location:showServices.php');
    } else {
        die(mysqli_error($connect));
    }
    
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Add Patient</title>
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
			            <button class="btn btn-dark"><a href="admin.php" class="text-light">Go back</a></button>
			    </p>
			       
			            
			            <div class="form-group">
			                <label for="firstname">Servive</label>
			                <input type="text" class="form-control" id="service" name="service" autocomplete="off" placeholder="Enter service name...">
			            </div>

			            
			            <div class="form-group">
			                <label for="surname">Price</label>
			                <input type="text" class="form-control" id="price" name="price" autocomplete="off" placeholder="Enter price...">
			            </div>

			            <div class="form-group">
			                <label for="category">Category</label>
			                <select class="form-control" id="category" name="category">
			                <option>hematology</option>
			                <option>coagulation</option>
			                </select>
			            </div>

			            <button type="submit" class="btn btn-primary" name="add">Add</button>
			        </form>
			    </div>
    		</div>
		</div>
	</div>
</div>

</body>
</html>