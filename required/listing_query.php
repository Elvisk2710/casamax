<?php
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $url = "https://";
else
    $url = "http://";
$url .= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
<div class="filter_div">
    <button class="filter_button" data-intro="Filter through your results." data-step="1" data-position="left" onclick="openFilter()">
        <img src="../images/filter.png" alt="open filter">
        <h3>Filters</h3>
    </button>
</div>

<script>
    function openFilter() {
        console.log("openFilter() called");
        const sidebarElement = document.querySelector(".side-bar-container");
        if (sidebarElement) {
            sidebarElement.style.display = "block";
        } else {
            console.error("Element with class 'sidebar' not found.");
        }
    }

    function triggerSharePHP(home_id) {
        // Send an AJAX request to your PHP script
        fetch(`https://localhost/casamax/homerunphp/database_increment_int.php?column=shares&home_id=${home_id}`)
            .then(response) // Get the response as text
            .catch(error => console.error('Error:', error));
    }
</script>

<?php
$num_per_page = 8;
$filters = ['kitchen', 'wifi', 'borehole', 'fridge', 'transport', 'gender'];
$filter_query = '';
$filter_url = '';
$kitchenIcon = '../images/kitchenIcon.png';
$wifiIcon = '../images/wifiIcon.png';
$boreholeIcon = '../images/boreholeIcon.png';
$transportIcon = '../images/transportIcon.png';
$fridgeIcon = '../images/fridgeIcon.png';
$verificationIcon = '../images/verifiedIcon.png';

if (isset($_GET['filter_set'])) {
    foreach ($filters as $filter) {
        if (isset($_GET[$filter])) {
            $value = $_GET[$filter];
            if ($filter === 'gender') {
                $filter_query .= " AND gender = '$value'";
                $filter_url .= "&gender = $value";
            } else {
                $filter_query .= " AND $filter = '1'";
                $filter_url .= "&$filter=1";
            }
        }
    }
    if (isset($_GET['price']) && $_GET['price'] != null) {
        $filter_query .= " AND price <= " . $_GET['price'];
        $filter_url .= ($_GET['price']);
    }
} elseif (isset($_GET['filter_reset'])) {
    $filter_query = '';
    $filter_url = '';
}

$page = $_GET['page'] ?? 1;
$start_from = ($page - 1) * $num_per_page;

$sql = "SELECT * FROM homerunhouses WHERE uni = '$university' AND available = '1' $filter_query ORDER BY id DESC LIMIT $start_from, $num_per_page";
$sql_num = "SELECT * FROM homerunhouses WHERE uni = '$university' AND available = '1' $filter_query";

$total_records = mysqli_num_rows(mysqli_query($conn, $sql_num));
$result = mysqli_query($conn, $sql);

echo "<h3 class='total-heading'>$total_records Options Found Near $university</h3>";
echo '<div class="house-list-container">';

while ($row = mysqli_fetch_array($result)) {
    $agent = false;
    if (!empty($row['agent_id'])) {
        $agent_id = $row['agent_id'];
        $agent_result = mysqli_query($conn, "SELECT * FROM agents WHERE agent_id = '$agent_id'");
        $agent = $agent_result && $row_agent = mysqli_fetch_array($agent_result);
    }

    $home_url = "https://casamax.co.zw/listingdetails.php?clicked_id=" . $row['home_id'];
    $agent_tagline = $agent ? ucfirst($row_agent['agent_tagline']) . " Agents" : "Landlord No Agent Fee";
    $agent_fee = $agent ? "$" . $row_agent['agent_fee'] . " Agent Fee" : "No Agent Fee";

    $whatsapp_link = "whatsapp://send?text=Check%20out%20this%20boarding%20house%20listed%20on%20casamax.co.zw%0A%0A" . $row['gender'] . "%20boarding%20house%20with%20" .
        ($row['kitchen'] ? "%0Akitchen" : "") .
        ($row['fridge'] ? "%0Afridge" : "") .
        ($row['wifi'] ? "%0Awifi" : "") .
        ($row['borehole'] ? "%0Aborehole" : "") .
        ($row['transport'] ? "%0Atransport" : "") .
        "%0A%0A*Price%20" . $row['price'] . "USD*%0A*Listed By:%20" . $agent_tagline . "*%0A%0A*use%20the%20link%20below%20to%C2%A0check%C2%A0it%C2%A0out.*%0A%0A" . urlencode($home_url);
?>
    <div class="house" data-intro="View each home and its amenities." data-step="2" data-position="top" id="div<?= $row['home_id'] ?>">
        <a href="../listingdetails.php?clicked_id=<?= $row['home_id'] ?>" onclick="GetName(this.id)" id="<?= $row['home_id'] ?>">
            <div class="house-img">
                <img src="<?= empty($row['image1']) ? '../images/no_image.png' : "../housepictures/$folder/" . $row['image1'] ?>" alt="house image">
                <!-- <div class="agent-details">
                    <p style="opacity:0.5;"><?= $agent ? ucfirst($row_agent['agent_tagline']) . ' Agents' : "Landlord" ?></p><br>
                    <p><?= $agent_fee ?></p>
                </div> -->
            </div>
            <div class="house-info">
                <p class="house-info-gender"><?= $row['gender'] ?> </p>
                <div class="amenities_div_container">
                    <?php if ($row['kitchen'] == "1"): ?>
                        <div class="amenities_div"><img src="<?= $kitchenIcon ?>" alt="kitchen" title="kitchen"></div>
                    <?php endif; ?>
                    <?php if ($row['fridge'] == "1"): ?>
                        <div class="amenities_div"><img src="<?= $fridgeIcon ?>" alt="fridge" title="fridge"></div>
                    <?php endif; ?>
                    <?php if ($row['wifi'] == "1"): ?>
                        <div class="amenities_div"><img src="<?= $wifiIcon ?>" alt="wifi" title="wifi"></div>
                    <?php endif; ?>
                    <?php if ($row['borehole'] == "1"): ?>
                        <div class="amenities_div"><img src="<?= $boreholeIcon ?>" alt="borehole" title="borehole"></div>
                    <?php endif; ?>
                    <?php if ($row['transport'] == "1"): ?>
                        <div class="amenities_div"><img src="<?= $transportIcon ?>" alt="transport" title="transport"></div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($row['verified'] == 1) { ?>
                <div class="verification-check">
                    <img src="<?= $verificationIcon ?>" alt="verification" title="verification">
                </div>
            <?php } ?>
            <div class="house-price">
                <div class="left-house-price">
                    <a href="<?= $whatsapp_link ?>" class="house_link" title="Click to share" onclick="triggerSharePHP('<?= $row['home_id'] ?>')">
                        <img src="../images/share_icon.png" alt="Share link">
                    </a>
                </div>
                <div class="right-house-price">
                    <p><?= $row['people_in_a_room'] ?> In A Room</p>
                    <h4>USD $<?= $row['price'] ?><span>/ month</span></h4>
                </div>
            </div>
        </a>
    </div>
<?php
}
?>
</div>