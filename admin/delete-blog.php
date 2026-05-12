<?php
ob_start();
session_start();
$pageTitle = 'Delete-Blog';
include 'init.php';

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

if (isset($_GET['id']) && isset($_GET['image_name']) && isset($_GET['video_name'])) {
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];
    $video_name = $_GET['video_name'];

    if ($image_name != "") {
        $path = "../layout/images/blog/" . $image_name;
        if (file_exists($path)) {
            $remove = unlink($path);
            if ($remove == false) {
                $_SESSION['remove'] = "<div class='error'>Failed To Remove Image.</div>";
                header('Location:blog.php');
                exit;
            }
        }
    }
    if ($video_name != "") {
        $path = "../layout/videos/video/" . $video_name;
        if (file_exists($path)) {
            $remove = unlink($path);
            if ($remove == false) {
                $_SESSION['remove'] = "<div class='error'>Failed To Remove Video.</div>";
                header('Location:blog.php');
                exit;
            }
        }
    }

    $sql = "DELETE FROM tb_blog WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION['delete'] = "<div class='success'>Blog Deleted Successfully.</div>";
        header('Location:blog.php');
        exit;
    } else {
        $_SESSION['delete'] = "<div class='error'>Failed To Delete The Blog.</div>";
        header('Location:blog.php');
        exit;
    }
} else {
    header('Location:blog.php');
    exit;
}

include $tpl . 'footer.php';
ob_end_flush();
