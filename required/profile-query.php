<?php

while ($row = mysqli_fetch_array($result)){            
    echo "<h1>My Profile</h1>";

    echo "<img src='images/UZ.png' class='profile-pic'>";

    echo "<h1 class= 'yourname'>".$row['firstname'] ." " .$row['lastname'] . "</h1>
    <div class='social_media'>
    <div>
        <label><img src='images/whatsapp.png' height='20px' width='20px'>" . $row['contact'] . "</label>
    </div>
    <div>
        <label><img src='images/mail.png' height='20px' width='20px'>" . $row['email'] . "</label>
    </div>
    </div>

    <div class='profile-bottom'>


    </div>
</div>

</div>
<div class='right-profile'>

<div class='house-box'>

    <hr>

    <h2>Your House Info</h2>

    <hr>
    <div>
    <label for=rooms'> Number of rooms:</label>
    <label id='rooms' class='info'>" . $row['rooms'] . "</label>
    </div>         
    <div>
    <label for='price'>Price:</label>
    <label id='price' class='info'> $" . $row['price'] . "/month</label>
    </div>     
    <div>
    <label for='address'>Address:</label>
    <label id='address' class='info'>" . $row['adrs'] . "</label>
    </div>
    <br>
    ";
}


?>