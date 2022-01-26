<?php 
session_start();


if (isset($_SESSION['patient'])) {
	unset($_SESSION['patient']);
	header("Location:index.php");
}else if(isset($_SESSION['employee'])){
	unset($_SESSION['employee']);
	header("Location:index.php");
}else if(isset($_SESSION['admin'])){
	unset($_SESSION['admin']);
	header("Location:index.php");
}



 ?>