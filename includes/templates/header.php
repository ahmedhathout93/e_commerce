<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title><?php getTitle() ?></title>
    <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.css.map" />
    <link rel="stylesheet" href="<?php echo $css; ?>all.css" />
    <link rel="stylesheet" href="<?php echo $css; ?>front.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Mitr:wght@300&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Ultra&display=swap" rel="stylesheet">
</head>

<body>
    <div class="upper-bar">
        <div class="container">
        upper bar
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark  shadow p-3 ">

        <div class="container ">

            <a class="navbar-brand" href="index.php"><?php echo lang('HOME') ?></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" aria-controls="app-nav" aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse justify-content-end " id="app-nav">

                <ul class="navbar-nav  mb-2 mb-lg-0">
                    <?php
                    foreach (getCat() as $cat) {
                        echo '<li class="nav-item">' . "<a class = 'nav-link' href='categories.php?pageid=" . $cat['ID'] . "&pagename=" . str_replace(' ', '-', $cat['Name']) . "'>" . $cat['Name'] . '</a></li>';
                    }
                    ?>
                </ul>


            </div>

        </div>

    </nav>