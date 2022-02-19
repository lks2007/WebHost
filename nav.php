<nav>
    <div class="brand">
        <ul>
            <li><img src="assets/title.png" class="logo" srcset=""></li>
            <li>Home</li>
            <li>Products</li>
            <li>Pricing</li>
        </ul>
    </div>
    <div class="brand">
        <?php if(isset($_SESSION['id'])){
            ?>
            <ul>
                <li><a class="modal"><i class="zmdi zmdi-apps mdc-text-grey"></i></a></li>
                <li><img class="btn-3" src="https://icebeal.herokuapp.com/api/identicon/<?= $_SESSION["name"] ?>.svg" /></li>
            </ul>       
        <?php
        }else{
            echo '<a href="/login.php" class="btn"><i class="far fa-user"></i> Login</a>
            <a href="/register.php" class="btn"><i class="far fa-id-badge"></i> Register</a>';
        } ?>
    </div>
</nav>