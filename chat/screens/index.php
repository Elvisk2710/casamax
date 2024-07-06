<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa Chat</title>
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>
    <div class="container">
        <?php include '../components/header.php'; ?>
        <div class="search">
            <div class="search_bar">
                <input type="text" placeholder="Search By Name">
            </div>
            <div class="search_icon">
            <img src="../../images/searchicon.webp" alt="search icon">
            </div>
        </div>
        <div class="chat_list_container">
            <div class="chat_list">
                <a href="./chat_dm.php">
                <div class="chat_element_container">
                    <div class="chat_details">
                    <div class="chat_img">
                        <img src="../../images/background2.jpg" alt="">
                    </div>
                    <div class="chat_info">
                        <div class="chat_name">
                            <h2>
                                Elvis Kadeya
                            </h2>
                        </div>
                        <div class="chat_msg">
                            This is the last message
                        </div>
                    </div>
                    </div>
                    <div class="online_status">
                        <div class="online_status_icon">
                            Active
                        </div>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
</body>

</html>