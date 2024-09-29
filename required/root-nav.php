<div class="nav-container">
    <nav id="navBar" class="navbar-white">
        <div class="top-nav">
            <h3 class="smltxt">CasaMax</h3>
            <img src="https://casamax.co.zw/images/menu.png" alt="menu" onclick="togglebtn()" class="fas">
        </div>
        <div class="left-navbar">
            <div class="head">
                <a href="https://casamax.co.zw"> <img src="./images/logoorange.png" alt="" class="logo"></a>
            </div>
            <div class="navbar-left-links">
                <a href="./index.php" class="home">Home</a>
                <a href="./advertise_as/index.php">Advertise</a>
                <a href="./manage/index.php">Manage Rental</a>
                <a href="./aboutus.php">About Us</a>
                <a href="./help.php">Help</a>
                <a href="./chat/screens/">My Chats</a>
            </div>
        </div>
        <div class="right-navbar">
            <div class="navbar-right-links">
                <?php
                if (isset($_SESSION['sessionstudent'])) {
                    echo '<a href="./student_profile.php" class="sign_in" name="loginbtn">My Profile</a>';
                } elseif (isset($_SESSION['sessionowner'])) {
                    echo '<a href="./profile.php" class="sign_in" name="loginbtn">My Profile</a>';
                } else {
                    echo '<a href="./loginas.php" class="sign_in" name="loginbtn">Login</a>';
                }
                ?>
            </div>
        </div>
    </nav>
</div>
<style>
    .nav-container {
        width: 100%;
    }
    .top-nav{
        display: none;
    }
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
        font-weight: 500 !important;
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

    @media only screen and (max-width: 700px) {
        nav .home {
            font-size: 1.2rem;
            display: inline-block;
            color: rgb(252, 153, 82);
        }
        .head{
            display: none;
        }

        nav {
            position: fixed;
            top: 0;
            z-index: 40;
            display: block !important;
            width: 100%;
            background: rgb(8, 8, 12);
            margin: 0 auto !important;
            max-height: 5rem;
            overflow: hidden;
            transition: max-height 1s;
            border-radius: 0px !important;
        }

        .top-nav {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 1rem 1.5rem;
            height: 5rem;
        }

        .smltxt {
            display: block;
            color: rgb(252, 153, 82);
        }

        .left-navbar {
            display: block;
            width: 100%;
            justify-content: center;
        }

        .navbar-left-links {
            display: flex;
            flex-direction: column;
            margin-top: 0rem !important;
            justify-content: center;
            align-items: center;
        }

        .navbar-right-links {
            display: flex;
            justify-content: center !important;
            align-items: center !important;
        }

        nav a {
            display: block;
            color: rgb(255, 255, 255);
            font-weight: 400;
            font-size: 1rem;
            display: flex;
            justify-content: center;
            justify-items: center;
            align-items: center;
        }

        .sign_in {
            background: rgb(252, 153, 82);
            border-radius: 15px;
            padding: 3px 12px;
            font-weight: 700;
            color: rgb(8, 8, 12);
            width: fit-content;
        }

        .hidemenu {
            max-height: 300vw;
            background: rgb(8, 8, 12);
            width: 100%;
        }

        .search-bar {
            width: 80%;
            margin: 30px auto;
            padding: 20px 10px 30px;
            border-radius: 15px;
            position: relative;
        }

        #navBar .fas {
            display: inline-block;
            color: rgb(252, 153, 82);
            height: 30px;
            width: 30px;
            background: none;
            text-align: right;
            margin-left: 60px;
            margin-bottom: 0px;
            padding-top: 0;
        }
    }
</style>