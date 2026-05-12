<!-- Start Blog Section -->
<section class="blog" id="blog">
    <h1 class="heading"> <span>Blog</span></h1>
    <div class="row bg-success-blog containers">
        <div class="owl-carousel owl-theme image-containers" data-aos="fade-left" data-aos-duration="1000" data-aos-offset="200" data-aos-delay="500">
            <?php
            $blog = 'SELECT * FROM tb_blog WHERE active = "No"';
            $stmt = $pdo->prepare($blog);
            $stmt->execute();

            if ($stmt->rowCount()) {
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($rows as $row) {
                    $image_name = $row['image_name'];
                    $video_name = $row['video_name'];

                    // Check if the image file exists
                    $image_path = 'layout/images/blog/' . $image_name;
                    if (!empty($image_name) && file_exists($image_path)) {
                        echo '<div class="item custom1 shadow p-3 mb-5 bg-body rounded">';
                        echo '<img src="' . $image_path . '" alt="blog-1" />';
                        echo '</div>';
                    }

                    // Check if the video file exists
                    $video_path = 'layout/videos/video/' . $video_name;
                    if (!empty($video_name) && file_exists($video_path)) {
                        echo '<div class="item custom1 shadow p-3 mb-5 bg-body rounded">';
                        echo '<video style="width:100%" src="' . $video_path . '" type="video/mp4" controls autoplay muted></video>';
                        echo '</div>';
                    }
                }
            } else {
                echo '<div class="item custom1 shadow p-3 mb-5 bg-body rounded">';
                echo '<img src="' . $img . '4.png" alt="blog-2" />';
                echo '</div>';
            }
            ?>
        </div>
        <div class="popup-image">
            <span>&times;</span>
            <img src="<?php echo $img ?>4.webp" alt="">
        </div>
        <div class="popup-video">
            <span>&times;</span>
            <video src="<?php echo $vid ?>food_1.mp4" controls autoplay muted></video>
        </div>
    </div>
</section>
<!-- End-Blog-section -->