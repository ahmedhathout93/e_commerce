<?php

function lang($phrase)
{
    static $lang = array(

        // homepage

        'message' => 'welcome',
        'admin' => 'adminstrator'

        // landing
    );
    return $lang[$phrase];
}

