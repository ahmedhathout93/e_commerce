<?php

session_start();

if (isset($_SESSION['Username'])) {
    $pageTitle = 'Dashboard';
    include "init.php";
?>

    <div class="container text-center home-stats">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="stat st-members">
                    Total members
                    <span><a href="members.php"><?php echo countItems('UserID', 'users') ?></a></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-pending">
                    Pending members
                    <span><a href="members.php?do=Manage&page=pending"><?php echo checkItem('RegStatus', 'users', 0) ?></a></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-items">
                    Total items
                    <span><a href="items.php"><?php echo countItems('item_ID', 'items') ?></a></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-comments">
                    Total comments
                    <span>1000</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container latest">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <?php $latestusers = 5 ?>
                    <div class="panel-heading">
                        <i class="fa fa-users"></i> Latest <?php $latestusers ?> registered users
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled latest-users">
                            <?php
                            $theLatestUsers = getLatest('*', 'users', 'UserID', $latestusers);
                            foreach ($theLatestUsers as $latestUser) {
                                echo '<li>';
                                echo $latestUser['Username'];
                                echo '<a href="members.php?do=Edit&userid=';
                                echo $latestUser['UserID'] . '"';
                                echo '<span class = "btn btn-success float-end">';
                                echo '<i class="fa fa-edit"></i>Edit';
                                if ($latestUser['RegStatus'] == 0) {
                                    echo '<a href="members.php?do=approve&userid=' . $latestUser["UserID"] . '" class="btn btn-info latest-approve float-end "><i class="fa fa-check "></i>Approve</a>';
                                }
                                echo '</span></li>';
                                echo '</a>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-tag"></i> Latest items
                    </div>
                    <div class="panel-body">
                        Test
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php



    include $tpl . 'footer.php';
} else {
    header('Location:index.php');
    exit();
}
