<?php

// Manage page (Add - Edit - Delete) members .

session_start();

if (isset($_SESSION['Username'])) {

    $pageTitle = 'Categories';

    include "init.php";

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';



    if ($do == 'Manage') {

        //manage categories page

        $sort = 'ASC';
        $sort_Array = array('ASC', 'DESC');
        if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_Array)) {
            $sort = $_GET['sort'];
        }
        $stmt2 = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
        $stmt2->execute();
        $cats = $stmt2->fetchAll();
?>
        <h1 class="text-center">Manage categories</h1>
        <div class="container categories">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Manage categories
                    <div class="float-end ord">
                        <i class="fa fa-sort"></i> Ordering : [
                        <a href="?sort=ASC" class="<?php if ($sort == 'ASC') {
                                                        echo 'active';
                                                    } ?>">ASC</a> |
                        <a href="?sort=DESC" class="<?php if ($sort == 'DESC') {
                                                        echo 'active';
                                                    } ?>">DESC</a> ]
                        <i class="fa fa-eye"></i> View : [
                        <span class="active" data-view="full">Full</span> |
                        <span>Classic</span>
                        ]
                    </div>
                </div>
                <div class="panel-body">
                    <?php
                    foreach ($cats as $cat) {
                        echo '<div class = "cat">'; ?>
                        <div class="cat-buttons">
                            <a href="?do=Edit&catid=<?php echo $cat['ID'] ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i>Edit</a>
                            <a href="?do=delete&catid=<?php echo $cat['ID'] ?>" class=" confirm btn btn-sm btn-danger"><i class="fa fa-close"></i>Delete</a>
                        </div>
                    <?php echo  '<h3>' . $cat['Name'] . '</h3>';
                        echo '<div class="full-view">';
                        echo  '<p>';
                        $catdesc = (empty($cat['Description'])) ? 'This category has no description' : $cat['Description'];
                        echo $catdesc;
                        echo '</p>';
                        if ($cat['Visibility'] == 1) {
                            echo '<span class ="visibility"><i class= "fa fa-eye"></i>Hidden</span>';
                        }
                        if ($cat['Allow_Comment'] == 1) {
                            echo '<span class ="commenting"><i class= "fa fa-close"></i>Comments disabled</span>';
                        }
                        if ($cat['Allow_Ads'] == 1) {
                            echo '<span class ="advertise"><i class= "fa fa-close"></i>Ads disabled</span>';
                        }
                        echo '</div>';
                        echo '</div>';
                        echo '<hr>';
                    }
                    ?>
                </div>
                <a href="categories.php?do=Add" class="save-cat btn btn-primary"><i class="fa fa-plus"></i>new category</a>
            </div>
        </div>
    <?php    } elseif ($do == 'Add')
    // Add  page 
    { ?>
        <h1 class="text-center">Add new category</h1>
        <div class="container">
            <form class="form-group row " action="?do=insert" method="POST">
                <!-- start name field -->
                <div class="form-group row form-control-lg">
                    <label class="col-sm-2 offset-2 control-label">Name</label>
                    <div class="col-sm-5">
                        <input type="text" name="name" class="form-control " required='required' placeholder="Category name" />
                        <span class="required"></span>
                    </div>
                </div>
                <!-- end name field -->
                <!-- start description field -->
                <div class="form-group row form-control-lg">
                    <label class="col-sm-2 offset-2 control-label">Description</label>
                    <div class="col-sm-5">
                        <input type="text" name="description" class=" form-control" placeholder="Category description" />
                    </div>
                </div>
                <!-- end description field -->
                <!-- start ordering field -->
                <div class="form-group row form-control-lg">
                    <label class="col-sm-2 offset-2 control-label">Ordering</label>
                    <div class="col-sm-5">
                        <input type="text" name="order" class="form-control" placeholder="Category ordering number" />
                    </div>
                </div>
                <!-- end order field -->
                <!-- start visibility field -->
                <div class="form-group row form-control-lg">
                    <label class="col-sm-2 offset-2 control-label">visibility</label>
                    <div class="col-sm-5">
                        <div>
                            <input id="vis-yes" type="radio" name="visible" value="0" checked />
                            <label for="vis-yes">Yes</label>
                        </div>
                        <div>
                            <input id="vis-no" type="radio" name="visible" value="1" />
                            <label for="vis-no">No</label>
                        </div>
                    </div>
                </div>
                <!-- end visibility field -->
                <!-- start Commenting field -->
                <div class="form-group row form-control-lg">
                    <label class="col-sm-2 offset-2 control-label">Comments</label>
                    <div class="col-sm-5">
                        <div>
                            <input id="com-yes" type="radio" name="comment" value="0" checked />
                            <label for="com-yes">Yes</label>
                        </div>
                        <div>
                            <input id="com-no" type="radio" name="comment" value="1" />
                            <label for="com-no">No</label>
                        </div>
                    </div>
                </div>
                <!-- end Commenting field -->
                <!-- start Ads field -->
                <div class="form-group row form-control-lg">
                    <label class="col-sm-2 offset-2 control-label">Ads</label>
                    <div class="col-sm-5">
                        <div>
                            <input id="ads-yes" type="radio" name="ads" value="0" checked />
                            <label for="ads-yes">Yes</label>
                        </div>
                        <div>
                            <input id="ads-no" type="radio" name="ads" value="1" />
                            <label for="ads-no">No</label>
                        </div>
                    </div>
                </div>
                <!-- end Ads field -->
                <!-- start save field -->
                <div class="savediv">
                    <div class="save">
                        <input type="submit" value="Add Category" class="save btn btn-primary" />
                    </div>
                </div>
                <!-- end save field -->

            </form>
        </div>
        <?php
    } elseif ($do == 'insert') {
        // insert page 
        echo "<h1 class='text-center'>Insert Category</h1>";
        echo '<div class = "container">';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //get variables from form
            $name   = $_POST['name'];
            $desc   = $_POST['description'];
            $order   = $_POST['order'];
            $visible  = $_POST['visible'];
            $comment  = $_POST['comment'];
            $ads  = $_POST['ads'];

            // form errors and validation
            $formErrors = array();
            if (strlen($name) < 3) {
                $formErrors[] = 'Category name can\'t be less than 3 characters ';
            }
            foreach ($formErrors as $error) {
                echo '<div class = " alert alert-danger">' . $error . '</div>';
            }
            // prevent updating database if form has error
            if (empty($formErrors)) {

                // check is category exists
                $check =  checkItem("Name", "categories", $name);
                if ($check == 1) {
                    $theMsg = '<div class="alert alert-danger">This category is already exists</div>';
                    redirectHome($theMsg, 'back');
                } else {

                    // insert category info in DB
                    $stmt = $con->prepare("INSERT INTO 
                                        categories (Name , Description , Ordering , Visibility , Allow_Comment , Allow_Ads )
                                        VALUES(:zname , :zdesc , :zorder , :zvisible , :zcomment , :zads)");
                    $stmt->execute(array(
                        'zname'      => $name,
                        'zdesc'      => $desc,
                        'zorder'     => $order,
                        'zvisible'   => $visible,
                        'zcomment'   => $comment,
                        'zads'       => $ads
                    ));
                    // print success message 
                    echo '<div class="container">';
                    $theMsg =  '<div class = "alert alert-success">' . $stmt->rowCount() . " Category is inserted successfully</div>";
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
        // edit page

        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
        $stmt = $con->prepare("SELECT * FROM categories where ID = ?  LIMIT 1");
        $stmt->execute(array($catid));
        $row = $stmt->fetch();
        $count = $stmt->rowcount();
        if ($count > 0) {
        ?>
            <h1 class="text-center">Edit category</h1>
            <div class="container">
                <form class="form-group row " action="?do=Update" method="POST">
                    <input type="hidden" name="catid" value="<?php echo $catid ?>" />

                    <!-- start name field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">Name</label>
                        <div class="col-sm-5">
                            <input type="text" name="name" class="form-control " required='required' placeholder="Category name" value="<?php echo $row['Name'] ?>" />
                            <span class="required"></span>
                        </div>
                    </div>
                    <!-- end name field -->
                    <!-- start description field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">Description</label>
                        <div class="col-sm-5">
                            <input type="text" name="description" class=" form-control" placeholder="Category description" value="<?php echo $row['Description'] ?>" />
                        </div>
                    </div>
                    <!-- end description field -->
                    <!-- start ordering field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">Ordering</label>
                        <div class="col-sm-5">
                            <input type="text" name="order" class="form-control" placeholder="Category ordering number" value="<?php echo $row['Ordering'] ?>" />
                        </div>
                    </div>
                    <!-- end order field -->
                    <!-- start visibility field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">visibility</label>
                        <div class="col-sm-5">
                            <div>
                                <input id="vis-yes" type="radio" name="visible" value="0" <?php if ($row['Visibility'] == 0) {
                                                                                                echo 'checked';
                                                                                            } ?> />
                                <label for="vis-yes">Yes</label>
                            </div>
                            <div>
                                <input id="vis-no" type="radio" name="visible" value="1" <?php if ($row['Visibility'] == 1) {
                                                                                                echo 'checked';
                                                                                            } ?> />
                                <label for="vis-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- end visibility field -->
                    <!-- start Commenting field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">Comments</label>
                        <div class="col-sm-5">
                            <div>
                                <input id="com-yes" type="radio" name="comment" value="0" <?php if ($row['Allow_Comment'] == 0) {
                                                                                                echo 'checked';
                                                                                            } ?> />
                                <label for="com-yes">Yes</label>
                            </div>
                            <div>
                                <input id="com-no" type="radio" name="comment" value="1" <?php if ($row['Allow_Comment'] == 1) {
                                                                                                echo 'checked';
                                                                                            } ?> />
                                <label for="com-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- end Commenting field -->
                    <!-- start Ads field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">Ads</label>
                        <div class="col-sm-5">
                            <div>
                                <input id="ads-yes" type="radio" name="ads" value="0" <?php if ($row['Allow_Ads'] == 0) {
                                                                                            echo 'checked';
                                                                                        } ?> />
                                <label for="ads-yes">Yes</label>
                            </div>
                            <div>
                                <input id="ads-no" type="radio" name="ads" value="1" <?php if ($row['Allow_Ads'] == 1) {
                                                                                            echo 'checked';
                                                                                        } ?> />
                                <label for="ads-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- end Ads field -->
                    <!-- start save field -->
                    <div class="savediv">
                        <div class="save">
                            <input type="submit" value="Save Category" class="save btn btn-primary" />
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
    } elseif ($do == 'Update') {
        echo "<h1 class='text-center'>Update Category</h1>";
        echo '<div class = "container">';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //get variables from form

            $id       = $_POST['catid'];
            $name     = $_POST['name'];
            $desc     = $_POST['description'];
            $order    = $_POST['order'];
            $visible  = $_POST['visible'];
            $comment  = $_POST['comment'];
            $ads      = $_POST['ads'];

            // form errors and validation
            $formErrors = array();
            if (strlen($name) < 3) {
                $formErrors[] = 'Cat name field can\'t be less than 3 characters ';
            }

            foreach ($formErrors as $error) {
                echo '<div class = " alert alert-danger">' . $error . '</div>';
            }
            // prevent updating database if form has error
            if (empty($formErrors)) {
                // update database with edites
                $stmt = $con->prepare("UPDATE categories SET Name = ? , Description = ? , Ordering = ? , Visibility = ? , Allow_Comment = ?, Allow_Ads = ? WHERE ID = ?");
                $stmt->execute(array($name, $desc, $order, $visible, $comment, $ads,  $id));
                // print success message 
                echo '<div class="container">';
                $theMsg = '<div class = "alert alert-success">' . $stmt->rowCount() . " Category is updated successfully</div>";
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
    } elseif ($do == 'delete') {
        // delete  page 

        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

        $check =  checkItem('ID', 'categories', $catid);
        if ($check > 0) {
            $stmt = $con->prepare('DELETE FROM categories WHERE ID =:zcat');
            $stmt->bindParam(':zcat', $catid);
            $stmt->execute();
            echo '<div class="container">';
            $theMsg = '<div class = "alert alert-success">' . $stmt->rowCount() . " Category is deleted successfully</div>";
            redirectHome($theMsg, 'back');
            echo '</div>';
        } else {
            echo '<div class="container">';
            $theMsg = "<div class='alert alert-danger'>This ID is not exist</div>";
            redirectHome($theMsg);
            echo '</div>';
        }
    }
    include $tpl . 'footer.php';
} else {
    header('Location:index.php');
    exit();
}
