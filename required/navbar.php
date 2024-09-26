<nav id="navBar" class="navbar-white">
    <h3 class="smltxt">CasaMax</h3>
    <img src="https://casamax.co.zw/images/menu.png" alt="menu" onclick="togglebtn()" class="fas">
    <div class="left-navbar">
        <div class="head">
            <a href="https://casamax.co.zw"> <img src="https://casamax.co.zw/images/logoblack.png" alt="" class="logo"></a>
        </div>
        <div class="navbar-left-links">
            <a href="../index.php" class="home">Home</a>
            <a href="../advertise_as/index.php">Advertise</a>
            <a href="../help.php">Help</a>
            <a href="../chat/screens/">My Chats</a>
        </div>
    </div>
    <div class="right-navbar">
        <div class="navbar-right-links">
            <?php
            if (isset($_SESSION['sessionstudent'])) {
                echo '<a href="../student_profile.php" class="sign_in" name="loginbtn">My Profile</a>';
            } elseif (isset($_SESSION['sessionowner'])) {
                echo '<a href="../profile.php" class="sign_in" name="loginbtn">My Profile</a>';
            } else {
                echo '<a href="../loginas.php" class="sign_in" name="loginbtn">Login</a>';
            }
            ?>
        </div>
    </div>
</nav>
<style>
    nav {
  background-color: white;
  text-align: center;
  margin: 2rem 6rem;
  border-radius: 20px;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.left-nav {
  display: flex;
  flex-direction: row;
  justify-content: start;
  align-items: center;
}
.right-nav {
  display: flex;
  flex-direction: row;
  justify-content: end;
  align-items: center;
}
nav .fas {
  display: none;
}
nav .home {
  display: none;
}
nav a {
  margin: 1rem 1rem;
  color: rgb(8, 8, 12);
  display: flex;
  justify-content: center;
  justify-items: center;
  align-items: center;
  text-decoration: none;
  width: fit-content;
}
.smltxt {
  display: none;
}
nav a:hover {
  color: rgb(252, 153, 82);
}
.sign_in {
  background-color: rgb(252, 153, 82);
  padding: 0.5rem 1.2rem;
  border-radius: 20px;
}
.sign_in:hover {
  color: rgb(8, 8, 12);
  transform: scale(1.05);
  transition: transform 0.3s ease-in-out;
}
.sign_in:active {
  color: rgb(8, 8, 12);
  transform: scale(0.95);
  transition: transform 0.3s ease-in-out;
}

.navbar-white {
  background-color: white;
  text-align: center;
  border-radius: 20px;
  margin: 0;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  width: 100%;
}
.left-navbar {
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  align-items: center;
}
.navbar-left-links {
  display: flex;
  justify-content: space-around;
  align-items: center;
}
</style>