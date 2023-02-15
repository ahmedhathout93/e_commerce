<?php

// title function that echo page title ($pageTitle) or default ;

function getTitle()
{
    global $pageTitle;
    if (isset($pageTitle)) {
        echo $pageTitle;
    } else {
        echo 'Default';
    }
}

// redirect function

function redirectHome($errmessage, $seconds = 3)
{
    echo "<div class = 'alert alert-danger'>.$errmessage.</div>";
    echo "<div class = 'alert alert-info'>You will be redirected to home page after $seconds seconds</div>";
    header("refresh:$seconds;url=index.php");
    exit();
}
