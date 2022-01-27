<?php
    session_start();

    include("check_login.php");
    if($_SESSION['role'] != "employee") {
        include("403_forbidden.php");
        return;
    };
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Dexter's Lab</title>
</head>
<body>

	<?php include("includes/header.php"); ?>

</body>
</html>