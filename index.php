<?php
session_start(); // Start the session to manage user state
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Online Bookstore</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS file -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">Book Heaven</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="aboutus.html" style="font-size: 18px; font-weight: bold;">About Us</a></li>
            <li><a href="books.html" style="font-size: 18px; font-weight: bold;">Books</a></li>
            <li><a href="contactus.html" style="font-size: 18px; font-weight: bold;">Contact Us</a></li>
            <?php if (isset($_SESSION['username'])): ?>
                <li><a href="signout.php" style="font-size: 18px; font-weight: bold;">Sign Out</a></li>
            <?php else: ?>
                <li><a href="register.php" style="font-size: 18px; font-weight: bold;">Register</a></li>
                <li><a href="signin.php" style="font-size: 18px; font-weight: bold;">Sign In</a></li>
            <?php endif; ?>
            <li><a href="#" data-toggle="modal" data-target="#adminModal" style="font-size: 18px; font-weight: bold;">Admin</a></li>
        </ul>
    </div>
</nav>

<!-- Carousel -->
<div class="container">  
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner">
            <div class="item active">
                <img src="./img/crousel2.jpg" alt="Book 1">
            </div>
            <div class="item">
                <img src="./img/carousel3.jpg" alt="Book 2">
            </div>
            <div class="item">
                <img src="./img/carousel4.jpg" alt="Book 3">
            </div>
        </div>

        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

<!-- Card Section -->
<div class="container card-container">
    <div class="col-sm-3">
        <div class="card cover-card">
            <img class="card-img-top" src="./img/book13].jfif" alt="Book Image">
            <div class="card-body">
                <h5 class="card-title" style="font-size: 18px; font-weight: bold; color: black;">Game of Shadows</h5>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card cover-card">
            <img class="card-img-top" src="./img/book14.jfif" alt="Book Image">
            <div class="card-body">
                <h5 class="card-title" style="font-size: 18px; font-weight: bold; color: black;">Shuri</h5>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card cover-card">
            <img class="card-img-top" src="./img/book15.jfif" alt="Book Image">
            <div class="card-body">
                <h5 class="card-title" style="font-size: 18px; font-weight: bold; color: white;">Scifi Anthology</h5>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card cover-card">
            <img class="card-img-top" src="./img/book16.jfif" alt="Book Image">
            <div class="card-body">
                <h5 class="card-title" style="font-size: 18px; font-weight: bold;  color: white;">The Luminous Dead</h5>
            </div>
        </div>
    </div>
</div>

<!-- Admin Modal -->
<div class="modal fade" id="adminModal" tabindex="-1" role="dialog" aria-labelledby="adminModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="adminModalLabel">Admin Login</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="adminForm" action="admin_login.php" method="POST">
                    <div class="form-group">
                        <label for="adminName">Username</label>
                        <input type="text" class="form-control" id="adminName" name="username" placeholder="Enter your username" required>
                    </div>
                    <div class="form-group">
                        <label for="adminPassword">Password</label>
                        <input type="password" class="form-control" id="adminPassword" name="password" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
