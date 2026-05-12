<!-- Navbar Section Starts Here -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <div class="logo">
            <a href="#home" title="Kiosk-Logo">
                <img src="<?php echo $img ?>logo02.svg" alt="Restaurant Logo" class="navbar-brand rounded-circle">
            </a>
        </div>

        <button class="navbar-toggler" name="button" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
            <!-- <span class="navbar-toggler-icon"></span> -->
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav ms-auto text-right">
                <li class="nav-item">
                    <a class="nav-link" href="#home"><?php echo $lang['home'] ?>
                        <span class="sr-only"></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#menu">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#blog">Blog</a>
                </li>
                <li class="nav-item lang">
                    <a href="?lang=en">
                        <img src="<?php echo $img ?>en.webp" alt="en" class="lang_img">
                    </a>
                    <a href="?lang=nl">
                        <img src="<?php echo $img ?>nl.webp" alt="nl" class="lang_img">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Navbar Section Ends Here -->