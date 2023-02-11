<?php

// Manage members page (Add - Edit - Delete) members .

session_start();

if (isset($_SESSION['Username'])) {

    $pageTitle = 'Members';

    include "init.php";


    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {
        echo 'welcome to manage page';
    } elseif ($do == 'Edit') {
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        $stmt = $con->prepare("select * from users where UserID = ?  LIMIT 1");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowcount();
        if ($count > 0) {
?>
            <h1 class="text-center">Edit Member</h1>
            <div class="container">
                <form class="form-group row " action="?do=update" method="POST">
                    <input type="hidden" name="userid" value="<?php echo $userid ?>" />
                    <!-- start username field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">Username</label>
                        <div class="col-sm-5">
                            <input type="text" name="username" class="form-control " value="<?php echo $row['Username'] ?>" autocomplete="off" required='required' />
                        </div>
                    </div>
                    <!-- end username field -->
                    <!-- start password field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">Password</label>
                        <div class="col-sm-5">
                            <input type="hidden" name="oldpass" value="<?php echo $row['Password'] ?>" />
                            <input type="password" name="newpass" class="form-control" placeholder="Old password" />
                        </div>
                    </div>
                    <!-- end password field -->
                    <!-- start email field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">Email</label>
                        <div class="col-sm-5">
                            <input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control" required />
                        </div>
                    </div>
                    <!-- end email field -->
                    <!-- start fullname field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">Full Name</label>
                        <div class="col-sm-5">
                            <input type="text" name="full" value="<?php echo $row['FullName'] ?>" class="form-control" required />
                        </div>
                    </div>
                    <!-- end fullname field -->
                    <!-- start save field -->
                    <div class="savediv">
                        <div class="save">
                            <input type="submit" value="Save" class="save" />
                        </div>
                    </div>
                    <!-- end save field -->

                </form>
            </div>
<?php
        } else echo 'there is no such userid';
    }
    // update page

    elseif ($do = 'update') {
        echo "<h1 class='text-center'>Update member</h1>";
        echo '<div class = "container">';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //get variables from form

            $id     = $_POST['userid'];
            $name   = $_POST['username'];
            $full   = $_POST['full'];
            $email  = $_POST['email'];

            // password update
            $pass = '';
            if (empty($_POST['newpass'])) {
                $pass = $_POST['oldpass'];
            } else {
                $pass = sha1($_POST['newpass']);
            }
            // form errors and validation
            $formErrors = array();
            if (strlen($name) < 3) {
                $formErrors[] = 'Username field can\'t be less than 3 characters ';
            }
            if (strlen($name) > 20) {
                $formErrors[] = 'Username field can\'t be more than 20 characters ';
            }
            if (empty($name)) {
                $formErrors[] = 'Username field can\'t be empty ';
            }
            if (empty($email)) {
                $formErrors[] = 'Email field can\'t be empty ';
            }
            foreach ($formErrors as $error) {
                echo '<div class = " alert alert-danger">' . $error . '</div>';
            }
            // prevent updating database if form has error
            if (empty($formErrors)) {
                // update database with edites
                $stmt = $con->prepare("UPDATE users SET Username = ? , Email = ? , FullName = ? , Password = ? WHERE UserID = ?");
                $stmt->execute(array($name, $email, $full, $pass,  $id));
                // print success message 
                echo '<div class = "alert alert-success">' . $stmt->rowCount() . " record is updated successfully</div>";
            }
        } else {
            echo "sorry you can't access this page directly";
        }
        echo '</div>';
    }
    include $tpl . 'footer.php';
} else {
    header('Location:index.php');
    exit();
}
