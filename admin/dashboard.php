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
                    <i class="fa fa-users"></i>
                    <div class="info">
                        Total members
                        <span><a href="members.php"><?php echo countItems('UserID', 'users') ?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-pending">
                    <i class="fa fa-user-plus"></i>
                    <div class="info">
                        Pending members
                        <span><a href="members.php?do=Manage&page=pending"><?php echo checkItem('RegStatus', 'users', 0) ?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-items">
                    <i class="fa fa-tag"></i>
                    <div class="info">
                        Total items
                        <span><a href="items.php"><?php echo countItems('item_ID', 'items') ?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-comments">
                    <i class="fa fa-comments"></i>
                    <div class="info">
                        Total comments
                        <span><a href="comments.php"><?php echo countItems('c_id', 'comments') ?></a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container latest">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <?php $user_num = 5 ?>
                    <div class="panel-heading">
                        <i class="fa fa-users"></i> Latest <?php echo $user_num ?> registered users
                        <span class="toggle-info float-end">
                            <i class="fa fa-minus fa-lg"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled latest-users">
                            <?php
                            $latest_users = getLatest('*', 'users', 'UserID', $user_num);
                            foreach ($latest_users as $latestItem) {
                                echo '<li>';
                                echo $latestItem['Username'];
                                echo '<a href="members.php?do=Edit&userid=';
                                echo $latestItem['UserID'] . '"';
                                echo '<span class = "btn btn-success float-end">';
                                echo '<i class="fa fa-edit"></i>Edit';
                                if ($latestItem['RegStatus'] == 0) {
                                    echo '<a href="members.php?do=approve&userid=' . $latestItem["UserID"] . '" class="btn btn-info latest-approve float-end "><i class="fa fa-check "></i>Approve</a>';
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
                        <?php $item_num = 5; ?>
                        <i class="fa fa-tag"></i> Latest <?php echo $user_num ?> items
                        <span class="toggle-info float-end">
                            <i class="fa fa-minus fa-lg"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled latest-users">
                            <?php
                            $latest_items = getLatest('*', 'items', 'item_ID', $item_num);
                            foreach ($latest_items as $latestItem) {
                                echo '<li>';
                                echo $latestItem['Name'];
                                echo '<a href="items.php?do=edit&itemid=';
                                echo $latestItem['item_ID'] . '"';
                                echo '<span class = "btn btn-success float-end">';
                                echo '<i class="fa fa-edit"></i>Edit';
                                if ($latestItem['Approve'] == 0) {
                                    echo '<a href="items.php?do=approve&itemid=' . $latestItem["item_ID"] . '" class="btn btn-info latest-approve float-end "><i class="fa fa-check "></i>Approve</a>';
                                }
                                echo '</span></li>';
                                echo '</a>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- start latest comments -->
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <?php $com_num = 5 ?>
                    <div class="panel-heading">
                        <i class="fa fa-comments"></i> Latest <?php echo $com_num ?> comments
                        <span class="toggle-info float-end">
                            <i class="fa fa-minus fa-lg"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <?php
                        $stmt = $con->prepare("SELECT comments.* , users.Username FROM comments 
                            INNER JOIN users ON users.UserID = comments.user_id ");
                        $stmt->execute();
                        $comments = $stmt->fetchAll();
                        if (!empty($comments)) {
                            foreach ($comments as $comment) {
                                echo '<div class="comment-box">';
                                echo '<span class="member-n">
                                            <a href="members.php?do=Edit&userid=' . $comment['user_id'] . '">
                                                ' . $comment['Username'] . '</a></span>';
                                echo '<p class="member-c">' . $comment['comment'] . '</p>';
                                echo '</div>';
                            }
                        } else {
                            echo 'There\'s No Comments To Show';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end latest comments  -->
    </div>
<?php



    include $tpl . 'footer.php';
} else {
    header('Location:index.php');
    exit();
}
