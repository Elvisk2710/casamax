<nav class="sidebar" id="navBar">
    <div class="toggleButton">
        <img src="../../images/menu.png" alt="menu" onclick="togglebtn()" class="fas">

    </div>
    <div class="logo">
        <a href="../../index.php">
            <img src="../../images/logowhite.png" alt="">
        </a>
    </div>
    <ul>
        <li>
            <a href="../dashboard/" class="sidebar_element">
                <h2 class="sidebar_element">
                    Dashboard
                </h2>
            </a>
        </li>
        <li>
            <h2 class="sidebar_element">
                Profile
            </h2>
        </li>
        <li>
            <a href="../admin_listings_dashboard/" class="sidebar_element">
                <h2 class="sidebar_element">
                    Reports
                </h2>
            </a>
        </li>
        <li>
            <h2 class="sidebar_element">
                Support
            </h2>
        </li>
    </ul>
</nav>

    <style>
        .sidebar {
            display: flex;
            height: 100%;
            flex-basis: 15%;
            flex-direction: column;
            left: 0;
            justify-content: center;
            align-items: center;
            width: 100%;
            background-color: rgb(8, 8, 12);
            border-top-right-radius: 50px;
            box-shadow: 10px 0 0 50px rgb(rgb(129, 129, 129), green, blue);
        }

        .sidebar_element {
            height: auto;
            text-align: left;
            color: white;
            font-weight: 600;
            text-decoration: none;
        }

        .fas {
            display: none;
        }

        .sidebar .logo {
            width: 100%;
            height: auto;
            margin: 0;
            display: flex;
            flex-direction: column;
            left: 0;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .sidebar a {
            width: 6rem;
            height: 6rem;
            margin: 0 auto;
            height: auto;
        }

        a img {
            width: 6rem;
            height: 6rem;
            margin: 0 auto;
            cursor: pointer;
        }

        .sidebar ul {
            height: auto;
            text-align: left;
            color: white;
            font-weight: 600;
        }

        .sidebar li {
            margin-top: 4rem;
            margin-bottom: 4rem;
        }

        .sidebar li:hover {
            color: rgb(252, 153, 8);
            transition-duration: 700ms;
            cursor: pointer;
        }

        @media only screen and (max-width: 700px) {
            .sidebar {
                position: fixed;
                top: 0;
                z-index: 40;
                display: block;
                width: 100%;
                padding: 20px 0% 12% 0%;
                background: rgb(8, 8, 12);
                margin: 0 auto;
                max-height: 1%;
                overflow: hidden;
                transition: max-height 1s;
                margin-top: 0px;
                border-radius: 0;
            }
            .sidebar_element{
                font-size: 22px !important;
            }
            .sidebar a{
                text-decoration: none;
            }

            .toggleButton {
                display: flex;
                justify-content: end;
                padding-right: 40px;
            }

            .fas {
                display: inline-block;
                color: rgb(252, 153, 82);
                height: 30px;
                width: 30px;
                background: none;
                text-align: right;
                margin-bottom: 0px;
                padding-top: 0;
            }

            .hidemenu {

                max-height: 50%;
                background: rgb(8, 8, 12);
                width: 100%;

            }
            .sidebar a {
            width: 6rem;
            height: 6rem;
            margin: 0 auto;
            height: auto;
        }

        a img {
            width: 6rem;
            height: 6rem;
            margin: 0 auto;
            cursor: pointer;
        }

        .sidebar ul {
            height: auto;
            text-align: left;
            color: white;
            font-weight: 600;
        }

        .sidebar li {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        }
    </style>