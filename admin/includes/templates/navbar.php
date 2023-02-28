
<nav class="navbar navbar-expand-lg navbar-dark  shadow p-3 ">

    <div class="container ">

        <a class="navbar-brand" href="dashboard.php"><?php echo lang('HOME') ?></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" aria-controls="app-nav" aria-expanded="false" aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="app-nav">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link " aria-current="page" href="#"><?php echo lang('CATEGORIES') ?></a></li>
                <li class="nav-item"><a class="nav-link " aria-current="page" href="#"><?php echo lang('ITEMS') ?></a></li>
                <li class="nav-item"><a class="nav-link " aria-current="page" href="members.php"><?php echo lang('MEMBERS') ?></a></li>
                <li class="nav-item"><a class="nav-link " aria-current="page" href="#"><?php echo lang('STATISTICS') ?></a></li>
                <li class="nav-item"><a class="nav-link " aria-current="page" href="#"><?php echo lang('LOGS') ?></a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                    <?php echo lang('ADMIN_NAME') ?>

                    </a>

                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                        <li><a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['ID']; ?>"><?php echo lang('EDIT') ?></a></li>

                        <li><a class="dropdown-item" href="#"><?php echo lang('SETTINGS') ?></a></li>

                        <li><a class="dropdown-item" href="logout.php"><?php echo lang('LOGOUT') ?></a></li>

                    </ul>

                </li>

            </ul>

        </div>

    </div>

</nav>
