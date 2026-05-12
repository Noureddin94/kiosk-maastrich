<?php
// Initialize the session
ob_start();
session_start();

$pageTitle = 'Food';

// Include config file
include_once 'init.php';
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage-Food</h1>
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
        // if (isset($_SESSION['upload'])) {
        //     echo $_SESSION['upload'];
        //     unset($_SESSION['upload']);
        //     header("Refresh:2");
        // }
        if (isset($_SESSION['failed-remove'])) {
            echo $_SESSION['failed-remove'];
            unset($_SESSION['failed-remove']);
            header("Refresh:2");
        }
        ?>
        <br /><br /><br />
        <a href="add-food.php" class="btn-primary">Add Food</a>
        <br /><br />
        <table class="tbl-full">

            <tr>
                <th>S.N.</th>
                <th>T-en</th>
                <th>T-nl</th>
                <th>Description-en</th>
                <th>Description-nl</th>
                <th>Cat-EN</th>
                <th>Cat-NL</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            <?php

            // Query To Get All Category From Database
            $sql = "SELECT tb_food.*, tb_category.category_en, tb_category.category_nl
            FROM tb_food
            JOIN tb_category ON tb_category.id = tb_food.category_id
            ORDER BY tb_food.id ASC";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $sn = 1;

            if ($stmt->rowCount()) {
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($rows as $row) {
                    $id = $row['id'];
                    $title_en = $row['title_en'];
                    $title_nl = $row['title_nl'];
                    $description_en = $row['description_en'];
                    $description_nl = $row['description_nl'];
                    $price = $row['price'];
                    $category_en = $row['category_en'];
                    $category_nl = $row['category_nl'];

            ?>
                    <tr>
                        <td><?php echo $sn++; ?>. </td>
                        <td><?php echo $title_en; ?></td>
                        <td><?php echo $title_nl; ?></td>
                        <td><?php echo $description_en; ?></td>
                        <td><?php echo $description_nl; ?></td>
                        <td><?php echo $category_en; ?></td>
                        <td><?php echo $category_nl; ?></td>
                        <td><?php echo $price; ?>€</td>

                        <td>
                            <a href="update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update</a>
                            <a href="delete-food.php?id=<?php echo $id; ?>" class="btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php

                }
            } else {
                // We do not have data
                // Display the message inside the table
                ?>
                <tr>
                    <td colspan="6">
                        <div class="error">No Food Added.</div>
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