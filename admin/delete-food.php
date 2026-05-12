<?php
// Initialize the session
ob_start();
session_start();
$pageTitle = 'Delete-Food';
// Include config file
include 'init.php';


// Check Whether The id And image_name Value Is Set Or Not
if (isset($_GET['id'])) {
    // Get The Value And Delete
    $id = $_GET['id'];

    // Delete Data From Database
    // SQL Query Delete Data From Database
    $sql = "DELETE FROM tb_food WHERE id=$id";

    // Execute The Query
    $stmt = $pdo->exec($sql);

    // Check Whether The Data Is Delete From Database Or Not
    if ($stmt !== false) {
        // Set Success Message And Redirect
        $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
        // Redirect To Manege food
        header('location:food.php');
        exit;
    } else {
        // Set Failed Message And Redirect
        $_SESSION['delete'] = "<div class='error'>Failed To Delete The Food.</div>";
        // Redirect To Manege Food
        header('location:food.php');
        exit;
    }
} else {
    // Redirect To Manege Food Page
    header('location:food.php');
}


include $tpl . 'footer.php';
ob_end_flush();
