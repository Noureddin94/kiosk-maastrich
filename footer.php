<!-- New footer style -->
<footer class="bg-success-footer text-dark pt-5 pb-4">
    <div class="container text-center text-md-left" data-aos="fade-up" data-aos-duration="1000" data-aos-offset="200" data-aos-delay="500">
        <div class="table-responsivee col-xs-6 col-m-6 col-lg-12 col-xl-6">
            <table class="table caption-top table-success table-striped table-hover">
                <caption class="p-3 text-white text-center fs-2 text-uppercase"><?php echo $lang['sub 4'] ?></caption>
                <tbody class="fs-4">
                    <tr>
                        <td>
                            <li class="fas fa-home mr-3"></li> STADSPARK MAASTRICHT
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <i class="fas fa-map"></i> MAASBOULEVARD 100
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <li class="fas fa-phone mr-3"></li>+31&#40;0&#41;615900219
                        </td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-calendar-alt"></i> <?php echo $lang['days-from'] ?> <?php echo $lang['between'] ?> <?php echo $lang['days-to'] ?></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-clock"></i> 10.00 - 19.00 <?php echo $lang['time-h'] ?></td>
                    </tr>
                    <tr>
                        <td>
                            <i class="fa-regular fa-eyes fa-flip-horizontal"></i>
                            <?php
                            // Get visitor's IP ADDRESESS
                            $ipAddress = $_SERVER['REMOTE_ADDR'];
                            // echo "My ip addres is: " . $ipAddress;
                            // Check if the IP address already exists in the database
                            $query1 = "SELECT IP FROM tb_counter WHERE IP = :ipAddress";
                            $check = $pdo->prepare($query1);
                            $check->bindParam(':ipAddress', $ipAddress);
                            $check->execute();
                            $checkIP = $check->rowCount();

                            if ($checkIP == 0) {
                                // Insert the IP address into the tb_counter table
                                $query2 = "INSERT INTO tb_counter(IP) VALUES(:ipAddress)";
                                $insertIP = $pdo->prepare($query2);
                                $insertIP->bindParam(':ipAddress', $ipAddress);
                                $insertIP->execute();
                            }

                            // Count the total number of visitors
                            $number = $pdo->prepare("SELECT IP FROM tb_counter");
                            $number->execute();
                            $visitor = $number->rowCount();

                            echo $lang['views'] . ': ' . $visitor;
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr class="mb-4">
        <div class="row align-items-center col-xs-6 col-m-6 col-lg-12 col-xl-6 ">
            <div class="col-md-7 col-lg-8">
                <p><?php echo $lang['copy-right'] ?>
                    <a href="https://m.pge.link/nourk94/1" target="_blank" style="text-decoration: none;">
                        <strong class="text-warning">Nour Keswani</strong>
                    </a>
                </p>
            </div>
            <div class="col-md-5 col-lg-4">
                <div class="text-center text-md-right">
                    <ul class="list-unstyled list-inline sci">
                        <li class="list-inline-item">
                            <a href="https://m.facebook.com/Kiosk-Stadspark-105733842099443/" class="btn-floatin btn-sm text-white ff" style="font-size: 23px">
                                <i class="fab fa-facebook"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="btn-floatin btn-sm text-white tt" style="font-size: 23px">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://www.instagram.com/kiosk_stadspark/" class="btn-floatin btn-sm text-white ii" style="font-size: 23px">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="tel:+31615900219" class="btn-floatin btn-sm text-white ww" style="font-size: 23px">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- animation.js -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<!-- jQuery.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<!-- owl-Carousel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- main.js -->
<script src="<?php echo $js ?>main.min.js"></script>
</body>

</html>