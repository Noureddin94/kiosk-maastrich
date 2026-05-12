<?php
// Initialize the session
ob_start();
session_start();
$pageTitle = 'Add-Food';

// Include config file
include_once 'init.php';

?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add-Food</h1>
        <?PHP
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
            header("Refresh:4");
        }
        ?>
        <br /><br />
        <!-- Add Food Form Start -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title-EN: </td>
                    <td>
                        <input type="text" name="title_en" placeholder="Food Title">
                    </td>
                </tr>
                <tr>
                    <td>Title-NL: </td>
                    <td>
                        <input type="text" name="title_nl" placeholder="Food Title">
                    </td>
                </tr>
                <tr>
                    <td>Description-EN: </td>
                    <td>
                        <textarea type="text" name="description_en" cols="30" rows="5" placeholder="Food Description"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Description-NL: </td>
                    <td>
                        <textarea type="text" name="description_nl" cols="30" rows="5" placeholder="Food Description"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="text" name="price" placeholder="Food Price">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select id="category" name="category">
                            <?php
                            $sql = 'SELECT * FROM tb_category';
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();

                            if ($stmt->rowCount()) {
                                // I have category
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $id = $row['id'];
                                    $cat = $row['category_en'];
                            ?>
                                    <option value="<?php echo $id; ?>"><?php echo $cat; ?></option>
                            <?php
                                }
                            } else {
                                // I don't have any category
                                echo '<option value="0">No Category</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr class="pt-5">
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
        <!-- Add Food Form End -->

        <?php
        // Check Whether The Submit Button Is Clicked Or Not
        if (isset($_POST['submit'])) {
            // 1. Get The Value From Category Form
            $title_en = $_POST['title_en'];
            $title_nl = $_POST['title_nl'];
            $description_en = $_POST['description_en'];
            $description_nl = $_POST['description_nl'];
            $price = $_POST['price'];
            $category = $_POST['category'];

            // Validate input fields
    if (empty($title_en) || empty($title_nl) || empty($price)) {
        $_SESSION['add'] = "<div class='error'>Please fill in at least the title and the price.</div>";
        header('location:add-food.php');
        exit;
    }

            // 2. Insert The Value In Database
            $sql2 = "INSERT INTO tb_food SET
                title_en = '$title_en',
                title_nl = '$title_nl',
                description_en = '$description_en',
                description_nl = '$description_nl',
                price = '$price',
                category_id = '$category'
                ";

            // 3. Execute The Query And Save In Database
            $stmt2 = $pdo->exec($sql2);

            // 4. Check Whether The Query Executed Or Not And Data Added Or Not
            if ($stmt2 !== false) {
                // Query Execute And Category Added
                $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                // Redirect To Manege Category Page
                header('location:food.php');
                exit;
            } else {
                // Failed To Add Category
                $_SESSION['add'] = "<div class='error'>Failed To Add Food.</div>";
                // Redirect To Manege Category Page
                header('location:add-food.php');
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