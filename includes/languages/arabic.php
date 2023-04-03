<?php

function lang($phrase)
{
    static $lang = array(
        'message' => 'أهلا يا ',
        'admin' => 'أدمن'
    );
    return $lang[$phrase];
}
echo lang('message')." ".lang('admin');