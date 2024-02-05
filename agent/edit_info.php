<div class="edit_info_container" id="edit_info_container">

<style>
.edit_info_container{
    margin: 5vh 20vw;
    background-color: white;
    width: 60vw;
    border-radius: 10px;
    position: absolute;
    box-shadow: 3px 2px 22px 1px rgba(0, 0, 0, 0.24);
    display: none;

}
.edit_info_container h1{
    color: rgb(252, 153, 82);
    margin-top: 20px;
    font-size: 50px;
    text-align: center;
    font-weight: 1000;
    font-family: 'Oswald', sans-serif;
}
.edit_info_container h2{
    margin: 40px 0 0 0 ;
    font-size: 30px;
    text-align: center;
    color: rgb(252, 153, 82);
    font-weight: 600;
    font-family: 'Oswald', sans-serif;

}
.edit_info_container label{
    font-family: 'Quicksand', sans-serif;
    margin-bottom: 20px auto;
    color: rgb(8, 8, 12);
    font-weight: 600;
    text-align: left;
}
.edit_info_container form{
   margin: 15% ;
}
.edit_info_container div{
    margin-bottom: 20px;
}
.edit_info_container input{
    width: 90%;
    height: 20px;
    border: none;
    background: none;
    color: rgb(8, 8, 12);
    border-bottom: solid 1px rgba(8, 8, 12, 0.452);
}
.checkbox label {
    font-family: 'Quicksand', sans-serif;
    display: block;
    padding-left: 15px;
    text-indent: -15px;
}
.checkbox input {
    width: 13px;
    height: 13px;
    padding: 0;
    margin:0;
    vertical-align: bottom;
    position: relative;
    top: -4px;
    overflow: hidden;
    text-align: center;
  }
