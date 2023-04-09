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


// show categories function

function getCat()
{
    global $con;
    $getCat = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");
    $getCat->execute();
    $cats = $getCat->fetchAll();
    return $cats;
}

// show items function

function getItems($catID)
{
    global $con;
    $getItems = $con->prepare("SELECT * FROM items WHERE Cat_ID = ? ORDER BY item_ID DESC");
    $getItems->execute(array($catID));
    $items = $getItems->fetchAll();
    return $items;
}
// check user status

function checkUserStatus($user)
{
    global $con;
    $stmtx = $con->prepare("SELECT Username , RegStatus from users where username = ? AND RegStatus = 0 ");
    $stmtx->execute(array($user));
    $status = $stmtx->rowcount();
    return $status;
}
