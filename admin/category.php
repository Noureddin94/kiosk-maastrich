<?php
// Initialize the session
ob_start();
session_start();
$pageTitle = 'Category';
// Include config file
include_once 'init.php';
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Manage-Category</h1>
        <?php

        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
            header("Refresh:2");
        }
        if (isset($_SESSION['remove'])) {
            echo $_SESSION['remove'];
            unset($_SESSION['remove']);
            header("Refresh:2");
        }
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
            header("Refresh:2");
        }
        if (isset($_SESSION['no-category-found'])) {
            echo $_SESSION['no-category-found'];
            unset($_SESSION['no-category-found']);
            header("Refresh:2");
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
            header("Refresh:2");
        }
        if (isset($_SESSION['failed-remove'])) {
            echo $_SESSION['failed-remove'];
            unset($_SESSION['failed-remove']);
            header("Refresh:2");
        }
        ?>

        <br /><br /><br />
        <!-- <a href="add-category.php" class="btn-primary">Add Category</a> -->

        <br /><br /><br />
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Category-En</th>
                <th>Category-NL</th>
                <th>Actions</th>
            </tr>
            <?php
            // Query To Get All Category From Database
            $sql = "SELECT id, category_en, category_nl FROM tb_category ORDER BY id ASC";

            // Prepare and execute the query
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            $sn = 1;
            // Check if there are any rows
            if ($stmt->rowCount()) {
                // Fetch all rows from the result set
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                // We have data in the database
                // Loop through the rows and display the data
                foreach ($rows as $row) {
                    $id = $row['id'];
                    $category_en = $row['category_en'];
                    $category_nl = $row['category_nl'];
            ?>
                    <tr>
                        <td><?php echo $sn++; ?>. </td>
                        <td><?php echo $category_en; ?></td>
                        <td><?php echo $category_nl; ?></td>
                        <td>
                            <a href="update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>
                            <!-- <a href="delete-category.php?id=<?php echo $id; ?>" class="btn-danger" onclick="return confirm('Are you sure?')">Delete Category</a> -->
                        </td>
                    </tr>
                <?php
                }
            } else {
                // We do not have data
                // Display the message inside the table
                ?>
                <tr>
                    <td colspan="4">
                        <div class="error">No Category Added.</div>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
</div>
</div>
<?php
include $tpl . 'footer.php';
ob_end_flush();
?>