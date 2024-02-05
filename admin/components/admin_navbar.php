<div class="sidebar">
    <div class="logo">
        <a href="../../index.php">
            <img src="../../images/logowhite.png" alt="">
        </a>
    </div>
    <ul>
        <li>
            <h2 class="sidebar_element">
                Dashboard
            </h2>
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
</div>

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
    .sidebar_element{
        height: auto;
        text-align: left;
        color: white;
        font-weight: 600;
        text-decoration: none;
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
</style>