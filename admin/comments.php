<?php

// Manage members page ( Edit - Delete - Approve ) comments .

session_start();

if (isset($_SESSION['Username'])) {

    $pageTitle = 'Comments';

    include "init.php";

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    //manage comments page

    if ($do == 'Manage') {

        // fetch comments info into comments table
        $stmt = $con->prepare("SELECT comments.*  , items.Name AS item_Name , users.Username FROM comments
        INNER JOIN items ON items.item_ID = comments.item_id 
        INNER JOIN users ON users.UserID = comments.user_id");
        $stmt->execute();
        $rows = $stmt->fetchAll();
?>
        <h1 class="text-center">Manage comments</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table table table-bordered  text-center">
                    <thead>
                        <th>ID</th>
                        <th>Comment</th>
                        <th>Item Name</th>
                        <th>User Name</th>
                        <th>Added date</th>
                        <th>Control</th>
                    </thead>
                    <?php
                    foreach ($rows as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['c_id'] . "</td>";
                        echo "<td>" . $row['comment'] . "</td>";
                        echo "<td>" . $row['item_Name'] . "</td>";
                        echo "<td>" . $row['Username'] . "</td>";
                        echo "<td>" . $row['comment_date'] . "</td>";
                        echo ' <td>  <a href="?do=edit&comid=' . $row["c_id"] . '" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a> 
                        <a href="?do=delete&comid=' . $row["c_id"] . '" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a> ';
                        if ($row['status'] == 0) {
                            echo '<a href="?do=approve&comid=' . $row["c_id"] . '" class="btn btn-info"><i class="fa fa-check"></i>Approve</a>';
                        }
                        echo '</td>';
                        echo "</tr>";
                    } ?>
                </table>
            </div>
        </div>
        <?php  } elseif ($do == 'edit') {
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
        $stmt = $con->prepare("SELECT * FROM comments where c_id = ? ");
        $stmt->execute(array($comid));
        $row = $stmt->fetch();
        $count = $stmt->rowcount();
        if ($count > 0) {
        ?>
            <h1 class="text-center">Edit Comment</h1>
            <div class="container">
                <form class="form-group row " action="?do=update" method="POST">
                    <input type="hidden" name="cid" value="<?php echo $comid ?>" />
                    <!-- start comment field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">Comment</label>
                        <div class="col-sm-5">
                            <textarea name="comment" class="form-control" required> <?php echo $row['comment'] ?></textarea>
                            <span class="required"></span>
                        </div>
                    </div>
                    <!-- end comment field -->

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
            $theMsg = "<div class='alert alert-danger'>there is no such id</div>";
            redirectHome($theMsg, 'back');
            echo '</div>';
        }
    }
    // update comment page

    elseif ($do == 'update') {
        echo "<h1 class='text-center'>Update member</h1>";
        echo '<div class = "container">';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //get variables from form

            $id     = $_POST['cid'];
            $comment   = $_POST['comment'];

            // prevent updating database if form has error
            
                // update database with edites
                $stmt = $con->prepare("UPDATE comments SET comment = ?  WHERE c_id = ?");
                $stmt->execute(array($comment,  $id));
                // print success message 
                echo '<div class="container">';
                $theMsg = '<div class = "alert alert-success">' . $stmt->rowCount() . " comment is updated successfully</div>";
                redirectHome($theMsg, 'back');
                echo '</div>';
        } else {
            echo '<div class="container">';
            $theMsg = "<div class='alert alert-danger'>sorry you can't access this page directly</div>";
            redirectHome($theMsg);
            echo '</div>';
        }
        echo '</div>';
    }

    // delete comment page  

    elseif ($do == 'delete') {
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
        $check =  checkItem('c_id', 'comments', $comid);
        if ($check > 0) {
            $stmt = $con->prepare('DELETE FROM comments WHERE c_id =:zid');
            $stmt->bindParam('zid', $comid);
            $stmt->execute();
            echo '<div class="container">';
            $theMsg = '<div class = "alert alert-success">' . $stmt->rowCount() . " comment is deleted successfully</div>";
            redirectHome($theMsg, 'back');
            echo '</div>';
        } else {
            echo '<div class="container">';
            $theMsg = "<div class='alert alert-danger'>This ID is not exist</div>";
            redirectHome($theMsg);
            echo '</div>';
        }
    } elseif ($do == 'approve') {
        echo "<h1 class='text-center'>Approve Comment</h1>";
        echo '<div class = "container">';

        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
        $check =  checkItem('c_id', 'comments', $comid);
        if ($check > 0) {
            $stmt = $con->prepare('UPDATE comments SET status=1   WHERE c_id = ?');
            $stmt->execute(array($comid));
            echo '<div class="container">';
            $theMsg = '<div class = "alert alert-success">' . $stmt->rowCount() . " comment is approved successfully</div>";
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
