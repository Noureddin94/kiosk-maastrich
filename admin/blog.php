<?php
// Initialize the session
ob_start();
session_start();
$pageTitle = 'Blog';

// Include config file
include_once 'init.php';

?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage-Blog</h1>
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
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
            header("Refresh:2");
        }
        if (isset($_SESSION['no-blog-found'])) {
            echo $_SESSION['no-blog-found'];
            unset($_SESSION['no-blog-found']);
            header("Refresh:2");
        }
        if (isset($_SESSION['failed-remove'])) {
            echo $_SESSION['failed-remove'];
            unset($_SESSION['failed-remove']);
            header("Refresh:2");
        }
        ?>
        <br /><br /><br />
        <a href="add-blog.php" class="btn-primary">Add Blog</a>

        <br /><br /><br />
        <table class="tbl-full">

            <tr>
                <th>S.N.</th>
                <th>Images</th>
                <th>Video's</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
            <?php

            // Query To Get All Category From Database
            $sql = "SELECT * FROM tb_blog ORDER BY id ASC";

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
                    $image_name = $row['image_name'];
                    $video_name = $row['video_name'];
                    $active = $row['active'];
            ?>
                    <tr>
                        <td><?php echo $sn++; ?>. </td>
                        <td>
                            <?php
                            // Check Whether We Have Image Or Not 
                            if ($image_name == "") {
                                // We Do Not Have Image, Display Error Message
                                echo "<div class='error'>Image Not Adedd.</div>";
                            } else {
                                // We Have Image, Display Image
                            ?>
                                <img src="../layout/images/blog/<?php echo $image_name; ?>" width="100px">
                            <?php
                            }

                            ?>
                        </td>
                        <td>
                            <?php
                            // Check Whether We Have Video Or Not 
                            if ($video_name == "") {
                                // We Do Not Have Video, Display Error Message
                                echo "<div class='error'>Video Not Adedd.</div>";
                            } else {
                                // We Have Video, Display Video
                            ?>
                                <video src="../layout/videos/video/<?php echo $video_name; ?>" width="100px"></video>
                            <?php
                            }
                            ?>
                        </td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="update-blog.php?id=<?php echo $id; ?>" class="btn-secondary">Update Blog</a>
                            <a href="delete-blog.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>&video_name=<?php echo $video_name; ?>" class="btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
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
                        <div class="error">No Blog Added.</div>
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