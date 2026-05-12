<?php
// error_reporting(0);

require_once 'config/db.php';
define('SITEURL', 'kioskmaastricht.nl/');

// Routes
$lang  = '../languages/lang_config.php'; // Language Directory
$tpl   = 'includes/templates/'; // Template Directory
$func  = 'includes/functions/'; //Function Directory
$img   = 'layout/images/'; // Layout
$css   = 'layout/css/'; // Css Directory
$js    = 'layout/js/'; // Js Directory

// Include The Important /filles

require_once $tpl . 'check-login.php';
require_once $func . 'functions.php';
require_once $tpl . 'header.php';

// Require Navbar On All Pages Expect The $noNavbar Variable
if (!isset($noNavbar)) {
    require_once $tpl . 'navbar.php';
}
