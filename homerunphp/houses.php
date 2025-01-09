<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

require_once "./advertisesdb.php";
require '../required/common_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

function sendResponse($data, $status = 200)
{
    http_response_code($status);
    echo json_encode($data);
    exit();
}

$request = $_SERVER['REQUEST_URI'];
$queryParams = $_GET;

switch (true) {
    case preg_match('/\/api\/houses\/all_houses(\?.*)?$/', $request) && $_SERVER['REQUEST_METHOD'] === 'GET':
        fetchHouses($queryParams);
        break;
    case preg_match('/\/api\/houses(\?.*)?$/', $request) && $_SERVER['REQUEST_METHOD'] === 'GET':
        fetchHouse($queryParams); // Pass the home_id to fetchHouse function
        break;
    case preg_match('/\/api\/add_house(\?.*)?$/', $request) && $_SERVER['REQUEST_METHOD'] === 'POST':
        addHouse(); // Pass the home_id to fetchHouse function
        break;
    default:
        sendResponse(["message" => "Endpoint not found"], 404);
}

function fetchHouse($queryParams)
{
    global $conn;

    try {
        // Fetch the house with the specified home_id
        $sql = "SELECT id, firstname, lastname, contact, price, adrs, home_id, image1, uni FROM homerunhouses WHERE home_id = ? AND available = 1 AND contact != 0 ";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Failed to prepare SQL statement: " . $conn->error);
        }

        // Bind parameters and execute
        $stmt->bind_param('s', $queryParams['homeId']);
        if (!$stmt->execute()) {
            throw new Exception("Failed to execute query: " . $stmt->error);
        }

        // Fetch the result
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new Exception("House not found");
        }

        $house = $result->fetch_assoc();

        // Add a link generation for the house
        $fullUrl = "https://casamax.co.zw/listingdetails.php?clicked_id=" . urlencode($house['home_id']);
        $house['link'] = generateShortUrl($fullUrl);
        $lowercaseUni = strtolower($house['uni']);
        $uploadPath = getUniLocation($lowercaseUni);
        $cleanedString = str_replace(".", "", $uploadPath);
        $image_link = "https://casamax.co.zw" . $cleanedString . $house['image1'];

        sendResponse([
            "message" => "House found successfully",
            "data" => [
                'firstname' => $house['firstname'],
                'lastname' => $house['lastname'],
                'contact' => $house['contact'],
                'price' => $house['price'],
                'adrs' => $house['adrs'],
                'home_id' => $house['home_id'],
                'uni' => $house['uni'],
                'link' => $house['link'],
                'image_url' => $image_link,
            ]

        ], 200);
    } catch (Exception $e) {
        sendResponse(["error" => $e->getMessage(), "code" => $e->getCode()], 500);
    }
}

