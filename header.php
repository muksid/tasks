<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Tasks</title>
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap-icons.css">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="index.php">Home</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Задачи</a>
            </li>
        </ul>
        <?php
        if (isset($_SESSION['username'])) {
            ?>
            <div class="my-2 my-lg-0">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Adminstrator:</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="#"><?php echo $_SESSION['username']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="index.php?act=logout"><i class="bi bi-box-arrow-in-right"></i></a>
                    </li>
                </ul>
            </div>
            <?php
        } else {
            ?>
            <form class="form-inline my-2 my-lg-0" action="index.php?act=login" method="post">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Adminstrator:</a>
                    </li>
                    <li class="nav-item">
                        <span class="text-dark nav-link"><?php echo $_SESSION['error_login']; ?></span>
                    </li>
                </ul>
                <input class="form-control mr-sm-1" type="text" name="username" placeholder="Login">
                <input class="form-control mr-sm-1" type="password" name="password" placeholder="Password">
                <button class="btn btn-dark my-2 my-sm-0" type="submit" name="log-in">Login</button>
            </form>
            <?php
        }
        ?>

    </div>
</nav>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Content</li>
    </ol>
</nav>
