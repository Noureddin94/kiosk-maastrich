<?php
error_reporting(0);
// Initialize the session
ob_start();
session_start();
$pageTitle = 'Home-Page';

// Include config file
include_once 'init.php';
?>

<div class="text-center">
    <h1 class="my-2">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome.</h1>
    <p class="sign-res">
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>
</div>


<div class="main-content">
    <div class="wrapper">
        <h1>Dashboard</h1>
        <br><br>
        
        <br><br>

        <div class="col-4 text-center">

            <?php
            // SQL Query
            $sql = "SELECT * FROM tb_category";

            // Execute Query
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            // Count Rows
            $row = $stmt->rowCount();
            ?>

            <h1><?php echo $row; ?></h1>
            <br />
            Categories
        </div>

        <div class="col-4 text-center">

            <?php
            // SQL Query
            $sql2 = "SELECT * FROM tb_food";

            // Execute Query
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->execute();

            // Count Rows
            $row2 = $stmt2->rowCount();
            ?>

            <h1><?php echo $row2; ?></h1>
            <br />
            Foods
        </div>

        <div class="col-4 text-center">

            <?php
            // SQL Query
            $sql3 = "SELECT * FROM tb_blog";

            // Execute Query
            $stmt3 = $pdo->prepare($sql3);
            $stmt3->execute();

            // Count Rows
            $row3 = $stmt3->rowCount();
            ?>

            <h1><?php echo $row3; ?></h1>
            <br />
            Totlal Photo's
        </div>

        <div class="clearfix"></div>
    </div>
</div>

<?php
include $tpl . 'footer.php';
ob_end_flush();
?>