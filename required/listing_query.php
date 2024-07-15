<?php


if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $url = "https://";
else
    $url = "http://";
// Append the host(domain name, ip) to the URL.   
$url .= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL   
$url .= $_SERVER['REQUEST_URI'];

?>
<div class="filter_div">
    <button class="filter_button" onclick="openFilter()">
        <img src="../images/filter.png" alt="open filter">
        <h3>
            Filters
        </h3>
    </button>
</div>

<script>
       function openFilter() {
          console.log("openFilter() called");
          const sidebarElement = document.querySelector(".sidebar");
          if (sidebarElement) {
               sidebarElement.style.display = "block";
          } else {
               console.error("Element with class 'sidebar' not found.");
          }
     }
</script>

<?php
$num_per_page = 8;
$kitchen_query = '';
$wifi_query = '';
$borehole_query = '';
$fridge_query = '';
$transport_query = '';
$gender_query = '';
$price_query = '';
$kitchen_url = "";
$wifi_url = "";
$borehole_url = "";
$transport_url = "";
$price_url = "";
$fridge_url = "";
$gender_url = "";
// reset filter

if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}
$start_from = ($page - 1) * 8;

// query for search
if (isset($_GET['price']) and ($_GET['filter'] == "search")) {
    $pricesearch = $_GET['price'];
    $sql_num = "SELECT * FROM  homerunhouses WHERE uni = '$university' and available = '1' and price <= '$pricesearch'";
    $sql = "SELECT * FROM  homerunhouses WHERE uni = '$university' and available = '1' and price <='$pricesearch' ORDER BY id DESC LIMIT $start_from,$num_per_page";
    $price_url = "&filter=search&price=$pricesearch";
} else {
    if (isset($_GET['kitchen'])) {
        $kitchen_query = "and kitchen = '1'";
        $kitchen_url = "&kitchen=1";
    }
    if (isset($_GET['wifi'])) {
        $wifi_query = "and wifi = '1'";
        $wifi_url = "&wifi=1";
    }
    if (isset($_GET['borehole'])) {
        $borehole_query = "and borehole = '1'";
        $borehole_url = "&borehole=1";
    }
    if (isset($_GET['fridge'])) {
        $fridge_query = "and fridge = '1'";
        $fridge_url = "&fridge=1";
    }
    if (isset($_GET['transport'])) {
        $transport_query = "and transport = '1'";
        $transport_url = "&transport=1";
    }
    if (isset($_GET['price'])) {
        $pricesearch = $_GET['price'];
        $price_query = "and price <= '$pricesearch'";
        $price_url = "&filter=search&price=$pricesearch";
    }
    if (isset($_GET['gender'])) {
        $gender = $_GET['gender'];
        $gender_url = "&gender=" . $gender;
        if ($gender == 'girls') {
            $gender_query = "and gender = 'girls'";
        } elseif ($gender == 'boys') {
            $gender_query = "and gender = 'boys'";
        } elseif ($gender == 'mixed') {
            $gender_query = "and gender = 'mixed'";
        }
    }

    $sql = "SELECT * FROM homerunhouses WHERE uni = '$university' AND available = '1' $kitchen_query $wifi_query $borehole_query $fridge_query $transport_query $gender_query $price_query ORDER BY id DESC LIMIT $start_from, $num_per_page";
    $sql_num = "SELECT * FROM  homerunhouses WHERE uni = '$university' and available = '1' $kitchen_query $wifi_query  $borehole_query $fridge_query $transport_query $gender_query $price_query";
}
$filter_url = $kitchen_url . $wifi_url . $borehole_url . $transport_url . $fridge_url . $price_url . $gender_url;
$num_result = mysqli_query($conn, $sql_num);
$total_records = mysqli_num_rows($num_result);
$result = mysqli_query($conn, $sql);


echo "<h3 style = 'color: rgba(252, 153, 82, 1); Font-weight = 800;'>" . $total_records . " Options Found Near " . $university . "</h3>";

