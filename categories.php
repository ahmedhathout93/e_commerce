<?php include "init.php"; ?>

<div class="container">
    <div class="landing">
        <img src="landing.png" alt="">
    </div>
    <h1 class="text-center"> <?php echo str_replace('-', ' ', $_GET['pagename']) ?> </h1>
    <div class="row">
        <?php
        foreach (getItems($_GET['pageid']) as $item) {
            echo '<div class="col-sm-6 col-md-3 item-show">';
            echo '<span class="price-tag">'.$item['Price'].'</span>';
            echo '<div class="img-thumbnail item-box">';
            echo '<div class ="scale">';
            echo '<img class = "img-fluid" src="img.png" alt="">';
            echo '</div>';
            echo '<div class="caption">';
            echo '<h3>' . $item['Name'] . '</h3>';
            echo '<p>' . $item['Description'] . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</div>
<?php include $tpl . "footer.php"; ?>