<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require '../required/header.php';
    ?>
    <meta name="description" content="Enjoy free advertising on CasaMax and make extra cash with shared spaces. Rent out your spare room, cottage, etc. to students in just a few simple steps">
    <meta name="description" content="Advertise your boarding house for students to view it and get in touch with you for enquiries">
    <link rel="icon" href="../images/logowhite.png">
    <title>CasaMax Advertise</title>
    <link rel="stylesheet" href="advertise.css">
</head>

<body onunload="" class="scrollable">

    <?php
    require_once '../required/pageloader.php';
    ?>
    <div class="container">
        <!-- <h1>Create Your Profile</h1>
        <p>
            Are you a landlord with multiple houses?     Click <a href="../agent/agent_register.php">here to sign up as an agent instead</a>
        </p> -->
        <div class="advertise-container">
            <div class="left-advertise">
            <lottie-player
                    src="https://lottie.host/12be720b-5ba7-4989-a48d-1cbd6de19286/qAUt599WBl.json"
                    background="transparent"
                    speed="1"
                    style="width: 90%; height: 90%;"
                    loop
                    autoplay>
                </lottie-player>
            </div>
            <div class="right-advertise">
                <form action="../homerunphp/advertisescript.php?new_user=true" method="post" enctype="multipart/form-data" id="admin_advertise_form">

                    <div id="tab">
                        <h1>
                            Personal Details
                        </h1>
                        <div class="input-div">
                            <div>
                                <label>First-name:</label>
                                <input type="text" name="firstname" placeholder="enter name that will show on your profile" required>
                            </div>

                            <div>
                                <label>Last-name:</label>
                                <input type="text" name="lastname" placeholder="enter last name" required>
                            </div>
                        </div>
                        <div class="input-div">
                            <div>
                                <label>Contact:</label>
                                <input type="number" min="0" name="phone" placeholder="enter phone-number" required>
                            </div>

                            <div>
                                <label for="upword">Password</label>
                                <input type="password" id="pword" name="password" placeholder="Enter your Password" required>
                            </div>
                        </div>
                        <div class="input-div">
                            <div>
                                <label for="upword">Confirm Password</label>
                                <input type="password" id="cpword" name="confirmpassword" placeholder="Enter your Password" required>
                            </div>

                            <div>
                                <label>Email:</label>
                                <input type="email" name="email" placeholder="email@email.com" required>
                            </div>
                        </div>
                        <div class="input-div">
                            <div>
                                <label>ID-Number:</label>
                                <input type="text" name="idnum" min="0" placeholder="Enter your Id number " required>
                            </div>
                        </div>
                    </div>
                    <div id="tab">
                        <h1>
                            Home Details
                        </h1>
                        <div class="input-div">
                            <div>
                                <label>Price/mnth:</label>
                                <input type="number" min="0" name="price" id="price" placeholder="Rent per Month" required>
                            </div>
                            <div>
                                <label>Number of people in a room:</label>
                                <input type="number" min="0" name="people" id="people" placeholder="# of people in one room " required>
                            </div>
                        </div>
                        <div class="input-div">
                            <div>
                                <label>Address:</label>
                                <input type="text" name="address" id="address" placeholder="address" required>
                            </div>
                        </div>
                        <label>Amenities</label>

                        <div class="amenities">
                            <div class="left_amenities">
                                <div>
                                    <label>Kichen: </label>
                                    <div class="amenities_radio"><label style="font-weight:100;font: size 12px;"><input type="checkbox" value="1" name="kitchen"></label></div>

                                </div>

                                <div>
                                    <label>Fridge: </label>
                                    <div class="amenities_radio"><label style="font-weight:100;font: size 12px;"><input type="checkbox" value="1" name="fridge"></label></div>

                                </div>
                                <div>
                                    <label>Wifi: </label>
                                    <div class="amenities_radio"><label style="font-weight:100; font: size 12px;"><input type="checkbox" value="1" name="wifi"></label></div>

                                </div>

                            </div>

                            <div class="right_amenities">
                                <div>
                                    <label>Borehole: </label>
                                    <div class="amenities_radio"><label style="font-weight:100;font: size 12px;"><input type="checkbox" value="1" name="borehole"></label></div>

                                </div>

                                <div>
                                    <label>Transport: </label>
                                    <div class="amenities_radio"><label style="font-weight:100;font: size 12px;"><input type="checkbox" value="1" name="transport"></label></div>

                                </div>

                            </div>
                        </div>

                        <div class="desc-div">
                            <label for="description">House Rules and Additional Ammenities </label>
                            <textarea name="description" id="description" placeholder=" add description, rules, curfew, security-status etc" required rows="2" cols=15></textarea>

                        </div>
                        <div class="navuni">
                            <label>Which University Do You Want To Cater For?</label>
                                <select name="university" id="uni_dropdown" required>
                                    <option value="">Choose University</option>
                                    <option value="University of Zimbabwe">University of Zimbabwe</option>
                                    <option value="Midlands State University">Midlands State University</option>
                                    <option value="Africa Univeristy">Africa Univeristy</option>
                                    <option value="Bindura State University">Bindura State University</option>
                                    <option value="Chinhoyi University of Science and Technology">Chinhoyi University of Science
                                        and Technology</option>
                                    <option value="Great Zimbabwe University">Great Zimbabwe University</option>
                                    <option value="Harare Institute of Technology">Harare Institue of Technology</option>
                                    <option value="National University of Science and Technology">National University of Science
                                        and Technology</option>
                                </select>
                        </div>
                        <div class="navuni">
                            <label>Gender Basis</label>
                            <select name="gender" id="gender_dropdown" required>
                                <option value="">Choose A Gender</option>
                                <option value="GIRLS">GIRLS BORDING HOUSE</option>
                                <option value="BOYS">BOYS BORDING HOUSE</option>
                                <option value="MIXED">BOYS/GIRLS</option>
                            </select>
                        </div>
                    </div>

                    <div id="tab">
                        <h2>
                            Add House Images
                        </h2>

                        <div class="images">
                            <p>(best represented in landscape view)</p>

                            <div class="imagepreview">

                                <div>
                                    <img title="Choose an Image" src="../images/addimage.png" id="image1" onclick="triggerClick()">
                                    <input type="file" id="inputimage1" name="image[]" multiple accept="image/jpeg, image/png, image/heif, image/heif-sequence" onchange="displayImage(this)">

                                    <h3 style="color: rgb(8, 8, 12);">
                                        Add Upto 8 Images
                                    </h3>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div id="tab">
                        <h2>
                            Verification Documents
                        </h2>
                        <p>
                            We need to verify that you are the owner of the house being listed. To do so we need:
                        </p>
                        <ol>
                            <li>
                                proof of identity (National ID or Passport)
                            </li>
                            <li>
                                proof of residency (with matching name)
                            </li>
                        </ol>
                        <div class="images">
                            <h4>
                                Add Proof of Identity
                            </h4>
                            <div class="imagepreview">
                                <div>
                                    <img title="Choose an Image" src="../images/addimage.png" id="image2" onclick="triggerClick2()">
                                    <input type="file" id="inputimage2" name="identityImage" accept="image/jpeg, image/png, image/heif, image/heif-sequence" onchange="displayImage2(this)">

                                </div>
                            </div>

                            <h4>
                                Add Proof of Residency
                            </h4>
                            <div class="imagepreview">
                                <div>
                                    <img title="Choose an Image" src="../images/addimage.png" id="image3" onclick="triggerClick3()">
                                    <input type="file" id="inputimage3" name="residencyImage" accept="image/jpeg, image/png, image/heif, image/heif-sequence" onchange="displayImage3(this)">

                                </div>
                            </div>

                        </div>
                        <div>

                            <label for="checkbox" class="checkbox">
                                <input type="checkbox" id="checkbox" required>
                                <a href="../../terms_of_service.html">I hereby accept all the terms and conditions</a>

                            </label>


                        </div>
                    </div>
                    <div>
                    </div>
                    <div>
                        <div class="prevNext">
                            <button type="button" id="cancelBtn" onclick="CloseAddListingForm()">Cancel</button>
                            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                            <button type="submit" id="submit" onclick="nextPrev(2)" name="create_profile">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script src="../jsfiles/onclickscript.js"></script>
</body>

</html>