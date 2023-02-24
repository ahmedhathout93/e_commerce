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

function redirectHome($theMSg, $url = null, $seconds = 3)
{
    if ($url == null) {
        $url = 'index.php';
        $link = 'Home Page';
    } else {
        if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
            $url = $_SERVER['HTTP_REFERER'];
            $link = 'Previous Page';
        } else {
            $url = 'index.php';
            $link = 'Home Page';
        }
    }
    echo $theMSg;
    echo "<div class = 'alert alert-info'>You will be redirected to $link after $seconds seconds</div>";
    header("refresh:$seconds;url=$url");
    exit();
}

// check item exist in database

function checkItem($select, $from, $value)
{
    global $con;
    $statement = $con->prepare("SELECT $select FROM $from WHERE $select=?");
    $statement->execute(array($value));
    $count = $statement->rowCount();
    return $count;
}