while ($row = mysqli_fetch_array($result)) {
    if (!empty($row['agent_id'])) {
        $agent_id = $row['agent_id'];
        $sql_agent = "SELECT * FROM agents WHERE agent_id = '$agent_id'";
        if ($agent_result = mysqli_query($conn, $sql_agent)) {
            $agent = true;
            $row_agent = mysqli_fetch_array($agent_result);
        }
    } else {
        $agent = false;
    }

    if ($row['available'] == 1) {
        $currentPageUrl = 'https%3A%2F%2F' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $home_url = $currentPageUrl . "%23div" . $row['home_id'];

        echo "<div class='house' id=div" . $row['home_id'] . ">";
        echo "<div class='house-img'>";
        if (empty($row['image1'])) {
            echo "<a href='../listingdetails.php?clicked_id=" . $row['home_id'] . "' onclick='GetName(this.id)' id = '" . $row['home_id'] . "'><img src='../images/no_image.png'> <p>click to view</p></a>";
            if ($agent == true) {
                $agent_tagline = ucfirst($row_agent['agent_tagline']) . "%20Agents";
                echo '<h3 style = "opacity:0.5;">' . ucfirst($row_agent['agent_tagline']) . ' Agents </h3><br> <h3> $' . $row_agent['agent_fee'] . ' Agent Fee</h3>';
            } else {
                echo "<h3 style = 'opacity:0.5;'> Landlord's listing </h3><br> <p> No Agent Fee</p>";
                $agent_tagline = "Landlord%20No%20Agent%20Fee";
            }
        } else {
            echo "<a href='../listingdetails.php?clicked_id=" . $row['home_id'] . "' onclick='GetName(this.id)' id = '" . $row['home_id'] . "'><img src='../housepictures/$folder/" . $row['image1'] . "'><p>click to view</p></a>";
            if ($agent == true) {
                $agent_tagline = ucfirst($row_agent['agent_tagline']) . "%20Agents";
                echo '<h3 style = "opacity:0.5;">' . ucfirst($row_agent['agent_tagline']) . ' agents </h3> <br> $' . $row_agent['agent_fee'] . ' Agent Fee';
            } else {
                echo "<h3 style = 'opacity:0.5'> Landlord's listing </h3><br> <p> No Agent Fee</p>";
                $agent_tagline = "Landlord%20No%20Agent%20Fee";
            }
        }
        echo '</div>';

        echo "<div class='house-info'> <h3>"
            . $row['gender'] . " Boarding House </h3>
                <h3 style = 'color: rgb(252, 153, 82);'>Amenities</h3>";
        if ($row['kitchen'] == "1") {
            $kitchen_link = "%0Akitchen";
            $kitchenimg = '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="checkmark" viewBox="0 0 16 16">
                                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                                    </svg>';
        } else {
            $kitchen_link = "";
            $kitchenimg = '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="crossmark" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                    </svg>';
        }
        if ($row['fridge'] == "1") {
            $fridge_link = "%0Afridge";
            $fridgeimg = '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="checkmark" viewBox="0 0 16 16">
                                    <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                                    <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                                </svg>';
        } else {
            $fridge_link = "";
            $fridgeimg = '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="crossmark" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>';
        }
        if ($row['wifi'] == "1") {
            $wifi_link = "%0Awifi";
            $wifiimg = '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="checkmark" viewBox="0 0 16 16">
                        <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                        <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>';
        } else {
            $wifi_link = "";
            $wifiimg = '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="crossmark" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>';
        }
        if ($row['borehole'] == "1") {
            $borehole_link = "%0Aborehole";
            $boreholeimg = '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="checkmark" viewBox="0 0 16 16">
                    <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                    <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                </svg>';
        } else {
            $borehole_link = "";
            $boreholeimg = '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="crossmark" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                    </svg>';
        }
        if ($row['transport'] == "1") {
            $transport_link = "%0Atransport";
            $transport = '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="checkmark" viewBox="0 0 16 16">
                    <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                    <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                </svg>';
        } else {
            $transport_link = "";
            $transport = '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="crossmark" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>';
        }
        $replaced_string = str_replace("/", "%2F", $home_url);

        $house_link = "whatsapp://send?text=Check%20out%20this%20boarding%20house%20listed%20on%20casamax.co.zw%0A%0A" . $row['gender'] . "%20boarding%20house%20%0A%0A*with*" . $kitchen_link . $fridge_link . $wifi_link . $borehole_link . $transport_link . "%0A%0A*Price%20" . $row['price'] . "USD*%0A*Listed By:%20" . $agent_tagline . "*%0A%0A*use%20the%20link%20below%20to%C2%A0check%C2%A0it%C2%A0out.*%0A%0A" . $replaced_string;


        echo "<p>
                 Kitchen  $kitchenimg
            <br> 

                Fridge $fridgeimg
            <br>

                Wifi $wifiimg
            <br>  
            
                Borehole $boreholeimg
            <br>
            
                Transport $transport
            <br>
            
            </p>
            <br>
            ";
?>
        <br>
        <a href="<?php echo $house_link ?>" class="house_link" title="click to share">
            <img src="../images/share_icon.png" alt="click to share" title="click to share"> Share link
        </a>
<?php
        // checking if it si verified
        if ($row['verified'] == 1) {

            echo "
            <br />
            <p style='font-weight: 600;color: green; margin: 10px; cursor: pointer'> VERIFIED";

            echo '  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16" onclick="openInfo()">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                </svg>
            </p>';
            echo "
            <div class='info' id='info' style='cursor: pointer'>
                <p>
                    This account has been verified by CASAMAX 👍🏾
                </p>
                </button>
            </div>

                <h3>";
        }


        echo " <div class='house-price'>
        <p>" . $row['people_in_a_room'] . " In A Room</p>
                <h4>";
        echo "USD $" . $row['price'] . "<span>/ month</span>";
        echo " </h4>
                </div>";
        echo "</div>";
        echo '</div>';
    }
}
?>