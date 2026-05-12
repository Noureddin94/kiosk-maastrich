<?php
// Initialize the session
ob_start();
session_start();
$pageTitle = 'Update-Blog';

// Include config file
include_once 'init.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];


    // Create a prepared statement with a parameter
    $sql = "SELECT * FROM tb_blog WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Check whether the id is valid or not
    if ($stmt->rowCount()) {
        // Get The Data (fetch single row)
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $current_image = $row['image_name'];
        $current_video = $row['video_name'];
        $active = $row['active'];
    } else {
        // Redirect To manage Blog With session message
        $_SESSION['no-blog-found'] = "<div class='error'>Blog Not Found.</div>";
        header('location:blog.php');
        exit;
    }
} else {
    // Redirect To Manage Blog
    header('location:blog.php');
    exit;
}

?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Blog</h1>
        <br><br>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Curent Image: </td>
                    <td>
                        <?php
                        if ($current_image == "") {
                            // Image Not Available
                            echo "<div class='error'>Image Not Available.</div>";
                        } else {
                            // Image Available
                        ?>
                            <img src="../layout/images/blog/<?php echo $current_image; ?>" width="150px">
                        <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Current Video: </td>
                    <td>
                        <?php
                        if ($current_video == "") {
                            // Video Not Available
                            echo "<div class='error'>Video Not Available.</div>";
                        } else {
                            // Video Available
                        ?>
                            <video src="../layout/videos/video/<?php echo $current_video; ?>" width="320" height="240" controls></video>
                        <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New Video: </td>
                    <td>
                        <input type="file" name="video">
                    </td>
                </tr>
                <tr>
                    <td>Active</td>
                    <td>
                        <input type="radio" name="active" value="Yes" <?php if ($active == 'Yes') echo 'checked'; ?>> Yes
                        <input type="radio" name="active" value="No" <?php if ($active == 'No') echo 'checked'; ?>> No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo "$current_image"; ?>">
                        <input type="hidden" name="current_video" value="<?php echo "$current_video"; ?>">

                        <input type="submit" name="submit" value="Update Blog" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php

if (isset($_POST['submit'])) {
    // 1. Get All The Detalis From The Form 
    $id = $_POST['id'];
    $active = $_POST['active'];
    $current_image = $_POST['current_image'];
    $current_video = $_POST['current_video'];

    // 2. Upload The Image If Selected
    if (isset($_FILES['image']['name'])) {
        // Upload Button Clicked
        $image_name = $_FILES['image']['name']; // New Image Name
        // Check Whether The File Is Available Or Not
        if ($image_name != "") {
            // Image Is Available
            // A. Upload New Image
            // Rename The Image
            $ext = end(explode('.', $image_name)); // Get The Extension Of The Image
            $image_name = "Blog-Name-" . rand(0000, 9999) . '.' . $ext; // This Will Rename Image
            // Get The Source Path And Destination Path
            $src_path = $_FILES['image']['tmp_name']; // Source Path
            $dest_path = "../layout/images/blog/" . $image_name; // Destination Path

            // Upload The Image
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $_FILES['image']['tmp_name']);
            finfo_close($finfo);
            $mime_type = mime_content_type($_FILES['image']['tmp_name']);
            $valid_mime_types = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/avif'];
            if (!in_array($mime_type, $valid_mime_types)) {
                // Invalid file type
                $_SESSION['upload'] = "<div class='error'>Invalid image format. Only jpg, jpeg, gif, webb, avif and png are allowed.</div>";
                header('location:add-blog.php');
                // Stop The Process
                die();
            }
            // Finally Upload The Food Image
            $upload = move_uploaded_file($src_path, $dest_path);
            // Check Whether Image Uploaded Or Not
            if ($upload == false) {
                // Failed To Upload The Image
                // Redirect To Add Blog Page With Error Message
                $_SESSION['upload'] = "<div class='error'>Failed To Upload Image</div>";
                header('location:add-blog.php');
                // Stop The Process
                die();
            }
            // 3. Remove The Image If New Image Is Uploaded And Current Image Exists
            // B. Remove Current Image If Available
            if ($current_image != "") {
                // Current Image Is Available
                // Remove The Image
                $remove_path = "../layout/images/blog/" . $current_image;
                $remove = unlink($remove_path);

                // Check Whether The Image Is Removed Or Not
                if ($remove == false) {
                    // Failed To Remove Current Image 
                    $_SESSION['remove-failed'] = "<div class='error'>Failed To Remove Current Image.</div>";
                    // redirect To Manege Food 
                    header('location:update-blog.php');
                    // Stop The Process
                    die();
                }
            }
        } else {
            $image_name = $current_image; // Default Image When Image Not Selected
        }
    } else {
        $image_name = $current_image; // Default Image When Button Is Not Clicked
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
            // Get The Extension Of Selected video (jpg, png, gif, etc.) "Nour-keswani.jpg"
            $ext = end(explode('.', $video_name));
            // Create New Name For video
            $video_name = "Video-Name" . rand(0000, 9999) . "." . $ext; // New video Name May Be "Blog-Name-568.jpg" 

            // B. Upload The video
            // Get The Src Path And Destination Path
            // Source Path Is The Current Location Of The video
            $src = $_FILES['video']['tmp_name'];
            // Destination Path For The video To Be Uploaded
            $dst = "../layout/videos/video/" . $video_name;

            // Upload the Video
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $_FILES['video']['tmp_name']);
            finfo_close($finfo);
            // Check the MIME type of the file
            $fileMimeType = mime_content_type($src);
            $allowedMimeTypes = ['video/mp4', 'video/webm', 'video/avi', 'video/flv'];
            // Check if the file MIME type is allowed
            if (!in_array($fileMimeType, $allowedMimeTypes)) {
                // Invalid file type
                $_SESSION['upload'] = "<div class='error'>Invalid video format. Only mp4, webm, avi, and flv are allowed.</div>";
                header('location:add-blog.php');
                // Stop The Process
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
            // 3. Remove The Video If New Video Is Uploaded And Current Video Exists
            // B. Remove Current Video If Available
            if ($current_video != "") {
                // Current video Is Available
                // Remove The video
                $remove_path = "../layout/videos/video/" . $current_video;
                $remove = unlink($remove_path);

                // Check Whether The Video Is Removed Or Not
                if ($remove == false) {
                    // Failed To Remove Current Video 
                    $_SESSION['remove-failed'] = "<div class='error'>Failed To Remove Current Video.</div>";
                    // redirect To Manege Food 
                    header('location:update-blog.php');
                    // Stop The Process
                    die();
                }
            }
        } else {
            $video_name = $current_video; // Default video When video Not Selected
        }
    } else {
        $video_name = $current_video; // Default video When Button Is Not Clicked
    }

    // 4. Update The Food In Database
    $sql2 = "UPDATE tb_blog SET active = :active, image_name = :image_name, video_name = :video_name WHERE id = :id";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt2->bindParam(':active', $active, PDO::PARAM_STR);
    $stmt2->bindParam(':image_name', $image_name, PDO::PARAM_STR);
    $stmt2->bindParam(':video_name', $video_name, PDO::PARAM_STR);
    $stmt2->execute();

    // Check Whether Executed Or Not
    if ($stmt2->rowCount()) {
        // Blog Updated
        $_SESSION['update'] = "<div class='success'>Blog Updated Successfully.</div>";
        header('location:blog.php');
        exit;
    } else {
        // Failed To Update Blog
        $_SESSION['update'] = "<div class='error'>Failed To Update Blog.</div>";
        header('location:update-blog.php?id=' . $id);
        exit;
    }
}

include $tpl . 'footer.php';
ob_end_flush();
