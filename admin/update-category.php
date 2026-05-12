<?php
// Initialize the session
ob_start();
session_start();
$pageTitle = 'Update-Category';

// Include config file
include 'init.php';
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>
        <?php
        // Check Whether The id Is Set Or Not
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            // Get The ID And All Other Details
            // echo "Getting The Data";
            $id = $_GET['id'];

            // Create a prepared statement with a parameter
            $sql = "SELECT * FROM tb_category WHERE id=:id";  // Use a placeholder :id
            $stmt = $pdo->prepare($sql);

            // Bind the parameter
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Execute The Query
            $stmt->execute();

            // Check whether the id is valid or not
            if ($stmt->rowCount() == 1) {
                // Get The Data (fetch single row)
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $category_en = $row['category_en'];
                $category_nl = $row['category_nl'];
            } else {
                // Redirect To manage category With session message
                $_SESSION['no-category-found'] = "<div class='error'>Category Not Found.</div>";
                header('location:category.php');
                exit;
            }
        } else {
            // Redirect To Manage Category
            header('location:category.php');
            exit;
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>category-EN: </td>
                    <td>
                        <input type="text" name="category_en" value="<?php echo $category_en; ?>">
                    </td>
                </tr>
                <tr>
                    <td>category-NL: </td>
                    <td>
                        <input type="text" name="category_nl" value="<?php echo $category_nl; ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            // echo "Clicked";
            // 1. Get All The Values From Our Form
            $id = $_POST['id'];
            $category_en = preg_replace('/[^a-zA-Z0-9_&]/', ' ', $_POST['category_en']);
            $category_nl = preg_replace('/[^a-zA-Z0-9_&]/', ' ', $_POST['category_nl']);

            // 2. Update The Database
            $sql2 = "UPDATE tb_category SET category_en = :category_en, category_nl = :category_nl WHERE id = :id";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->bindParam(':category_en', $category_en, PDO::PARAM_STR);
            $stmt2->bindParam(':category_nl', $category_nl, PDO::PARAM_STR);
            $stmt2->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt2->execute();


            // 3. Redirect To Manege Category With Message
            // Check Whether Executed Or Not
            if ($stmt2 !== false) {
                // Category Updated
                $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
                header('location:category.php');
                exit;
            } else {
                // Failed To Update Category
                $_SESSION['update'] = "<div class='error'>Failed To Update Category.</div>";
                header('location:update-category.php');
                exit;
            }
        }
        ?>
    </div>
</div>

<?php
include $tpl . 'footer.php';
ob_end_flush();
?>