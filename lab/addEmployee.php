<?php 
	session_start(); 

	include("includes/connection.php");

	if(isset($_POST['register'])){
    $firstname = $_POST['firstname'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $gender = $_POST['gender'];
    $role = $_POST['role'];
    $password = $_POST['password'];
    
    $sql = "INSERT INTO users (firstname, surname, username, gender, role, password)
            VALUES ('$firstname', '$surname', '$username', '$gender','$role', '$password')";
    
    $result=mysqli_query($connect, $sql);
    if($result) {
        header('location:admin.php');
    } else {
        die(mysqli_error($conn));
    }
    
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Dexter's Lab</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<?php include("includes/header.php"); ?>
	
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
			                <label for="firstname">First name</label>
			                <input type="text" class="form-control" id="firstname" name="firstname" autocomplete="off" placeholder="Enter first name...">
			            </div>

			            
			            <div class="form-group">
			                <label for="surname">Surname</label>
			                <input type="text" class="form-control" id="surname" name="surname" autocomplete="off" placeholder="Enter surname...">
			            </div>


			            <div class="form-group">
			                <label for="username">Username</label>
			                <input type="text" class="form-control" id="username" name="username" autocomplete="off" placeholder="Enter username...">
			            </div>
			            

			            <div class="form-group">
			                <label for="gender">Gender</label>
			                <select class="form-control" id="gender" name="gender">
			                <option>Male</option>
			                <option>Female</option>
			                </select>
			            </div>


			            <div class="form-group">
			                <label for="role">Role</label>
			                <select class="form-control" id="role" name="role">
			                <option>Employee</option>
			                </select>
			            </div>

			            <label>Password</label>
						<input type="password" name="password" class="form-control my-2" placeholder="Enter Password">

			            <button type="submit" class="btn btn-primary" name="register">Register</button>
			        </form>
			    </div>
    		</div>
		</div>
	</div>
</div>

</body>
</html>