.radio{
    text-align: center;
}
.radio h2{
    font-family: 'Oswald', sans-serif;
    font-size: 30px;
    display: block;
    font-weight: 600;
    text-decoration: underline;
    text-decoration-color: rgb(252, 153, 82);
}
.radio label{
    font-family: 'Quicksand', sans-serif;
    text-align: center;
    font-weight: 100;
    font-size: 15px;
}
.navuni{
    text-align: center;
    width: 80%;
    margin: 40px auto;
    padding-top: 40px;
}
textarea{
    width: 100%;
    margin: 20px auto;
    height:100px;
    border-radius: 10px;
    font-size: 14px;
    border:1px solid rgb(8,8,12);
}
select{
    width: 60%;
    background-color: rgb(252, 153, 82);
    margin-top: 20px;
    height: 30px;
    border: none;
    border-radius: 10px;
    font-weight: 600;

}
a{
    text-decoration: none;
    color: rgb(252, 153, 82);
    font-weight: 300;
}
option{
    text-align: center;
    margin: 40px;
    border: none;
}
.edit_info_button{
    display: block;
    margin: 20px auto;
    width: 50%;
    padding: 10px;
    border: none;
    border-radius: 10px;
    background:rgb(252, 153, 82);
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    font-family: 'Arvo', serif;
    font-size: 20px;
    text-align: center;
    font-weight: 600;
    color: white;
}
#checkbox{
    width: 10%;
    height: 15px;
    border: none;
    background: none;
    color: rgb(8, 8, 12);
    border-bottom: solid 1px rgba(8, 8, 12, 0.452);

}
/* --footer-- */
/* for small screens */
@media only screen and (max-width:700px) {
    .edit_info_container{
        width: 95vw;
        margin: 0 2.5vw;

    }
    .edit_info_container h1{
        font-size: 32px;
        margin-top: 10vh;
        font-family: 'Oswald', sans-serif;
        height: 20px;

    }
    
    .edit_info_container input{
        width: 100%;
        border: none;
        background: none;
        color: rgb(8, 8, 12);
        border-bottom: solid 1px rgb(8, 8, 12);
    }
    .checkbox input {
        width: 13px;
        height: 13px;
        padding-left: 0;
        margin:0;
        inline-size: 20px;
        vertical-align: bottom;
        position: relative;
        top: -4px;
        overflow: hidden;
        text-align: center;
      }
    .dropdown{
        display: block;
        padding-top: 20px;
        padding-bottom: 20px;
        margin: 0 auto;
    }
    .navuni{
        margin: 0;
        padding: 0;
    }
    .navuni label{
        font-family: 'Quicksand', sans-serif;
        text-align: center;
        width: 200px;
        display: block;
    }
    .navuni select{
        background-color: rgb(252, 153, 82);
        border: none;
        border-radius: 10px;
        width: 120% ;
        height: 35px;
        font-size: 15px;
        cursor: pointer;
        outline: none;
        font-weight: 400;
    }
    .edit_info_container label{
        font-family: 'Quicksand', sans-serif;
        display: block;
        margin-bottom: 20px auto;
        color: rgb(8, 8, 12);
        font-weight: 600;
        text-align: left;
        padding-bottom: 0px 0px 0px 0px;
    }
    .edit_info_container form{
       margin: 15% ;
    }
    .edit_info_container div{
        margin-bottom: 20px;
    }
    .edit_info_container h2{
        font-size: 30px;
        text-align: center;
        text-decoration: underline;
        text-decoration-color: rgba(252, 153, 82, 0.671);
        font-family: 'Oswald', sans-serif;
    }
    .radio{
        margin: 0px 0px 40px;
    }
    .radio label{
        font-family: 'Quicksand', sans-serif;
        text-align: center;
        margin-bottom: 20px auto;
        color: rgb(8, 8, 12);
        font-weight: 600;
        font-size: 20px;
    }
    button{
        display: block;
        margin: 5px auto;
        width: 80%;
        padding: 10px;
        border: none;
        border-radius: 10px;
        background:rgb(252, 153, 82);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        font-size: 15px;
        text-align: center;
        font-weight: 500;
        font-family: 'Arvo', serif;
        transition: 0.3s all;
    }
    select{
        background-color: rgb(252, 153, 82);
        width: 60%;
        margin-top: 20px;
        height: 30px;
        border: none;
        border-radius: 10px;
        text-align: center;
    }
    option{
        text-align: center;
        margin: 40px;
        border: none;
    }
    .images input{
        border: none;
        display: none;
        font-family: 'Arvo',sans-serif, serif;
    }
    .imagepreview{
        display: grid;
        grid-template-columns: 120px 120px;
        grid-gap: 2px;
    }
    .imagepreview img{
        width: 80px;
        height: 80px;
        border-radius: 10px;
        margin: 10px;
    }
    .edit_info_button{
        width: 60vw;
        color: white;
    }

}
</style>
            <h1>Edit Home Info</h1>
           
            <form action=<?php echo $action ?> method="post" enctype="multipart/form-data">

            <div>
            <label>First-name:</label><br>
            <input type="text" name="firstname" value="<?php echo $home_row['firstname']?>" placeholder="enter name that will show on your profile" required>
            </div>

            <div>
            <label>Last-name:</label><br>
            <input type="text" name="lastname" value="<?php echo $home_row['lastname']?>" placeholder="enter last name" required>
            </div>

            <div>
            <label>Price/mnth:</label><br>
            <input type="number" min="0" name="price" value=<?php echo $home_row['price']?> placeholder="Rent per Month" required>
            </div>
            
            <div>
            <label>Location:</label><br>
            <input type="text" name="location" value=<?php echo $home_row['home_location']?> placeholder="address" required>
            </div>

            <div>
            <label>Number of people in a room:</label><br>
            <input type="number"  min="0" name="people" value=<?php echo $home_row['people_in_a_room']?> placeholder="# of people in one room " required>
            </div>

            <h2>Amenities</h2><br>
