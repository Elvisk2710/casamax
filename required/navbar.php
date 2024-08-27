<nav id="navBar" class="navbar-white">

    <h3 class="smltxt">CasaMax</h3>

    <img src="../images/menu.png" alt="menu" onclick="togglebtn()" class="fas">
    <br>
        <a href="../index.php" class="home">HOME</a>
        <a href="../advertise_as/index.php">ADVERTISE</a>
        <a href="../help.php">HELP</a>
        <a href="../chat/screens/">MY CHATS</a>
        <?php
        if (isset($_SESSION['sessionstudent'])) {
            echo '<a href="../student_profile.php" class="sign_in" name="loginbtn">MY PROFILE</a>';
        } elseif (isset($_SESSION['sessionowner'])) {
            echo '<a href="../profile.php" class="sign_in" name="loginbtn">MY PROFILE</a>';
        } else {
            echo '<a href="../loginas.php" class="sign_in" name="loginbtn">LOGIN</a>';
        }
        ?>
</nav> 