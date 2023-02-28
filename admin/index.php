<?php
session_start();
if (isset($_SESSION['Username'])) {
    header('Location:dashboard.php'); // no need to sign in again if session still exist 
}
$pageTitle = 'Login';
$noNavBar = ' '; // exclude nav bar from index page

include "init.php";


// check if user coming from http post request

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashedpass = sha1($password);

    // check user exists in database
    $stmt = $con->prepare("select UserID , Username , Password from users where username = ? and password = ? and GroupID = 1 LIMIT 1");
    $stmt->execute(array($username, $hashedpass));
    $count = $stmt->rowcount();
    $row = $stmt->fetch();

    // if count > 0 this mean the database contain record about this username 
    if ($count > 0) {
        $_SESSION['Username'] = $username; // register session name 
        $_SESSION['ID'] = $row['UserID']; // register User id 
        header('Location:dashboard.php'); // redirect to dashboard page
        exit();
    }
}

?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <h4 class="text-center">Admin Login</h4>
    <input class="form-control" type="text" name="user" placeholder="username" autocomplete="off" />
    <input class="form-control" type="password" name="pass" placeholder="password" autocomplete="new-password" />
    <input class="btn btn-primary btn-block" type="submit" value="Login" />
</form>


<?php
include $tpl . "footer.php";
?>