function fetchHouses($queryParams)
{
    global $conn;

    $intents = [
        1 => ["name" => "University of Zimbabwe", "nicknames" => ["UZ", "University of Zimbabwe"], "page" => "uzlisting.php"],
        2 => ["name" => "Midlands State University", "nicknames" => ["MSU", "Midlands State University"], "page" => "msulisting.php"],
        3 => ["name" => "Africa University", "nicknames" => ["AU", "Africa University"], "page" => "aulisting.php"],
        4 => ["name" => "Bindura University of Science and Education", "nicknames" => ["BUSE", "Bindura University of Science and Education", "Bindura University"], "page" => "bsulisting.php"],
        5 => ["name" => "Chinhoyi University of Science and Technology", "nicknames" => ["CUT", "Chinhoyi University of Science and Technology", "Chinhoyi University"], "page" => "cutlisting.php"],
        6 => ["name" => "Great Zimbabwe University", "nicknames" => ["GZU", "Great Zimbabwe University", "Great Zimbabwe"], "page" => "gzlisting.php"],
        7 => ["name" => "Harare Institute of Technology", "nicknames" => ["HIT", "Harare Institute of Technology", "Harare Institute"], "page" => "hitlisting.php"],
        8 => ["name" => "National University of Science and Technology", "nicknames" => ["NUST", "National University of Science and Technology"], "page" => "nustlisting.php"]
    ];

    try {
        $whereClauses = [];
        $params = [];
        $types = '';

        if (!empty($queryParams['min_price'])) {
            $minPrice = floatval($queryParams['min_price']);
            $whereClauses[] = "price >= ?";
            $params[] = $minPrice;
            $types .= 'd';
        }
        if (!empty($queryParams['uni'])) {
            $uni = strtolower(trim($queryParams['uni']));
            $matchedIntent = null;
            foreach ($intents as $intent) {
                if (strtolower($intent['name']) === $uni || in_array($uni, array_map('strtolower', $intent['nicknames']))) {
                    $matchedIntent = $intent;
                    break;
                }
            }

            if ($matchedIntent) {
                $name = $matchedIntent['name'];
                $whereClauses[] = "uni = ?";
                $params[] = $name;
                $types .= 's';
            } else {
                throw new Exception("University not recognized");
            }
        }

        if (!empty($queryParams['max_price'])) {
            $maxPrice = floatval($queryParams['max_price']);
            $whereClauses[] = "price <= ?";
            $params[] = $maxPrice;
            $types .= 'd';
        }

        if (!empty($queryParams['people_in_a_room'])) {
            $peopleInRoom = intval($queryParams['people_in_a_room']);
            $whereClauses[] = "people_in_a_room = ?";
            $params[] = $peopleInRoom;
            $types .= 'i';
        }

        if (!empty($queryParams['home_location'])) {
            $location = "%" . $queryParams['home_location'] . "%";
            $whereClauses[] = "(home_location LIKE ? OR adrs LIKE ?)";
            $params[] = $location;
            $params[] = $location;
            $types .= 'ss';
        }

        $sql = "SELECT id, firstname, lastname, contact, price, adrs, home_id FROM homerunhouses";
        $sql .= " WHERE available = 1";
        if (!empty($whereClauses)) {
            $sql .= " AND " . implode(" AND ", $whereClauses);
        }

        if (!empty($queryParams['sort_by']) && $queryParams['sort_by'] === 'price') {
            $sortOrder = (!empty($queryParams['sort_order']) && strtoupper($queryParams['sort_order']) === 'DESC') ? 'DESC' : 'ASC';
            $sql .= " ORDER BY price $sortOrder";
        }

        $page = !empty($queryParams['page']) ? max(1, intval($queryParams['page'])) : 1;
        $limit = !empty($queryParams['limit']) ? max(1, min(100, intval($queryParams['limit']))) : 10;
        $offset = ($page - 1) * $limit;
        $sql .= " LIMIT ?, ?";
        $params[] = $offset;
        $params[] = $limit;
        $types .= 'ii';

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Failed to prepare SQL statement: " . $conn->error);
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        if (!$stmt->execute()) {
            throw new Exception("Failed to execute query: " . $stmt->error);
        }

        $result = $stmt->get_result();
        if ($result === false) {
            throw new Exception("Failed to get result: " . $conn->error);
        }

        $houses = $result->fetch_all(MYSQLI_ASSOC);

        // Add a link generation for each house
        foreach ($houses as &$house) {
            $homeId = urlencode($house['home_id']); // Assuming 'id' is a unique identifier
            $fullUrl = "https://casamax.co.zw/listingdetails.php?clicked_id=" . $homeId;
            $house['link'] = generateShortUrl($fullUrl); // Use the shortened link
        }

        $totalSql = "SELECT COUNT(*) as total FROM homerunhouses";
        if (!empty($whereClauses)) {
            $totalSql .= " WHERE " . implode(" AND ", $whereClauses);
        }

        $totalStmt = $conn->prepare($totalSql);
        $totalParams = array_slice($params, 0, -2);
        $totalTypes = substr($types, 0, -2);
        if (!empty($totalParams)) {
            $totalStmt->bind_param($totalTypes, ...$totalParams);
        }

        $totalStmt->execute();
        $totalResult = $totalStmt->get_result()->fetch_assoc();
        $total = $totalResult['total'];

        sendResponse([
            "message" => empty($houses) ? "No houses found" : "Houses found successfully",
            "total" => $total,
            "current_page" => $page,
            "total_pages" => ceil($total / $limit),
            "data" => $houses
        ], 200);
    } catch (Exception $e) {
        sendResponse(["error" => $e->getMessage(), "code" => $e->getCode()], 500);
    }
}