<?php
        if($home_row['kitchen'] = 1){
            $kitchen_yes = "checked";
            $kitchen_no = "";
        }else{
            $kitchen_yes = "";
            $kitchen_no = "checked"; 
        }
        if($home_row['wifi'] = 1){
            $wifi_yes = "checked";
            $wifi_no = "";
        }else{
            $wifi_yes = "";
            $wifi_no = "checked";
        }
        if($home_row['fridge'] = 1){
            $fridge_yes = "checked";
            $fridge_no = "";
        }else{
            $fridge_yes = "";
            $fridge_no = "checked";
        }
        if($home_row['borehole'] = 1){
            $borehole_yes = "checked";
            $borehole_no = "";
        }else{
            $borehole_yes = "";
            $borehole_no = "checked";
        }
        if($home_row['transport'] = 1){
            $transport_yes = "checked";
            $transport_no = "";
        }else{
            $transport_yes = "";
            $transport_no = "checked";
        }
?>
        <div class="checkbox">

            <div>
            <label>Kichen:
                <label style="font-weight:100;font: size 12px;">yes:<input type="radio" value="1" name="kitchen" <?php echo $kitchen_yes?> required></label>
                <label style="font-weight:100;font: size 12px;">no:<input type="radio" value="0" name="kitchen" <?php echo $kitchen_no?> required></label>
            </label>
            </div><br>

            <div>
            <label>Fridge: 
                <label style="font-weight:100;font: size 12px;">yes:<input type="radio" value="1" name="fridge" <?php echo $fridge_yes?> required></label>
                <label style="font-weight:100;font: size 12px;">no:<input type="radio" value="0" name="fridge" <?php echo $fridge_no?> required></label>
           </label>
            </div>

            <div>
            <label>Wifi:
                <label style="font-weight:100; font: size 12px;">yes:<input type="radio" value="1" name="wifi"  <?php echo $wifi_yes?> required></label>
                <label style="font-weight:100; font: size 12px;">no:<input type="radio" value="0" name="wifi"  <?php echo $wifi_no?> required></label>         
            </label>
            </div>

            <div>
            <label>Borehole:
                <label style="font-weight:100;font: size 12px;">yes:<input type="radio" value="1" name="borehole"  <?php echo $borehole_yes?> required></label>
                <label style="font-weight:100;font: size 12px;">no:<input type="radio" value="0" name="borehole"  <?php echo $borehole_no?> required></label>
            </label>
            </div>

            <div>
            <label>Transport:
                <label style="font-weight:100;font: size 12px;">yes:<input type="radio" value="1" name="transport"  <?php echo $transport_yes?> required></label>
                <label style="font-weight:100;font: size 12px;">no:<input type="radio" value="0" name="transport"  <?php echo $transport_no?> required></label>
            </label>
            </div>

        </div>

            <div class="navuni">
            <label for="description" >House Rules and Additional Ammenities </label>
            <textarea name="description" placeholder=" add description, rules, curfew, security-status etc" required rows="3" cols=15><?php echo $home_row['rules']?></textarea><br>

            </div>

            <div class="navuni">

                    <label>Which University Do You Want To Cater For?</h2> <br>
                        <select name="university" id="dropdown"  required>

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

                        <option value="GIRLs">GIRLS BORDING HOUSE</option>
                        <option value="BOYS">BOYS BORDING HOUSE</option>
                        <option value="MIXED">BOYS/GIRLS</option>
                        
                    </select>                
                    </label>
                </div>

                <div>
                    
                <label for="checkbox" class="terms"><input type="checkbox" id="checkbox" required> <a href="terms_of_service.html">I hereby accept all the terms and conditions</a> <span style="color: red; font-size:10px;">*</span></label>


                </div>
            <button type="submit" class="edit_info_button" name="edit_home">edit home info</button>
            <button type="button" class="edit_info_button" name="cancel" onclick="close_edit()">cancel</button>


        </form>
    </div>

    </div>
