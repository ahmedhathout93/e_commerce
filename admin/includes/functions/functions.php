<?php

// title function that echo page title ($pageTitle) or default ;

function getTitle(){
    global $pageTitle ;
    if(isset($pageTitle)){
        echo $pageTitle;
    }
    else {
        echo 'Default';
    }
}