function generateShortUrl($longUrl)
{
    $apiUrl = "https://tinyurl.com/api-create.php?url=" . urlencode($longUrl);

    $response = file_get_contents($apiUrl);
    if ($response === false) {
        return $longUrl; // Fallback to original URL if shortening fails
    }

    return $response; // TinyURL API returns the shortened URL directly
}
function addHouse()
{
    global $conn;

    // Start a transaction
    $conn->begin_transaction();
    $response = [];
    var_dump($_POST);

    try {
        $name = "image";
        $countfiles = 8;
        $count = 0;
        $images = [];

        for ($i = 0; $i < $countfiles; $i++) {
            $images[$i] = !empty($_FILES['image']['name'][$i]) ? $_FILES['image']['name'][$i] : "";
            if ($images[$i] !== "") {
                $count++;
            }
        }

        if (empty($_FILES['identityImage']['name']) || empty($_FILES['residencyImage']['name'])) {
            throw new Exception("Please upload the required documents.");
        }

        $identityImages = $_FILES['identityImage'];
        $residencyImages = $_FILES['residencyImage'];

        $firstname = sanitize_string($_POST['firstname']);
        $lastname = sanitize_string($_POST['lastname']);
        $phone = sanitize_integer($_POST['phone']);
        $email = sanitize_email($_POST['email']);
        $idnum = sanitize_string($_POST['idnum']);
        $price = sanitize_integer($_POST['price']);
        $address = sanitize_string($_POST['address']);
        $people = sanitize_integer($_POST['people']);
        $gender = sanitize_string($_POST['gender']);
        $description = sanitize_string($_POST['description']);
        $uni = sanitize_string($_POST['university']);
        $password = $_POST['password'];
        $confirmpass = $_POST['confirmpassword'];
        $kitchen = !empty($_POST['kitchen']) ? 1 : 0;
        $fridge = !empty($_POST['fridge']) ? 1 : 0;
        $wifi = !empty($_POST['wifi']) ? 1 : 0;
        $borehole = !empty($_POST['borehole']) ? 1 : 0;
        $transport = !empty($_POST['transport']) ? 1 : 0;

        if ($password !== $confirmpass) {
            throw new Exception("Passwords do not match.");
        }

        $sql = "SELECT email FROM homerunhouses WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            throw new Exception("SQL error.");
        }

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            throw new Exception("Email already exists.");
        }

        $hashedpass = password_hash($password, PASSWORD_DEFAULT);
        $home_id = preg_replace('/[^0-9]/', '', time() . bin2hex(random_bytes(1)) . rand(1, 100));

        $sql = "INSERT INTO homerunhouses (home_id, email, firstname, lastname, contact, idnum, price, rules, uni, image1, image2, image3, image4, image5, image6, image7, image8, gender, kitchen, fridge, wifi, borehole, transport, adrs, people_in_a_room, passw, id_image, res_image) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);

        $directoryPath = '../verification_images/home_verification_images/' . $home_id . '/';
        $identityFileDestination = $directoryPath . $identityImages['name'];
        $residencyFileDestination = $directoryPath . $residencyImages['name'];

        if (!file_exists($directoryPath)) {
            if (!mkdir($directoryPath, 0777, true)) {
                throw new Exception("Failed to create directory for verification.");
            }
        }

        if (
            !move_uploaded_file($residencyImages['tmp_name'], $residencyFileDestination) ||
            !move_uploaded_file($identityImages['tmp_name'], $identityFileDestination)
        ) {
            throw new Exception("Failed to move images.");
        }

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            throw new Exception("SQL prepare failed.");
        }

        if (!mysqli_stmt_bind_param(
            $stmt,
            "ssssisisssssssssssiiiiisisss",
            $home_id,
            $email,
            $firstname,
            $lastname,
            $phone,
            $idnum,
            $price,
            $description,
            $uni,
            $images[0],
            $images[1],
            $images[2],
            $images[3],
            $images[4],
            $images[5],
            $images[6],
            $images[7],
            $gender,
            $kitchen,
            $fridge,
            $wifi,
            $borehole,
            $transport,
            $address,
            $people,
            $hashedpass,
            $identityImages['name'],
            $residencyImages['name']
        )) {
            throw new Exception("SQL bind failed.");
        }
        if ($count <= 0) {
            throw new Exception("No images have been uploaded from the form.");
        }
        $lowercaseUni = strtolower($uni);
        $uploadPath = getUniLocation($lowercaseUni);
        if (!empty($uploadPath)) {
            for ($num = 0; $num < $count; $num++) {
                $imageUploadPath = $uploadPath . basename($_FILES["$name"]["name"][$num]);
                include './upload.php';
            }
            if (mysqli_stmt_execute($stmt)) {
                sendAdvertiseVerificationEmail($email, $firstname, "Casamax Upload Success");
                sendResponse(["message" => "House uploaded successfully"], 200);
            } else {
                throw new Exception("Execution failed: " . mysqli_stmt_error($stmt));
            }
        } else {
            throw new Exception("No images have been uploaded to the folder.");
        }

        // Commit the transaction
        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();  // Rollback the transaction
        sendResponse(["error" => "An error occurred: " . $e->getMessage()], 500);
    }
}
