<?php
include "init.php";
include $tpl . "header.php";
include $lan . "english.php"

?>

<form class="login">
    <h4 class="text-center">Admin Login</h4>
    <input class="form-control" type="text" name="user" placeholder="username" autocomplete="off" />
    <input class="form-control" type="password" name="pass" placeholder="password" autocomplete="new-password" />
    <input class="btn btn-primary btn-block" type="submit" value="Login"/>
</form>


<?php
include $tpl ."footer.php";
?>