<!-- Start-Slid-Show -->
<div id="carouselExampleSlidesOnly" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        $blog = 'SELECT * FROM tb_blog WHERE active = "Yes"';
        $stmt = $pdo->prepare($blog);
        $stmt->execute();

        if ($stmt->rowCount()) {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $firstImage = true; // Flag to track the first image
            foreach ($rows as $row) {
                $image_name = $row['image_name'];
                $video_name = $row['video_name'];
                $activeClass = $firstImage ? 'active' : ''; // Add "active" class only for the first image
                $firstImage = false; // Set the flag to false after the first image

                // Check if image exists
                $imagePath = $img . 'blog/' . $image_name;
                $hasImage = file_exists($imagePath);
                if (!empty($image_name) && $hasImage) {
        ?>
                    <div class="carousel-item <?php echo $activeClass; ?>" data-interval="3500">
                        <?php if ($hasImage) { ?>

                            <div class="overlay-image" style="background-image: url('<?php echo $imagePath; ?>')"></div>
                        <?php } ?>
                        <?php if ($hasImage && $activeClass) { ?>
                            <div class="container some__text">
                                <h1><?php echo $lang['slide1 h1'] ?></h1>
                            </div>
                        <?php } ?>
                    </div>
                    <?php
                }

                // Check if video exists
                $videoPath = $vid . 'video/' . $video_name;
                $hasVideo = file_exists($videoPath);
                if (!empty($video_name) && $hasVideo) {
                    if ($hasVideo) { ?>
                        <div class="carousel-item" data-interval="50000">
                            <video class="overlay-image" autoplay loop muted>
                                <source src="<?php echo $videoPath; ?>" type="video/mp4" />
                            </video>
                        </div>
            <?php
                    }
                }
            }
        } else {
            ?>
            <div class="carousel-item <?php echo $activeClass; ?>" data-interval="3500">
                <div class="overlay-image" style="background-image: url(layout/images/11.png)"></div>
            </div>
            <div class="carousel-item" data-interval="3500">
                <div class="overlay-image" style="background-image: url(layout/images/7.png)"></div>
            </div>
        <?php
        }
        ?>
    </div>
</div>
<!-- End-Slid-Show -->