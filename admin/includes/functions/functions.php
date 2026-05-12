<?php
// to show the title on the page
function getTitle()
{
    global $pageTitle;

    if (isset($pageTitle)) {

        echo $pageTitle;
    } else {
        echo 'Default';
    }
}
