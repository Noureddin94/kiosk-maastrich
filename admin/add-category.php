<?php
// Initialize the session
ob_start();
session_start();
$pageTitle = 'Add-Category';

// Include config file
include_once 'init.php';
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add-Category</h1>
        <?PHP
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
            header("Refresh:2");
        }
        ?>
        <br /><br />
        <!-- Add Category Form Start -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Category-EN: </td>
                    <td>
                        <input type="text" name="category_en" placeholder="Category Title">
                    </td>
                </tr>
                <tr>
                    <td>Category-NL: </td>
                    <td>
                        <input type="text" name="category_nl" placeholder="Category Title">
                    </td>
                </tr>
                <tr class="pt-5">
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
        <!-- Add Category Form End -->

        <?php
        // Check Whether The Submit Button Is Clicked Or Not
        if (isset($_POST['submit'])) {

            // 1. Get The Value From Category Form
            $category_en = preg_replace('/[^a-zA-Z0-9_&]/', ' ', $_POST['category_en']);
            $category_nl = preg_replace('/[^a-zA-Z0-9_&]/', ' ', $_POST['category_nl']);
            // Validate Input Fields
            if (empty($category_en) && empty($category_nl)) {
                echo "Error: Title cannot be empty";
            } else {
                // 2. Insert The Value In Database
                $sql = "INSERT INTO tb_category SET
                category_en = '$category_en',
                category_nl = '$category_nl'
                ";

                // 3. Execute The Query And Save In Database
                $stmt = $pdo->exec($sql);

                // 4. Check Whether The Query Executed Or Not And Data Added Or Not
                if ($stmt !== false) {
                    // Query Execute And Category Added
                    $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                    // Redirect To  Category Page
                    header('location:category.php');
                    exit;
                } else {
                    // Failed To Add Category
                    $_SESSION['add'] = "<div class='error'>Failed To Add Categoryy.</div>";
                    // Redirect To Add Category Page
                    header('location:add-category.php');
                    exit;
                }
            }
        }
        ?>
    </div>
</div>

<?php
include $tpl . 'footer.php';
ob_end_flush();
?>