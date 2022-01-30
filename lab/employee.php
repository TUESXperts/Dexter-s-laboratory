<?php
    session_start();

    include("check_login.php");
    if($_SESSION['role'] != "employee") {
        include("403_forbidden.php");
        return;
    };

include("includes/connection.php");

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Patients administration</title>
    <?php include("includes/header_links.php"); ?>
</head>
<body>

<?php include("includes/header_navigation.php"); ?>

<div class="container" style="text-align:center">
    <button class="btn btn-info my-5" style="float:right;">
        <a href="addPatient.php" class="text-light" >
            Register Patient
        </a>
    </button>

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">First name</th>
            <th scope="col">Surname</th>
            <th scope="col">Username</th>
            <th scope="col">Gender</th>
        </tr>
        </thead>
        <tbody>

        <?php

        $sql="SELECT id,firstname, surname, username, gender FROM users WHERE role='patient'";
        $result=mysqli_query($connect, $sql);
        if($result) {
            $i = 1;
            while($row=mysqli_fetch_assoc($result)) {
                $id=$row['id'];
                $firstname = $row['firstname'];
                $surname=$row['surname'];
                $username=$row['username'];
                $gender = $row['gender'];

                echo '
                                <tr>
                                    <th scope="row">' . $i . '</th>
                                    <td>'.$firstname.'</td>
                                    <td>'.$surname.'</td>
                                    <td>'.$username.'</td>
                                    <td>'.$gender. '</td>
                                    <td>
                                    <p style = "line-height:1.4">
                                        <button type="button" class="btn btn-primary"><a href="examinations.php?userid=' . $id . '" class="text-light">Examinations</a></button>
                                        <button class="btn btn-success"><a href="updateEmployee.php?updateid=' .$id.'" class="text-light">Edit</a></button>
                                        <button class="btn btn-danger"><a href="deleteEmployee.php?deleteid='.$id.'" class="text-light">Delete</a></button>
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