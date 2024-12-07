<div onunload="" class="admin_advertise_form" id="admin_advertise_form">

    <div class="admin_advertise_container">
        <h1>Create Profile</h1>

        <form action="../../homerunphp/admin_advertise_script.php" method="post" enctype="multipart/form-data" onsubmit="submitFn()">

            <div id="tab">
                <div>
                    <label>Admin ID: <?php echo $row['admin_id'] ?></label><br>
                </div>
                <h2>
                    Personal Details
                </h2>
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
                    <input type="number" min="0" name="phone" placeholder="enter phone-number" required>
                </div>

                <div>
                    <label for="upword">Password<span style="color: red; font-size:10px;">*</span></label>
                    <input type="password" id="pword" name="password" placeholder="Enter your Password" required>
                </div>

                <div>
                    <label for="upword">Confirm Password<span style="color: red; font-size:10px;">*</span></label>
                    <input type="password" id="cpword" name="confirmpassword" placeholder="Enter your Password" required>
                </div>

                <div>
                    <label>Email:</label><br>
                    <input type="email" name="email" placeholder="email@email.com" required>
                </div>

                <div>
                    <label>ID-Number:</label><br>
                    <input type="text" name="idnum" min="0" placeholder="Enter your Id number">
                </div>

            </div>
            <div id="tab">
                <h2>
                    Home Details
                </h2>

                <div>
                    <label>Price/mnth:</label><br>
                    <input type="number" min="0" name="price" id="price" placeholder="Rent per Month" required>
                </div>
                <div>
                    <label>Address:</label><br>
                    <input type="text" name="address" id="address" placeholder="address" required>
                </div>
                <div>
                    <label>Number of people in a room:</label><br>
                    <input type="number" min="0" name="people" id="people" placeholder="# of people in one room " required>
                </div>

                <h2>Amenities</h2><br>

                <div class="amenities">

                    <div class="left_amenities">
                        <div>
                            <label>Kichen:
                                <div class="amenities_radio"><label style="font-weight:100;font: size 12px;"><input type="checkbox" value="1" name="kitchen"></label></div>
                            </label>
                        </div>

                        <div>
                            <label>Fridge:
                                <div class="amenities_radio"><label style="font-weight:100;font: size 12px;"><input type="checkbox" value="1" name="fridge"></label></div>
                            </label>
                        </div>

                        <div>
                            <label>Wifi:
                                <div class="amenities_radio"><label style="font-weight:100; font: size 12px;"><input type="checkbox" value="1" name="wifi"></label></div>
                            </label>
                        </div>

                    </div>

                    <div class="right_amenities">
                        <div>
                            <label>Borehole:
                                <div class="amenities_radio"><label style="font-weight:100;font: size 12px;"><input type="checkbox" value="1" name="borehole"></label></div>
                            </label>
                        </div>

                        <div>
                            <label>Transport:
                                <div class="amenities_radio"><label style="font-weight:100;font: size 12px;"><input type="checkbox" value="1" name="transport"></label></div>
                            </label>
                        </div>

                    </div>
                </div>

                <div class="navuni">
                    <label for="description">House Rules and Additional Ammenities </label>
                    <textarea name="description" id="description" placeholder=" add description, rules, curfew, security-status etc" required rows="3" cols=15></textarea><br>

                </div>

                <div class="navuni">

                    <label>Which University Do You Want To Cater For?</h2> <br>
                        <select name="university" id="uni_dropdown" required>
                            <option value="">Choose University</option>
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
                        <select name="gender" id="gender_dropdown" required>
                            <option value="">Choose A Gender</option>
                            <option value="GIRLS">GIRLS BORDING HOUSE</option>
                            <option value="BOYS">BOYS BORDING HOUSE</option>
                            <option value="MIXED">BOYS/GIRLS</option>

                        </select>
                    </label>
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
                            <img title="Choose an Image" src="../../images/addimage.png" accept="image/png, image/jpeg" id="image1" onclick="triggerClick()">
                            <input type="file" id="inputimage1" name="image[]" multiple>
                            <br>
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
                            <img title="Choose an Image" src="../../images/addimage.png" accept="image/png, image/jpeg, .doc,.docx,.wordprocessingml.document" id="image2" onclick="triggerClick2()">
                            <input type="file" id="inputimage2" name="identityImage">
                            <br>
                        </div>
                    </div>
                    <br>
                    <h4>
                        Add Proof of Residency
                    </h4>
                    <div class="imagepreview">
                        <div>
                            <img title="Choose an Image" src="../../images/addimage.png" id="image3" accept="image/png, image/jpeg, .doc,.docx,/msword,.formats-officedocument.wordprocessingml.document" onclick="triggerClick3()">
                            <input type="file" id="inputimage3" name="residencyImage">
                            <br>
                        </div>
                    </div>

                </div>
                <div>

                    <label for="checkbox" class="checkbox">
                        <input type="checkbox" id="checkbox" required>
                        <a href="../../terms_of_service.html">I hereby accept all the terms and conditions</a>
                        <span style="color: red; font-size:10px;">*</span>
                    </label>


                </div>
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

<script src="../../jsfiles/onclickscript.js"></script>

</div>