<?php
// Initialize the session
ob_start();
session_start();
$pageTitle = 'Update-Food';

// Include config file
include 'init.php';
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>
        <?php
        // Check Whether The id Is Set Or Not
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            // Get The ID And All Other Details
            // echo "Getting The Data";
            $id = $_GET['id'];

            // Create a prepared statement with a parameter
            $sql = "SELECT * FROM tb_food WHERE id=:id";  // Use a placeholder :id
            $stmt = $pdo->prepare($sql);

            // Bind the parameter
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Execute The Query
            $stmt->execute();

            // Check whether the id is valid or not
            if ($stmt->rowCount() == 1) {
                // Get The Data (fetch single row)
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $title_en = $row['title_en'];
                $title_nl = $row['title_nl'];
                $description_en = $row['description_en'];
                $description_nl = $row['description_nl'];
                $price = $row['price'];
                $category = $row['category_id'];
            } else {
                // Redirect To manage food With session message
                $_SESSION['no-food-found'] = "<div class='error'>food Not Found.</div>";
                header('location:food.php');
                exit;
            }
        } else {
            // Redirect To Manage food
            header('location:food.php');
            exit;
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title-EN: </td>
                    <td>
                        <input type="text" name="title_en" value="<?php echo $title_en; ?>">
                    </td>
                </tr>
                <tr>
                <tr>
                    <td>Title-NL: </td>
                    <td>
                        <input type="text" name="title_nl" value="<?php echo $title_nl; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Description-EN: </td>
                    <td>
                        <input type="text" name="description_en" value="<?php echo $description_en; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Description-NL: </td>
                    <td>
                        <input type="text" name="description_nl" value="<?php echo $description_nl; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="text" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php
                            $sql3 = 'SELECT id, category_en AS category_title FROM tb_category';
                            $stmt3 = $pdo->prepare($sql3);
                            $stmt3->execute();
                            $categories = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($categories as $category) {
                                $categoryId = $category['id'];
                                $categoryTitle = $category['category_title'];

                                $selected = ($categoryId == $row['category_id']) ? 'selected="selected"' : '';

                                echo '<option value="' . $categoryId . '" ' . $selected . '>' . $categoryTitle . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            // echo "Clicked";
            // 1. Get All The Values From Our Form
            $id = $_POST['id'];
            $title_en = $_POST['title_en'];
            $title_nl = $_POST['title_nl'];
            $description_en = $_POST['description_en'];
            $description_nl = $_POST['description_nl'];
            $price = $_POST['price'];
            $category = $_POST['category'];

            // 2. Update The Database
            $sql2 = "UPDATE tb_food SET 
                        title_en = :title_en, 
                        title_nl = :title_nl, 
                        description_en = :description_en,
                        description_nl = :description_nl,
                        price = :price, 
                        category_id = :category
                        WHERE id = :id";

            $stmt2 = $pdo->prepare($sql2);
            $stmt2->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt2->bindParam(':title_en', $title_en, PDO::PARAM_STR);
            $stmt2->bindParam(':title_nl', $title_nl, PDO::PARAM_STR);
            $stmt2->bindParam(':description_en', $description_en, PDO::PARAM_STR);
            $stmt2->bindParam(':description_nl', $description_nl, PDO::PARAM_STR);
            $stmt2->bindParam(':category', $category, PDO::PARAM_INT);
            $stmt2->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt2->execute();


            // 3. Redirect To Manege food With Message
            // Check Whether Executed Or Not
            if ($stmt2 !== false) {
                // food Updated
                $_SESSION['update'] = "<div class='success'>food Updated Successfully.</div>";
                header('location:food.php');
                exit;
            } else {
                // Failed To Update food
                $_SESSION['update'] = "<div class='error'>Failed To Update food.</div>";
                header('location:update-food.php');
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