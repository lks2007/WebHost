<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webhost</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="material-design-iconic-font/css/material-design-iconic-font.min.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php require_once "nav.php" ?>
    <div class="wrapper">
        <h1>Create a website you're proud of</h1>
        <h3>Discover the platform that gives you the freedom to create, design, manage and develop your web presence exactly the way you want.</h3>
        <a href="#style"><button class="t-40 btn-2" href="#style">Get Start</button></a>
        <div id="style">
            <h2>Services</h2>
            <div class="contain">
                <div class="service">
                    <img src="https://s.w.org/style/images/about/WordPress-logotype-wmark.png" class="img" alt="" srcset="" />
                    <p>Wordpress CMS</p>
                </div>
                <div class="service">
                    <img src="assets/python.png" class="img" alt="" srcset="" />
                    <p>Python</p>
                </div>
                <div class="service">
                    <img src="assets/ruby.png" class="img" alt="" srcset="" />
                    <p>Ruby</p>
                </div>
            </div>
            <br><br>
            <!-- <h2>Offer</h2>
            <div class="contain offer">
                <div class="service w-50">
                    <p>Free</p>
                    <h2>0$</h2>
                    <div class="btn-5">Get Started</div>
                </div>
                <div class="service w-50">
                    <p>Python</p>
                </div>
            </div> -->
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    <?php if(isset($_SESSION['email']) AND isset($_SESSION['name'])){ ?>
        var email = "<?= $_SESSION['email'] ?>",
        name = "<?= $_SESSION['name'] ?>";
    <?php } ?>
</script>
<script src="js/main.js"></script>
</html>