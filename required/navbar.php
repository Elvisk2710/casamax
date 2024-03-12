<nav id="navBar" class="navbar-white">

    <h3 class="smltxt">CasaMax</h3>

    <img src="../images/menu.png" alt="menu" onclick="togglebtn()" class="fas">
    <br>
    <div class="navbar_link">
        <a href="../index.php" class="home">HOME</a>
        <a href="../bordinghouse.php">BOARDING-HOUSE</a>
        <a href="../advertise_as/index.php">ADVERTISE</a>
        <a href="../help.php">HELP</a>
        <?php
        if (!isset($_SESSION['sessionstudent'])) {
            echo '<a href="../loginas.php" class="sign_in" name="loginbtn">LOGIN</a>';
        } else {
            echo '<a href="../student_profile.php" class="sign_in" name="loginbtn">MY PROFILE</a>';
        }
        ?>
    </div>
</nav>