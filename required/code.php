<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../signup.css">
    <meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT">
    <meta http-equiv="pragma" content="no-cache">
    <title>Verification Code</title>

</head>

<body onunload="" class="scrollable">
    <div class="container">
        <div class="right-login">
            <div class="fpass-container">
                <header>
                    <a href="index.php">
                        <img src="../images/logoorange.png" alt="logo" class="logo">
                    </a>
                </header>
                <h4> Email has been sent to <?php echo $_COOKIE['email']; ?></h4>

                <p>Can not find Code? Check in the spam folder</p>
                <form action="../homerunphp/fpassscript.php" method="post">
                    <div class="input-label">
                        <label for="code">Enter Code<span style="color: red; font-size:10px;">*</span></label>
                        <input type="number" id="phone" placeholder="Enter Code" name="code" min="0" required title="Enter your code">

                    </div>

                    <div class="login">
                        <button type="submit" name="submit_code" class="login_btn">
                            UPDATE
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>