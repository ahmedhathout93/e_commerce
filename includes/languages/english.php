<?php

function lang($phrase)
{
    static $lang = array(

        // Dashboard - navbar

        'HOME'         =>     'Home',
        'CATEGORIES'     =>     'Categories',
        'ADMIN_NAME'     =>     'Ahmed',
        'EDIT'           =>     'Edit profile',
        'SETTINGS'       =>     'Settings',
        'LOGOUT'         =>     'Logout',
        'ITEMS'          =>     'Items',
        'COMMENTS'       =>     'Comments',
        'MEMBERS'        =>     'Members',
        'STATISTICS'     =>     'Statistics',
        'LOGS'           =>     'Logs',

        // landing
    );
    return $lang[$phrase];
}
