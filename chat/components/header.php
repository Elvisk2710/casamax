<style>
    * {
    }

    .header {
        width: 100%;
        height: 80px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        background-color: rgb(8, 8, 12);
        border-radius: 5px;
        border-bottom: 0;
    }

    .header_img {
        height: 100%;
        padding: 20px;
        width: 30%;
        display: flex;
        justify-content: center;
        justify-items: center;
        align-items: center;

    }

    .header_img img {
        width: 50px;
        height: 50px;
        border-radius: 50px;
    }

    .header_info {
        display: flex;
        flex-direction: column;
        justify-content: center;
        justify-items: center;
        align-items: center;
        width: fit-content;
        height: 100%;
        width: 30%;

    }

    .name {
        display: flex;
        flex-direction: row;
        gap: 10px;
        height: fit-content;
    }

    h2 {
        margin: 0;
        padding: 0;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .name {
        color: white;
    }

    p {
        margin: 0;
        padding: 0;
        font-size: 12px;
        font-weight: 200;
        color: rgb(252, 153, 82);
    }

    .logout {
        padding: 0 5%;
        height: 100%;
        align-items: center;
        width: 30%;
    }

    .logout_form {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        justify-items: center;
        align-items: center;
    }

    .logout_form button {
        width: 80%;
        max-width: 100px;
        height: fit-content;
        border: none;
        border-radius: 10px;
        text-align: center;
        padding: 5px 5px;
        font-weight: 600;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        transition: 0.3s all;
        color: white;
        text-align: center;
        background-color: rgb(252, 153, 82);
        cursor: pointer;
        transition: 300ms all;

    }
    button:active{
        transform: scale(0.95);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
    }
    @media only screen and (max-width: 600px){
    .header {
        border-radius: 0;
    }
    }
</style>
<div class="header">
    <div class="header_img">
        <img src="../../images/background2.jpg" alt="">
    </div>
    <div class="header_info">
        <div class="name">
            <div class="name_value">
                <h2>
                    Elvis
                </h2>
            </div>
            <div class="name_value">
                <h2>
                    Kadeya
                </h2>
            </div>
        </div>
        <div class="status">
            <p>
                Active Now
            </p>
        </div>
    </div>
    <div class="logout">
        <form action="" class="logout_form">
            <button class="logout_btn">
                Log Out
            </button>
        </form>
    </div>
</div>