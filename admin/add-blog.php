<?php
error_reporting(E_ALL);
// Initialize the session
ob_start();
session_start();
$pageTitle = 'Add-Blog';

// Include config file
include_once 'init.php';
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add-Blog</h1>
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
            header("Refresh:4");
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
            header("Refresh:4");
        }
        ?>
        <br /><br />
        <!-- Add Blog Form Start -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Select Video: </td>
                    <td>
                        <input type="file" name="video">
                    </td>
                </tr>
                <tr>
                    <td>Active</td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr class="pt-5">
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Blog" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
        <!-- Add Food Form End -->

        <?php
        // Check Whether The Submit Button Is Clicked Or Not
        if (isset($_POST['submit'])) {
            // 1. Get The Value From Category Form
            if (isset($_POST['active'])) {
                $active = $_POST['active'];
            } else {
                $active = "No"; // Setting Default Value
            }

            // 2. Upload The Image If Selected
            // Check Whether The Select Image Is Clicked Or Not And Upload The Image Only If The Image Is Selected
            if (isset($_FILES['image']['name'])) {
                // Get The Details Of The Selected Image
                // print_r($_FILES['image']);
                // exit;
                $image_name = $_FILES['image']['name'];
                // Check Whether The Image Is Selected Or Not And Upload Image Only If Selected
                if ($image_name != "") {
                    // Image Is Selected
                    // A. Rename The Image
                    // Get The Extension Of Selected Image (jpg, png, gif, etc.) "Nour-keswani.jpg"
                    $ext = end(explode('.', $image_name));
                    // Create New Name For Image
                    $image_name = "Blog-Name" . rand(0000, 9999) . "." . $ext; // New Image Name May Be "Blog-Name-568.jpg" 
                    // B. Upload The Image
                    // Get The Src Path And Destination Path
                    // Source Path Is The Current Location Of The Image
                    $src = $_FILES['image']['tmp_name'];
                    // Destination Path For The Image To Be Uploaded
                    $dst = "../layout/images/blog/" . $image_name;
                    // Check The MIME type for the image
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime_type = finfo_file($finfo, $_FILES['image']['tmp_name']);
                    finfo_close($finfo);
                    $mime_type = mime_content_type($_FILES['image']['tmp_name']);
                    $valid_mime_types = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                    if (!in_array($mime_type, $valid_mime_types)) {
                        // Invalid file type
                        $_SESSION['upload'] = "<div class='error'>Invalid image format. Only jpg, jpeg, gif, and png are allowed.</div>";
                        header('location:add-blog.php');
                        // Stop The Process
                        die();
                    }
                    // Finally Upload The Food Image
                    $upload = move_uploaded_file($src, $dst);
                    // Check Whether Image Uploaded Or Not
                    if ($upload == false) {
                        // Failed To Upload The Image
                        // Redirect To Add Blog Page With Error Message
                        $_SESSION['upload'] = "<div class='error'>Failed To Upload Image</div>";
                        header('location:add-blog.php');
                        // Stop The Process
                        die();
                    }
                }
            } else {
                $image_name = ""; // Setting Default Value As Blank
            }
            // 2. Upload The Video If Selected
            // Check Whether The Select Video Is Clicked Or Not And Upload The Video Only If The Video Is Selected
            if (isset($_FILES['video']['name'])) {
                // Get The Details Of The Selected Video
                // echo "<pre>";
                // var_dump($_FILES['video']);
                // exit;
                $video_name = $_FILES['video']['name'];
                // Check Whether The video Is Selected Or Not And Upload video Only If Selected
                if ($video_name != "") {
                    // video Is Selected
                    // A. Rename The video
                    // Get The Extension Of Selected video (mp4, etc.) "Nour-keswani.jpg"
                    $ext = end(explode('.', $video_name));
                    // Create New Name For video
                    $video_name = "Video-Name" . rand(0000, 9999) . "." . $ext; // New video Name May Be "Blog-Name-568.jpg" 

                    // B. Upload The video
                    // Get The Src Path And Destination Path
                    // Source Path Is The Current Location Of The video
                    $src = $_FILES['video']['tmp_name'];
                    // Destination Path For The video To Be Uploaded
                    $dst = "../layout/videos/video/" . $video_name;
                    // Check the MIME type of the file
                    $allowedMimeTypes = ['video/mp4', 'video/webm', 'video/avi', 'video/flv'];
                    $fileMimeType = mime_content_type($src);
                    // Check if the file MIME type is allowed
                    if (!in_array($fileMimeType, $allowedMimeTypes)) {
                        // Invalid file type
                        $_SESSION['upload'] = "<div class='error'>Invalid video format. Only mp4, webm, avi, and flv are allowed.</div>";
                        header('location:add-blog.php');
                        // Stop The Process
                        die();
                    }

                    // Maximum allowed file size in bytes (1GB)
                    $maxFileSize = 1073741824;
                    // Check image file size
                    if ($_FILES['video']['size'] > $maxFileSize) {
                        $_SESSION['upload'] = "<div class='error'>Video file size exceeds the allowed limit.</div>";
                        header('location:add-blog.php');
                        die();
                    }
                    // Finally Upload The video
                    $upload = move_uploaded_file($src, $dst);
                    // Check Whether video Uploaded Or Not
                    if ($upload == false) {
                        // Failed To Upload The video
                        // Redirect To Add Blog Page With Error Message
                        $_SESSION['upload'] = "<div class='error'>Failed To Upload Video</div>";
                        header('location:add-blog.php');
                        // Stop The Process
                        die();
                    }
                }
            } else {
                $video_name = ""; // Setting Default Value As Blank
            }
            // Check if both image and video fields are empty
            if (empty($_FILES['image']['name']) && empty($_FILES['video']['name'])) {
                $_SESSION['upload'] = "<div class='error'><strong>Please select an image or a video</strong></div>";
                header('location:add-blog.php');
                die();
            }
            // 2. Insert The Value In Database
            $sql2 = "INSERT INTO tb_blog (image_name, video_name, active) 
            VALUES ('$image_name', '$video_name', '$active')";
            // 3. Execute The Query And Save In Database
            $stmt2 = $pdo->exec($sql2);

            // 4. Check Whether The Query Executed Or Not And Data Added Or Not
            if ($stmt2 !== false) {
                // Query Execute And Category Added
                $_SESSION['add'] = "<div class='success'>Blog Added Successfully.</div>";
                // Redirect To Manege Category Page
                header('location:blog.php');
                exit;
            } else {
                // Failed To Add Category
                $_SESSION['add'] = "<div class='error'>Failed To Add Blog.</div>";
                // Redirect To Manege Category Page
                header('location:add-blog.php');
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