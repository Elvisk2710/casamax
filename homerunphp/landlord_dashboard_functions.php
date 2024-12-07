<?php
// Function to get total and new agents (employees in the agents table)
function getLandlordShares($conn, $home_id)
{
    $sqlLandlordShares = "SELECT shares FROM homerunhouses WHERE home_id = '$home_id' LIMIT 1";
    $resultShares = $conn->query($sqlLandlordShares);

    if ($resultShares === false) {
        // Handle query error
        throw new Exception("Error fetching shares: " . $conn->error);
    }

    $row = $resultShares->fetch_assoc();
    return $row ? (int)$row['shares'] : null; // Return the integer or null if no rows found
}

function getWhatsAppConvo($conn, $home_id)
{
    $sqlLandlordChats = "SELECT chats_initiated FROM homerunhouses WHERE home_id = '$home_id' LIMIT 1";
    $resultChats = $conn->query($sqlLandlordChats);

    if ($resultChats === false) {
        // Handle query error
        throw new Exception("Error fetching chats: " . $conn->error);
    }

    $row = $resultChats->fetch_assoc();
    return $row ? (int)$row['chats_initiated'] : null; // Return the integer or null if no rows found
}

function getLandlordViews($conn, $home_id)
{
    $sqlLandlordViews = "SELECT views FROM homerunhouses WHERE home_id = '$home_id' LIMIT 1";
    $resultViews = $conn->query($sqlLandlordViews);

    if ($resultViews === false) {
        // Handle query error
        throw new Exception("Error fetching views: " . $conn->error);
    }

    $row = $resultViews->fetch_assoc();
    return $row ? (int)$row['views'] : null; // Return the integer or null if no rows found
}

$landlordShares  = getLandlordShares($conn, $home_id);
$landlordViews  = getLandlordViews($conn, $home_id);
$landlordChats  = getWhatsAppConvo($conn, $home_id);
