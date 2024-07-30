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
    <button class="filter_button" data-intro="Filter through your results." data-step="1" data-position="left" onclick="openFilter()">
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
$kitchen_url = '';
$wifi_query = '';
$wifi_url = '';
$borehole_query = '';
$borehole_url = '';
$fridge_query = '';
$fridge_url = '';
$transport_query = '';
$transport_url = '';
$gender_query = '';
$gender_url = '';
$price_query = '';
$price_url = '';
$filter_query = '';
$checkmark = '../images/checkmark.png';
$crossmark = '../images/crossmark.png';

// reset filter

if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}
$start_from = ($page - 1) * 8;

// query for search
if (isset($_GET['filter'])) {
    if (isset($_GET['kitchen'])) {
        $kitchen_query = " and kitchen = '1'";
        $kitchen_url = "&kitchen=1";
    }
    if (isset($_GET['wifi'])) {
        $wifi_query = " and wifi = '1'";
        $wifi_url = "&wifi=1";
    }
    if (isset($_GET['borehole'])) {
        $borehole_query = " and borehole = '1'";
        $borehole_url = "&borehole=1";
    }
    if (isset($_GET['fridge'])) {
        $fridge_query = " and fridge = '1'";
        $fridge_url = "&fridge=1";
    }
    if (isset($_GET['transport'])) {
        $transport_query = " and transport = '1'";
        $transport_url = "&transport=1";
    }
    if (isset($_GET['price']) && $_GET['price'] != '') {
        unset($_POST);
        $pricesearch = $_GET['price'];
        $price_query = " and price <= '$pricesearch'";
        $price_url = "&price=$pricesearch";
    }
    if (isset($_GET['gender'])) {
        $gender = $_GET['gender'];
        $gender_url = "&gender=" . $gender;
        if ($gender == 'girls') {
            $gender_query = " and gender = 'girls'";
        } elseif ($gender == 'boys') {
            $gender_query = " and gender = 'boys'";
        } elseif ($gender == 'mixed') {
            $gender_query = "and gender = 'mixed'";
        }
    }

    $filter_query = $kitchen_query . ' ' . $wifi_query . ' ' . $borehole_query . ' ' . $fridge_query . ' ' . $transport_query . ' ' . $gender_query  . ' ' . $price_query;
    $filter_url = $kitchen_url . $wifi_url . $borehole_url . $fridge_url . $transport_url . $gender_url . $price_url . '&filter=';
} else {
    $filter_query = '';
    $filter_url = '';
}

$sql = "SELECT * FROM homerunhouses WHERE uni = '$university' AND available = '1' $filter_query ORDER BY id DESC LIMIT $start_from, $num_per_page";
$sql_num = "SELECT * FROM  homerunhouses WHERE uni = '$university' and available = '1' $filter_query";
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

        echo "<div class='house' data-intro='View each home and its amenities.' data-step='2' data-position='top' id=div" . $row['home_id'] . ">";
        echo "<div class='house-img'>";
        if (empty($row['image1'])) {
            echo "<a href='../listingdetails.php?clicked_id=" . $row['home_id'] . "' onclick='GetName(this.id)' id = '" . $row['home_id'] . "'><img data-intro='Click to view more photos and see more info.' data-step='3' src='../images/no_image.png'> <p>click to view</p></a>";
            if ($agent == true) {
                $agent_tagline = ucfirst($row_agent['agent_tagline']) . "%20Agents";
                echo '<h3 style = "opacity:0.5;">' . ucfirst($row_agent['agent_tagline']) . ' Agents </h3><br> <h3> $' . $row_agent['agent_fee'] . ' Agent Fee</h3>';
            } else {
                echo "<h3 style = 'opacity:0.5;'> Landlord's listing </h3><br> <p> No Agent Fee</p>";
                $agent_tagline = "Landlord%20No%20Agent%20Fee";
            }
        } else {
            echo "<a href='../listingdetails.php?clicked_id=" . $row['home_id'] . "' onclick='GetName(this.id)' id = '" . $row['home_id'] . "'><img data-intro='Click to view more photos and see more info.' data-step='3' src='../housepictures/$folder/" . $row['image1'] . "'><p>click to view</p></a>";
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
            $kitchenimg = $checkmark;
        } else {
            $kitchen_link = "";
            $kitchenimg = $crossmark;
        }
        if ($row['fridge'] == "1") {
            $fridge_link = "%0Afridge";
            $fridgeimg = $checkmark;
        } else {
            $fridge_link = "";
            $fridgeimg = $crossmark;
        }
        if ($row['wifi'] == "1") {
            $wifi_link = "%0Awifi";
            $wifiimg = $checkmark;
        } else {
            $wifi_link = "";
            $wifiimg = $crossmark;
        }
        if ($row['borehole'] == "1") {
            $borehole_link = "%0Aborehole";
            $boreholeimg = $checkmark;
        } else {
            $borehole_link = "";
            $boreholeimg = $crossmark;
        }
        if ($row['transport'] == "1") {
            $transport_link = "%0Atransport";
            $transportimg = $checkmark;
        } else {
            $transport_link = "";
            $transportimg = $crossmark;
        }
        $replaced_string = str_replace("/", "%2F", $home_url);

        $house_link = "whatsapp://send?text=Check%20out%20this%20boarding%20house%20listed%20on%20casamax.co.zw%0A%0A" . $row['gender'] . "%20boarding%20house%20%0A%0A*with*" . $kitchen_link . $fridge_link . $wifi_link . $borehole_link . $transport_link . "%0A%0A*Price%20" . $row['price'] . "USD*%0A*Listed By:%20" . $agent_tagline . "*%0A%0A*use%20the%20link%20below%20to%C2%A0check%C2%A0it%C2%A0out.*%0A%0A" . $replaced_string;

?>
        <div class="element_container">
            <div class="amenities_div_container">
                <div class="amenities_div">
                    <p>
                        Kitchen
                    </p>
                    <img src="<?php echo $kitchenimg ?>" alt="">
                </div>
                <div class="amenities_div">
                    <p>
                        Fridge
                    </p>
                    <img src="<?php echo $fridgeimg ?>" alt="">
                </div>
                <div class="amenities_div">
                    <p>
                        Wifi
                    </p>
                    <img src="<?php echo $wifiimg ?>" alt="">
                </div>
                <div class="amenities_div">
                    <p>
                        Borehole
                    </p>
                    <img src="<?php echo $boreholeimg ?>" alt="">
                </div>
                <div class="amenities_div">
                    <p>
                        Transport
                    </p>
                    <img src="<?php echo $transportimg ?>" alt="">
                </div>
            </div>
            <?php if (empty($row['agent_id'])) { ?>
                <div class="chat_btn_container">
                    <a href="../chat/screens/chat_dm.php?chat_id=<?php echo $row['home_id'] ?>&student=1">
                        <button data-intro='Chat to landlord.' data-step='5' data-position="top" class="chat_btn" style="background-color: rgb(255,255,255); color:rgb(8,8,12);">Go To Chat</button>
                    </a>
                </div>
            <?php } ?>
        </div>
        <a href="<?php echo $house_link ?>" class="house_link" title="click to share">
            <img data-intro='Like the listing? Share it with your friends.' data-step='4' src="../images/share_icon.png" alt="click to share" title="click to share"> Share link
        </a>
<?php
        // checking if it si verified
        if ($row['verified'] == 1) {

            echo "
            <br />
            <p style='font-weight: 600;color: green; margin: 10px; cursor: pointer'> VERIFIED
            </p>";
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