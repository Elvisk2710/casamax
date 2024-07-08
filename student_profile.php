<?php
session_start();
require './required/ads_query.php';
if (empty($_SESSION['sessionstudent'])) {
    header("Location:login.php?PleaseLogin");
    echo '<script type="text/javascript"> alert("You Have To Login First") </script>';
    exit();
} else {
    $user = $_SESSION['sessionstudent'];
    require_once 'homerunphp/advertisesdb.php';
    $sql = "SELECT * FROM  homerunuserdb WHERE userid = '$user' ";

    setcookie("update", $user, time() + (86400 * 1), "/");
}

if ($rs_result = mysqli_query($conn, $sql)) {
    $row = mysqli_fetch_array($rs_result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require './required/header.php';
    ?>
    <meta name="description" content="Login and enjoy vast options of homes to choose for your off-campus accommodation">
    <link rel="icon" href="images/logowhite.png">
    <link rel="stylesheet" href="profile.css">
    <title>My Profile</title>
</head>


<body onunload="" class="scrollable">

    <?php
    require_once 'required/pageloader.php';
    ?>

    <header>

        <a href="index.php"><img src="images/logowhite.png" alt="logo" class="logo"></a>

        <h1>
            Hey <?php echo ucfirst($row['firstname']) . '!'; ?>
        </h1>
    </header>

    <div class="container">
        <div class="house-info">
            <h2>YOUR STUDENT INFO</h2>
        </div>
        <br>
        <div class="address">
            <div class="address_info">
                <h3>FIRSTNAME</h3>
                <p><?php echo ucfirst($row['firstname']) ?></p>
            </div>

            <div class="address_info">
                <h3>LASTNAME</h3>
                <p><?php echo ucfirst($row['lastname']) ?></p>
            </div>

            <div class="address_info">
                <h3>D.O.B</h3>
                <p><?php echo ucfirst($row['dob']) ?></p>
            </div>

            <div class="address_info">
                <h3>SEX</h3>
                <p><?php echo ucfirst($row['sex']) ?></p>
            </div>

            <div class="address_info">
                <h3>UNIVERSITY</h3>
                <p><?php echo ucfirst($row['university']) ?></p>
            </div>


            <div class="address_info">
                <h3>PHONE</h3>
                <p><?php echo '0' . ucfirst($row['contact']) ?></p>
            </div>

            <div class="address_info">
                <h3>EMAIL</h3>
                <p><?php echo ucfirst($row['email']) ?></p>
            </div>

        </div>

        <div class="edit">
            <button type='button' class='edit-btn' onclick="openForm()">Edit My info</button>
        </div>

        <form action="homerunphp/action_page.php" method="POST">
            <div class="edit">
                <button style="background-color: white;" type='submit' class='edit-btn' name="student_logout">Log-Out</button>
            </div>
        </form>


        <div id="popup">
            <div class="background">
                <div class="form-popup" id="myForm">

                    <form action="homerunphp/action_page.php" class="form-container" method="POST">
                        <h1>Edit Info</h1>

                        <div class="input-label">

                            <label for="uname">First-Name <span style="color: red; font-size:10px;">*</span></label>
                            <input title="Enter Your First Name" type="text" id="frstnme" name="firstname" placeholder="Enter your First-Name" required>

                        </div>
                        <div class="input-label">
                            <label for="uname">Last-Name <span style="color: red; font-size:10px;">*</span></label>
                            <input title="Enter Your Larst Name" type="text" id="lstnme" name="lastname" placeholder="Enter your Last-Name" required>

                        </div>

                        <div class="input-label">

                            <label title="Choose Your University" class="dropdown"> University<span style="color: red; font-size:10px;">*</span>
                                <select name="university" id="dropdown">

                                    <option value="University of Zimbabwe">University of Zimbabwe</option>
                                    <option value="Midlands State University">Midlands State University</option>
                                    <option value="Africa Univeristy">Africa Univeristy</option>
                                    <option value="Bindura State University">Bindura State University</option>
                                    <option value="Chinhoyi University of Science and Technology">Chinhoyi University of Science and Technology</option>
                                    <option value="Great Zimbabwe University">Great Zimbabwe University</option>
                                    <option value="Harare Institute of Technology">Harae Institue of Technology</option>
                                    <option value="National University of Science and Technology">National University of Science and Technology</option>


                                </select>
                            </label>

                        </div>
                        <div class="input-label">
                            <label for="dob">DOB<span style="color: red; font-size:10px;">*</span></label>
                            <input title="Enter Your Date Of Birth" type="date" id="dob" name="dob" placeholder="Enter Date of Birth" required>

                        </div>
                        <div class="radio">

                            <span>
                                <label for="male" class="man">Male<span style="color: red; font-size:10px;">*</span></label>
                                <input type="radio" id="male" value="M" name="gender">

                                <label for="female" class="woman">Female<span style="color: red; font-size:10px;">*</span></label>
                                <input type="radio" id="female" value="F" name="gender">
                            </span>

                        </div>

                        <div class="input-label">

                            <label for="phone">Contact<span style="color: red; font-size:10px;">*</span></label>
                            <input title="Enter Your Phone Number" min="0" type="number" id="phone" name="contact" placeholder="Enter Contact" required>

                        </div>

                        <button type="submit" name="student_submit" class="btn">Submit</button>
                        <button type="button" class="btn cancel" onclick="closeForm()">Cancel</button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            // edit info onclick
            function openForm() {
                document.getElementById("myForm").style.display = "block";
            }

            function closeForm() {
                document.getElementById("myForm").style.display = "none";
            }
        </script>