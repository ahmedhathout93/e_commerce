<?php

// items page  .

session_start();

if (isset($_SESSION['Username'])) {

    $pageTitle = 'Items';

    include "init.php";

    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';



    if ($do == 'manage') {
        //manage items page

        $stmt = $con->prepare("SELECT items.*  , categories.Name AS Cat_Name , users.Username FROM items
        INNER JOIN categories ON categories.ID = items.Cat_ID 
        INNER JOIN users ON users.UserID = items.Member_ID");
        $stmt->execute();
        $items = $stmt->fetchAll();

?>
        <h1 class="text-center">Manage Items</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table table table-bordered  text-center">
                    <thead>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Username</th>
                        <th>Control</th>
                    </thead>
                    <?php
                    foreach ($items as $item) {
                        echo "<tr>";
                        echo "<td>" . $item['item_ID'] . "</td>";
                        echo "<td>" . $item['Name'] . "</td>";
                        echo "<td>" . $item['Description'] . "</td>";
                        echo "<td>" . $item['Price'] . "</td>";
                        echo "<td>" . $item['Add_Date'] . "</td>";
                        echo "<td>" . $item['Cat_Name'] . "</td>";
                        echo "<td>" . $item['Username'] . "</td>";
                        echo ' <td>  <a href="?do=edit&itemid=' . $item["item_ID"] . '" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a> 
                        <a href="?do=delete&itemid=' . $item["item_ID"] . '" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a> ';
                        if ($item['Approve'] == 0) {
                            echo '<a href="?do=approve&itemid=' . $item["item_ID"] . '" class="btn btn-info"><i class="fa fa-check"></i>Approve</a>';
                        }
                        echo '</td>';
                        echo "</tr>";
                    } ?>
                </table>
            </div>
            <a href="items.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i>new item</a>
        </div>
    <?php
    } elseif ($do == 'add') {
        // Add item page
    ?>
        <h1 class="text-center">Add new item</h1>
        <div class="container">
            <form class="form-group row " action="?do=insert" method="POST">
                <!-- start name field -->
                <div class="form-group row form-control-lg">
                    <label class="col-sm-2 offset-2 control-label">Name</label>
                    <div class="col-sm-5">
                        <input type="text" name="name" class="form-control " required='required' placeholder="Item name" />
                        <span class="required"></span>
                    </div>
                </div>
                <!-- end name field -->
                <!-- start description field -->
                <div class="form-group row form-control-lg">
                    <label class="col-sm-2 offset-2 control-label">Description</label>
                    <div class="col-sm-5">
                        <input type="text" name="description" class="form-control " required='required' placeholder="Description of item" />
                        <span class="required"></span>
                    </div>
                </div>
                <!-- end description field -->
                <!-- start price field -->
                <div class="form-group row form-control-lg">
                    <label class="col-sm-2 offset-2 control-label">Price</label>
                    <div class="col-sm-5">
                        <input type="text" name="price" class="form-control " required='required' placeholder="Price of item" />
                        <span class="required"></span>
                    </div>
                </div>
                <!-- end price field -->
                <!-- start country field -->
                <div class="form-group row form-control-lg">
                    <label class="col-sm-2 offset-2 control-label">Country</label>
                    <div class="col-sm-5">
                        <input type="text" name="country" class="form-control " required='required' placeholder="Country of origin" />
                        <span class="required"></span>
                    </div>
                </div>
                <!-- end country field -->
                <!-- start status field -->
                <div class="form-group row form-control-lg">
                    <label class="col-sm-2 offset-2 control-label">Status</label>
                    <div class="col-sm-5">
                        <select class="form-select" name="status">
                            <option value="0">...</option>
                            <option value="1">New</option>
                            <option value="2">Used</option>
                            <option value="3">Old</option>
                        </select>
                    </div>
                </div>
                <!-- end status field -->
                <!-- start member field -->
                <div class="form-group row form-control-lg">
                    <label class="col-sm-2 offset-2 control-label">Member</label>
                    <div class="col-sm-5">
                        <select class="form-select" name="member">
                            <option value="0">...</option>
                            <?php
                            $stmt = $con->prepare("SELECT UserID , Username FROM users");
                            $stmt->execute();
                            $users = $stmt->fetchAll();
                            foreach ($users as $user) {
                                echo '<option value="';
                                echo $user['UserID'] . '">';
                                echo $user['Username'];
                                echo '</options>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- end member field -->
                <!-- start category field -->
                <div class="form-group row form-control-lg">
                    <label class="col-sm-2 offset-2 control-label">Category</label>
                    <div class="col-sm-5">
                        <select class="form-select" name="category">
                            <option value="0">...</option>
                            <?php
                            $stmt = $con->prepare("SELECT ID , Name FROM categories");
                            $stmt->execute();
                            $cats = $stmt->fetchAll();
                            foreach ($cats as $cat) {
                                echo '<option value="';
                                echo $cat['ID'] . '">';
                                echo $cat['Name'];
                                echo '</options>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- end category field -->
                <!-- start save field -->
                <div class="savediv">
                    <div class="save">
                        <input type="submit" value="Add Item" class="save btn btn-primary" />
                    </div>
                </div>
                <!-- end save field -->

            </form>
        </div>
        <?php
    } elseif ($do == 'insert') {

        // insert item page 

        echo "<h1 class='text-center'>Insert item</h1>";
        echo '<div class = "container">';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //get variables from form
            $name   = $_POST['name'];
            $desc   = $_POST['description'];
            $price   = $_POST['price'];
            $country  = $_POST['country'];
            $status  = $_POST['status'];
            $cat_id  = $_POST['category'];
            $member_id  = $_POST['member'];
            // form errors and validation
            $formErrors = array();
            if (strlen($name) < 3) {
                $formErrors[] = 'Item name can\'t be less than 3 characters ';
            }
            if (strlen($desc) < 5) {
                $formErrors[] = 'Item description can\'t be less than 5 characters ';
            }
            if (strlen($price) < 3) {
                $formErrors[] = 'Item price can\'t be less than 1 characters ';
            }
            if (strlen($country) < 3) {
                $formErrors[] = 'Country name can\'t be less than 3 characters ';
            }
            if ($cat_id == 0) {
                $formErrors[] = 'Please select item category ';
            }
            if ($member_id == 0) {
                $formErrors[] = 'Please select item member ';
            }

            // prevent updating database if form has error
            if (empty($formErrors)) {
                // insert item info in DB
                $stmt = $con->prepare("INSERT INTO 
                                        items (Name , Description , Price , Country , Status , Add_Date , Cat_ID , Member_ID )
                                        VALUES(:zname , :zdesc , :zprice , :zcountry , :zstatus , now() , :zcat_id , :zmember_id)");
                $stmt->execute(array(
                    'zname'      => $name,
                    'zdesc'      => $desc,
                    'zprice'     => $price,
                    'zcountry'   => $country,
                    'zstatus'   => $status,
                    'zcat_id'   => $cat_id,
                    'zmember_id'   => $member_id
                ));
                // print success message 
                echo '<div class="container">';
                $theMsg =  '<div class = "alert alert-success">' . $stmt->rowCount() . " Item is inserted successfully</div>";
                redirectHome($theMsg, 'back');
                echo '</div>';
            } else {
                foreach ($formErrors as $error) {
                    echo '<div class = " alert alert-danger">' . $error . '</div>';
                }
            }
            echo '</div>';
        } else {
            echo '<div class="container">';
            $theMsg = "<div class='alert alert-danger'>sorry you can't access this page directly</div>";
            redirectHome($theMsg);
            echo '</div>';
        }
    } elseif ($do == 'update') {

        // update item page 
        echo "<h1 class='text-center'>Update Item</h1>";
        echo '<div class = "container">';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //get variables from form

            $itemid = $_POST['itemid'];
            $name   = $_POST['name'];
            $desc   = $_POST['description'];
            $price   = $_POST['price'];
            $country  = $_POST['country'];
            $status  = $_POST['status'];
            $cat_id  = $_POST['category'];
            $member_id  = $_POST['member'];

            // password update

            // form errors and validation
            $formErrors = array();
            if (strlen($name) < 3) {
                $formErrors[] = 'Item name can\'t be less than 3 characters ';
            }
            if (strlen($desc) < 5) {
                $formErrors[] = 'Item description can\'t be less than 5 characters ';
            }
            if (strlen($price) < 3) {
                $formErrors[] = 'Item price can\'t be less than 1 characters ';
            }
            if (strlen($country) < 3) {
                $formErrors[] = 'Country name can\'t be less than 3 characters ';
            }
            if ($cat_id == 0) {
                $formErrors[] = 'Please select item category ';
            }
            if ($member_id == 0) {
                $formErrors[] = 'Please select item member ';
            }
            foreach ($formErrors as $error) {
                echo '<div class = " alert alert-danger">' . $error . '</div>';
            }
            // prevent updating database if form has error
            if (empty($formErrors)) {
                // update database with edites
                $stmt = $con->prepare("UPDATE items SET Name = ? , Description = ? , Price = ? , Country = ? , Status = ? , Cat_ID = ? , Member_ID = ? WHERE item_ID = ?");
                $stmt->execute(array($name, $desc, $price, $country,  $status, $cat_id, $member_id, $itemid));
                // print success message 
                echo '<div class="container">';
                $theMsg = '<div class = "alert alert-success">' . $stmt->rowCount() . " Item is updated successfully</div>";
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
    } elseif ($do == 'edit') {
        // edit item
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        $stmt = $con->prepare("SELECT * FROM items where item_ID = ?  ");
        $stmt->execute(array($itemid));
        $item = $stmt->fetch();
        $count = $stmt->rowcount();
        if ($count > 0) {
        ?>
            <h1 class="text-center">Edit Item</h1>
            <div class="container">
                <form class="form-group row " action="?do=update" method="POST">
                    <input type="hidden" name="itemid" value="<?php echo $itemid ?>" />
                    <!-- start username field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">Name</label>
                        <div class="col-sm-5">
                            <input type="text" name="name" class="form-control " required='required' value="<?php echo $item['Name']; ?>" />
                            <span class="required"></span>
                        </div>
                    </div>
                    <!-- end name field -->
                    <!-- start description field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">Description</label>
                        <div class="col-sm-5">
                            <input type="text" name="description" class="form-control " required='required' value="<?php echo $item['Description']; ?>" />
                            <span class="required"></span>
                        </div>
                    </div>
                    <!-- end description field -->
                    <!-- start price field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">Price</label>
                        <div class="col-sm-5">
                            <input type="text" name="price" class="form-control " required='required' value="<?php echo $item['Price']; ?>" />
                            <span class="required"></span>
                        </div>
                    </div>
                    <!-- end price field -->
                    <!-- start country field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">Country</label>
                        <div class="col-sm-5">
                            <input type="text" name="country" class="form-control " required='required' value="<?php echo $item['Country']; ?>" />
                            <span class="required"></span>
                        </div>
                    </div>
                    <!-- end country field -->
                    <!-- start status field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">Status</label>
                        <div class="col-sm-5">
                            <select class="form-select" name="status">
                                <option value="0" <?php if ($item['Status'] == 0) {
                                                        echo "selected";
                                                    } ?>>...</option>
                                <option value="1" <?php if ($item['Status'] == 1) {
                                                        echo "selected";
                                                    } ?>>New</option>
                                <option value="2" <?php if ($item['Status'] == 2) {
                                                        echo "selected";
                                                    } ?>>Used</option>
                                <option value="3" <?php if ($item['Status'] == 3) {
                                                        echo "selected";
                                                    } ?>>Old</option>
                            </select>
                        </div>
                    </div>
                    <!-- end status field -->
                    <!-- start member field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">Member</label>
                        <div class="col-sm-5">
                            <select class="form-select" name="member">
                                <option value="0">...</option>
                                <?php
                                $stmt = $con->prepare("SELECT UserID , Username FROM users");
                                $stmt->execute();
                                $users = $stmt->fetchAll();
                                foreach ($users as $user) {
                                    echo '<option value="';
                                    echo $user['UserID'] . '"';
                                    if ($item['Member_ID'] == $user['UserID']) {
                                        echo 'selected';
                                    }
                                    echo ">";
                                    echo $user['Username'];
                                    echo '</options>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- end member field -->
                    <!-- start category field -->
                    <div class="form-group row form-control-lg">
                        <label class="col-sm-2 offset-2 control-label">Category</label>
                        <div class="col-sm-5">
                            <select class="form-select" name="category">
                                <option value="0">...</option>
                                <?php
                                $stmt = $con->prepare("SELECT ID , Name FROM categories");
                                $stmt->execute();
                                $cats = $stmt->fetchAll();
                                foreach ($cats as $cat) {
                                    echo '<option value="';
                                    echo $cat['ID'] . '"';
                                    if ($item['Cat_ID'] == $cat['ID']) {
                                        echo 'selected';
                                    }
                                    echo ">";
                                    echo $cat['Name'];
                                    echo '</options>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- end category field -->
                    <!-- start save field -->
                    <div class="savediv">
                        <div class="save">
                            <input type="submit" value="Add Item" class="save btn btn-primary" />
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

    // delete item page  

    elseif ($do == 'delete') {
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

        $check =  checkItem('item_ID', 'items', $itemid);
        if ($check > 0) {
            $stmt = $con->prepare('DELETE FROM items WHERE item_ID =:zuser');
            $stmt->bindParam('zuser', $itemid);
            $stmt->execute();
            echo '<div class="container">';
            $theMsg = '<div class = "alert alert-success">' . $stmt->rowCount() . " Item is deleted successfully</div>";
            redirectHome($theMsg, 'back');
            echo '</div>';
        } else {
            echo '<div class="container">';
            $theMsg = "<div class='alert alert-danger'>This ID is not exist</div>";
            redirectHome($theMsg);
            echo '</div>';
        }
    } elseif ($do == 'approve') {
        echo "<h1 class='text-center'>Approve item</h1>";
        echo '<div class = "container">';

        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

        $check =  checkItem('item_ID', 'items', $itemid);
        if ($check > 0) {
            $stmt = $con->prepare('UPDATE items SET Approve=1   WHERE item_ID = ?');
            $stmt->execute(array($itemid));
            echo '<div class="container">';
            $theMsg = '<div class = "alert alert-success">' . $stmt->rowCount() . " item is approved successfully</div>";
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
