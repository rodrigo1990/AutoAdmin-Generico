<?php 
session_start();
if(!isset($_SESSION["pass"]) AND !isset($_SESSION['email'])){
    header("Location:index.php");
}
?>