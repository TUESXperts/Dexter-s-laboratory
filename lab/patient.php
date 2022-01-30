<?php
    session_start();

    include("check_login.php");
    if($_SESSION['role'] != "patient") {
        include("403_forbidden.php");
        return;
    };
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Dexter's Lab</title>
    <?php include("includes/header_links.php"); ?>
</head>
<body>
	<?php include("includes/header_navigation.php"); ?>

</body>
</html>