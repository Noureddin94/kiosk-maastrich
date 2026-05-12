<?php
// error_reporting(0);
// Initialize the session
session_start();
// Include config file
include_once 'init.php';

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
unset($_SESSION['loggedin']);
session_destroy();

// Redirect to login page
header('location:login.php');
exit;
