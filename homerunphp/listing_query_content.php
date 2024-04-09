<?php
echo"<div class='house'>";
                    echo"<div class='house-img'>";

                    echo "<a href='../listingdetails.php' onclick='GetName(this.id)' id = '" .$row['email']. "'><img src='../housepictures/$folder/".$row['image1']."'></a>";

                    echo "</div>";

                    echo "<div class='house-info'>"
                            . $row['gender']." Boarding House <br>
                            <h3 style = 'color: rgb(252, 153, 82);'>Amenities</h3>";

                            if($row['kitchen'] == "1"){
                                $kitchen = "kitchen-";
                            }else{
                                $kitchen = "No kitchen- ";
                            }
                            if($row['fridge'] == "1"){
                                $fridge = "Fridge- ";
                            }else{
                                $fridge = "No Fridge- ";
                            }
                            if($row['wifi'] == "1"){
                                $wifi = "wifi- ";
                            }else{
                                $wifi = "No wifi- ";
                            }
                            if($row['borehole'] == "1"){
                                $borehole = " borehole ";
                            }else{
                                $borehole = " No borehole";
                            }

                    echo "<p>" . $kitchen. $fridge. $wifi. $borehole ."</p>
                            <h3>";
                    echo " <div class='house-price'>
                            <p>". $row['peopleneeded'] ."guest</p>
                            <h4>";
                    echo $row['price'] . "<span>/ month</span>";
                    echo " </h4>
                            </div>";
                    echo "</div>";

