        <div onunload="" class="admin_add_agent_form" id="admin_add_agent_form">
            <div class="admin_advertise_container">

                <h1>Create Your Profile</h1>

                <form action="../../homerunphp/admin_add_admin_script.php" method="POST" id="admin_add_admin_form">

                    <h2>
                        Agent Details
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
                        <label for="upword">Access Level<span style="color: red; font-size:10px;">*</span></label>
                        <input type="number" id="access_level" min="0" name="access_level" placeholder="Enter access Level" required>
                    </div>

                    <div>
                        <label for="upword">Address<span style="color: red; font-size:10px;">*</span></label>
                        <input type="text" id="address" name="address" placeholder="Enter Address" required>
                    </div>

                    <div>
                        <label>Email:</label><br>
                        <input type="email" name="email" placeholder="email@email.com" required>
                    </div>

                    <div>
                        <label>ID-Number:</label><br>
                        <input type="text" name="idnum"  placeholder="Enter your Id number" required>
                    </div>

                    <div>
                        <label>DOB:</label><br>
                        <input type="date" name="dob" placeholder="Date Of Birth" required>
                    </div>
                    <div class="gender_container">
                        <label>Gender:</label><br>
                        <div class="gender">
                            <label for="male">Male</label>
                            <input type="radio" class="radio_btn" id="male" name="gender" value="M" required>
                        </div>
                        <div class="gender">
                            <label for="female">Female</label>
                            <input type="radio" class="radio_btn" id="female" name="gender" value="F" required>
                        </div>
                    </div>
                    <div class="add_admin_form_buttons">
                        <div>
                            <button type="submit" id="admin_create_profile" name="admin_create_profile">Submit</button>
                        </div>
                        <div>
                            <button type="button" id="cancelBtn" onclick="CloseAddAddAgent()">Cancel</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>