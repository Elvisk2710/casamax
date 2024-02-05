<?php
session_start();
require './required/ads_query.php';
require_once 'homerunphp/advertisesdb.php';
require_once 'homerunphp/advertisescript.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php
    require './required/header.php';
?>
    <link rel="icon" href="images/logowhite.png">
    <title>CasaMax Advertise</title>
    <link rel="stylesheet" href="advertise.css">

</head>


<body onunload="" class="scrollable">

<?php
    require_once 'required/pageloader.php';
?>    
        <header>
           <a href="index.php"><img src="images/logoblack.png" alt="logo" height="80px" width="100px" class="logo"></a>
        </header>

    <div class="container">
            <h1>Edit Your Profile</h1>

            <form action="homerunphp/advertisescript.php" method="post" enctype="multipart/form-data">

            <div>
            <label>First-name:</label><br>
            <input type="text" name="firstname" placeholder="enter name that will show on your profile" required>
            </div>

            <div>
            <label>Last-name:</label><br>
            <input type="text" name="lastname" placeholder="enter last name" required>
            </div>

            <div>
            <label>Contact:</label><br>
            <input type="number"  min="0" name="phone" placeholder="enter phone-number" required>
            </div>

            <div>
            <label>Email:</label><br>
            <input type="email" name="email" placeholder="email@email.com" required>
            </div>

            <div>
            <label>ID-Number:</label><br>
            <input type="text" name="idnum"  min="0" placeholder="Enter your Id number" required>
            </div>

            <div>
            <label>Price/mnth:</label><br>
            <input type="text" name="price" placeholder="Rent per Month" required>
            </div>

            <div>
            <label>Rooms available:</label><br>
            <input type="number" name="rooms" placeholder="# of availabel rooms" required>
            </div>

            <div>
            <label>Address:</label><br>
            <input type="text" name="address" placeholder="address" required>
            </div>

            <div>
            <label>Number of people:</label><br>
            <input type="number"  min="0" name="people" placeholder="# of people in one house " required>
            </div>

            <h2>Amenities</h2><br>

        <div class="checkbox">

            <div>
            <label>Kichen:
                <label style="font-weight:100;font: size 12px;">yes:<input type="radio" value="Kitchen" name="kitchen" required></label>
                <label style="font-weight:100;font: size 12px;">no:<input type="radio" value="" name="kitchen" required></label>
            </label>
            </div><br>

            <div>
            <label>Fridge: 
                <label style="font-weight:100;font: size 12px;">yes:<input type="radio" value="Fridge" name="fridge" required></label>
                <label style="font-weight:100;font: size 12px;">no:<input type="radio" value="" name="fridge" required></label>
           </label>
            </div>

            <div>
            <label>Wifi:
                <label style="font-weight:100; font: size 12px;">yes:<input type="radio" value="Wifi" name="wifi" required></label>
                <label style="font-weight:100; font: size 12px;">no:<input type="radio" value="" name="wifi" required></label>         
            </label>
            </div>

            <div>
            <label>Borehole:
                <label style="font-weight:100;font: size 12px;">yes:<input type="radio" value="Borehole" name="borehole" required></label>
                <label style="font-weight:100;font: size 12px;">no:<input type="radio" value="" name="borehole" required></label>
            </label>
            </div>

        </div>

            <div class="radio">
            <h2>Rental Type</h2><br>

            <label for="bording-house" > Bording-House</label>
            <input type="radio" id="bording-house" name="rentaltype" value="bordinghouse"  required><br>

            <label for= "commercial-space"> Commercial-Space </label>
            <input type="radio" id="commercial-space" name="rentaltype" value="commercialspace" required><br>

            <label for= "full-house"> Full-House </label>
            <input type="radio" id="full-house" name="rentaltype" value="fullhouse" required<br>

            </div>

            <div class="navuni">

                    <label>Which University Do You Want To Cater For?</h2> <br>
                        <select name="university" id="dropdown"  required>

                        <option value="none">--Not for university students--</option>
                        <option value="University of Zimbabwe">University of Zimbabwe</option>
                        <option value="Midlands State University">Midlands State University</option>
                        <option value="Africa Univeristy">Africa Univeristy</option>
                        <option value="Bindura State University">Bindura State University</option>
                        <option value="Chinhoyi University of Science and Technology">Chinhoyi University of Science and Technology</option>
                        <option value="Great Zimbabwe University">Great Zimbabwe University</option>
                        <option value="Harare Institute of Technology">Harare Institue of Technology</option>
                        <option value="National University of Science and Technology">National University of Science and Technology</option>

                    
                    </select>                
                     </label>

                   
                   
                </div>
                <div class="navuni">

                    <label>Gender Basis</h2> <br>
                        <select name="gender" id="dropdown"  required>

                        <option value="GIRL">GIRLS BORDING HOUSE</option>
                        <option value="BOYS">BOYS BORDING HOUSE</option>
                        <option value="BOTH">BOYS/GIRLS</option>
                        
                    </select>                
                    </label>
                </div>
            
            <button type="submit" name="create_profile">Apply Edits</button>

        </div>

        </form>
    </div>

<?php

require_once 'required/footer.php';

?>
        <script src="jsfiles/onclickscript.js"></script>

</body>
</html>