<?php

session_start();

include("includes/connection.php");

$id=$_GET['updateid'];

$sql="SELECT * FROM users WHERE id=$id";
$result=mysqli_query($connect, $sql);
$row=mysqli_fetch_assoc($result);
$id = $row['id'];
$firstname = $row['firstname'];
$surname = $row['surname'];
$username = $row['username'];
$gender = $row['gender'];
$role = $row['role'];
$contract_type = $row['contract_type'];
$hiring_date = $row['hiring_date'];
$password = $row['password'];

if(isset($_POST['update'])){
    $firstname = $_POST['firstname'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $gender = $_POST['gender'];
    $role = $_POST['role'];
    $contract_type = $_POST['contract_type'];
    $hiring_date = $_POST['hiring_date'];
    $password = $_POST['password'];
    
    $sql="UPDATE users SET id=$id, firstname='$firstname', surname='$surname', username='$username', gender='$gender', role='$role', contract_type='$contract_type', hiring_date='$hiring_date', password='$password' WHERE id=$id";
    
    $result=mysqli_query($connect, $sql);
    if($result) {
        header('location:admin.php');
    } else {
        die(mysqli_error($connect));
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
                            <input type="text" class="form-control" id="firstname" name="firstname" autocomplete="off" 
                                   placeholder="Enter new first name..." value=<?php echo $firstname;?>>
                        </div>

                        <div class="form-group">
                            <label for="surname">Surname</label>
                            <input type="text" class="form-control" id="surname" name="surname" autocomplete="off" 
                                   placeholder="Enter new surname..." value=<?php echo $surname;?>>
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" autocomplete="off" 
                                   placeholder="Enter new username..." value=<?php echo $username;?>>
                        </div>
                 
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control" id="gender" name="gender">
                                <option <?php echo ($row['gender'] == 'Male')?'selected':''; ?>>Male</option>
                                <option <?php echo ($row['gender'] == 'Female')?'selected':''; ?>>Female</option>
                                <option <?php echo ($row['gender'] == 'Non-binary')?'selected':''; ?>>Non-binary</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" id="role" name="role">
                            <option>employee</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="contract_type">Contract type</label>
                            <select class="form-control" id="contact_type" name="contract_type">
                            <option>Employment contract</option>
                            <option>Civil contract</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="hiring_date">Hiring date</label>
                            <input type="date" id="hiring_date" name="hiring_date" class="form-control my-2" value="2022-01-01" min="2018-01-01" max="2222-12-31">
                        </div>



                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control my-2" placeholder="Enter new password..." value=<?php echo $password; ?>>
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