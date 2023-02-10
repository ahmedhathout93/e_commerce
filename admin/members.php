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
                <form class="form-group row ">
                    <!-- start username field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">Username</label>
                        <div class="col-sm-5">
                            <input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>" autocomplete="off" />
                        </div>
                    </div>
                    <!-- end username field -->
                    <!-- start password field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">Password</label>
                        <div class="col-sm-5">
                            <input type="password" name="pass" class="form-control" />
                        </div>
                    </div>
                    <!-- end password field -->
                    <!-- start email field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">Email</label>
                        <div class="col-sm-5">
                            <input type="email" name="email" value="<?php echo $row['Email'] ?>"class="form-control" />
                        </div>
                    </div>
                    <!-- end email field -->
                    <!-- start fullname field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">Full Name</label>
                        <div class="col-sm-5">
                            <input type="text" name="full" value="<?php echo $row['FullName'] ?>" class="form-control" />
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
    include $tpl . 'footer.php';
} else {
    header('Location:index.php');
    exit();
}
