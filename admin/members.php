<?php

// Manage members page (Add - Edit - Delete) members .

session_start();

if (isset($_SESSION['Username'])) {

    $pageTitle = 'Members';

    include "init.php";

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    //manage members page

    if ($do == 'Manage') {

        // fetch users info into members table

        $query = '';
        if (isset($_GET['page']) && $_GET['page'] == 'pending') {
            $query = 'AND RegStatus = 0';
        }

        $stmt = $con->prepare("SELECT * FROM users WHERE GroupID !=1 $query");
        $stmt->execute();
        $rows = $stmt->fetchAll();

?>
        <h1 class="text-center">Manage members</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table table table-bordered  text-center">
                    <thead>
                        <th>#ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Full Name</th>
                        <th>Registerd date</th>
                        <th>Control</th>
                    </thead>
                    <?php
                    foreach ($rows as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['UserID'] . "</td>";
                        echo "<td>" . $row['Username'] . "</td>";
                        echo "<td>" . $row['Email'] . "</td>";
                        echo "<td>" . $row['FullName'] . "</td>";
                        echo "<td>" . $row['Date'] . "</td>";
                        echo ' <td>  <a href="?do=Edit&userid=' . $row["UserID"] . '" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a> 
                        <a href="?do=delete&userid=' . $row["UserID"] . '" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a> ';
                        if ($row['RegStatus'] == 0) {
                            echo '<a href="?do=approve&userid=' . $row["UserID"] . '" class="btn btn-info"><i class="fa fa-check"></i>Approve</a>';
                        }
                        echo '</td>';
                        echo "</tr>";
                    } ?>
                </table>
            </div>
            <a href="members.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i>new member</a>
        </div>
    <?php  } elseif ($do == 'add') {

        //add new member page 

    ?>
        <h1 class="text-center">Add new member</h1>
        <div class="container">
            <form class="form-group row " action="?do=insert" method="POST">
                <!-- start username field -->
                <div class="form-group row form-control-lg">
                    <label class="col-sm-2 offset-2 control-label">Username</label>
                    <div class="col-sm-5">
                        <input type="text" name="username" class="form-control " autocomplete="off" required='required' placeholder="Login username" />
                        <span class="required"></span>
                    </div>
                </div>
                <!-- end username field -->
                <!-- start password field -->
                <div class="form-group row form-control-lg">
                    <label class="col-sm-2 offset-2 control-label">Password</label>
                    <div class="col-sm-5">
                        <input type="password" name="password" class="password form-control" placeholder="Login password should be complex" />
                        <i class="show-pass fa fa-eye" aria-hidden="true"></i>
                        <span class="required"></span>
                    </div>
                </div>
                <!-- end password field -->
                <!-- start email field -->
                <div class="form-group row form-control-lg">
                    <label class="col-sm-2 offset-2 control-label">Email</label>
                    <div class="col-sm-5">
                        <input type="email" name="email" class="form-control" required placeholder="Email must be valid" />
                        <span class="required"></span>
                    </div>
                </div>
                <!-- end email field -->
                <!-- start fullname field -->
                <div class="form-group row form-control-lg">
                    <label class="col-sm-2 offset-2 control-label">Full Name</label>
                    <div class="col-sm-5">
                        <input type="text" name="full" class="form-control" required placeholder="Appear in your profile page" />
                        <span class="required"></span>
                    </div>
                </div>
                <!-- end fullname field -->
                <!-- start save field -->
                <div class="savediv">
                    <div class="save">
                        <input type="submit" value="Add member" class="save btn btn-primary" />
                    </div>
                </div>
                <!-- end save field -->

            </form>
        </div>
        <?php } elseif ($do == 'insert') {

        // insert member page 

        echo "<h1 class='text-center'>Insert member</h1>";
        echo '<div class = "container">';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //get variables from form
            $name   = $_POST['username'];
            $pass   = $_POST['password'];
            $full   = $_POST['full'];
            $email  = $_POST['email'];

            $hashpass = sha1($pass);

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
            if (empty($pass)) {
                $formErrors[] = 'Password field can\'t be empty ';
            }
            foreach ($formErrors as $error) {
                echo '<div class = " alert alert-danger">' . $error . '</div>';
            }
            // prevent updating database if form has error
            if (empty($formErrors)) {

                // check is user exists
                $check =  checkItem("Username", "users", $name);
                if ($check == 1) {
                    echo '<div class="alert alert-danger">This user is already exists</div>';
                } else {

                    // insert userinfo in DB
                    $stmt = $con->prepare("INSERT INTO 
                                        users (Username , Password , Email , FullName , RegStatus , Date )
                                        VALUES(:zuser , :zpass , :zemail , :zname , 1 ,now())");
                    $stmt->execute(array(
                        'zuser'   => $name,
                        'zpass'   => $hashpass,
                        'zemail'  => $email,
                        'zname'   => $full
                    ));

                    // print success message 
                    echo '<div class="container">';
                    $theMsg =  '<div class = "alert alert-success">' . $stmt->rowCount() . " record is inserted successfully</div>";
                    redirectHome($theMsg, 'back');
                    echo '</div>';
                }
            }
            echo '</div>';
        } else {
            echo '<div class="container">';
            $theMsg = "<div class='alert alert-danger'>sorry you can't access this page directly</div>";
            redirectHome($theMsg);
            echo '</div>';
        }
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
                            <span class="required"></span>
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
                            <span class="required"></span>
                        </div>
                    </div>
                    <!-- end email field -->
                    <!-- start fullname field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">Full Name</label>
                        <div class="col-sm-5">
                            <input type="text" name="full" value="<?php echo $row['FullName'] ?>" class="form-control" required />
                            <span class="required"></span>
                        </div>
                    </div>
                    <!-- end fullname field -->
                    <!-- start save field -->
                    <div class="savediv">
                        <div class="save">
                            <input type="submit" value="Save" class="save btn btn-primary" />
                        </div>
                    </div>
                    <!-- end save field -->
                </form>
            </div>
<?php
        } else {
            echo '<div class="container">';
            $theMsg = "<div class='alert alert-danger'>there is no such userid</div>";
            redirectHome($theMsg, 'back');
            echo '</div>';
        }
    }
    // update member page

    elseif ($do == 'update') {
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
                echo '<div class="container">';
                $theMsg = '<div class = "alert alert-success">' . $stmt->rowCount() . " record is updated successfully</div>";
                redirectHome($theMsg, 'back');
                echo '</div>';
            }
        } else {
            echo '<div class="container">';
            $theMsg = "<div class='alert alert-danger'>sorry you can't access this page directly</div>";
            redirectHome($theMsg);
            echo '</div>';
        }
        echo '</div>';
    }

    // delete member page  

    elseif ($do == 'delete') {
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

        $check =  checkItem('UserID', 'users', $userid);
        if ($check > 0) {
            $stmt = $con->prepare('DELETE FROM users WHERE UserID =:zuser');
            $stmt->bindParam('zuser', $userid);
            $stmt->execute();
            echo '<div class="container">';
            $theMsg = '<div class = "alert alert-success">' . $stmt->rowCount() . " record is deleted successfully</div>";
            redirectHome($theMsg, 'back');
            echo '</div>';
        } else {
            echo '<div class="container">';
            $theMsg = "<div class='alert alert-danger'>This ID is not exist</div>";
            redirectHome($theMsg);
            echo '</div>';
        }
    } elseif ($do == 'approve') {
        echo "<h1 class='text-center'>Approve member</h1>";
        echo '<div class = "container">';

        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

        $check =  checkItem('UserID', 'users', $userid);
        if ($check > 0) {
            $stmt = $con->prepare('UPDATE users SET RegStatus=1   WHERE UserID = ?');
            $stmt->execute(array($userid));
            echo '<div class="container">';
            $theMsg = '<div class = "alert alert-success">' . $stmt->rowCount() . " Member is approved successfully</div>";
            redirectHome($theMsg, 'back');
            echo '</div>';
        } else {
            echo '<div class="container">';
            $theMsg = "<div class='alert alert-danger'>This ID is not exist</div>";
            redirectHome($theMsg);
            echo '</div>';
        }
        echo '</div>';
    }
    include $tpl . 'footer.php';
} else {
    header('Location:index.php');
    exit();
}
