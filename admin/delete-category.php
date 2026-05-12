<?php
// Initialize the session
ob_start();
session_start();
$pageTitle = 'Delete-Category';
// Include config file
include 'init.php';


// Check Whether The id And image_name Value Is Set Or Not
if (isset($_GET['id'])) {
    // Get The Value And Delete
    $id = $_GET['id'];

    // Delete Data From Database
    // SQL Query Delete Data From Database
    $sql = "DELETE FROM tb_category WHERE id = :id";

    // Execute The Query
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Check Whether The Data Is Delete From Database Or Not
    if ($stmt !== false) {
        // Set Success Message And Redirect
        $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully.</div>";
        // Redirect To Manege Category
        header('location:' . SITEURL . 'admin/category.php');
        exit;
    } else {
        // Set Failed Message And Redirect
        $_SESSION['delete'] = "<div class='error'>Failed To Delete The Category.</div>";
        // Redirect To Manege Category
        header('location:' . SITEURL . 'admin/category.php');
        exit;
    }
} else {
    // Redirect To Manege Category Page
    header('location:' . SITEURL . 'admin/category.php');
}


include $tpl . 'footer.php';
ob_end_flush();
